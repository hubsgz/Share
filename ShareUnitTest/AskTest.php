<?php
/**
 *	Ask项目单元测试
 */

require '../Share/ShareTest.php';

//testMethod测试
Share::module('Ask.Browse')->testMethod(1, 2, array(1));

//最新10条咨询测试
Share::module('Ask.Browse')->newQuestionList(1);



