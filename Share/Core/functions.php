<?php

function ShareConfig()
{
	static $config = null;
	if ($config == null) {
		$config = require(SHARE_PATH . '/Conf/config.php');
	}
	return $config;
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

	require_once SHARE_PATH . '/Core/Model/' . 'ShareCallSource.class.php';
}

function ShareGetStr($f)
{
	if (isset($_GET[$f])) {
		return trim($_GET[$f]);
	}
	return false;
}