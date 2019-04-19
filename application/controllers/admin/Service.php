<?php

class Service extends App {

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
                case 'service_no':
                    $filter['service_no'] = "LIKE:%" . $word . "%";
                    break;
                case 'name':
                    $filter['name'] = "LIKE:%" . $word . "%";
                    break;
                case 'mobi':
                    $filter['mobile'] = "LIKE:%" . $word . "%";
                    break;
                default :
                    $filter['1']['OR']['service_no'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['name'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['mobile'] = "LIKE:%" . $word . "%";
            }
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'service_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('service/service')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $serviceTypes = K::M('service/serviceType')->getnames("1  {$this->other_where}");
        $this->pagedata['serviceTypes'] = $serviceTypes;


        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'service/service.html';
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
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写服务商名称!',);
                return;
            }
            $service_id = intval($data['id']);

            if ($data['agreement_begin'] != '') {
                $data['agreement_begin'] = strtotime($data['agreement_begin']);
            }
            if ($data['agreement_end'] != '') {
                $data['agreement_end'] = strtotime($data['agreement_end']);
            }
$admin_id = ADMIN_ID;
            if ($service_id > 0) {//修改
                $one = K::M('service/service')->getone("name='{$data['name']}' AND admin_id = {$admin_id} AND  service_id != {$service_id}");
                if (!empty($one)) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '已经存在该服务商名称!',);
                    return;
                }
                
                $detail = K::M('service/service')->getone("service_id={$service_id}");
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

                unset($data['service_no']);
                unset($data['num']);

                K::M('service/service')->update($data, "service_id={$service_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'service_id' => $service_id,
                );

                K::M('OptLog')->addlog($service_id, K::M('service/service')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                $one = K::M('service/service')->getone("name='{$data['name']}' AND admin_id = {$admin_id}");
                if (!empty($one)) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '已经存在该服务商名称!',);
                    return;
                }

                $code = K::M('service/service')->getlastcode('service');//自动生成编号
                $data['service_no'] = $code[0];
                $data['num'] = $code[1];
                
                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($service_id = K::M('service/service')->add($data)) {

                    K::M('OptLog')->addlog($service_id, K::M('service/service')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'service_id' => $service_id,
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

        $code = K::M('service/service')->getlastcode('service');
        $this->pagedata['code'] = $code[0];

        $serviceType = K::M('service/serviceType')->getnames("1 {$this->must_where}");
        $this->pagedata['serviceType'] = $serviceType;
        $this->tmpl = 'service/service_edit.html';
    }

    public function edit() {
        $service_id = intval($this->GP('id'));

        $detail = K::M('service/service')->getone("service_id={$service_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }
        $serviceType = K::M('service/serviceType')->getnames("admin_id={$detail['admin_id']}");
        $this->pagedata['serviceType'] = $serviceType;
        $this->pagedata['id'] = $service_id;
        $this->pagedata['info'] = $detail;
		
        $this->tmpl = 'service/service_edit.html';
    }

    public function delone() {
        $service_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('service/service')->del("service_id={$service_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($service_id, K::M('service/service')->table(), CONF::$LogType_del, '删除'); //操作日志

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
