<?php 
$d->reset();
$sql_images="select * from #_hinhanh where type='".$_GET['type']."' order by stt, id desc ";
$d->query($sql_images);
$ds_photo=$d->result_array();
 ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.chonngonngu li a').click(function(event) {
            var lang = $(this).attr('href');
            $('.chonngonngu li a').removeClass('active');
            $(this).addClass('active');
            $('.lang_hidden').removeClass('active');
            $('.lang_'+lang).addClass('active');
            return false;
        });
    });
</script>
<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
            <li><a href="index.php?com=about&act=capnhat&type=<?=$_REQUEST['type']?>"><span>Nội dung</span></a></li>
            <li class="current"><a href="#" onclick="return false;">Cập nhật</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">
    function TreeFilterChanged2(){
        $('#validate').submit();
    }
</script>
<form name="supplier" id="validate" class="form" action="index.php?com=about&act=save&type=<?=$_REQUEST['type']?>" method="post" enctype="multipart/form-data">
    <div class="widget">
       <div class="formRow">
           <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
           <input type="button" class="blueB" value="Xóa" onclick="location.href='index.php?com=about&act=delete&type=<?= $_REQUEST['type'] ?>'">
       </div>
            <?php if(in_array('hinhanh',$config['type'])) { ?>
             <div class="formRow">
                 <label>Hình ảnh đại diện: </label>
                 <div class="formRight">
                     <?php if ($_REQUEST['act']=='capnhat') { ?>
                         <img width="100" src="<?=_upload_hinhanh.@$item['photo']?>"><br>
                     <?php }?>
                     <input type="file" id="file" name="file" /><img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình đại diện cho sản phẩm (ảnh JPEG, GIF , JPG , PNG)">
                     <div class="note">Width:<?=_width_thumb?>px | Height:<?=_height_thumb?>px <?=_format_duoihinh_l?> </div>
                 </div>
                 <div class="clear"></div>
             </div>
         <?php } ?>
                 <?php if(in_array('hinhthem',$config['type'])) { ?>
               <div class="formRow">
               <label>Hình ảnh kèm theo: </label>
                <?php if($act=='capnhat'){?>
                <div class="formRight">
               <?php if(count($ds_photo)!=0){?>
                     <?php for($i=0;$i<count($ds_photo);$i++){?>
                       <div class="item_trich trich<?=$ds_photo[$i]['id']?>" id="<?=md5($ds_photo[$i]['id'])?>">
                            <img class="img_trich" width="100px" height="80px" src="<?=_upload_hinhthem.$ds_photo[$i]['photo']?>" />

                            <input data-val0="<?=$ds_photo[$i]['id']?>" data-val2="table_hinhanh" type="text" value="<?=$ds_photo[$i]['stt']?>" name="stt<?=$i?>" data-val3="stt" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="tipS smallText update_stt" onblur="stt(this)" original-title="Nhập số thứ tự hình ảnh" rel="<?=$ds_photo[$i]['id']?>" />

                          <a style="cursor:pointer" class="remove_images" data-id="<?=$ds_photo[$i]['id']?>"><i class="fa fa-trash-o"></i></a>
                       </div>
                     <?php }?>

               <?php }?>
                 </div>
             <?php }?>
               <div class="formRight">
                   <a class="file_input" data-jfiler-name="files" data-jfiler-extensions="jpg, jpeg, png, gif"><i class="fa fa-paperclip"></i>Thêm ảnh</a>
                   <div class="note">Width:<?=_width_thumb?>px | Height:<?=_height_thumb?>px <?=_format_duoihinh_l?> </div>
               </div>
                   <div class="clear"></div>
                 </div>
             <?php } ?>
         <?php if(in_array('link',$config['type'])) { ?>
             <div class="formRow">
                 <label><?= (!empty($config['title']['link'])) ? $config['title']['link'] : "Link" ?></label>
                 <div class="formRight">
                     <input type="text" name="link" title="Nhập nội dung" id="link" class="tipS" value="<?=@$item['link']?>" />
                 </div>
                 <div class="clear"></div>
             </div>
         <?php } ?>
         
    </div>      <!-- .widget  -->
    <div class="widget">
           <ul class="tabs">
            <?php foreach ($config['lang'] as $key => $value) { ?>
                <li>
                    <a href="#content_lang_<?=$key?>"><?=$value?></a>
                </li>
            <?php } ?>
        </ul>
        <?php foreach ($config['lang'] as $key => $value) { ?>
         <div id="content_lang_<?=$key?>" class="tab_content <?php if($_REQUEST['type']!='lienhe' && $_REQUEST['type']!='footer' && $value=='')echo 'info' ?>">
            <div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
                <h6>Nội dung <?=$value?></h6>
            </div>
            <?php if(in_array('ten',$config['type'])) { ?>
                <div class="formRow">
                    <label><?= (!empty($config["title"]["ten"]))?$config["title"]["ten"]:"Tiêu đề" ?>:</label>
                    <div class="formRight">
                        <input type="text" name="ten<?=$key?>" title="Nhập nội dung" id="ten<?=$key?>" 
                        class="tipS" value="<?=@$item['ten'.$key]?>" />
                    </div>
                    <div class="clear"></div>
                </div>
            <?php }?>
            <?php if(in_array('ten2',$config['type'])) { ?>
                <div class="formRow">
                    <label><?= (!empty($config["title"]["ten2"]))?$config["title"]["ten2"]:"Tiêu đề" ?>:</label>
                    <div class="formRight">
                        <input type="text" name="ten2<?=$key?>" title="Nhập nội dung" id="ten2<?=$key?>"
                         class="tipS" value="<?=@$item['ten2'.$key]?>" />
                    </div>
                    <div class="clear"></div>
                </div>
            <?php }?>
            <?php if(in_array('mota',$config['type'])) { 
        $cls_ck = (in_array('mota',$config['ck'])) ? 'class="ck_editor"' : "";
                ?>
                <div class="formRow">
                    <label><?= (!empty($config["title"]["mota"]))?$config["title"]["mota"]:"Mô tả ngắn" ?>:</label>
                    <div class="formRight">
                        <textarea <?php echo $cls_ck; ?>  rows="8" cols="" title="Viết mô tả ngắn bài viết" class="tipS" name="mota<?=$key?>" id="mota<?=$key?>"><?=@$item['mota'.$key]?></textarea>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php }?>
                <?php if(in_array('mota2',$config['type'])) { 
            $cls_ck = (in_array('mota2',$config['ck'])) ? 'class="ck_editor"' : "";
                    ?>
                    <div class="formRow">
                        <label><?= (!empty($config["title"]["mota2"]))?$config["title"]["mota2"]:"Mô tả" ?>:</label>
                        <div class="formRight">
                            <textarea <?php echo $cls_ck; ?>  rows="8" cols="" title="Viết mô tả ngắn bài viết" class="tipS" name="mota2<?=$key?>" id="mota2<?=$key?>"><?=@$item['mota2'.$key]?></textarea>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php }?>
            <?php if(in_array('noidung',$config['type'])) { ?>
            <div class="formRow">
                <label>Nội dung chính: <img src="./images/question-button.png" alt="Chọn loại"  class="icon_que tipS" original-title="Viết nội dung chính"> </label>
                <div class="formRight"><textarea class="ck_editor" name="noidung<?=$key?>" id="noidung<?=$key?>" rows="8" cols="60"><?=@$item['noidung'.$key]?></textarea>
                </div>
                <div class="clear"></div>
            </div>
            <?php } ?>
        </div><!-- End content <?=$key?> -->
        <?php } ?>
    </div><!-- .widget  -->
    <?php if(in_array('seo',$config['type'])) include _template."seo_tpl.php"; ?>
    <div class="widget">
         <div class="formRow">
           <label>Tùy chọn: <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Check vào những tùy chọn "> </label>
           <div class="formRight">
             <input type="checkbox" name="hienthi" id="check1" <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked="checked"':''?> />
             <label for="check1">Hiển thị</label>
             </div>
             <div class="clear"></div>
         </div>
         <div class="formRow">
             <input type="hidden" name="id" id="id" value="<?=@$item['id']?>" />
                             <input type="hidden" name="type" id="type" value="<?=@$item['type']?>" />
                             <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
                             <input type="button" class="blueB" value="Xóa" onclick="location.href='index.php?com=about&act=delete&type=<?= $_REQUEST['type'] ?>'">
        </div>
    </div><!-- .widget  -->
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