<?php

class ShareCache
{
	static $obj = null;
	static function memcache()
	{
		if (self::$obj == null) {
			$config = ShareConfig();
			$memcache = new Memcached();
			$memcache -> connect($config['MEMCACHE_CONFIG'][0], $config['MEMCACHE_CONFIG'][1]);
			self::$obj = $memcache;
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