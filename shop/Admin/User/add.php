<?php
	session_start();

?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>用户管理系统</title>
		<link rel="stylesheet" rev="stylesheet" href="../css/style.css" type="text/css" media="all" />
		<style type="text/css">
		<!--
		.atten {font-size:12px;font-weight:normal;color:#F00;}
		-->
		</style>
	</head>

<body class="ContentBody">
	<form action="action.php?a=add" method="post" enctype="multipart/form-data">
	<div class="MainDiv">
	<table width="99%" border="0" cellpadding="0" cellspacing="0" class="CContent">
	<tr>
		<th class="tablestyle_title" >用户添加页面</th>
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
				<legend>添加用户</legend>
				<table border="0" cellpadding="2" cellspacing="1" style="width:100%">
					<tr>
					    <td nowrap align="right" width="13%">用户名:</td>
					    <td width="41%"><input autocomplete="off"  maxlength="50" placeholder="请用数字、字母或下划线"  name="username" style="width:150px" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">密码:</td>
					    <td width="41%"><input placeholder="请输入20个以内字符" name="pwd" style="width:150px" type="password"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">确认密码:</td>
					    <td width="41%"><input name="pwd2" placeholder="请输入20个以内字符" style="width:150px" type="password"/></td>
					</tr>
					<tr>
						<!-- 添加管理员的判断，如果是普通管理员，则无法创建管理员 -->
						<?php $dis = ($_SESSION['admin_info']['id']!='6')?'disabled':''; ?>
					    <td nowrap align="right" width="13%">角色:</td>
					    <td width="41%">
						    <select name="role">
						    	<option value="1">普通用户</option>
						    	<option <?=$dis?> value="2">管理员</option>
						    </select>
						</td>
					</tr>	
					<tr>
					    <td nowrap align="right" width="13%">性别:</td>
					    <td width="41%">
					    	<input name="sex" value="0" type="radio"/>女
					    	<input name="sex" value="1" type="radio"/>男
					    	<input name="sex" checked value="2" type="radio"/>保密
					    </td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">电话号码:</td>
					    <td width="41%"><input name="phone" placeholder="请输入11位号码" maxlength="11" minlength="11" style="width:150px" type="text" /></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">QQ号:</td>
					    <td width="41%"><input name="qq" placeholder="请输入15个以内字符" maxlength="15" style="width:150px" type="text" size="40" /></td>
					</tr>					
					<tr>
					    <td nowrap align="right" width="13%">头像:</td>
					    <td width="41%"><input name="pic" style="width:150px" type="file" size="40" /></td>
					</tr>																			
					<tr><td height="10"></td></tr>
					<tr><td></td><td>
						<input type="submit" value="确认">
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
		</table>
	 </td>
  </tr>
 	</table>
</div>
</form>
</body>
</html>
