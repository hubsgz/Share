<?php

require '../Share/Share.php';

define('APP_NAME', 'unittest');			//��Ԫ����
define('MODULE_NAME', 'testAsk');
define('ACTION_NAME', 'unittest');

//����10����ѯ
$list = Share::module('Ask.AskBrowse')->newQuestionList1(1, 1, 4);
print_r($list);
