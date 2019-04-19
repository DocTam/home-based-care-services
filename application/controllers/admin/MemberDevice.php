<?php

class MemberDevice extends App {

    public function __construct() {
        parent::__construct();
        $this->check_admin_login();
    }

    //设备列表
    public function index() {

        $member_id = intval($this->input->get('member_id'));
        if ($member_id <= 0) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $member = K::M('member/member')->getone("member_id={$member_id} {$this->other_where}");
        if (empty($member)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $page = intval($this->input->get('page'));
        $page = $page <= 0 ? 1 : $page;

        $limit = PAGE_LIMIT;

        $SO = $filter = array();
        if(SUPER_ADMIN_ID != ADMIN_ID){
            $filter['admin_id'] = ADMIN_ID;
        }
        $filter['member_id'] = $member_id;

        $order = array(
            'device_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('member/memberDevice')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $this->pagedata['member'] = $member;
        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'member/memberDevice.html';
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
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写设备名称!',);
                return;
            }
            if (empty($data['imei'])) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写设备imei!',);
                return;
            }

            $device_id = intval($data['id']);
            $member_id = intval($data['member_id']);


            if ($device_id > 0) {//修改
                $one = K::M('member/memberDevice')->getone("imei='{$data['imei']}' AND device_id != {$device_id}");
                if(!empty($one)){
                   $this->pagedata['data'] = array(
                        'Success' => false,
                        'Msg' => '系统中已经存在该设备imei !',
                    );
                    return;
                }
                
                $detail = K::M('member/memberDevice')->getone("device_id={$device_id}");
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

                K::M('member/memberDevice')->update($data, "device_id={$device_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'device_id' => $device_id,
                );

                K::M('OptLog')->addlog($device_id, K::M('member/memberDevice')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                
                $one = K::M('member/memberDevice')->getone("imei='{$data['imei']}'");
                if(!empty($one)){
                   $this->pagedata['data'] = array(
                        'Success' => false,
                        'Msg' => '系统中已经存在该设备imei !',
                    );
                    return;
                }
                    
                
                $data['member_id'] = $member_id;
                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($device_id = K::M('member/memberDevice')->add($data)) {

                    K::M('OptLog')->addlog($device_id, K::M('member/memberDevice')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'device_id' => $device_id,
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

        $member_id = intval($this->input->get('member_id'));
        if ($member_id <= 0) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $member = K::M('member/member')->getone("member_id={$member_id} {$this->other_where}");
        if (empty($member)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $this->pagedata['member'] = $member;

        $this->tmpl = 'member/memberDevice_edit.html';
    }

    public function edit() {
        $device_id = intval($this->GP('id'));

        $detail = K::M('member/memberDevice')->getone("device_id={$device_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }
        $member_id = intval($detail['member_id']);
        $member = K::M('member/member')->getone("member_id={$member_id} {$this->other_where}");
        if (empty($member)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $this->pagedata['member'] = $member;
        $this->pagedata['id'] = $device_id;
        $this->pagedata['info'] = $detail;
		
        $this->tmpl = 'member/memberDevice_edit.html';
    }

    public function delone() {
        $device_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('member/memberDevice')->del("device_id={$device_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($device_id, K::M('member/memberDevice')->table(), CONF::$LogType_del, '删除'); //操作日志

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
