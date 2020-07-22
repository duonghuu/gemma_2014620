<?php
include ("ajax_config.php");
$act = $_REQUEST['act'];
switch ($act) {
	case 'remove_image':
	remove_images();
	break;
	case 'remove_uudiem':
	remove_uudiem();
	break;
}
function remove_images(){
	global $d,$act,$item;
	$id=(int)$_POST['id'];
	$d->reset();
	$sql_kt="select * from #_hinhanh where id='".$id."'";
	$d->query($sql_kt);
	if($d->num_rows()>0){
		$rs=$d->fetch_array();
		// delete_file("../"._upload_hinhthem . $rs['photo']);
		// delete_file("../"._upload_hinhthem . $rs['thumb']);
		delete_file(_upload_hinhthem . $rs['photo']);
		delete_file(_upload_hinhthem . $rs['thumb']);
		$sql="delete from #_hinhanh where id='".$id."' ";
		if($d->query($sql)){
			echo json_encode(array("md5"=>md5($id)));
		}
	}
	die;
}
function remove_uudiem(){
	global $d,$act,$item;
	$id=(int)$_POST['id'];
	$sql_kt="select photo from #_news where id='".$id."'";
	$rs=get_fetch($sql_kt);
	if($rs){
		
		// delete_file("../"._upload_tintuc . $rs['photo']);
		delete_file(_upload_tintuc . $rs['photo']);
		$sql="delete from #_news where id='".$id."' ";
		$d->reset();
		$d->setTable('news');
		$d->setWhere('id',$id);
		if($d->delete()){
			echo json_encode(array("md5"=>md5($id)));
		}
	}
	die;
}
