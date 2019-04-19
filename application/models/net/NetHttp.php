<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class   NetHttp
{
    
	public $timeout = 30;
	public $connect_timeout = 30;
	public $useragent = 'KT-API Client V1.0';

    public $http_code = 0;
    public $http_info = array();

    public function http($url,$params=array(),$method='POST')
    {
        $this->http_code = 0;
		$this->http_info = array();
		$ci = curl_init();
		/* Curl settings */
		curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
		curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ci, CURLOPT_ENCODING, "");
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'get_header'));
		curl_setopt($ci, CURLOPT_HEADER, FALSE);

		$params = http_build_query($params);
		switch ($method) {
			case 'POST':
				curl_setopt($ci, CURLOPT_POST, TRUE);
				if (!empty($params)) {
					curl_setopt($ci, CURLOPT_POSTFIELDS, $params);
					$this->postdata = $params;
				}
				break;
			case 'PUT' : 
				 curl_setopt($ch, CURLOPT_PUT, true);
				if (!empty($params)) {
					$url = strpos('?',$url)===false ? "{$url}?{$params}" : "{$url}&{$params}";
				}
				break;
			case 'DELETE':
				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
				if (!empty($params)) {
					$url = strpos('?',$url)===false ? "{$url}?{$params}" : "{$url}&{$params}";
				}
				break;
			case 'GET':
				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'GET');
				if (!empty($params)) {
					$url = strpos('?',$url)===false ? "{$url}?{$params}" : "{$url}&{$params}";
				}
		}

		$headers[] = "API-ClientIP: " . $_SERVER['REMOTE_ADDR'];
		curl_setopt($ci, CURLOPT_URL, $url );
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
		curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );

		$res = curl_exec($ci);
		$this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
		$this->http_info = array_merge($this->http_info, curl_getinfo($ci));
		$this->url = $url;
		curl_close($ci);
		return $res;	    
    }

    public function get($url,$params=array())
    {
        return $this->http($url,$params,'GET');
    }

    public function post($url,$params=array())
    {
        return $this->http($url,$params,'POST');
    }

    public function code()
    {
        return $this->http_code;
    }

    public function info()
    {
        return $this->http_info;
    }

    public function ping($url)
    {
        $this->http($url);
        return $this->http_code;
    }

	protected function get_header($ci, $header)
    {
		$i = strpos($header, ':');
		if (!empty($i)) {
			$key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
			$value = trim(substr($header, $i + 2));
			$this->http_header[$key] = $value;
		}
		return strlen($header);
	}    
}