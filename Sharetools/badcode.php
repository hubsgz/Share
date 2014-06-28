<?php 
/**
 *	慢共享方法查询
 */
require '../Share/Share.php';

$trees = ShareReflection::loadAllClass();

$where = array();
$s_project = ShareGetStr('s_project');
$s_module = ShareGetStr('s_module');
if ($s_project != '') {
	$where['s_project'] = $s_project;
}
if ($s_module != '') {
	$where['s_module'] = $s_module;
}
$list = ShareBadcode::getAll($where);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=GB2312" />
<title>慢共享方法查询</title>
</head>
<body>
<h2>慢共享方法查询</h2>
<div>
	<form type='get' action="">
	项目 <select id="s_project" name="s_project" onchange="setChild(this.value);"></select>
	模块 <select id="s_module" name="s_module"></select>
	<input type="submit" value="查询" />
	</form>
</div>

<div>
	<table cellpadding="1" cellspacing="1" width="100%" border="1">
	<tr>
	<td>来源项目</td>
	<td>来源模块</td>
	<td>来源方法</td>
	<td>服务器ip</td>
	<td>调用api</td>
	<td>调用参数</td>
	<td>调用时间</td>
	<td>调用执行时间</td>
	</tr>
	<?php if(!empty($list)): ?>
	<?php 
	foreach($list as $v){
		echo "<tr>";
		echo "<td>".$v['f_project']."</td>";
		echo "<td>".$v['f_module']."</td>";
		echo "<td>".$v['f_method']."</td>";
		echo "<td>".$v['f_ip']."</td>";
		echo "<td>".$v['s_api']."</td>";
		echo "<td>". var_export(unserialize($v['args']), true)."</td>";
		echo "<td>". date('Y-m-d H:i:s', $v['calltime'])."</td>";
		echo "<td>".$v['spendtime']."毫秒</td>";
		echo "</tr>";
	}
	?>
	<?php else: ?>
	<tr><td colspan="8" align="center">没记录</td></tr>
	<?php endif; ?>

	</table>
</div>


<script>
	var data = <?php echo json_encode($trees); ?>;
	var cur_project = '<?php echo ShareGetStr('s_project');?>';
	var cur_module = '<?php echo ShareGetStr('s_module');?>';
	(function(){
		for (var i in data) {
			if (cur_project == '') {
				cur_project = i;
			}
			console.info(data[i]['name']);
			var sel = cur_project == data[i]['name'] ? 'selected="selected"' : '';
			tmp = "<option "+sel+" value='"+data[i]['name']+"'>"+data[i]['name']+"</option>";
			document.getElementById('s_project').innerHTML += tmp;
		}
		setChild(data[cur_project]['name'], cur_module);
	})();
	function setChild(project, cur_module) {
		tmp = "<option value=''>全部</option>";
		for (var i=0;i<data[project]['modules'].length;i++)
		{
			var v = data[project]['modules'][i];
			var sel = cur_module == v ? 'selected="selected"' : '';
			tmp += "<option "+sel+" value='"+v+"'>"+v+"</option>";
			console.info();
		}		
		document.getElementById('s_module').innerHTML = tmp;
	}
</script>

</body>
</html>