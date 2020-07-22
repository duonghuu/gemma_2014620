<?php	if(!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

switch($act){
	case "capnhat":
		get_gioithieu();
		$template = "company/item_add";
		break;
	case "save":
		save_gioithieu();
		break;

	default:
		$template = "index";
}

function get_gioithieu(){
	global $d, $item,$thuoctinh;
	$sql = "select * from #_company limit 0,1";
	$d->query($sql);
	//if($d->num_rows()==0) transfer("Dữ liệu chưa khởi tạo.", "index.php");
	$item = $d->fetch_array();
	$thuoctinh = json_decode($item["thuoctinh"],true);
}
function fns_Rand_digit($min,$max,$num)
	{
		$result='';
		for($i=0;$i<$num;$i++){
			$result.=rand($min,$max);
		}
		return $result;
	}
function save_gioithieu(){
	global $d,$config;
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=company&act=capnhat");
	foreach ($config['lang'] as $key => $value) {
			$data['ten'.$key] = $_POST['ten'.$key];
			$data['diachi'.$key] = $_POST['diachi'.$key];
			$data['slogan'.$key] = $_POST['slogan'.$key];
	}
	if($_POST['Latitude']!=0 and $_POST['Longitude']!=0){
			$toado=$_POST['Latitude'].','.$_POST['Longitude'];
			$data['toado'] = $toado;
		}
	$file_name = images_name($_FILES['favicon']['name']);
	$dongdau_name = images_name($_FILES['dongdau']['name']);

	if($favicon = upload_image("favicon", _format_duoihinh,_upload_hinhanh,$file_name)){
			$data['favicon'] = $favicon;
			// $data['faviconthumb'] = create_thumb($data['favicon'], 32, 32, _upload_hinhanh,$file_name,2);
			$d->setTable('company');
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_hinhanh.$row['favicon']);
				// delete_file(_upload_hinhanh.$row['faviconthumb']);
			}
	}
	if($dongdau = upload_image("dongdau", _format_duoihinh,_upload_hinhanh,$dongdau_name)){
			$data['dongdau'] = $dongdau;
			$data['dongdauthumb'] = create_thumb($data['dongdau'], 70, 70, _upload_hinhanh,$dongdau_name,2);
			$d->setTable('company');
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file(_upload_hinhanh.$row['dongdau']);
				delete_file(_upload_hinhanh.$row['dongdauthumb']);
			}
			del_cache();
	}
	if($sitemap = upload_image("sitemap", "xml|XML","../","sitemap")){
			$data['sitemap'] = $sitemap;
	}
	$data["thuoctinh"] = json_encode($_POST["thuoctinh"],JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
	$data['dienthoai'] = $_POST['dienthoai'];
	$data['email'] = $_POST['email'];
	$data['website'] = $_POST['website'];
	$data['giomo'] = $_POST['giomo'];
	$data['fax'] = $_POST['fax'];
	$data['fanpage'] = $_POST['fanpage'];
	$data['bct'] = $_POST['bct'];
	$data['ngaytao'] = strtotime((string)$_POST['ngaytao']);
	$data['codethem'] = magic_quote($_POST['codethem']);
	$data['codethem2'] = magic_quote($_POST['codethem2']);
	$data['bando'] = magic_quote($_POST['bando']);
	$data['soluong_sp'] = $_POST['soluong_sp'];
	$data['soluong_spk'] = $_POST['soluong_spk'];
	$data['soluong_tin'] = $_POST['soluong_tin'];
	$data['soluong_tink'] = $_POST['soluong_tink'];
	$data['lang_default'] = $_POST['lang_default'];

	$data['title'] = magic_quote($_POST['title']);
	$data['keywords'] = magic_quote($_POST['keywords']);
	$data['description'] = magic_quote($_POST['description']);
	$data['h1'] = $_POST['h1'];
	$data['h2'] = $_POST['h2'];
	$data['h3'] = $_POST['h3'];
	$d->reset();
	$d->setTable('company');
	if($d->update($data))
		transfer("Cập nhật dữ liệu Thành Công", "index.php?com=company&act=capnhat");
	else
		transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=company&act=capnhat");
}

?>
