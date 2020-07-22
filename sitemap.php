<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<?php
	@define ( '_template' , './templates/');
	@define ( '_source' , './sources/');
	@define('_lib', './libraries/');

	include_once _lib."config.php";
	include_once _lib."constant.php";
	include_once _lib."functions.php";
	include_once _lib."library.php";
	if (version_compare(phpversion(), '7.0.0', '<')) include_once _lib."class.database.php";
	else include_once _lib."class.database7.3.php"; 
	$d = new database($config['database']);

	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
	$login_name_admin = md5($config['salt_sta'].$config['salt_end']);

  check_login();

	function CreateXML1($link,$uutien=1){
		global $d,$config_url,$file_creatsite;
		fwrite($file_creatsite, "<url><loc>http://".$config_url."/".$link."</loc><changefreq>daily</changefreq><priority>".$uutien."</priority></url>");
		return;
	}
	function CreateXML2($tbl='',$com='',$type='',$duoi='',$uutien=1){
		global $d,$config_url,$file_creatsite;
		if($tbl=='') return false;

		$d->reset();
		$sql = "SELECT id,tenkhongdau,ngaytao FROM table_$tbl where hienthi=1 and type='".$type."' order by stt,ngaytao desc";
		$d->query($sql);
		$link_seo = $d->result_array();
		for($i=0; $i<count($link_seo); $i++){
			fwrite($file_creatsite, "<url><loc>http://".$config_url."/".$com."/".$link_seo[$i]["tenkhongdau"]."-".$link_seo[$i]["id"].$duoi."</loc><priority>".$uutien."</priority><lastmod>".date('Y-m-d',$link_seo[$i]['ngaytao'])."</lastmod><changefreq>daily</changefreq></url>");
		}
		return;
	}
?>

<?php
	$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">";

	$string_xml = "</urlset>";
	$file_creatsite = fopen("../upload/sitemap.xml", "w+");
	fwrite($file_creatsite, $xml);

	CreateXML1("sitemap.xml",'0.5');
	CreateXML1("",'0.5');
	CreateXML1("lien-he.html",'0.5');
	CreateXML1("gioi-thieu.html",'0.5');
	CreateXML1("tin-tuc.html",'0.5');

	CreateXML1("dich-vu.html",'0.5');
	CreateXML1("tuyen-dung.html",'0.5');
	CreateXML1("khuyen-mai.html",'0.5');
	CreateXML1("du-an.html",'0.5');
	CreateXML1("cong-trinh.html",'0.5');

	CreateXML2("product","san-pham","san-pham",".html",'1');
	CreateXML2("product_danhmuc","san-pham","san-pham","",'0.8');
	CreateXML2("product_list","san-pham","san-pham","/",'0.8');
	CreateXML2("news","tin-tuc","tin-tuc",".html",'1');
	CreateXML2("news","dich-vu","dich-vu",".html",'1');

	fwrite($file_creatsite, $string_xml);
	fclose($file_creatsite);

	transfer("Sitamap đã tạo thành công.<br>Quý khách có thể click vào đây để xem.", "http://".$config_url.'/sitemap.xml');
?>
