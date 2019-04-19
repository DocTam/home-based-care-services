<?php

interface Cache_Interface
{
	public function set($key, $val, $ttl=0);

	public function get($key);

	public function delete($key);

	public function flush();

	//public function update();
}