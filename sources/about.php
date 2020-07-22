<?php	if(!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
switch($act){
	case "capnhat":
		get_item();
		$template = "about/item_add";
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
	$item = get_fetch("select * from #_about where type='".$_REQUEST['type']."'");

	if(empty($item))
	{
		$data['hienthi'] = '1';
		$data['ngaytao'] = time();
		$data['type'] = $_REQUEST['type'];

		$d->reset();
		$d->setTable('about');
		if($d->insert($data))
			transfer("Dữ liệu được khởi tạo","index.php?com=about&act=capnhat&type=".$_REQUEST['type']);
		else
			transfer("Khởi tạo dữ liệu lỗi","index.php?com=about&act=capnhat&type=".$_REQUEST['type']);
	}
}

function save_item(){
	global $d,$config;

	$file_name = images_name($_FILES['file']['name']);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=about&act=capnhat&type=".$_REQUEST['type']);

	if($photo = upload_image("file", _format_duoihinh,_upload_hinhanh,$file_name)){
			$data['photo'] = $photo;
			if(_width_thumb > 0 and _height_thumb > 0)
			$data['thumb'] = create_thumb($data['photo'], _width_thumb, _height_thumb, _upload_hinhanh,$file_name,_style_thumb);
			$row=get_fetch("select photo,thumb from #_about where type='".$_REQUEST['type']."'");
			if($row){
				delete_file(_upload_hinhanh.$row['photo']);
				delete_file(_upload_hinhanh.$row['thumb']);
			}
		}

	$data['tenkhongdau'] = changeTitle($_POST['ten']);
	$data['title'] = $_POST['title'];
	$data['keywords'] = $_POST['keywords'];
	$data['description'] = $_POST['description'];
	$data['h1'] = $_POST['h1'];
	$data['h2'] = $_POST['h2'];
	$data['h3'] = $_POST['h3'];
	$data['link'] = $_POST['link'];
	$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
	$data['ngaysua'] = time();
	foreach ($config['lang'] as $key => $value) {
		$data['ten'.$key] = magic_quote($_POST['ten'.$key]);
		$data['ten2'.$key] = magic_quote($_POST['ten2'.$key]);
		$data['mota'.$key] = magic_quote($_POST['mota'.$key]);
		$data['mota2'.$key] = magic_quote($_POST['mota2'.$key]);
		$data['noidung'.$key] = magic_quote($_POST['noidung'.$key]);
	}
	$d->reset();
	$d->setTable('about');
	$d->setWhere('type', $_REQUEST['type']);
	if($d->update($data)){
		if (isset($_FILES['files'])) {
			$arr_chuoi = str_replace('"','',$_POST['jfiler-items-exclude-files-0']);
			$arr_chuoi = str_replace('[','',$arr_chuoi);
			$arr_chuoi = str_replace(']','',$arr_chuoi);
			$arr_file_del = explode(',',$arr_chuoi);
			for($i=0;$i<count($_FILES['files']['name']);$i++){
				if($_FILES['files']['name'][$i]!=''){
					if(!in_array(($_FILES['files']['name'][$i]),$arr_file_del,true))
					{
								//dump(in_array(($_FILES['files']['name'][$i]),$arr));
						$file['name'] = $_FILES['files']['name'][$i];
						$file['type'] = $_FILES['files']['type'][$i];
						$file['tmp_name'] = $_FILES['files']['tmp_name'][$i];
						$file['error'] = $_FILES['files']['error'][$i];
						$file['size'] = $_FILES['files']['size'][$i];
						$file_name = images_name($_FILES['files']['name'][$i]);
						$photo = upload_photos($file, _format_duoihinh, _upload_hinhthem,$file_name);
						$data1['photo'] = $photo;
						$data1['thumb'] = create_thumb($data1['photo'], _width_thumb, _height_thumb, _upload_hinhthem,$file_name,_style_thumb);
						$data1['stt'] = $_POST['stthinh'][$i];
						$data1['type'] = $_POST['type'];
						$data1['id_hinhanh'] = $id;
						$data1['hienthi'] = 1;
						$d->setTable('hinhanh');
						$d->insert($data1);
					}
				}
			}
		}
		transfer("Dữ liệu được cập nhật", "index.php?com=about&act=capnhat&type=".$_REQUEST['type']);
	}
	else{
		transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=about&act=capnhat&type=".$_REQUEST['type']);
	}
}
function delete_item(){
	global $d,$config;
	$photo_lq = get_result("select id,photo,thumb from #_hinhanh where type='".$_REQUEST['type']."'");
	if(count($photo_lq)>0){
		foreach($photo_lq as $v){
			delete_file(_upload_hinhthem.$v['photo']);
			delete_file(_upload_hinhthem.$v['thumb']);
			$d->reset();
			$sql = "delete from #_hinhanh where id='".$v["id"]."'";
			$d->query($sql);
		}
	}
	$get_about = get_fetch("select id,thumb, photo from #_about where type='".$_REQUEST['type']."'");
	if($d->num_rows()>0){
		foreach($get_about as $row){
			delete_file(_upload_hinhanh.$row['photo']);
			delete_file(_upload_hinhanh.$row['thumb']);
		}
		$d->reset();
		$sql = "delete from #_about where type='".$_REQUEST['type']."'";
		$d->query($sql);
	}
	if($d->query($sql))
		transfer("Dữ liệu được cập nhật", "index.php");
	else
		transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=about&act=capnhat&type=".$_REQUEST['type']);
}

?>
