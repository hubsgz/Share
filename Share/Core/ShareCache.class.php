<?php

class ShareCache
{
	static $obj = null;
	static function memcache()
	{
		if (self::$obj == null) {
			$config = ShareConfig();
			$o = new Memcache();
			$re = $o -> connect($config['MEMCACHE_CONFIG'][0], $config['MEMCACHE_CONFIG'][1]);
			//var_dump($re);
			
			//$o->set('aaa|||||fsegesgse|||', time());
			//echo $o->get('aaa|||||fsegesgse|||');
			//exit;
			self::$obj = $o;
		}
		return self::$obj;
	}
	static function get($key) 
	{
		return self::memcache()->get($key);
	}
	static function set($key, $val, $time=0) 
	{
		return self::memcache()->set($key, $val, false, $time);
	}

}