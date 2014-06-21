<?php

require '../Share/Share.php';

define('APP_NAME', 'unittest');			//单元测试
define('MODULE_NAME', 'testAsk');
define('ACTION_NAME', 'unittest');

//最新10条咨询
$list = Share::module('Ask.AskBrowse')->newQuestionList1(1, 1, 4);
print_r($list);
