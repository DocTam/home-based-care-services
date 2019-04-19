<?php

class Student extends App {

	protected $code = '';

    public function __construct() {
        parent::__construct();
        $this->check_admin_login();

		$this->code = K::M('worker/workerType')->getcode('teacher');
        $this->pagedata['pagecode'] = 'teacher';
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

                case 'name':
                    $filter['name'] = "LIKE:%" . $word . "%";
                    break;
                case 'mobi':
                    $filter['mobile'] = "LIKE:%" . $word . "%";
                    break;
                default :
                    $filter['1']['OR']['name'] = "LIKE:%" . $word . "%";
                    $filter['1']['OR']['mobile'] = "LIKE:%" . $word . "%";
            }
            $SO['word'] = $word;
            $SO['select'] = $select;
        }

        $order = array(
            'student_id' => 'DESC',
        );

        $pagenum = 1;
        if ($items = K::M('student/student')->items($filter, $order, $page, $limit, $count)) {
            $pagenum = ceil($count / $limit);
        }

        $courses = $this->getcourseteacher();
        $this->pagedata['courses'] = $courses;

        $this->pagedata['SO'] = $SO;
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $this->getPager($page, $count, $pagenum, $SO);

        $this->tmpl = 'student/list.html';
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
                $this->pagedata['data'] = array('Success' => false, 'Msg' => '请填写学员姓名!',);
                return;
            }
            $student_id = intval($data['id']);

            if ($data['addtime'] != '') {
                $data['addtime'] = strtotime($data['addtime']);
            }

            if ($student_id > 0) {//修改
                $detail = K::M('student/student')->getone("student_id={$student_id}");
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

                K::M('student/student')->update($data, "student_id={$student_id}");
                $this->pagedata['data'] = array(
                    'Success' => true,
                    'Msg' => '保存成功!',
                    'student_id' => $student_id,
                );

                K::M('OptLog')->addlog($student_id, K::M('student/student')->table(), CONF::$LogType_edit, $data); //操作日志

                return;
            } else {//新增
                $data['status'] = 1; //新增的有效
                $data['admin_id'] = ADMIN_ID;

                if ($student_id = K::M('student/student')->add($data)) {

                    K::M('OptLog')->addlog($student_id, K::M('student/student')->table(), CONF::$LogType_add, $data); //操作日志

                    $this->pagedata['data'] = array(
                        'Success' => true,
                        'Msg' => '保存成功!',
                        'student_id' => $student_id,
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

    //任课老师
    function getcourseteacher($admin_id) {
        $where = '1';
        if($admin_id>0){
            $where = "admin_id = {$admin_id}";
        }
        $option = array(
            'where' => $where,
        );
        $courses_res = K::M('course/course')->getlist($option);
        if (empty($courses_res)) {
            return null;
        }
        $ids = array();
        foreach ($courses_res as $k => $v) {
            $ids[] = $v['worker_id'];
        }

        $ids = implode(',', $ids);
        $option = array(
            'where' => "worker_id in ({$ids}) AND code='{$this->code}'  AND {$where}",
        );
        $teacher_res = K::M('worker/worker')->getlist($option);
        $teachers = array();
        foreach ($teacher_res as $k => $v) {
            $teachers[$v['worker_id']] = $v['name'];
        }

        $result = array();
        foreach ($courses_res as $k => $v) {
            $result[$v['course_id']] = array('course' => $v['name'], 'teacher' => $teachers[$v['worker_id']]);
        }
        return $result;
    }

    public function add() {

        $courses = $this->getcourseteacher(ADMIN_ID);

        $this->pagedata['courses'] = $courses;

        $this->tmpl = 'student/edit.html';
    }

    public function edit() {
        $student_id = intval($this->GP('id'));

        $detail = K::M('student/student')->getone("student_id={$student_id}");
        if (empty($detail)) {
            K::M('helper/error')->showmsg('操作错误!');
            return;
        }

        $courses = $this->getcourseteacher($detail['admin_id']);
        $this->pagedata['courses'] = $courses;

        $this->pagedata['id'] = $student_id;
        $this->pagedata['info'] = $detail;
		
        $this->tmpl = 'student/edit.html';
    }

    public function delone() {
        $student_id = intval($this->GP('id'));
        $this->pagedata['outType'] = 'json';

        if (K::M('student/student')->del("student_id={$student_id} {$this->other_where}")) {

            K::M('OptLog')->addlog($student_id, K::M('student/student')->table(), CONF::$LogType_del, '删除'); //操作日志

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
