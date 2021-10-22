<?php

	//更新数据到数据库
	header('Content-type:text/html;charset=utf-8');
	//接收用户数据
	//var_dump($_POST);

	//接收数据并验证
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0; 
	$list_name = isset($_POST['list_name']) ? trim($_POST['list_name']) : '';	//title是字符串（重要）
	$list_status = $_POST['list_status'];	//数字需求，而且不重要
	$content = isset($_POST['content']) ? trim($_POST['content']) : '';

    $list_status_class=$list_status==1 ? 'event done':'event doing';
	$done_time=$list_status==1 ? time():0;
	$event_state=$list_status==1 ? '已经完成了':'正在进行中......';
/*
	echo $list_status_class . '<br/>';
	echo $done_time. '<br/>';
	echo $event_state. '<br/>';
	*/
	//数据验证：标题和内容均不能为空
	if(empty($list_name)){
		//提示同时回到提交页 3秒后刷新到add.html
		header('Refresh:3;url=index.php');	//header前不能有输出，header：refresh不会阻止脚本执行

		//标题和内容至少有一个为空//阻止脚本继续执行
		exit('标题不能为空！');	
	}

	//组织SQL更新到数据库
	include_once 'public.php';

	$add_time = time();
	$sql = "update ll_love_lists set list_name = '{$list_name}',list_status = {$list_status},content='".$content."',list_status_class = '{$list_status_class}',done_time = '{$done_time}',event_state = '{$event_state}' where id = {$id}";
	my_error($sql);

//提示成功
	header('Refresh:1;url=index.php');
	
	echo $list_name .' 更新成功！';

