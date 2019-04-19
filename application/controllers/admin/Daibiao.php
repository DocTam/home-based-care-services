<?php

class Daibiao extends App {

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

                case 'name':
                    $filter['1']['OR']['name'] = "LIKE:%" . $word . "%";
                    break;
                case 'mobi':
                    $filter['1']['OR']['mobile'] = "LIKE:%" . $word . "%";
                    break;

                default :
                    $filter['1']['OR']['name'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['mobile'] = "LIKE:%" . $word . "%";
            }
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'daibiao_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('Daibiao/Daibiao')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }
 
        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'Daibiao/list.html';
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
            $daibiao_id = intval($data['id']);
            
            if ($data['birthday'] != '') {
                $arr = explode('/', $data['birthday']);
                $data['birthY'] = $arr[0];
                $data['birthM'] = $arr[1];
            }
            unset($data['birthday']);

            if ($daibiao_id > 0) {//修改
                $detail = K::M('Daibiao/Daibiao')->getone("daibiao_id={$daibiao_id}");
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

                K::M('Daibiao/Daibiao')->update($data, "daibiao_id={$daibiao_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'daibiao_id' => $daibiao_id,
                );

                K::M('OptLog')->addlog($daibiao_id, K::M('Daibiao/Daibiao')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($daibiao_id = K::M('Daibiao/Daibiao')->add($data)) {

                    K::M('OptLog')->addlog($daibiao_id, K::M('Daibiao/Daibiao')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'daibiao_id' => $daibiao_id,
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


        $this->tmpl = 'Daibiao/edit.html';
    }

    public function edit() {
        $daibiao_id = intval($this->GP('id'));

        $detail = K::M('Daibiao/Daibiao')->getone("daibiao_id={$daibiao_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $this->pagedata['id'] = $daibiao_id;
        $this->pagedata['info'] = $detail;
		
        $this->tmpl = 'Daibiao/edit.html';
    }

    public function delone() {
        $daibiao_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('Daibiao/Daibiao')->del("daibiao_id={$daibiao_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($daibiao_id, K::M('Daibiao/Daibiao')->table(), CONF::$LogType_del, '删除'); //操作日志

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