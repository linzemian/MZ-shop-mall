<?php
$id = isset($_GET['id'])?$_GET['id']:'';
$path = isset($_GET['path'])?$_GET['path']:'';
$num = substr_count($path,',');
if($num>=2){
	echo "<script>alert('不能创建三级分类');location.href='index.php'</script>";
	exit;
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>分类管理</title>
		<link rel="stylesheet" rev="stylesheet" href="../css/style.css" type="text/css" media="all" />
		<style type="text/css">
		<!--
		.atten {font-size:12px;font-weight:normal;color:#F00;}
		-->
		</style>
	</head>

<body class="ContentBody">
	<form action="action.php?a=add" method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?=$id?>"/>
	<input type="hidden" name="path" value="<?=$path.$id.','?>"/>
	<div class="MainDiv">
	<table width="99%" border="0" cellpadding="0" cellspacing="0" class="CContent">
	<tr>
		<th class="tablestyle_title" >添加分类</th>
	</tr>
	<tr>
    <td class="CPanel">
		<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
		<tr>
			<td align="left"></td>
		</tr>

		<tr>
			<td width="100%">
				<fieldset style="height:100%;">
				<legend>添加分类</legend>
				<table border="0" cellpadding="2" cellspacing="1" style="width:100%">
					<tr>
					    <td nowrap align="right" width="13%">分类名:</td>
					    <td width="41%"><input autocomplete="off" maxlength="10" autofocus placeholder="请输入10个字以内分类名"  name="name" style="width:150px" type="text"/></td>
					</tr>

					<tr>
					    <td nowrap align="right" width="13%">分类图片:</td>
					    <td width="41%"><input name="pic" type="file"/></td>
					</tr>
																	
					<tr><td height="10"></td></tr>
					<tr><td></td><td>
						<input type="submit" value="添加">
						<input type="reset" value="重置">
						<a href="./index.php"><input type="button" value="返回"></a></td>
					</tr>
				</table>
			 <br />
				</fieldset>	
		</tr>	
		</table>
	 </td>
  </tr>
	 </td>
  </tr>
 	</table>
</div>
</form>
</body>
</html>
