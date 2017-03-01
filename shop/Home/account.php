<?php
	session_start();
?>

<html>
<head>
	<link href="./image/icon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="./image/icon.ico" rel="icon" type="image/x-icon">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="description" content="欢迎登录和注册魅族账号，您可以体验手机云服务功能，包括：在线下载应用，同步手机数据和查找手机等，让您的手机管理更加智能。">
	<meta name="keywords" content="魅族  meizu 登录flyme 云服务  查找手机  充值账号  MX M9 MX2">
	<meta content="width=1080" name="viewport">
	<title>账号管理</title>
	<link href="./css/account/base.css" type="text/css" rel="Stylesheet">
	<link href="./css/account/head.css" type="text/css" rel="Stylesheet">
	<link href="./css/account/cycode.css" rel="stylesheet">
	<link href="./css/account/actmanage.css" type="text/css" rel="Stylesheet">
	<link rel="stylesheet" href="./css/home/layout-ea436a570a.css">
</script>
</head>
<body style="min-height: 848px;">
<!-- 包含页头 -->
<?php
	include './Public/home_header.php';
?>

<div class="flymeContent">
		
<style type="text/css">
	.navWrap{
		height: 58px;
		border-bottom: #e4e7e9 1px solid;
	}
	.navWrap .nav{
		display: block;
		float: left;
		line-height: 58px;
	}
	.navWrap .nav li{
		position: relative;
		display: inline-block;
		margin-right: 40px;
		width: 100px;
		height: 100%;
		float: left;
	}
	.navWrap .nav li a{
		display: inline-block;
		width: 100%;
		height: 56px;
		font-size: 16px;
		text-align: center;
	}
	.navWrap .nav .current{
		margin: 0px auto;
		height: 2px;
		width: 100px;
		overflow: hidden;
		background-color: #1daeed;
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
<div id="navWrap" class="navWrap">
	<ul class="nav">
		<li id="accountManage"><a href="./css/user/账号管理.html" class="linkABlue">账号管理</a><div class="current"></div></li>
		
	</ul>
</div>
<div class="clear"></div>
<?php
    include_once './Public/home_header.php';
    include_once '../Public/config.php';
	if (empty($_SESSION['home_info'])) {
		header('location:login.php');
		exit;
	}
	$id = $_SESSION['home_info']['id'];
	$sql = 'select * from '.FIX."user where id=$id";
	// echo $sql;
	$res = mysqli_query($link,$sql);
	// var_dump($res);
	if ($res && mysqli_num_rows($res) > 0) {
		$arr = mysqli_fetch_assoc($res);	
	}else{
		$arr = '';
	}
	switch ($arr['sex']) {
		case 1:
			$arr['sex'] = '男';
			break;
		case 2:
			$arr['sex'] = '女';
			break;
		case 3:
			$arr['sex'] = '保密';
			break;

	}
	// var_dump($arr);

	?>
			<div class="topWrap">
				<div class="top-leftWrap">
				<?php 
					if(!empty($arr['pic'])){
						$src = __PUBLIC__.'touxiang/'.$arr['pic'];
						$img ="<img id='userImg' src='$src'/>";
						echo $img;
					}else{
					}
				?>
					
					<!-- <a id="modifyIconTip" class="modifyIconTip modify">编辑头像</a> -->
					<!-- <a class="modifyIconTip-bg"></a> -->
				</div>
				<div class="top-rightWrap">
					<div id="nickNameTitle" class="lineWrap nickname">
						<label id="nickName">
						账号：<br><input style="visibility:hidden" size="2"><?=$arr['username']?>
						</label>
						<a id="nickNameEdite" class="pointer modify"><i class="i_icon"></i></a>


						<div id="getFunnyName" class="fleft getFunnyName" style="display: none">
							<div class="fullBtnBlue fleft">
								<a class="getFunnyNameTitle pointer fleft">抢昵称</a>
							</div>
							<div class="fleft nickname_tips">
								<span id="funnyNameClose" class="fleft">
									<span class="funnyNameWrap">大家都在抢注昵称，赶快去抢哦!</span>
									<a class="funnyNameClose">
										<i class="i_icon pointer"></i>
									</a>
								</span>
							</div>
						</div>
					</div>
					<div id="nickNameCon" class="lineWrap modify_content nickNameCon" style="display: none">
						<form style="*display:inline" novalidate="novalidate">
							<div class="lineWrap">
								<input type="text" value="" name="nickname" id="newnickName" class="normalInput">
							</div>
							<div class="clear"></div>
							<div class="edit">
								<a class="fullBtnBlue save_form fleft" id="editSave">保存</a>
								<a class="fullBtnGray cancel_form fleft" id="editCancel">取消</a>
							</div>
							<div class="clear"></div>
						</form>
					</div>
					<div class="lineWrap grayTip nameWrapTop" id="getaccountNameWrap">
						<label></label>
						<span id="userName"></span>
						
					</div>
					<div id="setUserNameWrap" class="lineWrap grayTip ftop" style="display: none">
						<a id="setuserName" class="blue modify" href="javascript:;">设置魅族账号</a>
					</div>
					<div id="setaccount" class="modify_content" style="display: none">
						<form novalidate="novalidate">
						<div>
							<div class="normalInput">
								<input type="text" value="" name="account" id="flyme" class="username" maxlength="32" placeholder="账号">
								<span class="grayTip flymeSpan">@flyme.cn</span>
							</div><div class="clear"></div>
							<label class="flymeTip">账号保存后不可修改</label>
						</div>
							<div class="clear"></div>
							<div class="fBtnleft">
								<a class="fullBtnBlue save_form fleft" id="newSave">保存</a>
								<a class="fullBtnGray cancel_form fleft" id="newCancel">取消</a>
								<div class="clear"></div>
							</div>
						</form>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="mainWrap">
				<div class="titleWrap grayBorderB grayBorderTop">
					<div class="title-leftWrap">
						<span>账号安全</span>
					</div>
					<div class="title-rightWrap">
						<span>安全等级：</span>
						<span id="safeLevel" class="green">100</span>
						<a id="safeLevelTip" class="pointer"><i class="i_icon"></i></a>
					</div>
					<div class="clear"></div>
				</div>
				<div class="bodyWrap">
					<div id="pwdWrap" class="lineWrap pwdWrapTop">
						<div class="item-right"><a href="editaccount.php" class="linkABlue modify" id="modifyPassword">修改</a></div>
						<div class="item-left">密码</div>
						<div class="item-middle">
							<span id="current_email" class="email bold">**********</span><br>
						</div>
						<div class="clear"></div>
					</div>
					<!-- 修改密码 验证密码 -->
					<div id="changePasswordWrapFirst" class="grayBorderT grayBorderB modify_content" style="display:none;">

							<form class="setQuestion-bodyWrap" novalidate="novalidate">
									<div class="lineWrap">
										<div class="leftWrap">
											<label class="leftLabel">手机号</label>
										</div>
										<input type="text" value="" data-key="kapkey" name="bindPhone" id="ce-u-check-phone" class="normalInput" maxlength="11">
									</div>
									<div class="lineWrap">
										<div class="leftWrap">
											<label class="leftLabel">验证码</label>
										</div>
										<div class="normalInput bottom">
											<input type="text" name="kapkey" id="kapkeyTel-check-phone" class="kapkey" maxlength="6" autocomplete="off">
											<span class="form-line"></span>
											<a id="getKey-checkPhoneOld" data-value="23" data-action="bindPhone" href="javascript:void(0);" data-type="1" class="linkABlue invalidBtn get_kapkey">获取验证码</a>
											<a href="javascript:void(0);" class="linkABlue kapkey_requested" style="display:none;">已发送 <span class="interval_num">60</span></a>
										</div>
										<div clear="clear"></div>
									</div>
									<div class="lineWrap">
										<label class="fleft">&nbsp;</label>
										<a class="fullBtnBlue save_form fleft" id="ce-u-pwd-phone-check">下一步</a>
										<a class="fullBtnGray cancel_form fleft" id="ce-u-pwd-phone-cancel">取消</a>
										<div class="clear"></div>
									</div>
										<div class="clear"></div>
							</form>
					  
						
					</div>

					<div id="changePasswordWrap" class="grayBorderB modify_content" style="display:none;">
						<div class="cEmail-titleWrap">
							<span>修改密码</span>
						</div>
						<form class="cEmail-bodyWrap" enctype="application/x-www-form-urlencoded" novalidate="novalidate">
							<div class="lineWrap">
								<div class="leftWrap">
									<label class="leftLabel">原密码</label>
								</div>
								<input type="password" value="" name="password" id="ce-u-current_pwd" class="normalInput" maxlength="16">
							</div>
							<div class="lineWrap">
								<div class="leftWrap">
									<label class="leftLabel">新密码</label>
								</div>
								<div class="normalInput">
									<input type="text" value="" name="resetPassword" id="ce-u-new_pwd1" maxlength="16" autocomplete="off">
									<input type="password" value="" id="ce-u-new_pwd2" maxlength="16" autocomplete="off" style="display:none">
									<a id="pwdBtn" class="pwdBtnShow noselect" onselectstart="return false">
										<i class="i_icon"></i>
									</a>
									<div class="clear"></div>
								</div>
							</div>
							<div class="lineWrap">
								<label class="fleft">&nbsp;</label>
								<a href="javascript:;" class="fullBtnBlue save_form fleft" id="ce-u-pwdsave">保存</a>
								<a href="javascript:;" class="fullBtnGray cancel_form fleft" id="ce-u-pwdcancel">取消</a>
								<div class="clear"></div>
							</div>
						</form>
					</div>
					<div id="emailWrap" class="lineWrap">
						<!--if未验证 -->
						<div class="item-right" style="display:none;">
							<a id="emailbindEdite" href="editaccount.php" class="linkABlue modify" data-type="modify">修改</a>
						</div>
						<!-- end if -->
						<!--if已验证  -->
						<div class="item-right">
							<a id="emailEdite" href="editaccount.php" class="linkABlue modify" data-type="modify">修改</a>
						</div>
						<!-- end if -->
						<!--if-->
						<div class="item-right" style="display:none;">
							<a id="emailBind" href="javascript:void(0);" class="linkABlue modify" data-type="bind">绑定</a>
						</div>
						<div class="item-left">QQ号</div>
						<!--if-->
						<div class="item-middle" id="email-item-middle1">
							<span id="current_email" class="email bold"><?=$arr['qq']?></span><br>
						</div>
						<!-- end if -->
						<!--if-->
						<div class="item-middle" id="email-item-middle2" style="display:none;">
							<span class="bold">未绑定</span><br>
							<span class="grayTip">绑定后可通过邮箱找回密码</span>
						</div>
						<!-- end if -->
						<!--if-->
						<div class="item-middle" id="email-item-middle3" style="display:none;">
							<!-- <span class='bold'>绑定未激活</span><br> -->
							<span class="email bold">2****023@qq.com</span><br>
							<span id="notice" class="ftipright">已发验证邮件，请尽快验证</span>
							<a id="renotice" href="javascript:void(0);" data-status="1" class="linkABlue renotice">重发</a>
							<span id="timeup" class="timeup" style="display:none;">60</span>
							<br>
							<span class="grayTip">验证后可在互动社区发帖、回复等，还可通过邮箱找回密码，提高账号安全级别</span>
						</div>
						<!-- end if -->
						<!-- end if -->
						<div class="clear"></div>
					</div>
					<!-- //绑定输入框 -->
					<!-- 绑定邮箱第一步，需要先验证密码 -->
					<div id="bindEmail-step1" class="grayBorderT grayBorderB modify_content " style="display:none;">
						<div class="cEmail-titleWrap">
							<span id="editEmail">绑定邮箱（验证密码）</span>
						</div>
						<form class="cEmail-bodyWrap" novalidate="novalidate">
							<div class="lineWrap">
								<div class="leftWrap">
									<label class="leftLabel">账号密码</label>
								</div>
								<input type="password" value="" name="password" id="ce-u-password-bind" class="normalInput" maxlength="16">
							</div>

							<div class="lineWrap">
								<label class="fleft">&nbsp;</label>
								<a class="fullBtnBlue ce-u-save save_form fleft" id="bindEmail-step1-savenext">下一步</a>
								<a class="fullBtnGray ce-u-cancel cancel_form fleft" id="bindEmail-step1-savenextcancel">取消</a>
								<div class="clear"></div>
							</div>
									<div class="clear"></div>
						</form>
					</div>
					<!-- 绑定邮箱第二 -->
					<div id="bindEmailWrap" class="grayBorderT grayBorderB modify_content" style="display: none;">
						<div class="bindEmail-titleWrap">
							<span>绑定邮箱</span>
						</div>
						<form class="bindEmail-bodyWrap" novalidate="novalidate">
							<div class="lineWrap">
								<div class="leftWrap">
									<label class="leftLabel">邮箱</label>
								</div>
								<input type="text" value="" data-key="kapkey" name="email" id="ce-u-bind_email" class="normalInput" maxlength="32">
							</div>
							<div class="lineWrap">
								<div class="leftWrap">
									<label class="leftLabel">邮件验证码</label>
								</div>
								<div class="normalInput bottom">
									<input type="text" name="kapkey" id="kapkey" class="kapkey" maxlength="6" autocomplete="off">
									<span class="form-line"></span>
									<a id="getKey-bindEmail" data-value="5" href="javascript:void(0);" data-type="1" class="linkABlue invalidBtn get_kapkey">获取验证码</a>
									<a href="javascript:void(0);" class="linkABlue kapkey_requested" style="display:none;">已发送 <span class="interval_num">60</span></a>
								</div>
							</div>
							<div class="lineWrap">
								<label class="fleft">&nbsp;</label>
								<a class="fullBtnBlue ce-u-save save_form fleft" id="ce-u-bindsave">保存</a>
								<a class="fullBtnGray ce-u-cancel cancel_form fleft" id="ce-u-bindcancel">取消</a>
								<div class="clear"></div>
							</div>
						</form>
					</div>
					<div id="changeEmailWrap-unactiveone" class="grayBorderT grayBorderB modify_content " style="display:none;">
						<div class="cEmail-titleWrap">
							<span id="editEmail">修改邮箱（验证密码）</span>
						</div>
						<form class="cEmail-bodyWrap" novalidate="novalidate">
							<div class="lineWrap">
								<div class="leftWrap">
									<label class="leftLabel">账号密码</label>
								</div>
								<input type="password" value="" name="password" id="ce-u-password" class="normalInput" maxlength="16">
							</div>

							<div class="lineWrap">
								<label class="fleft">&nbsp;</label>
								<a class="fullBtnBlue ce-u-save save_form fleft" id="ce-u-savenext">下一步</a>
								<a class="fullBtnGray ce-u-cancel cancel_form fleft" id="ce-u-savenextcancel">取消</a>
								<div class="clear"></div>
							</div>
									<div class="clear"></div>
						</form>
					</div>
					<div id="changeEmailWrap-unactive" class="grayBorderT grayBorderB modify_content " style="display:none;">
						<div class="cEmail-titleWrap">
							<span id="editEmail">修改邮箱</span>
						</div>
						<form class="cEmail-bodyWrap" novalidate="novalidate">
							<div class="lineWrap">
								<div class="leftWrap">
									<label class="leftLabel">新邮箱</label>
								</div>
								<input type="text" value="" data-key="kapkey" name="email" id="ce-u-new_email" class="normalInput" maxlength="32">
							</div>
							<div class="lineWrap">
								<div class="leftWrap">
									<label class="leftLabel">邮件验证码</label>
								</div>
								<div class="normalInput bottom">
									<input type="text" name="kapkey" id="ce-u-passwordvalidate_code" class="kapkey" maxlength="6" autocomplete="off">
									<span class="form-line"></span>
									<a id="getKeynewEmail" data-value="15" href="javascript:void(0);" data-type="1" class="linkABlue invalidBtn get_kapkey">获取验证码</a>
									<a href="javascript:void(0);" class="linkABlue kapkey_requested" style="display:none;">已发送 <span class="interval_num">60</span></a>
								</div>
							</div>
							<div class="lineWrap">
								<label class="fleft">&nbsp;</label>
								<a class="fullBtnBlue ce-u-save save_form fleft" id="ce-u-save">保存</a>
								<a class="fullBtnGray ce-u-cancel cancel_form fleft" id="ce-u-cancel">取消</a>
								<div class="clear"></div>
							</div>
						</form>
					</div>
					<!-- //编辑输入框，激活 -->
					<div id="changeEmailWrap-activeone" class="grayBorderT grayBorderB modify_content" style="display:none;">
						<div class="cEmail-titleWrap">
							<span>修改邮箱第一步</span>
						</div>
						<form class="cEmail-bodyWrap" novalidate="novalidate">
							<div class="lineWrap" id="currentEmail">
							    <div class="leftWrap">
									<label class="leftLabel">当前邮箱</label>
								</div>
								<span id="ce-u-current_email" data-key="kapkey" class="normalInput current_email bold">2****023@qq.com</span>
							</div>
							<div class="lineWrap">
								<div class="leftWrap">
									<label class="leftLabel">邮件验证码</label>
								</div>
								<div class="normalInput bottom">
									<input type="text" name="kapkey" id="ce-u-passwordvalidate_codeone" class="kapkey" maxlength="6" autocomplete="off">
									<span class="form-line"></span>
									<a id="getKeyone" data-value="12" href="javascript:void(0);" data-type="2" class="linkABlue  get_kapkey">获取验证码</a>
									<a href="javascript:void(0);" class="linkABlue kapkey_requested" style="display:none;">已发送 <span class="interval_num">60</span></a>
								</div>
							</div>
							<div class="lineWrap">
								<label class="fleft">&nbsp;</label>
								<a class="fullBtnBlue ce-u-save save_form fleft" id="ce-u-activenext">下一步</a>
								<a class="fullBtnGray ce-u-cancel cancel_form fleft" id="ce-u-activecancel">取消</a>
								<div class="clear"></div>
							</div>
						</form>
					</div>
					<div id="changeEmailWrap-active-two" class="grayBorderT grayBorderB modify_content" style="display:none;">
						<div class="cEmail-titleWrap">
							<span>修改邮箱第二步</span>
						</div>
						<form class="cEmail-bodyWrap" novalidate="novalidate">
							<div class="lineWrap">
								<div class="leftWrap">
									<label class="leftLabel">新邮箱</label>
								</div>
								<input type="text" value="" data-key="kapkey" name="email" id="ce-u-active_email" class="normalInput" maxlength="32">
							</div>
							<div class="lineWrap">
								<div class="leftWrap">
									<label class="leftLabel">邮件验证码</label>
								</div>
								<div class="normalInput bottom">
									<input type="text" name="kapkey" id="ce-u-passwordvalidate_codetwo" class="kapkey" maxlength="6" autocomplete="off">
									<span class="form-line"></span>
									<a id="getKey-activeEmail" data-value="12" href="javascript:void(0);" data-type="1" class="linkABlue invalidBtn get_kapkey">获取验证码</a>
									<a href="javascript:void(0);" class="linkABlue kapkey_requested" style="display:none;">已发送 <span class="interval_num">60</span></a>
								</div>
							</div>
							<div class="lineWrap">
								<label class="fleft">&nbsp;</label>
								<a class="fullBtnBlue save_form fleft" id="ce-u-activesave">保存</a>
								<a class="fullBtnGray cancel_form fleft" id="ce-u-activecanceltwo">取消</a>
								<div class="clear"></div>
							</div>
						</form>
					</div>
					<div id="telWrap" class="lineWrap">
						<!--if-->
						<div class="item-right">
							<a id="editMobile" href="editaccount.php" class="linkABlue modify">修改</a>
						</div>
						<!-- end if -->
						<!--if-->
						<div class="item-right" style="display:none;">
							<a id="bindMobile" href="javascript:void(0);" class="linkABlue modify">绑定</a>
						</div>
						<!-- end if -->
						<div class="item-left">手机号码</div>
						<!--if-->
						<div class="item-middle" id="telModify">
							<span id="current_phone" class="bold"><?=$arr['phone']?></span><br>
						</div>
						<!-- end if -->
						<!--if-->
						<div class="item-middle" id="telBind" style="display:none;">
							<span class="bold">未绑定</span><br>
							<span class="grayTip">绑定后可通过手机号码登录、找回密码、异常登录提醒、<br>登录不常用设备验证</span>
						</div>
						<!-- end if -->
						<div class="clear"></div>
					</div>
					<div id="questionWrap" class="lineWrap">
						<div class="item-left">注册时间</div>
						
							<div id="questionModifyTip" class="item-right">
								<a id="modifySafe" href="editaccount.php" class="linkABlue modify">修改</a>
							</div>
							<div id="questionSettedTip" class="item-middle">
								<span id="tip" class="bold"><?=date('Y-m-d H:i:s',$arr['time'])?>
							</div>
						
						
						<div class="clear"></div>
					</div>
					<!-- 设置密保 -->
					<div id="setQuestion-stepOne" class="grayBorderT grayBorderB modify_content" style="display:none;">
						<div class="setQuestion-titleWrap">
							<span>设置密保（验证密码）</span>
						</div>
						<form class="setQuestion-bodyWrap" novalidate="novalidate">
								<div class="lineWrap">
									<div class="leftWrap">
										<label class="leftLabel">账号密码</label>
									</div>
									<input type="password" value="" name="password" id="setQuestion_pwd" class="normalInput" maxlength="16">
								</div>

								<div class="lineWrap">
									<label class="fleft">&nbsp;</label>
									<a class="fullBtnBlue save_form fleft" id="setQuestionSave">下一步</a>
									<a class="fullBtnGray cancel_form fleft" id="setQuestionCancel">取消</a>
									<div class="clear"></div>
								</div>
									<div class="clear"></div>
						</form>
					</div>
				<div style="float:left">
                    <a href="./personal.php" class="go">返回个人中心&gt;&gt;</a>
                </div>     
		</div>
	</div>
<div id="flymeFooter" class="footerWrap" style="top: 717px;">
	<div class="footerInner">
		<div class="footer-layer1">
			<div class="footer-innerLink">
				<a href="http://www.meizu.com/about.html" target="_blank" title="关于魅族">关于魅族</a>
				<img class="foot-line" src="./css/user/space.gif">
				<a href="http://hr.meizu.com/" target="_blank" title="工作机会">工作机会</a>
				<img class="foot-line" src="./css/user/space.gif">
				<a href="http://www.meizu.com/contact.html" target="_blank" title="联系我们">联系我们</a>
				<img class="foot-line" src="./css/user/space.gif">
				<a href="http://www.meizu.com/legalStatement.html" target="_blank" title="法律声明">法律声明</a>
				<img class="foot-line" src="./css/user/space.gif">
				
				<div href="javascript:void(0);" id="globalName" class="footer-language" title="简体中文">
					简体中文&nbsp;&nbsp;&nbsp;
					<div id="globalContainer" class="footer-language_menu" style="left: 475px;">
						<a href="https://i.flyme.cn/uc/webjsp/member/detail?lang=en_US" id="i18n-link" title="English" class="ClobalItem">English</a>
						<script>
							;(function() {
								var u = decodeURIComponent(location.href)
								var r = /lang=([^&\s]+)/
								var lowB = !('addEventListener' in window)
								var addEvent = lowB ? window.attachEvent : window.addEventListener

								if(r.test(u)) u = u.replace(r, 'lang=en_US')
								else u += (~u.indexOf('?') ? '&' : '?') + 'lang=en_US'

								addEvent(lowB ? 'onload' : 'load', function() {document.getElementById('i18n-link').setAttribute('href',u)})
							}());
						</script>
					</div>
				</div>
			</div>
			<div class="footer-service">
				<span class="service-label">客服热线</span>
				<span class="service-num">400-788-3333</span>
				<a id="service-online" class="service-online" href="javascript:void(0);" title="在线客服">在线客服</a>
			</div>
			<div class="footer-outerLink">
				<a class="footer-sinaMblog" href="http://weibo.com/meizumobile" target="_blank"><i class="i_icon"></i></a>
				
				<a id="footer-weChat" class="footer-weChat" href="javascript:void(0);" target="_blank"><i class="i_icon"></i></a>
				<a class="footer-qzone" href="http://user.qzone.qq.com/2762957059" target="_blank"><i class="i_icon"></i></a>
			</div>
		</div>
		<div class="clear"></div>
		<div id="flymeCopyright" class="copyrightWrap">
			<div class="copyrightInner">
				<span>©2016 Meizu Telecom Equipment Co., Ltd. All rights reserved.</span>
				<a href="http://www.miitbeian.gov.cn/" class="linkAGray" target="_blank">备案号: 粤ICP备13003602号-4</a>
				<a href="http://www3.res.meizu.com/static/cn/widget/footer/images/icp2_b2dcb54.jpg" class="linkAGray" target="_blank">经营许可证编号: 粤B2-20130198</a>
				<a target="_blank" href="http://www2.res.meizu.com/zh_cn/images/common/com_licence.jpg" hidefocus="true" class="linkAGray">营业执照</a>
			</div>
		</div>
	</div>
</div>
<div id="wechatPic"></div>

    

</body></html>