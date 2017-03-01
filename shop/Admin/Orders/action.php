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
       
        case 'changestatus':
            $id = $_GET['oid'];
            $status = $_GET['status'];
            switch ($status){
                case '1':
                    $status = 2;
                    break;
                case '2':
                    $status =3;
                    break;
                case '3':
                    $status = 4;
                    break;
                default:
            }
            // var_dump($status);exit;
            $sql = "update ".FIX."order set status='$status' where id='$id'";
            $res = mysqli_query($link,$sql);
            header('location:'.$_SERVER['HTTP_REFERER'].'');
            break;

        case 'delorder':
            if(empty($_GET['id'])){
                header('location:index.php');
            }
            $id = $_GET['oid'];

            // 准备删除SQL语句
            $sql = "delete from ".FIX."order where id='$id'";
            $sql2 = "select count(*) from ".FIX."detail where oid='$id'"; 
            $sql3 = "delete from ".FIX."detail where oid='$id'"; 

            // 发送删除SQL语句
            $res = mysqli_query($link,$sql);
            // 处理删除结果
            if($res && mysqli_affected_rows($link)>0){
                $res2 = mysqli_query($link,$sql2);
                $num = mysqli_fetch_assoc($res2)[0];
                $res3 = mysqli_query($link,$sql3);
                if($res3 && mysqli_affected_rows($link)==$num){
                    echo '<script>alert("删除成功");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                    // echo '<script>alert("删除成功");location.href="./index.php"</script>';
                    exit; 
                }else{
                     echo '<script>alert("删除订单详情表失败，返回");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                    exit;
                }
            }else{
                echo '<script>alert("删除失败，返回");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }
            break;
        
        // 编辑订单详情
        case 'edit':
            if(empty($_POST)){
                header('location:index.php');exit;
            }
           // 接收数据，增加创建时间
            $oid = $_POST['oid'];
            $total = $_POST['total'];
            $uid = $_POST['uid'];
            $status = $_POST['status'];
            $aid = $_POST['aid'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $aname = $_POST['aname'];
            $code = $_POST['code'];
            // 判断价格是否为空
            if(empty($total)){
                echo '<script>alert("价格不能为空");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断地址是否为空
            if(empty($address)){
                echo '<script>alert("地址不能为空");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
            
            // 判断电话是否为空
            if(empty($phone)){
                echo '<script>alert("电话不能为空");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
            $set = " total=$total,status=$status ";      
            $sql = "update ".FIX."order set $set where id=$oid ";
            $set2 = " name='$aname',phone='$phone',address='$address'";
            $sql2 = "update ".FIX."address set $set2 where id=$aid ";
            // echo $sql2;exit;

            // 发送修改SQL语句
            $res = mysqli_query($link,$sql);
            // 处理修改结果集
            if($res && mysqli_affected_rows($link)>0){
                $res2 = mysqli_query($link,$sql2);
                if($res2 && mysqli_affected_rows($link)>0){
                    echo "<script>alert('修改订单和地址成功');location.href='index.php'</script>";
                    exit;
                }else{
                    echo "<script>alert('修改订单成功,修改地址失败');location.href='index.php'</script>";
                    exit;
                }
            }else{
                $res2 = mysqli_query($link,$sql2);
                if($res2 && mysqli_affected_rows($link)>0){
                    echo "<script>alert('修改地址成功,修改订单失败');location.href='index.php'</script>";
                    exit;
                }else{
                    echo "<script>alert('地址和订单均修改失败，请重新修改');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                    exit;
                }
            }
            break;

        case 'deldetail':
            if(empty($_GET['did'])){
                header('location:detail.php');
                exit;
            }
            if(empty($_GET['oid'])){
                header('location:detail.php');
                exit;
            }
            $oid = $_GET['oid'];
            $did = $_GET['did'];
            $sql4 = "select count(*) from ".FIX."detail d,".FIX."order o where d.oid=o.id and o.id=$oid";
            $res4 = mysqli_query($link,$sql4);
            if($res4 && mysqli_num_rows($res4)>0){
                $cou = mysqli_fetch_row($res4)['0'];
                $sql2 = "select g.price,d.num,o.total,o.id oid from ".FIX."detail d,".FIX."order o,".FIX."goods g where d.oid=o.id and d.gid=g.id and d.id=$did";
                $res2 = mysqli_query($link,$sql2);
                if($res2 && mysqli_num_rows($res2)>0){
                    $row = mysqli_fetch_assoc($res2);
                }else{
                    header('location:detail.php');
                    exit;
                }
                $oid = $row['oid'];
                $total = $row['total'];
                $price = $row['price'];
                $num = $row['num'];
                $total = $total-($price*$num);
                if($cou>1){
                    $sql = "delete from ".FIX."detail where id=$did ";
                    $res = mysqli_query($link,$sql);
                    if($res && mysqli_affected_rows($link)>0){
                        $sql3 = "update ".FIX."order set total=$total where id=$oid ";
                        $res3 = mysqli_query($link,$sql3);
                        if($res3 && mysqli_affected_rows($link)>0){
                            echo "<script>alert('删除单条信息成功，修改总价成功');location.href='detail.php'</script>";
                            exit;
                        }else{
                            echo "<script>alert('删除单条信息成功，修改总价失败');location.href='detail.php'</script>";
                            exit;
                        }
                    }else{
                        echo "<script>alert('删除信息失败，修改失败');location.href='detail.php'</script>";
                            exit;
                    }
                }else{
                    $sql = "delete from ".FIX."detail where id=$did ";
                    $res = mysqli_query($link,$sql);
                    if($res && mysqli_affected_rows($link)>0){
                        $sql3 = "delete from ".FIX."order where id=$oid ";
                        // echo $sql3;exit;
                        $res3 = mysqli_query($link,$sql3);
                        if($res3 && mysqli_affected_rows($link)>0){
                            echo "<script>alert('只有一条商品信息，订单和明细都已删除成功');location.href='detail.php'</script>";
                            exit;
                        }else{
                            echo "<script>alert('删除单条信息成功，删除订单失败');location.href='detail.php'</script>";
                            exit;
                        }
                    }else{
                        echo "<script>alert('删除信息和订单均失败');location.href='detail.php'</script>";
                            exit;
                    }
                }
            }else{
                header('location:detail.php');
            }
            break;

        // case 'editdetail':

        //     if(empty($_POST)){
        //         header('location:detail.php');exit;
        //     }
        //    // 接收数据，增加创建时间
        //     $did = $_POST['did'];
        //     $oid = $_POST['oid'];
        //     $gid = $_POST['gid'];
        //     $uid = $_POST['uid'];
        //     $username = $_POST['username'];
        //     $gname = $_POST['gname'];
        //     $num = $_POST['num'];
        //     // var_dump($username);
        //     // var_dump($gname);
        //     // var_dump($price);exit;
        //     // 判断商品名是否为空
        //     if(empty($gname)){
        //         echo '<script>alert("商品名不能为空");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
        //         exit;
        //     }

        //     // 判断数量是否为空
        //     if(empty($num)){
        //         echo '<script>alert("数量不能为空");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
        //         exit;
        //     }
        //     $set = " num='$num' ";      
        //     $sql = "update ".FIX."detail set $set where id=$did ";
        //     $set2 = " name='$gname' ";
        //     $sql2 = "update ".FIX."goods set $set2 where id=$gid ";
        //     // echo $sql2;exit;

        //     // 发送修改SQL语句
        //     $res = mysqli_query($link,$sql);
        //     // 处理修改结果集
        //     if($res && mysqli_affected_rows($link)>0){
        //         $res2 = mysqli_query($link,$sql2);
        //         if($res2 && mysqli_affected_rows($link)>0){
        //             echo "<script>alert('修改订单明细和产品名成功');location.href='detail.php'</script>";
        //             exit;
        //         }else{
        //             echo "<script>alert('修改订单明细成功,修改产品名失败');location.href='detail.php'</script>";
        //             exit;
        //         }
        //     }else{
        //         $res2 = mysqli_query($link,$sql2);
        //         if($res2 && mysqli_affected_rows($link)>0){
        //             echo "<script>alert('修改产品名成功,修改订单明细失败');location.href='detail.php'</script>";
        //             exit;
        //         }else{
        //             echo "<script>alert('产品名和订单明细均修改失败，请重新修改');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
        //             exit;
        //         }
        //     }
        //     break;


        case 'deladdress':
             if(empty($_GET['aid'])){
                header('location:address.php');
                exit;
            }
            $aid = $_GET['aid'];
            $sql2 = "select * from ".FIX."order o where o.aid=$aid ";
            $res2 = mysqli_query($link,$sql2);
            if($sql2 && mysqli_num_rows($res2)>0){
                echo "<script>alert('该地址已有存在订单，无法删除，请先删除订单');location.href='address.php'</script>";
                exit;
            }
            $sql = "delete from ".FIX."address where id=$aid ";
            $res = mysqli_query($link,$sql);
            if($res && mysqli_affected_rows($link)>0){
                header('location:address.php');
                exit;
            }else{
                echo "<script>alert('删除失败');location.href='location:address.php'</script>";
                exit;
            }
            break;

        case 'editaddress':

            if(empty($_POST)){
                header('location:address.php');exit;
            }
            $id = $_POST['id'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            // 判断收件人是否为空
            if(empty($name)){
                echo '<script>alert("收件人不能为空");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
            // 判断电话是否为空
            if(empty($phone)){
                echo '<script>alert("电话不能为空");location.href="'.$_SERVER['HTTP_REFERER'].'"</script>';
                exit;
            }

            // 判断地址是否为空
            if(empty($address)){
                echo '<script>alert("地址不能为空");location.href="'.$_SERVER["HTTP_REFERER"].'"</script>';
                exit;
            }
            $set = " name='$name',phone='$phone',address='$address' ";      
            $sql = "update ".FIX."address set $set where id=$id ";

            // 发送修改SQL语句
            $res = mysqli_query($link,$sql);
            // 处理修改结果集
            if($res && mysqli_affected_rows($link)>0){
                    echo "<script>alert('修改地址信息成功');location.href='address.php'</script>";
                    exit;
            }else{
                echo "<script>alert('修改地址信息失败，请重新修改');location.href='".$_SERVER['HTTP_REFERER']."'</script>";
                exit;
            }
            break;

        default:
            header('location:address.php');

    }