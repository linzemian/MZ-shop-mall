<?php
    session_start();
    include_once '../../Public/config.php';
    if(empty($_SESSION['admin_info'])){
        header('location:../login.php');
    }
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('数据库连接失败');
    mysqli_set_charset($link,'utf8');
	$status = isset($_GET['status'])?$_GET['status']:'';
	$username = isset($_GET['username'])?$_GET['username']:'';
	$id = isset($_GET['id'])?$_GET['id']:'';

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
		<h1 align="center">订单列表</h1>
		<hr>
		<form action="" method="get" align="center">
			<input type="text" value="<?=$id?>" placeholder="请输入订单号进行搜索" name="id">	
			<input type="text" value="<?=$username?>" placeholder="请输入用户名进行搜索" name="username">	
			<select name="status">
				<option value="">---请选择订单状态---</option>
				<option <?=($status==1)?'selected':'' ?> value="1">待付款</option>
				<option <?=($status==2)?'selected':'' ?> value="2">待发货</option>
				<option <?=($status==3)?'selected':'' ?> value="3">待收货</option>
				<option <?=($status==4)?'selected':'' ?> value="4">已完成</option>
			</select>
			<input type="submit" value="搜索订单">
		</form>
		<table align="center" width="95%" border="1" cellspacing="0" cellpadding="10">
			<tr>
				<th>订单号</th>
				<th>用户</th>
				<th>总计</th>
				<th>下单时间</th>
				<th>收件人</th>
				<th>地址</th>
				<th>订单状态</th>
				<th>查看订单详情</th>
				<th>操作</th>
			</tr>
			<?php
				/*------------------搜索开始------------------------------*/
				$where = "";
				$search = '';
				// 拼接订单号搜索条件
				if(!empty($id)){
					$where .= " and o.id like '%{$id}%'";		
					$search .= "&id=$id";
				}				

				// 拼接商品名搜索条件
				if(!empty($username)){
					$where .= " and u.username like '%{$username}%'";		
					$search .= "&username=$username";
				}

				// 拼接状态
				if(!empty($status)){
					$where .=" and o.status=$status";	
					$search .= "&status=$status";
				}

				/*------------------搜索结束------------------------------*/
				/*------------------分页开始------------------------------*/
				// 设置每页显示的条数
				$num =10;
				$sql = "select count(*) from ".FIX."user u,".FIX."order o where u.id=o.uid $where";
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
				$sql = "select u.id uid,u.username,o.*,a.address,a.name aname from ".FIX."order as o,".FIX."user as u,".FIX."address as a where o.uid=u.id and o.aid=a.id $where order by o.id desc $limit";
				$res = mysqli_query($link,$sql);
				if($res && mysqli_num_rows($res)>0){
					$orders = mysqli_fetch_all($res,MYSQLI_ASSOC);
					$status = [1=>'待付款',2=>'待发货',3=>'待收货',4=>'已完成'];
					foreach($orders as $v){
						if($_SESSION['admin_info']['id']=='6') {
								$caozuo2 = " <a style='color:rgb(255,50,0);' href='action.php?a=delorder&oid={$v['id']}'>删除订单</a>";
							}else{
								$caozuo2 = ' ';
							}
						$view = "<a style='color:rgb(255,50,0);' href='detail.php?id={$v['id']}'>点击查看</a>";
						switch ($v['status']){
							case '1':
								$caozuo = "等待买家付款,
								<a style='color:#999;' href='edit.php?oid={$v['id']}'>编辑</a>";
								break;
							case '2':
								$caozuo = "<a style='color:rgb(255,50,0);' href='action.php?a=changestatus&status=2&oid={$v['id']}'>发货</a>
								<a style='color:#999;' href='edit.php?oid={$v['id']}'>编辑</a>";
								break;
							case '3':
								$caozuo =  "等待买家确认收货
								<a style='color:#999;' href='edit.php?oid={$v['id']}'>编辑</a>";
								break;
							case '4':
								$caozuo = "
								<a style='color:#999;' href='edit.php?oid={$v['id']}'>编辑</a>".$caozuo2;
								break;

						}
						echo "<tr align='center'>
							<td>{$v['id']}</td>
							<td>{$v['username']}</td>
							<td>{$v['total']}</td>
							<td>".date("Y-m-d H:i:s",$v['addtime'])."</td>
							<td>{$v['aname']}</td>
							<td>{$v['address']}</td>
							<td>{$status[$v['status']]}</td>
							<td>$view</td>
							<td>{$caozuo}</td>
						</tr>";
					}
				}else{
			    	echo "<tr><td colspan='9' align='center'>该搜索条件下查不到订单,点击<a class='caozuo1' href='index.php'>查看所有订单</td></tr>";
			    }
			?>
			<tr>
				<td colspan="9">共<?=$total?>条数据 第<?=$p?>/<?=$totalpage?>页
				<span style="float:right">
					<a class='caozuo' href="./index.php?p=1">首页</a>
					<a class='caozuo' href="./index.php?p=<?=($p-1).$search?>">上一页</a>
					<a class='caozuo' href="./index.php?p=<?=($p+1).$search?>">下一页</a>
					<a class='caozuo' href="./index.php?p=<?=$totalpage?>">尾页</a>
				</span></td>
			</tr>
		</table>
	</body>
</html>