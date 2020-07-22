<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
            <li><a href="index.php?com=title&act=capnhat&type=<?=$_REQUEST['type']?>"><span>Nội dung</span></a></li>
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
<form name="supplier" id="validate" class="form" action="index.php?com=title&act=save&type=<?=$_REQUEST['type']?>" method="post" enctype="multipart/form-data">
    <div class="widget">
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
         
    </div>      <!-- .widget  -->
    <div class="widget">
        <div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
            <h6>Nội dung seo</h6>
        </div>
         <div class="formRow">
             <label>Title</label>
             <div class="formRight">
                 <input type="text" value="<?=@$item['title']?>" name="title" title="Nội dung thẻ meta Title dùng để SEO" class="tipS" />
             </div>
             <div class="clear"></div>
         </div>
         <div class="formRow">
             <label>Từ khóa</label>
             <div class="formRight">
                 <input type="text" value="<?=@$item['keywords']?>" name="keywords" title="Từ khóa chính cho sản phẩm" class="tipS" />
             </div>
             <div class="clear"></div>
         </div>
         <div class="formRow">
             <label>Description:</label>
             <div class="formRight">
                 <textarea rows="8" cols="" title="Nội dung thẻ meta Description dùng để SEO" class="tipS description_input" name="description"><?=@$item['description']?></textarea>
                 ký tự <b>(Tốt nhất là 160 ký tự)</b>
             </div>
             <div class="clear"></div>
         </div>
         
    </div><!-- .widget  -->
    <div class="widget">
         <div class="formRow">
             <div class="formRight">
                <input type="hidden" name="id" id="id" value="<?=@$item['id']?>" />
                <input type="hidden" name="type" id="type" value="<?=@$item['type']?>" />
                <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
                <input type="button" class="blueB" value="Xóa" onclick="location.href='index.php?com=title&act=delete&type=<?= $_REQUEST['type'] ?>'">
            </div>
            <div class="clear"></div>
        </div>
    </div><!-- .widget  -->
</form>