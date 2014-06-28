<?php
/**
 *	核心类
 */

class ShareCore
{	
	private $f_project;					//调用来源名称
	private $f_module;				//调用来源模块
	private $f_action;				//调用来源方法
	private $s_api;					//api名称  =  共享项目名.共享模块名.共享方法名

	private $moduleObjCache = array();			//项目模块对象缓存
	private $callModule = '';					//要调用的项目模块  =  共享项目名.共享模块名
	
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
		//初始化调用来源
		$this->initCallSource();
		
		//获取模块实例
		list($error, $desc) = $this->getProjectModuleObj();
		if ($error != 0) {
			$this->error($desc);
		}
		
		//判断方法是否存在
		if (!$desc->hasMethod($func)) {
			$this->error(sprintf("method %s not exists in %s", $func, $this->callModule));
		}
		
		$cachekey = md5($this->callModule.$func.serialize($args));
		$result = ShareCache::get($cachekey);
		if ($result === false || $this->isUnitTest()) {
			$methodref = $desc->getMethod($func);
			$timestart = microtime(true);
			$module_instance = $desc->newInstance();
			$result = $methodref->invokeArgs($module_instance, $args);
			//$result = $desc->$func($args);
			//$result = call_user_func($func, $args);
			$timeend = microtime(true);		
			$spendtime = number_format(($timeend - $timestart)*1000, 4, '.', ''); //'毫秒'

			if (($cachetime = $desc->getMethod('cacheTime')->invoke($module_instance)) > 0) {
				ShareCache::set($cachekey, serialize($result), $cachetime);
			}

			//记录调用来源
			$this->logCallResource($func, $args, $spendtime);

			$this->logBadcode($func, $args, $spendtime);

			$this->unitTestPrint($func, $args, $spendtime, $result);
		} else {
			if (ShareDebug()) {
				echo "\n<br>from cache<br>";
			}
			$result = unserialize($result);
		}
	
		return $result;
	}

	private function unitTestPrint($func, $args, $spendtime, $result)
	{
		if (!$this->isUnitTest()) {
			return;
		}		
		echo "\n".'<br><font style="background-color:#eee">' . sprintf('Test Api: %s.%s', $this->callModule, $func) . '</font>';
		echo "\n".'<br> args: ' . var_export($args, true); 
		echo "\n".'<br> spentime: ' . $spendtime . ' msec';
		echo "\n".'<br> result: ' . var_export($result, true) . '';
		echo "\n\n".'<br><br>';
	}

	private function logBadcode($func, $args, $spendtime)
	{
		if ($this->isUnitTest()) {	//单元测试不记录
			return;
		}

		//记录慢的共享方法
		if (round($spendtime, 4) >= ShareConfig('SLOW_TIME')) {			
			ShareBadcode::insert($this->f_project, $this->f_module, $this->f_method, $this->callModule.'.'.$func, 
				serialize($args), $spendtime);
		}
	}
	
	private function logCallResource($func, $args, $spendtime)
	{
		//记录调用了哪个共享api
		//记录调用来源的项目名，模块名，方法名
		if (ShareDebug()) {
			echo '<br>' . sprintf('api: %s.%s', $this->callModule, $func);
			echo '<br> args: ' . var_export($args, true); 
			echo '<br> from project: ' . $this->f_project;
			echo '<br> from module: ' . $this->f_module;
			echo '<br> from method: ' . $this->f_method;
			echo '<br> spentime: ' . $spendtime;
			echo '<br><br>';
		}

		if ($this->isUnitTest()) {	//单元测试不记录
			return;
		}
		
		$config = ShareConfig();
		if (!$config['ENABLE_CALLSOURCE_LOG']) {
			return;
		}

		$cachekey = sprintf('callsource_%s|%s|%s|%s.%s', $this->f_project, $this->f_module, $this->f_method, $this->callModule, $func);
		$val = ShareCache::get($cachekey);
		//小于一天，不入库
		if ((time() - $val) < 3600 * 24) {
			return ;	
		} else {	
			//入库操作
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
	
	/**
	 *	获取模块实例
	 */
	private function getProjectModuleObj()
	{
		$callModule = $this->callModule;
		if (isset($this->moduleObjCache[$callModule])) {
			return array(0, $this->moduleObjCache[$callModule]);
		}
		$arr = explode('.', $callModule);
		$s_project = $arr[0];
		$s_module = $arr[1];
		$s_module_classname = $s_module . 'Share';
		$s_module_file = $s_module . 'Share.class.php';
		$s_module_parent_file = $arr[0] . 'Share.class.php';
		
		$config = ShareConfig();
		$sharecode_basepath = SHARE_PATH . DIRECTORY_SEPARATOR . $config['BASE_PATH'];

		$classFile = $sharecode_basepath . DIRECTORY_SEPARATOR . $s_project . DIRECTORY_SEPARATOR . $s_module_file;
		if (!file_exists($classFile)) {
			return array(2, "module {$callModule} not exists [require file:".$classFile."]");
		}
		
		//加载父类
		$parentClassFile = $sharecode_basepath . DIRECTORY_SEPARATOR . $s_project . DIRECTORY_SEPARATOR . $s_module_parent_file;
		if (file_exists($parentClassFile)) {
			require_once($parentClassFile);
		}		
		//加载子类
		require_once($classFile);

		if (!class_exists($s_module_classname)) {
			return array(2, "Share Module '". $s_project.'.'.$s_module ."' not found [require class:".$s_module_classname."]");
		}		

		$obj = new ReflectionClass($s_module_classname);
		
		//强制继承ShareCommon类		
		if ($obj->isSubclassOf('CommonShare') == false) {
			ShareError("share module must extends from CommonShare! [".$obj->getName()."]");
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