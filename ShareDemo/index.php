<?php
/**
 *	Ask项目单元测试
 */

define('APP_NAME', 'ShareDemo');
define('MODULE_NAME', 'Demo');
define('ACTION_NAME', 'index');

require '../Share/Share.php';

//最新10条咨询
$list = Share::module('Ask.Browse')->newQuestionList(1);
print_r($list);
