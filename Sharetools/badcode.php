<?php 

require '../Share/Share.php';

$where = array();
$apiname = ShareGetStr('s_api');
if ($apiname != '') {
	$where['s_api'] = $apiname;
	$list = ShareBadcode::getAll($where);
} else {
	$list = array();
}

//$allopt = ShareCallSource::allopt();
//$all

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=GB2312" />
<title>����������ѯ</title>
</head>
<body>

<div>
	<form type='get' action="">
	����api <input type="text" name="apiname" value="<?php echo $apiname;?>" style="width:300px;" />
	<input type="submit" value="��ѯ" />
	</form>
</div>

<?php if(!empty($list)): ?>
<div>
	<table cellpadding="1" cellspacing="1" width="100%" border="1">
	<tr>
	<td>��Դ��Ŀ</td>
	<td>��Դģ��</td>
	<td>��Դ����</td>
	<td>����api</td>
	<td>���ò���</td>
	<td>����ʱ��</td>
	<td>����ִ��ʱ��</td>
	</tr>
	
	<?php 
	foreach($list as $v){
		echo "<tr>";
		echo "<td>".$v['appname']."</td>";
		echo "<td>".$v['modulename']."</td>";
		echo "<td>".$v['actionname']."</td>";
		echo "<td>".$v['apiname']."</td>";
		echo "<td>". var_export(unserialize($v['args']), true)."</td>";
		echo "<td>". date('Y-m-d H:i:s', $v['calltime'])."</td>";
		echo "<td>".$v['spendtime']."����</td>";
		echo "</tr>";
	}
	?>
	
	</table>
</div>
<?php endif; ?>

</body>
</html>