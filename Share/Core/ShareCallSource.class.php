<?php
/**

drop table if exists `share_callsource`;
CREATE TABLE `share_callsource` (
  `id` int(11) NOT NULL auto_increment COMMENT '主键',
  `appname` varchar(50) NOT NULL DEFAULT '' COMMENT '来源项目',
  `modulename` varchar(50) NOT NULL DEFAULT '' COMMENT '来源模块',  
  `actionname` varchar(50) NOT NULL DEFAULT '' COMMENT '来源action',
  `apiname` varchar(50) NOT NULL DEFAULT '' COMMENT '所调用的api',
  `args` varchar(50) NOT NULL DEFAULT '' COMMENT '调用参数',
  `calltime` int(11) default 0 COMMENT '调用时间',  
  `spendtime` float(7,4) default 0 COMMENT '运行时间',    
  PRIMARY KEY  (`id`),
  KEY `apiname` (`apiname`)      
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=gbk COMMENT='调用来源日志表';

*/

class ShareCallSource
{
	static function insert($appName, $moduleName, $actionName, $apiName, $args, $spendtime)
	{
		$insertdata = array(
			'appname' => $appName,
			'modulename' => $moduleName,
			'actionName' => $actionName,
			'apiname' => $apiName,
			'args' => $args,
			'spendtime' => $spendtime,
			'calltime' => time()			
		);
		
		echo '$insertdata => ';
		print_r($insertdata);
		
		$sql = ShareMysql::insertSql('sharedb.callsource_log', $insertdata); 
		return ShareMysql::execSql($sql);
	}

}