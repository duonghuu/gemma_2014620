<?php 
if($_GET["id_khachhang"] >0){
  $get_khachhang = get_fetch("select ten,email,dienthoai,diachi from 
  #_khachhang where id='".(int)$_GET["id_khachhang"]."'");
}
 ?>
<script language="javascript">
  function select_onchange()
  {
    var chuoi = "";if("<?=$_GET['act']?>"=='add' && "<?=$_GET['id_danhmuc']?>"<=0)
    chuoi= "&id_danhmuc="+document.getElementById("id_danhmuc").value;
    window.location = location.href.replace("id_danhmuc=<?=$_GET['id_danhmuc']?>",
     "id_danhmuc="+document.getElementById("id_danhmuc").value)+chuoi;
    return true;
  }
  function select_onchange1()
  {
    var chuoi = "";if("<?=$_GET['act']?>"=='add' && "<?=$_GET['id_khachhang']?>"<=0)
    chuoi= "&id_khachhang="+document.getElementById("id_khachhang").value;
    window.location = location.href.replace("id_khachhang=<?=$_GET['id_khachhang']?>",
     "id_khachhang="+document.getElementById("id_khachhang").value)+chuoi;
    return true;
  }
</script>
<?php
function get_main_khachhang()
{
    global $d;
      $sql="select id,ten from table_khachhang";
      $d->query($sql);
      $result = $d->result_array();
      $str='<select id="id_khachhang" name="id_khachhang" onchange="select_onchange1()" 
      class="main_select select_danhmuc">
        <option value="">Danh mục khách hàng</option>';
      foreach ($result as $key => $row) {
        if($row["id"]==(int)@$_REQUEST["id_khachhang"])
          $selected="selected";
        else
          $selected="";
        $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
      }
      $str.='</select>';
      return $str;
}
function get_main_danhmuc()
{
    global $d;
      $sql="select * from table_product_danhmuc where type='".$_REQUEST['type']."' order by stt,id desc";
      $d->query($sql);
      $result = $d->result_array();
      $str='<select id="id_danhmuc" name="id_danhmuc" onchange="select_onchange()" 
      class="main_select select_danhmuc">
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
?>
<div class="control_frm" style="margin-top:25px;">
  <div class="bc">
    <ul id="breadcrumbs" class="breadcrumbs">
      <li><a href="index.php?com=product&act=man<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>">
        <span>Sản phẩm</span></a></li>
      <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
    </ul>
    <div class="clear"></div>
  </div>
</div>
<div class="control_frm" style="margin-top:0;">
 <div style="float:left;">
   <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
   <a href="index.php?com=product&act=man<?php if($_REQUEST['p']!='') echo'&p='.$_REQUEST['p'];?><?php if($_REQUEST['type']!='') echo'&type='.$_REQUEST['type'];?>" 
    onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" 
    class="button tipS" original-title="Thoát">Thoát</a>
 </div>
</div>
<script type="text/javascript">
  function TreeFilterChanged2(){
    $('#validate').submit();
  }
</script>
<form name="supplier" id="validate" class="form" 
action="index.php?com=product&act=save&p=<?=$_REQUEST['p']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"
 method="post" enctype="multipart/form-data">
 <div class="widget">
    <?php if(in_array('danhmuc',$config['type'])) { ?>
      <div class="formRow">
       <label>Chọn loại hình</label>
       <div class="formRight">
         <?=get_main_danhmuc()?>
       </div>
       <div class="clear"></div>
     </div>
   <?php } ?>
    <div class="formRow">
     <label>Chọn khách hàng</label>
     <div class="formRight">
       <?=get_main_khachhang()?>
     </div>
     <div class="clear"></div>
   </div>
   <div class="formRow">
    <label>Họ tên:</label>
    <div class="formRight">
      <input type="text" name="data[ten]" id="ten" readonly=""
      value="<?=($get_khachhang['ten'])?$get_khachhang['ten']:$item['ten']?>" class="input" />
    </div>
    <div class="clear"></div>
   </div>
   <div class="formRow">
    <label>Email:</label>
    <div class="formRight">
      <input type="text" name="email" id="email" readonly=""
      value="<?=($get_khachhang['email'])?$get_khachhang['email']:$item['email']?>" class="input" />
    </div>
    <div class="clear"></div>
   </div>
   <div class="formRow">
    <label>Điện thoại:</label>
    <div class="formRight">
      <input type="text" name="dienthoai" readonly=""
      value="<?=($get_khachhang['dienthoai'])?$get_khachhang['dienthoai']:$item['dienthoai']?>" class="input" />
    </div>
    <div class="clear"></div>
   </div>
   <div class="formRow">
    <label>Địa chỉ:</label>
    <div class="formRight">
      <input type="text" name="diachi" readonly=""
      value="<?=($get_khachhang['diachi'])?$get_khachhang['diachi']:$item['diachi']?>" class="input" />
    </div>
    <div class="clear"></div>
   </div>
  <div class="formRow">
    <label><?= (!empty($config["title"]["mota"]))?$config["title"]["mota"]:"Mô tả ngắn" ?>:</label>
    <div class="formRight">
      <textarea <?php echo $cls_ck; ?> rows="8" cols="" title="Viết mô tả ngắn bài viết" 
        class="tipS" name="data[mota]" id="mota"><?=@$item['mota']?></textarea>
    </div>
    <div class="clear"></div>
  </div>

 </div>      <!-- .widget  -->
 <div class="widget">
   <?php if(in_array('noibat',$config['type'])) { ?>
     <div class="formRow">
       <label><?= (!empty($config['title']['noibat'])) ? $config['title']['noibat'] : "Nổi bật" ?> : 
        <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" 
        original-title="Bỏ chọn để không hiển thị danh mục này !"> </label>
       <div class="formRight">
         <input type="checkbox" name="noibat" id="check1" <?=($item['noibat']==1)?'checked="checked"':''?> />
       </div>
       <div class="clear"></div>
     </div>
   <?php } ?>
   <div class="formRow">
     <label>Hiển thị: <img src="./images/question-button.png" alt="Chọn loại" 
      class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này ! "> </label>
     <div class="formRight">
       <input type="checkbox" name="hienthi" id="check1" 
       <?=(!isset($item['hienthi']) || $item['hienthi']==1)?'checked="checked"':''?> />
       <label>Số thứ tự: </label>
       <input type="text" class="tipS" value="<?=isset($item['stt'])?$item['stt']:1?>" 
       name="stt" style="width:20px; text-align:center;" 
       onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" 
       original-title="Số thứ tự của danh mục, chỉ nhập số">
     </div>
     <div class="clear"></div>
   </div>
   <div class="formRow">
     <div class="formRight">
      <input type="hidden" name="id" id="id" value="<?=@$item['id']?>" />
      <input type="hidden" name="type" id="id_this_type" value="<?=$_REQUEST['type']?>" />
       <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
       <a href="index.php?com=product&act=man<?php if($_REQUEST['p']!='') echo'&p='.$_REQUEST['p'];?><?php if($_REQUEST['type']!='') echo'&type='.$_REQUEST['type'];?>" 
        onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" 
        class="button tipS" original-title="Thoát">Thoát</a>
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
    $( "#ngayketthuc" ).datepicker({
      dateFormat: "dd-mm-yy",
      changeMonth: true,
      changeYear: true,
      dayNamesMin: [ "CN", "T2", "T3", "T4", "T5", "T6", "T7" ],
      monthNamesShort: [ "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
       "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12" ],
      yearRange: "1900:now"
    });
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
<?php /* <!-- copy of input fields group -->
<div class="form-group fieldGroupCopy" style="display: none;">
    <label>Món: </label>
    <div class="formRight formRight-flex">
        <input type="hidden" name="idgoi[]" value=""   />
        <select name="chucvugoi[]" required="">
          <?php foreach ($mon as $key => $value) {
          echo '<option value="'.$value["id"].'_'.$value["ten"].'">'.$value["ten"].'</option>';  
          } ?>
          
        </select>
        <input type="text" name="linkgoi[]" value=""  title="Mô tả" placeholder="Mô tả" class="tipS" />
        <a href="javascript:void(0)" class="btn btn-danger redB button remove">Xóa</a>
    </div>
    <div class="clear"></div>
</div>
<script>
    $(document).ready(function() {
        //add more fields group
            $(".addMore").click(function(){
                var fieldHTML = '<div class="formRow formRow-flex form-group fieldGroup">'+$(".fieldGroupCopy").html()+'</div>';
                $('body').find('.fieldGroup:last').after(fieldHTML);
            });
            
            //remove fields group
            $("body").on("click",".remove",function(){ 
                var id=$(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "ajax/xuly_admin_dn.php",
                    data: {id:id, act: 'remove_uudiem'},
                    success:function(data){
                        
                    }
                })
                $(this).parents(".fieldGroup").remove();
            });
    });
</script> */?>