<?php 
/**
 *  调用来源查询
 */
require '../Share/Share.php';

$where = array();
$apiname = ShareGetStr('s_api');
if ($apiname != '') {
	$where['s_api'] = $apiname;
	$list = ShareCallSource::getAll($where);
} else {
	$list = ShareCallSource::getAll();
}

//$allopt = ShareCallSource::allopt();
//$all

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=GB2312" />
<title>共享代码调用查询</title>
</head>
<body>
<h2>共享代码调用查询</h2>
<div>
	<form type='get' action="">
	调用api <input type="text" name="s_api" value="<?php echo $apiname;?>" style="width:300px;" />
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
<?php else: ?>
<div style="border:1px solid #eee">没找到记录</div>
<?php endif; ?>

</body>
</html>