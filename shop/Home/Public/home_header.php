<div class="layout-topbar clearfix" id="topbar">
    <div class="mzcontainer">
        <ul class="layout-topbar-left clearfix">
            <li class="layout-topbar-left-links">
                <a class="layout-topbar-link" href="./home.php" data-mdesc="页头中第1个" data-mtype="store_index_yt_1">魅族官网</a>
            </li>
            <li class="layout-topbar-left-links">
                <a class="layout-topbar-link" data-mdesc="页头中第2个" data-mtype="store_index_yt_2">魅族商城</a>
            </li>
            <li class="layout-topbar-left-links">
                <a class="layout-topbar-link" data-mdesc="页头中第3个" data-mtype="store_index_yt_3">Flyme</a>
            </li>
            <li class="layout-topbar-left-links">
                <a class="layout-topbar-link" data-mdesc="页头中第4个" data-mtype="store_index_yt_4">专卖店</a>
            </li>
            <li class="layout-topbar-left-links">
                <a class="layout-topbar-link" data-mdesc="页头中第5个" data-mtype="store_index_yt_5">服务</a>
            </li>
            <li class="layout-topbar-left-links">
                <a class="layout-topbar-link" data-mdesc="页头中第6个" data-mtype="store_index_yt_6">社区</a>
            </li>
        </ul>
        <form action="type.php" method="get">
            <ul class="layout-topbar-right clearfix">
                    <li class="layout-topbar-right-links" style="height:28px;margin-top:5px;">
                        <input style="height:28px;margin-top:0px;" name="name">
                    </li>
                    <li class="layout-topbar-right-links" style="height:30px;margin-top:5px;">
                        <input type="submit" value="搜索" style="height:30px;margin-top:0px;">
                    </li>
                <li class="layout-topbar-right-links">
                    <a class="layout-topbar-link" data-mdesc="页头-收藏" href="./shopcar.php" data-mtype="store_index_yt_collect">购物车
                        <i class="layout-icon layout-icon-new"></i>
                    </a>
                </li>
                <li class="layout-topbar-right-links">
                    <a id="topbarOrderMsg"  href='./personal.php' class="layout-topbar-link" data-mdesc="页头-我的订单" data-mtype="store_index_yt_order">个人中心
                    </a>
                </li>
                <?php
                    if(empty($_SESSION['home_info'])){?>
                        <li class="layout-topbar-right-links signout">
                            <a class="layout-topbar-link" href="./login.php">登录</a>
                        </li>
                        <li class="layout-topbar-right-links signout">
                            <a class="layout-topbar-link" target="_blank" href="./register.php">注册</a>
                        </li>
                    <?php
                        }else{
                            echo "<li class='layout-topbar-right-links signout'>
                                    <a class='layout-topbar-link'>欢迎您，{$_SESSION['home_info']['username']}</a>
                                </li>
                                <li class='layout-topbar-right-links signout'>
                                    <a class='layout-topbar-link' href='./action.php?a=logout'>注销</a>
                                </li>";
                    }

                ?>
            </ul>
        </form>
    </div>
</div>
<div class="layout-header clearfix">
    <div class="mzcontainer">
        <div class="layout-header-logo">
            <a href="./home.php" class="layout-header-logo-link" alt="魅族科技"><i class="layout-font layout-font-logo"></i></a>
        </div>
        <ul class="layout-header-nav clearfix" id="layoutHeaderNav">
        <?php
            include_once '../Public/config.php';
            $link = mysqli_connect(HOST,USER,PWD,DB)or die('连接数据库失败');
            mysqli_set_charset($link,'utf8');
             // 遍历一级分类
            $sql = "select * from ".FIX."type where pid=0 limit 9";
            $res = mysqli_query($link,$sql);
            if($res && mysqli_num_rows($res)>0){
                while($row=mysqli_fetch_assoc($res)){
        ?>
                <li class="layout-header-nav-item">
                    <a href="./type.php?id=<?=$row['id']?>&type=<?=$row['name']?>" class="layout-header-nav-link"><?=$row['name']?></a>
                    <div class="layout-header-nav-child">
                        <div class="mzcontainer">
                            <ul class="layout-header-nav-child-list">
                                <?php
                                    $sql1 = "select * from ".FIX."type where pid={$row['id']}";
                                    $res1 = mysqli_query($link,$sql1);
                                    if($res1 && mysqli_num_rows($res1)>0){
                                        while($row1=mysqli_fetch_assoc($res1)){?>
                                        <li class="layout-header-nav-child-item">
                                            <a class="layout-header-nav-child-link" data-mtype="store_index_dh_1_1" data-mdesc="导航中第1个下第1个坑" href="./type.php?id=<?=$row1['id']?>&type=<?=$row1['name']?>">
                                                <p><img src="<?=__PUBLIC__?>/type/<?=$row1['pic']?>" class="layout-header-nav-child-img"></p>
                                                <p class="layout-header-nav-child-name"><?=$row1['name']?></p>
                                                <p class="layout-header-nav-child-bottom">
                                                </p>
                                            </a>
                                        </li>
                                     <?php
        							}}?>
                                <!-- more -->
                            </ul>
                        </div>
                    </div>
                </li>
	        <?php
	            }}
	        ?>
                
        </ul>
        <div class="layout-header-nav-downmenu" id="layoutHeaderNavDownmenu"></div>
    </div>
</div>