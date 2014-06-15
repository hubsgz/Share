<?php

return array(
	
	//路径配置
	'BASE_PATH' => '../Sharecode',    //共享代码根目录
	
	//memcache连接配置
	'MEMCACHE_CONFIG' => array('127.0.0.1', 9999),			//array(ip, 端口)

	//数据库配置
	'DB_CONFIG' => array('127.0.0.1', 91, 'root', ''),		//array(ip, 端口, 用户名, 密码)

	'ENABLE_CALLSOURCE_LOG' => false

);