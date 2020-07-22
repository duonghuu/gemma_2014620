<?php
	session_start();
	@define ( '_template' , '../templates/');
	@define ( '_source' , '../sources/');
	@define('_lib', '../libraries/');
	include_once _lib."config.php";
	include_once _lib."constant.php";
	include_once _lib."functions.php";
	include_once _lib."functions_for.php";
	include_once _lib."library.php";
	include_once _lib."pclzip.php";
	if (version_compare(phpversion(), '7.0.0', '<')) include_once _lib."class.database.php";
	else include_once _lib."class.database7.3.php"; 
	$d = new database($config['database']);

	$login_name_admin = md5($config['salt_sta'].$config['salt_end']);

  check_login_ajax();
?>
