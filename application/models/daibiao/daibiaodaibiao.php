<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class daibiaodaibiao extends MY_Model {

    protected $_table = 'daibiao';  
    protected $_pk = 'daibiao_id';
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
            
    
}
