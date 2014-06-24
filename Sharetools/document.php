<?php 
/**
 *	共享代码文档更新和查询文档
 */
require '../Share/Share.php';

require_once SHARE_PATH . '/Core/' . 'ShareReflection.class.php';

$trees = ShareReflection::loadAllClass();

$m = ShareGetStr('m');
if ($m != false) {
	$moduleDoc = array('name'=>$m);

	$reflector = new ReflectionClass($m);
	$classDoc = $reflector->getDocComment();
	$moduleDoc['doc'] = $classDoc;
	$methods = $reflector->getMethods();
	$methodlist = array();
	foreach ($methods as $method) {
		if ($method->isPrivate()) {
			continue;
		}
		if ($method->getDeclaringClass()->getName() != $reflector->getName()) {
			continue;
		}
		$methodName = $method->getName();
		$methodDoc = $method->getDocComment();

		$methodlist[] = array('name'=>$methodName, 'doc'=>$methodDoc);
	}

	$moduleDoc['methods'] = $methodlist;

	//print_r($moduleDoc);
}


//
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>共享代码文档</title>
<script type="text/javascript" src="http://js.findlawimg.com/min/?b=js&amp;f=jquery-1.6.2.min.js"></script>
<style>
* { padding:0; margin:0;}
.main { width:260px; line-height:28px; padding-left:5px; background:#ccc; cursor:pointer; border-bottom:1px solid #fff;}
.child { width:255px; background:#eee;}
.child ul li { padding-left:5px; border-bottom:1px solid #fff; line-height:180%; margin-bottom:1px;}
.child ul li a{ color:#666;}
</style>
<script type="text/javascript">
  <!--
	function cancel(){
		event.cancelBubble=true;
	}
	function toggle(obj){
		 var display=obj.children[0].style.display;
		 //alert(display);
		 if(display=='block'){
			obj.children[0].style.display='none';
		 }else{
			obj.children[0].style.display='block';
		 }
	}
  //-->
  </script>
</head>
<body>

<?php if (!isset($_GET['m'])): ?>

<h2 style="float:left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;共享代码文档</h2>
<div style="clear:both;"></div>

<div id="left" style="width:260px;background:#ccc; float:left;">

<?php foreach($trees as $v): ?>
<div class="main" onClick="toggle(this)" > + <?php echo $v['name'];?>
	<div class="child" style="display:none">
		<ul>
		<?php foreach($v['modules'] as $m): ?>
		<li onclick="cancel()">  
			- <a href="document.php?m=<?php echo $m;?>" target="ifpage">  <?php echo $m;?></a>
		</li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endforeach; ?>

</div>

<div id="right" style="width:900px; height:1500px; background:#eee; float:left; margin-left:10px;">
	<iframe name="ifpage" width="100%" height="100%" src="">
</div>

<?php else: ?>
<div style="padding:10px; ">	

	<h4><?php echo $moduleDoc['name'];?>.class.php</h4>
	<p><?php echo ShareDoc($moduleDoc['doc']);?></p>
	<?php foreach($moduleDoc['methods'] as $m): ?>
	<div onclick="toggle(this)" style="width:100%;background:#777777; margin:2px; font-weight:bold; padding:2px;" > 
		+ <?php echo $m['name'] . str_repeat('&nbsp;', 25-strlen($m['name'])) . ShareDocResume($m['doc']);?>
		<div class="child" style="display:none;width:100%;font-size:14px; ">
			<ul>
			<li onclick="cancel()" style="">  
				<?php echo ShareDoc($m['doc']);?>
			</li>
			</ul>
		</div>
	</div>
	<?php endforeach; ?>
<div/>
<?php endif; ?>
</body>
</html>

