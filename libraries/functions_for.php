<?php if(!defined('_lib')) die("Error");
function l_ten($id=0)
{
	if($id==0) return; 
	global $d;
	$d->reset();
	$sql="select ten from table_news where id=".$id." limit 1";
	$d->query($sql);
	$result=$d->fetch_array();
	return $result['ten'];	
}
function GetImg($pathto){
	if(file_exists($pathto)){
		return $pathto;
	} else {
		return 'images/1x1.png';
	}
}
function docgia($so){ 
  if (($so < 0) || ($so > 999999999999999)) 
  {
      echo "Số quá lớn";
  }
  else
  {
  if (($so>=1000000000) && ($so <= 999999999999999))    //TỶ
      {$ty = round(($so / 1000000000),2);
      $gia = $ty.' tỷ';
      }
  if (($so>=1000000) && ($so < 1000000000)) //TRIỆU
      {$trieu = round(($so / 1000000),2);
      $gia = $trieu.' triệu';
      }
  if (($so<1000000)){ //Tram
    $gia = number_format($so,0, ',', '.');
    }
  }
  
  return $gia; 
}
function sendEmail($sendType=false,$to, $from=null, $from_name=null, $subject, $body,$more=array(),$file='') {

	include_once "./sources/phpMailer/class.phpmailer.php";

	global $error,$ip_host,$mail_host,$pass_mail;
	
	$mail = new PHPMailer();  // tạo một đối tượng mới từ class PHPMailer
	$mail->CharSet = "utf-8"; 
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->SMTPAuth   = true;       // Sử dụng đăng nhập vào account
	if($sendType==true){
		$mail->Host       = $ip_host;   // tên SMTP server
		$mail->Username   = $mail_host; // SMTP account username
		$mail->Password   = $pass_mail;  
	}else{
		$mail->Priority = 1;
		$mail->AddCustomHeader("X-MSMail-Priority: High");    
		$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
		// Connect to smtp.gmail.com on port 465, if you’re using SSL. (Connect on port 587 if you’re using TLS.)
		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
		$mail->Username   =MAIL_USER;  // GMAIL username
		$mail->Password   =MAIL_PWD;
	}
	if(!$from_name){
		$from_name = $mail->Username;
	}
	if(!$from){
		$from = $mail->Username;
	}
	$mail->SetFrom($from, $from_name);
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	$mail->AddReplyTo($to,'Liên hệ từ website'.$_SERVER["SERVER_NAME"]);
	if($file){
		foreach($file as $k=>$v){
			$mail->AddAttachment($v[0].$v[1]);
		}
	}
	if(count($more) > 0){
		foreach($more as $k=>$v){
			$mail->AddAddress($v);
		}
	}
	if(!$mail->Send()) {
		$error = _guimailbiloi.': '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = _thucuabandaduocguidi;
		return true;
	}
} 
function num_format($number,$lang='vi'){
	if($lang=='en'){
		return (number_format($number,'2','.',','));
	}
	return (number_format($number,'0','.','.'));
}
function in_array_r($needle, $haystack, $strict = false) {
	foreach ($haystack as $item) {
		if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
			return true;
		}
	}
	return false;
}
function raw_json_encode($input, $flags = 0) {
	$fails = implode('|', array_filter(array(
		'\\\\',
		$flags & JSON_HEX_TAG ? 'u003[CE]' : '',
		$flags & JSON_HEX_AMP ? 'u0026' : '',
		$flags & JSON_HEX_APOS ? 'u0027' : '',
		$flags & JSON_HEX_QUOT ? 'u0022' : '',
	)));
	$pattern = "/\\\\(?:(?:$fails)(*SKIP)(*FAIL)|u([0-9a-fA-F]{4}))/";
	$callback = function ($m) {
		return html_entity_decode("&#x$m[1];", ENT_QUOTES, 'UTF-8');
	};
	return preg_replace_callback($pattern, $callback, json_encode($input, $flags));
}
function get_url($v,$com,$linklevel=""){
	global $link_id;
	if($link_id){
		if($linklevel==1){
			$str_result = $com.'/'.$v["tenkhongdau"].'-'.$v["id"];	
		}else if($linklevel==2){
			$str_result = $com.'/'.$v["tenkhongdau"].'-'.$v["id"].'/';	
		}else if($linklevel==3){
			$str_result = $com.'/'.$v["tenkhongdau"].'/'.$v["id"];	
		}else if($linklevel==4){
			$str_result = $com.'/'.$v["tenkhongdau"].'/'.$v["id"].'/';	
		}else{
			$str_result = $com.'/'.$v["tenkhongdau"].'-'.$v["id"].'.html';	
		}
	}else{
		$str_result = $v["tenkhongdau"];	
	}
	
	return $str_result;
}
function get_result($sql){
	global $d,$lang,$str;
	$d->reset();
	$d->query($sql);
	return $d->result_array();
}
function get_fetch($sql){
	global $d,$lang,$str;
	$d->reset();
	$d->query($sql);
	return $d->fetch_array();
}
function for1($table,$com,$type,$duoi='.html'){
	global $d,$lang,$str,$link_id;
	$baiviet = get_result("select id,ten$lang as ten,tenkhongdau,type from #_$table where hienthi=1 and type='$type' order by stt,id desc");
	$str='';
	$str.='<ul class="sub-menu">';
	for($i=0;$i<count($baiviet);$i++){
		if($link_id){
		$str.='<li><a href="'.$com.'/'.$baiviet[$i]["tenkhongdau"].'-'.$baiviet[$i]["id"].$duoi.'">'.$baiviet[$i]["ten"].'</a>';	
		}
		else{
		$str.='<li><a href="'.$baiviet[$i]["tenkhongdau"].'">'.$baiviet[$i]["ten"].'</a>';	
		} 
	}
	$str.='</ul>';
	return $str;
}
function for2cap($table1,$table2,$com,$type,$duoi1='',$duoi2='/'){
	global $d,$lang,$str,$link_id;
	$danhmuc_cap1 = get_result("select id,ten$lang as ten,tenkhongdau,type from #_$table1 where hienthi=1 and type='$type' order by stt,id desc");
	$str='';
	$str.='<ul class="sub-menu">';
	for($i=0;$i<count($danhmuc_cap1);$i++){
		if($link_id){
			$link1 = $com.'/'.$danhmuc_cap1[$i]["tenkhongdau"].'-'.$danhmuc_cap1[$i]["id"];
		}else{
			$link1 = $danhmuc_cap1[$i]["tenkhongdau"];	
		}
		$str.='<li><a href="'.$link1.'">'.$danhmuc_cap1[$i]["ten"].'</a>';
		$danhmuc_cap2= get_result("select id,ten$lang as ten,tenkhongdau,type from #_$table2 where hienthi=1 and type='$type' and id_danhmuc='".$danhmuc_cap1[$i]["id"]."' order by stt,id asc");
		if(count($danhmuc_cap2)>0){
			$str.='<ul>';
			for($j=0;$j<count($danhmuc_cap2);$j++){
				if($link_id){
					$link2 = $com.'/'.$danhmuc_cap2[$j]["tenkhongdau"].'-'.$danhmuc_cap2[$j]["id"].'/';
				}else{
					$link2 = $danhmuc_cap2[$j]["tenkhongdau"];	
				}
				$str.='<li><a href="'.$link2.'">'.$danhmuc_cap2[$j]["ten"].'</a></li>';
			}
			$str.='</ul>';
		}
		$str.='</li>';
	}
	$str.='</ul>';
	return $str;
}
function for3cap($table1,$table2,$table3,$com,$type,$duoi1='',$duoi2='/',$duoi3=''){
	global $d,$lang,$str,$link_id;
	$d->reset();
	$sql = "select id,ten$lang as ten,tenkhongdau,type from #_$table1 where hienthi=1 and type='$type' order by stt,id desc";
	$d->query($sql);
	$danhmuc_cap1 = $d->result_array();
	$str='';
	$str.='<ul class="sub-menu">';
	for($i=0;$i<count($danhmuc_cap1);$i++){
		if($link_id){
			$link1 = $com.'/'.$danhmuc_cap1[$i]["tenkhongdau"].'-'.$danhmuc_cap1[$i]["id"];
		}else{
			$link1 = $danhmuc_cap1[$i]["tenkhongdau"];	
		}
		$str.='<li><a href="'.$link1.'">'.$danhmuc_cap1[$i]["ten"].'</a>';
		$d->reset();
		$sql="select id,ten$lang as ten,tenkhongdau,type from #_$table2 where hienthi=1 and type='$type' and id_danhmuc='".$danhmuc_cap1[$i]["id"]."' order by stt,id asc";
		$d->query($sql);
		$danhmuc_cap2=$d->result_array();
		if(count($danhmuc_cap2)>0){
			$str.='<ul>';
			for($j=0;$j<count($danhmuc_cap2);$j++){
				if($link_id){
					$link2 = $com.'/'.$danhmuc_cap2[$j]["tenkhongdau"].'-'.$danhmuc_cap2[$j]["id"].'/';
				}else{
					$link2 = $danhmuc_cap2[$j]["tenkhongdau"];	
				}
				$str.='<li><a href="'.$link2.'">'.$danhmuc_cap2[$j]["ten"].'</a>';
				$d->reset();
				$sql="select id,ten$lang as ten,tenkhongdau,type from #_$table3 where hienthi=1 and type='$type' and id_list='".$danhmuc_cap2[$j]["id"]."' order by stt,id asc";
				$d->query($sql);
				$danhmuc_cap3=$d->result_array();
				if(count($danhmuc_cap3)>0){
					$str.='<ul>';
					for($k=0;$k<count($danhmuc_cap3);$k++){
						if($link_id){
							$link3 = $com.'/'.$danhmuc_cap3[$k]["tenkhongdau"].'/'.$danhmuc_cap3[$k]["id"];
						}else{
							$link3 = $danhmuc_cap3[$k]["tenkhongdau"];	
						}
						$str.='<li><a href="'.$link3.'">'.$danhmuc_cap3[$k]["ten"].'</a>';
					}
					$str.='</ul>';
				}
				$str.='</li>';
			}
			$str.='</ul>';
		}
		$str.='</li>';
	}
	$str.='</ul>';
	return $str;
}
function tinh_phantram($gia,$giakm){
	global $d,$str;
	$str = 0;
	if($gia>0 and $giakm>0)
	{
		$str = round(100-($giakm/$gia*100));
	}
	return $str;
}
function tinh_giamgia($gia,$phantram){
	global $d,$str;
	$str = 0;
	if($gia>0 and $phantram>0)
	{
		$str = round($gia-($gia*$phantram/100));
	}
	return $str;
}
function lay_link($type){
	global $d,$lang,$str;
	$str = "";
	$d->reset();
	$sql = "select link from #_background where type='".$type."' limit 0,1";
	$d->query($sql);
	$row_banner = $d->fetch_array();
	$str .= $row_banner['link'];
	return $str;
}
function lay_banner($type){
	global $d,$lang,$str;
	$str = "";
	$d->reset();
	$sql = "select photo$lang as photo from #_background where type='".$type."' limit 0,1";
	$d->query($sql);
	$row_banner = $d->fetch_array();
	$str .= _upload_hinhanh_l.$row_banner['photo'];
	return $str;
}
function lay_slider($type,$class='',$width=0,$height=0,$zc=2){
	global $d,$lang,$str,$str_thumb;
	$str_thumb = "";
	$str = "";
	if($width>0 and $height >0){
		$str_thumb = 'thumb/'.$width.'x'.$height.'/'.$zc.'/';
	}
	$slider=get_result("select ten$lang as ten,link,photo from #_slider where hienthi=1 and type='".$type."' order by stt,id desc");
	foreach($slider as $k => $v){
		if($class!='') $str .= '<div class="'.$class.'">';
		if($v['link']!=''){
			$str .= '<a href="'.$v['link'].'"><img class="img-fill" src="images/1x1.png" data-lazy="'.$str_thumb._upload_hinhanh_l.$v['photo'].'" alt="'.$v['ten'].'" /></a>';}
			else{
				$str .= '<span><img class="img-fill" src="images/1x1.png" data-lazy="'.$str_thumb._upload_hinhanh_l.$v['photo'].'" alt="'.$v['ten'].'" /></span>';
			}
			if($class!='') $str .= '</div>';
		}
		return $str;
	}
	function showProduct($v,$options=array(),$k=null){
		global $lang,$company,$com;
		$link = get_url($v, $v["type"]);
		$giaspgiam = ($v["giakm"]>0)?'<span class="giam">-'.tinh_phantram($v["gia"],$v["giakm"]).
		'%</span>':"";
		// $cls_moi = ($v["spmoi"]>0)?'<i class="new">new</i>':"";
		// $cls_banchay = ($v["spbanchay"]>0)?'<i class="sale"></i>':"";
		$giasp = ($v["giakm"]>0)?$v["giakm"]:$v["gia"];
		$gia = ($giasp>0)?num_format($giasp).' vnđ':_lienhe;
		$s_gia = "";
		if($v["giakm"]>0) {
			$s_gia .= '<del>'.num_format($v["gia"]).' vnđ</del>';
			$s_gia .= '<span>'.num_format($v["giakm"]).' vnđ</span>';
		}else{
			$s_gia .= '<span>'.$gia.'</span>';
		}
		// $danhgiasao = get_result("select ROUND(AVG(giatri)) as giatri FROM #_danhgiasao 
		// where id_sanpham='".$v["id"]."' order by time desc");
		// if($danhgiasao[0]['giatri']==0){$num_danhgiasao=0;}
		// else{$num_danhgiasao=$danhgiasao[0]['giatri'];};
		// $linkct="";
		// $prostar='';
		// for($i=1;$i<=5;$i++) { 
			
		// 	if($i<=$danhgiasao[0]['giatri']){
		// 		$prostar .='<i class="fas active fa-star"></i>';
		// 	}else{
		// 		$prostar .='<i class="fas fa-star"></i>';
		// 	}
		// }
		if(($options["slick"])){
			$imgurl='<img src="images/1x1.png" data-lazy="'._upload_sanpham_l.$v["thumb"].
			'" alt="'.$v["ten"].'" />';
			$slickdiv = '<div class="slick-box-item">';
			$slickenddiv = '</div>';
			$wowclass="";
		}else{
			$imgurl='<img data-src="'._upload_sanpham_l.$v["thumb"].'" alt="'.$v["ten"].
			'" class="lazy" />';
			$slickdiv=$slickenddiv="";
			$wowclass='';
		}
		// $linkct= '<a href="'.$link.'" class="chitietnt" >Xem chi tiết</a>';
		// $linkct .= '<a href="#" data-id="'.$v["id"].'" class="dathang">
		// <i class="fas fa-shopping-cart"></i> Đặt hàng</a>';
		// $linkct = '<a href="#" data-id="'.$v["id"].'" class="muangay">
		// Đặt hàng</a>';
		echo $slickdiv.'<div class="pr-box name '.$wowclass.'" >
		<article>
				<a href="'.$link.'" class="imgsp">'.$imgurl.$cls_moi.$cls_banchay.
					$giaspgiam.'
				</a>
				
				<div class="info">
					<h3><a href="'.$link.'">'.$v["ten"].'</a></h3>
					<p>'.$s_gia.'</p>
				</div>
				'.$linkct.'
		</article></div>'.$slickenddiv;
	}
	function showProductAjax($v,$options=array(),$k=null){
		global $lang,$company,$com;
		$link = get_url($v, $v["type"]);
		if($v["id_dist"]>0){
			$get_dist = get_fetch("select ten$lang as ten from table_place_dist where id = '".$v["id_dist"]."'");
		}
		// $giaspgiam = ($v["giakm"]>0)?'<span class="giam">-'.tinh_phantram($v["gia"],$v["giakm"]).
		// '%</span>':"";
		// $giasp = ($v["giakm"]>0)?$v["giakm"]:$v["gia"];
		// $gia = ($giasp>0)?num_format($giasp).'đ':_lienhe;
		// $s_gia = "";
		// if($v["giakm"]>0) {
		// 	$s_gia .= '<span>'.num_format($v["giakm"]).'đ</span>';
		// 	$s_gia .= '<del>'.num_format($v["gia"]).'đ</del>';
		// }else{
		// 	$s_gia .= '<span>'.$gia.'</span>';
		// }
		if(($options["slick"])){
			$imgurl='<img src="images/1x1.png" data-lazy="'._upload_sanpham_l.$v["thumb"].
			'" alt="'.$v["ten"].'" />';
			$slickdiv = '<div class="slick-box-item">';
			$slickenddiv = '</div>';
			$wowclass="";
		}else{
			$imgurl='<img data-src="'._upload_sanpham_l.$v["thumb"].'" alt="'.$v["ten"].
			'" class="lazy" />';
			$slickdiv=$slickenddiv="";
			$wowclass='';
		}
		// $linkct = '<a href="#" data-id="'.$v["id"].'" class="muangay">
		// Đặt hàng</a>';
		$s_result = $slickdiv.'<div class="pr-box name '.$wowclass.'" >
		<article>
		<div class="image">
				<a href="'.$link.'" class="imgsp ">'.$imgurl.$cls_moi.$cls_banchay.
				$giaspgiam.'
				</a>
				</div>
				<div class="info">
					<h3><a href="'.$link.'">'.$v["ten"].'</a></h3>
					<p><i class="fas fa-map-marker-alt"></i><strong>Giá:</strong><span>'.$v["vitri"].'</span></p>
					<p><i class="fas fa-dollar-sign"></i><strong>Diện tích:</strong>'.$v["dientich"].'</p>
					<p><i class="fas fa-bed"></i><strong>Phòng ngủ:</strong>'.$v["mattien"].'</p>
					<p><i class="fas fa-location-arrow"></i><strong>Quận Huyện:</strong>'.$get_dist["ten"].'</p>
				</div>
				'.$linkct.'
		</article></div>'.$slickenddiv;
		return $s_result;
	}
	function lay_sanpham($product,$class,$width=0,$height=0,$zc=2){
		global $d,$str,$str_thumb,$lang;
		if($width>0 and $height >0){
			$str_thumb = 'thumb/'.$width.'x'.$height.'/'.$zc.'/';
		}
		$str_thumb = "";
		$str = "";
		foreach($product as $k => $v){
			$str .= '<div class="'.$class.'">';
			$giacu = "";$giakm = "";$gia = "";
			if($v['giakm']>0) {
				$giacu = 'giacu';$giakm = number_format($v['giakm'],0, ',', '.') .' vnđ';}
				else {$gia = _gia.': ';}
				$str .= '<p class="sp_img zoom_hinh hover_sang3"><a href="'.$v['type'].'/'.$v['tenkhongdau'].'-'.$v['id'].'.html"><img src="'.$str_thumb._upload_sanpham_l.$v['thumb'].'" alt="'.$v['ten'].'" /></a></p>';
				$str .= '<h3 class="sp_name"><a href="'.$v['type'].'/'.$v['tenkhongdau'].'-'.$v['id'].'.html">'.$v['ten'].'</a></h3>';
				$str .= '<p class="sp_gia"><span class="gia '.$giacu.'">'.$gia.number_format($v['gia'],0, ',', '.').' vnđ</span><span class="giakm">'.$giakm.'</span></p>';
				$str .= '</div>';
			}
			return $str;
		}
		function lay_tintuc($type,$class='',$mota=0,$ngaytao=0,$width=0,$height=0,$zc=2){
			global $d,$str,$str_thumb,$lang;
			if($width>0 and $height >0){
				$str_thumb = 'thumb/'.$width.'x'.$height.'/'.$zc.'/';
			}
			$str = "";
			$str_thumb = "";
			$d->reset();
			$sql = "select id,ten$lang as ten,tenkhongdau,type,photo,thumb,ngaytao,mota$lang as mota from #_news where hienthi=1 and type='".$type."' and noibat=1 order by stt,id desc";
			$d->query($sql);
			$tintuc=$d->result_array();
			foreach($tintuc as $k => $v){
				$str .= '<div class="'.$class.'">';
				$str .= '<p class="img_news hover_sang1"><a href="'.$v['type'].'/'.$v['tenkhongdau'].'-'.$v['id'].'.html"><img src="'.$str_thumb._upload_tintuc_l.$v['thumb'].'" alt="'.$v['ten'].'" /></a></p>';
				$str .= '<h4 class="name_news"><a href="'.$v['type'].'/'.$v['tenkhongdau'].'-'.$v['id'].'.html">'.$v['ten'].'</a></h4>';
				if($ngaytao==1){
					$str .= '<p class="ngaytao">'.make_date($v['ngaytao']).'</p>';
				}
				if($mota==1){
					$str .= '<p class="mota">'.catchuoi($v['mota'],150).'</p>';
				}
				$str .= '</div>';
			}
			return $str;
		}
		//lấy thứ
		function lay_thu($weekday) {
		   date_default_timezone_set('Asia/Ho_Chi_Minh');
		   $weekday = date('l',$weekday);
		   $weekday = strtolower($weekday);

		   switch($weekday) {
		       case 'monday':
		           $weekday = 'Thứ 2';
		           break;
		       case 'tuesday':
		           $weekday = 'Thứ 3';
		           break;
		       case 'wednesday':
		           $weekday = 'Thứ 4';
		           break;
		       case 'thursday':
		           $weekday = 'Thứ 5';
		           break;
		       case 'friday':
		           $weekday = 'Thứ 6';
		           break;
		       case 'saturday':
		           $weekday = 'Thứ 7';
		           break;
		       default:
		           $weekday = 'Chủ nhật';
		           break;
		   }
		   return $weekday;
		}
		function lay_text($type){
			global $d,$lang,$str;
			$str = "";
			$d->reset();
			$sql = "select noidung$lang as noidung from #_about where type='".$type."' limit 0,1";
			$d->query($sql);
			$row_text = $d->fetch_array();
			$str = $row_text['noidung'];
			return $str;
		}
		function lay_mxh($type,$width='',$height='',$zc=2){
			global $d,$lang,$str,$str_thumb;
			if($width>0 and $height >0){
				$str_thumb = 'thumb/'.$width.'x'.$height.'/'.$zc.'/';
			}
			$str = "";
			$str_thumb = "";
			$lkweb=get_result("select ten$lang as ten,link,photo from #_lkweb where hienthi=1 and type='".$type."' order by stt,id desc");
			foreach($lkweb as $k => $v){
				$str .= '<a href="'.$v['link'].'" target="_blank"><img src="'.$str_thumb._upload_khac_l.$v['photo'].'" alt="'.$v['ten'].'" /></a>';
			}
			return $str;
		}
		function lay_fanpage($link,$width=235,$height=140){
			global $d,$lang,$str;
			$str = '';
			$str = '<div class="fb-page" data-height="'.$height.'" data-width="'.$width.'" data-href="'.$link.'" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"></div></div>';
			return $str;
		}

		// Use PreparedQuery to ease use of prepared query calls
		// Example:
		//    PreparedQuery($conn, "SELECT id, username FROM users WHERE email = ?", array("s", $_POST["email"])
		//

		function PreparedQuery($query, $params=array())
		{
			global $d;
			$connection = $d->db; 
		    // Create a prepared statement
		    $stmt = $connection->prepare($query);
		    if (!$stmt)
		        throw new Exception("Query is not valid : '$query'");
		    
		    // Bind parameters
		    if (count($params) > 1)
		        call_user_func_array(array($stmt, 'bind_param'), RefValues($params));
		    
		    // Execute and buffer results into memory
		    $stmt->execute();
		    
		    // Return results based on query type
		    $type = GetQueryType($query);
		    $result = FALSE;
		    if ($stmt->errno !== 0)
		    {
		        $result = FALSE;
		    }
		    else if ($type == "SELECT")
		    {
		        $meta = $stmt->result_metadata();

		        // Fetch field names
		        while ($field = $meta->fetch_field())
		            $parameters[] = &$row[$field->name];

		        call_user_func_array(array($stmt, 'bind_result'), RefValues($parameters));

		        $results = array();
		        while ($stmt->fetch())
		        {
		            $tmp = array();
		            foreach ($row as $key => $val)
		                $tmp[$key] = $val;
		            $results[] = $tmp;
		        }
		        $result = $results;
		    }
		    else if (in_array($type, array("INSERT", "UPDATE", "DELETE")))
		    {
		        $result = $stmt->affected_rows;
		    }
		    else // CREATE TABLE, REPLACE
		    {
		        $result = TRUE;
		    }
		    
		    // Close the prepared statement with MySQL
		    $stmt->close();
		    
		    return $results;
		}

		function GetQueryType($query)
		{
		    $query = strtoupper($query);
		    $best_type = NULL;
		    foreach(array("SELECT", "INSERT", "UPDATE", 
		                  "DELETE", "REPLACE", "CREATE TABLE") as $type) {
		        $pos = strpos($query, $type);
		        if ($pos !== FALSE && $pos >= 0)
		        {
		            $best_type = $type;
		            $query = substr($query, 0, $pos);
		            
		            // stop iteration early
		            if (strlen($query) == 0)
		                break;
		        }
		    }
		    
		    return $best_type;
		}

		function RefValues($arr)
		{
		    if (strnatcmp(phpversion(), '5.3') >= 0) //Reference is required for PHP 5.3+
		    {
		        $refs = array();
		        foreach($arr as $key => $value)
		            $refs[$key] = &$arr[$key];
		        return $refs;
		    }
		    return $arr;
		}