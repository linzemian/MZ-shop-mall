<?php
	include_once '../../Public/config.php';
	$link = mysqli_connect(HOST,USER,PWD,DB) or die('服务器连接失败');

	if(empty($_GET['aid'])){
		header('location:address.php');
		exit;
	}else{
		$id = $_GET['aid'];
	    $sql = "select * from ".FIX."order o where o.aid=$id ";
	    $res = mysqli_query($link,$sql);
	    if($sql && mysqli_num_rows($res)>0){
	        echo "<script>alert('该地址已有存在订单，无法修改地址，请先删除订单');location.href='address.php'</script>";
	        exit;
	    }
	}

	if(empty($_GET['uid'])){
		header('location:address.php');
		exit;
	}else{
		$uid = $_GET['uid'];
	}

	if(empty($_GET['username'])){
		header('location:address.php');
		exit;
	}else{
		$username = $_GET['username'];
	}

	if(empty($_GET['name'])){
		header('location:address.php');
		exit;
	}else{
		$name = $_GET['name'];
	}

	if(empty($_GET['phone'])){
		header('location:address.php');
		exit;
	}else{
		$phone = $_GET['phone'];
	}

	if(empty($_GET['address'])){
		header('location:address.php');
		exit;
	}else{
		$address = $_GET['address'];
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>订单管理系统</title>
		<link rel="stylesheet" rev="stylesheet" href="../css/style.css" type="text/css" media="all" />
		<style type="text/css">
		<!--
		.atten {font-size:12px;font-weight:normal;color:#F00;}
		-->
		</style>
	</head>

<body class="ContentBody">
	<form action="action.php?a=editaddress" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="">
	<div class="MainDiv">
	<table width="99%" border="0" cellpadding="0" cellspacing="0" class="CContent">
	<tr>
		<th class="tablestyle_title" >地址明细修改页面</th>
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
				<legend>修改地址</legend>
				<table border="0" cellpadding="2" cellspacing="1" style="width:100%">
					<tr>
					    <td nowrap align="right" width="13%">地址编号:</td>
					    <td width="41%"><input autocomplete="off" readonly name="id" value="<?=$id?>" style="width:150px" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">用户名:</td>
					    <td width="41%"><input autocomplete="off" readonly name="username" value="<?=$username?>" style="width:150px" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">收件人:</td>
					    <td width="41%"><input name="name"  style="width:150px" value="<?=$name?>" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">电话:</td>
					    <td width="41%"><input name="phone"  style="width:150px" value="<?=$phone?>" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">收货地址:</td>
					    <td width="41%"><input name="address"  style="width:150px" value="<?=$address?>" type="text"/></td>
					</tr>	
					<tr><td height="10"></td></tr>
					<tr><td></td><td>
						<input type="submit" value="修改">
						<input type="reset" value="重置">
						<a href="./address.php"><input type="button" value="返回"></a></td>
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
