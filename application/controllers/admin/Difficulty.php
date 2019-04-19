<?php

class Difficulty extends App {

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
                case 'mobi':
                    $filter['mobile'] = "LIKE:%" . $word . "%";
                    break;
                case 'name':
                    $filter['name'] = "LIKE:%" . $word . "%";
                    break;

                default : //默认只搜索 名称
                    $filter['1']['OR']['name'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['mobile'] = "LIKE:%" . $word . "%";
            }
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'difficulty_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('difficulty/difficulty')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $serviceTypes = K::M('service/serviceType')->getnames("1 {$this->other_where}");
        $this->pagedata['serviceTypes'] = $serviceTypes;

        $services = K::M('service/service')->getnames("1 {$this->other_where}");
        $this->pagedata['services'] = $services;

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'difficulty/list.html';
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
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写姓名!',);
                return;
            }
            $difficulty_id = intval($data['id']);
            
            if ($data['begin_time'] != '') {
                $data['begin_time'] = strtotime($data['begin_time']);
            }
            if ($data['end_time'] != '') {
                $data['end_time'] = strtotime($data['end_time']);
            }
$admin_id = ADMIN_ID;
            if ($difficulty_id > 0) {//修改
                $detail = K::M('difficulty/difficulty')->getone("difficulty_id={$difficulty_id}");
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

                K::M('difficulty/difficulty')->update($data, "difficulty_id={$difficulty_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'difficulty_id' => $difficulty_id,
                );

                K::M('OptLog')->addlog($difficulty_id, K::M('difficulty/difficulty')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                $one = K::M('difficulty/difficulty')->getone("name='{$data['name']}' AND admin_id = {$admin_id}");
                if (!empty($one)) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '已经存在该姓名!',);
                    return;
                }

                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($difficulty_id = K::M('difficulty/difficulty')->add($data)) {

                    K::M('OptLog')->addlog($difficulty_id, K::M('difficulty/difficulty')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'difficulty_id' => $difficulty_id,
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

    //二级联动
    function serviceAndTypes($admin_id) {
        $option = array(
            'where' => "admin_id = {$admin_id}",
        );
        $types = K::M('service/serviceType')->getlist($option);

        $services = K::M('service/service')->getlist($option);

        $arr = array();
        foreach ($services as $v) {//二级
            $arr[$v['type_id']][] = array('id' => $v['service_id'], 'name' => $v['name'], 'data' => $v['service_no']);
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

    public function add() {

        $this->serviceAndTypes(ADMIN_ID);

        $this->tmpl = 'difficulty/edit.html';
    }

    public function edit() {
        $difficulty_id = intval($this->GP('id'));

        $detail = K::M('difficulty/difficulty')->getone("difficulty_id={$difficulty_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }
        $this->serviceAndTypes($detail['admin_id']);

        $this->pagedata['id'] = $difficulty_id;
        $this->pagedata['info'] = $detail;
		
        $this->tmpl = 'difficulty/edit.html';
    }

    public function delone() {
        $difficulty_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('difficulty/difficulty')->del("difficulty_id={$difficulty_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($difficulty_id, K::M('difficulty/difficulty')->table(), CONF::$LogType_del, '删除'); //操作日志

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
