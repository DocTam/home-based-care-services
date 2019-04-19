<?php
/**
 * Copy Right Anhuike.com
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: cache.mdl.php 72 2013-08-16 11:25:08Z youyi $
 */

if(!defined('BASEPATH')){
    exit("Access Denied");
}
require_once('CacheFile.php');
class Cache
{   
	public $__CACHE = array();
	public $cache = null;

	public function __construct()
	{
		$this->cache = new CacheFile();
	}
    
    public function set($key, $val, $ttl=0)
    {
        $ttl = intval($ttl);
    	return $this->cache->set($key, $val, $ttl);
    }

    public function get($key)
    {
    	return $this->cache->get($key);
    }

    public function delete($key)
    {
    	return $this->cache->delete($key);
    }

    public function flush()
    {
    	return $this->cache->flush();
    }

    public function clean()
    {
        $this->cache->clean();
    }
}