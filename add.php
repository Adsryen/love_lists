<?php
	//临时设置为中国时区
	date_default_timezone_set('PRC');
	//接收用户数据，实现新闻插入数据库功能
	header('Content-type:text/html;charset=utf-8');

	//接收用户数据
	//var_dump($_POST);

	$list_name = isset($_POST['list_name']) ? trim($_POST['list_name']) : '';	//title是字符串（重要）
	$list_status = isset($_POST['list_status']) ? (integer)$_POST['list_status'] : 2 ;	//(置顶)数字需求，而且不重要
	$content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $list_status_class=$list_status==1 ? 'event done':'event doing';
	$done_time=$list_status==1 ? time():0;
	$event_state=$list_status==1 ? '已经完成了':'正在进行中......';
	//数据验证：标题不能为空
	if(empty($list_name)){
		//提示同时回到提交页 3秒后刷新到add.html
		header('Refresh:3;url=add.html');	//header前不能有输出，header：refresh不会阻止脚本执行

		//标题和内容至少有一个为空//阻止脚本继续执行
		exit('标题不能为空！');	
	}

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
	
	//阻止SQL指令执行
	$add_time = time();
	//（变量在数据库别名：
	//$name=pic_fengmian_name
	//$dir.$newname=pic_fengmian_path
	//末尾$add_time=pic_fengmian_add_time
	$sql = "insert into ll_love_lists values(null,'{$list_name}','".$content."','{$list_status}','{$list_status_class}','{$event_state}',$add_time,$done_time,'".$name."','".$dir.$newname."',$add_time)";
	$sql_backup = "insert into ll_love_lists_backup values(null,'{$list_name}','".$content."','{$list_status}','{$list_status_class}','{$event_state}',$add_time,$done_time,'".$name."','".$dir.$newname."',$add_time)";

	$insert_id = my_error($sql);
	$insert_id = my_error($sql_backup);
	//成功操作
	//提示同时去到列表页
	echo $newname . ' 上传成功！';	
} catch (Exception $ex) {
    echo $ex->getMessage();
}
	//成功操作
	//提示同时去到列表页
	header('Refresh:3;url=index.php');
	echo $list_name . ' 增加成功！';	

?>