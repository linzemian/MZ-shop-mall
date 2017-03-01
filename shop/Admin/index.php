<?php
session_start();
    if(empty($_SESSION['admin_info'])){
        header('location:login.php');
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>项目管理系统</title>
	</head>

	<frameset rows="59,*" cols="*" frameborder="no" border="0" framespacing="0">
		<frame src="files/top.html" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
		<frameset cols="213,*" frameborder="no" border="0" framespacing="0">
		<frame src="files/left.php" name="leftFrame" scrolling="No" noresize="noresize" id="leftFrame" title="leftFrame" />
		<frame src="files/mainfra.html" name="mainFrame" id="mainFrame" title="mainFrame" />
	</frameset>
	</frameset>
<noframes><body>
</body>
</noframes></html>
