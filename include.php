<?php

define('__TIME', time());

$fc_path = rtrim(str_replace("\\", "/", dirname(__FILE__)), '/\\');

define('FCPATH', $fc_path . '/'); // 程序目录 E:/Znizao/shenghuopindao/
//这里设置自定义路由器
//require('router.php');
//$myRTR = new MY_Router();
//admin.php?g=index&c=index&a=index&id=1

$g = isset($_GET['g']) ? $_GET['g'] : ( isset($_GET['G']) ? $_GET['G'] : '' );
if (!empty($g) && preg_match('/^[a-zA-Z]{1,20}$/', $g)) {
    $routing['directory'] = PREFIX . '/' . $g;
} else {
    $routing['directory'] = PREFIX;
}

//$routing['controller'] = $myRTR->class;
//$routing['function'] = $myRTR->method;
require("common.inc.php");

require("./CodeIgniter/include.php");

