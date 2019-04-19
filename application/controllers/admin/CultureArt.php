<?php

class CultureArt extends App {

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
        if (SUPER_ADMIN_ID != ADMIN_ID) {
            $filter['admin_id'] = ADMIN_ID;
        }
        $SO = array();

        if ($word = K::M('share')->replace_null(trim($this->GP('word')))) {
            $select = $this->GP('select');
            switch ($select) {


                case 'name':
                    $filter['name'] = "LIKE:%" . $word . "%";
                    break;
                default :
                    $filter['1']['OR']['name'] = "LIKE:%" . $word . "%";
            }
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'art_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('culture/cultureArt')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $types = K::M('culture/cultureType')->getnames("1 {$this->other_where}");
        $this->pagedata['types'] = $types;

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'culture/cultureArt.html';
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
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写艺术团名!',);
                return;
            }
            $art_id = intval($data['id']);

            $admin_id = ADMIN_ID;
            if ($art_id > 0) {//修改
                $one = K::M('culture/cultureArt')->getone("name='{$data['name']}' AND admin_id = {$admin_id} AND art_id !={$art_id}");
                if (!empty($one)) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '已经存在该艺术团名称!',);
                    return;
                }

                $detail = K::M('culture/cultureArt')->getone("art_id={$art_id}");
                if (empty($detail)) {
                    $this->pagedata['data'] = array(
                        'Success' => false,
                        'Msg' => '数据提交错误!',
                    );
                    return;
                }
                if (SUPER_ADMIN_ID != ADMIN_ID && $detail['admin_id'] != ADMIN_ID) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '您没有权限修改该数据!',);
                    return;
                }

                K::M('culture/cultureArt')->update($data, "art_id={$art_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'art_id' => $art_id,
                );

                K::M('OptLog')->addlog($art_id, K::M('culture/cultureArt')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                $one = K::M('culture/cultureArt')->getone("name='{$data['name']}' AND admin_id = {$admin_id}");
                if (!empty($one)) {
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '已经存在该艺术团名称!',);
                    return;
                }

                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($art_id = K::M('culture/cultureArt')->add($data)) {

                    K::M('OptLog')->addlog($art_id, K::M('culture/cultureArt')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'art_id' => $art_id,
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

        $types = K::M('culture/cultureType')->getnames("1 {$this->must_where}");
        $this->pagedata['types'] = $types;

        $this->tmpl = 'culture/cultureArt_edit.html';
    }

    public function edit() {
        $art_id = intval($this->GP('id'));

        $detail = K::M('culture/cultureArt')->getone("art_id={$art_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $types = K::M('culture/cultureType')->getnames(" 1 AND admin_id={$detail['admin_id']}");
        $this->pagedata['types'] = $types;

        $this->pagedata['id'] = $art_id;
        $this->pagedata['info'] = $detail;

        $this->tmpl = 'culture/cultureArt_edit.html';
    }

    public function delone() {
        $art_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('culture/cultureArt')->del("art_id={$art_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($art_id, K::M('culture/cultureArt')->table(), CONF::$LogType_del, '删除'); //操作日志

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
