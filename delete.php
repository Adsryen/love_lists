<?php

	//新闻管理：删除指定新闻
	header('Content-type:text/html;charset=utf-8');

	//接收要删除的新闻ID
	$id = isset($_GET['id']) ? (integer)$_GET['id'] : 0;	//0不会存在
	if($id == 0) {
		header('Refresh:3;url=index.php');
		echo '当前要删除的行项目不存在！';
		exit;
	}

	//删除数据
	include_once 'public.php';

	//组织SQL并执行
	my_error('delete from ll_love_lists where id = ' . $id);


	//提示
	header('Refresh:1;url=index.php');
	echo '当前行项目删除成功！';