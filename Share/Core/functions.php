<?php

function ShareConfig($f='')
{
	static $config = null;
	if ($config == null) {
		$config = require(SHARE_PATH . '/Conf/config.php');
	}
	if ($f == '' || !isset($config[$f])) {
		return $config;
	} else {
		return $config[$f];
	}	
}

function ShareError($msg)
{
	echo "\n".'<br>-----Share error report-----<br>';
	echo $msg;
	echo '<br>----------------------------';
	exit;
}

function importRequireClass()
{
	require_once SHARE_PATH . '/Core/' . 'ShareCore.class.php';
	require_once SHARE_PATH . '/Core/' . 'ShareCache.class.php';
	require_once SHARE_PATH . '/Core/' . 'ShareMysql.class.php';
	require_once SHARE_PATH . '/Core/' . 'ShareCommon.class.php';

	require_once SHARE_PATH . '/Model/' . 'ShareCallSource.class.php';
	require_once SHARE_PATH . '/Model/' . 'ShareBadcode.class.php';
}

function ShareGetStr($f)
{
	if (isset($_GET[$f])) {
		return trim($_GET[$f]);
	}
	return false;
}

function ShareDebug()
{
	return isset($_REQUEST['sharedebug']);
}