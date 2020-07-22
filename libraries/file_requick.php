<?php
$com = (string)(isset($_REQUEST['com'])) ? addslashes($_REQUEST['com']) : "";
$act = (string)(isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

$d = new database($config['database']);
	#Thông tin công ty
$company= get_fetch("select *,ten$lang as ten,diachi$lang as diachi,slogan$lang as slogan from #_company limit 0,1");
$thuoctinh = json_decode($company["thuoctinh"],true);
$datacom = array(
	array("tbl"=>"product_danhmuc","field"=>"id_danhmuc","source"=>"product","type"=>"san-pham","com"=>"san-pham"),
	array("tbl"=>"product_list","field"=>"id_list","source"=>"product","type"=>"san-pham","com"=>"san-pham"),
	// array("tbl"=>"product_cat","field"=>"id_cat","source"=>"product","type"=>"san-pham","com"=>"san-pham"),
	array("tbl"=>"product","field"=>"id","source"=>"product","type"=>"san-pham","com"=>"san-pham"),

	// array("tbl"=>"news_danhmuc","field"=>"id_danhmuc","source"=>"news","type"=>"cokhi","com"=>"co-khi"),
	// array("tbl"=>"news_list","field"=>"id_list","source"=>"news","type"=>"cokhi","com"=>"co-khi"),
	// array("tbl"=>"news_cat","field"=>"id_cat","source"=>"news","type"=>"cokhi","com"=>"co-khi"),
	// array("tbl"=>"news","field"=>"id","source"=>"news","type"=>"cokhi","com"=>"co-khi"),

	array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"tin-tuc","type"=>"tin-tuc"),
	array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"huong-dan","type"=>"huong-dan"),
	array("tbl"=>"news","field"=>"id","source"=>"news","com"=>"chinh-sach","type"=>"chinh-sach"),
	array("tbl"=>"about","field"=>"id","source"=>"about","com"=>"lien-he","type"=>"lienhe"),
	array("tbl"=>"about","field"=>"id","source"=>"about","com"=>"gioi-thieu","type"=>"gioi-thieu"),
	array("tbl"=>"about","field"=>"id","source"=>"about","com"=>"huong-dan-mua-hang","type"=>"huong-dan-mua-hang"),
);
// if($com){
// 	foreach($datacom as $k=>$v){
// 		if(isset($com) && $v['tbl']!='info'){
// 			$d->query("select id from #_".$v['tbl']." where tenkhongdau='".$com."' and type='".$v['type']."' and hienthi=1");
			
// 			if($d->num_rows()>=1){
// 				$row = $d->fetch_array();
// 				$_GET[$v['field']] = $row['id'];
// 				$com = $v['com'];	
// 				break;
// 			}
// 		}
// 	}
// }
switch($com)
{
	case 'sitemap':
	$type = "sitemap";
	$title = "Sitemap";
	$title_cat = "Sitemap";
	$template = "sitemap";
	break;
	case 'tags':
	$type = "tags";
	$title = "Tags";
	$title_cat = "Tags";
	$template = "tags";
	break;
	case 'lien-he':
	case 'contact':
	$type = "lienhe";
	$title = _lienhe;
	$title_cat = _lienhe;
	$source = "contact";
	$template = "contact";
	break;
	case 'tin-tuc':
	$type = "tin-tuc";
	$title = _tintuc;
	$title_cat = _tintuc;
	$title_other = _tinlienquan;
	$source = "news";
	$template = isset($_GET['id']) ? "news_detail" : "news";
	$type_og = isset($_GET['id']) ? "article" : "object";
	break;
	case 'tuyen-dung':
	$type = "tuyen-dung";
	$title = _tuyendung;
	$title_cat = _tuyendung;
	$title_other = _tinlienquan;
	$source = "news";
	$template = isset($_GET['id']) ? "news_detail" : "news";
	$type_og = isset($_GET['id']) ? "article" : "object";
	break;
	case 'ky-gui':
	$type = "ky-gui";
	$title = "Ký gửi";
	$title_cat = "Ký gửi";
	$title_other = _tinlienquan;
	$source = "news";
	$template = isset($_GET['id']) ? "news_detail" : "news";
	$type_og = isset($_GET['id']) ? "article" : "object";
	break;
	case 'xay-dung':
	$type = "xay-dung";
	$title = "Xây dựng sửa chữa";
	$title_cat = "Xây dựng sửa chữa";
	$title_other = _tinlienquan;
	$source = "news";
	$template = isset($_GET['id']) ? "news_detail" : "news";
	$type_og = isset($_GET['id']) ? "article" : "object";
	break;
	case 'tu-van':
	$type = "tu-van";
	$title = "Tư vấn thiết kế";
	$title_cat = "Tư vấn thiết kế";
	$title_other = _tinlienquan;
	$source = "news";
	$template = isset($_GET['id']) ? "news_detail" : "news";
	$type_og = isset($_GET['id']) ? "article" : "object";
	break;
	case 'dich-vu':
	$type = "dich-vu";
	$title = _dichvu;
	$title_cat = _dichvu;
	$title_other = _tinlienquan;
	$source = "news";
	$template = isset($_GET['id']) ? "news_detail" : "news";
	$type_og = isset($_GET['id']) ? "article" : "object";
	break;
	case 'chinh-sach':
	$type = "chinh-sach";
	$title = _chinhsach;
	$title_cat = _chinhsach;
	$title_other = _tinlienquan;
	$source = "news";
	$template = isset($_GET['id']) ? "news_detail" : "news";
	$type_og = isset($_GET['id']) ? "article" : "object";
	break;
	// case 'chi-nhanh':
	// $type = "diachi";
	// $title = "Chi nhánh";
	// $title_cat = "Chi nhánh";
	// $title_other = _tinlienquan;
	// $source = "news";
	// $template = isset($_GET['id']) ? "hethong_detail" : "hethong";
	// $type_og = isset($_GET['id']) ? "article" : "object";
	// break;
	case 'thu-vien':
	$type = "thu-vien";
	$title = "Album";
	$title_cat = "Album";
	$title_other = _tinlienquan;
	$source = "news";
	$template = isset($_GET['id']) ? "thuvien_detail" : "thuvien";
	$type_og = isset($_GET['id']) ? "article" : "object";
	break;
	case 'gioi-thieu':
	$type = "gioi-thieu";
	$title = _gioithieu;
	$title_cat = _gioithieu;
	$title_other = _tinlienquan;
	$source = "about";
	$template = "about";
	$type_og = "article";
	break;
	case 'huong-dan-mua-hang':
	$type = "huong-dan-mua-hang";
	$title = "Hướng dẫn mua hàng";
	$title_cat = "Hướng dẫn mua hàng";
	$title_other = _tinlienquan;
	$source = "about";
	$template = "about";
	$type_og = "article";
	break;
	case 'tim-kiem':
	$type = "san-pham";
	$title = _ketquatimkiem;
	$title_cat = _ketquatimkiem;
	$source = "search";
	$template = "product";
	break;
	case 'san-pham':
	$type = "san-pham";
	$title = _sanpham;
	$title_cat = _sanpham;
	$title_other = _tinlienquan;
	$source = "product";
	$template = isset($_GET['id']) ? "product_detail" : "product";
	$type_og = isset($_GET['id']) ? "article" : "object";
	break;
	case 'thuong-hieu':
	$type = "cong-trinh";
	$title = _sanpham;
	$title_cat = _sanpham;
	$title_other = _sanphamkhac;
	$source = "thuonghieu";
	$template = isset($_GET['id']) ? "product_detail" : "product";
	$type_og = isset($_GET['id']) ? "article" : "object";
	break;
	case 'phan-trang-danh-muc':
	$type = "cong-trinh";
	$title = _sanpham;
	$title_cat = _sanpham;
	$source = "phantrang_dm";
	$template = "phantrang_dm";
	break;
	case 'video':
	$type = "video";
	$title = 'Video Clip';
	$title_cat = "Video Clip";
	$source = "video";
	$template = "video";
	break;
	case 'thay-doi-thong-tin':
	$type = "thaydoithongtin";
	$title = _thaydoithongtin;
	$title_cat = _thaydoithongtin;
	$source = "thaydoithongtin";
	$template = "thaydoithongtin";
	break;
	case 'gio-hang':
	$type = "giohang";
	$title = _giohang;
	$title_cat = _giohang;
	$source = "giohang";
	$template = "giohang";
	break;
	case 'checkouts':
	$type = "thanhtoan";
	$title = _thanhtoan;
	$title_cat = _thanhtoan;
	$source = "checkouts";
	$template = "checkouts";
	break;
	case 'dang-xuat':
	logout();
	break;
	case 'ngonngu':
	if(isset($_GET['lang']))
	{
		switch($_GET['lang'])
		{
			case '':
			$_SESSION['lang'] = '';
			break;
			case 'en':
			$_SESSION['lang'] = 'en';
			break;
			case 'cn':
			$_SESSION['lang'] = 'cn';
			break;
			default:
			$_SESSION['lang'] = '';
			break;
		}
	}
	else{
		$_SESSION['lang'] = '';
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	break;
	case '':
		$source = "index";
		$template = "index";
		$type_og = "website";
	break;
	default:
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
	        include_once '404.php';
	        exit();
	break;
}
if($source!="") include _source.$source.".php";
if($_REQUEST['com']=='logout')
{
	unset($_SESSION[$login_name]);
	header("Location:index.php");
}
