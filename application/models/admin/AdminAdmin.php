<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminAdmin extends MY_Model {

    protected $_table = 'admin';  
    
    function admin($id, $name = ''){
        if($id > 0){
            return $this->getone("admin_id={$id}");
        }
        if($name != ''){
            return $this->getone("admin_name='{$name}'");
        }
        return array();
    }

    //更新最后登录时间 ip
    function update_login($id){
        $data = array(
            'last_login' => __TIME,
            'loginip' => __IP,
        );
        $this->update($data, "admin_id={$id}");
    }
}
