<?php
    session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;
        charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>魅族官网在线商店-提供魅族 PRO 5、魅族MX系列、魅蓝note系列、魅蓝metal系列产品的预约和购买</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link href="./image/icon.ico" rel="shortcut icon" type="image/x-icon">
        <link href="./image/icon.ico" rel="icon" type="image/x-icon">
        <meta name="description" content="魅族商城是魅族面向全国服务的官方电商平台，提供魅族 PRO 系列、MX系列、魅蓝note系列和魅蓝metal系列的手机，配件和智能硬件的预约和购买。官方正品，全国联保，全场包邮，7天无理由退货，15天换货保障。">
        <meta name="Keywords" content="魅族官方在线商店、魅族在线商城、魅族官网在线商店、魅族商城">
        <link rel="stylesheet" href="./css/home/layout-ea436a570a.css">
        <link rel="stylesheet" href="./css/home/pkg-home.css">
        <style>
        .layout-header-logo-link{
            background:url('./image/home/logo.png') no-repeat;
        }

        </style>
    </head>
<body>
<!-- common header -->
<?php
    include_once './Public/home_header.php';
    include_once '../Public/config.php';
    $link = mysqli_connect(HOST,USER,PWD,DB)or die('连接数据库失败');
    mysqli_set_charset($link,'utf8');
?>
<div class="home-category-wrap">
    <div class="mzcontainer home-category-position">
        <div class="home-category-list">
            <ul class="home-category-nav">
                    <li class="home-category-nav-item ">
                        <a class="category-nav-link" href="./type.php" data-mtype="store_index_cdh_1" data-mdesc="侧边导航中第1个分类" >
                            <span>全部商品分类</span>
                        </a>
                    </li>

                    <?php
                        // 遍历一级分类
                        $sql = "select * from ".FIX."type where pid=0 limit 7";
                        $res = mysqli_query($link,$sql);
                        if($res && mysqli_num_rows($res)>0){
                            while($row=mysqli_fetch_assoc($res)){
                    ?>
                    <li class="home-category-nav-item ">
                        <a class="category-nav-link" data-mtype="store_index_cdh_2" data-mdesc="侧边导航中第2个分类" href="./type.php?id=<?=$row['id']?>&type=<?=$row['name']?>">
                            <span><?=$row['name']?></span>
                        </a>
                            <div class="category-nav-children no-ad-col-3">
                                <div class="nav-children-wrap">
                    <?php
                        // 遍历二级分类
                            $sql1 = "select * from ".FIX."type where pid={$row['id']}";
                            $res1 = mysqli_query($link,$sql1);
                            if($res1 && mysqli_num_rows($res1)>0){
                                while($row1=mysqli_fetch_assoc($res1)){?>
		                            <ul class="nav-children-left">
		                                <li class="nav-children-item">
		                                    <a href="./type.php?id=<?=$row1['id']?>&type=<?=$row1['name']?>" data-mtype="store_index_cdh_2_1" data-mdesc="侧边导航中第2个分类第1个产品">
		                                        <img src="./image/home/init-1x1.jpg" data-src="<?=__PUBLIC__?>/type/<?=$row1['pic']?>"width="50" height="50" alt="魅蓝 Note5">
		                                        <span><?=$row1['name']?></span>
		                                    </a>
		                                </li> 
		                            </ul>    	
                        <?php
	                            }	}	}	}
	                    ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="MzHomeSlider" class="home-slider">
    <div class="home-slider-items">
        <div class="bx-wrapper" style="max-width:100%;">
            <div class="bx-viewport" style="width:100%;overflow:hidden;position:relative;height:480px;">
                <ul class="bxslider" style="width:auto;position:relative;">
                    <li class="home-slider-box" data-bgcolor="#FFFFFF" style="float:none;list-style:none;position:absolute;width:1349px;z-index:50;display:block;background:rgb(255,255,255);">
                        <a class="home-slider-image" style="width:1920px;margin-left:-960px;" data-mtype="store_index_ba_1" data-mdesc="第1屏banner">
                            <img src="./image/home/Cix_s1hOF-6AExjcABX8_I6kD6g141.png" width="1920" height="480">
                        </a>
                    </li>  
                </ul>
            </div>
        </div>
    </div>
</div>
        <div class="mzcontainer">

<div class="home-mzad">
  <div class="home-box home-service">
      <div class="service-module-2">
        <a href="http://mformy.meizu.com/?click=store_index_gd_1" target="_blank" >
          <span class="home-service-icon service-icon-mentry">
            <img src="./image/home/1450855246-61162.png" width="24" height="24" alt="M码通道">
          </span>
          <p>M码通道</p>
        </a>
      </div>
      <div class="service-module-2">
        <a href="http://mcycle.meizu.com/?click=store_index_gd_2">
          <span class="home-service-icon service-icon-mentry">
            <img src="./image/home/1450855279-64872.png" width="24" height="24" alt="以旧换新">
          </span>
          <p>以旧换新</p>
        </a>
      </div>
      <div class="service-module-2">
        <a href="" target="_blank">
          <span class="home-service-icon service-icon-mentry">
            <img src="./image/home/1450855198-58056.png" width="24" height="24" alt="魅族意外保">
          </span>
          <p>魅族意外保</p>
        </a>
      </div>
      <div class="service-module-2">
        <a href="" target="_blank">
          <span class="home-service-icon service-icon-mentry">
            <img src="./image/home/1451960447-93534.png" width="24" height="24" alt="回购单查询">
          </span>
          <p>回购单查询</p>
        </a>
      </div>
  </div>

    <div class="home-box home-ad-box">
      <a href="" target="_blank">
        <img src="./image/home/CnQOjVhFNwmAYvQrAAAqUbqSkrE237.jpg" width="244" height="140">
      </a>
    </div>
    <div class="home-box home-ad-box">
      <a href="" target="_blank">
        <img src="./image/home/Cix_s1hOBziAVRZbAABBtYp331U332.jpg" width="244" height="140">
      </a>
    </div>
    <div class="home-box home-ad-box">
      <a href="" target="_blank">
        <img src="./image/home/Cix_s1hIzZCANeseAAArSRxfc3c907.jpg" width="244" height="140">
      </a>
    </div>
    <div class="home-box home-ad-box">
      <a href="" target="_blank">
        <img src="./image/home/Cix_s1hKH-CAfvECAAAvbKGLEQQ695.jpg" width="244" height="140">
      </a>
    </div>
</div>

<div class="site-gotop" style="display:block;
    ">
 <a class="gotop-suggest" title="建议反馈" ></a>
 <div class="gotop-arrow" title="回到顶部"></div>
</div>

    <div class="home-full-box" style="margin-top:30px;">

        <div class="mzcontainer">
            <div class="home-panel home-rmd home-floor">                 
        <?php
            $sql = "select * from ".FIX."type where pid =0";
            $res = mysqli_query($link,$sql);
            if($res && mysqli_num_rows($res)>0){
                $row = mysqli_fetch_all($res,MYSQLI_ASSOC);
                // var_dump($row);exit;
            }
            foreach($row as $j){
            $sql2 = "select * from ".FIX."type where pid = {$j['id']}";
            $res2 = mysqli_query($link,$sql2);
            if($res2 && mysqli_num_rows($res2)>0){
                $row2 = mysqli_fetch_all($res2,MYSQLI_ASSOC); 
            ?>
                <div class="home-rmd-main">
                    <div class="home-rmd-cotent">
                            <div class="home-full-box white">
					            <div class="mzcontainer">
					                <div class="home-floor-ad">
					                    <img src="./image/home/CnQOjVhOAWyAcHfNAADyNbd8e94667.jpg">
					                        <a class="hot-point" style="width:1240px;height:120px;left:0px;top:0px;"></a>
					                </div>
					            </div>
					        </div>
					    <div class="home-panel home-rmd home-floor">
					        <div class="home-panel-topbar">
						        <a href="./type.php?id=<?=$j['id']?>&type=<?=$j['name']?>"><h2 class="home-panel-title"><?=$j['name']?></h2></a>
	                    		<h6 class="home-panel-subtitle">
	                                <a href="http://lists.meizu.com/page/list?categoryid=88&rc=lc&click=store_index_kwd_3_1" target="_blank" data-mtype="store_index_kwd_3_1" data-mdesc="第3个楼层上方小导航第1个按钮   "></a>
	                    		</h6>
					        </div>
					    </div>
                        <?php    
                        // 遍历找出二级类目对应的产品
                            foreach($row2 as $k){ 
                             $sql3 = "select * from ".FIX."goods where tid = {$k['id']}";
                                // echo $sql3;exit;    
                                $res3 = mysqli_query($link,$sql3);
                                if($res3 && mysqli_num_rows($res3)>0){
                                    $row3 = mysqli_fetch_all($res3,MYSQLI_ASSOC);
                                    // var_dump($row3);exit;
                                    foreach($row3 as $l){
				                        ?>                                     
				                        <div class="rmd-box rmd-box-product">
				                            <a href="details.php?id=<?=$l['id']?>" target="_blank" data-mtype="store_index_kw_1_2" data-mdesc="第1个楼层第2个坑">
				                                <div class="rmd-product-detail">
				                                    <img class="home-img-lazy"  src="<?=__PUBLIC__.$l['pic']?>" width="180" height="180" style="display:inline;">
				                                    <div class="rmd-product-desc">
				                                        <h4 class="rmd-product-title"></h4>
				                                            <h6 class="rmd-product-subtitle"><?=$l['name']?></h6>
				                                        <!-- TODO 替换为内容-->
				                                        <p class="rmb-product-bottom">
				                                            <span class="rmd-product-price">
				                                            ¥
				                                            <span><?=$l['price']?></span>
				                                            </span>
				                                        </p>
				                                    </div>
				                                </div>
				                            </a>
				                        </div>
				                    <?php
				                    	
				                        }
				                    }
				                }
				            }
				       }
				        ?>                  
                </div>
            </div>
        </div>
    </div>
</div>
<table class="footernew footheight" style="width:1000px;" bosszone="footer">
    <tr style="width:960px;">
 <?php
    include_once './Public/home_footer.php';
    $sql = "select * from ".FIX."link";
    $res = mysqli_query($link,$sql);
    if($res && mysqli_num_rows($res)>0){ 
        $you = mysqli_fetch_all($res,MYSQLI_ASSOC);
        foreach($you as $v){   
            if(!empty($v['pic'])){
                $src =  __PUBLIC__.'link/'.$v['pic']; 
            }else{
                $src = ''; 
            }
     ?>
        <td width="100">   
            <a style="color:#999" href="<?=$v['lujing']?>" target="_blank" rel="nofollow">
                <img width="50" height="50" border="0" alt="<?=$v['name']?>" src="<?=$src?>">
                <?=$v['name']?></a>
        </td>

        <?php    
        }

    }

 ?>
    </tr>  
</table>
</body></html>