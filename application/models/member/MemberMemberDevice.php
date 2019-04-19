<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MemberMemberDevice extends MY_Model {

    protected $_table = 'memberdevice';  
    protected $_pk = 'device_id';
    protected $fields = array();
            
    function update($data, $where){
        unset($data[$this->_pk]);
        $data = $this->_check_field($data);
        if(empty($data)){
            return FALSE;
        }        
        return parent::update($data, $where);
    }
    
    function add($data){
        unset($data[$this->_pk]);
        $data = $this->_check_field($data);
        if(empty($data)){
            return FALSE;
        }
        $data['dateline'] = __TIME;
        return parent::add($data);
    }
    
    function getmemberids($imei, $where = ''){
        $option = array(
            'where' => "imei like '%{$imei}%' {$where}",
        );
        $res = $this->getlist($option);
        $member_ids = array();
        foreach($res as $v){
            $member_ids[] = $v['member_id'];
        }
        return $member_ids;
    }
            
    
}
