<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CultureCultureart extends MY_Model {

    protected $_table = 'cultureart';  
    protected $_pk = 'art_id';
            
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
