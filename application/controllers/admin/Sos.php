<?php

class sos extends App {

    protected $datatype = 'sos'; //数据类型

    public function __construct() {
        parent::__construct();
        //if (METHOD != 'checkSos') {
        $this->check_admin_login();

        $max_record_id = 0;

        $admin_id = ADMIN_ID;
        if (SUPER_ADMIN_ID == $admin_id) {
            $where = "datatype='sos'  ORDER BY data_id DESC";
        } else {
            $where = "datatype='sos' AND admin_id={$admin_id} ORDER BY data_id DESC";
        }

        $lastone = K::M('api/healthdata')->getone($where, 'data_id');
        if (!empty($lastone)) {
            $max_record_id = $lastone['data_id'];
        }
        $this->pagedata['max_record_id'] = $max_record_id;
        //}
    }

    //列表
    public function index() {

        $page = intval($this->input->get('page'));
        $page = $page <= 0 ? 1 : $page;

        $limit = 10;

        $filter = array();
        $SO = array();

        if (SUPER_ADMIN_ID != ADMIN_ID) {
            $filter['admin_id'] = ADMIN_ID;
        }

        $filter['datatype'] = $this->datatype;

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
            'status' => 'ASC',
            'data_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('api/healthdata')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'sos/sos.html';
    }

    //定位
    function map() {
        $this->index();

        $this->tmpl = 'sos/map.html';
    }

    //报警信息处理
    function sosinfo() {
        $data_id = intval($this->GP('id'));

        $info = K::M('api/healthdata')->getone("data_id='{$data_id}'");
        if (empty($info)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }
        $member = K::M('member/member')->getone("member_id='{$info['member_id']}'");

        $this->pagedata['member'] = $member;
        $this->pagedata['info'] = $info;
        $this->pagedata['id'] = $data_id;


        $this->tmpl = 'sos/sos_info.html';
    }

    function savesos() {
        $this->pagedata['outType'] = 'json';
        if ($this->checksubmit()) {
            $data = (array) $_POST;

            if (empty($data) || count($data) != 3) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '提交失败!',);
                return;
            }
            if (empty($data['receptionist'])) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写接待人!',);
                return;
            }
            if (empty($data['result'])) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写处理结果!',);
                return;
            }
            $data_id = intval($data['id']);
            unset($data['id']);

            if ($data_id > 0) {//修改
                $one = K::M('api/healthdata')->getone("data_id='{$data_id}'");
                if (empty($one)) {
                    $this->pagedata['data'] = array(
                        'Success' => false,
                        'Msg' => '数据提交错误!',
                    );
                    return;
                }
                if ($one['status'] == 1) {
                    $this->pagedata['data'] = array(
                        'Success' => false,
                        'Msg' => '已处理,不要重复提交!',
                    );
                    return;
                }
                $data['updatetime'] = __TIME;
                $data['status'] = 1;
                $data['opter'] = ADMIN_ID;
                K::M('api/healthdata')->update($data, "data_id={$data_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                );

                K::M('OptLog')->addlog($data_id, K::M('api/healthdata')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            }
        }
        $this->pagedata['data'] = array(
            'Success' => false,
            'Msg' => '保存失败!',
        );
    }

    //获取刷新新数据
    function checkSos() {
        $this->pagedata['outType'] = 'json';

        $max_record_id = intval($this->GP('max_record_id'));

        //存在未处理的数据
        $option = array(
            'where' => "data_id > {$max_record_id} AND datatype='{$this->datatype}' AND status = 0 ",
            'order' => 'data_id DESC',
        );
        if (SUPER_ADMIN_ID != ADMIN_ID) {
            $admin_id = ADMIN_ID;
            $option['where'] .= " AND admin_id={$admin_id}";
        }
        $list = K::M('api/healthdata')->getlist($option);
        $result = array();
        foreach ($list as $v) {
            $result[] = array(
                'data_id' => $v['data_id'],
                'name' => $v['name'],
                'mobile' => $v['mobile'],
                'heartrate' => $v['heartrate'],
                //'city' => $v['city'],
                'address' => $v['address'],
                'lon' => $v['lon'],
                'lat' => $v['lat'],
                'status' => $v['status'] == 1 ? '是' : '否',
                'time_begin' => empty($v['time_begin']) ? date('Y-m-d H:i:s', $v['dateline']) : $v['time_begin'],
            );
            $max_record_id = $v['data_id']; //最大的id
        }
        //echo json_encode($result, JSON_UNESCAPED_UNICODE);
        $this->pagedata['data'] = array(
            'Success' => true,
            'Data' => $result,
            'max_record_id' => $max_record_id,
        );
    }

}
