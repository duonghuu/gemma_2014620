<?php	if(!defined('_source')) die("Error");
switch($act){

	case "man":
		get_items();
		$template = "gia/items";
		break;
	case "add":		
		$template = "gia/item_add";
		break;
	case "edit":		
		get_item();
		$template = "gia/item_add";
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
	if($_GET['type']=='tintuc'){

		$title_main = "Tin Tức";
		$config_images = "true";
		$config_mota= "true";

	} elseif($_GET['type']=='dichvu'){

		$title_main = "Dịch Vụ";
		$config_mota = "true";
		$config_images = "true";

	} elseif($_GET['type']=='chamsoc'){

		$title_main = "Chăm sóc khách hàng";
		$config_mota = "false";
		$config_images = "false";

	} elseif($_GET['type']=='hoangquan'){

		$title_main = "Xuất nhập khẩu Hoàng Quân";
		$config_mota = "false";
		$config_images = "false";

	} else {

		$title_main = "Bài Viết";
		$config_images = "true";

	}

#====================================

function get_items(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset,$paging,$urlcu,$page;
	
	#-------------------------------------------------------------------------------
	
	// $per_page = 10; // Set how many records do you want to display per page.
	// $startpoint = ($page * $per_page) - $per_page;
	// $limit = ' limit '.$startpoint.','.$per_page;
	
	$where = " and hienthi>0";
	
	if($_REQUEST['keyword']!='')
	{
		// $keyword=addslashes($_REQUEST['keyword']);
		$where.=" and ten_vi LIKE '%$keyword%'";
		$link_add .= "&keyword=".$_GET['keyword'];
	}

	if($_REQUEST['id_product']!='')
	{
		$where.=" and id_product='".$_GET['id_product']."'";
	}

	$where .=" order by id desc";

	// $sql = "select *,ten_vi,id,stt,hienthi,id_product from $where $limit";
	// $d->query($sql);
	// $items = $d->result_array();

	// $url = "index.php?com=gia&act=man&type=".$_GET['type']."".$link_add;
	// $paging = pagination($where,$per_page,$page,$url);		
	$dem=get_fetch("select count(id) AS numrows from #_gia where id<>0 $where");
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
	$sql = "select * from #_gia where id<>0 $where limit $bg,$pageSize";
	$items=get_result($sql);
	$url_link="index.php?com=gia&act=man".$urlcu;
}
function get_item(){
  global $d, $item,$ds_tags;
  $id = isset($_GET['id']) ? themdau($_GET['id']) : "";

  if(!$id)
    transfer("Không nhận được dữ liệu", "index.php?com=gia&act=man&type=".$_GET['type']); 
  $sql = "select * from #_gia where id='".$id."'";
  $d->query($sql);
  if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=gia&act=man&type=".$_GET['type']);
  $item = $d->fetch_array();
}
function save_item(){
  global $d;
  if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=gia&act=man&type=".$_GET['type']);
  $id = isset($_POST['id']) ? themdau($_POST['id']) : "";
  if($id){
    $id =  themdau($_POST['id']);

    // dump($_POST);
    $data['nhandien'] = $_POST['nhandien'];
    $data['chatlieu'] = $_POST['chatlieu'];
    $data['kichthuoc'] = $_POST['kichthuoc'];
    $data['mausac'] = $_POST['mausac'];
    $data['gia'] = str_replace(',','',$_POST['gia']);
    $data['id_product'] = $_POST['id_product'];


    $data['ten'] = $_POST['ten'];
    $data['tenkhongdau'] = changeTitle($_POST['ten']);
    $data['tenen'] = $_POST['tenen'];
    $data['giatu'] = str_replace(',','',$_POST['giatu']);
    $data['giaden'] = str_replace(',','',$_POST['giaden']);
    
    $data['stt'] = $_POST['stt'];
    
    $data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
    
    $data['ngaysua'] = time();
    $d->setTable('gia');
    $d->setWhere('id', $id);
    if($d->update($data))
      redirect("index.php?com=gia&act=man&id_product=".$_POST['id_product']);
    else
      transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=gia&act=man&type=".$_GET['type']);
  }else{

    // dump($_POST);
    $data['nhandien'] = $_POST['nhandien'];
    $data['chatlieu'] = $_POST['chatlieu'];
    $data['kichthuoc'] = $_POST['kichthuoc'];
    $data['mausac'] = $_POST['mausac'];
    $data['gia'] = str_replace(',','',$_POST['gia']);
    $data['id_product'] = $_POST['id_product'];


    $data['ten'] = $_POST['ten'];
    $data['tenen'] = $_POST['tenen'];
    $data['tenkhongdau'] = changeTitle($_POST['ten']);
    $data['giatu'] = str_replace(',','',$_POST['giatu']);
    $data['giaden'] = str_replace(',','',$_POST['giaden']);
    
    $data['stt'] = $_POST['stt'];
    
    $data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;
    $data['ngaytao'] = time();
    $d->reset();
    $d->setTable('gia');

    if($d->insert($data))
    {     
      redirect("index.php?com=gia&act=man&id_product=".$_POST['id_product']);
    }
    else{
      transfer("Lưu dữ liệu bị lỗi", "index.php?com=gia&act=man&type=".$_GET['type']);
    }
  }
}

function delete_item(){
  global $d;
  if(isset($_GET['id'])){
    $id =  themdau($_GET['id']);
    $d->reset();
    $sql = "select id from #_gia where id='".$id."'";
    $d->query($sql);
    if($d->num_rows()>0){
      // $sql = "delete from #_gia where id='".$id."'";
      // $d->query($sql);

      $d->reset();
      $d->setTable("gia");
      $d->setWhere("id", $id);
      $del_rs = $d->delete();
    }
    if($del_rs)
      redirect("index.php?com=gia&act=man&curPage=".$_REQUEST['curPage']."&type=".$_GET['type']."&id_product=".$_GET['id_product']);
    else
      transfer("Xóa dữ liệu bị lỗi", "index.php?com=gia&act=man&curPage=".$_REQUEST['curPage']."&type=".$_GET['type']."&id_product=".$_GET['id_product']);
  } elseif (isset($_GET['listid'])==true){
    $listid = explode(",",$_GET['listid']); 
    for ($i=0 ; $i<count($listid) ; $i++){
      $idTin=$listid[$i]; 
      $id =  themdau($idTin);   
      $d->reset();
      $sql = "select id from #_gia where id='".$id."'";
      $d->query($sql);
      if($d->num_rows()>0){
        $sql = "delete from #_gia where id='".$id."'";
        $d->query($sql);
      }
    }
    redirect("index.php?com=gia&act=man&curPage=".$_REQUEST['curPage']."&type=".$_GET['type']."&id_product=".$_GET['id_product']);
  } else {
    transfer("Không nhận được dữ liệu", "index.php?com=gia&act=man&curPage=".$_REQUEST['curPage']."&type=".$_GET['type']."&id_product=".$_GET['id_product']);
  }


}