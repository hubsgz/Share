<?php
/**
 *	����վ��Ŀ��Ԫ����
 */

require '../Share/ShareTest.php';

//areatestMethod����
Share::module('Areastation.Index')->areatestMethod(1, 2, array(1));

//����10����������
Share::module('Areastation.Index')->areaNewAnliList(100);



