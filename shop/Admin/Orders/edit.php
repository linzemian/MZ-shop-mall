<?php
	if(empty($_GET['oid'])){
		header('location:index.php');
		exit;
	}else{
		$oid = $_GET['oid'];
	}
	include_once '../../Public/config.php';
	// var_dump($oid);exit;
	$link = mysqli_connect(HOST,USER,PWD,DB) or die('服务器连接失败');
	$sql = "select o.*,a.address,a.phone,a.name aname,a.code,u.username from ".FIX."order o,".FIX."address a,".FIX."user u where o.aid=a.id and o.uid=u.id and o.id=$oid";
	$res = mysqli_query($link,$sql);
	$arr = mysqli_fetch_assoc($res);
	// var_dump($arr);
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
	<form action="action.php?a=edit" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="">
	<div class="MainDiv">
	<table width="99%" border="0" cellpadding="0" cellspacing="0" class="CContent">
	<tr>
		<th class="tablestyle_title" >订单修改页面</th>
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
				<legend>修改订单</legend>
				<table border="0" cellpadding="2" cellspacing="1" style="width:100%">
					<tr>
					    <td nowrap align="right" width="13%">订单号:</td>
					    <td width="41%"><input autocomplete="off" readonly name="oid" value="<?=$oid?>" style="width:150px" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">用户:</td>
					    <td width="41%"><input name="username" readonly style="width:150px" value="<?=$arr['username']?>" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">订单总价:</td>
					    <td width="41%"><input name="total"  style="width:150px" value="<?=$arr['total']?>" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">订单状态:</td>
					    <td width="41%">
					    <input name="status" <?=($arr['status']==1)?'checked':''?> value="1" type="radio"/>待付款
					    <input name="status" <?=($arr['status']==2)?'checked':''?> value="2" type="radio"/>待发货
					    <input name="status" <?=($arr['status']==3)?'checked':''?> value="3" type="radio"/>待收货
					    <input name="status" <?=($arr['status']==4)?'checked':''?> value="4" type="radio"/>已完成</td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">收件人:</td>
					    <td width="41%"><input name="aname"  style="width:150px" value="<?=$arr['aname']?>" type="text"/></td>
					</tr>	
					<tr>
					    <td nowrap align="right" width="13%">电话号码:</td>
					    <td width="41%"><input name="phone"  style="width:150px" value="<?=$arr['phone']?>" type="text"/></td>
					</tr>	
					<tr>
					    <td nowrap align="right" width="13%">收货地址:</td>
					    <td width="41%"><input name="address"  style="width:150px" value="<?=$arr['address']?>" type="text"/></td>
					</tr>		
					<tr>
					    <td nowrap align="right" width="13%">邮编:</td>
					    <td width="41%"><input name="code"  style="width:150px" value="<?=$arr['code']?>" type="text"/></td>
					</tr>		
					<input type="hidden" name="aid" value="<?=$arr['aid']?>">
					<input type="hidden" name="uid" value="<?=$arr['uid']?>">
					<tr><td height="10"></td></tr>
					<tr><td></td><td>
						<input type="submit" value="修改">
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
