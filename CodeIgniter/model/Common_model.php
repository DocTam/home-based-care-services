<?php

/**
 * 公共model
 */
require_once(BASEPATH . 'core' . DIRECTORY_SEPARATOR . 'Model.php');

class Common_model extends CI_model {

    function __construct() {
        parent::__construct();
    }
 
 

    function GetIP() {
        $ip = "";
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
            $ip = getenv("REMOTE_ADDR");
        } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if ($ip !== '') {
            $p = '/^(((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))\.){3}((1?\d{1,2})|(2[0-4]\d)|(25[0-5]))$/';
            if (preg_match($p, $ip)) {
                return $ip;
            }
            $ip = "";
        }

        return $ip;
    }

    function fopen_url($url) {
        if (function_exists('file_get_contents')) {
            $file_content = @file_get_contents($url);
        } elseif (ini_get('allow_url_fopen') && ($file = @fopen($url, 'rb'))) {
            $i = 0;
            while (!feof($file) && $i++ < 1000) {
                $file_content .= strtolower(fread($file, 4096));
            }
            fclose($file);
        } elseif (function_exists('curl_init')) {
            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $url);
            curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_FAILONERROR, 1);
            curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Trackback Spam Check'); //引用垃圾邮件检查
            $file_content = curl_exec($curl_handle);
            curl_close($curl_handle);
        } else {
            $file_content = '';
        }
        return $file_content;
    }

    //保存文件
    function save($file, $content) {
        $fp = fopen($file, 'wb+');
        fwrite($fp, $content);
        fclose($fp);
    }

    function mkdirs($dir) {
        $this->_mkdirs($dir);
    }

    /**
     * 建立多级目录
     */
    function _mkdirs($dir, $mode = 0777) {
        is_dir(dirname($dir)) || $this->_mkdirs(dirname($dir), $mode);
        return is_dir($dir) || @mkdir($dir, $mode);
    }

    /**
     * 过滤非法字符 ' " / \ < >
     */
    function replace_null($str) {
        $arr = array('"', "'", '\\', '<', '>');
        return str_replace($arr, '', trim($str));
    }

    function replace_null2($str) {
        $arr = array("'", '\\', '<', '>');
        return str_replace($arr, '', trim($str));
    }

    /**
     * 替换 ' " / \ < >
     */
    function replace_html($str) {
        $arr1 = array('"', '<', '>', '\\', "'");
        $arr2 = array('&quot;', '&lt;', '&gt;', '\\\\', '&#39;');
        return str_replace($arr1, $arr2, trim($str));
    }

    /**
     * 替换 script
     */
    function replace_script($str) {
        $str = str_ireplace(array('<script', '</script'), array('&lt;script', '&lt;/script'), $str);
        return $str;
    }

    //用来设置 是否是从 登录页面登录的
    function setRealLogin($key) {
        $this->setsession($key, array(
            'IP' => $this->GetIP(),
            'login' => true,
        ));
    }

    //用来设置 是否是从 登录页面登录的
    function checkRealLogin($key) {
        $sess = $this->getsession($key);
        if (empty($sess) || $sess['IP'] != $this->GetIP()) {
            return false;
        }
        return true;
    }

    //用来设置 是否是从 登录页面登录的
    function delRealLogin($key) {
        $this->share->delsession($key);
    }
     

    function set_cookie($key, $value, $expire = 86400) {
        setcookie("llss_{$key}", serialize($value), time() + $expire);
        return false;
    }

    function get_cookie($key) {
        return isset($_COOKIE['llss_' . $key]) ? unserialize($_COOKIE['llss_' . $key]) : '';
    }

    function del_cookie($key) {
        setcookie("llss_{$key}", '', time() - 3600);
        return true;
    }

    function goto_url($url, $top = false, $msg = '') {
        if ($top) {
            echo "{$msg} 
				<script>top.location.href='{$url}';</script>
			";
        } else {
            echo "{$msg} 
				<script>location.href='{$url}';</script>
			";
        }
        exit;
    }

    function delsession($key) {
        $_SESSION['llss_' . $key] = null;
        return true;
    }

    function alert($msg = '', $url = '') {
        if ($url) {
            echo "
			<script>alert('{$msg}'); location.href='{$url}';</script>
			";
        } else {
            echo "
			<script>alert('{$msg}'); history.go(-1);</script>
			";
        }
    }

    function getsession($key) {
        return isset($_SESSION['llss_' . $key]) ? $_SESSION['llss_' . $key] : '';
    }

    function setsession($key, $value) {
        $_SESSION['llss_' . $key] = $value;
        return true;
    }
 

    function session($status = true) {
        if ($status) {
            session_start();
        }
        return true;
    }

    function checkCode($code) {
        if (md5($code) != $this->getsession('codeV')) {
            return false;
        }
        return true;
    }

    //验证手机号码
    function checkMobile($phone) {

        return preg_match('/^1[345789]\d{9}$/', $phone);
    }
 
        
}

?>