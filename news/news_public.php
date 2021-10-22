<?php

	//PHP操作mysql的公共文件

	// 本文件要被其他文件包含。这行代码针对浏览器设置编码防止中文乱码，起复用作用
	header('Content-type:text/html;charset=utf-8');

	//做数据库初始化
	$servername = "localhost";
	$username = "root";
	$password = "1594959462prl";
	
	//连接 - 面向对象方式
	$mysqli = new mysqli($servername, $username, $password) or die('数据库连接失败');
	
	//设定字符集
	$mysqli -> set_charset('utf8');

	//选择数据库
	$mysqli -> select_db('love_lists');

	/**
	 * 封装MySQL语法错误检查函数并执行
	 * @param string $sql，要执行的SQL指令
	 * @return $res，正确执行完返回的结果，如果SQL错误，直接终止
	 */
	function my_error($sql){
		//执行SQL
		$res = mysql_query($sql);
		//处理可能存在的错误
		if(!$res){
			echo 'SQL执行错误，错误编号为：' . mysql_errno() . '<br/>';
			echo 'SQL执行错误，错误信息为：' . mysql_error() . '<br/>';
			//终止错误继续执行
			exit;
		}
		//返回结果
		return $res;
	}

	//php7兼容mysql代码
	const MYSQL_BOTH = MYSQLI_BOTH;
	const MYSQL_ASSOC = MYSQLI_ASSOC;
	const MYSQL_NUM = MYSQLI_NUM;

	function mysql_insert_id(){
		global $mysqli;
		return mysqli_insert_id($mysqli);
	}

	//执行sql
	function mysql_query($query){
		//写法一
		global $mysqli;
		return mysqli_query($mysqli,$query);
		//写法二
		//return mysqli_query($GLOBALS['mysqli'],$query);
		//写法三
		// global $mysqli;
		//return $mysqli -> query($query);
	}

	//解析结果集，获取关联或索引数组
	function mysql_fetch_array($result){
		//实现重载。mysqli本身默认MYSQLI_BOTH;
		return mysqli_fetch_array($result,func_num_args()>1?func_get_arg(1):MYSQLI_BOTH);
	}

	//解析结果集，获取关联数组
	function mysql_fetch_assoc($result){
		return mysqli_fetch_assoc($result);
	}

	//解析结果集，获取索引数组
	function mysql_fetch_row($result){
		return mysqli_fetch_row($result);
	}

	//获取结果集行数
	function mysql_num_rows($result){
		return mysqli_num_rows($result);
	}

	//获取结果集中所有字段数量
	function mysql_num_fields($result){
		return mysqli_num_fields($result);
	}

	//获取指定列字段名 fieldnr:fieldnumber
	function mysql_field_name($result,$fieldnr){
		//面向过程
		// return mysqli_fetch_field_direct($result,$fieldnr)->name;
		//面向对象
		return $result->fetch_field_direct($fieldnr)->name;
	}

	//返回最近函数调用的错误代码
	function mysql_errno(){
		global $mysqli;
		return mysqli_errno($mysqli);
	}

	//返回最近函数调用的错误描述
	function mysql_error(){
		global $mysqli;
		return mysqli_error($mysqli);
	}

	function mysql_escape_string($data){
		global $mysqli;
		return mysqli_real_escape_string($mysqli, $data);
	}

	function mysql_real_escape_string($data){
		return mysql_real_escape_string($data);
	}

	function mysql_close(){
		global $mysqli;
		return mysqli_close($mysqli);
	}
	
