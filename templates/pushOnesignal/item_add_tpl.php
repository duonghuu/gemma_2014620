<style>
	.reviewOnesignal{
    width: 450px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 1px 1px 1px #ccc;
    padding: 5px;
    position: relative;
}
.reviewOnesignal .img{float: left;}
.reviewOnesignal .img  img{width: 150px;height: 150px;}
.reviewOnesignal .detail{
    float: left;
    margin-left: 10px;
    width: 290px;
}
.reviewOnesignal .detail h2{
    font-size: 16px;
}
.reviewOnesignal .detail h3{
    margin-top: 10px;
    font-size: 13px;
}
.reviewOnesignal .detail h4{
    position: absolute;
    left: 165px;
    bottom: 10px;
    color: #999;
    font-weight: normal;
    font-size: 13px;
}
input[type="number"]{padding: 5px 10px;}
.formRightsmall{width: 20%; float: left; margin-left: 2%}
.formRightsmall label{width: 30%;}
.formRightsmall input{width: 70%;}
.imgview{width: 450px;height: auto;}
</style>

<link href="../plugin/datetimepicker/css/datepicker.min.css" rel="stylesheet" type="text/css" media="screen" />
<div class="wrapper">
	<div class="control_frm" style="margin-top:25px;">
		<div class="bc">
			<ul id="breadcrumbs" class="breadcrumbs">
				<li><a href="index.php?com=pushOnesignal&act=man"><span>Thêm Push OneSignal</span></a></li>
				<li class="current"><a href="#" onclick="return false;">Thêm</a></li>
			</ul>
			<div class="clear"></div>
		</div>
	</div>
	<form name="supplier" id="validate" class="form" action="index.php?com=pushOnesignal&act=save<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" method="post" enctype="multipart/form-data">
		<div class="widget">
		      <div class="formRow">
		        <label>Tải hình ảnh:</label>
		        <div class="formRight">
		          <input type="file" id="file" name="file" onchange="imgreview(this);" />
		          <img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
		          <div class="note"> width : <?php echo _width_thumb*$ratio_;?> px , Height : <?php echo _height_thumb*$ratio_;?> px </div>
		        </div>
		        <div class="clear"></div>
		      </div>
		      <?php if($_GET['act']=='edit'){?>
		      <div class="formRow">
		        <label>Hình Hiện Tại :</label>
		        <div class="formRight">
		          <div class="mt10"><img src="<?='../upload/onesignal/'.$item['thumb_vi']?>"  alt="NO PHOTO" width="100" /></div>
		        </div>
		        <div class="clear"></div>
		      </div>
		      <?php  } ?>
		      <div class="formRow lang_hidden lang_vi active">
		        <label>Tiêu đề</label>
		        <div class="formRight">
		          <input type="text" name="ten_vi" title="Nhập tên bài viết" id="ten_vi" class="tipS validate[required]" value="<?=@$item['ten_vi']?>" />
		        </div>
		        <div class="clear"></div>
		      </div>
		      <div class="formRow lang_hidden lang_vi active">
		        <label>Mô tả</label>
		        <div class="formRight">
		          <textarea rows="4" cols="" title="Nhập mô tả" class="tipS" id="mota_vi" name="mota_vi"><?=@$item['mota_vi']?></textarea>
		        </div>
		        <div class="clear"></div>
		      </div>
		      <div class="formRow lang_hidden lang_vi active">
		        <label>Liên kết</label>
		        <div class="formRight">
		          <input type="text" name="link" title="Nhập tên danh mục" id="link" class="tipS" value="<?=@$item['link']?>" placeholder="http://youlink.com"/>
		        </div>
		        <div class="clear"></div>
		      </div>
		<!--      <div class="formRow lang_hidden lang_vi active">
		        <label>Lưu và gửi thông báo</label>
		        <div class="formRight">
		          <input type="checkbox" name="status" title="Nhập tên danh mục" id="status" class="tipS" value="1" <?=(!isset($item['status']) || $item['status']==1)?'checked="checked"':''?>/>
		        </div>
		        <div class="clear"></div>
		      </div> -->
		    </div> 
		    <div class="widget">

		      <div class="formRow lang_hidden lang_vi active">
		        <label>Thời gian bắt đầu:</label>
		        <div class="formRight">
		          
		          <input type='text' name="thoigianbatdau" class="tipS datepicker-here" id='thoigianbatdau' data-timepicker="true" data-time-format='hh:ii aa' value="<?=date('d/m/Y h:i:s a',(int)$item['thoigianbatdau'])?>"/>

		          <?php /*?> <input type="text" name="link" title="Nhập tên danh mục" id="link" class="tipS" value="<?=@$item['link']?>" placeholder="http://youlink.com"/> <?php */?>
		        </div>
		        <div class="clear"></div>
		      </div>
		      <? //=  date('Y-m-d H:i:s TO',(int)$item['thoigianbatdau']) ?>

		      <div class="formRow lang_hidden lang_vi active">
		        <label>Số lần gửi:</label>
		        <div class="formRight">
		          <input type='number' name="solangui" class="tipS" placeholder="1" value="<?=@$item['solangui']=='' ? '1': @$item['solangui']?>" />
		        </div>
		        <div class="clear"></div>
		      </div>

		      <div class="formRow lang_hidden lang_vi active">
		        <label>Các lượt gửi cách nhau:</label>
		        <div class="formRightsmall">
		          <label for="phut">Giờ</label>
		          <input type='number' name="gio" class="tipS " id='gio' placeholder="0" value="<?=@$item['gio'] == '' ? '0' : @$item['gio'] ?>"  />
		        </div>
		        <div class="formRightsmall">
		          <label for="phut">Phút</label>
		          <input type='number' name="phut" class="tipS " id='phut' placeholder="0"  value="<?=@$item['phut'] == '' ? '0' : @$item['phut'] ?>"  />
		        </div>
		        <div class="formRightsmall">
		          <label for="phut">Giây</label>
		          <input type='number' name="giay" class="tipS " id='giay' placeholder="0"  value="<?=@$item['giay'] == '' ? '0' : @$item['giay'] ?>"  />
		        </div>
		        <div class="clear"></div>
		      </div>

		    </div>
		    <div class="widget">
		      <div class="formRow">   
		        <label for="">Xem trước</label> 
		        <div class="formRight">
		          <div class="reviewOnesignal">
		            <div class="img">
		              <img src="../logo.png" alt="images">
		            <?/*  <img class="imgview" src="<?=  empty($item['thumb'])?'images/150x150.png':'../upload/onesignal/'.$item['thumb'] ?>   " alt="images"> */?>
		            </div>
		            <div class="detail">
		              <h2 id="caption"><?=  empty($item['ten_vi'])?'OneSignal Web  Push Notification':$item['ten_vi'] ?></h2>
		              <h3 id="desc"><?=  empty($item['mota_vi'])?'This is an example of web push notifications.':catchuoi($item['mota_vi'],120) ?></h3>
		              <h4 id="linkto"><?=  empty($item['link'])?'https://youlink.com':$item['link'] ?></h4>
		            </div>            
		            <div class="clear"></div>
		                          <img class="imgview" src="<?=  empty($item['thumb_vi'])?'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAACAQMAAACqpIQeAAAAA1BMVEX///+nxBvIAAAACklEQVQI12MAAgAABAABINItbwAAAABJRU5ErkJggg==':'../upload/onesignal/'.$item['thumb_vi'] ?>   " alt="images">
		          </div>
		        </div>
		        <div class="clear"></div>
		      </div>
		    </div>
		<div class="formRow">    
			<div class="formRight">
				<input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
				<input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Lưu lại" />
				<a href="index.php?com=pushOnesignal&act=man" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
			</div>
			<div class="clear"></div>
		</div>
	</form> 
</div>
<script>
	$(document).ready(function() {
		$('#ten_vi').keyup(function(event) {				
			document.getElementById("caption").innerHTML = this.value;
		});
		$('#ten_vi').change(function(event) {			
			
			document.getElementById("caption").innerHTML = this.value;
		});
		$('#mota_vi').keyup(function(event) {			
			var str = this.value.substring(1, 120);
			document.getElementById("desc").innerHTML = str+'...';
		});
		$('#mota_vi').change(function(event) {				
			var str = this.value.substring(1, 120);
			document.getElementById("desc").innerHTML = str+'...';
		});
		$('#link').keyup(function(event) {				
			document.getElementById("linkto").innerHTML = this.value;
		});
		$('#link').change(function(event) {				
			document.getElementById("linkto").innerHTML = this.value;
		});
	});
	function imgreview(input){
		if (input.files && input.files[0]) {
			var filerd = new FileReader();
			filerd.onload = function(e){
				$('.imgview').attr('src',e.target.result);
			};
			filerd.readAsDataURL(input.files[0]);
		}
	}


</script>

<?php /*?> .reviewOnesignal{
    width: 450px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 1px 1px 1px #ccc;
    padding: 5px;
    position: relative;
}
.reviewOnesignal .img{float: left;}
.reviewOnesignal .img  img{width: 150px;height: 150px;}
.reviewOnesignal .detail{
    float: left;
    margin-left: 10px;
    width: 290px;
}
.reviewOnesignal .detail h2{
    font-size: 16px;
}
.reviewOnesignal .detail h3{
    margin-top: 10px;
    font-size: 13px;
}
.reviewOnesignal .detail h4{
    position: absolute;
    left: 165px;
    bottom: 10px;
    color: #999;
    font-weight: normal;
    font-size: 13px;
} <?php */?>

<script src='../plugin/datetimepicker/js/datepicker.js' defer></script>