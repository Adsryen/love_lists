<?php

	//查询某个新闻信息放到对应的表单中（编辑第一步）

	header('Content-type:text/html;charset=utf-8');

	//接收要编辑的新闻ID
	$id = isset($_GET['id']) ? (integer)$_GET['id'] : 0;	//0不会存在
	if($id == 0) {
		header('Refresh:3;url=news.php');
		echo '当前要编辑的新闻不存在！';
		exit;
	}

	//获取当前ID对应的新闻信息
	include_once 'news_public.php';
	$sql = "select * from n_news where id = {$id}"; 
	$res = my_error($sql);
	$new = mysql_fetch_assoc($res);	//$new一定是一个数组吗？此时明确是个数组，但是实际上不一定，自己优化

	//加载模板
	include_once 'news_edit.html';