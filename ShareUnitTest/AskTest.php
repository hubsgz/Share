<?php
/**
 *	Ask��Ŀ��Ԫ����
 */

require '../Share/ShareTest.php';

//testMethod����
Share::module('Ask.Browse')->testMethod(1, 2, array(1));

//����10����ѯ����
Share::module('Ask.Browse')->newQuestionList(1);



