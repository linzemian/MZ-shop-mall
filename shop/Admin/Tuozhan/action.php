    <?php
    // var_dump($_POST);exit;
    session_start();
    // var_dump($_POST);
    // 引入配置文件
    include_once '../../Public/config.php';
    include_once '../../Public/function.php';
    // 判断是否非法访问，非法则跳回首页
    if(empty($_GET['a'])){
        header('location:you.php');
        exit;
    }
    // 连接数据库，设置字符集
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('数据库连接失败。<a href="./index.php">返回</a>');
    mysqli_set_charset($link,'utf8');
    // 判断执行操作的类型
    switch ($_GET['a']){
        case 'addyou':

           if(empty($_POST['name'])){
                echo "<script>alert('标题不能为空');location.href='add.php'</script>";
                exit;
           }else{
                $name = $_POST['name']; 
           }
           if(empty($_POST['lujing'])){
                echo "<script>alert('路径不能为空');location.href='add.php'</script>";
                exit;
           } else{
                 $lujing = $_POST['lujing']; 
           }
           if($_FILES['pic']['error']!=4){
                // 调用函数，处理上传的图片 
                $info = upload('pic','../../Public/upload/link');
                // 判断图片是否正常上传
                if($info['status']){
                    $pic = $info['name'];
                }else{
                    echo '<script>alert("'.$info['msg'].'");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }
           }else{
                $pic = '';
           }
           $sql = "insert into ".FIX."link values(null,'$name','$lujing','$pic')";
           $res = mysqli_query($link,$sql);
           if($res && mysqli_affected_rows($link)>0){
                echo "<script>alert('成功添加链接');location.href='you.php'</script>";
                exit;
           }else{
                echo "<script>alert('添加链接失败');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;           
           }
           break;

        case 'delyou':

           if(empty($_GET['id'])){
                header('location:you.php');
                exit;
           }else{
                $id = $_GET['id'];
           }

           $sql = "delete from ".FIX."link where id=$id";
           $res = mysqli_query($link,$sql);
           if($res && mysqli_affected_rows($link)>0){
                header('location:you.php');
                exit;
           }else{
                echo "<script>alert('删除链接失败');location.href='you.php'</script>";
                exit; 
           }
           break;

         case 'edityou':
           if(empty($_POST['id'])){
                header('loacation:you.php');
                exit;
           }else{
                $id = $_POST['id'];
           }
           if(empty($_POST['name'])){
                echo "<script>alert('标题不能为空');location.href='add.php'</script>";
                exit;
           }else{
                $name = $_POST['name']; 
           }
           if(empty($_POST['lujing'])){
                echo "<script>alert('路径不能为空');location.href='add.php'</script>";
                exit;
           } else{
                 $lujing = $_POST['lujing']; 
           }
           if($_FILES['pic']['error']!=4){
                // 调用函数，处理上传的图片 
                $info = upload('pic','../../Public/upload/link');
                // 判断图片是否正常上传
                if($info['status']){
                    $pic = $info['name'];
                }else{
                    echo '<script>alert("'.$info['msg'].'");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }
           }
           if($_FILES['pic']['error']==4){
                $set = " name='$name',lujing='$lujing ' ";
           }else{
                $set = " name='$name',lujing='$lujing',pic='$pic' ";
           }
           $sql = "update ".FIX."link set $set where id=$id";
           $res = mysqli_query($link,$sql);
           if($res && mysqli_affected_rows($link)>0){
                echo "<script>alert('修改链接成功');location.href='you.php'</script>";
                exit;
           }else{
                echo "<script>alert('添加链接失败');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;           
           }
           break;


    }