<?php
/**
 *	地区站项目单元测试
 */

require '../Share/ShareTest.php';

//areatestMethod测试
Share::module('Areastation.Index')->areatestMethod(1, 2, array(1));

//最新10条案例测试
Share::module('Areastation.Index')->areaNewAnliList(100);



