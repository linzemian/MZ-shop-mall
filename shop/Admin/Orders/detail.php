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
	$gname = isset($_GET['gname'])?$_GET['gname']:'';
	$id = isset($_GET['id'])?$_GET['id']:'';
	$tid = isset($_GET['tid'])?$_GET['tid']:'';

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
		<h1 align="center">订单明细列表</h1>
		<hr>
		<form action="" method="get" align="center">
			<input type="text" value="<?=$id?>" placeholder="请输入订单号进行搜索" name="id">	
			<input type="text" value="<?=$username?>" placeholder="请输入用户ID进行搜索" name="username">	
			<input type="text" value="<?=$gname?>" placeholder="请输入商品名进行搜索" name="gname">	
			<select name="tid">
				<option value="">---请选择商品分类---</option>
				<?php
					$sql2 = "select * from ".FIX."type order by concat(path,id) ";
					$res2 = mysqli_query($link,$sql2);
					if($res2 && mysqli_num_rows($res2)>0){
						$arr = mysqli_fetch_all($res2,MYSQLI_ASSOC);
					}else{
						echo '<script>alert("请先添加分类");location.href="../Type/add.php"</script>';
						exit;
					}
					foreach($arr as $v){
	    				$dis = ($v['pid']=='0')?'disabled':'';
	    				$num = substr_count($v['path'],',');
	    				$str = str_repeat('--',$num-1);
	    				$sel = ($v['id']==$_GET['tid'])?'selected':'';
	    				echo "<option $dis $sel value='{$v['id']}'>{$str}{$v['name']}</option>";
	    			}

				?>
			</select>	
			<input type="submit" value="搜索订单">
		</form>
		<table align="center" width="95%" border="1" cellspacing="0" cellpadding="10">
			<tr>
				<th>编号</th>
				<th>订单号</th>
				<th>用户ID</th>
				<th>商品名</th>
				<th>单价</th>
				<th>数量</th>
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

				// 拼接用户名搜索条件
				if(!empty($username)){
					$where .= " and u.username like '%{$username}%'";		
					$search .= "&username=$username";
				}	

				// 拼接商品名搜索条件
				if(!empty($gname)){
					$where .= " and g.name like '%{$gname}%'";		
					$search .= "&name=$gname";
				}


				// 拼接分类
				if(!empty($tid)){
					$where .=" and g.tid=$tid";	
					$search .= "&tid=$tid";
				}

				/*------------------搜索结束------------------------------*/
				/*------------------分页开始------------------------------*/
				// 设置每页显示的条数
				$num =10;
				$sql = "select count(*) from ".FIX."user u,".FIX."order o,".FIX."goods g,".FIX."detail d where u.id=o.uid and o.id=d.oid and d.gid=g.id $where";
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

				$sql = "select u.id,u.username,o.*,a.address,d.id did,d.gid,d.num,g.name gname,g.price,g.tid from ".FIX."order as o,".FIX."user as u,".FIX."address as a,".FIX."detail as d,".FIX."goods as g where o.uid=u.id and o.aid=a.id and o.id=d.oid and d.gid=g.id $where order by d.id desc $limit";
				$res = mysqli_query($link,$sql);
				if($res && mysqli_num_rows($res)>0){
					$orders = mysqli_fetch_all($res,MYSQLI_ASSOC);
					// var_dump($orders);exit;
					foreach($orders as $v){
						if($_SESSION['admin_info']['id']==6){
							$caozuo1 = "<a style='color:rgb(255,50,0);' href='action.php?a=deldetail&did={$v['did']}&oid={$v['id']}'>删除此条明细</a> ";
						}else{
							$caozuo1 = ' ';
						}
						$caozuo2 = "<a style='color:#999;' href='".$_SERVER['HTTP_REFERER']."'> 返回</a>";
						$caozuo = empty($_GET['id'])?$caozuo1:$caozuo1.$caozuo2;
						echo "<tr align='center'>
							<td>{$v['did']}</td>
							<td>{$v['id']}</td>
							<td>{$v['username']}</td>
							<td>{$v['gname']}</td>
							<td>{$v['price']}</td>
							<td>{$v['num']}</td>
							<td>{$caozuo}</td>
						</tr>";
					}
					// var_dump($orders);exit;
				}else{
			    	echo "<tr><td colspan='7' align='center'>该搜索条件下查不到订单,点击<a class='caozuo1' href='detail.php'>查看所有订单</td></tr>";
			    }
			?>
			<tr>
				<td colspan="7">共<?=$total?>条数据 第<?=$p?>/<?=$totalpage?>页
				<span style="float:right">
					<a class='caozuo' href="./detail.php?p=1">首页</a>
					<a class='caozuo' href="./detail.php?p=<?=($p-1).$search?>">上一页</a>
					<a class='caozuo' href="./detail.php?p=<?=($p+1).$search?>">下一页</a>
					<a class='caozuo' href="./detail.php?p=<?=$totalpage?>">尾页</a>
				</span></td>
			</tr>
		</table>
	</body>
</html>