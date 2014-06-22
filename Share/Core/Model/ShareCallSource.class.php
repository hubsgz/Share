<?php
/**
调用来源模型
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
		
		$sql = ShareMysqlTool::insertSql('sharedb.callsource_log', $insertdata); 
		return ShareMysql::execSql($sql);
	}
	
	static function getAll($where=array())
	{
		$sql = ShareMysqlTool::querySql('sharedb.callsource_log', $where); 
		$list = ShareMysql::getAll($sql);
		foreach($list as $k=>$v) {
			//$implode(',', unserialize($v['args']))
			//$list[$k]['apinameshow'] = sprintf('%s(%s)', $v['apiname']));
		}
		return $list;
	}
}