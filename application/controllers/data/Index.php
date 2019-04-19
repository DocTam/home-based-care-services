<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends App {

    public function __construct() {
        parent::__construct();
    }

    public function test() {
        echo 'test';
        exit;
    }

    public function index() {
        $data = (array) $_POST;
        if (empty($data)) {
            $data = (array) $_GET;
            if (empty($data)) {
                echo '1';
                exit;
            }
        }

        $imei = K::M('share')->replace_null($data['imei']);
        
        if(empty($imei)){
            $imei = K::M('share')->replace_null($data['deviceid']);
            if(empty($imei)){
                echo '1';exit;
            }
        }

        $datatype = $this->checkdata($data);
        
        $otherdata = K::M('content/Filter')->replace_all_null($data);
        $result = array(
            'imei' => $imei,
            'datatype' => $datatype,
            'content' => json_encode($otherdata, JSON_UNESCAPED_UNICODE),
            'ip' => __IP,
        );
        K::M('api/apidata')->add($result);
        
        $one = K::M('member/memberDevice')->getone("imei='{$imei}'");

        $member = array();
        if (!empty($one)) {
            $member = K::M('member/member')->getone("member_id={$one['member_id']}");
        }

        $result = array(
            'member_id' => $member['member_id'],
            'name' => $member['name'],
            'mobile' => $member['mobile'],
            'datatype' => $datatype,
            'status' => 0,
        );
        $result = array_merge($result, $data);//合并数据
        
        $id = K::M('api/healthdata')->add($result);
        if($id>0){
            echo '';exit;
        }
        echo '1';exit;
         
    }
 
    //检查数据类型 
    function checkdata($data) {
        if ($this->islocation($data)) {
            return 'location';
        }
        if ($this->issos($data)) {
            return 'sos';
        }
        if ($this->isheart($data)) {
            return 'heart';
        }
        if ($this->isrun($data)) {
            return 'run';
        }
        if ($this->issleep($data)) {
            return 'sleep';
        }
        if ($this->ispower($data)) {
            return 'power';
        }
        if ($this->isbp($data)) {//血压
            return 'bp';
        }
        if ($this->isfall($data)) {//跌倒
            return 'fall';
        }
        return '';
    }

    //定位
    function islocation($data) {
        if (isset($data['is_reply']) &&
                isset($data['is_track']) &&
                isset($data['city'])) {
            return true;
        }
        return false;
    }

    function issos($data) {
        if (isset($data['heartrate']) &&
                isset($data['lon']) &&
                isset($data['lat']) &&
                isset($data['city'])) {
            return true;
        }
        return false;
    }

    function isheart($data) {
        if (isset($data['heartrate']) &&
                isset($data['theshold_heartrate_h']) &&
                isset($data['theshold_heartrate_l'])) {
            return true;
        }
        return false;
    }

    function isrun($data) {
        if (isset($data['value']) &&
                count($data) <= 4) {
            return true;
        }
        return false;
    }

    function issleep($data) {
        if (isset($data['total']) &&
                isset($data['time_end']) &&
                isset($data['interval'])) {
            return true;
        }
        return false;
    }

    function ispower($data) {
        if (isset($data['remaining_power'])) {
            return true;
        }
        return false;
    }

    function isbp($data) {
        if (isset($data['dbp']) &&
                isset($data['sbp'])) {
            return true;
        }
        return false;
    }

    function isfall($data) {
        if (isset($data['city']) &&
                isset($data['address']) &&
                isset($data['lat']) &&
                isset($data['lon']) && count($data) == 7) {
            return true;
        }
        return false;
    }

}
