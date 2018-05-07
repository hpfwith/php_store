<?php
error_reporting(E_ALL &~E_NOTICE &~E_DEPRECATED);
session_start();
if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){
    header('Location:index.php');
    exit;
}

if(!empty($_POST['username'])){
    // 表单提交 
    include_once './lib/fun.php';

    // username password 
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
   
    // validate
    if(!$username) {
        header('Location:login.php?error=1');
        exit;
    }
    if(!$password) {
        header('Location:login.php?error=2');
        exit;
    }
 
    // connect mysql
    $link = mysqlInit('127.0.0.1','root','','store');
    if(!$link) {
        echo mysql_error();exit;
    }
    // 判断用户是否存在
    $sql = "select * from user where username='{$username}' limit 1";
    $obj = mysql_query($sql);
    $result=mysql_fetch_array($obj,MYSQL_ASSOC);
    // var_dump($result);
    $msg = '';

    if($result){
        if($result['password']===encryptPwd($password)){
            $_SESSION['user'] = $result;
            header('Location:index.php');
            exit;
        }else{
            header('Location:login.php?error=3');
            exit;
        }
    }else{
        header('Location:login.php?error=4');
        exit;
    }
}else{
    // GET请求
    if(isset($_GET['error'])){
        switch ($_GET['error']) {
            case '1':
                $selector = 'username';
                $errorMsg = '用户名不能为空';
                break;
            case '2':
                $selector = 'password';
                $errorMsg = '密码不能为空';
                break;
            case '3':
                $selector = 'password';
                $errorMsg = '密码不正确';
                break;
            case '4':
                $selector = 'username';
                $errorMsg = '用户名不存在';
                break;
            default:
                $selector = null;
                $errorMsg = null;
                break;
        }
    }else{
        $selector = null;
        $errorMsg = null;
    }
}

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>

    <link href="./static/css/bootstrap.min.css" rel="stylesheet">
    <link href="./static/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="./static/css/animate.css" rel="stylesheet">
    <link href="./static/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">IN+</h1>

            </div>
            <h3>Welcome to IN+</h3>
            <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p>Login in. To see it in action.</p>
            <form class="m-t" role="form" method="POST" action="login.php" id="login_form">
            <div class="form-group">
            <input id='username' name="username" type="text" class="form-control" placeholder="Username" data-toggle="tooltip" data-placement="right">
        </div>
        <div class="form-group">
            <input id='password' name="password" type="password" class="form-control" placeholder="Password" data-toggle="tooltip" data-placement="right">
        </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="./register.php">Create an account</a>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="./static/js/jquery-3.1.1.min.js"></script>
    <script src="./static/js/bootstrap.min.js"></script>
    <script>
      $(document).ready(function () {
            // init tooltip
            let template =
                `<div class="tooltip" role="tooltip">
                    <div class="tooltip-arrow"></div>
                    <div class="tooltip-inner" style="white-space:nowrap;"></div>
                </div>`
            $('[data-toggle="tooltip"]').tooltip({
                //使用template防止tooptip文字不换行
                template,
                trigger: 'manual',
                title: function () {
                    // this为触发tooltip元素
                    return $(this).attr('title')
                }
            }).on('focus', function () {
                $(this).attr('title', '').tooltip('hide')
            })

            // register action
            let $login_form = $('#login_form')
            let $username = $('#username')
            let $password = $('#password')
            $login_form.submit(function (e) {
                let username = $username.val()
                if (username === '') {
                    $username.attr('title', '用户名不能为空').tooltip('show')
                    return false
                }
                if (username.length >= 10) {
                    $username.attr('title', '用户名长度不超过10').tooltip('show')
                    return false
                }
                let password = $password.val()
                if (password === '') {
                    $password.attr('title', '密码不能为空').tooltip('show')
                    return false
                }
            })

            // show errorMsg
            let selector = '<?php echo $selector?'#'.$selector:null ?>'
            let errorMsg = '<?php echo $errorMsg?>'
            $(selector).attr('title',errorMsg).tooltip('show')
        })
    </script>

</body>

</html>
