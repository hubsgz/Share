<?php

define('SHARE_PATH', dirname(__FILE__));

class Share
{
	static function toolobj()
	{
		static $obj = null;
		if ($obj == null) {
			$obj = new ShareTool();
		}
		return $obj;
	}

	static function api($apiname)
	{
		$tool = self::toolobj();
		$tool -> api($apiname);

		return $tool;
	}
}

class ShareTool
{	
	private $appName;					//项目名称
	private $moduleName;				//项目下的模块名
	private $actionName;				//方法名
	private $apiname;					//api名称

	private $projectObjCache = array();			//项目对象缓存
	
	public function api($apiname)
	{
		//初始化调用来源
		$this->initCallResource();
		
		//初始化api名称
		$this->apiname = $apiname;
	}

	public function call()
	{
		$args = func_get_args();
		
		//解析api
		list($error, $desc, $func) =  self::parseApi();

		if ($error != 0) {
			$this->error($desc); 
		} 
		
		$result = $desc->$func($args);
		
		//记录调用来源
		$this->logCallResource();
				
		return $result;
	}
	
	private function logCallResource()
	{
		//记录调用了哪个共享api
		//记录调用来源的项目名，模块名，方法名
	}

	private function parseApi()
	{
		$apiname = $this->apiname;
		$arr = explode('.', $apiname);
		if (count($arr) != 3) {
			return array(1, 'wrong apiname,  apiname must like Ask.Browse.newQuestionList', '');
		}

		list($error, $desc) = $this->getProjectObj($arr[0] . '.' . $arr[1]);
		
		if ($error != 0) {
			return array($error, $desc, '');
		}

		if (!method_exists($desc, $arr[2])) {
			return array(1, sprintf("method %s not exists in %s.%s", $arr[2], $arr[0], $arr[1]), '');
		}

		return array(0, $desc, $arr[2]);
	}

	private function getProjectObj($projectName)
	{
		if (isset($this->projectObjCache[$projectName])) {
			return array(0, $this->projectObjCache[$projectName]);
		}
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
		$this->projectObjCache[$projectName] = $obj;
		return array(0, $this->projectObjCache[$projectName]);
	}

	private function initCallResource()
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
		
		$this->appName = APP_NAME;
		$this->moduleName = MODULE_NAME;
		$this->actionName = ACTION_NAME;
		return true;
	}

	private function error($msg)
	{
		echo "\n".'<br>-----Share error report-----<br>';
		echo $msg;
		echo '<br>----------------------------';
		exit;
	}

}
