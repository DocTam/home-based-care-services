<?php

class K {

    public static $system = null;
	public static $_Models = array();
	public static $_Libs = array();
	public static $_Widgets = array();
	
	//system/config  system/SystemConfig.php  class SystemConfig
    public static function &M($model) {
		$name = str_replace('/','_',strtolower($model));
		if (isset(self::$_Models[$name])){
			return self::$_Models[$name];
		}
        $CI = get_instance();
		$CI->load->model($model,$name);
		self::$_Models[$name] = &$CI->$name;
        return $CI->$name;
    }

    public static function &L($lib) {
		
		if (($last_slash = strrpos($lib, '/')) !== FALSE)
		{
			$name = strtolower(substr($lib, $last_slash+1));
		} else {
			$name = strtolower($lib);
		}
		if (isset(self::$_Libs[$name])){
			return self::$_Libs[$name];
		}
        $CI = &get_instance();
		$CI->load->library($lib);
		self::$_Libs[$name] = &$CI->$name;
        return $CI->$name;
    }

    public static function C($ctl) {
        
    }

    public static function &W($wgt) {
        if (isset(self::$_Widgets[$wgt])){
			return self::$_Widgets[$wgt];
		}
		$wgt = Import::W($wgt);
        $obj = new $wgt($this);
        $obj->__MDL = $wgt;
        self::$_Widgets[$wgt] = &$obj;
        return $obj;
    }

    //public static function DB($db = null) {
        //return K::$system->LoadDB($db);
    //}

    public static function IDS($ids) {
        if (is_array($ids)) {
            $ids = implode("','", $ids);
        } else if (strpos($ids, "'") === false) {
            $ids = str_replace(',', "','", trim($ids, ','));
        } else {
            return trim($ids, ',');
        } return "'{$ids}'";
    }

    public static function GUID($key = '') {
        return strtoupper(md5(uniqid(mt_rand(), true) . $key));
    }

    public static function IS_GUID($guid) {
        return preg_match("/[0-9A-F]{32}/", $guid);
    }

}

function GUID($key = '') {
    $charid = strtoupper(md5(uniqid(mt_rand(), true) . $key));
    $hyphen = chr(45);
    $GUID = substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
    return $GUID;
}
