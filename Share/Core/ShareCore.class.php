<?php
/**
 *	������
 */

class ShareCore
{	
	private $f_project;					//������Դ����
	private $f_module;				//������Դģ��
	private $f_action;				//������Դ����
	private $s_api;					//api����  =  ������Ŀ��.����ģ����.��������

	private $moduleObjCache = array();			//��Ŀģ����󻺴�
	private $callModule = '';					//Ҫ���õ���Ŀģ��  =  ������Ŀ��.����ģ����
	
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
		$this->initCallSource();
		
		//��ȡģ��ʵ��
		list($error, $desc) = $this->getProjectModuleObj();
		if ($error != 0) {
			$this->error($desc);
		}
		
		//�жϷ����Ƿ����
		if (!method_exists($desc, $func)) {
			$this->error(sprintf("method %s not exists in %s", $func, $this->callModule));
		}
		
		$cachekey = md5($this->callModule.$func.serialize($args));
		$result = ShareCache::get($cachekey);
		if ($result === false || $this->isUnitTest()) {
			$timestart = microtime(true);
			$result = $desc->$func($args);
			$timeend = microtime(true);		
			$spendtime = number_format(($timeend - $timestart)*1000, 4, '.', ''); //'����'

			if ($desc->cacheTime() > 0) {
				ShareCache::set($cachekey, serialize($result), $desc->cacheTime());
			}

			//��¼������Դ
			$this->logCallResource($func, $args, $spendtime);

			$this->logBadcode($func, $args, $spendtime);

			$this->unitTestPrint($func, $args, $spendtime);
		} else {
			if (ShareDebug()) {
				echo "\n<br>from cache<br>";
			}
			$result = unserialize($result);
		}
	
		return $result;
	}

	private function unitTestPrint($func, $args, $spendtime)
	{
		if (!$this->isUnitTest()) {
			return;
		}		
		echo "\n".'<br>' . sprintf('Test Api: %s.%s', $this->callModule, $func);
		echo "\n".'<br> args: ' . var_export($args, true); 
		echo "\n".'<br> spentime: ' . $spendtime . ' msec';
		echo "\n\n".'<br><br>';
	}

	private function logBadcode($func, $args, $spendtime)
	{
		//��¼���Ĺ�����
		if (round($spendtime, 4) >= ShareConfig('SLOW_TIME')) {			
			ShareBadcode::insert($this->f_project, $this->f_module, $this->f_method, $this->callModule.'.'.$func, 
				serialize($args), $spendtime);
		}
	}
	
	private function logCallResource($func, $args, $spendtime)
	{
		//��¼�������ĸ�����api
		//��¼������Դ����Ŀ����ģ������������
		if (ShareDebug()) {
			echo '<br>' . sprintf('api: %s.%s', $this->callModule, $func);
			echo '<br> args: ' . var_export($args, true); 
			echo '<br> from project: ' . $this->f_project;
			echo '<br> from module: ' . $this->f_module;
			echo '<br> from method: ' . $this->f_method;
			echo '<br> spentime: ' . $spendtime;
			echo '<br><br>';
		}

		if ($this->isUnitTest()) {	//��Ԫ���Բ���¼
			return;
		}

		$config = ShareConfig();
		if (!$config['ENABLE_CALLSOURCE_LOG']) {
			return;
		}

		$cachekey = sprintf('callsource_%s|%s|%s|%s.%s', $this->f_project, $this->f_module, $this->f_method, $this->callModule, $func);
		$val = ShareCache::get($cachekey);
		//С��һ�죬�����
		if ((time() - $val) < 3600 * 24) {
			return ;	
		} else {	
			//������
			$re = ShareCallSource::insert($this->f_project, $this->f_module, $this->f_method, $this->callModule.'.'.$func);	
			if ($re) {
				ShareCache::set($cachekey, time(), 3600*24);
			}
		}
	}

	private function isUnitTest()
	{
		return $this->f_project == 'ShareUnitTest';
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
			return array(2, "Class '".$arr[1]."' not found");
		}		
		$obj = new $arr[1]();
		
		//ǿ�Ƽ̳�ShareCommon��
		if (is_subclass_of($obj, 'ShareCommon') == false) {
			ShareError("you must extends from ShareCommon!");
		}

		$this->moduleObjCache[$callModule] = $obj;
		return array(0, $this->moduleObjCache[$callModule]);
	}

	private function initCallSource()
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
		
		$this->f_project = APP_NAME;
		$this->f_module = MODULE_NAME;
		$this->f_method = ACTION_NAME;
		return true;
	}

	private function error($msg)
	{
		ShareError($msg);		
	}

}