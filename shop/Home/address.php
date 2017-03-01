<?php
	session_start();
	if(empty($_SESSION['home_info'])){
		echo "<script>alert('亲，请先登录账号~');location.href='./login.php'</script>";
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
<!-- 引入头部文件 -->
<?php
    include_once './Public/home_header.php';
    include_once '../Public/config.php';
?>
<form action="action.php?a=addaddress" method="post">
	<div class="store-wrap">
<!-- 左侧导航栏开始 -->
	    <div class="crumbs">
			<a href="home.php">首页&gt;</a>
	        <a class="active">地址管理</a>
	    </div>
	    <div class="main clearfix">
	    <div class="left-nav f-fl">
	        <div class="nav-main">
	            <a href="javascript:;" class="type-title"><i class="iconfont icon-orderCenter"></i>订单中心</a>
	            <a href="personal.php" class="ml ">我的订单</a>
	            <a href="javascript:;" class="type-title"><i class="iconfont icon-selfCenter"></i>个人中心</a>
	            <a href="./account.php" class="ml ">账号信息</a>
	            <a href="./address.php" class="ml ">地址管理</a>
	            <a href="./shopcar.php" class="ml ">我的购物车</a>
	        </div>
	    </div>
<!-- 左侧导航栏结束 -->	   
	        <div class="right-content f-fr">
	            <div class="address-main">
	                <div class="main">
	                    <div class="row">
	                        <span class="title rollit">新增收货地址</span>
	                        <span class="gray">（您目前已有地址<i class="already">1</i>个，最多还可以增加<i class="settle">9</i>个）</span>
	                    </div>
	                    <form id="valid-form">
	                        <div class="content">
	                            <div class="row namePhone clearfix">
	                                <div class="f-fl addressName">
	                                    <span>收货人姓名<i class="mark">*</i></span>
	                                    <input id="name" class="varify" name="name" type="text" placeholder="长度为2-12个字以内" maxlength="12">
	                                </div>
	                                <div class="f-fl addressPhone">
	                                    <span>收货人手机号<i class="mark">*</i></span>
	                                    <input id="phone" name="phone" class="varify" type="text" placeholder="请输入11位手机号" maxlength="11">
	                                </div>
	                            </div>
	                            <div class="row  detailAddress">
	                                <span>收件人地址<i class="mark">*</i></span>
	                                <input id="detailAddress" name="address" class="varify" type="text" placeholder="请输入3个字以上，50个字以下的详细地址，例如：广东省广州市天河区兄弟连教育" maxlength="50">
	                            </div>
	                            <div class="opreat">
	                                <input type="submit" class="saveAddress" value="保存">                    
	                                <a href="confirm.php" class="saveAddress">返回结算页</a>
	                            </div>
	                        </div>
	                    </form>
						
	                    <div class="list">
	                        <div class="row">
	                            <div class="title">
	                                <div>已有地址</div>
	                                <div class="upload hide">
	                                    <i class="iconfont icon-zhuyi"></i>
	                                    <span>因配送地址库数据升级，请点击地址进行升级，让您享受更好的配送服务！</span>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="listHead">
	                            <span class="center w15">收货人姓名</span>
	                            <span class="center w35">收货人地址</span>
	                            <span class="center w25">收货人手机号</span>
	                            <span class="center w10">操作</span>
	                        </div>

	                    <?php
	                        $uid = $_SESSION['home_info']['id'];
	                        $sql = "select * from ".FIX."address where uid=$uid";
	                        $res = mysqli_query($link,$sql);
	                        if($res && mysqli_num_rows($res)>0){
	                            $dizhis = mysqli_fetch_all($res,MYSQLI_ASSOC);
	                            // var_dump($dizhis);exit;
	                            foreach($dizhis as $v){?>
	                                <ul id="tableList" class="">
	                                    <li class="">
	                                        <input class="addressId" type="hidden" value="6499090496000">
	                                        <input class="isOld" type="hidden" value="0">
	                                        <span class="center w15"><?=$v['name']?></span>
	                                        <span class="completeAddress center w35"><?=$v['address']?></span>
	                                        <span class="center w25"><?=$v['phone']?></span>
	                                        <span class="center w10">
	                                            <a class="edit" href="editaddress.php?id=<?=$v['id']?>">修改</a>
	                                            <a class="delete" href="action.php?a=deladdress&id=<?=$v['id']?>">删除</a>
	                                        </span>
	                                        <span class="left w15">
	                                        </span>
	                                    </li>
	                                </ul>
		                        <?php
		                            }
		                        }
		                    ?>
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