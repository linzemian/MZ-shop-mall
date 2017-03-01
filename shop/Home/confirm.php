<?php
    session_start();
    include_once '../Public/config.php';
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('数据库连接失败');
    mysqli_set_charset($link,'utf8');
    if(empty($_SESSION['home_info'])){
        echo "<script>alert('亲，请先登录~~');location.href='login.php'</script>";
        exit;
    }else{
        $panduan = $_SESSION['home_info']['id'];
        $sql5 = "select * from ".FIX."user where id=$panduan ";
        $chazhao = mysqli_query($link,$sql5);
        if($chazhao && mysqli_num_rows($chazhao)<=0){
            unset($_SESSION['home_info']);
            header('location:home.php');
            exit;
        }
    }
    if(empty($_SESSION['shopcar'])){
        echo "<script>alert('购物车没有商品，请先添加一件先');location.href='shopcar.php'</script>";
        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>确认订单-魅族商城</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./image/icon.ico" rel="shortcut icon" type="image/x-icon">
        <link href="./image/icon.ico" rel="icon" type="image/x-icon">
        <meta name="description" content="魅族商城是魅族面向全国服务的官方电子商务平台,提供魅族PRO系列、魅族MX系列和魅蓝系列等产品的预约和购买.官方正品,全国联保.">
        <meta name="keywords" content="魅族官方在线商店、魅族在线商城、魅族官网在线商店、魅族商城">
        <link rel="stylesheet" href="css/confirm/layout-25702f0ee1.css">
        <link href="css/confirm/add-b464169420.css" rel="stylesheet" charset="UTF-8">
        <style>
            .layout-header-logo-link{
                background:url('./image/home/logo.png') no-repeat;
            }

        </style>
    </head>
<body>
<?php

    include_once './Public/home_header.php';

?>
<form action="action.php?a=addorder" method="post">
    <div class="order">
    <div class="mzcontainer">
        <div class="order-header">
            <div class="order-header-title">
                确认订单
            </div>
            <ul class="order-header-bread">
                <li class="order-header-bread-block active">购物车</li>
                <li class="order-header-bread-block active">确认订单</li>
                <li class="order-header-bread-block">在线支付</li>
                <li class="order-header-bread-block">完成</li>
            </ul>
        </div>
                <div class="order-address" id="addressModule">
                    <div class="order-address-title">收货人信息</div>
                    <ul style="height: 174px;" class="order-address-list clearfix" id="addressList">
                    <?php
                        $uid = $_SESSION['home_info']['id'];
                        $sql = "select * from ".FIX."address where uid = $uid";
                        $res = mysqli_query($link,$sql);
                        // var_dump($res);exit;
                        if($res && mysqli_num_rows($res)>0){
                            $dizhis = mysqli_fetch_all($res,MYSQLI_ASSOC);
                            // var_dump($dizhis);
                            foreach($dizhis as $v){ 
                            $checked = ($dizhis[0]['id']==$v['id'])?'checked':'';
                            // var_dump($v);
                            ?>
                                <label>
                                    <input class="zzzz" name="addressid" value="<?=$v['id']?>" type="radio" style="display:none">
                                    <li  class="order-address-checkbox zzzz">
                                        <div class="order-address-checkbox-top">
                                            <div class="order-address-checkbox-name"><?=$v['name']?></div>
                                            <div class="order-address-checkbox-phone"><?=$v['phone']?></div>
                                        </div>
                                        <div class="order-address-checkbox-content"><?=$v['address']?></div>
                                        <div class="order-address-checkbox-checked">
                                            <div class="order-address-checkbox-tick"></div>
                                        </div>
                                        <div class="order-address-checkbox-ctrl">
                                            <a class="order-address-checkbox-edit" style="color:#00c3f5;"href="editaddress.php?id=<?=$v['id']?>">
                                            </a>  
                                            <a class="order-address-checkbox-delete" style="color:#00c3f5;" href="action.php?a=deladdress&id=<?=$v['id']?>">
                                            </a>
                                        </div>
                                    </li>
                                </label>
                                <?php
                                }

                            }else{
                                
                            }

                        ?>
                <a href="address.php">
                    <li class="order-address-checkbox add">
                        <div class="order-address-add-icon"></div>
                        <div class="order-address-add-text">添加新地址</div>
                    </li>
                </a>
            </ul>
            <div class="order-address-bottom">
                <div class="order-address-more" id="orderAddressMore">
                  <p class="order-address-more-text">点击显示更多地址</p>
 				  <i class="order-address-triangle"></i>
                </div>
            </div>
        </div>

        <div class="mzcontainer order-product">
            <div class="order-product-title">确认订单信息</div>
            <div class="order-product-list" id="orderProductList">
                <table cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="order-product-table-name">
                                <div class="order-product-supplier">供应商：
                                     <span class="order-product-supplier-name">魅族</span>
                                     <div class="order-product-supplier-tips">由“魅族”负责发货，并提供售后服务</div>
                                    </div>
                                </th>
                            <th class="order-product-table-price">单价</th>
                            <th class="order-product-table-num">数量</th>
                            <th class="order-product-table-total">小计</th>
                            <th class="order-product-table-express">配送方式</th>
                        </tr>
                    </thead>
                <tbody>
                <?php
                    $total = 0; 
                    foreach($_SESSION['shopcar'] as $v){
                            $total += $v['num']*$v['price'];
                ?>
                    <tr>
                        <td class="order-product-table-name">
                            <img class="order-product-image" src="<?=__PUBLIC__.$v['pic']?>">
                            <div class="order-product-name">
                                <a target="_blank" class="order-product-link" href="./details.php?id=<?=$v['id']?>"><?=$v['name']?></a>
                            </div>
                        </td>
                        <td class="order-product-table-price"><p></p>
                            <span class="order-product-price"><?=$v['price']?></span>
                        </td>
                        <td class="order-product-table-num"><?=$v['num']?></td>
                            <td class="order-product-table-total">
                                <p class="order-product-price red"><?=number_format($v['price']*$v['num'],2)?></p>
                            </td>
                            <td rowspan="1" class="order-product-table-express">
                                <p>运费：
                                    <span class="order-product-price red">0.00</span>
                                </p>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="order-product-info">
                                    <div class="order-product-invoice clearfix">
                                        <div class="order-product-invoice-type">发票类型：电子发票
                                            <div class="order-product-invoice-icon"></div>
                                        </div>
                                        <div class="order-product-invoice-title">发票抬头：默认为收货人姓名</div>
                                    </div>
                                    <div class="order-product-remark">
                                    <span class="order-product-remark-title">备注</span>
                                    <textarea class="order-product-remark-input" placeholder="备注..." maxlength="45"></textarea>
                                </div>
                            </div>
                            <div class="order-product-total">合计：
                                <span class="order-product-price red"><?=number_format($total,2)?></span>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        <div class="order-total clearfix">
            <div class="order-total-content">
                <div class="order-total-row order-total-valid-row clearfix">
                    <input type="submit" value="提交订单" class="mz-btn success" id="submitForm">
                </div>
            </div>
        </div>
    </div>
</div>
    
<!-- end content -->

 <?php
    include_once './Public/home_footer.php';
    $_SESSION['total']=$total;
 ?>

</form>
</body></html>