<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CookCookFood extends MY_Model {
    
    protected static $_dining_times = array(1=> '早餐',2=> '上午点心' ,3=> '中餐', 4=> '下午点心', 5=>'晚餐',6=> '夜宵' );

    protected $_table = 'cookFood';  
    protected $_pk = 'Food_id';
    protected $fields = array();
    
    function dining_times(){
        return self::$_dining_times;
    }
            
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
