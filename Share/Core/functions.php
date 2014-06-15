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