<html>
<head>
    <link rel="stylesheet" href="./css/details/layout-25702f0ee1.css">
    <link rel="stylesheet" href="./css/details/main-610bbe3.css">
    <link href="./image/icon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="./image/icon.ico" rel="icon" type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<?php
    session_start();
    if(empty($_GET['id'])){
        header('location:home.php');exit;
    }
    include_once './Public/home_header.php';
    include_once '../Public/config.php';
    $id = $_GET['id'];
    $link = mysqli_connect(HOST,USER,PWD,DB) or die('连接数据库失败');
    $sql = "select * from ".FIX."goods where id='$id'";
    $res = mysqli_query($link,$sql);
    if($res && mysqli_num_rows($res)>0){
        $row = mysqli_fetch_assoc($res);
    }else{
        echo '<script>alert("找不到你要的商品");location.href="./home.php"</script>';
        exit;
    }
?>
    <script charset="utf-8" src="./css/details/v.js"></script>
    <script src="./css/details/hm.js"></script>
    <script src="./css/details/flow.js"></script>
    <script src="./css/details/analytics-min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?=$row['name']?>-魅族商城</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=$row['name']?>，正品行货，另有<?=$row['name']?>详细介绍、图片、价格、参数、售前咨询等，购买<?=$row['name']?>上魅族商城，全场包邮，7天无理由退货，15天换货保障。">
    <meta name="keywords" content="<?=$row['name']?>，魅族，魅族商城">
    <style type="text/css">
        .site-gotop {
            position:fixed;
            width:44px;
            bottom:50px;
            left:50%;
            margin-left:640px;
            display:none
        }
        .gotop-suggest,.gotop-arrow {
            display:inline-block;
            width:44px;
            height:44px;
            background:#b4b4b4 no-repeat 50%50%;
            cursor:pointer
        }
        .gotop-suggest {
        	background-image:url(//store.res.meizu.com/resources/php/store/static/detail/assets/img/suggest.png)
        }
        .gotop-arrow {
	        background-image:url(//store.res.meizu.com/resources/php/store/static/detail/assets/img/gotop-arrow.png);
	        margin-top:5px
        }
    </style>
</head>
<body>
    <!-- common header -->

        <!--下面是模板标签，不可删除-->
        <main class="wrapper page-detail">
            <div class="container">
                <section class="crumbs clearfix">
                            <a data-mtype="store_de_mbx_1" href="http://store.meizu.com/index.html">首页</a>&nbsp;&gt;&nbsp;
                            <a class="ellipsis crumbs-title"><?=$row['name']?></a>
                </section>
                <section class="row">
                    <div class="preview" id="preview">
                        <div class="preview-booth">
                            <a href="javascript:;" id="J_imgBooth">
                                <img src="<?=__PUBLIC__.$row['pic']?>" height="375" width="375" alt="">
                            </a>
                        </div>
                        <ul class="preview-thumb clearfix" id="J_previewThumb">
                            <li class="current">
                                <a data-mtype="store_de_tp_1">
                                    <img src="<?=__PUBLIC__.$row['pic']?>" width="75" height="75">
                                </a>
                            </li>
                            <li>
                                <a data-mtype="store_de_tp_2">
                                    <img src="<?=__PUBLIC__.$row['pic']?>" width="75" height="75">
                                </a>
                            </li>
                            <li>
                                <a data-mtype="store_de_tp_3">
                                    <img src="<?=__PUBLIC__.$row['pic']?>" height="75">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="property" id="property">
                            <div class="property-hd">
                                <h1><?=$row['name']?></h1>

                                <p class="mod-info active"><?=$row['des']?></p>
                            </div>
                            <div class="property-sell">
                                <dl class="property-sell-price clearfix">
                                    <dt class="vm-metatit" id="J_discountTag">价
                                        <span class="s-space"></span>
                                        <span class="s-space"></span>格：
                                    </dt>
                                    <dd>
                                        <div class="mod-price">
                                            <small>¥</small>
                                            <span id="J_price" class="vm-money"><?=$row['price']?></span>
                                        </div>
                                        <div class="mod-original" id="J_originalPrice" style="display:none;"></div>
                                        <div class="mod-activity"></div>
                                        <div class="mod-countdown" id="J_discountCountDown" style="display:none;"></div>
                                    </dd>
                                </dl>
                                <dl class="property-sell-coupon clearfix" id="J_prodPromo" style="display:none;">
                                    <dt class="vm-metatit">领
                                        <span class="s-space"></span>
                                        <span class="s-space"></span>券：
                                    </dt>
                                    <dd>
                                        <p id="J_promoInner"></p>
                                        <a class="vm-more" id="J_promoMore" href="http://detail.meizu.com/item/pro6plus.html?click=store_list_kw_1#">更多&gt;</a>
                                    </dd>
                                </dl>
                            </div>
                            <div class="property-set">
                                <dl class="property-set-sale" data-property="颜色分类">
                                    <dt class="vm-metatit">颜色分类：</dt>
                                    <dd class="clearfix">
                                        <a data-value="3:14286" class="vm-sale-img selected" data-mtype="store_de_sp_2_1">
                                            <img src="<?=__PUBLIC__.$row['pic']?>" width="32" height="32">
                                        </a>
                                    </dd>
                                </dl>
                            </div> 
                            <div class="property-set">
                            <?php 
                                if($row['status']==2){
                                    $disno = "style='display:none';";
                                }else{
                                    $disno = '';
                                }
                            ?>
                                <dl class="property-set-sale" <?=$disno?> data-property="库存">
                                    <dt class="vm-metatit">剩余库存：</dt>
                                    <dd class="clearfix">
                                        <a data-value="3:14286" class="vm-sale-img " data-mtype="store_de_sp_2_1"><span><?=$row['store']?></span>
                                        </a>
                                    </dd>
                                </dl>
                            </div>
                            <div class="property-buy">
                                <p class="vm-message" id="J_message"></p>
                                <dl class="property-buy-quantity">
                                    <dt class="vm-metatit">数
                                        <span class="s-space"></span>
                                        <span class="s-space"></span>量：
                                    </dt>
                                    <dd class="clearfix">
                                        <div class="mod-control">
                                            <input type="text" value="1" id="J_quantity" data-max="1">
                                        </div>
                                        <?php
                                            if($row['store']<=0 ||$row['status']==2){
                                                $xianshi = "<a id='J_btnBuy' class='btn btn-primary btn-lg' data-mtype='store_de_buy'>已售罄</a>";
                                            }else{
                                                $xianshi = "<a id='J_btnBuy' class='btn btn-primary btn-lg' data-mtype='store_de_buy' href='./action.php?a=buy&id={$row['id']}'>立即购买</a>
                                            <a id='J_btnBuy' class='btn btn-primary btn-lg' data-mtype='store_de_buy' href='./action.php?a=addgoods&id={$row['id']}'>加入购物车</a>";
                                            }
                                        ?>
                                            
                                        <div>
                                            <?=$xianshi?>
                                            <p class="vm-service" id="J_panicBuyingWrap"></p>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        <div class="prod-addition">
                            <div class="layer-promo" id="layerPromo" style="display:none;">
                                <div class="layer-promo-hd">
                                    领取优惠券
                                    <a class="vm-close" id="J_promoClose" href="">
                                        ╳
                                    </a>
                                </div>
                                <div class="layer-promo-bd">
                                    <dl class="discount-coupon" id="J_discountCoupon">
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="detail-tab anim detail-fast-float fixed float-button float-nav" id="detailFast">
                <div class="fixed-container">
                    <ul class="clearfix">
                        <li class="current">
                            <a>商品详情</a>
                        </li>
                        <li>
                            <a>规格参数</a>
                        </li>
                            <li>
                                <a>常见问题</a>
                            </li>
                    </ul>
                    <?php
                        if($row['store']<=0 ||$row['status']==2){
                            $xianshi2 = "<a id='J_btnBuyShortcut' class='btn btn-primary btn-lg'><i></i>已售罄</a>";
                        }else{
                            $xianshi2 = "<a href='./action.php?a=buy&id={$row['id']}' id='J_btnBuyShortcut' class='btn btn-primary btn-lg'><i></i>现在购买</a>";
                        }
                    ?>
                    <div class="shortcut trans">
                        <div class="mod-buy">
                            <?=$xianshi2?>
                        </div>
                        <div class="mod-total trans"><?=$row['name']?>
                            <em class="vm-price" id="J_totalPriceShortcut">￥<?=$row['price']?></em>
                            <p class="vm-title" id="J_summaryName"></p>
                        </div>
                    </div>
                    <div class="mod-title">

                    </div>
                </div>
            </div>
            <section class="row detail" id="detail">
                <div style="height:62px;">
                    <div class="detail-tab" id="detailTabFixed">
                        <div class="fixed-container">
                            <ul class="clearfix" style="display: none;">
                                <li class="current">
                                    <a data-mtype="store_de_xq_1" href="">商品详情</a>
                                </li>
                                <li>
                                    <a data-mtype="store_de_xq_2" href="">规格参数</a>
                                </li>
                                    <li>
                                        <a data-mtype="store_de_xq_3" href="">常见问题</a>
                                    </li>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="detail-content container">
                    <div class="introduce" id="introduce" style="display:block;">
                        <img class="lazy" data-original="//openfile.meizu.com/group1/M00/00/C3/CnQOjVg-gXyARuuDAAFokGRQqdE574.jpg" width="1240" alt="" src="./image/details/CnQOjVg-gXyARuuDAAFokGRQqdE574.jpg" style="display: inline;">
                        <img class="lazy" data-original="//openfile.meizu.com/group1/M00/00/C3/CnQOjVg-gX2AW6zuAAMlj9z_DNk624.jpg" width="1240" alt="" src="./image/details/CnQOjVg-gX2AW6zuAAMlj9z_DNk624.jpg" style="display: inline;">
                        <img class="lazy" data-original="//openfile.meizu.com/group1/M00/00/C3/Cix_s1g-gX2AZB5BAAJTPHO8K84717.jpg" width="1240" alt="" src="./image/details/Cix_s1g-gX2AZB5BAAJTPHO8K84717.jpg" style="display: inline;">
                        <img class="lazy" data-original="//openfile.meizu.com/group1/M00/00/C3/Cix_s1g-gX2AZN8KAAJxvyeCYuM116.jpg" width="1240" alt="" src="./image/details/Cix_s1g-gX2AZN8KAAJxvyeCYuM116.jpg" style="display: inline;">
                        <img class="lazy" data-original="//openfile.meizu.com/group1/M00/00/C3/CnQOjVg-gX2AHSoNAAF8uZS2Ec0534.jpg" width="1240" alt="" src="./image/details/CnQOjVg-gX2AHSoNAAF8uZS2Ec0534.jpg" style="display: inline;">
                        <img class="lazy" data-original="//openfile.meizu.com/group1/M00/00/C3/Cix_s1g-gX2ACyp5AAIKsNKFiIg644.jpg" width="1240" alt="" src="./image/details/Cix_s1g-gX2ACyp5AAIKsNKFiIg644.jpg" style="display: inline;">
                        <img class="lazy" data-original="//openfile.meizu.com/group1/M00/00/C3/CnQOjVg-gX2AGqu4AAHDAiHIAU0307.jpg" width="1240" alt="" src="./image/details/CnQOjVg-gX2AGqu4AAHDAiHIAU0307.jpg" style="display: inline;">
                        <img class="lazy" data-original="//openfile.meizu.com/group1/M00/00/C3/Cix_s1g-gX6AZxWLAAFP5xynT0M390.jpg" width="1240" alt="" src="./image/details/Cix_s1g-gX6AZxWLAAFP5xynT0M390.jpg" style="display: inline;">
                        <img class="lazy" data-original="//openfile.meizu.com/group1/M00/00/C3/CnQOjVg-gX6AEck3AAHYLC8nPKw914.jpg" width="1240" alt="" src="./image/details/CnQOjVg-gX6AEck3AAHYLC8nPKw914.jpg" style="display: inline;">
                        <img class="lazy" data-original="//openfile.meizu.com/group1/M00/00/C3/Cix_s1g-gX6AGn4nAAHCG6jiEM4513.jpg" width="1240" alt="" src="./image/details/Cix_s1g-gX6AGn4nAAHCG6jiEM4513.jpg" style="display: inline;">
                        <img class="lazy" data-original="//openfile.meizu.com/group1/M00/00/C3/CnQOjVg-gX6AWOMGAAB2eJ7V-eM461.jpg" width="1240" alt="" src="./image/details/CnQOjVg-gX6AWOMGAAB2eJ7V-eM461.jpg" style="display: inline;">
                    </div>
                </div>
            </section>
        </main>
    <?php
    	include_once './Public/home_footer.php';
    ?>
</body></html>