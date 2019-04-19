<?php

class App extends CI_Controller {

    public $request = array();
    protected $other_where = '';
    protected $must_where = '';

    public function __construct() {

        $this->_client_ip();
        parent::__construct();

        K::M('CONF');

        $this->pagedata['request'] = $this->request;

        $attch = K::M('system/config')->get('attach'); //配置数据
        define('ATTACHURL', trim($attch['attachurl'], '/'));
        define('ATTACHDIR', trim($attch['attachdir'], '/'));

        if (!$this->isajax()) {
            $max_record_id = 0;
            //获取sos最后一条记录  sos.php 里有做处理.  如果其他页面也需要,则统一这里处理
            //$lastone = K::M('api/healthdata')->getone("datatype='sos' ORDER BY data_id DESC", 'data_id');
            //if (!empty($lastone)) {
            //$max_record_id = $lastone['data_id'];
            //}
            $this->pagedata['max_record_id'] = $max_record_id;

            if (METHOD == 'edit') {
                $this->pagedata['frompage'] = $_SERVER['HTTP_REFERER'];
            }
        }
    }

    function isajax() {
        return $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    function check_admin_login() {
        K::M('admin/auth')->token();
        if (METHOD != 'login') {
            if (!K::M('admin/auth')->admin_id) {
                if ($this->isajax()) {
                    $this->pagedata['outType'] = 'json';
                    $this->pagedata['data'] = array('Success' => false, 'Msg' => '请重新登录!');
                    $this->output();
                    exit();
                }
                $this->tmpl = 'login/login.html';
                $this->output();
                exit();
            }
            //设置上传图片的session
            $_SESSION['ALLOW_UPLOAD'] = true;

            define('ADMIN_ID', K::M('admin/auth')->admin_id);

            $admin_id = ADMIN_ID;
            if (SUPER_ADMIN_ID != ADMIN_ID) {
                $this->other_where = " AND admin_id = {$admin_id}";
            }
            $this->must_where = " AND admin_id = {$admin_id}";
        }
        return true;
    }

    function checkpost() {
        $a = $this->input->post();
        if (!empty($a)) {
            return true;
        }
        return false;
    }

    function checksubmit() {

        return $this->checkpost();
    }

    protected function check_fields($data, $fields) {
        if (!is_array($fields)) {
            $fields = explode(',', $fields);
        }
        foreach ((array) $data as $k => $v) {
            if (!in_array($k, $fields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }

    public function GP($p) {
        $v = $this->input->post($p);
        $v = $v ? $v : $this->input->get($p);
        return $v;
    }

    function getPager($page, $count, $pagenum, $SO = null) {
        $pager['page'] = $page;
        $pager['count'] = $count;
        $pager['pagenum'] = $pagenum;
        $pager['prepage'] = $page > 1 ? ($page - 1) : 1;
        $pager['nextpage'] = $page >= $pagenum ? ($page ) : ($page + 1);
        $pager['query_url'] = $this->getQueryUrl($SO);

        return $pager;
    }

    function getQueryUrl($query) {
        $q = $_SERVER['QUERY_STRING'];
        parse_str($q, $output);

        unset($output['page']); //取消page

        if ($query) {
            $output = array_merge($output, $query);
        }
        $query = http_build_query($output);

        return $query;
    }

    function makeQuery($SO) {
        if (empty($SO)) {
            return '';
        }
        return http_build_query($SO);
    }

    function makeQueryUrl($SO, $page = 1) {
        if (empty($SO)) {
            return "page={$page}";
        }
        return http_build_query($SO) . "&page={$page}";
    }

    protected function __upload($from = 'photo', $thumb = false) {
        $photos = array();
        if ($_FILES['data']) {

            $attachs = array();
            foreach ($_FILES['data'] as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $attachs[$kk][$k] = $vv;
                }
            }
            //$upload = K::M('magic/upload');
            foreach ($attachs as $k => $attach) {
                //if ($attach['error'] == UPLOAD_ERR_OK) {
                if ($p = $this->__uploadOne($attach, $from, $thumb)) {
                    $photos[$k] = $p;
                }
                //if ($a = $upload->upload($attach, $from)) {
                //$photos[$k] = $a['photo'];
                //}
                //}
            }
        }
        return $photos;
    }

    //图片, 路径, 是否需要缩略图
    //返回图片路径
    public function __uploadOne($attach, $from = 'attach', $thumb = false) {
        if (UPLOAD_ERR_OK != $attach['error']) {
            return false;
        }
        if ($a = K::M('magic/upload')->upload($attach, $from, $thumb)) {
            return $a['photo'];
        }
        return false;
    }

    public function output($return = false) {
        if (isset($this->pagedata['outType'])) {
            switch ($this->pagedata['outType']) {
                case 'json':
                    $this->outJson();
                    break;
                case 'no':
                    break;
            }

            return;
        }
        if (empty($this->tmpl)) {
            return;
        }
        ob_clean();

        $pre = defined('PREFIX') ? rtrim(PREFIX, '/') . '/' : '';
        $file = $pre . $this->tmpl;
        $data = $this->pagedata;
        if ($return) {
            return $this->load->view($file, $data, TRUE);
        }
        $this->load->view($file, $data);
        $OUT = & load_class('Output', 'core');
        $OUT->_display();
    }

    function outJson() {

        echo json_encode($this->pagedata['data'], JSON_UNESCAPED_UNICODE);
    }

    public function shutdown() {
        debug();
    }

    protected function _client_ip() {
        if (!defined('__IP')) {
            $ip = '';
            if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
                foreach ($matches[0] AS $xip) {
                    if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                        $ip = $xip;
                        break;
                    }
                }
            }
            if (!$ip) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            define('__IP', $ip);
        }
        return __IP;
    }

    public function redirect($url) {
        header("location:{$url}");
        exit();
    }

    function http_post($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $o = "";
        foreach ($data as $k => $v) {
            if ($k == 'destMobiles') {
                $o .= "$k=" . $v . "&";
            } else {
                $o .= "$k=" . urlencode($v) . "&";
            }
        }
        $post_data = substr($o, 0, -1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $response = curl_exec($ch);
        //$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $response;
    }

    function http_get($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

}
