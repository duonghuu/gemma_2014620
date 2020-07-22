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
     <input type="text" value="<?=@$item['keywords']?>" name="keywords" title="Từ khóa chính cho bài viết" class="tipS" />
   </div>
   <div class="clear"></div>
 </div>
 <div class="formRow">
   <label>Description:</label>
   <div class="formRight">
     <textarea rows="8" cols="" title="Nội dung thẻ meta Description dùng để SEO" class="tipS description_input" name="description"><?=@$item['description']?></textarea>
     <b>(Tốt nhất là 68 - 170 ký tự)</b>
   </div>
   <div class="clear"></div>
 </div>
 <div class="formRow">
   <label>H1</label>
   <div class="formRight">
     <input type="text" value="<?=@$item['h1']?>" name="h1" title="" class="tipS" />
   </div>
   <div class="clear"></div>
 </div>
<?php /* 
 <div class="formRow">
   <label>H2</label>
   <div class="formRight">
     <input type="text" value="<?=@$item['h2']?>" name="h2" title="" class="tipS" />
   </div>
   <div class="clear"></div>
 </div>
 <div class="formRow">
   <label>H3</label>
   <div class="formRight">
     <input type="text" value="<?=@$item['h3']?>" name="h3" title="" class="tipS" />
   </div>
   <div class="clear"></div>
 </div> 
*/?>
</div>