<?php
	session_start();
	if(!empty($_SESSION['home_info'])){
		echo "<script>alert('已登录魅族账号，请先注销再进行注册');location.href='./home.php'</script>";
		exit;
	}
?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Access-Control-Allow-Origin" content="*">
	
	<meta name="description" content="欢迎登录和注册魅族账号，您可以体验手机云服务功能，包括：在线下载应用，同步手机数据和查找手机等，让您的手机管理更加智能。">
	<meta name="keywords" content="魅族 meizu 登录flyme 云服务 查找手机 充值账号 MX M9 MX2">
	<meta content="width=1080" name="viewport">
	<title>魅族账号 - 注册</title>
	<link href="./css/register/base.css" type="text/css" rel="Stylesheet">
	<link href="./css/register/cycode.css" rel="stylesheet">
	<link href="./css/register/register.css" type="text/css" rel="Stylesheet">
	<style>
		.btn{
		    display: inline-block;
		    height: 50px!important;
		    width: 100%;
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
		.btn:hover{
			background-color: #2b8cc5;
    		color: #fff;
			}
	</style>
</head>
<body style="min-height: 800px;">
	<div id="content" class="content">
		

<div class="ucSimpleHeader" id="header">
			<a href="home.php">
				<div class="meizuLogo" style="background-image:url('./image/home/logo.png')"></div>
			</a>
		</div>
		<div class="banner-box">
			<form id="mainForm" class="main-form" action="action.php?a=register" method="post">
				<div class="tab-title">
					<a class="linkABlue" id="toTelRegister" href="javascript:void(0)">注册</a>
					
				</div>
				<br>
				<div class="normalInput">
					<input type="text" class="inp-focus" name="username" placeholder="用户名" autocomplete="off">
				</div>
				<div class="normalInput">
					<input type="password" class="inp-focus" name="pwd" placeholder="密码"  autocomplete="off">
				</div>
				<div class="normalInput">
					<input type="password" class="inp-focus" name="pwd2" placeholder="确认密码" autocomplete="off">
				</div>			

				<div class="normalInput fieldInput" style="display:none;">
                    <input id="tips-show">
                </div>
				<div id="flymeService" class="rememberField" style="font-size:12px;">
                    <label class="pointer" for="acceptFlyme" tabindex="0">点击注册，即表示您同意并愿意遵守</label>
                    <a class="linkABlue">Flyme服务协议</a>
                    <label class="pointer">和</label>
                    <a class="linkABlue">法律声明</a>
				</div>
				<input type="submit" class="btn" value="立即注册">
				<div class="transferField">
					<a class="go2register linkABlue" href="./login.php" id="toLogin">登录</a>
				</div>
			</form>
		</div>
	</div>

<?php
	include './Public/log_footer.php';



?>


</body></html>