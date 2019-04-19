<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class gulaogulao extends MY_Model {

    protected $_table = 'gulao';  
    protected $_pk = 'gulao_id';
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
