<?php
	header("Content-type: text/html; charset=utf-8");
	include_once '../../Public/config.php';
	$link = mysqli_connect(HOST,USER,PWD,DB) or die('服务器连接失败');
	$sql = "select * from ".FIX."link ";
	// echo $sql;exit;
	$res = mysqli_query($link,$sql);
	if($res && mysqli_num_rows($res)>0){
		$arr = mysqli_fetch_all($res,MYSQLI_ASSOC);
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>链接管理系统</title>
		<link rel="stylesheet" rev="stylesheet" href="../css/style.css" type="text/css" media="all" />
		<style type="text/css">
		<!--
		.atten {font-size:12px;font-weight:normal;color:#F00;}
		-->
		</style>
	</head>

<body class="ContentBody">
	<form action="action.php?a=addyou" method="post" enctype="multipart/form-data">
	<div class="MainDiv">
	<table width="99%" border="0" cellpadding="0" cellspacing="0" class="CContent">
	<tr>
		<th class="tablestyle_title" >链接添加页面</th>
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
				<legend>添加链接</legend>
				<table border="0" cellpadding="2" cellspacing="1" style="width:100%">
					<tr>
					    <td nowrap align="right" width="13%">链接名:</td>
					    <td width="41%"><input autocomplete="off" name="name" style="width:150px" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">路径:</td>
					    <td width="41%"><input name="lujing" style="width:150px" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">图片:</td>
					    <td width="41%"><input name="pic"  style="width:150px" type="file"/></td>
					</tr>										
					<tr><td height="10"></td></tr>
					<tr><td></td><td>
						<input type="submit" value="添加">
						<input type="reset" value="重置">
						<a href="./you.php"><input type="button" value="返回"></a></td>
					</tr>
				</table>
			 <br />
				</fieldset>	
		</tr>	
		</table>
	 </td>
  </tr>
		</table>
	 </td>
  </tr>
 	</table>
</div>
</form>
</body>
</html>
