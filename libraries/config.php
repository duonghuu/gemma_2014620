<?php if(!defined('_lib')) die("Error");
$cautruyvan = strtolower($_SERVER['QUERY_STRING']);
$tukhoa = array('union','chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(',
	'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20',
	'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=',
	'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(',
	'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm',
	'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(',
	'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(',
	'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall',
	'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20',
	'insert%20into', 'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20',
	'$_request', '$_get', '$request', '$get', '.system', '&aim', '%20getenv', 'getenv%20',
	'new_password', '&icq','/etc/password','/etc/shadow', '/etc/groups', '/etc/gshadow',
	'/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id','/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python',
	'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/X11R6/bin/xterm', 'lsof%20',
	'/bin/mail', '.conf', 'motd%20', '_config.php', 'cgi-', '.eml',
	'file\://', 'window.open', '<script>', 'javascript\://','img src', 'img%20src','.jsp','ftp.exe',
	'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd',
	'servlet', '/etc/passwd', '[Only registered and activated users can see links]','alert', '~root', '~ftp', '.js', '.jsp', '.history',
	'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20',
	'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con',
	'<script', '/robot.txt' ,'/perl' ,'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from',
	'select from', 'drop%20', '.system', 'getenv', '_php', 'php_', 'phpinfo()', '<?php', '?>', 'sql=');
$kiemtra = str_replace($tukhoa, '*', $cautruyvan);
if ($cautruyvan != $kiemtra){
	header("HTTP/1.0 404 Not Found");
	die( "404 Not found" );
}
$link_id = true;

$config['database']['servername'] = 'localhost';
$config_tam = '/2007/gemma_2014620';
$config['database']['database'] = 'gemma201';
$config['database']['username'] = 'root';
$config['database']['password'] = '';
$config['database']['debug'] = 0;
define ( 'NN_MSHD' , '2014620');
define ( 'NN_AUTHOR' , 'huuduongnina@gmail.com'); 
$config['author']['name'] = 'Lê Hữu Dương';
$config['author']['email'] = 'huuduongnina@gmail.com';
if (version_compare(phpversion(), '7.0.0', '<')) {
    $config['database']['dbtype'] = 'mysql';
}else{
	$config['database']['dbtype'] = 'mysqli';
}
error_reporting(0);
$config_url = $_SERVER["SERVER_NAME"].$config_tam;
$config_url_ssl = 'http://'.$config_url;
$config['database']['refix'] = 'table_';
if($config_tam==''){$meta_robots = 'noodp, INDEX, FOLLOW';$sendType = true;}
else{$meta_robots = 'NOINDEX, NOFOLLOW';$sendType = false;}
$ip_host = '127.0.0.1';
$mail_host = 'contact@demo.com';
$pass_mail = '1234qwer!@#$';
$config_email="mailtransnina@gmail.com";
$config_pass="etvdzuqvkdwporgv";
$login_name = $config_url;
@define ( 'MAIL_USER' , "mailtransnina@gmail.com" );
@define ( 'MAIL_PWD' , "etvdzuqvkdwporgv" );
$config['lang']=array(''=>'Tiếng Việt');

date_default_timezone_set('Asia/Ho_Chi_Minh');
$config['reponsive'] = true;
$config['company'] = array("tt_giomo"=>"Giờ mở","tt_zalo"=>"Zalo","tt_messenger"=>"Messenger");
$config['salt_sta'] = '@nina';
$config['salt_end'] = '@#LIQIDCT1^';

	// +sitekey 6LfrTJkUAAAAAJvr-qt-eCnpESTHTgq275qGaMyB
	// +secretkey 6LfrTJkUAAAAAKT9qwHJMryQsVSfSw5XI_upBjZS
$config['recaptcha_sitekey'] = '6LfrTJkUAAAAAJvr-qt-eCnpESTHTgq275qGaMyB';
$config['recaptcha_secretkey'] = '6LfrTJkUAAAAAKT9qwHJMryQsVSfSw5XI_upBjZS';
$lang_default = array("","en","cn");
if(!isset($_SESSION['lang']) or !in_array($_SESSION['lang'], $lang_default))
{
    $_SESSION['lang'] = '';
}
$lang = $_SESSION['lang'];