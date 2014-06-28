<?php


class ShareReflection
{
	static function loadAllClass($isimport = true)
	{
		$sharecodePath = SHARE_PATH . DIRECTORY_SEPARATOR . ShareConfig('BASE_PATH');
		$arr = scandir($sharecodePath);
		$projects = array();
		foreach ($arr as $project_name) {
			if (in_array($project_name, array('.', '..'))) {
				continue;
			}
			$project = array('name'=>$project_name, 'modules' => array());
			
			if ($isimport) {
				//先加载项目公共父类
				$project_parent_class = $project_name . 'Share';
				$project_parent_class_file = $sharecodePath . DIRECTORY_SEPARATOR . $project_name . DIRECTORY_SEPARATOR . 
											 $project_parent_class . '.class.php';
				if (file_exists($project_parent_class_file)) {
					require_once($project_parent_class_file);
				}
			}
			
			$modules = scandir($sharecodePath . '/' . $project_name);
			foreach ($modules as $module_filename) {
				if (in_array($module_filename, array('.', '..'))) {
					continue;
				}

				$mname = str_replace('.class.php', '', $module_filename);
				if (!self::isSharecode($mname)) {
					continue;
				}
				
				if ($isimport) {
					$classFile = $sharecodePath . DIRECTORY_SEPARATOR . $project_name . DIRECTORY_SEPARATOR . $module_filename;
					require_once($classFile);
				}
				$project['modules'][] = substr($mname, 0, -5);
			}

			$projects[$project_name] = $project;
		}
		return $projects;
	}

	/**
	 *	判断是否是共享代码
	 */
	static function isSharecode($name)
	{
		return substr($name, -5) == 'Share';
	}
}