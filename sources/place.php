<?php	if(!defined('_source')) die("Error");
$urlcu = "";
$urlcu .= (isset($_REQUEST['id_city'])) ? "&id_city=".addslashes($_REQUEST['id_city']) : "";
$urlcu .= (isset($_REQUEST['id_dist'])) ? "&id_dist=".addslashes($_REQUEST['id_dist']) : "";
$urlcu .= (isset($_REQUEST['id_ward'])) ? "&id_ward=".addslashes($_REQUEST['id_ward']) : "";
$urlcu .= (isset($_REQUEST['id_street'])) ? "&id_street=".addslashes($_REQUEST['id_street']) : "";
$urlcu .= (isset($_REQUEST['type'])) ? "&type=".addslashes($_REQUEST['type']) : "";
$urlcu .= (isset($_REQUEST['p'])) ? "&p=".addslashes($_REQUEST['p']) : "";
switch($act){
	case "man_city":
		get_citys();
		$template = "place/citys";
		break;
	case "add_city":		
		$template = "place/city_add";
		break;
	case "edit_city":		
		get_city();
		$template = "place/city_add";
		break;
	case "save_city":
		save_city();
		break;
	case "delete_city":
		delete_city();
		break;
	case "man_dist":
		get_dists();
		$template = "place/dists";
		break;
	case "add_dist":		
		$template = "place/dist_add";
		break;
	case "edit_dist":		
		get_dist();
		$template = "place/dist_add";
		break;
	case "save_dist":
		save_dist();
		break;
	case "delete_dist":
		delete_dist();
		break;	
	case "man_ward":
		get_wards();
		$template = "place/wards";
		break;
	case "add_ward":		
		$template = "place/ward_add";
		break;
	case "edit_ward":		
		get_ward();
		$template = "place/ward_add";
		break;
	case "save_ward":
		save_ward();
		break;
	case "delete_ward":
		delete_ward();
		break;	
	case "man_street":
		get_streets();
		$template = "place/streets";
		break;
	case "add_street":		
		$template = "place/street_add";
		break;
	case "edit_street":		
		get_street();
		$template = "place/street_add";
		break;
	case "save_street":
		save_street();
		break;
	case "delete_street":
		delete_street();
		break;	
	default:
		$template = "index";
}
#====================================
function get_citys(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset;
	if(!empty($_POST)){
		$multi=$_REQUEST['multi'];
		$id_array=$_POST['iddel'];
		$count=count($id_array);
		if($multi=='show'){
			for($i=0;$i<$count;$i++){
				$data = array();
				$data["hienthi"] = 1;
				$d->reset();
				$d->setTable("place_city");
				$d->setWhere("id", $id_array[$i]);
				if($d->update($data) == false){
					die("Not query sqlUPDATE_ORDER");
				}
			}
			redirect($_SESSION["links_re"]);			
		}
		if($multi=='hide'){
			for($i=0;$i<$count;$i++){
				$data = array();
				$data["hienthi"] = 0;
				$d->reset();
				$d->setTable("place_city");
				$d->setWhere("id", $id_array[$i]);
				if($d->update($data) == false){
					die("Not query sqlUPDATE_ORDER");
				}
			}
			redirect($_SESSION["links_re"]);			
		}
		if($multi=='del'){
			for($i=0;$i<$count;$i++){							
				$d->reset();
				$d->setTable('place_city');
				$d->setWhere('id',$id_array[$i]);
				if($d->delete() == false){
				  die("Not query sqlUPDATE_ORDER");	
				}
			}
			redirect($_SESSION["links_re"]);			
		}
	}
	#----------------------------------------------------------------------------------------
	if($_REQUEST['hienthi']!='')
	{
		$id_up = $_REQUEST['hienthi'];
		$d->reset();
		$d->setTable('place_city');
		$d->setWhere('id',$id_up);
		$d->select('id,hienthi');
		$cats= $d->fetch_array();

		$hienthi=$cats['hienthi'];
		if($hienthi==0)
		{
			$data = array();
			$data["hienthi"] = 1;
			$d->reset();
			$d->setTable("place_city");
			$d->setWhere($id, $id_up);
			if($d->update($data) == false){
				die("Not query sqlUPDATE_ORDER");
			}
		}
		else
		{
			$data = array();
			$data["hienthi"] = 0;
			$d->reset();
			$d->setTable("place_city");
			$d->setWhere($id, $id_up);
			if($d->update($data) == false){
				die("Not query sqlUPDATE_ORDER");
			}
		}	
	}
	#-------------------------------------------------------------------------------
	if($_REQUEST['key']!='')
	{
		$where.=" where ten like '%".$_REQUEST['key']."%'";
	}
	$dem=get_fetch("SELECT count(id) AS numrows FROM #_place_city $where");
	$totalRows=$dem['numrows'];
	$page=$_GET['p'];
	$pageSize=10;
	$offset=5;
	if ($page=="")
		$page=1;
	else 
		$page=$_GET['p'];
	$page--;
	$bg=$pageSize*$page;		
	$sql = "SELECT * from #_place_city $where order by id limit $bg,$pageSize";		
	$items=get_result($sql);
	$url_link='index.php?com=place&act=man_city';		
}
function get_city(){
	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_city");	
	$item = get_fetch("select * from #_place_city where id='".$id."'");
	if($item){

	}else{
	    transfer("Dữ liệu không có thực", "index.php?com=place&act=man_city");
	} 
}
function save_city(){
	global $d;	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_city");
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){
		$id =  themdau($_POST['id']);					
		$data['ten'] = $_POST['name'];			
		$data['tenkhongdau'] = changeTitle($_POST['name']);			
		$data['stt'] = $_POST['num'];			
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;		
		$data['ngaysua'] = time();
		$d->setTable('place_city');
		$d->setWhere('id', $id);
		if($d->update($data)){						
			// redirect("index.php?com=place&act=man_city&curPage=".$_REQUEST['curPage']."");
			redirect($_SESSION["links_re"]);
		}else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=place&act=man_city");
	}else{
		$data['ten'] = $_POST['name'];	
		$data['tenkhongdau'] = changeTitle($_POST['name']);		
		$data['stt'] = $_POST['num'];				
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('place_city');
		if($d->insert($data))
		{		
			redirect($_SESSION["links_re"]);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=place&act=man_city");
	}
}
function delete_city(){
	global $d;
	if($_REQUEST['id_cat']!='')
	{ $id_catt="&id_cat=".$_REQUEST['id_cat'];
	}
	if($_REQUEST['curPage']!='')
	{ $id_catt.="&curPage=".$_REQUEST['curPage'];
	}
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);
		$d->reset();
		$d->setTable('place_city');
		$d->setWhere('id',$id);
		if($d->delete() == false){
		  transfer("Xóa dữ liệu bị lỗi", "index.php?com=place&act=man_city");
		}else{
			// redirect("index.php?com=place&act=man_city".$id_catt."");
			redirect($_SESSION["links_re"]);
		}
	}else transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_city");
}
#====================================
function get_dists(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset;
	if(!empty($_POST)){
		$multi=$_REQUEST['multi'];
		$id_array=$_POST['iddel'];
		$count=count($id_array);
		if($multi=='show'){
			for($i=0;$i<$count;$i++){
				$data = array();
				$data["hienthi"] = 1;
				$d->reset();
				$d->setTable("place_dist");
				$d->setWhere("id", $id_array[$i]);
				if($d->update($data) == false){
					die("Not query sqlUPDATE_ORDER");
				}	
			}
			redirect($_SESSION["links_re"]);			
		}
		if($multi=='hide'){
			for($i=0;$i<$count;$i++){
				$data = array();
				$data["hienthi"] = 0;
				$d->reset();
				$d->setTable("place_dist");
				$d->setWhere("id", $id_array[$i]);
				if($d->update($data) == false){
					die("Not query sqlUPDATE_ORDER");
				}			
			}
			redirect($_SESSION["links_re"]);			
		}
		if($multi=='del'){
			for($i=0;$i<$count;$i++){							
				$d->reset();
				$d->setTable('place_dist');
				$d->setWhere('id',$id_array[$i]);
				if($d->delete() == false){
				  die("Not query sqlUPDATE_ORDER");	
				}
			}
			redirect($_SESSION["links_re"]);			
		}
	}
	#----------------------------------------------------------------------------------------
	if($_REQUEST['hienthi']!='')
	{
		$id_up = $_REQUEST['hienthi'];
		$d->reset();
		$d->setTable('place_dist');
		$d->setWhere('id',$id_up);
		$d->select('id,hienthi');
		$cats= $d->fetch_array();

		$hienthi=$cats['hienthi'];
		if($hienthi==0)
		{
			$data = array();
			$data["hienthi"] = 1;
			$d->reset();
			$d->setTable("place_dist");
			$d->setWhere($id, $id_up);
			if($d->update($data) == false){
				die("Not query sqlUPDATE_ORDER");
			}
		}
		else
		{
			$data = array();
			$data["hienthi"] = 0;
			$d->reset();
			$d->setTable("place_dist");
			$d->setWhere($id, $id_up);
			if($d->update($data) == false){
				die("Not query sqlUPDATE_ORDER");
			}
		}	
	}
	#-------------------------------------------------------------------------------
	if((int)$_REQUEST['id_cat']!='')
	{
		$categoryData = get_id_child('place_cat',$_REQUEST['id_cat']);
		$cat_array=implode(",",$categoryData);
		$where.=" where id_cat IN ($cat_array) ";
	}
	if($_REQUEST['id_city']!='')
	{
		$where.=" where id_city = '".$_REQUEST['id_city']."'";
	}	
	if($_REQUEST['key']!='')
	{
		$where.=" where ten like '%".$_REQUEST['key']."%'";
	}
	$sql= "SELECT count(id) AS numrows FROM #_place_dist $where";
	$d->query($sql);	
	$dem=$d->fetch_array();
	$totalRows=$dem['numrows'];
	$page=$_GET['p'];
	$pageSize=10;
	$offset=5;
	if ($page=="")
		$page=1;
	else 
		$page=$_GET['p'];
	$page--;
	$bg=$pageSize*$page;		
	$sql = "SELECT * from #_place_dist $where order by id  limit $bg,$pageSize";		
	$items=get_result($sql);
	$url_link='index.php?com=place&act=man_dist';		
}
function get_dist(){
	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_dist");	
	$item = get_fetch("select * from #_place_dist where id='".$id."'");
	if($item){

	}else{
	    transfer("Dữ liệu không có thực", "index.php?com=place&act=man_dist");
	} 
}
function save_dist(){
	global $d;	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_dist".$urlcu);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){
		$id =  themdau($_POST['id']);					
		$data['id_city'] = (int)$_POST['id_city'];	
		$data['ten'] = $_POST['name'];			
		$data['tenkhongdau'] = changeTitle($_POST['name']);	
		$data['stt'] = $_POST['num'];
		$data['gia'] = $_POST['gia'];			
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;		
		$data['ngaysua'] = time();
		$d->setTable('place_dist');
		$d->setWhere('id', $id);
		if($d->update($data)){						
			// redirect("index.php?com=place&act=man_dist".$urlcu);
			redirect($_SESSION["links_re"]);
		}else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=place&act=man_dist".$urlcu);
	}else{
		$data['id_city'] = (int)$_POST['id_city'];	
		$data['ten'] = $_POST['name'];	
		$data['tenkhongdau'] = changeTitle($_POST['name']);		
		$data['stt'] = $_POST['num'];
		$data['gia'] = $_POST['gia'];				
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('place_dist');
		if($d->insert($data))
		{		
			// redirect("index.php?com=place&act=man_dist".$urlcu);
			redirect($_SESSION["links_re"]);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=place&act=man_dist".$urlcu);
	}
}
function delete_dist(){
	global $d;
	if($_REQUEST['id_city']!='')
	{ $id_catt="&id_city=".$_REQUEST['id_city'];
	}
	if($_REQUEST['curPage']!='')
	{ $id_catt.="&curPage=".$_REQUEST['curPage'];
	}
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);
		$d->reset();
		$d->setTable('place_dist');
		$d->setWhere('id',$id);
		if($d->delete() == false){
		  transfer("Xóa dữ liệu bị lỗi", "index.php?com=place&act=man_dist".$urlcu);
		}else{
			// redirect("index.php?com=place&act=man_dist".$id_catt."");
			redirect($_SESSION["links_re"]);
		}
	}else transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_dist".$urlcu);
}
#====================================
function get_wards(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset;
	if(!empty($_POST)){
		$multi=$_REQUEST['multi'];
		$id_array=$_POST['iddel'];
		$count=count($id_array);
		if($multi=='show'){
			for($i=0;$i<$count;$i++){
				$data = array();
				$data["hienthi"] = 1;
				$d->reset();
				$d->setTable("place_ward");
				$d->setWhere("id", $id_array[$i]);
				if($d->update($data) == false){
					die("Not query sqlUPDATE_ORDER");
				}
			}
			// redirect("index.php?com=place&act=man_ward".$urlcu);
			redirect($_SESSION["links_re"]);			
		}
		if($multi=='hide'){
			for($i=0;$i<$count;$i++){
				$data = array();
				$data["hienthi"] = 0;
				$d->reset();
				$d->setTable("place_ward");
				$d->setWhere("id", $id_array[$i]);
				if($d->update($data) == false){
					die("Not query sqlUPDATE_ORDER");
				}			
			}
			// redirect("index.php?com=place&act=man_ward".$urlcu);
			redirect($_SESSION["links_re"]);			
		}
		if($multi=='del'){
			for($i=0;$i<$count;$i++){							
				$d->reset();
				$d->setTable('place_ward');
				$d->setWhere('id',$id_array[$i]);
				if($d->delete() == false){
				  die("Not query sqlUPDATE_ORDER");	
				}	
			}
			// redirect("index.php?com=place&act=man_ward".$urlcu);
			redirect($_SESSION["links_re"]);			
		}
	}
	#----------------------------------------------------------------------------------------
	if($_REQUEST['hienthi']!='')
	{
		$id_up = $_REQUEST['hienthi'];
		$d->reset();
		$d->setTable('place_ward');
		$d->setWhere('id',$id_up);
		$d->select('id,hienthi');
		$cats= $d->fetch_array();

		$hienthi=$cats['hienthi'];
		if($hienthi==0)
		{
			$data = array();
			$data["hienthi"] = 1;
			$d->reset();
			$d->setTable("place_ward");
			$d->setWhere($id, $id_up);
			if($d->update($data) == false){
				die("Not query sqlUPDATE_ORDER");
			}
		}
		else
		{
			$data = array();
			$data["hienthi"] = 0;
			$d->reset();
			$d->setTable("place_ward");
			$d->setWhere($id, $id_up);
			if($d->update($data) == false){
				die("Not query sqlUPDATE_ORDER");
			}
		}	
	}
	#-------------------------------------------------------------------------------
	if($_REQUEST['id_city']!='')
	{
		$where.=" where id_city = '".$_REQUEST['id_city']."'";
	}
	if($_REQUEST['id_dist']!='')
	{
		$where.=" and id_dist = '".$_REQUEST['id_dist']."'";
	}	
	if($_REQUEST['key']!='')
	{
		$where.=" where ten like '%".$_REQUEST['key']."%'";
	}
	$sql= "SELECT count(id) AS numrows FROM #_place_ward $where";
	$d->query($sql);	
	$dem=$d->fetch_array();
	$totalRows=$dem['numrows'];
	$page=$_GET['p'];
	$pageSize=10;
	$offset=5;
	if ($page=="")
		$page=1;
	else 
		$page=$_GET['p'];
	$page--;
	$bg=$pageSize*$page;		
	$sql = "SELECT * from #_place_ward $where order by id limit $bg,$pageSize";		
	$items=get_result($sql);
	$url_link='index.php?com=place&act=man_ward';		
}
function get_ward(){
	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_ward".$urlcu);	
	$item = get_fetch("select * from #_place_ward where id='".$id."'");
	if($item){

	}else{
	    transfer("Dữ liệu không có thực", "index.php?com=place&act=man_ward".$urlcu);
	} 	
}
function save_ward(){
	global $d,$urlcu;	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_ward".$urlcu);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){
		$id =  themdau($_POST['id']);					
		$data['id_city'] = (int)$_POST['id_city'];	
		$data['id_dist'] = (int)$_POST['id_dist'];	
		$data['ten'] = $_POST['name'];	
		$data['tenkhongdau'] = changeTitle($_POST['name']);			
		$data['stt'] = $_POST['num'];			
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;		
		$data['ngaysua'] = time();
		$d->setTable('place_ward');
		$d->setWhere('id', $id);
		if($d->update($data)){						
			// redirect("index.php?com=place&act=man_ward".$urlcu);
			redirect($_SESSION["links_re"]);
		}else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=place&act=man_ward".$urlcu);
	}else{
		$data['id_city'] = (int)$_POST['id_city'];
		$data['id_dist'] = (int)$_POST['id_dist'];		
		$data['ten'] = $_POST['name'];	
		$data['tenkhongdau'] = changeTitle($_POST['name']);	
		$data['stt'] = $_POST['num'];				
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('place_ward');
		if($d->insert($data))
		{		
			// redirect("index.php?com=place&act=man_ward".$urlcu);
			redirect($_SESSION["links_re"]);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=place&act=man_ward".$urlcu);
	}
}
function delete_ward(){
	global $d;
	if($_REQUEST['id_cat']!='')
	{ $id_catt="&id_cat=".$_REQUEST['id_cat'];
	}
	if($_REQUEST['curPage']!='')
	{ $id_catt.="&curPage=".$_REQUEST['curPage'];
	}
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);
		$d->reset();
		$d->setTable('place_ward');
		$d->setWhere('id',$id);
		if($d->delete() == false){
		  transfer("Xóa dữ liệu bị lỗi", "index.php?com=place&act=man_ward");
		}else{
			// redirect("index.php?com=place&act=man_ward".$id_catt."");
			redirect($_SESSION["links_re"]);
		}
	}else transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_ward");
}
#====================================
function get_streets(){
	global $d, $items, $url_link,$totalRows , $pageSize, $offset,$urlcu;
	if(!empty($_POST)){
		$multi=$_REQUEST['multi'];
		$id_array=$_POST['iddel'];
		$count=count($id_array);
		if($multi=='show'){
			for($i=0;$i<$count;$i++){
				$data = array();
				$data["hienthi"] = 1;
				$d->reset();
				$d->setTable("place_street");
				$d->setWhere("id", $id_array[$i]);
				if($d->update($data) == false){
					die("Not query sqlUPDATE_ORDER");
				}			
			}
			// redirect("index.php?com=place&act=man_street".$urlcu);
			redirect($_SESSION["links_re"]);			
		}
		if($multi=='hide'){
			for($i=0;$i<$count;$i++){
				$data = array();
				$data["hienthi"] = 0;
				$d->reset();
				$d->setTable("place_street");
				$d->setWhere("id", $id_array[$i]);
				if($d->update($data) == false){
					die("Not query sqlUPDATE_ORDER");
				}					
			}
			// redirect("index.php?com=place&act=man_street".$urlcu);
			redirect($_SESSION["links_re"]);			
		}
		if($multi=='del'){
			for($i=0;$i<$count;$i++){							
				$d->reset();
				$d->setTable('place_street');
				$d->setWhere('id',$id_array[$i]);
				if($d->delete() == false){
					die("Not query sqlUPDATE_ORDER");	
				}
			}
			// redirect("index.php?com=place&act=man_street".$urlcu);
			redirect($_SESSION["links_re"]);		
		}
	}
	#----------------------------------------------------------------------------------------
	if($_REQUEST['hienthi']!='')
	{
		$id_up = $_REQUEST['hienthi'];
		$d->reset();
		$d->setTable('place_street');
		$d->setWhere('id',$id_up);
		$d->select('id,hienthi');
		$cats= $d->fetch_array();

		$hienthi=$cats['hienthi'];
		if($hienthi==0)
		{
			$data = array();
			$data["hienthi"] = 1;
			$d->reset();
			$d->setTable("place_street");
			$d->setWhere($id, $id_up);
			if($d->update($data) == false){
				die("Not query sqlUPDATE_ORDER");
			}
		}
		else
		{
			$data = array();
			$data["hienthi"] = 0;
			$d->reset();
			$d->setTable("place_street");
			$d->setWhere($id, $id_up);
			if($d->update($data) == false){
				die("Not query sqlUPDATE_ORDER");
			}
		}	
	}
	#-------------------------------------------------------------------------------
	if($_REQUEST['id_city']!='')
	{
		$where.=" where id_city = '".$_REQUEST['id_city']."'";
	}
	if($_REQUEST['id_dist']!='')
	{
		$where.=" and id_dist = '".$_REQUEST['id_dist']."'";
	}	
	if($_REQUEST['id_ward']!='')
	{
		$where.=" and id_ward = '".$_REQUEST['id_ward']."'";
	}	
	if($_REQUEST['key']!='')
	{
		$where.=" where ten like '%".$_REQUEST['key']."%'";
	}
	$sql= "SELECT count(id) AS numrows FROM #_place_street $where";
	$d->query($sql);	
	$dem=$d->fetch_array();
	$totalRows=$dem['numrows'];
	$page=$_GET['p'];
	$pageSize=10;
	$offset=5;
	if ($page=="")
		$page=1;
	else 
		$page=$_GET['p'];
	$page--;
	$bg=$pageSize*$page;		
	$sql = "SELECT * from #_place_street $where order by id limit $bg,$pageSize";		
	$items=get_result($sql);
	$url_link='index.php?com=place&act=man_street'.$urlcu;
}
function get_street(){
	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_street");	
	$item = get_fetch("select * from #_place_street where id='".$id."'");
	if($item){

	}else{
	    transfer("Dữ liệu không có thực", "index.php?com=place&act=man_street");
	} 
}
function save_street(){
	global $d,$urlcu;	
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_street".$urlcu);
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	if($id){
		$id =  themdau($_POST['id']);					
		$data['id_city'] = (int)$_POST['id_city'];	
		$data['id_dist'] = (int)$_POST['id_dist'];	
		$data['id_ward'] = (int)$_POST['id_ward'];	
		$data['ten'] = $_POST['name'];	
		$data['tenkhongdau'] = changeTitle($_POST['name']);			
		$data['stt'] = $_POST['num'];			
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;		
		$data['ngaysua'] = time();
		$d->setTable('place_street');
		$d->setWhere('id', $id);
		if($d->update($data)){						
			// redirect("index.php?com=place&act=man_street".$urlcu);
			redirect($_SESSION["links_re"]);
		}else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=place&act=man_street".$urlcu);
	}else{
		$data['id_city'] = (int)$_POST['id_city'];
		$data['id_dist'] = (int)$_POST['id_dist'];	
		$data['id_ward'] = (int)$_POST['id_ward'];		
		$data['ten'] = $_POST['name'];	
		$data['tenkhongdau'] = changeTitle($_POST['name']);	
		$data['stt'] = $_POST['num'];				
		$data['hienthi'] = isset($_POST['active']) ? 1 : 0;
		$data['ngaytao'] = time();
		$d->setTable('place_street');
		if($d->insert($data))
		{		
			// redirect("index.php?com=place&act=man_street".$urlcu);
			redirect($_SESSION["links_re"]);
		}
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=place&act=man_street".$urlcu);
	}
}
function delete_street(){
	global $d;
	if($_REQUEST['id_cat']!='')
	{ 
		$id_catt="&id_cat=".$_REQUEST['id_cat'];
	}
	if($_REQUEST['curPage']!='')
	{ 
		$id_catt.="&curPage=".$_REQUEST['curPage'];
	}
	if(isset($_GET['id'])){
		$id =  themdau($_GET['id']);
		$d->reset();
		$d->setTable('place_street');
		$d->setWhere('id',$id);
		if($d->delete() == false){
		  transfer("Xóa dữ liệu bị lỗi", "index.php?com=place&act=man_street");
		}else{
			// redirect("index.php?com=place&act=man_street".$id_catt."");
			redirect($_SESSION["links_re"]);
		}
	}else transfer("Không nhận được dữ liệu", "index.php?com=place&act=man_street");
}
?>