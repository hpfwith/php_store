<?php
// 连接数据库
function mysqlInit($host,$username,$password,$dbName){
    $link = mysql_connect($host,$username,$password);
    if(!$link) return false;
    mysql_select_db($dbName);
    mysql_set_charset('utf8');
    return $link;
}
// md5加密密码
function encryptPwd($pwd){
    if(!$pwd) return false;
    return md5(md5($pwd).'glw');
}
// 上传图片
function imgUpload($file){

    if(!is_uploaded_file($file['tmp_name'])){
        echo '请上传符合规范的图片';exit;
    }
    $type = $file['type'];
    if(!in_array($type,array('image/png','image/gif','image/jpeg'))){
        echo '请上传png,jpg,gif图像';exit;
    }

    // 上传目录
    $uploadPath = './static/file/';
    // 访问目录
    $uploadUrl = '/static/file/';
    $fileDir = date('Y/MD/', $_SERVER['REQUEST_TIME']);
    if(!is_dir($uploadPath.$fileDir)){
        //递归创建目录
        mkdir($uploadPath.$fileDir,0755,true);
    }
    // 格式
    $ext = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
    // 上传图像名称
    $img = uniqid().mt_rand(1000,9999).'.'.$ext;

    // 上传地址
    $imgPath = $uploadPath.$fileDir.$img;
    // 访问地址
    $imgUrl = 'http://localhost/store'.$uploadUrl.$fileDir.$img;

    if(!move_uploaded_file($file['tmp_name'],$imgPath)){
        // 操作失败，查看目录上传权限
        echo '拷贝失败';exit;
    }else{
        return $imgUrl;
    }
}