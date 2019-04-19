<?php

class Worker extends App {

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
            $select = $this->GP('select');
            switch ($select) {
                case 'worker_no':
                    $filter['worker_no'] = "LIKE:%" . $word . "%";
                    break;
                case 'name':
                    $filter['name'] = "LIKE:%" . $word . "%";
                    break;
                case 'mobi':
                    $filter['mobile'] = "LIKE:%" . $word . "%";
                    break;
                default :
                    $filter['1']['OR']['worker_no'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['name'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['mobile'] = "LIKE:%" . $word . "%";
            }
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'worker_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('worker/worker')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }


        //-----------服务商
        $services = K::M('service/service')->getnames("1 {$this->other_where}");
        $this->pagedata['services'] = $services;
        
        //-----------服务角色
        $types = K::M('worker/workerType')->getnames("1 {$this->other_where}");
        $this->pagedata['types'] = $types;
        

        //-----------服务角色
        $roles = K::M('worker/workerRole')->getnames("1 {$this->other_where}");
        $this->pagedata['roles'] = $roles;

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'worker/list.html';
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
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写真实姓名!',);
                return;
            }
            $data['type_id'] = intval($data['type_id']);
            if (empty($data['type_id'])) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请选择服务类型!',);
                return;
            }
            
            $type = K::M('worker/workerType')->getone("type_id={$data['type_id']}");
            if (empty($type)) {
                $msg = "'服务类型选择失败,请您在“服务人员” -> “员工服务类型”中先添加相应服务类型数据！!'";
                $this->pagedata['data'] = array('Success' => false, 'Msg' => $msg,);
                return;
            }
            $data['code'] = $type['code'];

            $worker_id = intval($data['id']);

            if ($data['birthday'] != '') {
                $arr = explode('/', $data['birthday']);
                $data['birthY'] = $arr[0];
                $data['birthM'] = $arr[1];
            }
            unset($data['birthday']);

            if ($data['agreement_begin'] != '') {
                $data['agreement_begin'] = strtotime($data['agreement_begin']);
            }
            if ($data['agreement_end'] != '') {
                $data['agreement_end'] = strtotime($data['agreement_end']);
            }
            if ($data['secure_date'] != '') {
                $data['secure_date'] = strtotime($data['secure_date']);
            }

            if ($worker_id > 0) {//修改
                $detail = K::M('worker/worker')->getone("worker_id={$worker_id}");
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

                unset($data['worker_no']);
                unset($data['num']);

                K::M('worker/worker')->update($data, "worker_id={$worker_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'worker_id' => $worker_id,
                );

                K::M('OptLog')->addlog($worker_id, K::M('worker/worker')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                $code = K::M('worker/worker')->getlastcode('worker');
                $data['worker_no'] = $code[0];
                $data['num'] = $code[1];

                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($worker_id = K::M('worker/worker')->add($data)) {

                    K::M('OptLog')->addlog($worker_id, K::M('worker/worker')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'worker_id' => $worker_id,
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
        $from = K::M('share')->replace_null($this->GP('from')); //角色
        
        $type_id = 0; //如果是从其它页面过来, 则服务类型强制为来源的类型
        if (!empty($from)) {
            $frompage = K::M('worker/workerType')->frompage($from, ADMIN_ID);
            if (empty($frompage['id'])) {//type_id
                $msg = "操作失败, 请您在“服务人员”->“员工服务类型”中先添加“{$frompage['type']}”类型数据!";
                K::M('helper/error')->showmsg($msg);
                return;
            }
            $type_id = $frompage['id'];
            $this->pagedata['from'] = $frompage;
        }

        //员工编号
        $code = K::M('worker/worker')->getlastcode('worker');
        $this->pagedata['code'] = $code[0];

        $services = K::M('service/service')->getnames("1 {$this->must_where}");
        $this->pagedata['services'] = $services;
        
        $this->typesAndRoles(ADMIN_ID);
        
        $this->pagedata['type_id'] = $type_id;
        $this->tmpl = 'worker/edit.html';
    }
    
    function typesAndRoles($admin_id){
        $option = array(
            'where' => "admin_id={$admin_id}",
        );
        $types = K::M('worker/workerType')->getlist($option);

        $roles = K::M('worker/workerRole')->getlist($option);

        $arr = array();
        foreach ($roles as $v) {//二级
            $arr[$v['type_id']][] = array('id' => $v['role_id'], 'name' => $v['name'] );
        }
        $result = array();
        foreach ($types as $v) {//一级
            $result[$v['type_id']] = array(
                'id' => $v['type_id'],
                'name' => $v['name'],
                'data' => $arr[$v['type_id']], 
            );
        }

        $this->pagedata['oneAndTwo'] = $result;
    }

    public function edit() {
        $worker_id = intval($this->GP('id'));

        $detail = K::M('worker/worker')->getone("worker_id={$worker_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $from = K::M('share')->replace_null($this->GP('from')); //角色

        $frompage = K::M('worker/workerType')->frompage($from, $detail['admin_id']);
        $this->pagedata['from'] = $frompage;

        $services = K::M('service/service')->getnames("admin_id = {$detail['admin_id']}");
        $this->pagedata['services'] = $services;

        $this->typesAndRoles($detail['admin_id']);

        $this->pagedata['id'] = $worker_id;
        $this->pagedata['info'] = $detail;
        $this->pagedata['type_id'] = $detail['type_id'];
		
        $this->tmpl = 'worker/edit.html';
    }

    public function delone() {
        $worker_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('worker/worker')->del("worker_id={$worker_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($worker_id, K::M('worker/worker')->table(), CONF::$LogType_del, '删除'); //操作日志

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
