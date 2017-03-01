<?php
	session_start();
	// var_dump($_SESSION);exit;

?>
<html>
	<head>
	    <link href="./image/icon.ico" rel="shortcut icon" type="image/x-icon">
	    <link href="./image/icon.ico" rel="icon" type="image/x-icon">
	    <link rel="stylesheet" href="css/shopcar/layout-25702f0ee1.css">
		<link rel="stylesheet" href="css/shopcar/order-newPayment-a3c96e731b.css">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<script src="css/shopcar/v.htm" charset="utf-8"></script>
		<script src="css/shopcar/hm.js"></script>
		<script src="css/shopcar/flow.js"></script>
		<script src="css/shopcar/analytics-min.js"></script>
	    <meta charset="utf-8">
	    <meta http-equiv="x-ua-compatible" content="ie=edge">
	    <title>购物车-魅族商城</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="魅族商城是魅族面向全国服务的官方电子商务平台,提供魅族PRO系列、魅族MX系列和魅蓝系列等产品的预约和购买.官方正品,全国联保.">
	    <meta name="keywords" content="魅族官方在线商店、魅族在线商城、魅族官网在线商店、魅族商城">
		<style>
		    .sureGet .ui-pop-main .ui-pop-cont{
		        line-height: 28px !important;
		        margin: 64px auto 30px !important;
		        padding:0 30px;
		    }
		    .font-14{
		        font-size: 14px;
		    }
		    .big-font{
		        font-size: 18px;
		    }
		    .layout-header-logo-link{
		        background:url('./image/home/logo.png') no-repeat;
		    }
		</style>
	</head>
<body>
<!-- common header -->
<?php
    include_once './Public/home_header.php';
    include_once '../Public/config.php';


?>
    <div class="store-wrap">
        <div class="crumbs">
            <a href="./home.php">首页&gt;</a>
            <a href="./shopcar.php" class="active">我的购物车</a>
        </div>
        <div class="main clearfix">
		    <div class="left-nav f-fl">
		        <div class="nav-main">
		            <a href="javascript:;" class="type-title"><i class="iconfont icon-orderCenter"></i>订单中心</a>
            		<a href="personal.php" class="ml ">我的订单</a>
		            <a href="javascript:;" class="type-title">
		            	<i class="iconfont icon-selfCenter"></i>个人中心
		            </a>
			            <a href="./account.php" class="ml ">账号信息</a>
			            <a href="./address.php" class="ml ">地址管理</a>
			            <a href="./shopcar.php" class="ml ">我的购物车</a>
		        </div>
		    </div>
	        <div class="right-content f-fr">
	            <div class="order-main">	
	                <div class="list-head">
	                    <ul class="clearfix"  style="text-align:right">
	                        <li class="w125" style="width:420px">商品名</li>
	                        <li class="w125" style="width:150px">单价</li>
	                        <li class="w125" style="width:150px">数量</li>
	                        <li class="w125" style="width:150px">小计</li>
	                        <li class="w125" style="width:150px">操作</li>
	                    </ul>
	                </div>
					<table class="orderItem">
					<?php 
						if(empty($_SESSION['shopcar'])){
							echo '<p style="text-align:center;font-size:20px;">购物车空空如也，快去<a style="color:#f90;" href="./type.php">添加一件吧~~</p>';
						}else{
							$num = 0;
							$total = 0;
							foreach($_SESSION['shopcar'] as $v){
					?>	
					      <tr align="center" class="list-box b-l b-r b-b">
					      	<td style="width:150px">
					      		<a class="productDetail nameWidth f-fl" href="./details.php?id=<?=$v['id']?>" target="_blank">
					            <img height="100" width="100" src="<?=__PUBLIC__.$v['pic']?>"></a>
					      	</td>
					      	<td style="width:250px">
					      		 <a class="productDetail nameWidth f-fl" href="./details.php?id=<?=$v['id']?>" target="_blank"><?=$v['name']?></a>
					      	</td>
					      	<td style="width:150px">
					      		<div class="priceDiv">￥ <?=$v['price']?></div>
					      	</td>
					      	<td style="width:150px">
					      		<a class="jian botton-n" href="./action.php?a=cutnum&id=<?=$v['id']?>"></a>
					      		<input type="text" value="<?=$v['num']?>" readonly size="1">
					      		<a class="add botton-n" href="./action.php?a=addnum&id=<?=$v['id']?>"></a>
					      	</td>
					      	<td style="width:150px">￥ 
					      		<?=number_format(($v['num']*$v['price']),2)?>
					      	</td>      	
					      	<td style="width:150px">
					      		<a href="./action.php?a=delgoods&id=<?=$v['id']?>">删除商品</a>
					      	</td>
						</tr>
						<?php
							$num += $v['num'];
							$total += $v['price']*$v['num'];
							} }
						?>
				</table>
				<div>
		        <div> 
					<br>
		            <a href="action.php?a=delall" style="margin-left:15px;">清空购物车</a>
		            <span class="slcont">数量总计：<?=isset($num)?$num:'';?>件</sapn>
		        </div>
		        <div class="under-b">
	                <div class="jine left">总计(不含运费)：<font class="monney"><?=isset($num)?'￥'.number_format($total, 2):'';?></font>
	                </div>
	                <div style="float:right">
	                    <a class="then" href="type.php">&lt;&lt;继续购物</a>
	                    <a href="./confirm.php" class="go">去结算&gt;&gt;</a>
	                </div>
		        </div>
		    </div>
		</div>
	</div>
</div>


    <!-- end content -->

 <?php
    include_once './Public/home_footer.php';

 ?>

</body></html>