<?php
	session_start();
	@define ( '_template' , './templates/');
	@define ( '_source' , './sources/');
	@define ( '_lib' , './libraries/');

	include_once _lib."config.php";
	include_once _lib."constant.php";
	include_once _lib."functions.php";
	include_once _lib."functions_giohang.php";
	include_once _lib."library.php";
	include_once _lib."pclzip.php";
	if (version_compare(phpversion(), '7.0.0', '<')) include_once _lib."class.database.php";
	else include_once _lib."class.database7.3.php"; 
	$login_name_admin = md5($config['salt_sta'].$config['salt_end']);
	$d = new database($config['database']);
	$do = (isset($_REQUEST['do'])) ? addslashes($_REQUEST['do']) : "";
	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
	if($do=='admin'){
		if($act=='login'){
			$username = (string)$_POST['email'];
			$password = (string)$_POST['pass'];

			$sql = "select * from #_user where username='".$username."'";
			$d->query($sql);
			if($d->num_rows() == 1){
				$row = $d->fetch_array();

				if($row['password'] == encrypt_password($config['salt_sta'],$password,$config['salt_end'])){
					$_SESSION[$login_name_admin] = true;
					$_SESSION['login_admin']['role'] = $row['role'];
					$_SESSION['login_admin']['nhom'] = $row['nhom'];
					$_SESSION['login_admin']['com'] = $row['com'];
					$_SESSION['isLoggedIn'] = true;
					$_SESSION['login_admin']['username'] = $username;
					$_SESSION['login_admin']['name'] = $row['ten'];
					$_SESSION['ck'] = $config_url;
					echo '{"page":"index.php"}';
				}else echo '{"mess":"Mật khẩu không chính xác!"}';
			}else
			echo '{"mess":"Tên đăng nhập không tồn tại!"}';
		}
	}

?>
