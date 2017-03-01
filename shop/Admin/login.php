<?php
	session_start();
	// 判断是否之前的用户名是否保留
	if(isset($_SESSION['username'])){
		$session_name=$_SESSION['username'];
	}else{
		$session_name='';
	}
	// 判断之前的密码是否保留
	if(isset($_SESSION['pwd'])){
		$session_pwd=$_SESSION['pwd'];
	}else{
		$session_pwd='';
	}
	// 判断action处理的信息
	if(isset($_SESSION['admin_info'])){
		$session=$_SESSION['admin_info'];
	}else{
		$session='';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>项目管理系统</title>
		<style type="text/css">
			<!--
			body {
				margin-left: 0px;
				margin-top: 0px;
				margin-right: 0px;
				margin-bottom: 0px;
			}
			-->
		</style>
		<link href="css/css.css" rel="stylesheet" type="text/css" />
	</head>

<body>
	<form action="./action.php?a=login" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td height="147" background="images/top02.gif"><img src="images/top03.gif" width="776" height="147" /></td>
		  </tr>
		</table>
		<table width="562" border="0" align="center" cellpadding="0" cellspacing="0" class="right-table03">
		  <tr>
		    <td width="221"><table width="95%" border="0" cellpadding="0" cellspacing="0" class="login-text01">
		      
		      <tr>
		        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="login-text01">
		          <tr>
		            <td align="center"><img src="images/ico13.gif" width="107" height="97" /></td>
		          </tr>
		          <tr>
		            <td height="40" align="center">&nbsp;</td>
		          </tr>
		          
		        </table></td>
		        <td><img src="images/line01.gif" width="5" height="292" /></td>
		      </tr>
		    </table></td>
		    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		      <tr>
		        <td width="31%" height="35" class="login-text02">用户名：<br /></td>
		        <td width="69%"><input name="username"  autocomplete="off" value="<?= ($session=='0')? '':$session_name?>" type="text" size="30" /></td>
		      </tr>
		      <tr>
		        <td height="35" class="login-text02">密　码：<br /></td>
		        <td><input name="pwd" value="<?= ($session=='2')? $session_pwd: '' ?>" type="password" size="30" /></td>
		      </tr>
		      <tr>
		        <td height="35" class="login-text02">验证图片：<br /></td>
		        <td><img onclick="this.src='../Public/yzm.php?'+Math.random()" src="../Public/yzm.php" width="109" height="40" /> </td>
		      </tr>
		      <tr>
		        <td height="35" class="login-text02">验证码：</td>
		        <td><input name="yzm" type="text" size="30" /></td>
		      </tr>
		      <tr>
		        <td height="35">&nbsp;</td>
		        <td><input type="submit"  value="确认登陆" onclick="window.location='index.html'" />
		          <input type="reset" value="重 置" /></td>
		      </tr>
		    </table></td>
		  </tr>
		</table>
	</form>
</body>
</html>