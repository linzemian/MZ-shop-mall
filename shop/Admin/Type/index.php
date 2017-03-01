<?php
    session_start();
    include_once '../../Public/config.php';
    if(empty($_SESSION['admin_info'])){
        header('location:../login.php');
    }
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('数据库连接失败');
    mysqli_set_charset($link,'utf8');

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
				color:rgb(255,10,0);
			}
		</style>
	</head>
	<body>
		<h2 align="center">分类列表</h2>
		<hr>
		<table align="center" width="95%" border="1" cellspacing="0" cellpadding="10">
			<tr>
				<th>编号</th>
				<th>分类名</th>
				<th>分类图片</th>
				<th>上一级分类</th>
				<th>path路径</th>
				<th>操作</th>
			</tr>
			<?php 

		    	$sql = "select * from ".FIX."type order by concat(`path`,`id`)";
			    $sql2 = "alter table ".FIX."type auto_increment=1";
			    $res = mysqli_query($link,$sql);
			    $res2 = mysqli_query($link,$sql2);
			    if($res && mysqli_num_rows($res)>0){
			    	$ren =mysqli_fetch_all($res,MYSQLI_ASSOC);
			    // 遍历数组，将父类显示成具体类目
			    	foreach($ren as $k=>$v){
			    		$arr[$v['id']] = $v['name'];
			    		if(!empty($v['pic'])){
			    			$pic = __PUBLIC__.'type/'.$v['pic'];
			    			$img = "<img height='70' src='$pic'/>";
			    		}else{
			    			$img = '';
			    		}

			    	// 计算有多少个逗号，得到应该空多少px
			    		$num = substr_count($v['path'],',');
			    		$str = str_repeat('---',$num-1);
			    		
						echo "<tr align='center'>
							<td width='80'>{$v['id']}</td>
							<td align='left' width='100'>{$str}{$v['name']}</td>
							<td width='80' height='80'>{$img}</td>
							<td width='150'>".(($v['pid']=='0') ? $v['name']:$arr[$v['pid']])."</td>
							<td width='80'>{$v['path']}
							</td>
							<td width='120'>
								<a class='caozuo1' href='action.php?a=del&id={$v['id']}&path={$v['path']}'>删除</a>
								<a class='caozuo' href='edit.php?id={$v['id']}'>编辑</a>
								<a class='caozuo' href='add.php?id={$v['id']}&path={$v['path']}'>添加子分类</a>
							</td>
						</tr>";
			    	}
				    }else{
				    	echo '<tr><td colspan="6" align="center">查不到分类，请先<a class="caozuo1" href="add.php">添加</a>一个</td></tr>';
			    }
			    	// 父类id基础版：{$v['pid']}
			    	// path路径基础版：{$v['path']}
			?>
		</table>
	</body>
</html>