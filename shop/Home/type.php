<?php
    session_start();
    $type=(isset($_GET['type']))?$_GET['type']:'全部商品';
    $name=(isset($_GET['name']))?$_GET['name']:'';
?>
<html>
    <link href="./image/icon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="./image/icon.ico" rel="icon" type="image/x-icon">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?=empty(!$name)?$name:$type?>-魅族商城</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="魅族商城提供各种手机产品，包括，品质保障，可按推荐、商品上架时间，价格等放心购买，魅族商城将为您提供最好的子类目名称产品，全场包邮，7天无理由退货，15天换货保障。">
    <meta name="keywords" content="手机,，魅族，魅族手机，魅族商城">
    <link rel="stylesheet" href="./css/type/layout-25702f0ee1.css">

    <link rel="stylesheet" href="./css/type/list-30ce4a4a2d.css">
    <style type="text/css">
        .site-gotop{
            position:fixed;
            width:44px;
            bottom:50px;
            left:50%;
            margin-left:640px;
            display:none
        }
        .gotop-suggest,.gotop-arrow{
            display:inline-block;
            width:44px;
            height:44px;
            background:#b4b4b4 no-repeat 50%50%;cursor:pointer
        }
        .gotop-suggest{
            background-image:url(http://store.res.meizu.com/resources/php/store/static/detail/assets/img/suggest.png)}
        .gotop-arrow{background-image:url(http://store.res.meizu.com/resources/php/store/static/detail/assets/img/gotop-arrow.png);margin-top:5px}
        .layout-header-logo-link{
            background:url('./image/home/logo.png') no-repeat;
        }
    </style>
    </head>
    <body>
        <!-- common header -->
<?php
    include_once './Public/home_header.php';
    $search = '';
?>

<!--下面是模板标签，不可删除-->

<main class="wrapper" id="main">
    <div class="container">
        <section class="crumbs clearfix">
            <a data-mtype="store_list_mbx_1" href="./home.php">首页</a> &nbsp;&gt;&nbsp;
            <span class="crumbs-level" id="crumbsLevel"><a href="type.php" data-mtype="store_list_mbx_2" data-cateid="73">全部商品</a>&nbsp;&gt;&nbsp;<?=empty(!$name)?$name:$type?></span>
        </section>

<section class="goods-list" id="goodsList">
        <ul class="goods-list-wrap clearfix" id="goodsListWrap">
        <?php
            include_once '../Public/config.php';
            $link = mysqli_connect(HOST,USER,PWD,DB)or die('连接数据库失败');
            mysqli_set_charset($link,'utf8');
            $id = isset($_GET['id'])? $_GET['id']:'';
            $search = "";

            // 判断是否通过搜索条件进来
            if(!empty($name)){
                $where =" where status=1 and store>0 and name like '%$name%' ";
                $search .= "&name=$name";
            }else{
                $where = " where status=1 and store>0 ";
            }

            // 判断首页传过来的是一级分类还是二级分类id,在type里用pid=id判断，如果查到值就是一级分类，如果查不到就是二级分类，二级分类则用传过来的id
            if(!empty($id)){
                $search .= "&id=$id";
                $sql1 = "select * from ".FIX."type where pid=$id ";
                $res1 = mysqli_query($link,$sql1);
                if($res1 && mysqli_num_rows($res1)>0){
                    $sonid = [];
                    while($row1 = mysqli_fetch_assoc($res1)){
                        $sonid[] = $row1['id'];
                    }
                    // 将拿到的二级菜单的id数组拼接起来
                    $ids = implode(',',$sonid);
                    $where .= " and tid in($ids)";
                }else{
                    $ids = $id;
                    $where .= " and tid in($ids)";
                }   
            }

            // 分页开始
                $num =11;
                // 统计有多少条数据
                $sql2 = "select count(*) from ".FIX."goods $where ";
                $res2 = mysqli_query($link,$sql2);
                $total = mysqli_fetch_row($res2)['0'];
                // 统计有多少页
                $totalpage = ceil($total / $num);
                $p = isset($_GET['p'])? $_GET['p']:1;
                if($p<1){
                    $p = 1;
                }elseif($p>$totalpage){
                    $p = $totalpage;
                }
                // 设置偏移量
                $offset = ($p-1)*$num;
                $limit = "limit $offset,$num";

        // 遍历产品
            $sql = "select * from ".FIX."goods $where $limit";
            $res = mysqli_query($link,$sql);
            if($res && mysqli_num_rows($res)>0){
                while($row=mysqli_fetch_assoc($res)){
        ?>
                <li class="gl-item">
                    <dl class="gl-item-wrap">
                        <dd class="mod-pic">
                            <a data-mtype="store_list_kw_1" target="_blank" href="./details.php?id=<?=$row['id']?>">
                                <img width="220" height="220" src="<?=__PUBLIC__.$row['pic']?>">
                            </a>
                        </dd>
                        <dd class="mod-name">
                            <a data-mtype="store_list_kw_1" target="_blank" href="./details.php?id=<?=$row['id']?>">
                            <?=$row['name']?>
                            </a>
                        </dd>
                        <dd class="mod-price">
                                <span>￥</span>
                                <span class="vm-price"><?=$row['price']?></span>
                            </dd>
                        </dl>
                    </li>
                <?php 
                	}
                }else{
                	 echo '<h1>sorry，还没开卖呢~~~</h1>';
                	}?>
            </ul>
    </section>
    <section class="pages" id="pages">
        <div class="ui-paginate">
            <a class="p-item p-elem" data-mtype="store_list_fy_14">共<?=$total?>条</a>
            <a class="p-prev p-elem" href="./type.php?p=<?=($p-1).$search?>&type=<?=$type?>"></a>
            <a class="p-item p-elem" href="./type.php?p=1<?=$search?>&type=<?=$type?>" data-page="首页">首页</a>
            <span class="etc p-elem">…</span>
            <a class="p-item p-elem" href="./type.php?p=<?=$totalpage.$search?>&type=<?=$type?>" data-mtype="store_list_fy_14" data-page="末页">末页</a>
            <a class="p-next p-elem" href="./type.php?p=<?=($p+1).$search?>&type=<?=$type?>" data-mtype="store_list_fy_next"></a>
            <a class="p-item p-elem" data-mtype="store_list_fy_14">第<?=$p?>/<?=$totalpage?>页</a>
        </div>
    </section>
    </div>
</main>

 <?php
    include_once './Public/home_footer.php';

 ?>
    
</body></html>