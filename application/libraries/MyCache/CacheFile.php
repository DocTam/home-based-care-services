<?php
/**
 * Copy Right Anhuike.com
 * Each engineer has a duty to keep the code elegant
 * Author shzhrui<anhuike@gmail.com>
 * $Id: file.mdl.php 72 2013-08-16 11:25:08Z youyi $
 */

if(!defined('BASEPATH')){
    exit("Access Denied");
}

require_once('interface.php');
class CacheFile implements Cache_Interface
{

	public function __construct()
	{
		$this->cache_dir = FCPATH.'data/cache/';
	}

	public function set($key, $val, $ttl=0)
	{
		$time = $ttl==0 ? 0 : (__TIME + $ttl);
		$hash = md5($key);
		$data[] = '<?php exit("Access Denied");?>';
		$data[] = "note:System cache file, DO NOT modify me!";
		$data[] = "hash:{$hash}:{$key}";
		$data[] = "time:$time";
		$data[] = "data:".serialize($val);
		file_put_contents($this->cache_dir."cache_{$hash}.php", implode("\n",$data));
	}

	public function get($key)
	{
		$file = $this->cache_dir.'cache_'.md5($key).'.php';
		if(file_exists($file)){
			$data = file($file);
			$time = substr($data[3],5);
			if(($time == 0) || (__TIME<$time)){
				return unserialize(substr($data[4],5));
			}
		}
		return false;
	}

	public function delete($key)
	{
		K::L('io/file')->remove($this->cache_dir.'cache_'.md5($key).'.php');
	}

	public function flush()
	{
		$this->clean();
	}

	public function clean()
	{
		$handler = dir($this->cache_dir);
		while (false !== ($file = $handler->read())) {
			if('.' == $file || '..' == $file){
				continue;
			}
			@unlink($this->cache_dir.$file);
		}
		$handler->close();
		return true;
	}
	
}