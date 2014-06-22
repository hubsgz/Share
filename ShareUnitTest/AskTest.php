<?php
/**
 *	Ask项目单元测试
 */

require '../Share/ShareTest.php';


//最新10条咨询
Share::module('Ask.AskBrowse')->newQuestionList(1);

//最新10条咨询
Share::module('Ask.AskBrowse')->newAnswerList(1);