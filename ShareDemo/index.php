<?php
/**
 *	Ask��Ŀ��Ԫ����
 */

define('APP_NAME', 'ShareDemo');
define('MODULE_NAME', 'Demo');
define('ACTION_NAME', 'index');

require '../Share/Share.php';

//����10����ѯ
$list = Share::module('Ask.Browse')->newQuestionList(1);
print_r($list);
