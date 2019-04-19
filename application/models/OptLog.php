<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class OptLog extends MY_Model {

    protected $_table = 'optlog';

    public function addlog($tableid, $table, $opttype, $content) {
        
        if(is_array($content)){
            $content = json_encode($content, JSON_UNESCAPED_UNICODE);
        }

        $data = array(
            'tableid' => $tableid,
            'tablename' => $table,
            'optid' => K::M('admin/auth')->admin_id,
            'opttype' => $opttype, //1增加 2删除 3改
            'after' => $content,
            'ip' => __IP,
            'dateline' => __TIME,
        );

        return $this->add($data);
    }

}
