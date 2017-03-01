<?php
    session_start();
    include_once '../../Public/config.php';
    if(empty($_SESSION['admin_info'])){
        header('location:../login.php');
    }
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('数据库连接失败');
    mysqli_set_charset($link,'utf8');
    $name = isset($_GET['name'])?$_GET['name']:'';
    $status = isset($_GET['status'])?$_GET['status']:'';
    $tid = isset($_GET['tid'])?$_GET['tid']:'';

?>
<html>
	<head>
		<style>
			a{
				text-decoration:none;
			}
			.caozuo{
				color:#777;
			}
			.caozuo1{
				color:rgb(255,50,0);
			}
		</style>
	</head>
	<body>
		<h1 align="center">商品列表</h1>
		<hr>
		<form action="" method="get" align="center">
			<input type="text" value="<?=$name?>" placeholder="请输入商品名进行搜索" name="name">			
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
			<select name="status">
				<option value="">---请选择商品状态---</option>
				<option <?=($status==1)?'selected':'' ?> value="1">在售中</option>
				<option <?=($status==2)?'selected':'' ?> value="2">已下架</option>
			</select>
			<input type="submit" value="搜索商品">
			<a href="add.php?tid=<?=$tid?>&status=<?=$status?>"><input type="button"  value="添加商品"></a>
		</form>
		<table align="center" width="95%" border="1" cellspacing="0" cellpadding="10">
			<tr>
				<th>编号</th>
				<th>商品名</th>
				<th>商品图片</th>
				<th>分类</th>
				<th>状态</th>
				<th>库存</th>
				<th>描述</th>
				<th>添加时间</th>
				<th>操作</th>
			</tr>
			<?php 
			/*------------------搜索开始------------------------------*/

				$where = "";
				$search = '';
				// 拼接商品名搜索条件
				if(!empty($name)){
					$where .= " and g.name like '%{$name}%'";		
					$search .= "&name=$name";
				}

				// 拼接分类
				if(!empty($tid)){
					$where .=" and tid=$tid";	
					$search .= "&tid=$tid";
				}

				// 拼接状态
				if(!empty($status)){
					$where .=" and status=$status";	
					$search .= "&status=$status";
				}
			/*------------------搜索结束------------------------------*/

			/*------------------分页开始------------------------------*/
				// 设置每页显示的条数
				$num =10;
				// 统计有多少条数据
				$sql = "select count(*) from ".FIX."goods g where 1=1 $where";
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

				$sql = "select g.*,t.name tname from ".FIX."goods g,".FIX."type t where g.tid=t.id $where order by time desc $limit";
				// echo $sql;exit;
			    $res = mysqli_query($link,$sql);
			    if($res && mysqli_num_rows($res)){
			    	while($ren =mysqli_fetch_assoc($res)){
			    		$row['status']=($ren['status']==1)? '在售中':'已下架';
			    		if($_SESSION['admin_info']['id']!=6){
			    			$caozuo = "<a class='caozuo' href='edit.php?id={$ren['id']}'>编辑</a>";
			    		}else{
			    			$caozuo = "<a class='caozuo1' href='action.php?a=del&id={$ren['id']}'>删除</a>
			    			 <a class='caozuo' href='edit.php?id={$ren['id']}'>编辑</a>";
			    		}
						echo "<tr align='center'>
							<td width='50'>{$ren['id']}</td>
							<td width='100'>{$ren['name']}</td>
							<td width='100'><img height='70' src='../../Public/upload/".$ren['pic']."'/></td>
							<td width='100'>{$ren['tname']}</td>
							<td width='100'><a class='caozuo1' href='./action.php?a=status&id={$ren['id']}&status={$ren['status']}'>{$row['status']}</a></td>
							<td width='80'>{$ren['store']}</td>
							<td width='80'>{$ren['des']}</td>
							<td>".date('Y-m-d H:i:s',$ren['time'])."</td>
							<td width='100'>{$caozuo}</td>
						</tr>";
			    	}
			    }else{
			    	echo "<tr><td colspan='9' align='center'>该搜索条件下查不到商品，请先<a class='caozuo1' href='add.php?tid=$tid&status=$status'>添加</a>一个</td></tr>";
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