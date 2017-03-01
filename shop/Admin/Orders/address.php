<?php
    session_start();
    include_once '../../Public/config.php';
    if(empty($_SESSION['admin_info'])){
        header('location:../login.php');
    }
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('数据库连接失败');
    mysqli_set_charset($link,'utf8');
	$id = isset($_GET['id'])?$_GET['id']:'';
	$username = isset($_GET['username'])?$_GET['username']:'';
	$aname = isset($_GET['aname'])?$_GET['aname']:'';
	$phone = isset($_GET['phone'])?$_GET['phone']:'';

?>
<html>
	<head>
		<style>
			a{
				text-decoration:none;
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
		<h1 align="center">地址列表</h1>
		<hr>
		<form action="" method="get" align="center">
			<input type="text" value="<?=$id?>" placeholder="请输入地址编号进行搜索" name="id">	
			<input type="text" value="<?=$username?>" placeholder="请输入用户名进行搜索" name="username">	
			<input type="text" value="<?=$aname?>" placeholder="请输入收件人进行搜索" name="aname">	
			<input type="text" value="<?=$phone?>" placeholder="请输入手机号进行搜索" name="phone">	
			<input type="submit" value="搜索订单">
		</form>
		<table align="center" width="95%" border="1" cellspacing="0" cellpadding="10">
			<tr>
				<th>地址编号</th>
				<th>用户名</th>
				<th>收件人</th>
				<th>电话</th>
				<th>地址</th>
				<th>操作</th>
			</tr>
			<?php
				/*------------------搜索开始------------------------------*/
				$where = "";
				$search = '';
				// 拼接地址编号搜索条件
				if(!empty($id)){
					$where .= " and a.id like '%{$id}%'";		
					$search .= "&id=$id";
				}				

				// 拼接用户名搜索条件
				if(!empty($username)){
					$where .= " and u.username like '%{$username}%'";		
					$search .= "&username=$username";
				}	

				// 拼接收件人搜索条件
				if(!empty($aname)){
					$where .= " and a.name like '%{$aname}%'";		
					$search .= "&aname=$aname";
				}


				// 拼接手机号搜索条件
				if(!empty($phone)){
					$where .=" and a.phone like '%{$phone}%'";	
					$search .= "&phone=$phone";
				}
				/*------------------搜索结束------------------------------*/
				/*------------------分页开始------------------------------*/
				// 设置每页显示的条数
				$num =10;
				$sql = "select count(*) from ".FIX."address a,".FIX."user u where a.uid=u.id $where";
				// echo $sql;exit;
				$res = mysqli_query($link,$sql);				
				$total = mysqli_fetch_row($res)[0];
				// var_dump($total);exit;
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

				$sql = "select a.id,a.uid,a.name,a.phone,a.address,u.username from ".FIX."address a,".FIX."user u where a.uid=u.id $where order by a.id desc $limit";
				// echo $sql;exit;
				$res = mysqli_query($link,$sql);
				if($res && mysqli_num_rows($res)>0){
					$orders = mysqli_fetch_all($res,MYSQLI_ASSOC);
					foreach($orders as $v){
						if($_SESSION['admin_info']['id']=='6') {
								$caozuo2 = " <a style='color:rgb(255,50,0);' href='action.php?a=deladdress&aid={$v['id']}'>删除单条地址</a>";
							}else{
								$caozuo2 = ' ';
							}
						$caozuo3 ="
							<a style='color:#999;'href='editaddress.php?aid={$v['id']}&uid={$v['uid']}&username={$v['username']}&name={$v['name']}&phone={$v['phone']}&address={$v['address']}'> 编辑</a> ";
						$caozuo = $caozuo2.$caozuo3;
						echo "<tr align='center'>
							<td>{$v['id']}</td>
							<td>{$v['username']}</td>
							<td>{$v['name']}</td>
							<td>{$v['phone']}</td>
							<td>{$v['address']}</td>
							<td>$caozuo</td>
						</tr>";
					}
					// var_dump($orders);exit;
				}else{
			    	echo "<tr><td colspan='7' align='center'>该搜索条件下查不到订单,点击<a class='caozuo1' href='address.php'>查看所有订单</td></tr>";
			    }
			?>
			<tr>
				<td colspan="7">共<?=$total?>条数据 第<?=$p?>/<?=$totalpage?>页
				<span style="float:right">
					<a class='caozuo' href="./address.php?p=1">首页</a>
					<a class='caozuo' href="./address.php?p=<?=($p-1).$search?>">上一页</a>
					<a class='caozuo' href="./address.php?p=<?=($p+1).$search?>">下一页</a>
					<a class='caozuo' href="./address.php?p=<?=$totalpage?>">尾页</a>
				</span></td>
			</tr>
		</table>
	</body>
</html>