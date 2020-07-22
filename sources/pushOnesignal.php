<?php	if(!defined('_source')) die("Error");	 

include_once  "../admin/lib/config.php";	
if (!file_exists('../upload/onesignal')) {
	mkdir('../upload/onesignal', 0777, true);
} 
$exists = mysql_query("select 1 from table_pushonesignal");
if($exists === FALSE)
{
	global $d;
// sql to create table
	$sql = "create table table_pushonesignal (id int(10)  unsigned auto_increment primary key , stt int(5) not null default '1', ten_vi varchar(255) not null, ten_en varchar(255) not null, link varchar(255) not null, photo_en varchar(255) not null, photo_vi varchar(255) not null, thumb_en varchar(255) not null, thumb_vi varchar(255) not null, mota_vi text not null, mota_en text not null, hienthi int(10) not null, ngaytao int(11) not null, thoigianbatdau int(11) not null, thoigianketthuc int(11) not null, gio int(11) not null, phut int(11) not null, giay int(11) not null, muigio varchar(255) not null, solangui int(11) not null, conlai int(11) not null, mathongbao varchar(255) not null, lichgui text not null )";
	if ($d->query($sql) !== TRUE) {
		echo "Error creating table: " . $d->error;
	}
}


@define ( _width_thumb , 360 );
@define ( _height_thumb , 240 );
@define ( _style_thumb , 2 );
$ratio_ = 1;
switch($act){
	case "man":
	get_mans();
	$template = "pushOnesignal/items";
	break;
	case "add":		
	
	$template = "pushOnesignal/item_add";
	break;
	case "edit":		
	get_man();
	$template = "pushOnesignal/item_add";
	break;
	case "save":
	save_man();
	break;
	case "sync":
	sendSync();
	break;
	case "delete":
	delete_man();
	break;	
	#============================================================
	default:
	$template = "index";
}

#====================================
function fns_Rand_digit($min,$max,$num)
	{
		$result='';
		for($i=0;$i<$num;$i++){
			$result.=rand($min,$max);
		}
		return $result;
	}
function get_mans(){
	global $d, $items, $paging,$page;
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$limit = ' limit '.$startpoint.','.$per_page;
	$where = " #_pushonesignal ";
	$where .=" order by id desc";
	$sql = "select * from $where";
	$d->query($sql);
	$items = $d->result_array();
	$curPage = isset($_GET['curPage']) ? $_GET['curPage'] : 1;
	$url="index.php?com=pushOnsignal&act=man";
	// $paging = pagination($where,$per_page,$page,$url);
}

function get_man(){

	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
		transfer("Không nhận được dữ liệu","index.php?com=pushOnesignal&act=man");	
	$sql = "select * from #_pushonesignal where id='".$id."'";
	$d->query($sql);
	$item = $d -> fetch_array();
}


function save_man(){
	// echo strtotime($_POST['thoigianbatdau']);
	// dump($_POST);
	global $config_IDoneSignal,$config_KEYgooogleAPI;
	global $d;
// 	$file_name='sync';
	$file_name=images_name($_FILES['file']['name']);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=pushOnesignal&act=man");
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){
		$id =  themdau($_POST['id']);
		if($photo = upload_image("file", 'jpg|png|gif|JPG|jpeg|JPEG', '../upload/onesignal/',$file_name)){
			$data['photo_vi'] = $photo;	
			$data['thumb_vi'] = create_thumb($data['photo_vi'], _width_thumb, _height_thumb, '../upload/onesignal/',$file_name,_style_thumb);		
			$d->setTable('pushonesignal');
			$d->setWhere('id', $id);
			$d->select();
			if($d->num_rows()>0){
				$row = $d->fetch_array();
				delete_file('../upload/onesignal/'.$row['photo_vi']);	
				delete_file('../upload/onesignal/'.$row['thumb_vi']);				
			}
		}	

		$data['ten_vi'] = $_POST['ten_vi'];		
		$data['ten_en'] = $_POST['ten_en'];		
		$data['mota_vi'] = magic_quote($_POST['mota_vi']);
		$data['mota_en'] = magic_quote($_POST['mota_en']);
		$data['link'] = $_POST['link'];
		$datestroot = $_POST['thoigianbatdau'];
		
		$datestr = str_replace('/', '-', $datestroot);
		$datestr = date('m/d/Y h:i:s a', strtotime($datestr));
		$datestr = (string)$datestr;
// dump($datestroot .'----'. $datestr.'----'.strtotime($datestr));
		$data['thoigianbatdau'] = strtotime($datestr);

		$data['solangui'] = $_POST['solangui'];
		$data['gio'] = $_POST['gio'];
		$data['phut'] = $_POST['phut'];
		$data['giay'] = $_POST['giay'];
		$data['ngaytao'] = time();


		$d->setTable('pushonesignal');
		$d->setWhere('id', $id);
		if($d->update($data))
			header("Location:index.php?com=pushOnesignal&act=man");
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=pushOnesignal&act=man");
	}else{
		if($photo = upload_image("file", 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG', '../upload/onesignal/',$file_name)){
			$data['photo_vi'] = $photo;		
			$data['thumb_vi'] = create_thumb($data['photo_vi'], _width_thumb, _height_thumb, '../upload/onesignal/',$file_name,_style_thumb);
		}		
		$data['ten_vi'] = $_POST['ten_vi'];		
		$data['ten_en'] = $_POST['ten_en'];		
		$data['mota_vi'] = magic_quote($_POST['mota_vi']);
		$data['mota_en'] = magic_quote($_POST['mota_en']);
		$data['link'] = $_POST['link'];	
		$datestroot = $_POST['thoigianbatdau'];
		
		$datestr = str_replace('/', '-', $datestroot);
		$datestr = date('m/d/Y h:i:s a', strtotime($datestr));
		$datestr = (string)$datestr;
		$data['thoigianbatdau'] = strtotime($datestr);

		$data['solangui'] = $_POST['solangui'];
		$data['gio'] = $_POST['gio'];
		$data['phut'] = $_POST['phut'];
		$data['giay'] = $_POST['giay'];
		$data['ngaytao'] = time();
		$d->setTable('pushonesignal');
		if($d->insert($data))
			header("Location:index.php?com=pushOnesignal&act=man");
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=pushOnesignal&act=man");
	}
}
function delete_man(){
	global $d;
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);
		$d->reset();
		$sql = "select id,photo_vi,thumb_vi from #_pushonesignal where id='".$id."'";
		$d->query($sql);
		$row = $d->fetch_array();
		delete_file('../upload/onesignal/'.$row['photo_vi']);
		delete_file('../upload/onesignal/'.$row['thumb_vi']);
		$sql = "delete from #_pushonesignal where id='".$id."'";
		$d->query($sql);
		if($d->query($sql))
			redirect($_SESSION['links_re']);
		else
			transfer("Xóa dữ liệu bị lỗi", $_SESSION['links_re']);
	} elseif (isset($_GET['listid'])==true){
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++){
			$idTin=$listid[$i]; 
			$id =  themdau($idTin);	
			$d->reset();
			$sql = "select id,photo_vi,thumb_vi from #_pushonesignal where id='".$id."'";
			$d->query($sql);
			$row = $d->fetch_array();
			delete_file('../upload/onesignal/'.$row['photo_vi']);
			delete_file('../upload/onesignal/'.$row['thumb_vi']);
			$sql = "delete from #_pushonesignal where id='".$id."'";
			$d->query($sql);
		}
		redirect($_SESSION['links_re']);
	} else {
		transfer("Không nhận được dữ liệu", $_SESSION['links_re']);
	}
}
function sendMessage($APP_ID,$API_KEY,$head,$cont,$url,$photo,$time){
		// $headings = $head;
		// $content = $cont;
		// $url = $url;
	global  $config_url;
	$content = array(
		"en" => $cont
	);
	$headings = array(
		"en" => $head
	);
	$url = $url;
	$uphoto = 'https://'.$config_url.'/'.'upload/onesignal/'.$photo;
	$fields = array(
		'app_id' => $APP_ID,
		'included_segments' => array('All'),
		'data' => array("foo" => "bar"),
		'contents' => $content,
		'headings' => $headings,
		'url' => $url,
		'chrome_web_image' => $uphoto,
		'send_after' => $time
	);
	$fields = json_encode($fields);
	// print("\nJSON sent:\n");
    // print_r( json_decode($fields));
			// die;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
		'Authorization: Basic '.$API_KEY));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}

function slit_time($thoigianbatdau, $solangui, $gio=0, $phut=0, $giay=0){
	$arr_time = array();
	$temp = date('Y-m-d H:i:s',(int)$thoigianbatdau);
	array_push($arr_time, $temp);
	if ($solangui>1) {
		for ($i=0; $i < $solangui; $i++) { 
			// $temp = date('Y-m-d H:i:s TO',(int)$thoigianbatdau);
			$temp = date('Y-m-d H:i:s',strtotime('+'.$gio.' hour +'.$phut.' minutes +'.$giay.' seconds',strtotime($temp)));
			array_push($arr_time, $temp);
		}
	}
	return $arr_time;
}

function sendSync(){
	global $config_IDoneSignal,$config_KEYoneSignal,$d;
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);
		$d->reset();
		$sql = "select id,photo_vi,thumb_vi,ten_vi,mota_vi,link,solangui,thoigianbatdau,gio,phut,giay from #_pushonesignal where id='".$id."'";
		$d->query($sql);
		$row = $d->fetch_array();
		$APP_ID=$config_IDoneSignal;
		$API_KEY=$config_KEYoneSignal;

		$arr_time = slit_time($row['thoigianbatdau'],$row['solangui'],$row['gio'],$row['phut'],$row['giay']);
		foreach ($arr_time as $key => $value) {
			# code...
		$response = sendMessage($APP_ID,$API_KEY,$row['ten_vi'],$row['mota_vi'],$row['link'],$row['photo_vi'],$value.' UTC+0700');
		$return["allresponses"] = $response;
		sleep(2);
		}
		$return = json_encode( $return);
	}
	transfer("Gửi thông báo thành công", "index.php?com=pushOnesignal&act=man");
}

// echo '<pre>'; print_r(slit_time(1530334620,5,2,10,5)); echo '</pre>';
?>