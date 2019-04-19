<?php

class ServiceType extends App {

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
            'type_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('service/serviceType')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'service/service_type.html';
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
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写项目类别名称!',);
                return;
            }
            $type_id = intval($data['id']);
 $admin_id = ADMIN_ID;
            if ($type_id > 0) {//修改
                $one = K::M('service/serviceType')->getone("name='{$data['name']}' AND admin_id = {$admin_id} AND type_id != {$type_id}");
                if (!empty($one)) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '已经存在该项目类别名称!',);
                    return;
                }
                
                $detail = K::M('service/serviceType')->getone("type_id={$type_id}");
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

                K::M('service/serviceType')->update($data, "type_id={$type_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'type_id' => $type_id,
                );

                K::M('OptLog')->addlog($type_id, K::M('service/serviceType')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                
                $one = K::M('service/serviceType')->getone("name='{$data['name']}' AND admin_id = {$admin_id}");
                if (!empty($one)) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '已经存在该项目类别名称!',);
                    return;
                }

                $data['status'] = 1; //新增的有效
				$data['admin_id'] = ADMIN_ID;

                if ($type_id = K::M('service/serviceType')->add($data)) {

                    K::M('OptLog')->addlog($type_id, K::M('service/serviceType')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'type_id' => $type_id,
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

        $this->tmpl = 'service/service_type_edit.html';
    }

    public function edit() {
        $type_id = intval($this->GP('id'));

        $detail = K::M('service/serviceType')->getone("type_id={$type_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }
        $this->pagedata['id'] = $type_id;
        $this->pagedata['info'] = $detail;
		
        $this->tmpl = 'service/service_type_edit.html';
    }

    public function delone() {
        $type_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('service/serviceType')->del("type_id={$type_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($type_id, K::M('service/serviceType')->table(), CONF::$LogType_del, '删除'); //操作日志

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
