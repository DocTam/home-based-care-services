<?php

class Cookie
{
	public $_COOKIE;
	public $GUID = null;

	public function __construct()
	{
		$this->Instance();
	}
	
	public function Instance()
	{
		$_clen = strlen(C_PREFIX);
		foreach($_COOKIE as $k => $v) {
			if(substr($k, 0, $_clen) == C_PREFIX) {
				$this->_COOKIE[(substr($k, $_clen))] = addslashes($v);
			}
		}
		if(!$this->GUID = $this->_COOKIE['GUID']){
			$this->GUID = 'KT-'.K::GUID('cookie');
			$this->set('GUID',$this->GUID);
		}
	}

	public function set($key, $value, $life=NULL, $prefix = '')
	{
		$prefix = $prefix ? $prefix : C_PREFIX;
		if($life === NULL){ //默认30天过期
			$life = __TIME + C_EXPIRE;
		}else{
			$life = $life ? ($life + __TIME) : 0;
		}
		$https = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
		$httponly = C_HTTPONLY ;
		$cookiepath = C_PATH;
		
		$domain = C_DOMAIN;

		if(PHP_VERSION < '5.2.0') {
			setcookie($prefix.$key, $value, $life, $cookiepath, $domain, $https);
		} else {
			setcookie($prefix.$key, $value, $life, $cookiepath, $domain, $https, $httponly);
		}


		$this->_COOKIE[$key] = $value;		
	}

	public function get($key)
	{
		return $this->_COOKIE[$key];
	}

	public function delete($key)
	{
		$this->set($key, '', -86400);
	}

	public function clear()
	{
		foreach($this->_COOKIE as $k=>$v){
			$this->set($k, '', -86400);
		}
	}

	public function update()
	{
	
	}
	
	public function fetch_all()
	{
		return $this->_COOKIE;
	}
}