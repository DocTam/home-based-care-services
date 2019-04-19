<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SystemConfig extends MY_Model {

    protected $_table = 'system_config';
    protected $_pk = 'k';
    protected $_cols = 'k,v,dateline';
    public static $_CFG = array();
	
    function __construct() {
        parent::__construct();
        
    }
    
    public function get($k) {
        if (!isset(self::$_CFG[$k])) {
            $row = $this->getone("k='{$k}'");
            if ($row) {
                self::$_CFG[$k] = unserialize(stripslashes($row['v']));
                if ('attach' == $k) {
                    self::$_CFG[$k] = $this->attach(self::$_CFG[$k]);
                } else if ('site' == $k) {
                    self::$_CFG[$k] = $this->site(self::$_CFG[$k]);
                }
            } else {
                self::$_CFG[$k] = null;
            }
        }
        return self::$_CFG[$k];
    }

    public function set($k, $v, $title=null) {
        
        $v = K::M('content/filter')->replace_null($v);
        $a = json_encode($v);
        $data = addslashes(serialize($v));

        $row = $this->getone("k='{$k}'");
        
        if (!$row) {
            $a = $this->insert(array('k' => $k, 'title' => empty($title)?'':$title, 'dateline' => __TIME));
            
        }

        if ($this->update(array('v' => $data, 'dateline' => __TIME), "k='{$k}'")) {
            self::$_CFG[$k] = $v;
            return true;
        }
        return false;
    }
                            
    protected function attach($cfg) {
        if (substr($cfg['dir'], 0, 2) == './') {
            $dir = substr($cfg['dir'], 2);
            $cfg['attachdir'] = FCPATH . $dir . '/';
        }
        if (substr($cfg['url'], 0, 7) != WEB_HTTP) {
            $site = $this->get('site');
            $siteurl = $site['siteurl'];
            if (substr($siteurl, 0, 7) != WEB_HTTP) {
                $siteurl = WEB_HTTP.$siteurl;
            }
            $url = $cfg['url'];
            if (substr($url, 0, 2) == './') {
                $url = substr($url, 2);
            }
            $cfg['attachurl'] = trim($siteurl, '/') . '/' . $url;
        }
        return $cfg;
    }
    
    //统计代码
    function saveTongji($tongji){
        $dir = UPLOAD . "/data";
        K::M('io/dir')->create($dir);
        $tmpfile = $dir . "/tongji.txt";
        if (file_exists($tmpfile)) {
            unlink($tmpfile);
        }
        file_put_contents($tmpfile, $tongji);
    }
    
    function getTongji(){
        $dir = UPLOAD . "/data";
        $tmpfile = $dir . "/tongji.txt";
        if (file_exists($tmpfile)) {
            return file_get_contents($tmpfile);
        }
        return '';
    }
    
    //返回array(code,num)
    function getcode($k, $current){
        $data = $this->get('code');
        $code = $data[$k.'_code'];
        $sort = $data[$k.'_sort'];
        $num = $data[$k.'_num'];//数字个数
        if($current < $sort){
            $current = $sort;
        }
        
        $nownum = $current + 1;
        if(strlen("{$nownum}") >= $num){
            return array($code.$nownum, $nownum);
        }
        $str = "000000000000000000{$nownum}";
        $result = substr($str, strlen($str) - $num);
        return array($code.$result, $nownum);
    }

}
