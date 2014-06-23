<?php 
/**
 *	共享代码文档更新和查询文档
 */
require '../Share/Share.php';

require_once SHARE_PATH . '/Core/' . 'ShareReflection.class.php';

if (ShareGetStr('update') !== false) {
	//更新文档
	$trees = ShareReflection::loadAllClass();
	foreach ($trees as $v) {
		foreach ($v['modules'] as $m) {
			$reflector = new ReflectionClass($m);
			$classDoc = $reflector->getDocComment();
			$methods = $reflector->getMethods();
			foreach ($methods as $method) {
				if ($method->isPrivate()) {
					continue;
				}
				if ($method->getDeclaringClass()->getName() != $reflector->getName()) {
					continue;
				}

				echo $methodName = $method->getName();
				echo $methodDoc = $method->getDocComment();
			}
		}
	}

} else {
	//查询文档
}


//

exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=GB2312" />
<title>共享代码文档</title>
</head>
<body>

<div>
	<form type='get' action="">
	调用api <input type="text" name="apiname" value="<?php echo $apiname;?>" style="width:300px;" />
	<input type="submit" value="查询" />
	</form>
</div>

<?php if(!empty($list)): ?>
<div>
	<table cellpadding="1" cellspacing="1" width="100%" border="1">
	<tr>
	<td>来源项目</td>
	<td>来源模块</td>
	<td>来源方法</td>
	<td>调用api</td>
	<td>调用时间</td>
	</tr>
	
	<?php 
	foreach($list as $v){
		echo "<tr>";
		echo "<td>".$v['f_project']."</td>";
		echo "<td>".$v['f_module']."</td>";
		echo "<td>".$v['f_method']."</td>";
		echo "<td>".$v['s_api']."</td>";
		echo "<td>". date('Y-m-d H:i:s', $v['calltime'])."</td>";
		echo "</tr>";
	}
	?>
	
	</table>
</div>
<?php endif; ?>

</body>
</html>