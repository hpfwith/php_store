<?php
error_reporting(E_ALL &~E_NOTICE &~E_DEPRECATED);
session_start();
// var_dump($_SESSION['user']);
if(!isset($_SESSION['user'])||empty($_SESSION['user'])){
    header('Location:login.php');
    exit;
}else{
    include_once './lib/fun.php';
    $link = mysqlInit('localhost','root','','store');
    if(!$link){
        echo mysql_error();exit;  
    }
    $sql = "select * from user where username='{$_SESSION['user']['username']}' limit 1";
    $obj = mysql_query($sql);
    $user_info=mysql_fetch_array($obj,MYSQL_ASSOC);
    // var_dump($result);
    if(!$user_info){
        header('Location:logout.php');
    }else{
       var_dump($user_info);
    }
}
?>