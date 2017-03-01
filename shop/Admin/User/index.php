<?php
    session_start();
    include_once '../../Public/config.php';
    if(empty($_SESSION['admin_info'])){
        header('location:../login.php');
    }
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('数据库连接失败');
    mysqli_set_charset($link,'utf8');
    $username = isset($_GET['username'])?$_GET['username']:'';
    $role = isset($_GET['role'])?$_GET['role']:'';
    $status = isset($_GET['status'])?$_GET['status']:'';

?>
<html>
	<head>
		<style>
			a{
				text-decoration:none;
				color:black;
			}
			.caozuo{
				color:blue;
			}
			.caozuo1{
				color:rgb(255,50,0);
			}
		</style>
	</head>
	<body>
		<center><h1 align="center">用户列表</h1>
		<hr>
		<form action="" method="get" align="center">
			<input type="text" value="<?= $username ?>" placeholder="请输入用户名进行搜索" name="username">
			<select name="role">
				<option value=''>---请选择用户类型---</option>
				<option <?=($role=='1')?'selected':'' ?> value="1">普通用户</option>
				<option <?=($role=='2')?'selected':'' ?> value="2">管理员</option>
			</select>			
			<select name="status">
				<option value=''>---请选择用户状态---</option>
				<option <?=($status=='1')?'selected':'' ?> value="1">正常使用</option>
				<option <?=($status=='2')?'selected':'' ?> value="2">禁用中</option>
			</select>
			<input type="submit" value="搜索用户">
			<a href="add.php"><input type="button"  value="添加用户"></a>
		</form>
		<table align="center" width="95%" border="1" cellspacing="0" cellpadding="10">
			<tr>
				<th>编号</th>
				<th>用户名</th>
				<th>用户类型</th>
				<th>状态</th>
				<th>添加时间</th>
				<th>操作</th>
			</tr>
			<?php 
			/*------------------搜索开始------------------------------*/

				// if(isset($_GET['username'])){
				// 	$username = $_GET['username'];
				// 	$where .= " and username like '%{$username}%'";	
				// }
				// if(isset($_GET['role'])){
				// 	$role = $_GET['role'];
				// 	$where .=" and role=$role";	
				// }
				$where = " where 1=1";
				$search = '';
				// 拼接用户名搜索条件
				if(!empty($username)){
					$where .= " and username like '%{$username}%'";	
					$search .= "&username=$username";
				}
				// 拼接角色

				// if($role=='1'||$role=='2'){
				// 	$where .=" and role=$role";	
				// 	$search .= "&role=$role";
				// }	
				if(!empty($role)){
					$where .=" and role=$role";	
					$search .= "&role=$role";
				}	
				// 拼接状态
				if(!empty($status)){
					$where .=" and status=$status";	
					$search .= "&status=$status";
				}
			/*------------------搜索开始------------------------------*/

			/*------------------分页开始------------------------------*/
				// 设置每页显示的条数
				$num =10;
				// 统计有多少条数据
				$sql = "select count(*) from ".FIX."user $where ";
				$res = mysqli_query($link,$sql);
				$total = mysqli_fetch_row($res)['0'];
				// 统计有多少页
				$totalpage = ceil($total / $num);
				$p = isset($_GET['p'])? $_GET['p']:1;
				if($p<1){
					$p = 1;
				}elseif($p>$totalpage){
					$p = $totalpage;
				}
				// 设置偏移量
				$offset = ($p-1)*$num;
				$limit = "limit $offset,$num";
				/*------------------分页结束------------------------------*/

			    $sql = "select * from ".FIX."user $where order by role desc,time desc $limit";
			    // echo $sql;exit;
			    $res = mysqli_query($link,$sql);
			    if($res && mysqli_num_rows($res)>0){
			    	while($ren =mysqli_fetch_assoc($res)){
			    		$row['role']=($ren['role']=='1')? '普通会员':'管理员';
			    		$row['status']=($ren['status']=='1')? '正常':'禁用';
						echo "<tr align='center'>
							<td width='80'>{$ren['id']}</td>
							<td width='150'>{$ren['username']}</td>
							<td width='150'>{$row['role']}</td>
							<td width='80'><a class='caozuo1' href='./action.php?a=status&id={$ren['id']}&status={$ren['status']}'>{$row['status']}</a></td>
							<td>".date('Y-m-d H:i:s',$ren['time'])."</td>
							<td width='120'><a class='caozuo' href='action.php?a=del&id={$ren['id']}'>删除</a>
							<a class='caozuo' href='edit.php?id={$ren['id']}'>编辑</a></td>
						</tr>";
			    	}
			    }else{
			    	echo '<tr><td colspan="6" align="center">该搜索条件下查不到用户，点击<a style="color:rgb(255,50,0);" href="index.php">查看所有用户</a></td></tr>';
			    	exit;
			    }
			?>
			<tr>
				<td colspan="6">共<?=$total?>条数据 第<?=$p?>/<?=$totalpage?>页
				<span style="float:right">
					<a href="./index.php?p=1">首页</a>
					<a href="./index.php?p=<?=($p-1).$search?>">上一页</a>
					<a href="./index.php?p=<?=($p+1).$search?>">下一页</a>
					<a href="./index.php?p=<?=$totalpage?>">尾页</a>
				</span></td>
			</tr>
		</table>
		</center>
	</body>
</html>