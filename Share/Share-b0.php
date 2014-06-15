<?php

define('SHARE_PATH', dirname(__FILE__));

class Share
{
	

}

class ShareTool
{
	
	static $appName;				//项目名称
	static $moduleName;				//项目下的模块名
	static $actionName;				//方法名
	static $projectObjCache;		//项目对象缓存
	static $apiname;				//api名称

	static function api($apiname)
	{
		//初始化调用来源
		self::initCallResource();
		
		//初始化api名称
		self::apiname = $apiname;
		
		return self;
	}
	
	static function logCallResource()
	{
		//记录调用了哪个共享api
		//记录调用来源的项目名，模块名，方法名
	}

	static function call()
	{
		$args = func_get_args();
		
		//获取实例
		list($error, $obj, $func) =  self::parseApi($apiname);

		if ($error != 0) {
			self::error($desc); 
		} 
		
		//记录调用来源
		self::logCallResource();

		return $desc;
	}

	static function 

	static function getProjectObj($projectName)
	{
		if (isset(self::$projectObjCache[$projectName])) {
			return array(0, self::$projectObjCache[$projectName]);
		}
		echo 'fsefsfsefes=====';
		$arr = explode('.', $projectName);
		if (count($arr) != 2) {
			return array(1, 'wrong projectName,  projectName must like Ask.Browse.');
		}

		$dirName = $arr[0];
		$className = $arr[1] . '.class.php';

		$classFile = SHARE_PATH . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $className;
		if (!file_exists($classFile)) {
			return array(2, "{$projectName} is not exists");
		}
		
		require_once($classFile);

		if (!class_exists($arr[1])) {
			return array(2, "Class 'Browse' not found");
		}
		$obj = new $arr[1]();
		self::$projectObjCache[$projectName] = $obj;
		return array(0, self::$projectObjCache[$projectName]);
	}

	static function initCallResource()
	{
		if (!defined('APP_NAME')) {
			self::error("APP_NAME is not defined"); 
			return false;
		}

		if (!defined('MODULE_NAME')) {
			self::error("MODULE_NAME is not defined"); 
			return false;
		}

		if (!defined('ACTION_NAME')) {
			self::error("ACTION_NAME is not defined"); 
			return false;
		}
		
		self::$appName = APP_NAME;
		self::$moduleName = MODULE_NAME;
		self::$actionName = ACTION_NAME;
		return true;
	}

	static function error($msg)
	{
		echo "\n".'<br>-----Share error report-----<br>';
		echo $msg;
		echo '<br>----------------------------';
		exit;
	}


	static function checkApi($apiname)
	{
		$arr = explode('.', $apiname);
		if (count($arr) != 3) {
			return array(1, 'wrong apiname,  apiname must like Ask.Browse.newQuestionList');
		}
	}

	static function parseApi($apiname)
	{
		$arr = explode('.', $apiname);
		return $arr;
	}

}
