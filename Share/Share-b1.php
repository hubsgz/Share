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
	private $appName;					//��Ŀ����
	private $moduleName;				//��Ŀ�µ�ģ����
	private $actionName;				//������
	private $apiname;					//api����

	private $projectObjCache = array();			//��Ŀ���󻺴�
	
	public function api($apiname)
	{
		//��ʼ��������Դ
		$this->initCallResource();
		
		//��ʼ��api����
		$this->apiname = $apiname;
	}

	public function call()
	{
		$args = func_get_args();
		
		//����api
		list($error, $desc, $func) =  self::parseApi();

		if ($error != 0) {
			$this->error($desc); 
		} 
		
		$result = $desc->$func($args);
		
		//��¼������Դ
		$this->logCallResource();
				
		return $result;
	}
	
	private function logCallResource()
	{
		//��¼�������ĸ�����api
		//��¼������Դ����Ŀ����ģ������������
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
