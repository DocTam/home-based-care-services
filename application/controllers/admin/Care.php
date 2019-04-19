<?php

class care extends App {
    
    protected $code = '';

    public function __construct() {
        parent::__construct();
        $this->check_admin_login();

		$this->code = K::M('worker/workerType')->getcode('care');
        $this->pagedata['pagecode'] = 'care';
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
        
        $filter['code'] = $this->code;

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
            'worker_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('worker/worker')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'care/care.html';
    }

}
