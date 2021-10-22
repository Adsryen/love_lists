<?php

	//获取所有新闻内容并显示

	//操作数据库获取数据
	include_once 'public.php';

	//组织SQL获取所有新闻信息
	$sql = "select * from ll_love_lists";
	//执行
	$res = my_error($sql);				//拿到结果集

	//循环遍历所有结果 两种方案
	$news = array();					//保存取出的记录（数组）

	//方案1：获取结果集中记录数，然后for循环
	// echo '<pre>';
	/* 
	$num = mysql_num_fields($res);
	for($i = 0;$i < $num;$i++){
		$news[] = mysql_fetch_assoc($res);
		print_r($news);
	}
	print_r($news);
	 */

	//方案2：利用while循环，每次取到数据之后判断保存数据的结果，只要结果不为false，那么一直取
	while($row = mysql_fetch_assoc($res)){//循环的是$row，$row的值为mysql_fetch_assoc($res)
		$lists[] = $row;
	}
	// print_r($lists);

	//包含显示模板（HTML）
	include_once 'isindex.html';