<?php
    // var_dump($_POST);exit;
    session_start();
    // var_dump($_POST);
    // 引入配置文件
    include_once '../../Public/config.php';
    include_once '../../Public/function.php';

    // 判断是否非法访问，非法则跳回首页
    if(empty($_GET['a'])){
        header('location:index.php');
        exit;
    }
    // 连接数据库，设置字符集
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('数据库连接失败。<a href="./index.php">返回</a>');
    mysqli_set_charset($link,'utf8');
    // 判断执行操作的类型
    switch ($_GET['a']){
        case 'add':
            // 判断POST是否为空，为空则跳回首页
        	if(empty($_POST)){
                header('location:index.php');exit;
            }
            // 接收数据，md5加密时间，增加创建时间
            $username = $_POST['username'];
            $pwd = md5($_POST['pwd']);
            $pwd2 = md5($_POST['pwd2']);
            $role = $_POST['role'];
            $time = time();
            $sex = $_POST['sex'];
            $phone = $_POST['phone'];
            $qq = $_POST['qq'];

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
            // 判断密码长度是否合法
            $lenth1 = strlen($_POST['pwd']);
            $lenth2 = strlen($_POST['pwd2']);
            if($lenth1 >20 || $lenth2 >20){
                echo '<script>alert("密码不能设置超过20个字");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断两次密码是否一致，不一致则返回上一页
            if($pwd != $pwd2){
                echo '<script>alert("两次密码不一致");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
            // var_dump($_FILES['pic']);exit;

             // 调用函数，处理上传的图片 
            $info = upload('pic','../../Public/upload/touxiang');
            // 判断图片是否正常上传
            if(($_FILES['pic']['error']!=4)){
                if($info['status']){
                    $pic = $info['name'];
                }else{
                    echo '<script>alert("'.$info['msg'].'");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }  
            }else{
                $pic = null;
            }

        	// 准备SQL语句
            // $sql = "insert into ".FIX."user (username,pwd,role,time) value('$username','$pwd','$role','$time')";
            
            // 判断phone和qq是否为空，为空则不用添加该字段
            if(!empty($phone)&& !empty($qq)){
                $sql = "insert into ".FIX."user (username,pwd,role,time,sex,phone,qq,pic) value('$username','$pwd','$role','$time','$sex','$phone','$qq','$pic')";
            }elseif(!empty($phone)){
                $sql = "insert into ".FIX."user (username,pwd,role,time,sex,phone,pic) value('$username','$pwd','$role','$time','$sex','$phone','$pic')";
            }elseif(!empty($qq)){
                $sql = "insert into ".FIX."user (username,pwd,role,time,sex,qq,pic) value('$username','$pwd','$role','$time','$sex','$qq','$pic')";
            }else{
                $sql = "insert into ".FIX."user (username,pwd,role,time,pic) value('$username','$pwd','$role','$time','$pic')";
            }
            // 发送SQL语句
            $res = mysqli_query($link,$sql);
            // echo $sql;exit;
            if($res && mysqli_affected_rows($link)){
                echo '<script>alert("成功添加用户");location.href="./index.php"</script>';
                exit;
            } else{
                echo '<script>alert("注册用户失败");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
        	break;

        case 'status':
            $id = $_GET['id'];
            $status = $_GET['status'];
            $status = ($status=='1')?'2':'1';
            // 查询要修改的是否是管理员
            $sql2 = "select role from ".FIX."user where id=$id limit 1";
            $res2 = mysqli_query($link,$sql2);
            if($res2 && mysqli_num_rows($res2)>0){
                $role = mysqli_fetch_assoc($res2)['role'];
            }
            // 判断是否是炒鸡
            if($_SESSION['admin_info']['id']!='6'){
                if($role == 2 ){
                    echo '<script>alert("不是炒鸡，不能修改其他管理员的状态");location.href="index.php"</script>';
                    exit; 
                }
            }
            // 判断是否禁用自己
            if($id == $_SESSION['admin_info']['id']){
                echo '<script>alert("不能自己搞自己");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;           
            }
            $sql = "update ".FIX."user set status='$status' where id='$id'";
            $res = mysqli_query($link,$sql);
            header('location:'.$_SERVER['HTTP_REFERER'].'');
            break;

        case 'del':
            if(empty($_GET['id'])){
                header('location:index.php');
            }
            $id = $_GET['id'];
            // 判断是否删除自己
            if($id == $_SESSION['admin_info']['id']){
                echo '<script>alert("不能自己删自己");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;           
            }
            // 查询要删除的是否是管理员
            $sql2 = "select role from ".FIX."user where id=$id limit 1";
            $res2 = mysqli_query($link,$sql2);
            if($res2 && mysqli_num_rows($res2)>0){
                $role = mysqli_fetch_assoc($res2)['role'];
            }
            // 判断是否是炒鸡
            if($_SESSION['admin_info']['id']!='6'){
                if($role == 2 ){
                    echo '<script>alert("不是炒鸡，不能删除其他管理员");location.href="index.php"</script>';
                    exit; 
                }
            }
            // 查出pic头像
            $sql2 = "select * from ".FIX."user where id='$id'";
            $res2 = mysqli_query($link,$sql2);
            if($res2 && mysqli_num_rows($res2)>0){
                $user = mysqli_fetch_assoc($res2);
                $pic = $user['pic'];
                // var_dump($pic);exit;
            }

            // 准备删除SQL语句
            $sql = "delete from ".FIX."user where id='$id'";
            // 发送删除SQL语句
            $res = mysqli_query($link,$sql);
            // 处理删除结果
            if($res && mysqli_affected_rows($link)>0){
                // 通过ID找出对应的订单和订单明细表，地址表，并且删除
                // $sql3 = "select a.id,o.id,d.id from ".FIX."order o,".FIX."detail d,".FIX."address a where o.uid=$id and o.aid=a.id and o.id=d.oid ";
                // 找订单号
                $sql3 = "select id from ".FIX."order where uid=$id";
                $res3 = mysqli_query($link,$sql3);
                if($res3 && mysqli_num_rows($res3)>0){
                    // 拿到所有订单的ID
                    $orders = mysqli_fetch_all($res3,MYSQLI_ASSOC);
                    foreach($orders as $o){
                        // 找订单明细表
                        $sql4 = "select id did from ".FIX."detail where oid={$o['id']}";
                        $res4 = mysqli_query($link,$sql4);
                        if($res4 && mysqli_num_rows($res4)>0){
                            // 拿到所有订单明细表的ID
                            $details = mysqli_fetch_all($res4,MYSQLI_ASSOC);
                            // var_dump($details);exit;
                                foreach($details as $d){
                                    // 遍历删除明细表数据
                                    $deld = "delete from ".FIX."detail where id={$d['did']}";
                                    $resd = mysqli_query($link,$deld);
                                }
                            }
                        // 遍历删除订单数据
                        $delo = "delete from ".FIX."order where id={$o['id']}";
                        $resd = mysqli_query($link,$delo);
                        }
                    }
                $sqla = "select a.id from ".FIX."address a where a.uid=$id";
                $resa = mysqli_query($link,$sqla);
                if($resa && mysqli_num_rows($resa)>0){
                    $address = mysqli_fetch_all($resa,MYSQLI_ASSOC);
                    foreach($address as $a){
                        // 遍历删除地址表数据
                        $dela = "delete from ".FIX."address a where a.uid=$id ";
                        $resa = mysqli_query($link,$dela);
                    }
                }

                // 判断是否有头像，有则删除
                if(!empty($pic)){
                    $filename="../../Public/upload/touxiang/".$pic;
                    unlink($filename);
                }
                echo '<script>alert("删除成功");location.href="./index.php"</script>';
                exit;
            }else{
                echo '<script>alert("删除失败，返回");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
            break;
        
        case 'edit':
            
            // var_dump($_POST['ren2']);exit;
            // $ren = unserialize($_POST['ren2']);
            // 判断是否有传到东西，没有则跳回首页
            if(empty($_POST)){
                header('location:index.php');
            }
            
            $id = $_POST['id'];
            $username = $_POST['username'];
            $role = $_POST['role'];
            $status = $_POST['status'];
            $sex = $_POST['sex'];
            $phone = $_POST['phone'];
            $qq = $_POST['qq'];
            // var_dump($_POST['phone']);
            // var_dump($phone);
            // exit;
            if($_SESSION['admin_info']['id']=='6'){
                if($role=='1'){
                    echo "<script>alert('你是超管，不能修改为普通会员');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
                }
            }

            // 判断用户名是否为空
            if(empty($username)){
                echo "<script>alert('用户名不能为空，返回修改');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            // 判断用户名格式是否正确
            $res1 = preg_match_all('/^[a-zA-Z0-9]\w*/',$username,$m);
            $res2 = preg_match_all("/^[\x{4e00}-\x{9fa5}]+/u", $username, $m);
            if($res1==0 && $res2==0){
                echo "<script>alert('用户名格式不正确，请修改');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            // 判断两次密码是否一致
            if($_POST['pwd'] !== $_POST['pwd2']){
                echo "<script>alert('两次密码不一致，请修改');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            // 判断密码是否超过20个字
            if(strlen($_POST['pwd'])>20||strlen($_POST['pwd2'])>20){
                echo "<script>alert('密码不能超过20个字，请修改');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }

               // 判断QQ是否为空
            if(!empty($_POST['qq'])){
                $qq = $_POST['qq'];
                // 判断qq是否符合要求
                $res = preg_match_all('/(\d){1,14}/', $qq);
                if ($res == 0) {
                    echo '<script>alert("QQ号码格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }
            }
            // 判断手机号码是否为空
            if(!empty($_POST['phone'])){
                // 判断电话号码是否符合要求
                $res = preg_match('/^1[34578]\d{9}$/', $_POST['phone']);
                if ($res == 0) {
                    echo '<script>alert("电话号码格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }
                $phone = $_POST['phone'];
            }

            // 调用函数，处理上传的图片 
            $info = upload('pic','../../Public/upload/touxiang');
            // 判断图片是否正常上传
            if(($_FILES['pic']['error']!=4)){
                if($info['status']){
                    $pic = $info['name'];
                }else{
                    echo '<script>alert("'.$info['msg'].'");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }  
            }else{
                $pic = null;
            }
            // 判断是否修改了角色和其他内容
            $set = ' ';
            $set .=" sex='$sex', role='$role', status='$status', pic='$pic'";
            if(!empty($username)){
            	$set .= ($_SESSION['pre']['username']==$username)?'':" ,username='$username'";           	
            }else{
            	$set .= (is_null($_SESSION['pre']['username']))?'':" ,username='$username'"; 
            }

            if(!empty($phone)){
            	$set .= ($_SESSION['pre']['phone']==$phone)?'':" ,phone='$phone'";  
            }else{
            	$set .= (is_null($_SESSION['pre']['phone']))?'':" ,phone='$phone'"; 
            }
            
            if(!empty($qq)){
            	$set .= ($_SESSION['pre']['qq']==$qq)?'':" ,qq='$qq'";  
            }else{
            	$set .= (is_null($_SESSION['pre']['qq']))?'':" ,qq='$qq'"; 
            }
            // 判断是否设置了新密码,并准备修改SQL语句
            // if(!empty($_POST['pwd'])){
            //     $pwd = md5($_POST['pwd']);
            //     $sql = "update ".FIX."user set username='$username',pwd='$pwd',role='$role' where id=$id ";
            // }else{
            //     $sql = "update ".FIX."user set username='$username',role='$role' where id=$id";
            // }
            if(!empty($_POST['pwd'])){
                $pwd = md5($_POST['pwd']);
                $set .=" ,pwd='$pwd'";
                $sql = "update ".FIX."user set $set where id=$id ";
            }else{
                $sql = "update ".FIX."user set $set where id=$id";
            }
            // echo $sql;exit;

            // 发送修改SQL语句
            $res = mysqli_query($link,$sql);
            // 处理修改结果集
            if($res && mysqli_affected_rows($link)>0){
                echo "<script>alert('修改成功');location.href='index.php'</script>";
                exit;
            }else{
                echo "<script>alert('修改失败，请重新修改');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            break;
    }