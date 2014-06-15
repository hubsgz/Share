<?php
/**

CREATE TABLE `callsource_log` (
  `id` int(11) NOT NULL auto_increment COMMENT '����',
  `appname` varchar(50) NOT NULL DEFAULT '' COMMENT '��Դ��Ŀ',
  `modulename` varchar(50) NOT NULL DEFAULT '' COMMENT '��Դģ��',  
  `actionname` varchar(50) NOT NULL DEFAULT '' COMMENT '��Դaction',
  `apiname` varchar(50) NOT NULL DEFAULT '' COMMENT '�����õ�api',
  `calltime` int(11) default 0 COMMENT '����ʱ��',  
  PRIMARY KEY  (`id`),
  KEY `apiname` (`apiname`)      
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=gbk COMMENT='������Դ��־��';

*/

class ShareCallSource
{
	static function insert($appName, $moduleName, $actionName, $apiName)
	{
		$insertdata = array(
			'appname' => $appName,
			'modulename' => $moduleName,
			'actionName' => $actionName,
			'apiname' => $apiName,
			'calltime' => time()			
		);
		
		echo '$insertdata => ';
		print_r($insertdata);
		
		$sql = ShareMysql::insertSql('sharedb.callsource_log', $insertdata); 
		return ShareMysql::execSql($sql);
	}

}