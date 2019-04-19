<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminAuth extends MY_Model {
    
    public $pwd_key = 'wWvV';
    public $admin_id = 0;
    public $admin_name = '';
    public $admin = array();
    public $role = null;
    public $_menu_tree = null;

    public function __construct() {
        parent::__construct();
    }
    
    function getPwdMd5($pwd){
        return md5($pwd . $this->pwd_key);
    }

    public function token() {
        $token = $this->session->get('ATOKEN');
        
        if ($token) {
            if ($this->_check_token($token)) {
                return true;
            }
            $this->session->delete('ATOKEN');
        }
        return false;
    }

    /**
     * 用户登录
     * @param   $u  用户名/邮箱
     * @param   $p  密码{明文密码}
     */
    public function login($name, $pwd) {
        $passwd = $this->getPwdMd5($pwd);
        $m = K::M('admin/admin')->admin(0, $name);

        if (!$m || $m['passwd'] != $passwd) {
            return '用户名或密码不正确!';
        }
        if ($m['status'] != 1 ) {
            return '用户状态异常,请联系管理员!';
        }

        $this->admin_id = $m['admin_id'];
        $this->admin_name = $m['admin_name'];
        $this->admin = $m;
        $token = $this->create_token($this->admin_id, $passwd);
        K::M('admin/admin')->update_login($this->admin_id);
        $this->session->set('ATOKEN', $token);
        //$this->cookie->set('ADMIN', $this->admin_name, NULL);

        return true;
    }

    public function logout() {
        $this->session->delete('ATOKEN');
        $this->cookie->delete('ATOKEN');
        //$this->cookie->delete('ADMIN');
        return true;
    }
 
    private function _check_token($token) {
        
        $a = explode('-', $token);
        if (!$uid = intval($a[0])) {
            return false;
        }
        if (!$m = K::M('admin/admin')->admin($uid)) {
            return false;
        } else if ($this->create_token($m['admin_id'], $m['passwd']) != $token) {
            return false;
        } else if (!in_array($m['status'], array(0, 1))) {
            return false;
        }
        $this->admin_id = $m['admin_id'];
        $this->admin_name = $m['admin_name'];
        $this->admin = $m;
         
        return true;
    }
 
}
