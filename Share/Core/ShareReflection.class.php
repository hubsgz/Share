<?php


class ShareReflection
{
	static function loadAllClass()
	{
		$sharecodePath = SHARE_PATH . DIRECTORY_SEPARATOR . ShareConfig('BASE_PATH');
		$arr = scandir($sharecodePath);
		$projects = array();
		foreach ($arr as $v) {
			if (in_array($v, array('.', '..'))) {
				continue;
			}
			$project = array('name'=>$v, 'modules' => array());
			
			$modules = scandir($sharecodePath . '/' . $v);
			foreach ($modules as $m) {
				if (in_array($m, array('.', '..'))) {
					continue;
				}

				$classFile = $sharecodePath . DIRECTORY_SEPARATOR . $v . DIRECTORY_SEPARATOR . $m;
				require_once($classFile);
				$project['modules'][] = str_replace('.class.php', '', $m);
			}

			$projects[] = $project;
		}
		return $projects;
	}
}