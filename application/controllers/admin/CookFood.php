<?php

class CookFood extends App {

    protected $code = '';

    public function __construct() {
        parent::__construct();
        $this->check_admin_login();

        $this->code = K::M('worker/workerType')->getcode('cook');
        $this->pagedata['pagecode'] = 'cook';
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
        
        $word = K::M('share')->replace_null(trim($this->GP('word')));
        $begin = strtotime($word);
        $end = $begin + 86400;
        if ($begin) {
            $select = $this->GP('select');
            
            $filter[1]['AND']['dateline'] = ">:{$begin}";
            $filter[2]['AND']['dateline'] = "<:{$end}";
            
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'food_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('cook/cookFood')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $this->pagedata['dining_times'] = K::M('cook/cookFood')->dining_times();

        $menus = K::M('cook/cookMenu')->getnames("1 {$this->other_where} ");
        $this->pagedata['menus'] = $menus;

        $cooks = K::M('worker/worker')->getnames("code='{$this->code}' {$this->other_where}");
        $this->pagedata['cooks'] = $cooks;

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'cook/cook_food.html';
    }

    function save() {
        $this->pagedata['outType'] = 'json';
        if ($this->checksubmit()) {
            $data = (array) $_POST;

            if (empty($data)) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '提交失败!',);
                return;
            }
            if (empty($data['dining_time'])) {
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请选择就餐时段!',);
                return;
            }
            $food_id = intval($data['id']);

            if ($food_id > 0) {//修改
                $detail = K::M('cook/cookFood')->getone("food_id={$food_id}");
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

                K::M('cook/cookFood')->update($data, "food_id={$food_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'food_id' => $food_id,
                );

                K::M('OptLog')->addlog($food_id, K::M('cook/cookFood')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($food_id = K::M('cook/cookFood')->add($data)) {

                    K::M('OptLog')->addlog($food_id, K::M('cook/cookFood')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'food_id' => $food_id,
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
        $option = array(
            'where' => "1  {$this->must_where}",
        );
        $menus = K::M('cook/cookMenu')->getlist($option);
        $this->pagedata['menus'] = $menus;

        $this->pagedata['dining_times'] = K::M('cook/cookFood')->dining_times();

        $cooks = K::M('worker/worker')->getnames("code='{$this->code}'  {$this->must_where}");
        $this->pagedata['cooks'] = $cooks;


        $this->tmpl = 'cook/cook_food_edit.html';
    }

    public function edit() {
        $food_id = intval($this->GP('id'));

        $detail = K::M('cook/cookFood')->getone("food_id={$food_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $option = array(
            'where' => "1  AND admin_id={$detail['admin_id']}",
        );
        $menus = K::M('cook/cookMenu')->getlist($option);
        $this->pagedata['menus'] = $menus;

        $this->pagedata['dining_times'] = K::M('cook/cookFood')->dining_times();

        $cooks = K::M('worker/worker')->getnames("code='{$this->code}' AND admin_id={$detail['admin_id']}");
        $this->pagedata['cooks'] = $cooks;

        $this->pagedata['id'] = $food_id;
        $this->pagedata['info'] = $detail;
		
        $this->tmpl = 'cook/cook_food_edit.html';
    }

    public function delone() {
        $food_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('cook/cookFood')->del("food_id={$food_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($food_id, K::M('cook/cookFood')->table(), CONF::$LogType_del, '删除'); //操作日志

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
