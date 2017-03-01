<?php
    session_start();
    // include_once '../Public/yzm.php';    //不能有图片输出
    include_once '../Public/config.php';
    if(empty($_GET['a'])){
        header('location:index.php');
        exit;
    }
    // 连接数据库
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('数据库连接失败。<a href="./index.php">返回</a>');
    mysqli_set_charset($link,'utf8');
    // 判断执行操作的类型
    switch ($_GET['a']){
        case 'login':
            //判断用户名不能为空 
            if(empty($_POST['username'])){
                $_SESSION['admin_info']='0';
                echo '<script>alert("用户名不能为空");location.href="login.php"</script>';
                exit;
            }
            // 判断密码不能为空
            if(empty($_POST['pwd'])){
                $_SESSION['admin_info']='1';
                $_SESSION['username']=$_POST['username'];
                echo '<script>alert("密码不能为空");location.href="login.php"</script>';
                exit;
            }
            $_SESSION['username']=$_POST['username'];
            $username = $_POST['username'];
            $pwd = md5($_POST['pwd']);
            $yzm = $_POST['yzm'];
            // 判断用户名的格式，不能为特殊字符
            $res1 = preg_match_all('/^[a-zA-Z0-9]\w*/',$username,$m);
            $res2 = preg_match_all("/^[\x{4e00}-\x{9fa5}]+/u", $username, $m);
            if($res1 ==0 && $res2 ==0){
                $_SESSION['admin_info']='0';
                echo '<script>alert("用户名格式有误，请重新输入");location.href="login.php"</script>';
                exit;
            }
            // 判断验证码是否正确
            if(strtolower($yzm) !== strtolower($_SESSION['yzm'])){
                $_SESSION['admin_info']='2';
                $_SESSION['pwd']=$_POST['pwd'];
                echo '<script>alert("验证码错误");location.href="login.php"</script>';
                // header('location:./index.php');
                exit;
            }
            // 准备SQL语句
            $sql = "select * from ".FIX."user where username='$username' and pwd='$pwd'";
            // echo $sql;exit;
            // 发送SQL语句
            $res = mysqli_query($link,$sql);
            if($res && mysqli_num_rows($res)>0){
                // 登录成功，设置session值，并跳转进入后台
                $row = mysqli_fetch_assoc($res);
                if($row['role']=='2'&& $row['status']=='1'){
	                $_SESSION['admin_info'] = $row;
	                echo '登录成功,2秒后<a href="./index.php">跳转</a>';
	                echo '<meta http-equiv="refresh" content="2;url=./index.php">';
	                exit;
                }elseif($row['role']=='1'){
					$_SESSION['admin_info']='1';
	                echo '<script>alert("权限不够,无法登陆");location.href="./login.php"</script>';
	                exit;
                }elseif($row['status']=='2'){
					$_SESSION['admin_info']='1';
	                echo '<script>alert("账号被冻结,请联系管理员");location.href="./login.php"</script>';
	                exit;
                }
            }else{
                // 登录失败，跳回登录页
                $_SESSION['admin_info']='1';
                echo '<script>alert("用户名或密码错误");location.href="./login.php"</script>';
                exit;
            }
            break;

        // 设置注销登录
        case 'logout':
            // 删除session并跳回登录页
            unset($_SESSION['admin_info']);
            header('location:index.php');
            exit;
            break;
    }