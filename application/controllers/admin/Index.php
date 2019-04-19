<?php

if (!defined('BASEPATH')) {
    exit("Access Denied");
}

class Index extends App {

    function __construct() {
        parent::__construct();
        $this->check_admin_login();
        
        $this->pagedata['topmenu'] = 'index';
        $this->pagedata['submenu'] = 'index';
    }
    public function top() {
        $this->pagedata['admin_name'] = K::M('admin/auth')->admin_name;
        $this->pagedata['admininfo'] = K::M('admin/auth')->admin;
        $this->tmpl = 'index/top.html';
    }
    public function left() {
        $this->pagedata['admininfo'] = K::M('admin/auth')->admin;
        
        $this->tmpl = 'index/left.html';
    }
    public function bottom() {
        $this->pagedata['admininfo'] = K::M('admin/auth')->admin;
        
        $this->tmpl = 'index/bottom.html';
    }
    public function yqtell() {
        
        $this->tmpl = 'index/yqtell.html';
    }
    
    public function right() {
        $this->pagedata['admininfo'] = K::M('admin/auth')->admin;
        $this->tmpl = 'index/right.html';
    }
    
    public function index() {
        
        $this->tmpl = 'index/index.html';
    }
 
    public function login() {
        if ($this->checkpost()) {
            $this->pagedata['outType'] = 'json';
            if (!$name = $this->input->post('name')) {
                $this->pagedata['data'] = array(
                    'Success' => false,
                    'Msg' => '账号不能为空!',
                );
            } else if (!$passwd = $this->input->post('pwd')) {
                $this->pagedata['data'] = array(
                    'Success' => false,
                    'Msg' => '密码不能为空!',
                );
            } else {
                $name = K::M('share')->replace_null($name);
                $r = K::M('admin/auth')->login($name, $passwd);
                if ($r === true) {
                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '登录成功!',
                    );
                    return;
                }
                $this->pagedata['data'] = array(
                    'Success' => false,
                    'Msg' => $r,
                );
            }
            return;
        }
        $this->tmpl = 'login/login.html';
    }

    public function logout() {
        $pagedata = K::M('admin/auth')->admin_name;
        $logoutName = $pagedata === "test888" ? "?".$pagedata : "";
        K::M('admin/auth')->logout();
        $this->redirect('admin.php'.$logoutName);
        exit;
    }
 

    public function page() {
        $page = $this->input->get('page');
        $this->tmpl = "page/{$page}.html";
    }

    //酒店管理菜单
    function hotel() {
        $mid = intval($this->input->get('mid'));
        $menu_tree = K::M('admin/auth')->tree();
        if (!$mid) {
            $tree = array_shift($menu_tree);
        } else {
            $tree = $menu_tree[$mid];
        }
        $this->pagedata['menu_tree'] = $tree['menu']['59'];
        $this->tmpl = 'index/hotel.html';
    }

}
