<?php

class Order extends App {
    
    protected $code = '';

    public function __construct() {
        parent::__construct();
        $this->check_admin_login();

		$this->code = K::M('worker/workerType')->getcode('house');
        $this->pagedata['pagecode'] = 'house';
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
                case 'house': // 
                    $ids = K::M('worker/worker')->getidsbyname($word, 'name', "code='{$this->code}' {$this->other_where}");
                    $filter['worker_id'] = $ids;
                    break;
                case 'order_no':
                    $filter['order_no'] = "LIKE:%" . $word . "%";
                    break;
                case 'name': //客户姓名
                    $filter['customer_name'] = "LIKE:%" . $word . "%";
                    break;
                case 'item': //服务项目
                    $filter['service_item'] = "LIKE:%" . $word . "%";
                    break;
                default :
                    $filter['1']['OR']['order_no'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['customer_name'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['service_item'] = "LIKE:%" . $word . "%";
            }
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'order_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('order/order')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }
        
        $names = K::M('service/serviceItem')->getnames("1  {$this->other_where}");
        $this->pagedata['serviceItems'] = $names;
        
        $names = K::M('worker/worker')->getnames("code='{$this->code}' {$this->other_where}");
        $this->pagedata['houses'] = $names;

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'order/list.html';
    }

    function save() {
        $this->pagedata['outType'] = 'json';
        if ($this->checksubmit()) {
            $data = (array) $_POST;

            if (empty($data)) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '提交失败!',);
                return;
            }
            if (empty($data['item_id'])) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请选择服务内容!',);
                return;
            }
            if (empty($data['customer_name'])) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写客户姓名!',);
                return;
            }

            $order_id = intval($data['id']);

            if ($data['agreement_begin'] != '') {
                $data['agreement_begin'] = strtotime($data['agreement_begin']);
            }
            if ($data['agreement_end'] != '') {
                $data['agreement_end'] = strtotime($data['agreement_end']);
            }

            if ($order_id > 0) {//修改
                $detail = K::M('order/order')->getone("order_id={$order_id}");
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

                unset($data['order_no']);
                unset($data['num']);

                K::M('order/order')->update($data, "order_id={$order_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'order_id' => $order_id,
                );

                K::M('OptLog')->addlog($order_id, K::M('order/order')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                
                $code = K::M('order/order')->getlastcode('order');
                $data['order_no'] = $code[0];
                $data['num'] = $code[1];

                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($order_id = K::M('order/order')->add($data)) {

                    K::M('OptLog')->addlog($order_id, K::M('order/order')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'order_id' => $order_id,
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
            'where' => "admin_id={$admin_id}"
        );
        $types = K::M('service/serviceType')->getlist($option);
        
        $services = K::M('service/service')->getlist($option);
        
        $arr = array();
        foreach ($services as $v) {//二级
            $arr[$v['type_id']][] = array('id' => $v['service_id'], 'name' => $v['name']);
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

        $code = K::M('order/order')->getlastcode('order');
        $this->pagedata['code'] = $code[0];

        //$this->serviceAndTypes();
        $admin_id = ADMIN_ID;
        $option = array(
            'where' => "admin_id={$admin_id}"
        );
        $serviceItems = K::M('service/serviceItem')->getlist($option);//服务内容
        $this->pagedata['serviceItems'] = $serviceItems;
                
        $names = K::M('worker/worker')->getnames("code='{$this->code}' AND admin_id={$admin_id} ");
        $this->pagedata['houses'] = $names;
        
        $this->tmpl = 'order/edit.html';
    }

    public function edit() {
        $order_id = intval($this->GP('id'));

        $detail = K::M('order/order')->getone("order_id={$order_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }
        //$this->serviceAndTypes();
        
        $option = array(
            'where' => "admin_id={$detail['admin_id']}"
        );
        $serviceItems = K::M('service/serviceItem')->getlist($option);//服务内容
        $this->pagedata['serviceItems'] = $serviceItems;
        
        $data = K::M('service/serviceItem')->getservice($detail['item_id']);
         
        $this->pagedata['services'] = $data;
        
        $names = K::M('worker/worker')->getnames("code='{$this->code}' AND admin_id={$detail['admin_id']}");
        $this->pagedata['houses'] = $names;
        
        $this->pagedata['id'] = $order_id;
        $this->pagedata['info'] = $detail;
		
        $this->tmpl = 'order/edit.html';
    }

    public function delone() {
        $order_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('order/order')->del("order_id={$order_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($order_id, K::M('order/order')->table(), CONF::$LogType_del, '删除'); //操作日志

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
