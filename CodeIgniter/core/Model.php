<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//define('ECHO_SQL',1);
//require_once(BASEPATH . 'core' . DIRECTORY_SEPARATOR . 'Model.php');

class Model extends CI_Model {

    /**
     */
    protected $table_name = 'school';
    protected $db_need = true;

    function __construct() {
        parent::__construct();
        if ($this->db_need) {
            $this->load->database();
            if (defined('ECHO_SQL')) {
                $this->db->db_debug = true;
            }
        }
    }

    function insert($data) {
        return $this->add($data);
    }

    //$data 数组
    function add($data) {
        if (is_array($data)) {
            $this->db->insert($this->table_name, $data);
            return $this->db->insert_id();
        } else {
            return -1;
        }
    }

    //删除: $where 字符串
    function del($where) {
        if (empty($where)) {
            return -1;
        }
        $table = $this->table_name; //这里可以加前缀
        $where = "where {$where}";
        $sql = "delete from {$table} {$where} ";
        $this->echosql($sql);
        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    //改: $data 数组, $where 字符串
    function update($data, $where) {
        if (empty($data) || empty($where)) {
            return -1;
        }

        $valstr = array();
        foreach ($data as $f => $v) {
            if (strpos($v, '+') !== false && strpos($v, "`{$f}`") !== false) {
                $valstr[] = "`{$f}`=" . "{$v}";
            } else {
                $valstr[] = "`{$f}`=" . "'{$v}'";
            }
        }

        $table = $this->table_name;

        $sql = 'UPDATE `' . $table . '` SET ' . implode(', ', $valstr) . " WHERE {$where}";
        $this->echosql($sql);
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    /**
     * field 字符串
     * where 字符串
     * order 字符串 id desc
     * limit 字符串 5,20
     */
    function getlist($option = null, &$return_total = false) {
        $field = isset($option['field']) ? $option['field'] : '*';

        $where = isset($option['where']) ? $option['where'] : '1';

        $order = '';
        if (!empty($option['order'])) {
            $order = "ORDER BY {$option['order']} ";
        }

        $limit = isset($option['limit']) ? $option['limit'] : '';
        $limit = checklimit($limit);

        $table = $this->table_name;
        $sql = "SELECT {$field} FROM {$table} WHERE {$where} {$order} {$limit}";
        $this->echosql($sql);
        $result = $this->db->query($sql);

        $tmp = $result->result('array');

        if ($return_total) { //查总数
            $return_total = $this->getnum($where);
        }
        return $tmp;
    }

    //$where 字符串
    function getone($where = '', $field = '*') {
        $where = !empty($where) ? $where : '1';
        $table = $this->table_name;
        $sql = "SELECT {$field} FROM {$table} WHERE {$where} LIMIT 1";
        $this->echosql($sql);
        $result = $this->db->query($sql);
        $tmp = $result->result('array');
        if (!empty($tmp)) {
            return $tmp[0];
        }
        return array();
    }

    //直接执行sql语句
    public function dosql($sql) {
        $this->echosql($sql);
        $result = $this->db->query($sql);
        if (is_object($result)) {
            return $result->result('array');
        }
        return $result;
    }

    //$where 字符串
    function getnum($where = null) {

        $where = !empty($where) ? $where : '1';
        $table = $this->table_name;
        $sql = "SELECT COUNT(1) as cou FROM {$table} WHERE {$where} ";
        $this->echosql($sql);
        $result = $this->db->query($sql);
        $tmp = $result->result('array');
        if (!empty($tmp)) {
            return $tmp[0]['cou'];
        }
        return 0;
    }

    function echosql($sql) {
        if (defined('ECHO_SQL')) {
            echo $sql, '<br>', "\r\n";
        }
    }

}

function checklimit($limit) {
    if (!empty($limit)) {//这里要处理一下负数问题
        $arr = explode(',', $limit);
        if (count($arr) == 1) {//只有一个
            $a = 0;
            $b = intval(trim($arr[0]));
            if ($b < 0) {
                $b = 1;
            }
            $limit = " limit {$a},{$b} ";
        } else if (count($arr) == 2) {
            $a = intval(trim($arr[0]));
            $b = intval(trim($arr[1]));
            if ($a < 0) {
                $a = 0;
            }
            if ($b < 0) {
                $b = 1;
            }
            $limit = " limit {$a},{$b} ";
        } else {
            $limit = '';
        }
    }
    return $limit;
}
