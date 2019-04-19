<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends Model {

    /**
     */
    protected $_table = '';
    protected $_pk = '';
    protected $no_check = array();
    public static $_CACHE_TABLES = array();

    function __construct() {
        parent::__construct();
        $this->load->database();
        if (defined('ECHO_SQL')) {
            $this->db->db_debug = true;
        }

        $this->table_name = $this->table(); //兼容原来的ci

        $this->cache = K::L('MyCache/Cache');
        $this->cookie = K::L('System/Cookie');
        $this->session = K::L('System/Session');
    }

    function table($table = false) {
        if ($table) {
            return DBPREFIX . $table;
        }
        return DBPREFIX . $this->_table;
    }
    
    
    function getnames($where = null){
        if(empty($where)){
            $where = '1';
        }
        $option = array(
            'where' => $where,
        );
        $res = $this->getlist($option);
        $names = array();
        foreach($res as $v){
            $names[$v[$this->_pk]] = $v['name'];
        }
        return $names;
    }


    //获取编号
    function getlastcode($k) {
        $one = $this->getone("1 ORDER BY {$this->_pk} DESC ");
        if (empty($one)) {
            $num = 0;
        } else {
            $num = $one['num'];
        }
        return K::M('system/config')->getcode($k, $num);
    }
    
    function getidsbyname($word, $field = 'name', $where=''){
        
        if(empty($word)){
            $where = empty($where) ? 1 : $where;
        } else {
            $where = empty($where) ? 1 : $where;
            $where =  " {$where} AND  `{$field}` like '%{$word}%'";
        }
        $option = array(
            "where" => $where,
        );
        $items = $this->getlist($option);
        
        $ids = array();
        if(!empty($items)){
            foreach($items as $item){
                $ids[] = $item[$this->_pk];
            }
        }
        return $ids;
    }

    function _check_field($data) {
        $fields = $this->get_columns($this->table());
        $result = array();
        
        foreach ($data as $k => $v) {
            if (in_array($k, $this->no_check)) {
                $result[$k] = $v;
                continue;
            }
            foreach ($fields as $t => $res) {
                if (in_array($k, $res)) {
                    switch ($t) {
                        case 'int':
                            $result[$k] = intval($v);
                            break;
                        case 'float':
                            $result[$k] = round(floatval($v), 2);
                            break;
                        case 'string':
                            $result[$k] = K::M('share')->replace_null($v);
                            break;
                    }
                }
            }
        }
        return $result;
    }

    function get_columns($table) {
        $sql = 'show columns from ' . $table;
        $result = $this->doSql($sql);

        $fields = array(); //key: type
        if (!empty($result)) {
            foreach ($result as $item) {
                if (strpos($item['Type'], 'int') !== false) {
                    $fields['int'][] = $item['Field'];
                } else if (strpos($item['Type'], 'float') !== false) {
                    $fields['float'][] = $item['Field'];
                } else if (strpos($item['Type'], 'char') !== false) {
                    $fields['string'][] = $item['Field'];
                } else if (strpos($item['Type'], 'text') !== false) {
                    $fields['string'][] = $item['Field'];
                }
            }
        }
        return $fields;
    }

    protected function _format_row($row) {
        return $row;
    }

    public static function field($field, $val, $glue = '=') {
        $field = self::_quote_field($field);
        $glue = strtoupper($glue);
        if (is_array($val)) {
            $glue = $glue == 'NOTIN' ? 'NOTIN' : 'IN';
        } elseif ($glue == 'IN') {
            $glue = '=';
        }
        switch ($glue) {
            case '=': return $field . $glue . self::_quote($val);
                break;
            case '-': case '+': return $field . '=' . $field . $glue . self::_quote($val);
                break;
            case '|': case '&': case '^': return $field . '=' . $field . $glue . self::_quote($val);
                break;
            case '>': case '<': case '<>': case '<=': case '>=': return $field . $glue . self::_quote($val);
                break;
            case 'LIKE': return $field . ' LIKE(' . self::_quote($val) . ')';
                break;
            case 'IN': case 'NOTIN': $val = $val ? implode(',', $val) : '\'\'';
                return $field . ($glue == 'NOTIN' ? ' NOT' : '') . ' IN(' . $val . ')';
                break;
            default: trigger_error('Not allow this glue between field and value: "' . $glue . '"');
        }
    }

    public static function _quote_field($field) {
        if (is_array($field)) {
            foreach ($field as $k => $v) {
                $field[$k] = self::_quote($v);
            }
        } else {
            if (strpos($field, '`') !== false)
                $field = str_replace('`', '', $field);
            $field = '`' . $field . '`';
        } return $field;
    }

    public static function _quote($val) {
        if (is_string($val))
            return '\'' . addcslashes($val, "\n\r\\'\"\032") . '\'';
        if (is_int($val) or is_float($val))
            return '\'' . $val . '\'';
        if (is_array($val)) {
            if ($noarray === false) {
                foreach ($val as &$v) {
                    $v = self::_quote($v, true);
                } return $val;
            } else {
                return '\'\'';
            }
        } if (is_bool($val))
            return $val ? '1' : '0';
        return '\'\'';
    }

    public function items($filter = array(), $orderby = null, $p = 1, $l = 50, &$count = 0) {

        $where = $this->where($filter);
        //pr($where);exit;
        $orderby = $this->order($orderby);
        $limit = $this->limit($p, $l);
        $items = array();
        if (!empty($where)) {
            $sql = "SELECT * FROM " . $this->table() . " WHERE $where $orderby $limit";
            if ($rs = $this->dosql($sql)) {
                foreach ($rs as $row) {
                    $row = $this->_format_row($row);

                    $items[] = $row;
                }
                $count = $this->getnum($where);
            }
        }
        return $items;
    }

    public function where($filter = null, $pre = '') {
        $where = array();
        if ($filter === null) {
            return 1;
        } else if (!is_array($filter)) {
            return $filter;
        } else {
            foreach ((array) $filter as $k => $v) {
                $where[] = self::_filter_where($k, $v, $pre);
            }
        } return $where ? implode(' AND ', $where) : 1;
    }

    public function order($field = null, $order = 'ASC', $pre = '') {
        $orders = array();
        if (!empty($field)) {

            foreach ($field as $k => $v) {
                $orders[] = "{$k} {$v} ";
            }
        }

        return $orders ? (' ORDER BY ' . implode(',', $orders)) : '';
    }

    protected static function _filter_where($k, $v, $pre = '') {
        //pr($v);
        if ($v === null) {
            return 1;
        } else if (is_array($v)) {
            if (isset($v['AND'])) {
                $s = array();
                foreach ($v['AND'] as $a => $b) {
                    $s[] = self::_filter_where($a, $b, $pre);
                }

                return '(' . implode(' AND ', $s) . ')';
            } else if (isset($v['OR'])) {
                $s = array();
                foreach ($v['OR'] as $a => $b) {
                    $s[] = self::_filter_where($a, $b, $pre);
                }

                return '(' . implode(' OR ', $s) . ')';
            } else {
                $vs = "'" . implode("','", $v) . "'";
                return "{$pre}`{$k}` IN($vs)";
            }
        } else if (preg_match('/^(\d+)~(\d+)$/', $v, $m)) {
            return "({$pre}`{$k}` BETWEEN $m[1] AND $m[2])";
        } else if (preg_match('/^(LIKE|~LIKE|NOTLIKE):(.*)$/i', $v, $m)) {
            if (strtoupper($m[1]) == 'LIKE') {
                return $pre . self::field("`{$k}`", $m[2], 'LIKE');
            } else {
                return "{$pre}`{$k}` NOT LIKE $m[2]";
            }
        } else if (preg_match('/^(IN|~IN|NOTIN):(.*)$/i', $v, $m)) {
            if (strtoupper($m[1]) == 'IN') {
                return $pre . self::field($k, $m[2], 'IN');
            } else {
                return $pre . self::field("`{$k}`", $m[2], 'NOTIN');
            }
        } else if (preg_match('/^([\=\>\<\|\^\&\+\-]{1,2}):(.+)/i', $v, $m)) {
            return $pre . self::field("`{$k}`", $m[2], $m[1]);
        } else {
            return "{$pre}`$k`='$v'";
        }
    }

    public function limit($page, $limit = 0) {
        $limit = intval($limit > 0 ? $limit : 0);
        $start = (max(intval($page), 1) - 1) * $limit;
        if ($start > 0 && $limit > 0) {
            return " LIMIT $start, $limit";
        } elseif ($limit) {
            return " LIMIT $limit";
        } elseif ($start) {
            return " LIMIT $start";
        } else {
            return '';
        }
    }

    //生成TOKEN
    public function create_token($uid, $pwd) {
        $s = strtoupper(md5($_SERVER['HTTP_USER_AGENT'] . $uid . md5(SECRET_KEY . $pwd . __IP, true)));
        $token = "{$uid}-KT{$s}";
        return $token;
    }

    function echosql($sql) {
        if (defined('ECHO_SQL')) {
            echo $sql, '<br>', "\r\n";
        }
    }

}
