<?php
	if(empty($_GET['did'])){
		header('location:detail.php');
		exit;
	}else{
		$did = $_GET['did'];
	}
	if(empty($_GET['oid'])){
		header('location:detail.php');
		exit;
	}else{
		$oid = $_GET['oid'];
	}
	include_once '../../Public/config.php';
	// var_dump($oid);exit;
	$link = mysqli_connect(HOST,USER,PWD,DB) or die('服务器连接失败');
	$sql = "select u.id,u.username,o.*,a.address,a.name aname,a.phone,a.code,d.id did,d.gid,d.num,g.name gname,g.price,g.tid from ".FIX."order as o,".FIX."user as u,".FIX."address as a,".FIX."detail as d,".FIX."goods as g where o.uid=u.id and o.aid=a.id and o.id=d.oid and d.gid=g.id ";
	$res = mysqli_query($link,$sql);
	$arr = mysqli_fetch_assoc($res);
	// var_dump($arr);exit;
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
	<form action="action.php?a=editdetail" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="">
	<div class="MainDiv">
	<table width="99%" border="0" cellpadding="0" cellspacing="0" class="CContent">
	<tr>
		<th class="tablestyle_title" >订单明细修改页面</th>
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
					    <td nowrap align="right" width="13%">订单明细编号:</td>
					    <td width="41%"><input autocomplete="off" readonly name="did" value="<?=$did?>" style="width:150px" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">订单号:</td>
					    <td width="41%"><input autocomplete="off" readonly name="oid" value="<?=$oid?>" style="width:150px" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">用户ID:</td>
					    <td width="41%"><input name="username" readonly style="width:150px" value="<?=$arr['username']?>" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">商品名:</td>
					    <td width="41%"><input name="gname"  style="width:150px" value="<?=$arr['gname']?>" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">单价:</td>
					    <td width="41%"><input name="price" readonly style="width:150px" value="<?=$arr['price']?>" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">数量:</td>
					    <td width="41%"><input name="num"  style="width:150px" value="<?=$arr['num']?>" type="text"/></td>
					</tr>	
					<input type="hidden" name="gid" value="<?=$arr['gid']?>">
					<input type="hidden" name="uid" value="<?=$arr['uid']?>">
					<tr><td height="10"></td></tr>
					<tr><td></td><td>
						<input type="submit" value="修改">
						<input type="reset" value="重置">
						<a href="./detail.php"><input type="button" value="返回"></a></td>
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
