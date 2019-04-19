<?php

class CleanerAdvice extends App {
    
    protected $code = '';

    public function __construct() {
        parent::__construct();
        $this->check_admin_login();

		$this->code = K::M('worker/workerType')->getcode('cleaner');
        $this->pagedata['pagecode'] = 'cleaner';
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

                case 'cleaner': // 
                    $ids = K::M('worker/worker')->getidsbyname($word, 'name', "code='{$this->code}' {$this->other_where}");
                    $filter['worker_id'] = $ids;
                    break;

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
            'advice_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('cleaner/cleanerAdvice')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $names = K::M('worker/worker')->getnames("code='{$this->code}' {$this->other_where}");
        $this->pagedata['cleaners'] = $names;

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'cleaner/cleanerAdvice.html';
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
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写客户姓名!',);
                return;
            }
            $advice_id = intval($data['id']);


            if ($advice_id > 0) {//修改
                $detail = K::M('cleaner/cleanerAdvice')->getone("advice_id={$advice_id}");
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

                K::M('cleaner/cleanerAdvice')->update($data, "advice_id={$advice_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'advice_id' => $advice_id,
                );

                K::M('OptLog')->addlog($advice_id, K::M('cleaner/cleanerAdvice')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增

                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($advice_id = K::M('cleaner/cleanerAdvice')->add($data)) {

                    K::M('OptLog')->addlog($advice_id, K::M('cleaner/cleanerAdvice')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'advice_id' => $advice_id,
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

        $names = K::M('worker/worker')->getnames("code='{$this->code}' {$this->must_where}");
        $this->pagedata['cleaners'] = $names;

        $this->tmpl = 'cleaner/cleanerAdvice_edit.html';
    }

    public function edit() {
        $advice_id = intval($this->GP('id'));

        $detail = K::M('cleaner/cleanerAdvice')->getone("advice_id={$advice_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }


        $names = K::M('worker/worker')->getnames("code='{$this->code}' AND admin_id={$detail['admin_id']}");
        $this->pagedata['cleaners'] = $names;

        $this->pagedata['id'] = $advice_id;
        $this->pagedata['info'] = $detail;
		
        $this->tmpl = 'cleaner/cleanerAdvice_edit.html';
    }

    public function delone() {
        $advice_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('cleaner/cleanerAdvice')->del("advice_id={$advice_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($advice_id, K::M('cleaner/cleanerAdvice')->table(), CONF::$LogType_del, '删除'); //操作日志

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
