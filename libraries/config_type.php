<?php
$type = (string)(isset($_REQUEST['type'])) ? addslashes($_REQUEST['type']) : "";
$act = (string)(isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
$act = explode('_',$act);
if(count($act>1)){
	$act = $act[1];
} else {
	$act = $act[0];
}

$config['type'] = array();
$config['title'] = array();
$config['ck'] = array();
@define ( _ext_thumb , '' );
switch($type){
//-------------san pham------------------
	case 'dichvu':
	switch($act){
		case 'danhmuc':
		$config['type'] = array('ten');
		$config['title'] = array('noibat'=>"Nổi bật",'tieubieu'=>"Hiện menu",'hinhanh2'=>"Icon");
		@define ( _width_thumb , 350 );
		@define ( _height_thumb , 590 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 350 );
		@define ( _height_thumb2 , 590 );
		@define ( _widthhinhanh_thumb , 40 );
		@define ( _heighthinhanh_thumb , 40 );
		@define ( _stylehinhanh_thumb , 2 );
		@define ( _widthhinhanh_thumb2 , 40 );
		@define ( _heighthinhanh_thumb2 , 40 );
		break;

		case 'list':
		$config['type'] = array('seo','ten');
		$config['title'] = array('noibat'=>"Nổi bật");
		@define ( _width_thumb , 250 );
		@define ( _height_thumb , 560 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 250 );
		@define ( _height_thumb2 , 560 );
		break;

		case 'cat':
		$config['type'] = array('seo','ten');
		@define ( _width_thumb , 250 );
		@define ( _height_thumb , 200 );
		@define ( _style_thumb , 1 );
		break;

		default:
		$config['type'] = array('ten',"mota","danhmuc");
		$config['ck'] = array('mota2');
		$config['title'] = array('tieubieu'=>"Khuyến mãi",'noibat'=>"Nổi bật",
			'spmoi'=>"Mới nhất",'spbanchay'=>"Bán chạy","toado"=>"Iframe google map",
			"mota2"=>"Thông số","mota"=>"Ghi chú",'mattien'=>"Phòng ngủ","dientich"=>"Diện tích","thuonghieu"=>"Thương hiệu",
			"vitri"=>"Giá bằng chữ");
		@define ( _width_thumb , 600 );
		@define ( _height_thumb , 400 );
		@define ( _style_thumb , 2 );
		@define ( _width_thumb2 , 600 );
		@define ( _height_thumb2 , 400 );
		break;
	}
	break;
//-------------san pham------------------
	case 'mausac':
	switch($act){
		default:
		$config['type'] = array('ten','color');
		$config['title']["noibat"] = "Dùng hình ảnh";
		@define ( _width_thumb , 200 );
		@define ( _height_thumb , 200 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 200 );
		@define ( _height_thumb2 , 200 );
		break;
	}
	break;
	case 'size':
	switch($act){
		default:
		$config['type'] = array('ten');
		@define ( _width_thumb , 400 );
		@define ( _height_thumb , 300 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 400 );
		@define ( _height_thumb2 , 300 );
		break;
	}
	break;
	case 'coupon':
	switch($act){
		default:
		$config['type'] = array('ten','gia');
		break;
	}
	break;
	case 'id_hientrang':
	case 'id_huong':
	switch($act){
		default:
		$config['type'] = array('ten');
		break;
	}
	break;
	case 'id_khoanggia':
	switch($act){
		default:
		$config['type'] = array('ten','chucvu','link');
		$config['title'] = array('chucvu'=>"Giá từ",'link'=>"Giá đến");
		break;
	}
	break;
	case 'tailieu':
	switch($act){
		default:
		$config['type'] = array('seo','taptin','ten','mota');
		break;
	}
	break;
	case 'bntrong':
	switch($act){
		default:
		$config['type'] = array('hinhanh','ten');
		@define ( _width_thumb , 1366 );
		@define ( _height_thumb , 300 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 1366 );
		@define ( _height_thumb2 , 300 );
		break;
	}
	break;
	case 'thuonghieu':
	switch($act){
		default:
		$config['type'] = array('hinhanh2', 'hinhanh','ten','seo');
		$config['title'] = array('hinhanh2'=>'Icon', 'hinhanh'=>'Hình ảnh');
		@define ( _width_thumb , 590 );
		@define ( _height_thumb , 480 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 590 );
		@define ( _height_thumb2 , 480 );
		@define ( _width_thumb4 , 145 );
		@define ( _height_thumb4 , 110 );
		break;
	}
	break;
	case 'tin-tuc':
	switch($act){
		case 'danhmuc':
		$config['type'] = array('seo','ten');
		break;
		default:
		$config['type'] = array('seo','ten','noidung','mota','hinhanh');
		if($type == "tin-tuc"){
			$config['type'][] = 'noibat';
		}
		@define ( _width_thumb , 375 );
		@define ( _height_thumb , 290 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 375);
		@define ( _height_thumb2 , 290 );
		break;
	}
	break;
	case 'txtnewsletter':
	case 'txttin-tuc':
	switch($act){
		default:
		$config['type'] = array('mota');
		break;
	}
	break;
	case 'tieu-chi':
	switch($act){
		default:
		$config['type'] = array('ten','mota','hinhanh');
		@define ( _width_thumb , 60 );
		@define ( _height_thumb , 60 );
		@define ( _style_thumb , 2 );
		@define ( _width_thumb2 , 60);
		@define ( _height_thumb2 , 60 );
		break;
	}
	break;
	case 'y-kien':
	switch($act){
		default:
		$config['type'] = array('ten','mota','hinhanh','chucvu');
		@define ( _width_thumb , 120 );
		@define ( _height_thumb , 120 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 120);
		@define ( _height_thumb2 , 120 );
		break;
	}
	break;
	case 'loc-san-pham':
	switch($act){
		case 'danhmuc':
		$config['type'] = array('ten');
		break;
		default:
		$config['type'] = array('ten','danhmuc');
		break;
	}
	break;
	case 'hotline':
	case 'zalo':
	switch($act){
		default:
		$config['type'] = array('ten','link');
		$config['title'] = array('link'=>"SĐT",'chucvu'=>"Bộ phận");
		break;
	}
	break;
	case 'diachi':
	switch($act){
		default:
		$config['type'] = array('ten','ten2','mota');
		$config['title'] = array('mota'=>"Iframe bản đồ",'link'=>'Link bản đồ',
			'ten2'=>'Địa chỉ','chucvu'=>'Email');
		@define ( _width_thumb , 200 );
		@define ( _height_thumb , 180 );
		@define ( _style_thumb , 2 );
		@define ( _width_thumb2 , 200 );
		@define ( _height_thumb2 , 180 );
		break;
	}
	break;
	case 'link-san-pham':
	case 'tags':
	switch($act){
		default:
		$config['type'] = array('ten', 'link');
		break;
	}
	break;
//-------------tin tuc------------------
	case 'chinh-sach':
	switch($act){
		default:
		$config['type'] = array('seo','ten','noidung');
		break;
	}
	break;
	case 'thong-tin':
	switch($act){
		default:
		$config['type'] = array('seo','ten','hinhanh','noidung');
		@define ( _width_thumb , 70 );
		@define ( _height_thumb , 70 );
		@define ( _style_thumb , 2 );
		@define ( _width_thumb2 , 70 );
		@define ( _height_thumb2 , 70 );
		break;
	}
	break;
	case 'thu-vien':
	switch($act){
		case 'danhmuc':
		$config['type'] = array('seo','ten');
		@define ( _width_thumb , 430 );
		@define ( _height_thumb , 430 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 600);
		@define ( _height_thumb2 , 600 );
		break;
		default:
		$config['type'] = array('ten','seo','hinhthem','hinhanh','noibat');
		@define ( _width_thumb , 450 );
		@define ( _height_thumb , 320 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 600 );
		@define ( _height_thumb2 , 430 );
		break;
	}
	break;
	case 'txtthu-vien':
	switch($act){
		default:
		$config['type'] = array('mota');
		@define ( _width_thumb , 680 );
		@define ( _height_thumb , 750 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 680 );
		@define ( _height_thumb2 , 750 );
		break;
	}
	break;
//-------------chinh sach / ho tro / cham soc khach hang------------------
	case 'ho-tro1':
	switch($act){
		default:
		$config['type'] = array('ten','hinhanh','mota');
		$config['title'] = array('mota'=>'Nội dung');
		@define ( _style_thumb , 3 );
		@define ( _width_thumb2 , 30 );
		@define ( _height_thumb2 , 30 );
		break;
	}
	break;

//-------------tin tuc------------------
//-------------Dạng photo------------------
	case 'logo':
	switch($act){
		default:
		// $config['type'] = array('ten','mota');
		$config['title'] = array('mota'=>'Tiêu đề nhỏ');
		@define ( _width_thumb , 140 );
		@define ( _height_thumb , 140);
		@define ( _style_thumb , 3 );
		@define ( _width_thumb2 , 140 );
		@define ( _height_thumb2 , 140 );
		break;
	}
	break;
	case 'dong':
	switch($act){
		default:
		@define ( _width_thumb , 100 );
		@define ( _height_thumb , 100 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 250 );
		@define ( _height_thumb2 , 250 );
		break;
	}
	break;
	case 'banner':
	switch($act){
		default:
		@define ( _width_thumb , 390 );
		@define ( _height_thumb , 50);
		@define ( _style_thumb , 2 );
		@define ( _width_thumb2 , 390 );
		@define ( _height_thumb2 , 50 );
		break;
	}
	break;
	case 'bgbn':
	switch($act){
		default:
		@define ( _width_thumb , 1366 );
		@define ( _height_thumb , 150 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 1366 );
		@define ( _height_thumb2 , 150 );
		break;
	}
	break;
	case 'bgft':
	switch($act){
		default:
		@define ( _width_thumb , 700 );
		@define ( _height_thumb , 500 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 700 );
		@define ( _height_thumb2 , 500 );
		break;
	}
	break;
	case 'banner_mobi':
	switch($act){
		default:
		@define ( _width_thumb , 600 );
		@define ( _height_thumb , 150 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 600 );
		@define ( _height_thumb2 , 150 );
		break;
	}
	break;
	case 'pupop':
	switch($act){
		default:
		@define ( _width_thumb2 , 550 );
		@define ( _height_thumb2 , 480 );
		@define ( _style_thumb2 , 1 );
		break;
	}
	break;
	case 'slider':
	switch($act){
		default:
		@define ( _width_thumb , 920 );
		@define ( _height_thumb , 420);
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 920 );
		@define ( _height_thumb2 , 420);
		break;
	}
	break;
	case 'slidermb':
	switch($act){
		default:
		@define ( _width_thumb , 768 );
		@define ( _height_thumb , 300);
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 768 );
		@define ( _height_thumb2 , 300);
		break;
	}
	break;
	case 'letruot':
	switch($act){
		default:
		@define ( _width_thumb , 150 );
		@define ( _height_thumb , 390 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 150 );
		@define ( _height_thumb2 , 390 );
		break;
	}
	break;
	case 'doi-tac':
	switch($act){
		default:
		@define ( _width_thumb , 200 );
		@define ( _height_thumb , 130 );
		@define ( _style_thumb , 2 );
		@define ( _width_thumb2 , 200 );
		@define ( _height_thumb2 , 130 );
		break;
	}
	break;
	case 'quang-cao':
	switch($act){
		default:
		@define ( _width_thumb , 590 );
		@define ( _height_thumb , 210 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 590 );
		@define ( _height_thumb2 , 210 );
		break;
	}
	break;
	case 'quang-cao2':
	switch($act){
		default:
		@define ( _width_thumb , 350 );
		@define ( _height_thumb , 560 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 350 );
		@define ( _height_thumb2 , 560 );
		break;
	}
	break;
//-------------Dạng 1 bài viết------------------
	case 'gioi-thieu':
	case 'huong-dan-mua-hang':
	switch($act){
		default:
		$config['type'] = array('seo','noidung');
		break;
	}
	break;
	case 'video':
	switch($act){
		default:
		// $config['type'] = array('hinhanh');
		@define ( _width_thumb , 425 );
		@define ( _height_thumb , 340 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 600 );
		@define ( _height_thumb2 , 480 );
		break;
	}
	break;
	case 'txtvideo':
	case 'txtban-chay':
	switch($act){
		default:
		$config['type'] = array('mota');
		$config['title'] = array('ten2'=>'Tiêu để nhỏ');
		@define ( _width_thumb , 585 );
		@define ( _height_thumb , 400 );
		@define ( _style_thumb , 1 );
		@define ( _width_thumb2 , 585 );
		@define ( _height_thumb2 , 400 );
		break;
	}
	break;
	
	case 'lienhe':
	switch($act){
		default:
		$config['type'] = array('noidung');
		break;
	}
	break;
	case 'footer':
	case 'footer2':
	switch($act){
		default:
		$config['type'] = array('noidung');
		@define ( _width_thumb , 490 );
		@define ( _height_thumb , 50);
		@define ( _style_thumb , 2 );
		@define ( _width_thumb2 , 490 );
		@define ( _height_thumb2 , 50 );
		break;
	}
	break;
//-------------tin tuc------------------

//--------------defaut main---------------
	default:
	$source = "";
	$template = "index";
	break;
}