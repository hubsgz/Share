<?php

define('SHARE_PATH', dirname(__FILE__));
require_once SHARE_PATH . '/Core/' . 'functions.php';
importRequireClass();
date_default_timezone_set('Asia/Shanghai');

class Share
{
	static function core()
	{
		static $obj = null;
		if ($obj == null) {
			$obj = new ShareCore();
		}
		return $obj;
	}

	static function module($moduleName)
	{
		$core = self::core();
		$core -> setCallModule($moduleName);

		return $core;
	}
}



