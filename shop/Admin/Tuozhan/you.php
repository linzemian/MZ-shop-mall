<?php
    session_start();
    include_once '../../Public/config.php';
    if(empty($_SESSION['admin_info'])){
        header('location:../login.php');
    }
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('数据库连接失败');
    mysqli_set_charset($link,'utf8');
	$id = isset($_GET['id'])?$_GET['id']:'';
	$name = isset($_GET['name'])?$_GET['name']:'';
	$lujing = isset($_GET['lujing'])?$_GET['lujing']:'';

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
			<input type="text"  placeholder="请输入编号进行搜索" name="id">	
			<input type="text"  placeholder="请输入链接名进行搜索" name="name">	
			<input type="text"  placeholder="请输入地址进行搜索" name="lujing">	

			<input type="submit" value="搜索链接">
			<a href="./addyou.php"><input type="button" value="添加链接"></a>
		</form>
		<table align="center" width="95%" border="1" cellspacing="0" cellpadding="10">
			<tr>
				<th>编号</th>
				<th>链接名</th>
				<th>地址</th>
				<th>图片</th>
				<th>操作</th>
			</tr>
			<?php
				/*------------------搜索开始------------------------------*/
				$where = " 1=1 ";
				$search = "";
				// 拼接订单号搜索条件
				if(!empty($id)){
					$where .= " and id like '%{$id}%'";		
					$search .= "&id=$id";
				}				

				// // 拼接链接名搜索条件
				if(!empty($name)){
					$where .= " and name like '%{$name}%'";		
					$search .= "&name=$name";
				}

				// // 拼接状态
				if(!empty($lujing)){
					$where .= " and lujing like '%{$lujing}%'";		
					$search .= "&lujing=$lujing";
				}

				/*------------------搜索结束------------------------------*/
				/*------------------分页开始------------------------------*/
				// 设置每页显示的条数
				$num =10;
				$sql = "select count(*) from ".FIX."link where $where";
				$res = mysqli_query($link,$sql);				
				$total = mysqli_fetch_row($res)[0];
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
				// /*------------------分页结束------------------------------*/
				$sql = "select * from ".FIX."link where $where $limit";
				$res = mysqli_query($link,$sql);
				if($res && mysqli_num_rows($res)>0){
					$links = mysqli_fetch_all($res,MYSQLI_ASSOC);
					foreach($links as $v){
						$caozuo  = "<a href='edityou.php?id={$v['id']}'>编辑</a>
						<a href='action.php?a=delyou&id={$v['id']}'>删除</a>";
						if(!empty($v['pic'])){
							$src = __PUBLIC__.'link/'.$v['pic'];
							$img = "<img height='50' src='$src'>";
						}else{
							$img = '';
						}
						echo "<tr height='50' align='center'>
							<td>{$v['id']}</td>
							<td>{$v['name']}</td>
							<td>{$v['lujing']}</td>
							<td>{$img}</td>
							<td>{$caozuo}</td>
						</tr>";
					}
				}else{
			    	echo "<tr><td colspan='5' align='center'>该搜索条件下查不到友情链接,点击<a class='caozuo1' href='you.php'>查看所有</td></tr>";
			    }
			?>
			<tr>
				<td colspan="5">共<?=$total?>条数据 第<?=$p?>/<?=$totalpage?>页
				<span style="float:right">
					<a class='caozuo' href="./you.php">首页</a>
					<a class='caozuo' href="./you.php?p=<?=($p-1).$search?>">上一页</a>
					<a class='caozuo' href="./you.php?p=<?=($p+1).$search?>">下一页</a>
					<a class='caozuo' href="./you.php?p=<?=$totalpage?>>">尾页</a>
				</span></td>
			</tr>
		</table>
	</body>
</html>