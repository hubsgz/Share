<?php
/**
 *	Ask��Ŀ��Ԫ����
 */

require '../Share/ShareTest.php';


//����10����ѯ����
Share::module('Ask.AskBrowse')->newQuestionList(1);

//testMethod����
Share::module('Ask.AskBrowse')->testMethod(1, 2, array(1));

