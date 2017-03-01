<?php
	$id = $_GET['id'];
	header("Content-type: text/html; charset=utf-8");
	include_once '../../Public/config.php';
	$link = mysqli_connect(HOST,USER,PWD,DB) or die('服务器连接失败');
	$sql = "select * from ".FIX."type order by concat(path,id) ";
	$res = mysqli_query($link,$sql);
	if($res && mysqli_num_rows($res)>0){
		$arr = mysqli_fetch_all($res,MYSQLI_ASSOC);
	}else{
		echo '<script>alert("请先修改分类");location.href="../Type/add.php"</script>';
		exit;
	}
	$sql2 = "select * from ".FIX."goods where id='$id'";
	$res2 = mysqli_query($link,$sql2);
	if($res2 && mysqli_num_rows($res2)>0){
		$info = mysqli_fetch_assoc($res2);
		// var_dump($info);exit;
	}else{
		echo '<script>alert("非法访问");location.href="../Type/add.php"</script>';
		exit;
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>商品管理系统</title>
		<link rel="stylesheet" rev="stylesheet" href="../css/style.css" type="text/css" media="all" />
		<style type="text/css">
		<!--
		.atten {font-size:12px;font-weight:normal;color:#F00;}
		-->
		</style>
	</head>

<body class="ContentBody">
	<form action="action.php?a=edit" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?=$_GET['id']?>">
	<div class="MainDiv">
	<table width="99%" border="0" cellpadding="0" cellspacing="0" class="CContent">
	<tr>
		<th class="tablestyle_title" >商品修改页面</th>
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
				<legend>修改商品</legend>
				<table border="0" cellpadding="2" cellspacing="1" style="width:100%">
					<tr>
					    <td nowrap align="right" width="13%">选择分类:</td>
					    <td width="41%">
					    	<select name="tid">
					    		<option value=''>--请选择--</option>
					    		<?php
					    		// 遍历分类数组$arr 得到每一条分类$v
					    		// 分类的id名就是商品的pid $v['id']等于要传的pid
					    		// 判断是否是一级类目，一级类目不给选择（$v['pid']等于0则为一级分类）
					    		// 判断是否为原先的分类，自动选中，原先的分类从数据库中查到，$info['tid']
					    		// 总的类目为type里找到的$arr中的$arr['id'],如果两者相等，则自动选中，输出selected
					    			foreach($arr as $v){
					    				$dis = ($v['pid']=='0')?'disabled':'';
					    				$sel = ($v['id']==$info['tid'])?'selected':'';
					    				// 制作缩进，根据path路径逗号的数量来判断
					    				$num = substr_count($v['path'],',');
					    				$str = str_repeat('--',$num-1);
					    				echo "<option $dis $sel value='{$v['id']}'>{$str}{$v['name']}</option>";
					    			}
					    		?>
					    	</select>
					    </td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">商品名:</td>
					    <td width="41%"><input autocomplete="off" maxlength="20" placeholder="请输入20个字以内商品名" name="name" value="<?=$info['name']?>" style="width:150px" type="text"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">价格:</td>
					    <td width="41%"><input name="price" style="width:150px" value="<?=$info['price']?>" type="number"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">库存:</td>
					    <td width="41%"><input name="store"  style="width:150px" value="<?=$info['store']?>" type="number"/></td>
					</tr>
					<tr>
					    <td nowrap align="right" width="13%">状态:</td>
					    <td width="41%">
						    <select name="status">
						    	<option <?=($info['status']=='1')?'selected':''?> value="1">在售中</option>
						    	<option <?=($info['status']=='2')?'selected':''?> value="2">已下架</option>
						    </select>
						</td>
					</tr>	
					<tr>
					    <td nowrap align="right" width="13%">商品图片:</td>
					    <td width="41%">
						   <input type="file" name="pic">
						</td>
					</tr>	
					<tr>
					    <td nowrap align="right" width="13%">原商品图片</td>
					    <td width="41%">
						 	<img width="150" src="../../Public/upload/<?="{$info['pic']}"?>">
						</td>
					</tr>	
					<tr>
					    <td nowrap align="right" width="13%">商品描述:</td>
					    <td width="41%">
					    	<textarea cols="22" rows="10" name="des"><?=$info['des']?></textarea>
					    </td>
					</tr>													
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
