<?php
	session_start();
	include_once '../../Public/config.php';
	if(empty($_SESSION['admin_info'])){
		header('location:../login.php');
	}
	$link = mysqli_connect(HOST,USER,PWD,DB)or die('连接数据库失败');
	mysqli_set_charset($link,'utf8');
	$id = $_GET['id'];
	$sql = "select * from ".FIX."type where id='$id'";
	$res = mysqli_query($link,$sql);
	if($res && mysqli_num_rows($res)>0) {
		$ren = mysqli_fetch_assoc($res);
		$_SESSION['ren'] = $ren;
	}else{
		header('location:index.php');
		exit;
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>分类管理系统</title>
		<link rel="stylesheet" rev="stylesheet" href="../css/style.css" type="text/css" media="all" />
		<style type="text/css">
		<!--
		.atten {font-size:12px;font-weight:normal;color:#F00;}
		-->
		</style>
	</head>

<body class="ContentBody">
	<form action="action.php?a=edit" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?=$id?>">
	<div class="MainDiv">
	<table width="99%" border="0" cellpadding="0" cellspacing="0" class="CContent">
	<tr>
		<th class="tablestyle_title" >分类修改页面</th>
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
				<legend>修改分类</legend>
				<table border="0" cellpadding="2" cellspacing="1" style="width:100%">
					<tr>
					    <td nowrap align="right" width="13%">分类名:</td>
					    <td width="41%"><input  autocomplete="off" maxlength="10" value="<?=$ren['name']?>" name="name" style="width:150px" type="text" size="40" placeholder="请输入10个字以内分类名" /></td>
					</tr>						
					<tr>
					    <td nowrap align="right" width="13%">移动到哪个类目下:</td>
					    <td width="100%">
					    <?php
					    	$sql = "select * from ".FIX."type";
					    	$res = mysqli_query($link,$sql);
					    	if($res && mysqli_num_rows($res)>0){
					    		echo ' <select style="width:100px" name="path">';
					    		while($arr = mysqli_fetch_assoc($res)){
					    			$sel = ($arr['id']==$ren['pid'])?'selected':'';
					    			$num = substr_count($arr['path'],',');
					    			$str = str_repeat('----',$num-1);
					    			echo "<option $sel value='".$arr['path'].$arr['id']."'>{$str}{$arr['name']}
					    			</option>";
					    			// $pid = $arr['id'];
					    		}
					    		
					    			// <input type='hidden' name='pid' value=".$arr['id'].">

					    		
					    		echo '</select>';
					    	}
					    ?>
					    </td>
					</tr>	
					<tr>
					    <td nowrap align="right" width="13%">分类图片:</td>
					    <td width="41%"><input name="pic" type="file"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">原分类图片:</td>
					    <td width="41%">
					    <?php	
					    	if(!empty($ren['pic'])){ ?>
						 		<img width="150" src="../../Public/upload/type/<?="{$ren['pic']}"?>">

					    <?php	
							}else{
								echo "无上传";
							}
					    ?>
						</td>
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
