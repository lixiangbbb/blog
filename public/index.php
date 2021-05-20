<?php
	define('DS',DIRECTORY_SEPARATOR);

	//应用目录
	define('APP_PATH',dirname(__DIR__).DS);

	//开启调试模式
	define('APP_DEBUG',true);

	//加载框架文件
	require(APP_PATH.'fastphp/Fastphp.php');


	//加载配置文件
	$config = require(APP_PATH.'config/config.php');

	//实例化框架类
	(new Fastphp($config))->run();     
