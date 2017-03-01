<?php
	session_start();
    if(empty($_SESSION['home_info'])){
        header('location:login.php');
        exit;
    }
    if(empty($_GET['id'])){
    	header('location:address.php');
    	exit;
    }

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script charset="utf-8" src="./css/address/v.js"></script>
        <script src="./css/address/hm.js"></script>
        <script src="./css/address/flow.js"></script>
        <script src="./css/address/analytics-min.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>会员中心-地址管理</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./image/icon.ico" rel="shortcut icon" type="image/x-icon">
        <link href="./image/icon.ico" rel="icon" type="image/x-icon">
        <meta name="description" content="会员中心，地址管理">
        <meta name="Keywords" content="魅族手机官网商城，魅族官方在线商店、魅族在线商城、魅族官网在线商店、魅族商城">
        <link rel="stylesheet" href="./css/address/layout-25702f0ee1.css">
        <link rel="stylesheet" href="./css/address/address-a3c96e731b.css">
        <link rel="stylesheet" href="./css/address/site-base.css">
    </head>
<body>
<!-- common header -->
<?php
    include_once './Public/home_header.php';
    include_once '../Public/config.php';
?>
<form action="action.php?a=editaddress" method="post">
	<div class="store-wrap">
	    <div class="crumbs">
			<a href="">首页&gt;</a>
			<a href="">我的商城&gt;</a>
	        <a href="./css/address/address.php" class="active">地址管理</a>
	    </div>
	    <div class="main clearfix">
	    <div class="left-nav f-fl">
	        <div class="nav-main">
	            <a href="javascript:;" class="type-title"><i class="iconfont icon-orderCenter"></i>订单中心</a>
	            <a href="" class="ml ">我的订单</a>
	            <a href="javascript:;" class="type-title"><i class="iconfont icon-selfCenter"></i>个人中心</a>
	            <a href="./account.php" class="ml ">账号信息</a>
                <a href="./address.php" class="ml ">地址管理</a>
                <a href="./shopcar.php" class="ml ">我的购物车</a>
	        </div>
	    </div>
        <div class="right-content f-fr">
            <div class="address-main">
                <div class="main">
                    <div class="row">
                        <span class="title rollit">新增收货地址</span>
                        <span class="gray">（您目前已有地址<i class="already">1</i>个，最多还可以增加<i class="settle">9</i>个）</span>
                    </div>
                    <?php
                    	$id = $_GET['id'];
                        $sql2 = "select * from ".FIX."order o where o.aid=$id ";
                        $res2 = mysqli_query($link,$sql2);
                        if($res2 && mysqli_num_rows($res2)>0){
                            echo "<script>alert('该地址已有订单使用，无法修改');location.href='address.php'</script>";
                            exit;
                        }
                    	$sql = "select * from ".FIX."address where id = $id limit 1";
                    	$res = mysqli_query($link,$sql);
                    	if($res && mysqli_num_rows($res)>0){
                    		$row = mysqli_fetch_assoc($res);
                    	}else{
                    		header('location:address.php');
                    		exit;
                    	}


                    ?>
                        <!-- 修改地址时要用的地址id -->
                        <input name="id" type="hidden" value="<?=$id?>">
                        <div class="content">
                            <div class="row namePhone clearfix">
                                <div class="f-fl addressName">
                                    <span>收货人姓名<i class="mark">*</i></span>
                                    <input id="name" class="varify" name="name" value="<?=$row['name']?>" type="text" placeholder="长度为2-12个字以内" maxlength="12">
                                </div>
                                <div class="f-fl addressPhone">
                                    <span>收货人手机号<i class="mark">*</i></span>
                                    <input id="phone" name="phone" class="varify"  value="<?=$row['phone']?>" type="text" placeholder="请输入11位手机号" maxlength="11">
                                </div>
                            </div>
                            <div class="row  detailAddress">
                                <span>收件人地址<i class="mark">*</i></span>
                                <input id="detailAddress" name="address"  value="<?=$row['address']?>" class="varify" type="text" placeholder="请输入3个字以上，50个字以下的详细地址，例如：广东省广州市天河区兄弟连教育" maxlength="50">
                            </div>
                            <div class="opreat">
                                <input type="submit" class="saveAddress" value="保存">                    
                                <a href="confirm.php" class="saveAddress">返回结算页</a>
                            </div>
                        </div>
	                </div>
	            </div>       
	        </div>
	    </div>
	</div>
</form>



 <?php
    include_once './Public/home_footer.php';

 ?>

<script src="./css/address/layout-25a9646b18.js" type="text/javascript"></script>

    <script type="text/javascript" src="./css/address/address-cc23fce232.js"></script><div class="mzui_select_content" id="mzuiSelect-provinceId"><ul><li class="mzui_select_item mzui_select_item_selected" data-value="" data-zipcode="undefined"></li><li class="mzui_select_item" data-value="2911" data-zipcode="undefined">北京</li><li class="mzui_select_item" data-value="14848" data-zipcode="undefined">天津</li><li class="mzui_select_item" data-value="7450" data-zipcode="undefined">吉林省</li><li class="mzui_select_item" data-value="8452" data-zipcode="undefined">辽宁省</li><li class="mzui_select_item" data-value="16860" data-zipcode="undefined">浙江省</li><li class="mzui_select_item" data-value="1" data-zipcode="undefined">福建省</li><li class="mzui_select_item" data-value="16624" data-zipcode="undefined">上海</li><li class="mzui_select_item" data-value="18482" data-zipcode="undefined">广东省</li><li class="mzui_select_item" data-value="21612" data-zipcode="undefined">海南省</li><li class="mzui_select_item" data-value="41143" data-zipcode="undefined">湖北省</li><li class="mzui_select_item" data-value="42634" data-zipcode="undefined">湖南省</li><li class="mzui_select_item" data-value="36793" data-zipcode="undefined">安徽省</li><li class="mzui_select_item" data-value="15121" data-zipcode="undefined">江苏省</li><li class="mzui_select_item" data-value="1214" data-zipcode="undefined">江西省</li><li class="mzui_select_item" data-value="27304" data-zipcode="undefined">四川省</li><li class="mzui_select_item" data-value="35714" data-zipcode="undefined">重庆</li><li class="mzui_select_item" data-value="34187" data-zipcode="undefined">云南省</li><li class="mzui_select_item" data-value="23366" data-zipcode="undefined">贵州省</li><li class="mzui_select_item" data-value="20238" data-zipcode="undefined">广西壮族自治区</li><li class="mzui_select_item" data-value="32166" data-zipcode="undefined">西藏自治区</li><li class="mzui_select_item" data-value="11241" data-zipcode="undefined">山东省</li><li class="mzui_select_item" data-value="38498" data-zipcode="undefined">河南省</li><li class="mzui_select_item" data-value="21894" data-zipcode="undefined">甘肃省</li><li class="mzui_select_item" data-value="3251" data-zipcode="undefined">河北省</li><li class="mzui_select_item" data-value="10088" data-zipcode="undefined">内蒙古自治区</li><li class="mzui_select_item" data-value="25024" data-zipcode="undefined">宁夏回族自治区</li><li class="mzui_select_item" data-value="25305" data-zipcode="undefined">青海省</li><li class="mzui_select_item" data-value="13289" data-zipcode="undefined">山西省</li><li class="mzui_select_item" data-value="25761" data-zipcode="undefined">陕西省</li><li class="mzui_select_item" data-value="32939" data-zipcode="undefined">新疆维吾尔自治区</li><li class="mzui_select_item" data-value="5700" data-zipcode="undefined">黑龙江省</li></ul></div><div class="mzui_select_content" id="mzuiSelect-cityId"><ul></ul></div><div class="mzui_select_content" id="mzuiSelect-areaId"><ul></ul></div><div class="mzui_select_content" id="mzuiSelect-townId"><ul></ul></div>
    <!--common js-->
<script>
    var __mzt = __mzt || [];
    (function () {
        var hm = document.createElement("script");
        hm.src = "//sccom.res.meizu.com/js/analytics-min.js";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

<script type="text/javascript" charset="utf-8">
    var _hmt = _hmt || [];
    (function () {
        var hm = document.createElement("script");
        hm.src = ('https:' == document.location.protocol ? 'https://tongji-res.meizu.com' : 'http://tongji-res1.meizu.com') + '/resources/tongji/flow.js';
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

<script type="text/javascript">
    var _hmt = _hmt || [];
    (function () {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?2a0c04774115b182994cfcacf4c122e9";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>


</body></html>