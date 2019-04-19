<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MemberMember extends MY_Model {

    protected $_table = 'member';  
    protected $_pk = 'member_id';
    protected $fields = array();
    protected $no_check = array('otherdata');
            
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
            
    
}
