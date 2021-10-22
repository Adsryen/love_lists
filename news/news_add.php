<?php

	//接收用户数据，实现新闻插入数据库功能
	header('Content-type:text/html;charset=utf-8');

	//接收用户数据
	//var_dump($_POST);

	$title = isset($_POST['title']) ? trim($_POST['title']) : '';	//title是字符串（重要）
	$isTop = isset($_POST['isTop']) ? (integer)$_POST['isTop'] : 2 ;	//(置顶)数字需求，而且不重要
	$content = isset($_POST['content']) ? trim($_POST['content']) : '';
	$publisher = isset($_POST['publisher']) ? trim($_POST['publisher']) : '佚名';	//trim通常针对字符串

	//数据验证：标题和内容均不能为空
	if(empty($title) || empty($content)){
		//提示同时回到提交页 3秒后刷新到news_add.html
		header('Refresh:3;url=news_add.html');	//header前不能有输出，header：refresh不会阻止脚本执行

		//标题和内容至少有一个为空//阻止脚本继续执行
		exit('标题和内容都不能为空！');	
	}

	//数据入库
	include_once 'news_public.php';

	//阻止SQL指令执行
	$time = time();
	$sql = "insert into n_news values(null,'{$title}',{$isTop},'{$content}','{$publisher}',$time)";

	$insert_id = my_error($sql);

	//成功操作
	//提示同时去到列表页
	header('Refresh:3;url=news.php');
	echo $title . ' 增加成功！';	