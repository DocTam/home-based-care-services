<?php

class WorkerRole extends App {

    public function __construct() {
        parent::__construct();
        $this->check_admin_login();
    }

    //列表
    public function index() {

        $page = intval($this->input->get('page'));
        $page = $page <= 0 ? 1 : $page;


        $limit = PAGE_LIMIT;

        $filter = array();
        if(SUPER_ADMIN_ID != ADMIN_ID){
            $filter['admin_id'] = ADMIN_ID;
        }
        $SO = array();

        if ($word = K::M('share')->replace_null(trim($this->GP('word')))) {
            $filter['name'] = "LIKE:%" . $word . "%";
            $SO['word'] = $word;
        }

        $order = array(
            'role_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('worker/workerRole')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }
        
        //-----------服务类型------------
        $types = K::M('worker/workerType')->getnames("1 {$this->other_where} ");
        $this->pagedata['types'] = $types;

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'worker/worker_role.html';
    }

    function save() {
        $this->pagedata['outType'] = 'json';
        if ($this->checksubmit()) {
            $data = (array) $_POST;

            if (empty($data)) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '提交失败!',);
                return;
            }
            if (empty($data['name'])) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写服务角色名称!',);
                return;
            }
            if (empty($data['type_id'])) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请选择服务类型!',);
                return;
            }
            
            $role_id = intval($data['id']);
$admin_id = ADMIN_ID;
            if ($role_id > 0) {//修改
                $detail = K::M('worker/workerRole')->getone("role_id={$role_id}");
                if (empty($detail)) {
                    $this->pagedata['data'] = array(
                        'Success' => false,
                        'Msg' => '数据提交错误!',
                    );
                    return;
                }
                
                if(SUPER_ADMIN_ID != ADMIN_ID && $detail['admin_id'] != ADMIN_ID){
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '您没有权限修改该数据!',);
                    return;
                }

                K::M('worker/workerRole')->update($data, "role_id={$role_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'role_id' => $role_id,
                );

                K::M('OptLog')->addlog($role_id, K::M('worker/workerRole')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                $one = K::M('worker/workerRole')->getone("name='{$data['name']}' AND admin_id = {$admin_id}");
                if (!empty($one)) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '已经存在该服务角色名称!',);
                    return;
                }

                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($role_id = K::M('worker/workerRole')->add($data)) {

                    K::M('OptLog')->addlog($role_id, K::M('worker/workerRole')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'role_id' => $role_id,
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

        $types = K::M('worker/workerType')->getnames("1 {$this->must_where} ");
        $this->pagedata['types'] = $types;

        $this->tmpl = 'worker/worker_role_edit.html';
    }

    public function edit() {
        $role_id = intval($this->GP('id'));

        $detail = K::M('worker/workerRole')->getone("role_id={$role_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $types = K::M('worker/workerType')->getnames("admin_id = {$detail['admin_id']}");
        $this->pagedata['types'] = $types;
        
        

        $this->pagedata['id'] = $role_id;
        $this->pagedata['info'] = $detail;
		
        $this->tmpl = 'worker/worker_role_edit.html';
    }

    public function delone() {
        $role_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('worker/workerRole')->del("role_id={$role_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($role_id, K::M('worker/workerRole')->table(), CONF::$LogType_del, '删除'); //操作日志

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
