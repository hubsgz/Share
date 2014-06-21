<?php

return array(
	
	//路径配置
	'BASE_PATH' => '../Sharecode',    //共享代码根目录
	
	//memcache连接配置
	'MEMCACHE_CONFIG' => array('127.0.0.1', 11211),			//array(ip, 端口)

	//数据库配置
	'DB_CONFIG' => array('127.0.0.1:3306', 'root', '123'),		//array(ip, 端口, 用户名, 密码)

	'ENABLE_CALLSOURCE_LOG' => true,


	'SLOW_TIME' => 3000,  //单位毫秒， 程序执行超过此时间点， 自动记录到 share_slowapi

);