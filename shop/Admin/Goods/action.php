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
                header('location:index.php');
                exit;
            }
            // 接收数据，增加创建时间
            $name = $_POST['name'];
            $tid = $_POST['tid'];
            $price = $_POST['price'];
            $store = $_POST['store'];
            $status = $_POST['status'];
            $des = $_POST['des'];
            $time = time();
            // var_dump($_FILES);exit;
            

            // 判断分类是否为空
            if(empty($tid)){
                echo '<script>alert("分类选择有误，请选择正确的分类");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }

            // 判断商品名是否为空
            if(empty($name)){
                echo '<script>alert("商品名不能为空");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断价格是否为空
            if(empty($price)){
                echo '<script>alert("价格不能为空");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
            
            // 判断库存是否为空
            if(empty($store)){
                echo '<script>alert("库存不能为空");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
            // 调用函数，处理上传的图片 
            $info = upload('pic','../../Public/upload');
 			// 判断图片是否正常上传
            if($info['status']){
            	$pic = $info['name'];
            }else{
            	echo '<script>alert("'.$info['msg'].'");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

        	// 准备SQL语句
            $sql = "insert into ".FIX."goods (name,tid,price,store,status,time,des,pic) value('$name','$tid','$price','$store','$status','$time','$des','$pic')";

            // 设置id自增复原
            $sql2 = "alter table ".FIX."goods auto_increment=1";
            $res2 = mysqli_query($link,$sql2);
            // 发送SQL语句
            $res = mysqli_query($link,$sql);
            if($res && mysqli_affected_rows($link)){
                echo '<script>alert("成功添加商品");location.href="./index.php"</script>';
                exit;
            } else{
                echo '<script>alert("添加商品失败，返回");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
        	break;

        case 'status':
            $id = $_GET['id'];
            $status = $_GET['status'];
            $status = ($status=='1')?'2':'1';
            $sql = "update ".FIX."goods set status='$status' where id='$id'";
            $res = mysqli_query($link,$sql);
            header('location:'.$_SERVER['HTTP_REFERER'].'');
            break;

        case 'del':
            if(empty($_GET['id'])){
                header('location:index.php');
            }
            $id = $_GET['id'];
            // 判断是否有买过该商品的订单，有的话则不能删除商品
            $sql3 = "select * from ".FIX."order o,".FIX."detail d where d.oid=o.id and d.gid=$id";
            $res3 = mysqli_query($link,$sql3);
            if($res3 && mysqli_num_rows($res3)>0){
                 echo '<script>alert("该商品有存在的订单，无法直接删除");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
            // 找到该商品的pic名
            $sql2 = "select pic from ".FIX."goods where id='$id'";
            $res2 = mysqli_query($link,$sql2);
            $pic = mysqli_fetch_row($res2)[0];
            // var_dump($row);exit;
            // 准备删除SQL语句
            $sql = "delete from ".FIX."goods where id='$id'";

            // 发送删除SQL语句
            $res = mysqli_query($link,$sql);
            // 处理删除结果
            if($res && mysqli_affected_rows($link)>0){
                // 删除产品，同时删除对应的图片
                unlink('../../Public/upload/'.$pic);
                echo '<script>alert("删除成功");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
                // echo '<script>alert("删除成功");location.href="./index.php"</script>';
                exit;
            }else{
                echo '<script>alert("删除失败，返回");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
            break;
        
        case 'edit':

            if(empty($_POST)){
                header('location:index.php');exit;
            }
           // 接收数据，增加创建时间
            $id = $_POST['id'];
            $name = $_POST['name'];
            $tid = $_POST['tid'];
            $price = $_POST['price'];
            $store = $_POST['store'];
            $status = $_POST['status'];
            $des = $_POST['des'];
            $time = time();

           // 判断分类是否为空
            if(empty($tid)){
                echo '<script>alert("分类选择有误，请选择正确的分类");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }

            // 判断商品名是否为空
            if(empty($name)){
                echo '<script>alert("商品名不能为空");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断价格是否为空
            if(empty($price)){
                echo '<script>alert("价格不能为空");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
            
            // 判断库存是否为空
            if(empty($store)){
                echo '<script>alert("库存不能为空");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
            $set = " id='$id',name='$name',tid='$tid',price='$price',store='$store',status='$status',des='$des' ";
            // 判断图片是否有重新上传图片，
            // 有的话就调用函数，处理上传的图片 
            if($_FILES['pic']['error']!==4){
                $info = upload('pic','../../Public/upload');
                if($info['status']){
                    $pic = $info['name'];
                    $set .= " , pic='$pic' ";
                }else{
                    echo '<script>alert("'.$info['msg'].'");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }
            }            
           
            $sql = "update ".FIX."goods set $set where id=$id ";
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
        default:
            header('location:index.php');
    }