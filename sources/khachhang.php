<?php	if(!defined('_source')) die("Error");
$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
$urlcu = "";
$urlcu .= (isset($_REQUEST['p'])) ? "&p=".addslashes($_REQUEST['p']) : "";
switch($act){
	case "man":
	get_items();
	$template = "khachhang/items";
	break;
	case "add":
	$template = "khachhang/item_add";
	break;
	case "edit":
	get_item();
	$template = "khachhang/item_add";
	break;
	case "save":
	save_item();
	break;
	case "delete":
	delete_item();
	break;
	default:
	$template = "index";
}
//////////////////
function get_items(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset,$paging,$urlcu;
	/* if($_SESSION['login']['role']!='3'){
		transfer("Chỉ có admin mới được vào mục này . ", "index.php");
	} */
	if($_REQUEST['hoten']!='')
	{
		$where.=" and (ten like '%".$_REQUEST['hoten']."%')";
	}
	if($_REQUEST['email']!='')
	{
		$where.=" and (email like '%".$_REQUEST['email']."%')";
	}
	if($_REQUEST['dienthoai']!='')
	{
		$where.=" and (dienthoai like '%".$_REQUEST['dienthoai']."%')";
	}
	if($_REQUEST['diachi']!='')
	{
		$where.=" and (diachi like '%".$_REQUEST['diachi']."%')";
	}
	$where.=" and com!='admin' order by username";
	$dem=get_fetch("select count(id) AS numrows from #_khachhang where id<>0 $where");
	$totalRows=$dem['numrows'];
	$page=$_GET['p'];
	$pageSize=20;
	$offset=10;
	if ($page=="")
		$page=1;
	else
		$page=$_GET['p'];
	$page--;
	$bg=$pageSize*$page;
	$sql = "select * from #_khachhang where id<>0 $where limit $bg,$pageSize";
	$items=get_result($sql);
	$url_link="index.php?com=khachhang&act=man".$urlcu;
}
function get_item(){
	global $d, $item;
	/* if($_SESSION['login_admin']['role']!='3'){
			transfer("Chỉ có admin mới được vào mục này . ", "index.php");
		} */
		$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
		if(!$id)
			transfer("Không nhận được dữ liệu", "index.php?com=khachhang&act=man");
		$item = get_fetch("select * from #_khachhang where id='".$id."'");
		if($item){
		}else{
		    transfer("Dữ liệu không có thực", "index.php?com=khachhang&act=man");
		} 
	}
	function save_item(){
		global $d, $item, $login_name_admin,$config;
	/* if($_SESSION['login_admin']['role']!='3'){
			transfer("Chỉ có admin mới được vào mục này . ", "index.php");
		} */
		if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=khachhang&act=man");
		$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
		$data['username'] = $_POST['username'];
		$data['email'] = $_POST['email'];
		$data['ho'] = $_POST['ho'];
		$data['quoctich'] = $_POST['quoctich'];
		$data['curjob'] = $_POST['curjob'];
		$data['ten'] = $_POST['ten'];
		$data['sex'] = $_POST['sex'];
		$data['didong'] = $_POST['didong'];
		$data['dienthoai'] = $_POST['dienthoai'];
		$data['nick_yahoo'] = $_POST['nick_yahoo'];
		$data['nick_skype'] = $_POST['nick_skype'];
		$data['ngaysinh'] = strtotime($_POST['ngaysinh']);
		$data['diachi'] = $_POST['diachi'];
		$data['country'] = $_POST['country'];
		$data['city'] = $_POST['city'];
		$data['nhom'] = (int)$_POST['group'];
		$data['role'] = (int)$_POST['role'];
		$data['quyen'] = $_POST['quyen'];
	if($id){ // cap nhat
		
		if($_POST['oldpassword']!=""){
			$data['password'] = encrypt_password($config['salt_sta'],$_POST['oldpassword'],$config['salt_end']);
		}
		$d->reset();
		$d->setTable('khachhang');
		$d->setWhere('id', $id);
		//$d->setWhere('role', 1);
		if($d->update($data))
			transfer("Dữ liệu đã được cập nhật", "index.php?com=khachhang&act=man");
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=khachhang&act=man");
	}else{ // them moi
		$data['password'] = encrypt_password($config['salt_sta'],$_POST['oldpassword'],$config['salt_end']);
		
		$data['com'] = "user";
		$d->setTable('khachhang');
		if($d->insert($data)){
			transfer("Dữ liệu đã được lưu", "index.php?com=khachhang&act=man");
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=khachhang&act=man");
	}
}
function delete_item(){
	global $d, $item, $login_name_admin,$config;
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);
		// xoa item
		$d->reset();
		$d->setTable('khachhang');
		$d->setWhere('id',$id);
		if($d->delete())
			transfer("Dữ liệu đã được xóa", "index.php?com=khachhang&act=man");
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=khachhang&act=man");
	}
	elseif (isset($_GET['listid'])==true)
	{
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++)
		{
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);		
				// xoa item
			$d->reset();
			$d->setTable('khachhang');
			$d->setWhere('id',$id);
			$d->delete();
		} 
		redirect("index.php?com=khachhang&act=man");
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=khachhang&act=man");
}
