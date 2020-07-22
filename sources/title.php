<?php	if(!defined('_source')) die("Error");
$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
switch($act){
	case "capnhat":
		get_item();
		$template = "title/item_add";
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
function fns_Rand_digit($min,$max,$num)
	{
		$result='';
		for($i=0;$i<$num;$i++){
			$result.=rand($min,$max);
		}
		return $result;
	}

function get_item(){
	global $d, $item;
	$sql = "select * from #_title where type='".$_REQUEST['type']."' limit 0,1";
	$d->query($sql);
	if($d->num_rows()==0)
	{
		$data['ngaytao'] = time();
		$data['type'] = $_REQUEST['type'];
		$d->setTable('title');
		if($d->insert($data))
			transfer("Dữ liệu được khởi tạo","index.php?com=title&act=capnhat&type=".$_REQUEST['type']);
		else
			transfer("Khởi tạo dữ liệu lỗi","index.php?com=title&act=capnhat&type=".$_REQUEST['type']);
	}
	$item = $d->fetch_array();
}

function save_item(){
	global $d,$config;
	$file_name = images_name($_FILES['file']['name']);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=title&act=capnhat&type=".$_REQUEST['type']);
	if($photo = upload_image("file", _format_duoihinh,_upload_hinhanh,$file_name)){
			$data['photo'] = $photo;
			if(_width_thumb > 0 and _height_thumb > 0)
			$data['thumb'] = create_thumb($data['photo'], _width_thumb, _height_thumb, _upload_hinhanh,$file_name,_style_thumb);
			$d->setTable('title');
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_hinhanh.$row['photo']);
				delete_file(_upload_hinhanh.$row['thumb']);
			}
		}

	$data['title'] = $_POST['title'];
	$data['keywords'] = $_POST['keywords'];
	$data['description'] = $_POST['description'];
	$data['ngaysua'] = time();
	$d->reset();
	$d->setTable('title');
	$d->setWhere('type', $_REQUEST['type']);
	if($d->update($data)){
		transfer("Dữ liệu được cập nhật", "index.php?com=title&act=capnhat&type=".$_REQUEST['type']);
	}
	else{
		transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=title&act=capnhat&type=".$_REQUEST['type']);
	}
}
function delete_item(){
	global $d,$config;
	$get_title = get_fetch("select id,thumb, photo from #_title where type='".$_REQUEST['type']."'");
	if($d->num_rows()>0){
		foreach($get_title as $row){
			delete_file(_upload_hinhanh.$row['photo']);
			delete_file(_upload_hinhanh.$row['thumb']);
		}
		$d->reset();
		$sql = "delete from #_title where type='".$_REQUEST['type']."'";
		$d->query($sql);
	}
	if($d->query($sql))
		transfer("Dữ liệu được cập nhật", "index.php");
	else
		transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=title&act=capnhat&type=".$_REQUEST['type']);
}

?>
