<?php
    session_start();
    include_once '../Public/config.php';
    if(empty($_SESSION['home_info'])){
        header('location:login.php');
        exit;
    }
    if(empty($_GET['oid'])){
        header('location:home.php');
        exit;
    }
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('连接服务器失败');
    mysqli_set_charset($link,'utf8');
    $oid = $_GET['oid'];
    // 通过订单号找到用户ID uid和地址ID aid，以及具体商品ID
    $sql = "select * from ".FIX."order where id=$oid";
    $res = mysqli_query($link,$sql);
    if($res && mysqli_num_rows($res)>0){
        // 找到用户的订单信息，赋值给$row
        $order = mysqli_fetch_assoc($res);
    }else{
        header('location:home.php');
        exit;
    }
    if(($_SESSION['home_info']['id'])!=$order['uid']){
        header('location:personal.php');
        exit;
    }
    // 通过订单号找到用户地址ID
    $sql2 = "select * from ".FIX."address where id={$order['aid']}";
    $res2 = mysqli_query($link,$sql2);
    if($res2 && mysqli_num_rows($res2)>0){
        $address = mysqli_fetch_assoc($res2);
    }else{
        header('location:home.php');
        exit;
    }
    // 通过订单号找到具体商品ID
    $sql3 = "select * from ".FIX."detail where oid=$oid";
    $res3 = mysqli_query($link,$sql3);
    if($res3 && mysqli_num_rows($res3)){
        $details = mysqli_fetch_all($res3,MYSQLI_ASSOC);
    }else{
        header('location:home.php');
        exit;
    }
    $status = [1=>'待付款',2=>'待发货',3=>'待收货',4=>'已完成'];

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script charset="utf-8" src="./css/pay/v.js"></script>
        <script src="./css/pay/hm.js"></script>
        <script src="./css/pay/flow.js"></script>
        <script src="./css/pay/analytics-min.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>订单详情-魅族商城</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./image/icon.ico" rel="shortcut icon" type="image/x-icon">
        <link href="./image/icon.ico" rel="icon" type="image/x-icon">
        <meta name="description" content="魅族官方在线商店、魅族在线商城、魅族官网在线商店、魅族商城">
        <meta name="keywords" content="魅族商城是魅族面向全国服务的官方电子商务平台,提供魅族PRO系列、魅族MX系列和魅蓝系列等产品的预约和购买.官方正品,全国联保.">
        <link rel="stylesheet" href="./css/pay/layout-25702f0ee1.css">
        <link rel="stylesheet" href="./css/pay/payment-ff928355d2.css">
        <style>
            .layout-header-logo-link{
                background:url('./image/home/logo.png') no-repeat;
            }
            .go{
                display: inline-block;
                height: 50px!important;
                width: 200px;
                font-size: 20px;
                line-height: 50px;
                text-align: center;
                margin-bottom: 20px;
                outline: none;
                cursor: pointer;
                background-color: #32a5e7;
                color: #fff;
                border-radius: 2px;
                padding: 0!important;
            }
        </style>
</head>
<body>
    <?php 
      include_once './Public/home_header.php';

    ?>

    <div class="payment">
        <div class="mzcontainer">
            <div class="order-header">
                <div class="order-header-title">
                    在线支付
                </div>
                <ul class="order-header-bread">
                    <li class="order-header-bread-block active">确认订单</li>
                    <li class="order-header-bread-block active">在线支付</li>
                    <li class="order-header-bread-block">完成</li>
                </ul>
            </div>
            <div class="payment-body">
                <div class="payment-info clearfix">
                    <i class="order-font payment-success"></i>
                    <div class="payment-info-content">
                        <div class="payment-info-title">订单状态: <?=$status[$order['status']]?>，金额
                            <span class="payment-info-total"><?=$order['total']?></span>
                        </div>
                        <p class="payment-info-desc">订单号：<?=$order['id']?>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="payment-info-time" id="paymentInfoTime"> </span> 下单时间：<?=date("Y-m-d H:i:s",$order['addtime'])?>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="payment-info-time" id="paymentInfoTime"> </span>
                        </p>
                        <div class="payment-info-bottom">
                            <p class="payment-info-row">
                                <span style="vertical-align:center;line-height:80px"  class="payment-info-label">商品：</span>
                            <?php
                                foreach($details as $v){
                                    $id = $v['gid'];
                                    $sql4 = "select * from ".FIX."goods where id=$id";
                                    $res4 = mysqli_query($link,$sql4);
                                    if($res4 && mysqli_num_rows($res4)>0){
                                        $goods = mysqli_fetch_assoc($res4);
                                    }
                            ?>
                                <span style="vertical-align:center;line-height:80px" class="payment-info-product"> <img style="height:80px;border:1px solid #999" src="<?=__PUBLIC__.$goods['pic']?>"> <?=$goods['name']?> X <?=$v['num']?>件
                                    &nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <?php
                                }
                            ?>
                            </p>
                            <p class="payment-info-row">
                                <span class="payment-info-label">收件人：</span>
                                <span> <?=$address['name']?></span>
                            </p>                            
                            <p class="payment-info-row">
                                <span class="payment-info-label">电话：</span>
                                <span> <?=$address['phone']?></span>
                            </p>
                            <p class="payment-info-row">
                                <span class="payment-info-label">收货地址：</span>
                                <span> <?=$address['address']?></span>
                            </p> 
                            <div style="float:left">
                                <?php
                                    switch($order['status']){
                                        case '1':
                                            echo "<form action='action.php?a=paydone' method='post'>
                                                <input type='submit' value='立即支付' class='go'>
                                                <input type='hidden' name='oid' value='{$order['id']}'>
                                            </form>";
                                            echo "<a href='./personal.php' class='go'>返回订单中心&gt;&gt;</a>";
                                            break;
                                        case '2':
                                            echo "<a href='./personal.php' class='go'>返回订单中心&gt;&gt;</a>";
                                            break;
                                        case '3':
                                            echo "<form action='action.php?a=receive' method='post'>
                                                <input type='submit' value='确认收货' class='go'>
                                                <input type='hidden' name='oid' value='{$order['id']}'>
                                            </form>";
                                            echo "<a href='./personal.php' class='go'>返回订单中心&gt;&gt;</a>";
                                            break;
                                        case '4':
                                            echo "<a href='./personal.php' class='go'>返回订单中心&gt;&gt;</a>";
                                            break;
                                    }


                                ?>
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