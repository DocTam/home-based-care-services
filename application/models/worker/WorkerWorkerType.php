<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class WorkerWorkerType extends MY_Model {

    protected $_table = 'workerType';  
    protected $_pk = 'type_id';
    protected $fields = array();
    
    protected static $typecodes = array(
        'lawyer' => array('code' => 'LVS','type' => '律师','module' => '法律援助'),
        'teacher' => array('code' =>'JIS', 'type' =>'教师','module' => '老年大学'),
        'medical' => array('code' =>'BJYS', 'type' =>'保健医生', 'module' =>'医疗保健'),
        'psychology' => array('code' =>'XLZX', 'type' =>'心理咨询师', 'module' =>'心理关爱'),
        'health' => array('code' =>'JKZX','type' => '健康咨询师','module' => '健康咨询'),
        'care' => array('code' =>'HLS','type' => '护理师','module' => '日间照料'),
        'volunteer' => array('code' =>'ZYZ','type' => '志愿者','module' => '志愿者'),
        'cleaner' => array('code' =>'BJRY','type' => '保洁人员' ,'module' => '保洁卫生'),
        'cook' => array('code' =>'CHS','type' => '厨师','module' => '营养餐厅'),
        'house' => array('code' =>'JZFW','type' => '家政服务员','module' => '家政服务'),
        'culture' => array('code' =>'YST','type' => '艺术团员','module' => '文化娱乐'),
        'travel' => array('code' =>'LYGL','type' => '旅游','module' => '旅游旅居'),
        'veteran' => array('code' =>'TWJR','type' => '退伍军人','module' => '退伍军人'),
        'disabled' => array('code' =>'CJR','type' => '残疾人','module' => '残疾人'),
        'difficulty' => array('code' =>'TKFW','type' => '特困服务','module' => '特困服务'),
       
        
    );

    function getcode($page) {
        return self::$typecodes[$page]['code'];
    }

    function frompage($from, $admin_id=0) {
        if (empty($from)) {
            return array();
        }
        $code = $this->getcode($from);
        $one = $this->getone("code='{$code}' AND admin_id={$admin_id}");
        return array(
            'from'=>$from,
            'id' => $one['type_id'] ,
            'type' => self::$typecodes[$from]['type'] , 
            'module' =>self::$typecodes[$from]['module'] , 
        );
    }
    
    function gettypecodes() {
        
        return self::$typecodes;
    }
            
    function update($data, $where){
        unset($data[$this->_pk]);
        $data = $this->_check_field($data);
        if(empty($data)){
            return FALSE;
        }        
        return parent::update($data, $where);
    }
    
    function add($data){
        unset($data[$this->_pk]);
        $data = $this->_check_field($data);
        if(empty($data)){
            return FALSE;
        }
        $data['dateline'] = __TIME;
        return parent::add($data);
    }
            
    
}
