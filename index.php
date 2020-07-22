<?php
session_start();
@define ( '_template' , './templates/');
@define ( '_source' , './sources/');
@define('_lib', './libraries/');
include_once _lib."config.php";
include_once _lib."constant.php";
include_once _lib."config_type.php";
include_once _lib."functions.php";
include_once _lib."functions_for.php";
include_once _lib."functions_giohang.php";
include_once _lib."library.php";
include_once _lib."pclzip.php";
if (version_compare(phpversion(), '7.0.0', '<')) include_once _lib."class.database.php";
else include_once _lib."class.database7.3.php"; 
require './composer/vendor/autoload.php';
$com = (string)(isset($_REQUEST['com'])) ? addslashes($_REQUEST['com']) : "";
$act = (string)(isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
$login_name_admin = md5($config['salt_sta'].$config['salt_end']);
check_login();
if($_REQUEST['author']){
	header('Content-Type: text/html; charset=utf-8');
	echo '<pre>';
	print_r($config['author']);
	echo '</pre>';
	die();
}
$d = new database($config['database']);
$archive = new PclZip($file);
switch($com){
		####Phân quyền
	case 'title':
	$source = "title";
	break;
	case 'gia':
	$source = "gia";
	break;
	case 'import':
	$source = "import";
	break;
	case 'comment':
	$source = "comment";
	break;
	case 'phanquyen':
	$source = "phanquyen";
	break;
	case 'com':
	$source = "com";
	break;
	case 'group':
	$source = "group";
	break;
		####Thường có
	case 'lienhe':
	$source = "lienhe";
	break;
	case 'database':
	$source = "database";
	break;
	case 'backup':
	$source = "backup";
	break;
	case 'pupop':
	$source = "pupop";
	break;
	case 'background':
	$source = "background";
	break;
	case 'vnexpress':
	$source = "vnexpress";
	break;
		####Đơn hàng
	case 'order':
	$source = "donhang";
	break;
	case 'anhnen':
	$source = "anhnen";
	break;
	case 'place':
	$source = "place";
	break;
	case 'chitietdonhang':
	$source = "chitietdonhang";
	break;
	case 'httt':
	$source = "httt";
	break;
	case 'hinhthucgiaohang':
	$source = "hinhthucgiaohang";
	break;
	case 'import':
	$source = "import";
	break;
	case 'export':
	$source = "export";
	break;
		####Đơn hàng
	case 'letruot':
	$source = "letruot";
	break;
	case 'slider':
	$source = "slider";
	break;
	case 'newsletter':
	$source = "newsletter";
	break;
	case 'lkweb':
	$source = "lkweb";
	break;
	case 'video':
	$source = "video";
	break;
	case 'photo':
	$source = "photo";
	break;
	case 'about':
	$source = "about";
	break;
	case 'news':
	$source = "news";
	break;
	case 'product':
	$source = "product";
	break;
	case 'yahoo':
	$source = "yahoo";
	break;
		####Luôn tồn tại
	case 'uploadfile':
	$source = "uploadfile";
	break;
	case 'multi':
	$source = "multi";
	break;
	case 'multi_upload':
	$source = "multi_upload";
	break;
	case 'creatsitemap':
	$source = "creatsitemap";
	break;
	case 'banner':
	$source = "banner";
	break;
	case 'hinhanh':
	$source = "hinhanh";
	break;
	case 'company':
	$source = "company";
	break;
	case 'footer':
	$source = "footer";
	break;
	case 'user':
	$source = "user";
	break;
	case 'meta':
	$source = "meta";
	break;
		####Giá trị mạc định
	default:
	$source = "";
	$template = "index";
	break;
}
	//dump($_SESSION['login_admin']['com']);
if((!isset($_SESSION[$login_name_admin]) || !$_SESSION[$login_name_admin]) && $act!="login"){
	redirect("index.php?com=user&act=login");
}
if($_GET['act']=='man' || $_GET['act']=='man_cat' || $_GET['act']=='man_list' || 
	$_GET['act']=='capnhat' || $_GET['act']=='man_photo' || $_GET['act']=='man_danhmuc' ||
	$_GET['act']=='man_item' || $_GET['act']=='man_city' || $_GET['act']=='man_dist'
	|| $_GET['act']=='man_ward' || $_GET['act']=='man_street'){
	$_SESSION['links_re'] = getCurrentPage();
}
if(phanquyen($_SESSION['login_admin']['com'],$_SESSION['login_admin']['nhom'],$_GET['com'],$_GET['act'],$_GET['type'])){
	transfer("Bạn Không có quyền vào đây. Vui lòng liên hệ admin. Cảm ơn!",'index.php');
}
if($_GET['act']!=''){
	$act_ = explode('_',$_GET['act']);
	if($act_['0']=='edit'){$checkurl = 0;}
	if($act_['0']=='add'){ $checkurl = 1;}
}
if($source!="") {
	include _source.$source.".php";
}
?>
<!doctype html>
<html lang="vi">
<head itemscope itemtype="https://schema.org/WebSite">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Administrator - Hệ thống quản trị nội dung</title>
	<!--<link href="css/main.css" rel="stylesheet" type="text/css" />-->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="js/t-datepicker/css/t-datepicker.min.css" rel="stylesheet" type="text/css" />
	<link href="js/t-datepicker/css/themes/t-datepicker-blue.css" rel="stylesheet" type="text/css" />
	<link href="css/main_repon.css" rel="stylesheet" type="text/css" />
	<?php if($config['reponsive']) { ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link href="css/media.css" rel="stylesheet" type="text/css" />
	<?php } else { ?>
		<meta name="viewport" content="width=1300">
	<?php } ?>
	<script type="text/javascript" src="js/external.js"></script>
	<script src="js/jquery.price_format.2.0.js" type="text/javascript"></script>
	<script src="ckeditor/ckeditor.js"></script>
	<link href="js/plugins/multiupload/css/jquery.filer.css" type="text/css" rel="stylesheet" />
	<link href="js/plugins/multiupload/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
	<!-- MultiUpload -->
	<script type="text/javascript" src="js/plugins/multiupload/jquery.filer.min.js"></script>
	<script src="js/jquery.minicolors.js"></script>
	<link rel="stylesheet" href="css/jquery.minicolors.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<script type="text/javascript">
		var loadFile = function(event) {
			var output = document.getElementById('output');
			output.src = URL.createObjectURL(event.target.files[0]);
		};
	</script>
	<link href="js/select-box-searching-jquery/select2.css" rel="stylesheet"/>
	<script src="js/select-box-searching-jquery/select2.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".main_select").select2();
		});
	</script>
	<link href="css/fSelect.css" rel="stylesheet">
	<script src="js/fSelect.js" type="text/javascript"></script>
	<script type="text/javascript">
		$().ready(function(){
			$('.se-w').fSelect();
		})
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			var $chkboxes = $('.checker');
			var lastChecked = null;
			$('.checker').click(function(e) {
				if(!$(this).find('span').hasClass('checked')){
					lastChecked = this;
					return;
				}
				if (e.shiftKey) {
					var start = $chkboxes.index(this);
					var end = $chkboxes.index(lastChecked);
					console.log(start + ' = ' + end);
					var between = $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1);
					console.log(between);
					between.children('span').addClass('checked');
					between.children('span').find('input[name=chon]').prop('checked', true);
				}
				lastChecked = this;
			});
		});
	</script>
	<!--Chọn mã màu-->
	<script type="text/javascript" src="media/scripts/jquery.ps-color-picker.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.taoseo').click(function(){
				var ten = $("#ten").val();
				$("input[name='title']").val(ten);
				$("input[name='keywords']").val(ten);
				$("textarea[name='description']").val(ten);
			});
			var click_menu = 0;
			$('.menu_mobi,.baophu').click(function(){
				if(click_menu==0)
				{
					$('#leftSide').show(300);click_menu=1;
					$('.baophu').fadeIn();
				}
				else
				{
					$('#leftSide').hide(300);click_menu=0;
					$('.baophu').fadeOut();
				}
			});
			$(".cp3").CanvasColorPicker();
			$(".sub li").each(function(){
				if($(this).hasClass("<?=$_REQUEST["com"].'_'.$_REQUEST["act"]?>")){
					$(this).addClass("this");
				}
			})
			$.fn.exists = function(){return this.length>0;}
			$(".categories_li").each(function(){
				if($(this).find("ul").find("li").exists()==false){
					$(this).hide();
				}
			})
		});
	</script>
	<!--Chọn mã màu-->
	<script>var base_url = '//<?=$config_url?>';  </script>
	<script src="js/t-datepicker/js/t-datepicker.min.js"></script>
	<link href="main.css" rel="stylesheet" type="text/css" />
</head>
<?php if(isset($_SESSION[$login_name_admin]) && ($_SESSION[$login_name_admin] == true)){?>
	<body data-tit="<?= $source." - "._template.$template ?>">
		<span class="vui"></span>
		<div class="baophu"></div>
		<script type="text/javascript">
			function stt(x)
			{
				var a=$(x).val();
				$.ajax({
					type: "POST",
					url: "ajax/ajax_hienthi.php",
					data:{
						id: $(x).attr("data-val0"),
						bang: $(x).attr("data-val2"),
						type: $(x).attr("data-val3"),
						value:a
					}
				});
				$('.vui').show();
			}
			$(function(){
				var lan = 0;
				$('.hien_menu').click(function(){
					if(lan==0)
					{
						$(this).parents('.ddnew2').find('.menu_header').slideDown(300);
						lan = 1;
					}
					else
					{
						$(this).parents('.ddnew2').find('.menu_header').slideUp(300);
						lan = 0;
					}
				});
				$('.menu_header').parents('.ddnew2').find('.numberTop').html($('.menu_header > li').length);
				var num = $('#menu').children(this).length;
				for (var index=0; index<=num; index++)
				{
					var id = $('#menu').children().eq(index).attr('id');
					$('#'+id+' strong').html($('#'+id+' .sub').children(this).length);
					$('#'+id+' .sub li:last-child').addClass('last');
				}
				$('#menu .activemenu .sub').css('display', 'block');
				$('#menu .activemenu a').removeClass('inactive');
				$('.conso').priceFormat({
					limit: 13,
					prefix: '',
					centsLimit: 0
				});
				$('.color').each( function() {
					$(this).minicolors({
						control: $(this).attr('data-control') || 'hue',
						defaultValue: $(this).attr('data-defaultValue') || '',
						format: $(this).attr('data-format') || 'hex',
						keywords: $(this).attr('data-keywords') || '',
						inline: $(this).attr('data-inline') === 'true',
						letterCase: $(this).attr('data-letterCase') || 'lowercase',
						opacity: $(this).attr('data-opacity'),
						position: $(this).attr('data-position') || 'bottom left',
						change: function(value, opacity) {
							if( !value ) return;
							if( opacity ) value += ', ' + opacity;
							if( typeof console === 'object' ) {
								console.log(value);
							}
						},
						theme: 'bootstrap'
					});
				});
			})
		</script>
		<div id="leftSide">
			<?php include _template."menu_tpl.php";?>
		</div>
		<!-- Right side -->
		<div id="rightSide">
			<!-- Top fixed navigation -->
			<div class="topNav">
				<?php include _template."header_tpl.php";?>
			</div>
			<div class="wrapper">
				<?php include _template.$template."_tpl.php";?>
			</div></div>
			<div class="clear"></div>
		</body>
	<?php }else {?>
		<body class="nobg loginPage">
			<?php include _template.$template."_tpl.php";?>
			<!-- Footer line -->
		</body>
	<?php } ?>
	<script type="text/javascript">
		function inick(id){
			CKEDITOR.replace( id, {
				height : 400,
				entities: false,
				basicEntities: false,
				entities_greek: false,
				entities_latin: false,
				skin:'office2013',
				filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
				filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
				filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
				filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
				allowedContent:
				'h1 h2 h3 p blockquote strong em;' +
				'a[!href];' +
				'img(left,right)[!src,alt,width,height];' +
				'table tr th td caption;' +
				'span{!font-family};' +
				'span{!color};' +
				'span(!marker);' +
				'del ins'
			});
			CKEDITOR.on("instanceReady", function(event) {
				event.editor.on("beforeCommandExec", function(event) {
			// Show the paste dialog for the paste buttons and right-click paste
					if (event.data.name == "paste") {
						event.editor._.forcePasteDialog = true;
					}
			// Don't show the paste dialog for Ctrl+Shift+V
					if (event.data.name == "pastetext" && event.data.commandData.from == "keystrokeHandler") {
						event.cancel();
					}
				})
			});
		}
		$(document).ready(function() {
			$('.ck_editor').parent('.formRight').css({width:'100%','margin-top':'30px','float':'none'});
			$('.ck_editor').each(function(index, el) {
				var id=$(this).attr('id');
				CKEDITOR.replace( id, {
					height : 400,
					entities: false,
					basicEntities: false,
					entities_greek: false,
					entities_latin: false,
					// extraPlugins: 'widget,contents',
					skin:'office2013',
					filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
					filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
					filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
					filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
					filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
					filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
					allowedContent:
					'h1 h2 h3 p blockquote strong em;' +
					'a[!href];' +
					'img(left,right)[!src,alt,width,height];' +
					'table tr th td caption;' +
					'span{!font-family};' +
					'span{!color};' +
					'span(!marker);' +
					'del ins'
				});
				CKEDITOR.on("instanceReady", function(event) {
					event.editor.on("beforeCommandExec", function(event) {
				// Show the paste dialog for the paste buttons and right-click paste
						if (event.data.name == "paste") {
							event.editor._.forcePasteDialog = true;
						}
				// Don't show the paste dialog for Ctrl+Shift+V
						if (event.data.name == "pastetext" && event.data.commandData.from == "keystrokeHandler") {
							event.cancel();
						}
					})
				});
			});
		});
	</script>
	<script type="text/javascript">
		function to_slug(str)
		{
			str = str.toLowerCase();     
			str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
			str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
			str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
			str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
			str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
			str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
			str = str.replace(/đ/gi, 'd');
			str = str.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
			str = str.replace(/ /gi, "-");
			str = str.replace(/\-\-\-\-\-/gi, '-');
			str = str.replace(/\-\-\-\-/gi, '-');
			str = str.replace(/\-\-\-/gi, '-');
			str = str.replace(/\-\-/gi, '-');
			str = '@' + str + '@';
			str = str.replace(/\@\-|\-\@|\@/gi, '');
			return str;
		}
		$(document).ready(function(e) {
			$('#ten').keyup(function(){
				var text = $(this).val();
				str = to_slug(text);
				var  ischeck = $('#checkurl').prop('checked');
				if(ischeck){
					$("#tenkhongdau").val(str);
				}
			})
			$("#checkurl").click(function(){
				if($('#checkurl').prop('checked')){
					var text = $("#ten").val();
					str = to_slug(text);
					$("#tenkhongdau").val(str);
				}
			});
			$("a.diamondToggle").click(function(){
				if($(this).attr("rel")==0){
					$.ajax({
						type: "POST",
						url: "ajax/ajax_hienthi.php",
						data:{
							id: $(this).attr("data-val0"),
							bang: $(this).attr("data-val2"),
							type: $(this).attr("data-val3"),
							value:1
						}
					});
					$(this).addClass("diamondToggleOff");
					$(this).attr("rel",1);
				}else{
					$.ajax({
						type: "POST",
						url: "ajax/ajax_hienthi.php",
						data:{
							id: $(this).attr("data-val0"),
							bang: $(this).attr("data-val2"),
							type: $(this).attr("data-val3"),
							value:0
						}
					});
					$(this).removeClass("diamondToggleOff");
					$(this).attr("rel",0);
				}
			});
		});
	</script>
	</html>