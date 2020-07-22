<script language="javascript">
  function select_onchange()
  {
    var chuoi = "";if("<?=$_GET['act']?>"=='add' && "<?=$_GET['id_danhmuc']?>"<=0)
    chuoi= "&id_danhmuc="+document.getElementById("id_danhmuc").value;
    window.location = location.href.replace("id_danhmuc=<?=$_GET['id_danhmuc']?>", "id_danhmuc="+document.getElementById("id_danhmuc").value)+chuoi;
    return true;
  }
  function select_onchange1()
  {
    var chuoi = "";if("<?=$_GET['act']?>"=='add' && "<?=$_GET['id_list']?>"<=0)
    chuoi= "&id_list="+document.getElementById("id_list").value;
    window.location = location.href.replace("id_list=<?=$_GET['id_list']?>", "id_list="+document.getElementById("id_list").value)+chuoi;
    return true;
  }
  function select_onchange2()
  {
    var chuoi = "";if("<?=$_GET['act']?>"=='add' && "<?=$_GET['id_cat']?>"<=0)
    chuoi= "&id_cat="+document.getElementById("id_cat").value;
    window.location = location.href.replace("id_cat=<?=$_GET['id_cat']?>", "id_cat="+document.getElementById("id_cat").value)+chuoi;
    return true;
  }
</script>
<?php
function get_main_danhmuc()
  {
    global $d;
      $sql="select * from table_news_danhmuc where type='".$_REQUEST['type']."' order by stt,id desc";
      $d->query($sql);
      $result = $d->result_array();
      $str='<select id="id_danhmuc" name="id_danhmuc" onchange="select_onchange()" class="main_select select_danhmuc">
        <option value="">Danh mục cấp 1</option>';
      foreach ($result as $key => $row) {
        if($row["id"]==(int)@$_REQUEST["id_danhmuc"])
          $selected="selected";
        else
          $selected="";
        $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
      }
      $str.='</select>';
      return $str;
  }

function get_main_list()
  {
    global $d;
      $sql="select * from table_news_list where id_danhmuc='".$_REQUEST['id_danhmuc']."' order by stt,id desc";
      $d->query($sql);
      $result = $d->result_array();     
      $str='<select id="id_list" name="id_list" onchange="select_onchange1()" class="main_select select_danhmuc">
        <option value="">Danh mục cấp 2</option>';        
      foreach ($result as $key => $row) {
        if($row["id"]==(int)@$_REQUEST["id_list"])
          $selected="selected";
        else
          $selected="";       
        $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
        }
      $str.='</select>';
    return $str;
  }

function get_main_category()
  {
    global $d;
      $sql="select * from table_news_cat where id_list='".$_REQUEST['id_list']."' order by stt,id desc";
      $d->query($sql);
      $result = $d->result_array();     
      $str='<select id="id_cat" name="id_cat" onchange="select_onchange2()" class="main_select select_danhmuc">
        <option value="">Danh mục cấp 3</option>';        
      foreach ($result as $key => $row) {
        if($row["id"]==(int)@$_REQUEST["id_cat"])
          $selected="selected";
        else
          $selected="";
        $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
        }
      $str.='</select>';
    return $str;
  }

function get_main_item()
  {
    global $d;
      $sql="select * from table_news_item where id_cat='".$_REQUEST['id_cat']."' order by stt,id desc";
      $d->query($sql);
      $result = $d->result_array();     
      $str='<select id="id_item" name="id_item" class="main_select select_danhmuc">
        <option value="">Danh mục cấp 4</option>';        
      foreach ($result as $key => $row) {
        if($row["id"]==(int)@$_REQUEST["id_item"])
          $selected="selected";
        else
          $selected="";
        $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
        }
      $str.='</select>';
    return $str;
  }
$d->reset();
$sql_images="select * from #_hinhanh where id_hinhanh='".$item['id']."' and type='".$_GET['type']."' order by stt, id desc ";
$d->query($sql_images);
$ds_photo=$d->result_array();
?>
<div class="control_frm" style="margin-top:25px;">
  <div class="bc">
    <ul id="breadcrumbs" class="breadcrumbs">
      <li><a href="index.php?com=news&act=man<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Bài viết</span></a></li>
      <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
    </ul>
    <div class="clear"></div>
  </div>
</div>
<div class="control_frm" style="margin-top:0;">
 <div style="float:left;">
   <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
   <a href="index.php?com=news&act=man<?php if($_REQUEST['p']!='') echo'&p='.$_REQUEST['p'];?><?php if($_REQUEST['type']!='') echo'&type='.$_REQUEST['type'];?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
   <input type="button" class="blueB taoseo" value="Tạo seo" />
 </div>
</div>
<script type="text/javascript">
  function TreeFilterChanged2(){
    $('#validate').submit();
  }
</script>
<form name="supplier" id="validate" class="form" action="index.php?com=news&act=save&p=<?=$_REQUEST['p']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" method="post" enctype="multipart/form-data">
 <div class="widget">
    <?php if(in_array('danhmuc',$config['type'])) { ?>
      <div class="formRow ">
       <label>Chọn danh mục 1</label>
       <div class="formRight">
         <?=get_main_danhmuc()?>
       </div>
       <div class="clear"></div>
     </div>
   <?php } ?>
   <?php if(in_array('list',$config['type'])) { ?>
    <div class="formRow ">
     <label>Chọn danh mục cấp 2</label>
     <div class="formRight">
       <?=get_main_list()?>
     </div>
     <div class="clear"></div>
   </div>
  <?php } ?>
  <?php if(in_array('hinhanh',$config['type'])) { ?>
    <div class="formRow">
     <label><?= (!empty($config['title']['hinhanh'])) ? $config['title']['hinhanh'] : "Tải hình ảnh" ?>:</label>
     <div class="formRight">
       <input type="file" id="file" name="file" />
       <img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
       <div class="note"> Width:<?= _width_thumb2 ?>px | Height:<?= _height_thumb2 ?>px<?=_format_duoihinh_l?> </div>
     </div>
     <div class="clear"></div>
     <?php if(in_array('img-size',$config['type'])) { ?>
      <!-- Trigger/Open The Modal -->
      <span id="myBtn">Xem kích thước up hình</span>

      <!-- The Modal -->
      <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
          <span class="close">&times;</span>
          <p style="text-align: center"><img src="images/kichthuoc.jpg" alt="guide" style="max-width: 100%"></p>
        </div>

      </div>

      <script>
      // Get the modal
      var modal = document.getElementById("myModal");

      // Get the button that opens the modal
      var btn = document.getElementById("myBtn");

      // Get the <span> element that closes the modal
      var span = document.getElementsByClassName("close")[0];

      // When the user clicks the button, open the modal 
      btn.onclick = function() {
        modal.style.display = "block";
      }

      // When the user clicks on <span> (x), close the modal
      span.onclick = function() {
        modal.style.display = "none";
      }

      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
      </script>
     <?php } ?>
   </div>
   <?php if($_GET['act']=='edit'){?>
    <div class="formRow">
     <label>Hình Hiện Tại :</label>
     <div class="formRight">
       <div class="mt10"><img src="<?=_upload_tintuc.$item['photo']?>"  width="100px" alt="NO PHOTO" width="100" /></div>
     </div>
     <div class="clear"></div>
   </div>
  <?php } ?>
  <?php } ?>
  <?php if(in_array('hinhanh2',$config['type'])) { ?>
    <div class="formRow">
     <label><?= (!empty($config['title']['hinhanh2'])) ? $config['title']['hinhanh2'] : "Tải hình ảnh" ?>:</label>
     <div class="formRight">
       <input type="file" id="file2" name="file2" />
       <img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
       <div class="note"> Width:<?= _width_thumb4 ?>px | Height:<?= _height_thumb4 ?>px<?=_format_duoihinh_l?> </div>
     </div>
     <div class="clear"></div>
   </div>
   <?php if($_GET['act']=='edit'){?>
    <div class="formRow">
     <label>Hình Hiện Tại :</label>
     <div class="formRight">
       <div class="mt10"><img src="<?=_upload_tintuc.$item['photo2']?>"  width="100px" alt="NO PHOTO" width="100" /></div>
     </div>
     <div class="clear"></div>
   </div>
  <?php } ?>
  <?php } ?>
  <?php if(in_array('taptin',$config['type'])) { ?>
    <div class="formRow aliceblueBack">
     <label>Tải tập tin:</label>
     <div class="formRight">
       <input type="file" id="taptin" name="taptin" />
       <img src="./images/question-button.png" alt="Upload tập tin" class="icon_question tipS" original-title="Tải tập tin">
       <div class="note"> <?=_format_duoitailieu_l?> </div>
     </div>
     <div class="clear"></div>
   </div>
   <?php if($_GET['act']=='edit'){?>
    <div class="formRow aliceblueBack">
     <label>Tập tin :</label>
     <div class="formRight">
       <div class="mt10"><strong><a href="<?=_upload_khac.$item['taptin']?>" download><i class="fas fa-cloud-download-alt"></i> Tập tin</a></strong></div>
     </div>
     <div class="clear"></div>
   </div>
  <?php } ?>
  <?php } ?>
  <?php if(in_array('hinhthem',$config['type'])) { ?>
    <div class="formRow">
      <label>Hình ảnh kèm theo: </label>
      <img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
      <div class="note"> Width:<?= _width_thumb2 ?>px | Height:<?= _height_thumb2 ?>px<?=_format_duoihinh_l?> </div>
      <?php if($act=='edit'){?>
       <div class="formRight">
        <?php if(count($ds_photo)!=0){?>
          <?php for($i=0;$i<count($ds_photo);$i++){?>
            <div class="item_trich trich<?=$ds_photo[$i]['id']?>" id="<?=md5($ds_photo[$i]['id'])?>">
             <img class="img_trich" width="100px" height="80px" src="<?=_upload_hinhthem.$ds_photo[$i]['photo']?>" />
             <input data-val0="<?=$ds_photo[$i]['id']?>" data-val2="table_hinhanh" data-val3="stt" onblur="stt(this);" type="text" rel="<?=$ds_photo[$i]['id']?>" value="<?=$ds_photo[$i]['stt']?>" class="update_stt tipS" />
             <a style="cursor:pointer" class="remove_images" data-id="<?=$ds_photo[$i]['id']?>"><i class="fa fa-trash-o"></i></a>
           </div>
         <?php }?>
       <?php }?>
     </div>
   <?php }?>
   <div class="formRight">
    <a class="file_input" data-jfiler-name="files" data-jfiler-extensions="jpg, jpeg, png, gif"><i class="fa fa-paperclip"></i>Thêm ảnh</a>
  </div>
  <div class="clear"></div>
  </div>
  <?php } ?>
  
  <?php if(in_array('color',$config['type'])) { ?>
    <div class="formRow">
      <label>Màu nền :</label>
      <div class="formRight">
        <input type="text" autocomplete="off" name="color" value="<?=@$item['color']?>" class="input form-control short_input cp3" />
      </div>
      <div class="clear"></div>    
    </div>
    <style>
    .formRow input.short_input {
      width: 200px;
    }
  </style>
  <script>
    $(document).ready(function() {
      $('#picker').css('border-right','20px solid #<?=@$item['color']?>');
      $('#picker').css('border-color','#<?=@$item['color']?>'); 
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function(e) {
      $('#picker').colpick({
        layout:'hex',
        submit:0,
        colorScheme:'dark',
        onChange:function(hsb,hex,rgb,el,bySetColor) {
          $(el).css('border-right','20px solid #'+hex);
          $(el).css('border-color','#'+hex);
                  // Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
                  if(!bySetColor) $(el).val(hex);
                }
              }).keyup(function(){
                $(this).colpickSetColor(this.value);
              });
            })
          </script>
        <?php } ?>
        

 </div><!-- .widget  -->
 <div class="widget">
        <ul class="tabs">
         <?php foreach ($config['lang'] as $key => $value) { ?>
             <li>
                 <a href="#content_lang_<?=$key?>"><?=$value?></a>
             </li>
         <?php } ?>
     </ul>
     <?php foreach ($config['lang'] as $key => $value) { ?>
         <div id="content_lang_<?=$key?>" class="tab_content">
          <?php if(in_array('ten',$config['type'])) { ?>
           <div class="formRow">
             <label>Tên</label>
             <div class="formRight">
               <input type="text" name="data[ten<?=$key?>]" title="Nhập tên" id="ten<?=$key?>" class="tipS"
                value="<?=htmlspecialchars($item['ten'.$key])?>" />
             </div>
             <div class="clear"></div>
           </div>
           <?php if ($key=='') {?>
                <div class="formRow">
                    <label>Url</label>
                    <div class="formRight">
                        <input type="text" name="tenkhongdau" title="Nhập tên không dấu" id="tenkhongdau" 
                        class="tipS validate[required]" value="<?=@$item['tenkhongdau']?>" />
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                  <label>Đổi Url: <img src="./images/question-button.png" alt="Chọn loại" 
                    class="icon_que tipS" original-title=" "> </label>
                  <div class="formRight">
                      <input type="checkbox" name="checkurl" id="checkurl" value="0" 
                      <?=($checkurl==1)?'checked="checked"':''?> />
                  </div>
                  <div class="clear"></div>
              </div>
          <?php }?>
         <?php } ?>
         <?php if(in_array('ten2',$config['type'])) { ?>
             <div class="formRow">
                 <label><?= (!empty($config["title"]["ten2"]))?$config["title"]["ten2"]:"Tiêu đề" ?>:</label>
                 <div class="formRight">
                     <input type="text" name="data[ten2<?=$key?>]" title="Nhập nội dung" id="ten2<?=$key?>"
                      class="tipS" value="<?=@$item['ten2'.$key]?>" />
                 </div>
                 <div class="clear"></div>
             </div>
         <?php }?>
         <?php if(in_array('chucvu',$config['type'])) { ?>
           <div class="formRow">
             <label><?= (!empty($config['title']['chucvu'])) ? $config['title']['chucvu'] : "Chức vụ" ?></label>
             <div class="formRight">
               <input type="text" name="data[chucvu<?=$key?>]" title="Nhập nội dung" id="chucvu<?=$key?>" class="tipS" value="<?=@$item['chucvu'.$key]?>" />
             </div>
             <div class="clear"></div>
           </div>
         <?php } ?>
         <?php if(in_array('link',$config['type'])) { ?>
           <div class="formRow">
             <label><?= (!empty($config['title']['link'])) ? $config['title']['link'] : "Link" ?></label>
             <div class="formRight">
               <input type="text" name="data[link<?=$key?>]" title="Nhập nội dung" id="link<?=$key?>" class="tipS" value="<?=@$item['link'.$key]?>" />
             </div>
             <div class="clear"></div>
           </div>
         <?php } ?>
         <?php if(in_array('mota',$config['type'])) { 
           $cls_ck = (in_array('mota',$config['ck'])) ? 'class="ck_editor"' : "";
           ?>
           <div class="formRow">
             <label><?= (!empty($config['title']['mota'])) ? $config['title']['mota'] : "Mô tả ngắn" ?>:</label>
             <div class="formRight">
               <textarea <?php echo $cls_ck; ?> rows="8" cols="" title="Viết mô tả ngắn bài viết" class="tipS" name="data[mota<?=$key?>]" id="mota<?=$key?>"><?=@$item['mota'.$key]?></textarea>
             </div>
             <div class="clear"></div>
           </div>
         <?php } ?>
         <?php if(in_array('mota2',$config['type'])) { 
           $cls_ck = (in_array('mota2',$config['ck'])) ? 'class="ck_editor"' : "";
           ?>
           <div class="formRow">
             <label><?= (!empty($config['title']['mota2'])) ? $config['title']['mota2'] : "Mô tả" ?>:</label>
             <div class="formRight">
               <textarea <?php echo $cls_ck; ?> rows="8" cols="" title="Viết mô tả ngắn bài viết" class="tipS" name="data[mota2<?=$key?>]" id="mota2<?=$key?>"><?=@$item['mota2'.$key]?></textarea>
             </div>
             <div class="clear"></div>
           </div>
         <?php } ?>
         <?php if(in_array('noidung',$config['type'])) { ?>
           <div class="formRow">
             <label>Nội dung chính: <img src="./images/question-button.png" alt="Chọn loại"  class="icon_que tipS" original-title="Viết nội dung chính"> </label>
             <div class="formRight"><textarea class="ck_editor" name="data[noidung<?=$key?>]" id="noidung<?=$key?>" rows="8" cols="60"><?=@$item['noidung'.$key]?></textarea>
             </div>
             <div class="clear"></div>
           </div>
         <?php } ?>

         <?php if(in_array('vitri',$config['type'])) { ?>
           <div class="formRow">
             <label>Vị trí: <img src="./images/question-button.png" alt="Chọn loại"  class="icon_que tipS" original-title="Viết nội dung chính"> </label>
             <div class="formRight"><textarea class="ck_editor" name="data[vitri<?=$key?>]" id="vitri<?=$key?>" rows="8" cols="60"><?=@$item['vitri'.$key]?></textarea>
             </div>
             <div class="clear"></div>
           </div>
         <?php } ?>

         <?php if(in_array('tienich',$config['type'])) { ?>
           <div class="formRow">
             <label>Tiện ích: <img src="./images/question-button.png" alt="Chọn loại"  class="icon_que tipS" original-title="Viết nội dung chính"> </label>
             <div class="formRight"><textarea class="ck_editor" name="data[tienich<?=$key?>]" id="tienich<?=$key?>" rows="8" cols="60"><?=@$item['tienich'.$key]?></textarea>
             </div>
             <div class="clear"></div>
           </div>
         <?php } ?>
         <?php if(in_array('matbang',$config['type'])) { ?>
           <div class="formRow">
             <label>Mặt bằng: <img src="./images/question-button.png" alt="Chọn loại"  class="icon_que tipS" original-title="Viết nội dung chính"> </label>
             <div class="formRight"><textarea class="ck_editor" name="data[matbang<?=$key?>]" id="matbang<?=$key?>" rows="8" cols="60"><?=@$item['matbang'.$key]?></textarea>
             </div>
             <div class="clear"></div>
           </div>
         <?php } ?>
         <?php if(in_array('hinhanhvi',$config['type'])) { ?>
           <div class="formRow">
             <label>Hình ảnh: <img src="./images/question-button.png" alt="Chọn loại"  class="icon_que tipS" original-title="Viết nội dung chính"> </label>
             <div class="formRight"><textarea class="ck_editor" name="data[hinhanh<?=$key?>]" id="hinhanh<?=$key?>" rows="8" cols="60"><?=@$item['hinhanh'.$key]?></textarea>
             </div>
             <div class="clear"></div>
           </div>
         <?php } ?>

      </div><!-- End content <?=$key?> -->
    <?php } ?>

  </div>      <!-- .widget  -->
  <div class="widget">
    <?php if(in_array('gia',$config['type'])) { ?>
    <div class="formRow">
      <label>Giá</label>
      <div class="formRight">
        <input type="text" name="gia" title="Nhập giá" id="gia" class="tipS" value="<?=@$item['gia']?>" />
      </div>
      <div class="clear"></div>
    </div>
  <?php } ?>
  </div>
  <?php if(in_array('seo',$config['type'])) include _template."seo_tpl.php"; ?>
  <div class="widget">
    <?php if(in_array('noibat',$config['type'])) { ?>
      <div class="formRow">
        <label><?= (!empty($config['title']['noibat'])) ? $config['title']['noibat'] : "Nổi bật" ?> : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này !"> </label>
        <div class="formRight">
          <input type="checkbox" name="noibat" id="check1" <?=($item['noibat']==1)?'checked="checked"':''?> />
        </div>
        <div class="clear"></div>
      </div>
    <?php } ?>
    <?php if(in_array('spmoi',$config['type'])) { ?>
      <div class="formRow ">
        <label>Mới : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này !"> </label>
        <div class="formRight">
          <input type="checkbox" name="spmoi" id="check1" <?=($item['spmoi']==1)?'checked="checked"':''?> />
        </div>
        <div class="clear"></div>
      </div>
    <?php } ?>
    <div class="formRow">
      <label>Hiển thị : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này ! "> </label>
      <div class="formRight">
        <input type="checkbox" name="hienthi" id="check1" <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked="checked"':''?> />
        <label>Số thứ tự: </label>
        <input type="text" class="tipS" value="<?=isset($item['stt'])?$item['stt']:1?>" name="stt" style="width:20px; text-align:center;" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" original-title="Số thứ tự của danh mục, chỉ nhập số">
      </div>
      <div class="clear"></div>
    </div>
    <div class="formRow">
      <div class="formRight">
        <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
        <input type="hidden" name="id" id="id" value="<?=@$item['id']?>" />
        <input type="hidden" name="type" id="id_this_type" value="<?=$_REQUEST['type']?>" />
        <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
        <a href="index.php?com=news&act=man<?php if($_REQUEST['p']!='') echo'&p='.$_REQUEST['p'];?><?php if($_REQUEST['type']!='') echo'&type='.$_REQUEST['type'];?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
      </div>
      <div class="clear"></div>
    </div>
  </div>      <!-- .widget  -->
</form>
<script type="text/javascript">
  $(document).ready(function(e) {
    $('.remove_images').click(function(){
     var id=$(this).data("id");
     $.ajax({
      type: "POST",
      url: "ajax/xuly_admin_dn.php",
      data: {id:id, act: 'remove_image'},
      success:function(data){
       $jdata = $.parseJSON(data);
       $("#"+$jdata.md5).fadeOut(500);
       setTimeout(function(){
        $("#"+$jdata.md5).remove();
      }, 1000)
     }
   })
   })
    $('.update_stt').blur(function(){
     var a=$(this).val();
     $.ajax({
      type: "POST",
      url: "ajax/ajax_hienthi.php",
      data:{
       id: $(this).attr("data-val0"),
       bang: $(this).attr("data-val2"),
       type: $(this).attr("data-val3"),
       value:a
     },
     success:function(kq){
       alert('Cập nhật stt thành công.');
     }
   });
   })
  });
</script>
<script>
  $(document).ready(function() {
    $('.file_input').filer({
      showThumbs: true,
      templates: {
        box: '<ul class="jFiler-item-list"></ul>',
        item: '<li class="jFiler-item">\
        <div class="jFiler-item-container">\
        <div class="jFiler-item-inner">\
        <div class="jFiler-item-thumb">\
        <div class="jFiler-item-status"></div>\
        <div class="jFiler-item-info">\
        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
        </div>\
        {{fi-image}}\
        </div>\
        <div class="jFiler-item-assets jFiler-row">\
        <ul class="list-inline pull-left">\
        <li><span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span></li>\
        </ul>\
        <ul class="list-inline pull-right">\
        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
        </ul>\
        </div>\<input type="text" name="stthinh[]" class="stthinh" />\
        </div>\
        </div>\
        </li>',
        itemAppend: '<li class="jFiler-item">\
        <div class="jFiler-item-container">\
        <div class="jFiler-item-inner">\
        <div class="jFiler-item-thumb">\
        <div class="jFiler-item-status"></div>\
        <div class="jFiler-item-info">\
        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
        </div>\
        {{fi-image}}\
        </div>\
        <div class="jFiler-item-assets jFiler-row">\
        <ul class="list-inline pull-left">\
        <span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span>\
        </ul>\
        <ul class="list-inline pull-right">\
        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
        </ul>\
        </div>\<input type="text" name="stthinh[]" class="stthinh" />\
        </div>\
        </div>\
        </li>',
        progressBar: '<div class="bar"></div>',
        itemAppendToEnd: true,
        removeConfirmation: true,
        _selectors: {
          list: '.jFiler-item-list',
          item: '.jFiler-item',
          progressBar: '.bar',
          remove: '.jFiler-item-trash-action',
        }
      },
      addMore: true
    });
});
</script>