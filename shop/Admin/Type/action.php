<?php
    session_start();
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
                header('location:index.php');
                exit;
            }
            $name = $_POST['name'];
            if(!empty($_POST['pid'])){
                $pid = $_POST['pid'];
                $path = $_POST['path'];
            }else{
                $pid = '0';
                $path = '0,';
            }

            // 判断分类名是否为空
            if(empty($name)){
                echo '<script>alert("分类名不能为空");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断分类名是否合法
            $res1 = preg_match_all('/^[a-zA-Z0-9]\w*/',$name,$m);
            $res2 = preg_match_all("/^[\x{4e00}-\x{9fa5}]+/u", $name, $m);
            if($res1 ==0 && $res2 ==0){
                echo '<script>alert("分类名格式有误，请重新输入");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断是否有上传分类图片
            $info = upload('pic','../../Public/upload/type');
            // 判断图片是否正常上传
            if($info['status']){
                $pic = $info['name'];
                $sql = "insert into ".FIX."type (id,name,pid,path,pic) value(null,'$name','$pid','$path','$pic')";
            }else{
                $sql = "insert into ".FIX."type (id,name,pid,path) value(null,'$name','$pid','$path')";
            }

            // 准备SQL语句
            $sql2 = "alter table ".FIX."type auto_increment=1";
            $res2 = mysqli_query($link,$sql2);
            
            // 发送SQL语句
            $res = mysqli_query($link,$sql);
            if($res && mysqli_affected_rows($link)){
                // echo '<script>alert("成功添加分类");location.href="./index.php"</script>';
                header('location:index.php');
                exit;
            } else{
                echo '<script>alert("添加分类失败，返回");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
            break;

        case 'del':
            if(empty($_GET['id'])){
                header('location:index.php');
                exit;
            }
            $id = $_GET['id'];
            $sql = "select * from ".FIX."type where pid='$id'";
            $sql2 = "select * from ".FIX."goods where tid=$id";
            $res2 = mysqli_query($link,$sql2);
            $arr2 = mysqli_fetch_assoc($res2);
            $res = mysqli_query($link,$sql);
            if($res && mysqli_num_rows($res)>0){
                $arr = mysqli_fetch_assoc($res);
                echo "<script>alert('请先删除{$arr['name']}下的子分类');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }elseif($res=='0'){
                echo "<script>alert('语法有误');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            if($res2 && mysqli_num_rows($res2)>0){
                echo "<script>alert('请先删除分类下的产品');location.href='../Goods/index.php?tid={$id}'</script>";
                exit;
            }
            $sql3 = "select * from ".FIX."type where id=$id";
            $res3 = mysqli_query($link,$sql3);
            $pic = mysqli_fetch_assoc($res3)['pic'];
            // 准备删除SQL语句
            $sql = "delete from ".FIX."type where id='$id'";

            // 发送删除SQL语句
            $res = mysqli_query($link,$sql);
            // 处理删除结果
            if($res && mysqli_affected_rows($link)>0){
                // 删除分类，同时删除对应的图片
                unlink('../../Public/upload/type/'.$pic);
                header('location:./index.php');
                exit;
            }else{
                echo '<script>alert("删除失败，返回");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
            break;
        
        case 'edit':
            
            if(empty($_POST)){
                header('location:index.php');
            }
            // 得到id和username
            $id = $_POST['id'];
            $name = $_POST['name'];

            // 得到新的$pid和$path
            $pid = ltrim(strrchr($_POST['path'],','),',');
            $path = $_POST['path'].',';
            // var_dump($pid);
            // var_dump($path);exit;

            // 判断分类名是否为空
            if(empty($name)){
                echo "<script>alert('分类名不能为空，返回修改');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            // 判断分类名格式是否正确
            $res1 = preg_match_all('/^[a-zA-Z0-9]\w*/',$name,$m);
            $res2 = preg_match_all("/^[\x{4e00}-\x{9fa5}]+/u", $name, $m);
            if($res1=='0' && $res2=='0'){
                echo "<script>alert('分类名格式不正确，请修改');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            // 判断是否一级类目
            if($_SESSION['ren']['pid']=='0'){
                echo "<script>alert('不能编辑一级类目');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit; 
            }
            // 判断是否移动到自己身上
            if($id ==$pid){
               echo "<script>alert('不能移动到自己身上');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit; 
            }
            // 判断自己是否有子类目
            $sql = "select * from ".FIX."type where pid =$id ";
            $res = mysqli_query($link,$sql);
            if($res && mysqli_num_rows($res)>0){
                echo "<script>alert('有子类目不可修改');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }

            $set = " name='$name',pid = '$pid',path = '$path' ";
            // echo $set;exit;

            // 判断图片是否有重新上传图片，
            // 有的话就调用函数，处理上传的图片 
            if($_FILES['pic']['error']!==4){
                $info = upload('pic','../../Public/upload/type/');
                if($info['status']){
                    $pic = $info['name'];
                    $set .= " , pic='$pic' ";
                }else{
                    echo '<script>alert("'.$info['msg'].'");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }
            }            

            // 准备SQL语句
            $sql = "update ".FIX."type set $set where id=$id ";

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