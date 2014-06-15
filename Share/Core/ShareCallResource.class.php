<?php


class ShareCallResource
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
		
		$sql = ShareMysql::insertSql('callresource', $insertdata); 
		return ShareMysql::execSql($sql);
	}

}