<?php

return array(
	
	//·������
	'BASE_PATH' => '../Sharecode',    //��������Ŀ¼
	
	//memcache��������
	'MEMCACHE_CONFIG' => array('127.0.0.1', 11211),			//array(ip, �˿�)

	//���ݿ�����
	'DB_CONFIG' => array('127.0.0.1:3306', 'root', '123'),		//array(ip, �˿�, �û���, ����)

	'ENABLE_CALLSOURCE_LOG' => true,


	'SLOW_TIME' => 3000,  //��λ���룬 ����ִ�г�����ʱ��㣬 �Զ���¼�� share_slowapi

);