<?php

class Member extends App {

    public function __construct() {
        parent::__construct();
        $this->check_admin_login();
    }

    //会员列表
    public function index() {

        $page = intval($this->input->get('page'));
        $page = $page <= 0 ? 1 : $page;


        $limit = PAGE_LIMIT;

        $filter = array();
        if (SUPER_ADMIN_ID != ADMIN_ID) {
            $filter['admin_id'] = ADMIN_ID;
        }
        $SO = array();

        if ($word = K::M('share')->replace_null(trim($this->GP('word')))) {
            $select = $this->GP('select');
            switch ($select) {
                case 'member_no':
                    $filter['member_no'] = "LIKE:%" . $word . "%";
                    break;
                case 'name':
                    $filter['name'] = "LIKE:%" . $word . "%";
                    break;
                case 'mobi':
                    $filter['mobile'] = "LIKE:%" . $word . "%";
                    break;
                case 'imei'://设备找人
                    if (strlen($word) >= 6) {
                        $member_ids = K::M('member/memberDevice')->getmemberids($word, $this->other_where);
                        $filter['member_id'] = $member_ids;
                    } else {
                        $filter['member_id'] = 0;
                    }

                    break;
                default :
                    $filter['1']['OR']['member_no'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['name'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['mobile'] = "LIKE:%" . $word . "%";
            }
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'member_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('member/member')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);

            $ids = array();
            foreach ($items as $k => $v) {
                $one = K::M('member/memberDevice')->getnum("member_id={$v['member_id']}");
                
                $items[$k]['device'] = $one;
                
            }
            
        }



        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'member/list.html';
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
            //-----其它监护人-----
            if (empty($data['otherdata'])) {
                $data['otherdata'] = '';
            } else {
                $otherdata = K::M('content/Filter')->replace_all_null($data['otherdata']);
                unset($data['otherdata']);
                if (!empty($otherdata)) {
                    $otherresult = array();
                    foreach ($otherdata as $k => $v) {
                        foreach ($v as $k2 => $v2) {
                            $otherresult[$k2][$k] = $v2;
                        }
                    }

                    $data['otherdata'] = json_encode($otherresult, JSON_UNESCAPED_UNICODE);
                }
            }


            $member_id = intval($data['id']);

            if ($data['birthday'] != '') {
                $arr = explode('/', $data['birthday']);
                $data['birthY'] = $arr[0];
                $data['birthM'] = $arr[1];
            }
            unset($data['birthday']);

            if ($data['vip_time'] != '') {
                $data['vip_time'] = strtotime($data['vip_time']);
            }
            if ($data['vip_end'] != '') {
                $data['vip_end'] = strtotime($data['vip_end']);
            }
            if ($data['vip_addtime'] != '') {
                $data['vip_addtime'] = strtotime($data['vip_addtime']);
            }

            if ($member_id > 0) {//修改
                $detail = K::M('member/member')->getone("member_id={$member_id}");
                if (empty($detail)) {
                    $this->pagedata['data'] = array(
                        'Success' => false,
                        'Msg' => '数据提交错误!',
                    );
                    return;
                }

                unset($data['member_no']);
                unset($data['num']);

                if (SUPER_ADMIN_ID != ADMIN_ID && $detail['admin_id'] != ADMIN_ID) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '您没有权限修改该数据!',);
                    return;
                }

                K::M('member/member')->update($data, "member_id={$member_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'member_id' => $member_id,
                );

                K::M('OptLog')->addlog($member_id, K::M('member/member')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                $code = K::M('member/member')->getlastcode('member');
                $data['member_no'] = $code[0];
                $data['num'] = $code[1];

                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($member_id = K::M('member/member')->add($data)) {

                    K::M('OptLog')->addlog($member_id, K::M('member/member')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'member_id' => $member_id,
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

        $code = K::M('member/member')->getlastcode('member');

        $this->pagedata['code'] = $code[0];

        $this->tmpl = 'member/edit.html';
    }

    public function edit() {
        $member_id = intval($this->GP('id'));

        $detail = K::M('member/member')->getone("member_id={$member_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        if (!empty($detail)) {
            $detail['otherdata'] = json_decode($detail['otherdata'], true);
        }

        $this->pagedata['id'] = $member_id;
        $this->pagedata['info'] = $detail;

        $this->tmpl = 'member/edit.html';
    }

    public function delone() {
        $member_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('member/member')->del("member_id={$member_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($member_id, K::M('member/member')->table(), CONF::$LogType_del, '删除'); //操作日志

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

    //会员心率管理
    public function heartrate() {

        $page = intval($this->input->get('page'));
        $page = $page <= 0 ? 1 : $page;

        $limit = PAGE_LIMIT;

        $filter = array();
        if (SUPER_ADMIN_ID != ADMIN_ID) {
            $filter['admin_id'] = ADMIN_ID;
        }
        $SO = array();

        $filter['datatype'] = 'heart';

        if ($word = K::M('share')->replace_null(trim($this->GP('word')))) {
            $select = $this->GP('select');
            switch ($select) {

                case 'mobi':
                    $filter['mobile'] = "LIKE:%" . $word . "%";
                    break;

                case 'name':
                    $filter['name'] = "LIKE:%" . $word . "%";
                    break;
                default :
                    $filter['1']['OR']['name'] = "LIKE:%" . $word . "%";
                    $filter['mobile'] = "LIKE:%" . $word . "%";
            }
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'data_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('api/healthdata')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'member/heartrate.html';
    }

    //血压记录
    public function bp() {

        $page = intval($this->input->get('page'));
        $page = $page <= 0 ? 1 : $page;

        $limit = PAGE_LIMIT;

        $filter = array();
        if (SUPER_ADMIN_ID != ADMIN_ID) {
            $filter['admin_id'] = ADMIN_ID;
        }
        $SO = array();

        $filter['datatype'] = 'bp';

        if ($word = K::M('share')->replace_null(trim($this->GP('word')))) {
            $select = $this->GP('select');
            switch ($select) {

                case 'mobi':
                    $filter['mobile'] = "LIKE:%" . $word . "%";
                    break;

                case 'name':
                    $filter['name'] = "LIKE:%" . $word . "%";
                    break;
                default :
                    $filter['1']['OR']['name'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['mobile'] = "LIKE:%" . $word . "%";
            }
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'data_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('api/healthdata')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'member/bp.html';
    }

}
