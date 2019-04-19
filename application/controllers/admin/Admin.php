<?php

class Admin extends App {

    public function __construct() {
        parent::__construct();
        $this->check_admin_login();
    }

    //后台管理员列表
    public function index() {
        $page = intval($this->input->get('page'));
        $page = $page <= 0 ? 1 : $page;


        $limit = PAGE_LIMIT;

        $filter = array();
        $SO = array();
        if ($word = K::M('share')->replace_null(trim($this->GP('word')))) {
            $select = $this->GP('select');
            switch ($select) {
                case 'login_name':
                    $filter['admin_name'] = "LIKE:%" . $word . "%";
                    break;
                case 'name':
                    $filter['realname'] = "LIKE:%" . $word . "%";
                    break;
                case 'mobi':
                    $filter['mobile'] = "LIKE:%" . $word . "%";
                    break;
                default :
                    $filter['1']['OR']['admin_name'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['realname'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['mobile'] = "LIKE:%" . $word . "%";
            }
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'admin_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('admin/admin')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $pagedata = K::M('admin/auth')->admin_name;
        if($pagedata === "test888"){
            $this->redirect('admin.php?c=admin&a=edit');
        }else{
            $this->tmpl = 'admin/list.html';
        }
    }

    function save() {
        $this->pagedata['outType'] = 'json';
        if ($this->checksubmit()) {
            $data = array();

            $admin_id = intval($this->GP('id'));
            $data['admin_name'] = $realname = K::M('share')->replace_null($this->GP('admin_name'));
            $data['passwd'] = $pwd1 = $this->GP('pwd1');
            $pwd2 = $this->GP('pwd2');
            $data['realname'] = $realname = K::M('share')->replace_null($this->GP('realname'));
            $data['gender'] = $gender = intval($this->GP('gender'));
            $data['mobile'] = $mobile = K::M('share')->replace_null($this->GP('mobile'));
            $data['telephone'] = $telephone = K::M('share')->replace_null($this->GP('telephone'));
            $data['status'] = $status = intval($this->GP('status'));

            if (empty($realname)) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写真实姓名!',);
                return;
            }
            if (empty($gender)) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写选择性别!',);
                return;
            }
            if (empty($mobile)) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写手机号码!',);
                return;
            }

            if ($admin_id == 0 && $pwd1 == '') {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请输入密码!',);
                return;
            }

            if ($pwd1 != '') {
                if (strlen($pwd1) < 4) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '密码至少4位数!',);
                    return;
                }
                if ($pwd1 != $pwd2) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '两次密码输入不一致!',);
                    return;
                }
            }

            if ($admin_id > 0) {//修改
                $detail = K::M('admin/admin')->admin($admin_id);
                if (empty($detail)) {
                    $this->pagedata['data'] = array(
                        'Success' => false,
                        'Msg' => '数据提交错误!',
                    );
                    return;
                }
                if ($admin_id == SUPER_ADMIN_ID && $data['status'] == 2) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '超级管理员账号不能设置为无效!',);
                    return;
                }

                unset($data['admin_name']);

                if ($data['passwd'] == '') {//不修改密码
                    unset($data['passwd']);
                } else {
                    $data['passwd'] = K::M('admin/auth')->getPwdMd5($data['passwd']);
                }

                K::M('admin/admin')->update($data, "admin_id={$admin_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'admin_id' => $admin_id,
                );

                K::M('OptLog')->addlog($admin_id, K::M('admin/admin')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                if (strlen($data['admin_name']) < 4) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '用户名至少4个字母或数字!',);
                    return;
                }

                if ($data['passwd'] == '') {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '请输入密码!',);
                    return;
                } else {
                    $data['passwd'] = K::M('admin/auth')->getPwdMd5($data['passwd']);
                }

                //查用户名是否已经存在
                $one = K::M('admin/admin')->getone("admin_name='{$data['admin_name']}'");
                if (!empty($one)) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '已经存在该用户名!',);
                    return;
                }

                $data['status'] = 1; //新增的位有效

                if ($admin_id = K::M('admin/admin')->add($data)) {

                    K::M('OptLog')->addlog($admin_id, K::M('admin/admin')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'admin_id' => $admin_id,
                    );
                    return;
                }
            }
        }
        $this->pagedata['data'] = array(
            'Success' => false,
            'Msg' => '保存失败!',
        );
    }

    public function add() {

        $this->tmpl = 'admin/edit.html';
    }

    public function edit() {
        $admin_id = intval($this->GP('id'));

        if (empty($admin_id)) {
            $admin_id = K::M('admin/auth')->admin_id;
        }

        $detail = K::M('admin/admin')->admin($admin_id);
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $this->pagedata['id'] = $admin_id;
        $this->pagedata['info'] = $detail;
        $this->pagedata['admin_name'] = K::M('admin/auth')->admin_name;

        $this->tmpl = 'admin/edit.html';
    }

    public function delone() {
        $admin_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';
        if ($admin_id == SUPER_ADMIN_ID) {
            $this->pagedata['data'] = array(
                'Success' => false,
                'Msg' => '不能删除超级管理员账号!',
            );
            return;
        }
        if (K::M('admin/admin')->del("admin_id={$admin_id}")) {

            K::M('OptLog')->addlog($admin_id, K::M('admin/admin')->table(), CONF::$LogType_del, '删除'); //操作日志

            $this->pagedata['data'] = array(
                'Success' => true,
                'Msg' => '删除成功!',
            );
            return;
        }
        $this->pagedata['data'] = array(
            'Success' => false,
            'Msg' => '删除失败!',
        );
    }

}
