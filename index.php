<?php
 error_reporting(E_ALL &~E_NOTICE &~E_DEPRECATED);
session_start();
$default_avatar = 'https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3610704133,3947436040&fm=27&gp=0.jpg';
if(!isset($_SESSION['user'])||empty($_SESSION['user'])){
    // header('Location:logout.php');
    $isLogined = false;
    $avatar = $default_avatar;
}else{
    $isLogined = true;
    $avatar = isset($_SESSION['user']['avatar'])?$_SESSION['user']['avatar']:$default_avatar;
}
include_once './lib/fun.php';
$link = mysqlInit('localhost','root','','store');
if(!$link){
    echo mysql_error();exit;  
}
$sql = 'select * from goods order by update_time desc';
$rows = mysql_query($sql);
if(!$rows){
    echo mysql_error();exit;
}
 ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | E-commerce</title>

    <link href="./static/css/bootstrap.min.css" rel="stylesheet">
    <link href="./static/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="./static/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <link href="./static/css/animate.css" rel="stylesheet">
    <link href="./static/css/style.css" rel="stylesheet">



</head>

<body class="pace-done">
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>

    <div id="wrapper">
        <!-- 侧边导航栏 -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span>
                                <img alt="image" class="img-circle" style="height:48px;width:48px;"
                                src="<?php echo $avatar; ?>">
                            </span>
                            <a <?php if(!$isLogined) echo 'href="login.php"';?>>
                                <span class="block m-t-xs">
                                    <strong class="font-bold"><?php echo $isLogined?'欢迎你，'.$_SESSION['user']['username']:'未登录，前往登录'?></strong>
                                </span>
                            </a>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>
                    <li>
                        <a href="index.php">
                            <i class="fa fa-diamond"></i>
                            <span class="nav-label">瞧一瞧看一看</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#">
                            <i class="fa fa-th-large"></i>
                            <span class="nav-label">商品发布</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse" style="height: 0px;">
                            <li>
                                <a href="pub_good.php">我要发布</a>
                            </li>
                            <li>
                                <a href="pub_good.php">修改发布</a>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="#">
                            <i class="fa fa-bar-chart-o"></i>
                            <span class="nav-label">个人中心</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse" style="height: 0px;">
                            <li>
                                <a href="profile.php">我的信息</a>
                            </li>
                            <li>
                                <a href="profile_modify.php">修改信息</a>
                            </li>
                            <li>
                                <a href="profile_favorite.php">我的收藏</a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg" style="min-height: 1263px;">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                            <i class="fa fa-bars"></i>
                        </a>
                        <form role="search" class="navbar-form-custom" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
                        </li>
                        <li>
                             <!-- show if not login  -->
                            <a href="<?php echo $isLogined?'logout.php':'login.php'; ?>">
                                <i class="fa fa-sign-out"></i><?php echo $isLogined?' Log out':' Log in'; ?>
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>E-commerce grid</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a>E-commerce</a>
                        </li>
                        <li class="active">
                            <strong>Products grid</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <?php while ($row = mysql_fetch_array($rows)): ?>
                    <?php $good_url = 'good_detail.php?id='.$row['id'];?>   
                    <div class="col-md-4 col-lg-3">
                        <a href="<?php echo $good_url; ?>">
                            <div class="ibox">
                                <div class="ibox-content product-box active">
                                    <div class="product-imitation" 
                                        style="height:200px;line-height:200px;overflow:hidden;padding:0">
                                        <img style="width:100%" src="<?php echo($row['pic_url']); ?>" alt="">
                                    </div>
                                    <div class="product-desc">
                                        <span class="product-price">
                                            <?php echo '￥'.$row['price']?>
                                        </span>
                                        <small class="text-muted">Category</small>
                                        <a href="<?php echo $good_url; ?>" class="product-name"> Product</a>
                                        <div class="small m-t-xs">
                                            Many desktop publishing packages and web page editors now.
                                        </div>
                                        <div class="m-t text-righ">

                                            <a href="<?php echo $good_url; ?>" class="btn btn-xs btn-outline btn-primary">Info
                                                <i class="fa fa-long-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>   
                    <?php endwhile; ?>  
                </div>
            </div>
            <div class="footer">
                <div class="pull-right">
                    10GB of
                    <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> 咸鱼网 © 2014-2017
                </div>
            </div>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="./static/js/jquery-3.1.1.min.js"></script>
    <script src="./static/js/bootstrap.min.js"></script>
    <!-- 动态菜单栏插件 -->
    <script src="./static/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <!-- 横向滚动插件 -->
    <script src="./static/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="./static/js/inspinia.js"></script>
    <!-- 进度条插件 -->
    <script src="./static/js/plugins/pace/pace.min.js"></script>

</body>

</html> 

