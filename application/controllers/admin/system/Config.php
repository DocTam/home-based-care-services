<?php

class Config extends App {

    function __construct() {
        parent::__construct();
        $this->check_admin_login();

        $this->pagedata['topmenu'] = 'system';
    }

    function index() {
        $code = K::M('system/config')->get('code');
        $this->pagedata['code'] = $code;
        $this->tmpl = "system/config.html";
    }

    public function site() {
        $site = K::M('system/config')->get('site');
        $this->pagedata['config'] = $site;
        $this->pagedata['submenu'] = 'site';
        $this->tmpl = "system/config/site.html";
    }

    public function attach() {
        $attach = K::M('system/config')->get('attach');
        $this->pagedata['config'] = $attach;
        $this->pagedata['submenu'] = 'site';
        $this->tmpl = "system/config/attach.html";
    }

    public function watermark() {
        $attach = K::M('system/config')->get('watermark');
        $this->pagedata['config'] = $attach;
        $this->pagedata['submenu'] = 'site';
        $this->tmpl = "system/config/watermark.html";
    }

    function save() {
        $pk = K::M('share')->replace_null($this->GP('K'));
        $data = $this->GP('config');

        $this->pagedata['outType'] = 'json';
        if (!$pk || !$data) {
            $this->pagedata['data'] = array('Success' => false, 'Msg' => '数据错误!');
            return;
        }

        if ($pk == 'code') {
            if (!$this->checkcode($data)) {
                return;
            }
        }

        if (K::M('system/config')->set($pk, $data)) {
            $this->pagedata['data'] = array('Success' => true, 'Msg' => '保存成功!');
            return;
        }
        $this->pagedata['data'] = array('Success' => false, 'Msg' => '保存失败!');
    }

    function checkcode(&$data) {
        if (!preg_match('/^[a-zA-Z]{1,6}$/', $data['service_code'])) {
            $this->pagedata['data'] = array('Success' => false, 'Msg' => '只能填写1-6个字母字符!');
            return false;
        }
        if (!preg_match('/^[a-zA-Z]{1,6}$/', $data['member_code'])) {
            $this->pagedata['data'] = array('Success' => false, 'Msg' => '只能填写1-6个字母字符!');
            return false;
        }
        if (!preg_match('/^[a-zA-Z]{1,6}$/', $data['worker_code'])) {
            $this->pagedata['data'] = array('Success' => false, 'Msg' => '只能填写1-6个字母字符!');
            return false;
        }
        if (!preg_match('/^[a-zA-Z]{1,6}$/', $data['order_code'])) {
            $this->pagedata['data'] = array('Success' => false, 'Msg' => '只能填写1-6个字母字符!');
            return false;
        }
        $data['service_sort'] = intval($data['service_sort']);
        $data['service_num'] = intval($data['service_num']);
        $data['member_sort'] = intval($data['member_sort']);
        $data['member_num'] = intval($data['member_num']);
        $data['worker_sort'] = intval($data['worker_sort']);
        $data['worker_num'] = intval($data['worker_num']);
        $data['order_sort'] = intval($data['order_sort']);
        $data['order_num'] = intval($data['order_num']);
        if ($data['service_sort'] < 0 || $data['member_sort'] < 0 || $data['worker_sort'] < 0 || $data['order_sort'] < 0) {
            $this->pagedata['data'] = array('Success' => false, 'Msg' => '起始序号填写错误!');
            return false;
        }
        if ($data['service_sort'] > 1000000000 || $data['member_sort'] > 1000000000 ||
                $data['worker_sort'] > 1000000000 || $data['order_sort'] > 1000000000) {
            $this->pagedata['data'] = array('Success' => false, 'Msg' => '起始序号填写错误!');
            return false;
        }
        
        if ($data['service_num'] <= 0 || $data['service_num']>10 ) {
            $data['service_num'] = 6;
        }
        if ($data['member_num'] <= 0 || $data['member_num']>10 ) {
            $data['member_num'] = 6;
        }
        if ($data['worker_num'] <= 0 || $data['worker_num']>10 ) {
            $data['worker_num'] = 6;
        }
        if ($data['order_num'] <= 0 || $data['order_num']>10 ) {
            $data['order_num'] = 6;
        }
         
        return true;
    }

}
