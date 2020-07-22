<div class="control_frm" style="margin-top:25px;">
  <div class="bc">
    <ul id="breadcrumbs" class="breadcrumbs">
     <li><a href="index.php?com=product&act=man_danhmuc<?php if($_REQUEST['type']!='') 
     echo'&type='. $_REQUEST['type'];?>"><span>Danh mục</span></a></li>
     <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
   </ul>
   <div class="clear"></div>
 </div>
</div>
<div class="control_frm" style="margin-top:0;">
 <div style="float:left;">
   <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
   <a href="index.php?com=product&act=man_danhmuc<?php if($_REQUEST['p']!='') 
   echo'&p='.$_REQUEST['p'];?><?php if($_REQUEST['type']!='') echo'&type='.$_REQUEST['type'];?>" 
   onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" 
   class="button tipS" original-title="Thoát">Thoát</a>
   <input type="button" class="blueB taoseo" value="Tạo seo" />
 </div>
</div>
<script type="text/javascript">
  function TreeFilterChanged2(){
    $('#validate').submit();
  }
</script>
<form name="supplier" id="validate" class="form" action="index.php?com=product&act=save_danhmuc
<?php if($_REQUEST['p']!='') echo'&p='.$_REQUEST['p'];?><?php if($_REQUEST['type']!='') 
echo '&type='. $_REQUEST['type'];?>" method="post" enctype="multipart/form-data">
 <div class="widget">

    <?php if(in_array('maunen',$config['type'])) { ?>
      <div class="formRow">
        <label>Màu nền</label>
        <div class="formRight">
          <input type="text" name="maunen" title="Màu nền" id="maunen" class="input short_input cp3" 
          value="<?=@$item['maunen']?>" />
        </div>
        <div class="clear"></div>
      </div>
    <?php } ?>
    <?php if(in_array('hinhanh',$config['type'])) { ?>
      <div class="formRow">
       <label>Tải hình ảnh:</label>
       <div class="formRight">
         <input type="file" id="file" name="file" />
         <img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" 
         original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
         <div class="note">Width:<?=_width_thumb2?>px | Height:<?=_height_thumb2?>px <?=_format_duoihinh_l?> </div>
       </div>
       <div class="clear"></div>
     </div>
     <?php if($_GET['act']=='edit_danhmuc'){?>
      <div class="formRow">
       <label>Hình Hiện Tại :</label>
       <div class="formRight">
         <div class="mt10"><img src="<?=_upload_sanpham.$item['photo']?>"  width="100px" alt="NO PHOTO" width="100" /></div>
       </div>
       <div class="clear"></div>
     </div>
   <?php } ?>
  <?php } ?>
  <?php 
  if(in_array('hinhthem',$config['type'])) { ?>
    <div class="formRow">
      <label>Hình ảnh kèm theo: </label>
      <?php if($act=='edit_danhmuc'){?>
       <div class="formRight">
        <?php if(count($ds_photo)!=0){?>
          <?php for($i=0;$i<count($ds_photo);$i++){?>
            <div class="item_trich trich<?=$ds_photo[$i]['id']?>" id="<?=md5($ds_photo[$i]['id'])?>">
             <img class="img_trich" width="100px" height="80px" src="<?=_upload_hinhthem.$ds_photo[$i]['photo']?>" />
             <input data-val0="<?=$ds_photo[$i]['id']?>" data-val2="table_hinhanh" type="text" 
             value="<?=$ds_photo[$i]['stt']?>" name="stt<?=$i?>" data-val3="stt" 
             onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" 
             class="tipS smallText update_stt" onblur="stt(this)" original-title="Nhập số thứ tự hình ảnh" 
             rel="<?=$ds_photo[$i]['id']?>" />
             <a style="cursor:pointer" class="remove_images" data-id="<?=$ds_photo[$i]['id']?>"><i class="fa fa-trash-o"></i></a>
           </div>
         <?php }?>
       <?php }?>
     </div>
   <?php }?>
   <div class="formRight">
    <a class="file_input" data-jfiler-name="files" data-jfiler-extensions="jpg, jpeg, png, gif">
      <i class="fa fa-paperclip"></i>Thêm ảnh</a>
    <div class="note">Width:<?=_widthhinhanh_thumb?>px | Height:<?=_heighthinhanh_thumb?>px <?=_format_duoihinh_l?> </div>
  </div>
  <div class="clear"></div>
  </div>
  <?php } ?>
  <?php if(in_array('hinhanh2',$config['type'])) { ?>
    <div class="formRow">
      <label>Tải <?= (!empty($config['title']['hinhanh2'])) ? $config['title']['hinhanh2']: 'banner' ?>:</label>
      <div class="formRight">
        <input type="file" id="file2" name="file2" />
        <img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" 
        original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
        <div class="note">Width:<?=_widthhinhanh_thumb2?>px | Height:<?=_heighthinhanh_thumb2?>px <?=_format_duoihinh_l?> </div>
      </div>
      <div class="clear"></div>
    </div>
    <?php if($_GET['act']=='edit_danhmuc'){?>
      <div class="formRow">
        <label>Hình <?= (!empty($config['title']['hinhanh2'])) ? $config['title']['hinhanh2']: 'banner' ?> :</label>
        <div class="formRight">
          <div class="mt10"><img src="<?=_upload_sanpham.$item['photo2']?>"  width="100px" alt="NO PHOTO" width="100" /></div>
        </div>
        <div class="clear"></div>
      </div>
    <?php } ?>
  <?php } ?>
 </div>
 <div class="widget">
         <ul class="tabs">
          <?php foreach ($config['lang'] as $key => $value) { ?>
              <li>
                  <a href="#content_lang_<?=$key?>"><?=$value?></a>
              </li>
          <?php } ?>
      </ul>
      <?php foreach ($config['lang'] as $key => $value) {
        ?>
        <div id="content_lang_<?=$key?>" class="tab_content">
            <?php if(in_array('ten',$config['type'])) { ?>
             <div class="formRow">
               <label>Tên bài viết</label>
               <div class="formRight">
                 <input type="text" name="ten<?=$key?>" title="Nhập tên bài viết" id="ten<?=$key?>" class="tipS"
                  value="<?=@$item['ten'.$key]?>" />
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
           <?php if(in_array('mota',$config['type'])) { ?>
             <div class="formRow">
               <label>Mô tả ngắn:</label>
               <div class="formRight">
                 <textarea rows="8" cols="" title="Viết mô tả ngắn bài viết" class="tipS" name="mota<?=$key?>"
                  id="mota<?=$key?>"><?=@$item['mota'.$key]?></textarea>
               </div>
               <div class="clear"></div>
             </div>
           <?php } ?>
           <?php if(in_array('noidung',$config['type'])) { ?>
             <div class="formRow ">
               <label>Nội dung:</label>
               <div class="formRight">
                 <textarea rows="8" cols="" title="Viết nội dung bài viết" class="tipS ck_editor" 
                 name="noidung<?=$key?>" id="noidung<?=$key?>"><?=@$item['noidung'.$key]?></textarea>
               </div>
               <div class="clear"></div>
             </div>
           <?php } ?>
           
        </div>
      <?php } ?>
    </div>
 <?php if(in_array('seo',$config['type'])) include _template."seo_tpl.php"; ?>
 <div class="widget">
  <?php if(in_array('noibat',$config['type'])) { ?>
    <div class="formRow">
      <label>Nổi bật : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" 
        original-title="Bỏ chọn để không hiển thị danh mục này ! "> </label>
      <div class="formRight">
        <input type="checkbox" name="noibat" id="check1" <?=($item['noibat']>0)?'checked="checked"':''?> />
      </div>
      <div class="clear"></div>
    </div>
  <?php } ?>
  <div class="formRow">
    <label>Hiển thị : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" 
      original-title="Bỏ chọn để không hiển thị danh mục này ! "> </label>
    <div class="formRight">
      <input type="checkbox" name="hienthi" id="check1" 
      <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked="checked"':''?> />
      <label>Số thứ tự: </label>
      <input type="text" class="tipS" value="<?=isset($item['stt'])?$item['stt']:1?>" name="stt" 
      style="width:20px; text-align:center;" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')"
       original-title="Số thứ tự của danh mục, chỉ nhập số">
    </div>
    <div class="clear"></div>
  </div>
  <div class="formRow">
      <input type="hidden" name="id" id="id" value="<?=@$item['id']?>" />
      <input type="hidden" name="type" id="id_this_type" value="<?=$_REQUEST['type']?>" />
      <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
      <a href="index.php?com=product&act=man_danhmuc<?php if($_REQUEST['p']!='') echo'&p='.$_REQUEST['p'];?>
      <?php if($_REQUEST['type']!='') echo'&type='.$_REQUEST['type'];?>" 
      onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS"
       original-title="Thoát">Thoát</a>
  </div>
 </div>
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