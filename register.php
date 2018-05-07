<?php
error_reporting(E_ALL &~E_NOTICE &~E_DEPRECATED);
session_start();


if(!empty($_POST['username'])){
    // 表单提交 
    include_once './lib/fun.php';

    // username password confirm_password
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    // validate
    if(!$username) {
        header('Location:register.php?error=1');
        exit;
    }
    if(strlen($username)>10){
        header('Location:register.php?error=2');
        exit;
    }
    if(!$password) {
        header('Location:register.php?error=3');
        exit;
    }
    if($password!==$confirm_password){
        header('Location:register.php?error=4');
        exit;
    }
 
    // connect mysql
    $link = mysqlInit('127.0.0.1','root','','store');
    if(!$link) {
        echo mysql_error();exit;
    }
    // 判断用户是否存在
    $sql = "select count(id) as total from user where username='{$username}'";
    $obj = mysql_query($sql);
    $result=mysql_fetch_array($obj);
    if(isset($result['total'])&&$result['total']>0){
        header('Location:register.php?error=5');
        exit;
    }
    // 存库
    $password = encryptPwd($password);
    $create_time = $_SERVER['REQUEST_TIME'];
    $sql = "insert user(username,password,create_time) values ('{$username}','{$password}','{$create_time}')";
    $obj = mysql_query($sql);
    if($obj){
        // 注册成功跳到登录页
        header('Location:login.php');
        exit;
        /* // 插入成功主键id
        $userId = mysql_insert_id();
        echo sprintf('注册成功，用户名：%s，用户id：%s',$username,$userId); */
    }else{
        echo mysql_error();exit;
    }
}else{
    // GET
    if(isset($_GET['error'])){
        switch ($_GET['error']) {
            case '1':
                $selector = 'username';
                $errorMsg = '用户名不能为空';
                break;
            case '2':
                $selector = 'username';
                $errorMsg = '用户名长度不超过10';
                break;
            case '3':
                $selector = 'password';
                $errorMsg = '密码不能为空';
                break;
            case '4':
                $selector = 'confirm_password';
                $errorMsg = '两次密码输入不一致';
                break;
            case '5':
                $selector = 'username';
                $errorMsg = '用户名已存在';
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
    <title>INSPINIA | Register</title>
    <link href="./static/css/bootstrap.min.css" rel="stylesheet">
    <link href="./static/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./static/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="./static/css/animate.css" rel="stylesheet">
    <link href="./static/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">IN+</h1>
            </div>
            <h3>Register to IN+</h3>
            <p>Create account to see it in action.</p>
            <form class="m-t" role="form" id="register_form" method="POST" action="register.php">
                <div class="form-group">
                    <input id='username' name="username" type="text" class="form-control" placeholder="Username" data-toggle="tooltip" data-placement="right">
                </div>
                <div class="form-group">
                    <input id='password' name="password" type="password" class="form-control" placeholder="Password" data-toggle="tooltip" data-placement="right">
                </div>
                <div class="form-group">
                    <input id='confirm_password' name="confirm_password" type="password" class="form-control" placeholder="Confirm Password"
                        data-toggle="tooltip" data-placement="right">
                </div>
                <!-- <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Agree the terms and policy </label></div>
                </div> -->
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center">
                    <small>Already have an account?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="./login.php">Login</a>
            </form>
            <p class="m-t">
                <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small>
            </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="./static/js/jquery-3.1.1.min.js"></script>
    <script src="./static/js/bootstrap.min.js"></script>

    <!-- iCheck -->
    <!-- <script src="./static/js/plugins/iCheck/icheck.min.js"></script>
    <script>
        // iCheck => checkbox美化插件
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script> -->
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
            let $register_form = $('#register_form')
            let $username = $('#username')
            let $password = $('#password')
            let $confirm_password = $('#confirm_password')

            $register_form.submit(function (e) {
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

                let confirm_password = $confirm_password.val()
                if (password !== confirm_password) {
                    $confirm_password.attr('title', '两次输入密码不一致').tooltip('show')
                    return false
                }
            })

            // show errorMsg
            let selector = '<?php echo $selector?'#'.$selector:null ?>'
            console.log(selector)
            let errorMsg = '<?php echo $errorMsg?>'
            $(selector).attr('title',errorMsg).tooltip('show')
        })
        
    </script>
</body>
</html>