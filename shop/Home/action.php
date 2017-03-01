<?php
    session_start();
	if(empty($_GET['a'])){header('location:./home.php');exit;}
	include_once '../Public/config.php';
    include_once '../Public/function.php';
	$link = mysqli_connect(HOST,USER,PWD,DB) or die('服务器连接失败');
	mysqli_set_charset($link,'utf8');
	switch ($_GET['a']){
        // 注册
		case 'register':
			if(empty($_POST)){
               echo '<script>alert("注册信息不能为空");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
            // 接收数据，md5加密时间，增加创建时间
            $username = $_POST['username'];
            $pwd = md5($_POST['pwd']);
            $pwd2 = md5($_POST['pwd2']);
            $time = time();

			// 判断用户名是否为空
            if(empty($username)){
                echo '<script>alert("用户名不能为空");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
            
            // 判断密码不能为空
            if(empty($_POST['pwd'])||empty($_POST['pwd2'])){
                echo '<script>alert("密码或确认密码不能为空");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
            // 判断用户名是否合法
            $res1 = preg_match_all('/^[a-zA-Z0-9]\w*/',$username,$m);
            $res2 = preg_match_all("/^[\x{4e00}-\x{9fa5}]+/u", $username, $m);
            if($res1 ==0 && $res2 ==0){
                echo '<script>alert("用户名格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断用户名长度是否合法
            $lenth3 = strlen($_POST['username']);
            if($lenth3 >50 || $lenth3 < 3){
                echo '<script>alert("用户名需要设置3-50个字以内");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断两次密码是否一致，不一致则返回上一页
            if($pwd != $pwd2){
                echo '<script>alert("两次密码不一致");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }

            // 判断密码长度是否合法
            $lenth1 = strlen($_POST['pwd']);
            if($lenth1 >20 || $lenth1 <3){
                echo '<script>alert("密码需要设置3-20个字以内");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }


            //判断用户名是否已存在
            $sql2 = "select * from ".FIX."user where username='$username' ";
            $res2 = mysqli_query($link,$sql2);
            if($res2 && mysqli_num_rows($res2)>0){
                echo '<script>alert("用户名已存在，请重新命名");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }

            // 准备SQL语句
            $sql = "insert into ".FIX."user (username,pwd,role,time) value('$username','$pwd',1,'$time')";
            // echo $sql;exit;

            // 发送SQL语句
            $res = mysqli_query($link,$sql);
            if($res && mysqli_affected_rows($link)){
                echo '<script>alert("注册成功");location.href="./login.php"</script>';
                exit;
            } else{
                echo '<script>alert("注册失败");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
        	break;

        // 登录
        case 'login':
            //判断用户名不能为空 
            if(empty($_POST['username'])){
                echo '<script>alert("用户名不能为空");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
            // 判断密码不能为空
            if(empty($_POST['pwd'])){
                echo '<script>alert("密码不能为空");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
            $username = $_POST['username'];
            $pwd = md5($_POST['pwd']);
            // $yzm = $_POST['yzm'];
            // 判断用户名的格式，不能为特殊字符
            $res1 = preg_match_all('/^[a-zA-Z0-9]\w*/',$username,$m);
            $res2 = preg_match_all("/^[\x{4e00}-\x{9fa5}]+/u", $username, $m);
            if($res1 ==0 && $res2 ==0){
                echo '<script>alert("用户名格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
            // 判断是否有这个账号
            $sql1 = "select * from ".FIX."user where username='$username'";
            $res1 = mysqli_query($link,$sql1);
            if($res1 && !(mysqli_num_rows($res1)>0)){
                echo '<script>alert("账号有误，请重新输入");location.href="./login.php"</script>';
                exit;
            }

            // 判断账号和密码是否正确
            $sql = "select * from ".FIX."user where username='$username' and pwd='$pwd'";
            // 发送SQL语句
            $res = mysqli_query($link,$sql);
            if($res && mysqli_num_rows($res)>0){
            	$row = mysqli_fetch_assoc($res);
                if($row['role']==2){
                    echo '<script>alert("管理员不能登录前台页面");location.href="./login.php"</script>';
                    exit;
                }
            	if($row['status']==1){
	            	$_SESSION['home_info'] = $row;
                    // var_dump($_SESSION['home_info']);exit;
	                // echo '登录成功,回到<a href="./home.php">首页</a>';
	                // echo '<meta http-equiv="refresh" content="2;url=./home.php">';
	                // exit;
                    echo '<script>alert("登录成功");location.href="./home.php"</script>';
                    exit;
            	}else{
            		echo '<script>alert("账号被冻结，请联系管理员");location.href="./login.php"</script>';
                	exit;
            		}      
            }else{
                echo '<script>alert("用户名或密码错误");location.href="./login.php"</script>';
                exit;
            }
            break;

        // 注销
        case 'logout':
            unset($_SESSION['home_info']);
            header('location:home.php');
            exit;
            break;

        // 详情页点击购买
         case 'buy':
            if(empty($_GET['id'])){
                header('location:home.php');
                exit;
            }
            $id = $_GET['id'];
            $sql = "select * from ".FIX."goods where id = $id";
            $res = mysqli_query($link,$sql);
            $info = mysqli_fetch_assoc($res);
            if(empty($_SESSION['shopcar'][$id])){
                if($res && mysqli_num_rows($res)>0){
                    $info['num'] = 1;
                    $_SESSION['shopcar'][$id]=$info;
                    header('location:shopcar.php');
                    exit;    
                }else{
                    echo "header(location:".$_SERVER['HTTP_REFERER'].")";
                    exit;         
                }
            }else{
                if($_SESSION['shopcar'][$id]['num']<$info['store']){
                    $_SESSION['shopcar'][$id]['num']++;
                    header('location:shopcar.php');
                    exit;  
                }else{
                    header('location:shopcar.php');
                    exit;
                }
            }
            break;

        // 详情页添加商品到购物车
        case 'addgoods':
            if(empty($_GET['id'])){
                header('location:home.php');
                exit;
            }
            $id = $_GET['id'];
            $sql = "select * from ".FIX."goods where id = $id";
            $res = mysqli_query($link,$sql);
            $info = mysqli_fetch_assoc($res);
            if(empty($_SESSION['shopcar'][$id])){
                if($res && mysqli_num_rows($res)>0){
                    $info['num'] = 1;
                    $_SESSION['shopcar'][$id]=$info;
                    header('location:'.$_SERVER['HTTP_REFERER'].'');
                    exit;    
                }else{
                    echo "header(location:home.php)";
                    exit;         
                }
            }else{
                if($_SESSION['shopcar'][$id]['num']<$info['store']){
                    $_SESSION['shopcar'][$id]['num']++;
                    header('location:'.$_SERVER['HTTP_REFERER'].'');
                    exit;  
                }else{
                    echo '<script>alert("加入购物车数量已超过库存件数");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }
            }
            break;

        // 购物车数量加一
        case 'addnum':
             if(empty($_GET['id'])){
                header('location:home.php');
                exit;
            }
            $id = $_GET['id'];
            $sql = "select store from ".FIX."goods where id=$id";
            $res = mysqli_query($link,$sql);
            if($res && mysqli_num_rows($res)>0){
                $store = mysqli_fetch_assoc($res)['store'];
                if($_SESSION['shopcar'][$id]['num']<$store){
                        $_SESSION['shopcar'][$id]['num']++;
                        header('location:'.$_SERVER['HTTP_REFERER'].'');
                        exit;
                    }else{
                        echo "<script>alert('亲，已经超过最大库存了~~');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                        exit;
                    }
                }
                break;        

        // 购物车数量减一
        case 'cutnum':
         if(empty($_GET['id'])){
            header('location:home.php');
            exit;
        }
        $id = $_GET['id'];
        if($_SESSION['shopcar'][$id]['num']>1){
                $_SESSION['shopcar'][$id]['num']--;
                header('location:'.$_SERVER['HTTP_REFERER'].'');
                exit;
            }else{
                echo "<script>alert('亲，最少一件，请直接删除商品');location.href='shopcar.php'</script>";
            }
        break;

        // 购物车删除单条商品
        case 'delgoods':
             if(empty($_GET['id'])){
                header('location:home.php');
                exit;
            }
            $id = $_GET['id'];
            unset($_SESSION['shopcar'][$id]);
            header('location:shopcar.php');
            exit;
            break;

        // 删除购物车所有商品
        case 'delall':
        	unset($_SESSION['shopcar']);
        	header('location:shopcar.php');
        	exit;
        	break;


        // 增加新地址
        case 'addaddress':
            // var_dump($_POST);exit;
            // 判断是否非法访问
            if(empty($_POST)){
                header("location:home.php");
                exit;
            }
            if(empty($_SESSION['home_info'])){
                header('location:login.php');
                exit;
            }
            // 判断收件人是否为空
             if(empty($_POST['name'])){
                echo "<script>alert('收件人不能为空');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            // 判断电话是否为空
             if(empty($_POST['phone'])){
                echo "<script>alert('电话不能为空');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            // 判断地址是否为空
             if(empty($_POST['address'])){
                echo "<script>alert('地址不能为空');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }

            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $uid = $_SESSION['home_info']['id'];
            // 判断收件人姓名是否符合要求
            // // 判断收件人的格式，不能为特殊字符
            $res1 = preg_match_all('/^[a-zA-Z]+/',$name,$m);
            $res2 = preg_match_all("/^[\x{4e00}-\x{9fa5}]+/u", $name, $m);
            if($res1 ==0 && $res2 ==0){
                echo '<script>alert("收件人格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断用户名长度是否合法
            $lenth3 = strlen($_POST['name']);
            if($lenth3 >36 || $lenth3 < 6){
                echo '<script>alert("收件人需要设置2-12个中文以内");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断电话号码是否符合要求
            $res = preg_match('/^1[34578]\d{9}$/', $phone);
            if ($res == 0) {
                echo '<script>alert("电话号码格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断地址是否符合要求
            $res1 = preg_match_all('/^[a-zA-Z0-9]\w*/',$address,$m);
            $res2 = preg_match_all("/^[\x{4e00}-\x{9fa5}]+/u", $address, $m);
            if($res1 ==0 && $res2 ==0){
                echo '<script>alert("地址格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断地址长度是否合法
            $lenth = strlen($address);
            if($lenth >50 || $lenth < 3){
                echo '<script>alert("地址需要设置3-50个字以内");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            $sql = "insert into ".FIX."address values(null,$uid,'$address',$phone,'$name',null)";
            $res = mysqli_query($link,$sql);
            if($res && mysqli_affected_rows($link)>0){
                // echo "<script>alert('成功增加地址');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                header('location:address.php');
                exit;
            }else{
                echo "<script>alert('添加地址失败');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            break;


        // 删除单个地址
        case 'deladdress':
            if(empty($_SESSION['home_info'])){
                header('location:login.php');
                exit;
            }
            if(empty($_GET['id'])){
                header("location:address.php");
                exit;
            }
            $id = $_GET['id'];
            // 查找是否有订单使用了该地址，有则无法删除
            $sql2 = "select * from ".FIX."order o where o.aid=$id ";
            $res2 = mysqli_query($link,$sql2);
            if($res2 && mysqli_num_rows($res2)>0){
                echo "<script>alert('该地址已有订单使用过，无法删除');location.href='address.php'</script>";
                exit;
            }
            $sql = "delete from ".FIX."address where id =$id ";
            $res = mysqli_query($link,$sql);
            if($res && mysqli_affected_rows($link)>0){
                header('location:address.php');
                exit;
            }else{
                echo "<script>alert('删除地址失败');location.href='address.php'</script>";
                exit;
            }

            
        // 修改地址
        case 'editaddress':
            if(empty($_SESSION['home_info'])){
                header('location:login.php');
                exit;
            }
            if(empty($_POST['id'])){
                header("location:address.php");
                exit;
            }
            $id = $_POST['id'];
            $phone = $_POST['phone'];
            $name = $_POST['name'];
            $address = $_POST['address'];

            // 判断收件人姓名是否符合要求
            // // 判断收件人的格式，不能为特殊字符
            $res1 = preg_match_all('/^[a-zA-Z0-9]\w*/',$name,$m);
            $res2 = preg_match_all("/^[\x{4e00}-\x{9fa5}]+/u", $name, $m);
            if($res1 ==0 && $res2 ==0){
                echo '<script>alert("收件人格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断用户名长度是否合法
            $lenth3 = strlen($_POST['name']);
            if($lenth3 >36 || $lenth3 < 6){
                echo '<script>alert("收件人需要设置2-12个中文以内");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断电话号码是否符合要求
            $res = preg_match('/^1[34578]\d{9}$/', $phone);
            if ($res == 0) {
                echo '<script>alert("电话号码格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断地址是否符合要求
            $res1 = preg_match_all('/^[a-zA-Z0-9]\w*/',$address,$m);
            $res2 = preg_match_all("/^[\x{4e00}-\x{9fa5}]+/u", $address, $m);
            if($res1 ==0 && $res2 ==0){
                echo '<script>alert("地址格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断地址长度是否合法
            $lenth = strlen($address);
            if($lenth >50 || $lenth < 3){
                echo '<script>alert("地址需要设置3-50个字以内");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            $sql = "update ".FIX."address set phone=$phone,address='$address' where id =$id ";
            $res = mysqli_query($link,$sql);
            if($res && mysqli_affected_rows($link)>0){
                echo "<script>alert('修改地址成功');location.href='address.php'</script>";
                exit;
            }else{
                echo "<script>alert('修改地址失败');location.href='address.php'</script>";
                exit;
            }
            break;

        //点击提交订单
        case 'addorder':

            // 判断是否登录
            if(empty($_SESSION['home_info'])){
                header('location:login.php');
                exit;
            }
            if(empty($_POST['addressid'])){
                echo "<script>alert('请选择收货地址');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            $uid = $_SESSION['home_info']['id'];
            $total = $_SESSION['total'];
            $addtime = time();
            $status = 1;
            $aid = $_POST['addressid'];
            $sql = "insert into ".FIX."order values(null,$uid,$total,$addtime,$status,$aid)";
            $res = mysqli_query($link,$sql);
            // 写入订单表
            if($res && mysqli_affected_rows($link)>0){
                // 写入订单详情表
                $oid = mysqli_insert_id($link);
                $sql2 = "insert into ".FIX."detail values";
                foreach($_SESSION['shopcar'] as $v){
                    $sql3 = "select * from ".FIX."goods g where g.id={$v['id']}";
                    $res3 = mysqli_query($link,$sql3);
                    if($res3 && mysqli_num_rows($res3)>0){
                        $store = mysqli_fetch_assoc($res3)['store']-$v['num'];
                    }
                    $sql2 .= " (null,$oid,{$v['id']},{$v['num']}),";
                }
                $sql2 = rtrim($sql2,',');
                $res2 = mysqli_query($link,$sql2);
                if($res2 && mysqli_affected_rows($link)==count($_SESSION['shopcar'])){
                    echo "<script>alert('亲，已成功下单');location.href='pay.php?oid=".$oid."'</script>";
                    $sql4 = "update ".FIX."goods set store=$store where id={$v['id']}";
                    $res4 = mysqli_query($link,$sql4);
                    unset($_SESSION['shopcar']);
                    exit;
                }else{
                     echo "<script>alert('亲，下单失败，请联系客服人员');location.href='pay.php'</script>";
                    exit;
                }
            }else{
                echo "<script>alert('亲，下单失败，请联系管理员');location.href='pay.php'</script>";
                exit;
            }
            break;

        // 点击支付
        case 'paydone':
            // var_dump($_POST);exit;
             // 判断是否登录
            if(empty($_SESSION['home_info'])){
                header('location:login.php');
                exit;
            }
            if(empty($_POST['oid'])){
                header('location:pay.php');
                exit;
            }
            $oid = $_POST['oid'];
            // 先判断该订单是否存在
            $sql = "select * from ".FIX."order where id=$oid";
            // echo $sql;exit;
            $res = mysqli_query($link,$sql);
            if($res && mysqli_num_rows($res)>0){
                // 找到该订单的信息状态
                $order = mysqli_fetch_assoc($res);
                // 判断该订单的状态是否为待付款
                if($order['status']==1){
                    $sql2 = "update ".FIX."order set status=2 where id=$oid";
                    $res2 = mysqli_query($link,$sql2);
                    if($res2 && mysqli_affected_rows($link)>0){
                        echo "<script>alert('亲，支付成功，将尽快为安排你发货');location.href='personal.php'</script>";
                        exit;
                    }else{
                        echo "<script>alert('亲，支付失败，请联系客服');location.href='personal.php'</script>";
                        exit;
                    }
                }else{
                    // 订单状态不为待付款时提示报错
                    echo "<script>alert('亲，系统故障，请联系管理员');location.href='pay.php'</script>";
                    exit;
                }
            }else{
                // 假如找不到该订单
                header('location:pay.php');
                exit;
            }
            break;

        case 'receive':
             // 判断是否登录
            if(empty($_SESSION['home_info'])){
                header('location:login.php');
                exit;
            }
            if(empty($_POST['oid'])){
                header('location:pay.php');
                exit;
            }
            $oid = $_POST['oid'];
            // 先判断该订单是否存在
            $sql = "select * from ".FIX."order where id=$oid";
            // echo $sql;exit;
            $res = mysqli_query($link,$sql);
            if($res && mysqli_num_rows($res)>0){
                // 找到该订单的信息状态
                $order = mysqli_fetch_assoc($res);
                // 判断该订单的状态是否为待付款
                if($order['status']=3){
                    $sql2 = "update ".FIX."order set status=4 where id=$oid";
                    $res2 = mysqli_query($link,$sql2);
                    if($res2 && mysqli_affected_rows($link)>0){
                        echo "<script>alert('亲，确认收货成功，欢迎再次光临');location.href='personal.php'</script>";
                        exit;
                    }else{
                        echo "<script>alert('亲，确认失败，请联系客服');location.href='personal.php'</script>";
                        exit;
                    }
                }else{
                    // 订单状态不为待付款时提示报错
                    echo "<script>alert('亲，系统故障，请联系管理员');location.href='pay.php'</script>";
                    exit;
                }
            }else{
                // 假如找不到该订单
                header('location:pay.php');
                exit;
            }
            break;

        case 'editaccount':
            if(empty($_SESSION['home_info'])){
                header('location:login.php');
                exit;
            }
            $username = $_POST['username'];
            $set = " username ='$username '";
            $id = $_SESSION['home_info']['id'];

            // 判断两次密码是否一致，不一致则返回上一页
            if($_POST['pwdpwd'] != $_POST['pwdpwd2']){
                echo '<script>alert("两次密码不一致");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
            // 判断密码是否为空
            if(!empty($_POST['pwdpwd'])){
                $pwd = md5($_POST['pwdpwd']);
                $set .= " ,pwd='$pwd' ";
            }
            
            // 判断QQ是否为空
            if(!empty($_POST['qqqq'])){
                $qq = $_POST['qqqq'];
                // 判断qq是否符合要求
                $res = preg_match('/\d{1,14}/', $qq);
                if ($res == 0) {
                    echo '<script>alert("QQ号码格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }
                $set .= " ,qq=$qq ";
            }
            // 判断手机号码是否为空
            if(!empty($_POST['phonephone'])){
                // 判断电话号码是否符合要求
                $res = preg_match('/^1[34578]\d{9}$/', $_POST['phonephone']);
                if ($res == 0) {
                    echo '<script>alert("电话号码格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }
                $phone = $_POST['phonephone'];
                $set .= " ,phone=$phone";
            }
             // 判断是否上传头像
            if($_FILES['pic']['error']!=4){
                $info = upload('pic','../Public/upload/touxiang');
                // 判断图片是否正常上传
                if($info['status']){
                $pic = $info['name'];
                }else{
                    echo '<script>alert("'.$info['msg'].'");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }
                $set .= " ,pic='$pic' ";
            }

            $sql = "update ".FIX."user set $set where id=$id";
            // echo $sql;exit;
            $res = mysqli_query($link,$sql);
            if($res && mysqli_affected_rows($link)>0){
                echo "<script>alert('资料修改成功');location.href='account.php'</script>";
                exit;
            }else{
                echo "<script>alert('资料修改失败');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            break;
            
	}
