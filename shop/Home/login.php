<?php
	session_start();
	if(!empty($_SESSION['home_info'])){
		header('location:home.php');
		exit;
	}
?>
<html>
	<head>
		<link href="./image/icon.ico" rel="shortcut icon" type="image/x-icon">
        <link href="./image/icon.ico" rel="icon" type="image/x-icon">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=11;IE=10;IE=9;IE=8;">
		<meta name="description" content="欢迎登录和注册魅族账号，您可以体验手机云服务功能，包括：在线下载应用，同步手机数据和查找手机等，让您的手机管理更加智能。">
		<meta name="keywords" content="魅族  meizu 登录flyme 云服务  查找手机  充值账号  MX M9 MX2 MX3">
		<meta content="width=1080" name="viewport">
		<title>魅族账号 - 登录 </title>
		<link href="./css/login/base.css" rel="stylesheet">
		<link href="./css/login/cycode.css" rel="stylesheet">
		<link href="./css/login/login.css" rel="stylesheet">
		<link rel="stylesheet" href="./css/style_https.3.1.1.css">
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
<body>
	<div id="content" class="content">
		<div class="ucSimpleHeader" id="header">
			<a href="home.php">
				<div class="meizuLogo" style="background-image:url('./image/home/logo.png')"></div>
			</a>
		</div>
		<div style="background-image:url('image/login/banner.png')" class="banner-box">
			<form id="mainForm" class="main-form" method="post" action="action.php?a=login">
				<div class="tab-title">
					<a class="linkABlue" id="toAccountLogin" href="javascript:void(0);">账号登录</a>
				</div>
				<br>
				<div class="normalInput cycode-box fieldInput" id="cycode-box">
					<div class="cycode-selectbox">
                    <span class="cycode-selected">
                        <input class="ipt-cycode" readonly="" id="cycode" value="+86" name="cycode">
                        <i class="arrow-down"></i>
                    </span>
						<input class="ipt-account inp-focus" name="username" id="account" maxlength="50" placeholder="魅族账号" autocomplete="off">
					</div>
				</div>
				<div class="normalInput fieldInput">
					<input type="password" class="inp-focus" name="pwd" id="password" placeholder="密码" autocomplete="off">
				</div>

				<div class="normalInput fieldInput" style="display:none;">
                    <input id="tips-show">
                </div>

				<input type="submit" class="btn" value="提交">
				<div class="transferField">
					<a class="go2register linkABlue" href="./register.php">注册</a>
				</div>
			</form>
		</div>
	</div>


<?php
	include_once './Public/log_footer.php';
?>

<div id="ads"></div></body></html>