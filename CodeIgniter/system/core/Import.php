<?php

class Import {

    static public $_GFILES = array();

    static public function I($i) {
        $i = str_replace('.', '/', $i);
        $path = '';
        if ($pos = strpos($i, ':')) {
            $path = substr($i, 0, $pos);
        } 
		return self::_import(APPPATH . "models/{$i}/interface.php");
    }

    static public function E($e) {
        $e = str_replace('.', '/', $e);
        $path = '';
        if ($pos = strpos($e, ':')) {
            $path = substr($e, 0, $pos);
            $e = substr($e, $pos + 1);
        } if (!self::_import(__CORE_DIR . "{$path}models/{$e}/exception.php")) {
            self::_import(__CORE_DIR . "models/{$e}/exception.php");
        }
    }

    static public function M($model) {
        $model = str_replace('.', '/', $model);
        $path = '';
        if ($pos = strpos($model, ':')) {
            $path = substr($model, 0, $pos) . '/';
            $model = substr($model, $pos + 1);
        }

		if (($last_slash = strrpos($model, '/')) !== FALSE){
			$path = substr($model, 0, $last_slash);
			$model = substr($model, $last_slash+1);
		}

		//var_dump( $path);
		$model = ucfirst($model).'Model';
		if ($path == 'plugin/') {
			pr('M');exit;
            //$file = __CORE_DIR . preg_replace("/^([\w\/]+)\/(\w+)$/i", "plugins/\\1/models/\\2.mdl.php", $model);
            //self::_import($file);
            //$model = "plugin/{$model}";
        } else {
            $file = APPPATH . "models/{$path}/{$model}.php";
			//var_dump( $file);exit;
            self::_import($file);
        }
        return $model;
    }

    static public function C($ctl) {
        $ctl = str_replace('.', '/', $ctl);
		var_dump($ctl);
		$path = '';
        if ($pos = strpos($ctl, ':')) {
            $path = substr($ctl, 0, $pos);
			$path = !$path ? '':"{$path}/";
            $ctl = substr($ctl, $pos + 1);
        }
		$file = APPPATH . "controllers/{$path}{$ctl}.ctl.php";
		if (!self::_import($file)) {
            return false;
        } 
		return 'Ctl_' . str_replace(' ', '_', ucwords(str_replace('/', ' ', $ctl)));
    }

    static public function W($w) {
        self::_import(APPPATH . 'plugins/widgets/' . $w . '/widget.php');
        return "Widget_" . ucfirst($w);
    }

    static public function P($plugin) {
        self::_import(APPPATH . "plugins/{$plugin}.php");
        return "Plugin_" . str_replace(' ', '_', ucfirst(str_replace('/', ' ', $plugin)));
    }

    static public function L($lib) {
		if(file_exists(__CORE_DIR . 'libraries/' . $lib.'.mdl.php')){
			self::_import(__CORE_DIR . 'libraries/' . $lib.'.mdl.php');
		} else if(file_exists(BASEPATH . 'libraries/' . $lib.'.mdl.php')){
			self::_import(BASEPATH . 'libraries/' . $lib.'.mdl.php');
		}
         
		$model = 'Mdl_' . str_replace(' ', '_', (ucwords(str_replace('/', ' ', $lib))));
        return $model; 
    }

    static private function _import($file) {
        if (!file_exists($file)) {
            return false;
        } 
		$hash = md5($file);
        if (!isset(self::$_GFILES[$hash])) {
            self::$_GFILES[$hash] = $file;
            require($file);
        } 
		return true;
    }

}

class Using extends Import {
    
}

;
