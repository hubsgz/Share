<?php
/**
 *	Ask项目单元测试
 */

require '../Share/ShareTest.php';


//最新10条咨询测试
Share::module('Ask.AskBrowse')->newQuestionList(1);

//testMethod测试
Share::module('Ask.AskBrowse')->testMethod(1, 2, array(1));

