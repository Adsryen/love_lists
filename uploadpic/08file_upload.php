<?php

//数据入库
include_once 'public.php';
try {
    $file = $_FILES['filename'];
    if (!$file['error'] == 0) {
        throw new Exception('上传文件出错');
    }
//文件来源安全性（文件上传白名单）
    if (!$file['tmp_name']) {
        throw new Exception('您的图片来源不安全');
    }
//文件目录
    $dir = 'uploads/' . date('ym/');
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    //文件上传大小
    if ($file['size'] > 80000000) {
        throw new Exception('文件不得超过80000000M');
    }
//文件名
    $name = $file['name'];
    $ext = substr($name, strrpos($name, '.'));
    if (!preg_match('/(.jpg)|(.png)|(.gif)$/', $ext)) {
        throw new Exception('图片格式错误');
    }
    $newname = md5(time() . rand(0, 999999999) . rand(111, 9999)) . $ext;
    $filenamea = $file['tmp_name'];
    move_uploaded_file($filenamea, $dir . $newname);
//    数据库连接
    $link = new mysqli('localhost', 'root', '1594959462prl');
    if ($link->connect_errno) {
        unlink($dir . $newname);
        throw new Exception('数据库连接失败');
    }

	$add_time = time();
    $sql = "insert into ll_love_fm values('".$name."','".$dir.$newname."',$add_time)";

    $insert_id = my_error($sql);

	//成功操作
	//提示同时去到列表页
	echo $newname . ' 上传成功！';	
} catch (Exception $ex) {
    echo $ex->getMessage();
}