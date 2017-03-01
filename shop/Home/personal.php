<?php
	session_start();
	include_once '../Public/config.php';
	$link = mysqli_connect(HOST,USER,PWD,DB) or die('数据库连接失败');
	mysqli_set_charset($link,'utf8');
	if(empty($_SESSION['home_info'])){
		echo "<script>alert('亲，请先登录账号~');location.href='./login.php'</script>";
		exit;
    }else{
        $panduan = $_SESSION['home_info']['id'];
        $sql5 = "select * from ".FIX."user where id=$panduan ";
        $chazhao = mysqli_query($link,$sql5);
        if($chazhao && mysqli_num_rows($chazhao)<=0){
            unset($_SESSION['home_info']);
            header('location:home.php');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<script src="css/personal/v.htm" charset="utf-8"></script>
	<script src="css/personal/hm.js"></script>
	<script src="css/personal/flow.js"></script>
	<script src="css/personal/analytics-min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>个人中心-魅族商城</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="./image/icon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="./image/icon.ico" rel="icon" type="image/x-icon">
    <meta name="description" content="魅族商城是魅族面向全国服务的官方电子商务平台,提供魅族PRO系列、魅族MX系列和魅蓝系列等产品的预约和购买.官方正品,全国联保.">
    <meta name="keywords" content="魅族官方在线商店、魅族在线商城、魅族官网在线商店、魅族商城">
    <link rel="stylesheet" href="css/personal/layout-25702f0ee1.css">
	<link rel="stylesheet" href="css/personal/order-newPayment-a3c96e731b.css">
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
	<?php
	    include_once './Public/home_header.php';
	?>
<!-- common header -->
    <div class="store-wrap">
        <div class="crumbs">
            <a href="home.php">首页&gt;</a><a href="personal.php" class="active">我的订单</a>
        </div>
        <div class="main clearfix">
    <div class="left-nav f-fl">
        <div class="nav-main">
            <a href="javascript:;" class="type-title"><i class="iconfont icon-orderCenter"></i>订单中心</a>
            <a href="" class="ml active">我的订单</a>
            <a href="javascript:;" class="type-title"><i class="iconfont icon-selfCenter"></i>个人中心</a>
            <a href="./account.php" class="ml ">账号信息</a>
            <a href="./address.php" class="ml ">地址管理</a>
            <a href="./shopcar.php" class="ml ">我的购物车</a>
        </div>
    </div>
            <div class="right-content f-fr">
                <div class="order-main">
                    <div class="type-tab-btn">
                        <a href="personal.php" class="allOrder" data-type="-1">全部订单</a>
                        <i class="line">|</i>
                        <a class="waitPay" href="./personal.php?status=1" data-type="0">待付款
                        	<span class="amount _actAmount"></span>
                        </a>
                        <i class="line">|</i>
                        <a class="waitDeliver" href="./personal.php?status=2" data-type="1">待发货</a>
                        <i class="line">|</i>
                        <a class="hasDeliver" href="./personal.php?status=3" data-type="2">待收货</a>
                        <i class="line">|</i>
                        <a class="other" href="./personal.php?status=4" data-type="99">已完成</a>
                    </div>
                    <div class="list-head">
                        <ul class="clearfix">
                            <li class="w50">订单明细</li>
                            <li class="w125">售后</li>
                            <li class="w125">金额</li>
                            <li class="w125">状态</li>
                            <li class="w125">操作</li>
                        </ul>
                    </div>
					<?php
					    include_once './Public/home_header.php';
					    include_once '../Public/config.php';
					    $uid = $_SESSION['home_info']['id'];
					    $status =isset($_GET['status'])?$_GET['status']:'';
					    if(!empty($status)){
					    	$sql = "select * from ".FIX."order where uid=$uid and status=$status order by addtime desc";

					    }else{
					    	$sql = "select * from ".FIX."order where uid=$uid order by addtime desc";
					    }
					    $res = mysqli_query($link,$sql);
					    if($res && mysqli_num_rows($res)>0){
					    	$orders = mysqli_fetch_all($res,MYSQLI_ASSOC);

					    }else{
					    	echo "<p style='text-align:center;font-size:20px;'>亲，该状态下查不到订单，<a href='personal.php' style='color:#f90'>点击查看所有订单吧~~</a></p>";
					    	exit;
					    }
                    	$status = [1=>'待付款',2=>'待发货',3=>'待收货',4=>'已完成'];
                    	foreach($orders as $v){?>
		                    <div id="tableList" class="type-contain ui-load-container">
		                    	<div class="ui-load-content">
		                    		<input id="unPayNum" value="0" type="hidden">
										<table class="orderItem">
										      <tbody>
										      <tr class="trHead">
										          <td colspan="5" class="title">
										              下单时间：<span style="text-align:center;display:inline-block;width:150px;"class="time"><?=date("Y-m-d H:i:s",$v['addtime'])?></span>
										              订单号：<span style="display:inline-block;width:70px;"class="orderNumber"><?=$v['id']?></span>
										              合计：<span class="orderNumber" style="display:inline-block;width:70px;"><?=$v['total']?></span>
										              订单状态：<span style="display:inline-block;width:70px;" class="orderNumber"><?=$status[$v['status']]?></span>
										              收件人信息：<span style="display:inline-block;width:70px;" class="orderNumber"><a href='orderdetail.php?oid=<?=$v['id']?>'>点击查看</a></span>
										          </td>
										      </tr>
										      <?php
										      		$sql2 = "select * from ".FIX."detail where oid={$v['id']}";
										      		$res2 = mysqli_query($link,$sql2);
										      		if($res2 && mysqli_num_rows($res2)>0){
										      			$goods = mysqli_fetch_all($res2,MYSQLI_ASSOC);
										      		}
										      		foreach($goods as $k=>$w){
										      			$sql3 = "select * from ".FIX."goods where id={$w['gid']}";
										      			$res3 = mysqli_query($link,$sql3);
										      			if($res3 && mysqli_num_rows($res3)>0){
										      				$product = mysqli_fetch_assoc($res3);
										      			}
										      			?>
										      			<tr class="list-box b-l b-r b-b">
										          <td style="width:200px;" class="list b-r">
										              <div class="item clearfix">
										                  <a class="productDetail nameWidth f-fl" href="details.php?id=<?=$product['id']?>" target="_blank">
										                  <img src="<?=__PUBLIC__.$product['pic']?>"></a>
										                  <div class="describe f-fl">
										                      <div class="vertic">
										                          <span class="clearfix">
										                              <a class="productDetail nameWidth f-fl" href="details.php?id=<?=$product['id']?>" target="_blank"><?=$product['name']?></a>
										                              <i class="f-fr"><?=$w['num']?>件</i>
										                          </span>
										                      </div>
										                  </div>
										              </div>
										          </td>
										          <td style="width:100px;">
										          	<div></div>
										          </td>
										          <td class="b-r w125 center state">
										              <div class="stateDiv">
										                 ￥ <?=$product['price']?><br>
										              </div>
										          </td>
										          <td class="b-r w125 center price">
										              <div class="priceDiv">
										                  ￥ <?=$product['price']*$w['num']?>
										              </div>
										          </td>
										          <td class="w125 center opreat">
										              <ul>
										                  <input class="_isOld" value="true" type="hidden">
											                  	<li class="more">
											                  		<?php
											                  			switch($v['status']){
											                  				case '1':
											                  					echo "<form action='action.php?a=paydone' method='post'>
											                  						<input type='submit' value='立即付款'>
											                  						<input type='hidden' name='oid' value='{$v['id']}'>
											                  					</form>";
											                  					break;
											                  				case '2':
											                  					echo '等待卖家家发货';
											                  					break;
											                  				case '3':
											                  					echo "<form action='action.php?a=receive' method='post'>
											                  						<input type='submit' value='确认收货'>
											                  	 					<input type='hidden' name='oid' value='{$v['id']}'>
											                  					</form>";
											                  					break;
											                  				case '4':
											                  					echo '已完成';
											                  					break;
											                  			}
											                  		?>
											                  	</li>
										                  	</form>
										              </ul>
										          </td>
										      </tr>
							      			<?php }
									     ?>
									</tbody>
								</table>
							</div>
						</div>
                    	<?php	
                    	}
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- common js -->

    <!-- end content -->

 <?php
    include_once './Public/home_footer.php';

 ?>

</body></html>