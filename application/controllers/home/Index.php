<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends App {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->pagedata['pagemenu'] = 'index';
        

        $this->tmpl = 'index.html';
    }
    
    function getpwdmd5(){
        $pwd = $this->GP('pwd');
        echo K::M('admin/auth')->getPwdMd5($pwd);
        exit;
    }
    
    function gpstobaidu(){
        $coords = $this->GP('coords');
        
        $url = "http://api.map.baidu.com/geoconv/v1/?coords={$coords}&from=3&to=5&ak=bTo1dN47NP1gEvFgReoaYWWh9wxrXGOX";
         
        $result = $this->http_get($url);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        exit;
    }
 

}
