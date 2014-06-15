<?php

class ShareCache
{
	static $obj = null;
	static function memcache()
	{
		if (self::$obj == null) {
			$config = ShareConfig();
			$memcache = new Memcached();
			$memcahce -> connect($config['MEMCACHE_CONFIG'][0], $config['MEMCACHE_CONFIG'][1]);
			self::$obj = $memcahce;
		}
		return self::$obj;
	}
	static function get($key) 
	{
		self::memcache()->get($key);
	}
	static function set($key, $val) 
	{
		self::memcache()->set($key, $val);
	}

}