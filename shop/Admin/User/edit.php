<?php
	session_start();
	include_once '../../Public/config.php';
	if(empty($_SESSION['admin_info'])){
		header('location:../login.php');
	}
	$link = mysqli_connect(HOST,USER,PWD,DB)or die('连接数据库失败');
	mysqli_set_charset($link,'utf8');
	$id = $_GET['id'];
 // 查询要修改的是否是管理员
    $sql2 = "select role from ".FIX."user where id=$id limit 1";
    $res2 = mysqli_query($link,$sql2);
    if($res2 && mysqli_num_rows($res2)>0){
        $role = mysqli_fetch_assoc($res2)['role'];
    }
    // 判断是否是炒鸡
    if($_SESSION['admin_info']['id']!='6'){
        if($role == 2 ){
            echo '<script>alert("不是炒鸡，不能编辑其他管理员");location.href="index.php"</script>';
            exit; 
        }
    }

	$sql = "select * from ".FIX."user where id='$id' limit 1";
	$res = mysqli_query($link,$sql);
	if($res && mysqli_num_rows($res)>0) {
		$ren = mysqli_fetch_assoc($res);
		$_SESSION['pre'] = $ren;
		// var_dump($_SESSION['pre']);
	}else{
		header('location:index.php');
		exit;
	}
?>
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
	<form action="action.php?a=edit" method="post" enctype="multipart/form-data">
	<!-- <input type="hidden" name="ren" value="<?=$ren?>"> -->
	<!-- 不能通过隐藏域传数组 -->
	<input type="hidden" name="id" value="<?=$id?>">
	<div class="MainDiv">
	<table width="99%" border="0" cellpadding="0" cellspacing="0" class="CContent">
	<tr>
		<th class="tablestyle_title" >用户修改页面</th>
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
					    <!-- 若要保留账号不能更改 则用readonly  -->
					    <td width="41%"><input autofocus autocomplete="off" maxlength="50" value="<?=$ren['username']?>" name="username" style="width:150px" type="text" size="40" /></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">密码:</td>
					    <td width="41%"><input placeholder="为空则用原密码" name="pwd" style="width:150px" type="password" size="40" /></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">确认密码:</td>
					    <td width="41%"><input name="pwd2" placeholder="为空则用原密码" style="width:150px" type="password" size="40" /></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">角色:</td>
					    <td width="41%">
					    <?php
					    	if($_SESSION['admin_info']['id']!='6'){
					    		$dis = 'disabled' ;
					    		echo '<input type="hidden" name="role" value="'.$ren['role'].'">';
					    	}else{
					    		$dis = '';
					    	}
					    ?>
						    <select name="role" <?=$dis?>>
						    	<option <?=($ren['role']=='1')?'selected':''?> value="1">普通用户</option>
						    	<option <?=($ren['role']=='2')?'selected':''?> value="2">管理员</option>
						    </select>
						</td>
					</tr>	
					<tr>
					    <td nowrap align="right" width="13%">用户状态:</td>
					    <td width="41%">
						    <select name="status">
						    	<option <?=($ren['status']=='1')?'selected':''?> value="1">正常使用</option>
						    	<option <?=($ren['status']=='2')?'selected':''?> value="2">禁用中</option>
						    </select>
						</td>
					</tr>				
					<tr>
					    <td nowrap align="right" width="13%">性别:</td>
					    <td width="41%">
					    	<input name="sex" <?=($ren['sex']=='0')?'checked':''?> value="0" type="radio"/>女
					    	<input name="sex" <?=($ren['sex']=='1')?'checked':''?> value="1" type="radio"/>男
					    	<input name="sex" <?=($ren['sex']=='2')?'checked':''?> value="2" type="radio"/>保密
					    </td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">电话号码:</td>
					    <td width="41%"><input name="phone" value="<?=$ren['phone']?>" minlength="11" maxlength="11" placeholder="请输入11位号码" style="width:150px" type="text" /></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">QQ号:</td>
					    <td width="41%"><input name="qq" value="<?=$ren['qq']?>" maxlength="15" placeholder="请输入15个以内字符" style="width:150px" type="text" size="40" /></td>
					</tr>	
					<tr>
					    <td nowrap align="right" width="13%">头像:</td>
					    <td width="41%"><input name="pic" style="width:150px" type="file" size="40" /></td>
					</tr>	
					<tr>
					    <td nowrap align="right" width="13%">原头像:</td>
					    <td width="41%">
					    <?php if(!empty($ren['pic'])){ ?>
						 	<img width="150" src="../../Public/upload/touxiang/<?="{$ren['pic']}"?>">
					    <?php }else{
					    	echo '无上传';
					    	} ?>
						</td>
					</tr>											
					<tr><td height="10"></td></tr>
					<tr><td></td><td>
						<input type="submit" value="提交">
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
