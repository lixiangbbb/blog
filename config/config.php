<?php
	$config['db']['host']     = 'host.docker.internal';
	$config['db']['username'] = 'root';
	$config['db']['password'] = '';
	$config['db']['dbname']   = 'stock';

	// 默认控制器和操作名
	$config['defaultController'] = 'Item';
	$config['defaultAction'] = 'index';
	return $config;