<?php
    session_start();
    include_once '../Public/config.php';
    if(empty($_SESSION['home_info'])){
        header('location:login.php');
        exit;
    }
    if(empty($_GET['oid'])){
        header('location:confirm.php');
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
        header('location:confirm.php');
        exit;
    }
    // 通过订单号找到用户地址ID
    $sql2 = "select * from ".FIX."address where id={$order['aid']}";
    $res2 = mysqli_query($link,$sql2);
    if($res2 && mysqli_num_rows($res2)>0){
        $address = mysqli_fetch_assoc($res2);
    }else{
        header('location:confirm.php');
        exit;
    }
    // 通过订单号找到具体商品ID
    $sql3 = "select * from ".FIX."detail where oid=$oid";
    $res3 = mysqli_query($link,$sql3);
    if($res3 && mysqli_num_rows($res3)){
        $details = mysqli_fetch_all($res3,MYSQLI_ASSOC);
    }else{
        header('location:confirm.php');
        exit;
    }

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
        <title>收银台-魅族商城</title>
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
        </style>
</head>
<body>
    <?php 
      include_once './Public/home_header.php';

    ?>
<form action="action.php?a=paydone" method="post">
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
                        <div class="payment-info-title">订单提交成功，应付金额
                            <span class="payment-info-total"><?=$order['total']?></span>
                        </div>
                        <p class="payment-info-tips">该宝贝为付款减库存,拍下并不代表购买成功哦。请您尽快付款，付款后我们将会尽快安排发货。</p>
                        <p class="payment-info-desc">订单号：<?=$order['id']?>&nbsp;&nbsp;&nbsp;&nbsp;请您在提交订单后 
                            <span class="payment-info-time" id="paymentInfoTime"> 24小时 </span>内完成支付，否则订单会自动取消
                        </p>
                        <div class="payment-info-bottom">
                            <p class="payment-info-row">
                                <span class="payment-info-label">商品：</span>
                            <?php
                                foreach($details as $v){
                                    $id = $v['gid'];
                                    $sql4 = "select * from ".FIX."goods where id=$id";
                                    $res4 = mysqli_query($link,$sql4);
                                    if($res4 && mysqli_num_rows($res4)>0){
                                        $goods = mysqli_fetch_assoc($res4);
                                    }
                            ?>
                                <span class="payment-info-product"> <?=$goods['name']?> X <?=$v['num']?>
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
                        </div>
                    </div>
                </div>
                <div class="payment-tools">
                    <div class="mz-tab" id="mzTab">
                        <ul class="mz-tab-handlers">
                                <li class="mz-tab-handler active" data-type="bank">在线支付</li>
                                <li class="mz-tab-handler" data-type="alipayCode">支付宝扫码</li>
                                <li class="mz-tab-handler" data-type="wechatCode">微信扫码</li>
                        </ul>
                        <ul class="mz-tab-panels">
                                <li class="mz-tab-panel payment-tools-banks active" id="paymentToolsBanks">
                                    <ul class="payment-tools-list clearfix">
                                        <li class="payment-tools-label huabei" data-bank="Huabei" data-third="true">
                                            <div class="payment-tools-radio"></div>
                                            <div class="payment-tools-img"></div>
                                        </li>
                                        <li class="payment-tools-label alipay active" data-bank="Alipay" data-third="true">
                                            <div class="payment-tools-radio"></div>
                                            <div class="payment-tools-img"></div>
                                        </li>
                                    </ul>

                                    <!-- huabei -->
                                    <div class="payment-tools-huabei" id="paymentToolsHuabei">
                                </div>
                                <ul class="payment-tools-list clearfix">
                                    <li class="payment-tools-label boc" data-bank="BOCB2C">
                                        <div class="payment-tools-radio"></div>
                                        <div class="payment-tools-img"></div>
                                    </li>
                                    <li class="payment-tools-label ccb" data-bank="CCB">
                                        <div class="payment-tools-radio "></div>
                                        <div class="payment-tools-img"></div>
                                    </li>
                                    <li class="payment-tools-label abc" data-bank="ABC">
                                        <div class="payment-tools-radio "></div>
                                        <div class="payment-tools-img"></div>
                                    </li>
                                    <li class="payment-tools-label icbc" data-bank="ICBCB2C">
                                        <div class="payment-tools-radio "></div>
                                        <div class="payment-tools-img"></div>
                                    </li>
                                    <li class="payment-tools-label comm" data-bank="COMM">
                                        <div class="payment-tools-radio "></div>
                                        <div class="payment-tools-img"></div>
                                    </li>
                                    <li class="payment-tools-label cmb" data-bank="CMB">
                                        <div class="payment-tools-radio "></div>
                                        <div class="payment-tools-img"></div>
                                    </li>
                                    <li class="payment-tools-label psbc" data-bank="PSBC-DEBIT">
                                        <div class="payment-tools-radio "></div>
                                        <div class="payment-tools-img"></div>
                                    </li>
                                    <li class="payment-tools-label cib" data-bank="CIB">
                                        <div class="payment-tools-radio "></div>
                                        <div class="payment-tools-img"></div>
                                    </li>
                                </ul>
                                <a href="personal.php" class="mz-btn warning xl payment-tools-submit" style="margin-right:200px;text-decoration:none;" type="submit">回到个人中心</a>
                                <input type="hidden" name="oid" value="<?=$oid?>">  
                                <input class="mz-btn warning xl payment-tools-submit" type="submit" value="立即支付" id="paymentToolsSubmit">
                                <input type="hidden" name="oid" value="<?=$oid?>">
                                </li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- end content -->

 <?php
    include_once './Public/home_footer.php';

 ?>

</body></html>