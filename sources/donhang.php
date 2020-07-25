<?php	if(!defined('_source')) die("Error");
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
$id=$_REQUEST['id'];
switch($act){
	case "man":
	get_items();
	$template = "donhang/items";
	break;
	case "add":		
	$template = "donhang/item_add";
	break;
	case "edit":		
	get_item();
	$template = "donhang/item_add";
	break;
	case "save":
	save_item();
	break;
	case "delete":
	delete_item();
	break;	
	case "exportkhachhang":
	exportkhachhang();
	break;	
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
function get_items(){
	global $d, $items, $paging;
	$where=" where id<> 0 "; 
	if($_GET["ngaybd"]!=''){
		$ngaybatdau = $_GET["ngaybd"];		
	$Ngay_arr = explode("/",$ngaybatdau); // array(17,11,2010)
	if (count($Ngay_arr)==3) {
		$ngay = $Ngay_arr[0]; //17
		$thang = $Ngay_arr[1]; //11
		$nam = $Ngay_arr[2]; //2010
		if (checkdate($thang,$ngay,$nam)==false){ $coloi=true; $error_ngaysinh = "Bạn nhập chưa đúng ngày sinh<br>";} else $ngaybatdau=$nam."-".$thang."-".$ngay;
	}	
	$where.=" and ngaytao>=".strtotime($ngaybatdau)." ";
}
if($_GET["ngaykt"]!=''){
	$ngayketthuc = $_GET["ngaykt"];		
	$Ngay_arr = explode("/",$ngayketthuc); // array(17,11,2010)
	if (count($Ngay_arr)==3) {
		$ngay = $Ngay_arr[0]; //17
		$thang = $Ngay_arr[1]; //11
		$nam = $Ngay_arr[2]; //2010
		if (checkdate($thang,$ngay,$nam)==false){ $coloi=true; $error_ngaysinh = "Bạn nhập chưa đúng ngày sinh<br>";} else $ngayketthuc=$nam."-".$thang."-".$ngay;
	}	
	$where.=" and ngaytao<=".strtotime($ngayketthuc)." ";
}
if($_GET["keyword"]!=''){
	$where.=" and (madonhang like '%".$_GET["keyword"]."%' or hoten like '%".$_GET["keyword"]."%' )  ";
}
	//sotien
if($_GET["sotien"]!='' && $_GET["sotien"]>0){
	$sql="select giatu,giaden from #_giasearch where id='".$_GET["sotien"]."'";
	$d->query($sql);
	$giatim=$d->fetch_array();
	if($giatim!=null){
		$where.=" and tonggia>=".$giatim['giatu']." and tonggia<=".$giatim['giaden']." ";			
	}
}
	//httt
if($_GET["httt"] > 0){
	$where.=" and httt=".$_GET["httt"]." ";
}
	//tinhtrang
if($_GET["tinhtrang"]>0){
	$where.=" and tinhtrang=".$_GET["tinhtrang"]." ";
}
if($_REQUEST['hoten']!='')
{
	$where.=" and (hoten like '%".$_REQUEST['hoten']."%')";
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
if($_REQUEST['nhanvien']!='')
{
	$where.=" and (nhanvien like '%".$_REQUEST['nhanvien']."%')";
}
if($_REQUEST['nguoithu']!='')
{
	$where.=" and (nguoithu like '%".$_REQUEST['nguoithu']."%')";
}
$sql = "select * from #_donhang $where";	
$sql.=" order by id desc";
$d->query($sql);
$items = $d->result_array();
$curPage = isset($_GET['curPage']) ? $_GET['curPage'] : 1;
$url="index.php?com=order&act=man&tinhtrang=".$_GET['tinhtrang']."&ngaytao=".$_GET['ngaytao']."&ngayin=".$_REQUEST['ngayin']."&hinhthucgiaohang=".$_GET['hinhthucgiaohang'];
$maxR=20;
$maxP=20;
$paging=paging($items, $url, $curPage, $maxR, $maxP);
$items=$paging['source'];
}
function get_item(){
	global $d, $item;
	$id = isset($_GET['id']) ? themdau($_GET['id']) : "";
	if(!$id)
		transfer("Không nhận được dữ liệu", "index.php?com=order&act=man");
	$sql = "select * from #_donhang where id='".$id."'";
	$d->query($sql);
	if($d->num_rows()==0) transfer("Dữ liệu không có thực", "index.php?com=order&act=man");
	$item = $d->fetch_array();	
}
function save_item(){
	global $d;
	$file_name=fns_Rand_digit(0,9,12);
	if(empty($_POST)) transfer("Không nhận được dữ liệu", "index.php?com=order&act=man");
	$id = isset($_POST['id']) ? themdau($_POST['id']) : "";
	$data['ngaydangky'] = $_POST['ngaydangky'];
	$data['hoten'] = (string)magic_quote(trim(strip_tags($_POST['hoten'])));
	$data['dienthoai'] = $_POST['dienthoai'];
	$data['diachi'] = $_POST['diachi'];
	$data['email'] = $_POST['email'];
	$data['nhanvien'] = (string)magic_quote(trim(strip_tags($_POST['nhanvien'])));
	$data['gia'] = $_POST['gia'];
	$data['member'] = $_POST['member'];
	$data['hansudung'] = strtotime($_POST['hansudung']);
	$data['tinhtrang'] = $_POST['tinhtrang'];
	$data['httt'] = $_POST['httt'];
	$data['ngaythanhtoan'] = strtotime($_POST['ngaythanhtoan']);
	$data['nguoithu'] = (string)magic_quote(trim(strip_tags($_POST['nguoithu'])));
	$data['ghichu'] = $_POST['ghichu'];
	if($id){
		$data['ngaysua'] = time();
		$d->setTable('donhang');
		$d->setWhere('id', $id);
		if($d->update($data)){
			// redirect("index.php?com=order&act=man&curPage=".$_REQUEST['curPage']."");
			redirect($_SESSION["links_re"]);
		}
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=order&act=man");
	}else{
		$data['ngaytao'] = time();
		$d->setTable('donhang');
		if($d->insert($data))
			redirect($_SESSION["links_re"]);
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=order&act=man");
	}
}
function delete_item(){
	global $d;
	if(isset($_GET['id']))
	{
		$id =  themdau($_GET['id']);
		$d->reset();
		$d->setTable('donhang');
		$d->setWhere('id',$id);
		if($d->delete())
		{					
			redirect($_SESSION["links_re"]);
		}
		else
			transfer("Xóa dữ liệu bị lỗi", "index.php?com=order&act=man");
	}
	elseif (isset($_GET['listid'])==true)
	{
		$listid = explode(",",$_GET['listid']); 
		for ($i=0 ; $i<count($listid) ; $i++)
		{
			$idTin = $listid[$i]; 
			$id =  themdau($idTin);		
			$d->reset();
			$d->setTable('donhang');
			$d->setWhere('id',$id);
			$d->delete();
		} 
		redirect($_SESSION["links_re"]);
	}
	else transfer("Không nhận được dữ liệu", "index.php?com=order&act=man");
}
function exportkhachhang(){
	global $d,$items;
		$where=" where id<> 0 "; 
		if($_GET["ngaybd"]!=''){
			$ngaybatdau = $_GET["ngaybd"];		
		$Ngay_arr = explode("/",$ngaybatdau); // array(17,11,2010)
		if (count($Ngay_arr)==3) {
			$ngay = $Ngay_arr[0]; //17
			$thang = $Ngay_arr[1]; //11
			$nam = $Ngay_arr[2]; //2010
			if (checkdate($thang,$ngay,$nam)==false){ $coloi=true; $error_ngaysinh = "Bạn nhập chưa đúng ngày sinh<br>";} else $ngaybatdau=$nam."-".$thang."-".$ngay;
		}	
		$where.=" and ngaytao>=".strtotime($ngaybatdau)." ";
	}
	if($_GET["ngaykt"]!=''){
		$ngayketthuc = $_GET["ngaykt"];		
		$Ngay_arr = explode("/",$ngayketthuc); // array(17,11,2010)
		if (count($Ngay_arr)==3) {
			$ngay = $Ngay_arr[0]; //17
			$thang = $Ngay_arr[1]; //11
			$nam = $Ngay_arr[2]; //2010
			if (checkdate($thang,$ngay,$nam)==false){ $coloi=true; $error_ngaysinh = "Bạn nhập chưa đúng ngày sinh<br>";} else $ngayketthuc=$nam."-".$thang."-".$ngay;
		}	
		$where.=" and ngaytao<=".strtotime($ngayketthuc)." ";
	}
	if($_GET["keyword"]!=''){
		$where.=" and (madonhang like '%".$_GET["keyword"]."%' or hoten like '%".$_GET["keyword"]."%' )  ";
	}
		//sotien
	if($_GET["sotien"]!='' && $_GET["sotien"]>0){
		$sql="select giatu,giaden from #_giasearch where id='".$_GET["sotien"]."'";
		$d->query($sql);
		$giatim=$d->fetch_array();
		if($giatim!=null){
			$where.=" and tonggia>=".$giatim['giatu']." and tonggia<=".$giatim['giaden']." ";			
		}
	}
		//httt
	if($_GET["httt"] > 0){
		$where.=" and httt=".$_GET["httt"]." ";
	}
		//tinhtrang
	if($_GET["tinhtrang"]>0){
		$where.=" and tinhtrang=".$_GET["tinhtrang"]." ";
	}
	if($_REQUEST['hoten']!='')
	{
		$where.=" and (hoten like '%".$_REQUEST['hoten']."%')";
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
	if($_REQUEST['nhanvien']!='')
	{
		$where.=" and (nhanvien like '%".$_REQUEST['nhanvien']."%')";
	}
	if($_REQUEST['nguoithu']!='')
	{
		$where.=" and (nguoithu like '%".$_REQUEST['nguoithu']."%')";
	}
	$sql = "select * from #_donhang $where";	
	$sql.=" order by id desc";
	$d->query($sql);
	$items = $d->result_array();
	$spreadsheet = new Spreadsheet();
	// Set document properties
	$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
	    ->setLastModifiedBy('Maarten Balliauw')
	    ->setTitle('Office 2007 XLSX')
	    ->setSubject('Office 2007 XLSX')
	    ->setDescription('Office 2007 XLSX, generated using PHP classes.')
	    ->setKeywords('office 2007 openxml php')
	    ->setCategory('Output file');
	$sheet = $spreadsheet->getActiveSheet();
	//set styles
	$stylemainArray = [
	    'font' => [
	        'bold' => true,
	        'size' => 20,
	        'color' => ['argb' => 'FFFFFFFF'],
	    ],
	    'alignment' => [
	        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
	    ],
	    'fill' => [
	        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
	        'startColor' => [
	            'argb' => 'FF0000FF',
	        ],
	    ],
	    
	];
	$styletongArray = [
	    'font' => [
	        'bold' => true,
	        'size' => 14,
	        'color' => ['argb' => 'FFFFFFFF'],
	    ],
	    'alignment' => [
	        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
	        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
	    ],
	    'fill' => [
	        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
	        'startColor' => [
	            'argb' => 'FFFF0000',
	        ],
	    ],
	    
	];
	$styleheaderArray = [
	    'font' => [
	        'bold' => true,
	        'size' => 14,
	        'color' => ['argb' => 'FFFFFFFF'],
	    ],
	    'alignment' => [
	        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
	        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
	    ],
	    'fill' => [
	        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
	        'startColor' => [
	            'rgb' => '996600',
	        ],
	    ],
	    'borders' => [
	        'allBorders' => [
	            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
	            'color' => ['argb' => '00000000'],
	        ],
	    ],
	];
	$styleborderArray = [
	    'borders' => [
	  		'allBorders' => [
	            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
	            'color' => ['argb' => '00000000'],
	        ]
	   	 ]
	];
	$sheet->getStyle('A1:N1')->applyFromArray($stylemainArray);
	$sheet->getStyle('A2:N2')->applyFromArray($styleheaderArray);
	foreach(range('A','N') as $columnID) {
	    $sheet->getColumnDimension($columnID)->setAutoSize(true);
	}
	//set data

	$sheet->mergeCells('A1:N1')->setCellValue('A1', 'QUẢN LÝ HOẠT ĐỘNG VÀ BÁO CÁO CÔNG TY GEMMA TRAVEL');
	$sheet->setCellValue('A2', 'STT');
	$sheet->setCellValue('B2', 'HỌ VÀ TÊN');
	$sheet->setCellValue('C2', 'EMAIL');
	$sheet->setCellValue('D2', 'SỐ ĐIỆN THOẠI');
	$sheet->setCellValue('E2', 'ĐỊA CHỈ');
	$sheet->setCellValue('F2', 'MEMBER');
	$sheet->setCellValue('G2', 'HẠN SỬ DỤNG THẺ');
	$sheet->setCellValue('H2', 'GIÁ TRỊ THẺ');
	$sheet->setCellValue('I2', 'NHÂN VIÊN KINH DOANH');
	$sheet->setCellValue('J2', 'HÌNH THỨC THANH TOÁN');
	$sheet->setCellValue('K2', 'NGÀY THANH TOÁN');
	$sheet->setCellValue('L2', 'NGƯỜI THU PHÍ');
	$sheet->setCellValue('M2', 'TÌNH TRẠNG');
	$sheet->setCellValue('N2', 'GHI CHÚ');
	// set data detail
	$vitri = 3;
	foreach($items as $k=>$v) {
		$d->reset();
		$sql="select ten from table_httt where id = '".$v["httt"]."'";
		$d->query($sql);
		$httt = $d->fetch_array();   

		$d->reset();
		$sql="select trangthai from #_tinhtrang where id = '".$v["tinhtrang"]."'";
		$d->query($sql);
		$tinhtrang = $d->fetch_array();

		$sheet->setCellValue('A'.$vitri, $k+1);
		$sheet->setCellValue('B'.$vitri, $v["hoten"]);
		$sheet->setCellValue('C'.$vitri, $v["email"]);
		$sheet->setCellValue('D'.$vitri, $v["dienthoai"]);
		$sheet->setCellValue('E'.$vitri, $v["diachi"]);
		$sheet->setCellValue('F'.$vitri, $v["member"]);
		$sheet->setCellValue('G'.$vitri, date("d/m/Y",$v["hansudung"]));
		$sheet->setCellValue('H'.$vitri, $v["gia"]);
		$sheet->setCellValue('I'.$vitri, $v["nhanvien"]);
		$sheet->setCellValue('J'.$vitri, $httt["ten"]);
		$sheet->setCellValue('K'.$vitri, date("d/m/Y",$v["ngaythanhtoan"]));
		$sheet->setCellValue('L'.$vitri, $v["nguoithu"]);
		$sheet->setCellValue('M'.$vitri, $tinhtrang["trangthai"]);
		$sheet->setCellValue('N'.$vitri, $v["ghichu"]);
		$sheet->getStyle('A'.$vitri.':'.'N'.$vitri)->applyFromArray($styleborderArray);
		$vitri++;
	}

	$sheet->setCellValue('A'.$vitri, '');
	$sheet->setCellValue('B'.$vitri, '');
	$sheet->setCellValue('C'.$vitri, '');
	$sheet->setCellValue('D'.$vitri, '');
	$sheet->setCellValue('E'.$vitri, '');
	$sheet->setCellValue('F'.$vitri, '');
	$sheet->setCellValue('G'.$vitri, '');
	$sheet->setCellValue('H'.$vitri, '');
	$sheet->setCellValue('I'.$vitri, '');
	$sheet->setCellValue('J'.$vitri, '');
	$sheet->setCellValue('K'.$vitri, '');
	$sheet->setCellValue('L'.$vitri, '');
	$sheet->setCellValue('M'.$vitri, '');
	$sheet->setCellValue('N'.$vitri, '');
	$vitri++;
	$sheet->getStyle('G'.$vitri)->applyFromArray($styletongArray);
	$sheet->setCellValue('G'.$vitri, 'TỔNG GIÁ TRỊ');
	$sheet->setCellValue('H'.$vitri,'=SUM(H3:H'.($vitri - 2).')');
	//set output
	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="quanlykhachhang.xlsx"');
	header('Cache-Control: max-age=0');
	$writer->save("php://output");
	exit;
}
