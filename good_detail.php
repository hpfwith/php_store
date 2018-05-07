<?php
 error_reporting(E_ALL &~E_NOTICE &~E_DEPRECATED);
session_start();
if(!isset($_SESSION['user'])||empty($_SESSION['user'])){
    // header('Location:logout.php');
    $isLogined = false;
}else{
    $isLogined = true;
}
if(!isset($_GET['id'])||$_GET['id']==0){
    header('Location:index.php');
}else{
    include_once './lib/fun.php';
    $link = mysqlInit('localhost','root','','store');
    if(!$link){
        echo mysql_error();exit;  
    }
    $sql = "select * from goods where id='{$_GET['id']}' limit 1";
    $rows = mysql_query($sql);
    if(!$rows){
        echo mysql_error();exit;
    }
    $good_info = mysql_fetch_array($rows);
    if(!$good_info){
        echo '商品不存在';
    }else{
        echo "<img src='{$good_info['pic_url']}' alt=''>";
    }
}
?>