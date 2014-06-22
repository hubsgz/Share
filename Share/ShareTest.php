<?php
/**
 *	共享代码单元测试脚本
 */

define('APP_NAME', 'ShareUnitTest');			//单元测试
define('MODULE_NAME', 'Ask');
define('ACTION_NAME', '');

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", "On");

require_once dirname(__FILE__) . '/' . 'Share.php';
