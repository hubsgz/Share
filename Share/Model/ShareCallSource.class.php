<?php
/**
调用来源模型
*/

class ShareCallSource
{
	static $table = 'sharedb.share_callsource';

	static function insert($f_project, $f_module, $f_method, $s_api)
	{
		$insertdata = array(
			'f_project' => $f_project,
			'f_module' => $f_module,
			'f_method' => $f_method,
			'f_ip' => $_SERVER['SERVER_ADDR'],
			's_api' => $s_api,
			'calltime' => time()			
		);
		
		$sql = ShareMysqlTool::insertSql(self::$table, $insertdata); 
		return ShareMysql::execSql($sql);
	}
	
	static function getAll($where=array())
	{
		$sql = ShareMysqlTool::querySql(self::$table, $where); 
		$list = ShareMysql::getAll($sql);
		foreach($list as $k=>$v) {
			//$implode(',', unserialize($v['args']))
			//$list[$k]['apinameshow'] = sprintf('%s(%s)', $v['apiname']));
		}
		return $list;
	}
}