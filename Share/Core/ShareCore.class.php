<?php


class ShareCore
{	
	private $appName;					//��Ŀ����
	private $moduleName;				//��Ŀ�µ�ģ����
	private $actionName;				//������
	private $apiname;					//api����  =  ��Ŀ��.ģ����.������

	private $moduleObjCache = array();			//��Ŀģ����󻺴�
	private $callModule = '';					//Ҫ���õ���Ŀģ��  =  ��Ŀ��.ģ����
	
	public function setCallModule($moduleName)
	{
		$moduleName = trim($moduleName);
		$arr = explode('.', $moduleName);
		if ($moduleName == '' || count($arr) != 2) {
			return array(1, 'wrong moduleName,  moduleName must like Ask.Browse');
		}
		$this->callModule = $moduleName;
	}

	public function __call($func, $args) 
	{	
		//��ʼ��������Դ
		$this->initCallResource();
		
		//��ȡģ��ʵ��
		list($error, $desc) = $this->getProjectModuleObj();
		if ($error != 0) {
			$this->error($desc);
		}
		
		//�жϷ����Ƿ����
		if (!method_exists($desc, $func)) {
			$this->error(sprintf("method %s not exists in %s", $func, $this->callModule));
		}
		
		$timestart = microtime(true);
		$result = $desc->$func($args);
		$timeend = microtime(true);		
		$spendtime = number_format(($timeend - $timestart)*1000, 4); //'����'
		
		//��¼������Դ
		$this->logCallResource($func, $args, $spendtime);
				
		return $result;
	}
	
	private function logCallResource($func, $args, $spendtime)
	{
		//��¼�������ĸ�����api
		//��¼������Դ����Ŀ����ģ������������
		if (isset($_GET['debug'])) {
			echo '<br>' . sprintf('api: %s.%s', $this->callModule, $func);
			echo '<br> args: ' . var_export($args, true); 
			echo '<br> appName: ' . $this->appName;
			echo '<br> moduleName: ' . $this->moduleName;
			echo '<br> actionName: ' . $this->actionName;
			echo '<br> spentime: ' . $spendtime;
			echo '<br><br>';
		}
		
		$config = ShareConfig();
		if (!$config['ENABLE_CALLSOURCE_LOG']) {
			return;
		}

		$cachekey = sprintf('%s|%s|%s|%s.%s', $this->appName, $this->moduleName, $this->actionName, $this->callModule, $func);
		$val = ShareCache::get($cachekey);
		//С��һ�죬�����
		if ((time() - $val) < 3600 * 24) {
			return ;	
		} else {	
			//������
			$re = ShareCallSource::insert($this->appName, $this->moduleName, $this->actionName, 
				$this->callModule.'.'.$func, serialize($args), $spendtime);	
			if ($re) {
				ShareCache::set($cachekey, time());
			}
		}
	}

	private function getProjectModuleObj()
	{
		$callModule = $this->callModule;
		if (isset($this->moduleObjCache[$callModule])) {
			return array(0, $this->moduleObjCache[$callModule]);
		}
		$arr = explode('.', $callModule);
		$dirName = $arr[0];
		$className = $arr[1] . '.class.php';
		$parentClassName = $arr[0] . $arr[0] . '.class.php';
		
		$config = ShareConfig();
		$sharecodePath = SHARE_PATH . DIRECTORY_SEPARATOR . $config['BASE_PATH'];

		$classFile = $sharecodePath . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $className;
		if (!file_exists($classFile)) {
			return array(2, "module {$callModule} not exists");
		}
		
		//���ظ���
		$parentClassFile = $sharecodePath . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $parentClassName;
		if (file_exists($parentClassFile)) {
			require_once($parentClassFile);
		}
		
		//��������
		require_once($classFile);

		if (!class_exists($arr[1])) {
			return array(2, "Class 'Browse' not found");
		}
		$obj = new $arr[1]();
		$this->moduleObjCache[$callModule] = $obj;
		return array(0, $this->moduleObjCache[$callModule]);
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
		ShareError($msg);		
	}

}