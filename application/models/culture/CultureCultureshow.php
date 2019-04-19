<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CultureCultureshow extends MY_Model {

    protected $_table = 'cultureshow';  
    protected $_pk = 'show_id';
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
