<?php
 error_reporting(E_ALL &~E_NOTICE &~E_DEPRECATED);
 session_start();
 if(!isset($_SESSION['user'])||empty($_SESSION['user'])){
     header('Location:login.php');
     exit;
 }

 $req_time =  $_SERVER['REQUEST_TIME'];
 if(!empty($_POST['name'])){
    include_once './lib/fun.php';
    // post
    // upload img
    $file = $_FILES['file'];
    $imgUrl = imgUpload($file);
    var_dump($imgUrl);

    // connect mysql
    $link = mysqlInit('127.0.0.1','root','','store');
    if(!$link) {
        echo mysql_error();
    }

    $user = $_SESSION['user'];
    $sql = <<<EOF
    insert goods values (null,'{$_POST['name']}',{$_POST['price']},
    '{$imgUrl}','{$_POST['des']}','{$_POST['detail']}',
    '{$user['username']}',{$req_time},{$req_time},0);
EOF;
    var_dump($sql);
    $obj = mysql_query($sql);
    if($obj){
        // 添加成功
        header('Location:login.php');
    }else{
        echo mysql_error();
    }
 }else{
    
 }
//  exit;
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Basic Form</title>

    <link href="./static/css/bootstrap.min.css" rel="stylesheet">
    <link href="./static/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./static/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="./static/css/animate.css" rel="stylesheet">
    <link href="./static/css/style.css" rel="stylesheet">

    <link href="./static/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">


    <!-- file upload -->
    <link href="./static/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

</head>

<body class=" pace-done">
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span>
                                <img alt="image" class="img-circle" src="img/profile_small.jpg">
                            </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs">
                                        <strong class="font-bold">David Williams</strong>
                                    </span>
                                    <span class="text-muted text-xs block">Art Director
                                        <b class="caret"></b>
                                    </span>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li>
                                    <a href="profile.html">Profile</a>
                                </li>
                                <li>
                                    <a href="contacts.html">Contacts</a>
                                </li>
                                <li>
                                    <a href="mailbox.html">Mailbox</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="logout.php">Logout</a>
                                </li>
                            </ul>
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

        <div id="page-wrapper" class="gray-bg" style="min-height: 1233px;">
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
                            <a href="logout.php">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Basic Form</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a>Forms</a>
                        </li>
                        <li class="active">
                            <strong>Basic Form</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content">
                                <form method="POST" id="add_good_form" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品名称</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" id="name" name="name" placeholder="请输入商品名称" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品价格</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="tel" id="price" name="price" placeholder="请输入商品价格" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品简介</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <textarea type="text" id="des" name="des" rows="3" style="resize:none" class="form-control" placeholder="请输入商品简介，长度在200以内"></textarea>
                                                </div>
                                            </div>
                                            <!-- <span class="help-block m-b-none">A block of help text that breaks onto a new line and may extend beyond one line.</span> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品图片</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span class="btn btn-default btn-file">
                                                            <span class="fileinput-new">Select file</span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input type="file" id="file" name="file"/>
                                                        </span>
                                                        <span class="fileinput-filename"></span>
                                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品详情</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <textarea type="text" id="detail" name="detail" rows="4" style="resize:none" class="form-control" placeholder="请输入商品详情"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-danger" type="button" id="reset_btn">清空</button>
                                            <button class="btn btn-primary" type="submit">确认添加</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="pull-right">
                    10GB of
                    <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> Example Company © 2014-2017
                </div>
            </div>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="./static/js/jquery-3.1.1.min.js"></script>
    <script src="./static/js/bootstrap.min.js"></script>
    <script src="./static/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="./static/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="./static/js/inspinia.js"></script>
    <script src="./static/js/plugins/pace/pace.min.js"></script>

    <!-- iCheck -->
    <script src="./static/js/plugins/iCheck/icheck.min.js"></script>

    <!-- Jasny -->
    <script src="./static/js/plugins/jasny/jasny-bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $add_good_form = $('#add_good_form')
            $name = $('#name')
            $price = $('#price')
            $file = $('#file')
            $des = $('#des')
            $detail = $('#detail')


            $name.val('华为手机')
            $price.val('2000')
            //$file.val('https://paimgcdn.baidu.com/196675918AADB2B8?src=https://ss2.bdstatic.com/8_V1bjqh_Q23odCf/dsp-image/165742663.jpg&rz=urar_2_968_600&v=0')
            $des.val('一部华为手机')
            $detail.val('华为朴P10')

            $add_good_form.submit(function (e) {
            
                if ($name.val() === '') {
                    alert('商品名不能为空')
                    return false
                }
                if ($price.val() === '') {
                    alert('商品价格不能为空')
                    return false
                }

                if ($file.val() === '') {
                    alert('商品图片不能为空')
                    return false
                }
                if ($des.val() === '') {
                    alert('商品描述不能为空')
                    return false
                }
                if ($detail.val() === '') {
                    alert('商品详情不能为空')
                    return false
                }
            })

            // reset btn
            $('#reset_btn').click(function () {
                $name.val('')
                $price.val('')
                $('.fileinput.fileinput-exists .close').click()
                $des.val('')
                $detail.val('')
            })
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>




</body>

</html>