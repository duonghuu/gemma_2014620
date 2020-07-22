<?php 
$mausac = get_result("select ten,id,color from table_news where type='mausac' order by stt asc");
$size = get_result("select ten,id,color from table_news where type='size' order by stt asc");
$a_mausac2 = explode(',', $item["mausac2"]);
$a_size2 = explode(',', $item["size2"]);

$item_thuoctinh = json_decode($item["thuoctinh"],true);
$condition = implode(',', $item_thuoctinh);
if(!empty($condition)){
    $prlk = get_result("select ten,id,thumb,type,id_danhmuc,id_list,id_cat,id_item,id_nhasanxuat,type from table_product where id in (".$condition.") order by id desc");
}
?>
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
      $sql="select * from table_product_danhmuc where type='".$_REQUEST['type']."' order by stt,id desc";
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
      $sql="select * from table_product_list where id_danhmuc='".$_REQUEST['id_danhmuc']."' order by stt,id desc";
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
      $sql="select * from table_product_cat where id_list='".$_REQUEST['id_list']."' order by stt,id desc";
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
      $sql="select * from table_product_item where id_cat='".$_REQUEST['id_cat']."' order by stt,id desc";
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
function get_main_nhasanxuat()
{
    global $d;
      $sql="select * from table_news where type='nhasanxuat' order by stt,id desc";
      $d->query($sql);
      $result = $d->result_array();     
      $str='<select id="id_nhasanxuat" name="id_nhasanxuat" class="main_select select_danhmuc">
        <option value="">Chọn danh mục</option>';        
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
      <li><a href="index.php?com=product&act=man<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Sản phẩm</span></a></li>
      <li class="current"><a href="#" onclick="return false;">Thêm</a></li>
    </ul>
    <div class="clear"></div>
  </div>
</div>
<div class="control_frm" style="margin-top:0;">
 <div style="float:left;">
   <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
   <a href="index.php?com=product&act=man<?php if($_REQUEST['p']!='') echo'&p='.$_REQUEST['p'];?><?php if($_REQUEST['type']!='') echo'&type='.$_REQUEST['type'];?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
   <input type="button" class="blueB taoseo" value="Tạo seo" />
 </div>
</div>
<script type="text/javascript">
  function TreeFilterChanged2(){
    $('#validate').submit();
  }
</script>
<style>.minicolors-panel{ display:none !important;}</style>
<script type="text/javascript">
  $(document).ready(function(e) {
  //   $('button[name=ok]').click(function(){
  //     var mau = $('.cp3').val();
  //     if(mau!='' && mau!='Thêm màu')
  //     {
  //      var maucu = $('.mausac').val();
  //      if(maucu=='')
  //      {
  //       $('.mausac').val(mau);
  //     }
  //     else
  //     {
  //       $('.mausac').val(maucu+','+mau);
  //     }
  //     $('.cp3').val('Thêm màu');
  //     $('.add_mau').append('<span data-mau="'+mau+'" style="background-color:'+mau+'"><b title="Xóa màu này"></b></span>');
  //     $('.add_mau span b').click(function(){
  //       var mausac = $('.mausac').val();
  //       var mauxoa = $(this).parent('span').data('mau');
  //       var chuoimoi = mausac.replace(','+mauxoa, '');
  //       chuoimoi = chuoimoi.replace(mauxoa+',', '');
  //       chuoimoi = chuoimoi.replace(mauxoa, '');
  //       $('.mausac').val(chuoimoi);
  //       $(this).parent('span').remove();
  //     });
  //   }
  // });
    $('.add_mau span b').click(function(){
      var mausac = $('.mausac').val();
      var mauxoa = $(this).parent('span').data('mau');
      var chuoimoi = mausac.replace(','+mauxoa, '');
      chuoimoi = chuoimoi.replace(mauxoa+',', '');
      chuoimoi = chuoimoi.replace(mauxoa, '');
      $('.mausac').val(chuoimoi);
      $(this).parent('span').remove();
    });
  });
</script>
<form autocomplete="off" name="supplier" id="validate" class="form" action="index.php?com=product&act=save&p=<?=$_REQUEST['p']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" method="post" enctype="multipart/form-data">
 <div class="widget">
   <div class="title"><img src="./images/icons/dark/record.png" alt="" class="titleIcon" />
    <h6>Nhập dữ liệu</h6>
  </div>
  <ul class="tabs">
    
   <li>
     <a href="#info">Thông tin chung</a>
   </li>
   <?php foreach ($config['lang'] as $key => $value) { ?>
     <li>
       <a href="#content_lang_<?=$key?>"><?=$value?></a>
     </li>
   <?php } ?>
   <li>
     <a href="#btn_linkpro">Liên kết sản phẩm</a>
   </li>
 </ul>
 
 <div id="info" class="tab_content">
  <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
  <?php if(in_array('danhmuc',$config['type'])) { ?>
    <div class="formRow">
     <label>Chọn danh mục 1</label>
     <div class="formRight">
       <?=get_main_danhmuc()?>
     </div>
     <div class="clear"></div>
   </div>
 <?php } ?>
 <?php if(in_array('list',$config['type'])) { ?>
  <div class="formRow">
   <label>Chọn danh mục 2</label>
   <div class="formRight">
     <?=get_main_list()?>
   </div>
   <div class="clear"></div>
 </div>
<?php } ?>
<?php if(in_array('cat',$config['type'])) { ?>
  <div class="formRow">
    <label>Chọn danh mục cấp 3</label>
    <div class="formRight">
      <?=get_main_category()?>
    </div>
    <div class="clear"></div>
  </div>
<?php } ?>
<?php if(in_array('nhasanxuat',$config['type'])) { ?>
 <div class="formRow">
   <label>Giá: </label>
   <div class="formRight">
     <input type="text" name="nhasanxuat" value="<?=@$item['nhasanxuat']?>" class="input form-control" />
   </div>
   <div class="clear"></div>
 </div>
<?php } ?>
<?php if(in_array('masp',$config['type'])) { ?>
  <div class="formRow">
    <label>Mã sản phẩm:</label>
    <div class="formRight">
      <input type="text" id="code_pro" name="masp" value="<?=@$item['masp']?>"  title="Nhập mã sản phẩm" class="tipS" />
    </div>
    <div class="clear"></div>
  </div>
<?php } ?>
<?php if(in_array('gia',$config['type'])) { ?>
 <div class="formRow">
  <label>Giá: </label>
  <div class="formRight">
    <input type="text" name="gia" value="<?=@$item['gia']?>"  title="Nhập giá" class="tipS conso" onkeypress="return OnlyNumber(event)" />
  </div>
  <div class="clear"></div>
</div>
<?php } ?>
<?php if(in_array('giakm',$config['type'])) { ?>
  <div class="formRow">
    <label>Giá K.mãi: </label>
    <div class="formRight">
      <input type="text" name="giakm" value="<?=@$item['giakm']?>"  title="Nhập giá khuyến mãi" class="tipS conso" onkeypress="return OnlyNumber(event)" />
    </div>
    <div class="clear"></div>
  </div>
<?php } ?>
<?php if(in_array('dientich',$config['type'])) { ?>
 <div class="formRow">
  <label><?= (!empty($config["title"]["dientich"]))?$config["title"]["dientich"]:'Diện tích' ?>: </label>
  <div class="formRight">
    <input type="text" name="dientich" value="<?=@$item['dientich']?>" class="tipS" />
  </div>
  <div class="clear"></div>
</div>
<?php } ?>
<?php if(in_array('phaply',$config['type'])) { ?>
  <div class="formRow">
    <label><?= (!empty($config["title"]["phaply"]))?$config["title"]["phaply"]:'Pháp lý' ?>:</label>
    <div class="formRight">
      <input type="text" name="phaply" value="<?=@$item['phaply']?>"  title="Nhập nội dung" class="tipS" />
    </div>
    <div class="clear"></div>
  </div>
<?php } ?>
<?php if(in_array('diachi',$config['type'])) { ?>
  <div class="formRow">
    <label>Địa chỉ</label>
    <div class="formRight">
      <input type="text" name="diachi" title="Nhập nội dung" id="diachi" class="tipS" value="<?=@$item['diachi']?>" />
    </div>
    <div class="clear"></div>
  </div>
<?php } ?>
<div class="formRow none">
  <label>Tag </label>
  <div class="formRight">
    <input type="text" id="tag" name="tag" value="<?=@$item['tag']?>"  title="Nhập tag sản phẩm,mỗi tag cách nhau dấu phẩy" class="tipS" style="float:left;" />
    <div class="note">Mỗi tag cách nhau dấu phẩy</div>
  </div>
  <div class="clear"></div>
</div>
<?php if(in_array('size',$config['type'])) { ?>
  <div class="formRow">
    <label>Size </label>
    <div class="formRight">
      <input type="text" id="price" name="size" value="<?=@$item['size']?>"  title="Nhập size sản phẩm,mỗi size cách nhau dấu phẩy" class="tipS" style="float:left;" />
      <div class="note">Mỗi size cách nhau dấu phẩy</div>
    </div>
    <div class="clear"></div>
  </div>
<?php } ?>
<?php if(in_array('mausac',$config['type'])) { ?>
  <div class="formRow">
    <label>Màu sắc </label>
    <div class="formRight">
     <input type="hidden" name="mausac" value="<?=$item['mausac']?>" class="input mausac" />
     <span class="add_mau">
       <?php
       if($item['mausac']!='')
       {
        $arr_mau = explode(',',$item['mausac']);
        foreach($arr_mau as $key=>$value)
        {
         echo '<span data-mau="'.$value.'" style="background-color:'.$value.'"><b title="Xóa màu này"></b></span>';
       }
     }
     ?>
   </span>
   <input type="text" class="cp3 chonmau" value="Thêm Màu" />
   <img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Chọn thêm màu xong nhấn OK">
 </div>
 <div class="clear"></div>
</div>
<?php } ?>
<?php if(in_array('hinhanh',$config['type'])) { ?>
  <div class="formRow">
   <label>Tải hình ảnh:</label>
   <div class="formRight">
    <input type="file" id="file" name="file" accept="image/*" onchange="loadFile(event)" />
    <img src="./images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
    <div class="note">Width:<?=_width_thumb2?>px | Height:<?=_height_thumb2?>px <?=_format_duoihinh_l?> </div>
  </div>
  <div class="clear"></div>
</div>
<?php if($_GET['act']=='edit'){?>
  <div class="formRow">
   <label>Hình Hiện Tại :</label>
   <div class="formRight">
     <div class="mt10"><img id="output" src="<?=_upload_sanpham.$item['photo']?>"  style="max-width:100px" alt="NO PHOTO" /></div>
   </div>
   <div class="clear"></div>
 </div>
<?php } ?>
<?php } ?>
<?php if(in_array('hinhthem',$config['type'])) { ?>
  <div class="formRow">
    <label>Hình ảnh kèm theo: </label>
    <?php if($act=='edit'){?>
     <div class="formRight">
      <?php if(count($ds_photo)!=0){?>
        <?php for($i=0;$i<count($ds_photo);$i++){?>
          <div class="item_trich trich<?=$ds_photo[$i]['id']?>" id="<?=md5($ds_photo[$i]['id'])?>">
           <img class="img_trich" width="100px" height="80px" src="<?=_upload_hinhthem.$ds_photo[$i]['photo']?>" />
           <input data-val0="<?=$ds_photo[$i]['id']?>" data-val2="table_hinhanh" type="text" value="<?=$ds_photo[$i]['stt']?>" name="stt<?=$i?>" data-val3="stt" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" class="tipS smallText update_stt" onblur="stt(this)" original-title="Nhập số thứ tự hình nahr" rel="<?=$ds_photo[$i]['id']?>" />
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
<?php if(in_array('colormau',$config['type'])) { 
  ?>
  <div class="formRow">
   <label>Màu sắc</label>
   <div class="formRight">
     <select id="mausac_multi" multiple="multiple" class="se-w" name="id_mausac[]">
       <?php 
       foreach($mausac as $v){ 
        $sel = (in_array($v["id"], $a_mausac2))?'selected':'';
        ?>
        <option <?= $sel ?> value="<?=$v['id']?>" data-list="true" ><b><?=$v['ten']?></b></option>
      <?php } ?>
    </select>
  </div>
  <div class="clear"></div>
</div>
<?php } ?>
<?php if(in_array('sizekichthuoc',$config['type'])) { ?>
  <div class="formRow">
   <label>Size</label>
   <div class="formRight">
     <select id="size_multi" multiple="multiple" class="se-w" name="id_size[]">
       <?php 
       foreach($size as $v){ 
        $sel = (in_array($v["id"], $a_size2))?'selected':'';
        ?>
        <option <?= $sel ?> value="<?=$v['id']?>" data-list="true" ><b><?=$v['ten']?></b></option>
      <?php } ?>
    </select>
  </div>
  <div class="clear"></div>
</div>
<?php } ?>
<?php if(in_array('seo',$config['type'])) { ?>
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
<?php } ?>
<?php if(in_array('noibat',$config['type'])) { ?>
  <div class="formRow">
    <label><?= (!empty($config['title']['noibat'])) ? $config['title']['noibat'] : "Nổi bật" ?> : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này !"> </label>
    <div class="formRight">
      <input type="checkbox" name="noibat" id="check1" <?=($item['noibat']==1)?'checked="checked"':''?> />
    </div>
    <div class="clear"></div>
  </div>
<?php } ?>
<?php if(in_array('spbanchay',$config['type'])) { ?>
 <div class="formRow">
  <label><?= (!empty($config['title']['spbanchay'])) ? $config['title']['spbanchay'] : "Bán chạy" ?> : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này !"> </label>
  <div class="formRight">
    <input type="checkbox" name="spbanchay" id="check1" <?=($item['spbanchay']==1)?'checked="checked"':''?> />
  </div>
  <div class="clear"></div>
</div>
<?php } ?>
<?php if(in_array('spmoi',$config['type'])) { ?>
  <div class="formRow">
    <label><?= (!empty($config['title']['spmoi'])) ? $config['title']['spmoi'] : "Sp mới" ?> : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này !"> </label>
    <div class="formRight">
      <input type="checkbox" name="spmoi" id="check1" <?=($item['spmoi']==1)?'checked="checked"':''?> />
    </div>
    <div class="clear"></div>
  </div>
<?php } ?>
<?php if(in_array('tieubieu',$config['type'])) { ?>
  <div class="formRow">
    <label><?= (!empty($config['title']['tieubieu'])) ? $config['title']['tieubieu'] : "Tiêu biểu" ?> : <img src="./images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Bỏ chọn để không hiển thị danh mục này !"> </label>
    <div class="formRight">
      <input type="checkbox" name="tieubieu" id="check1" <?=($item['tieubieu']==1)?'checked="checked"':''?> />
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
    <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
    <a href="index.php?com=product&act=man<?php if($_REQUEST['p']!='') echo'&p='.$_REQUEST['p'];?><?php if($_REQUEST['type']!='') echo'&type='.$_REQUEST['type'];?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
  </div>
  <div class="clear"></div>
</div>
</div>
<!-- End info -->
<?php foreach ($config['lang'] as $key => $value) {
  ?>
  <div id="content_lang_<?=$key?>" class="tab_content">
   <?php if(in_array('ten',$config['type'])) { ?>
    <div class="formRow">
      <label>Tên bài viết</label>
      <div class="formRight">
        <input type="text" name="data[ten<?=$key?>]" title="Nhập tên bài viết" id="ten<?=$key?>" class="tipS" value="<?=@$item['ten'.$key]?>" />
      </div>
      <div class="clear"></div>
    </div>
  <?php } ?>
  <?php if(in_array('mota',$config['type'])) {
    $cls_ck = (in_array('mota',$config['ck'])) ? 'class="ck_editor"' : "";
    ?>
    <div class="formRow">
      <label><?= (!empty($config["title"]["mota"]))?$config["title"]["mota"]:"Mô tả ngắn" ?>:</label>
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
      <label><?= (!empty($config["title"]["mota2"]))?$config["title"]["mota2"]:"Mô tả ngắn" ?>:</label>
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
  <div class="formRow">
    <div class="formRight">
     <input type="hidden" name="id" id="id" value="<?=@$item['id']?>" />
     <input type="hidden" name="type" id="id_this_type" value="<?=$_REQUEST['type']?>" />
     <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
   </div>
   <div class="clear"></div>
 </div>
</div><!-- End content <?=$key?> -->
<?php } ?>
<div id="btn_linkpro" class="tab_content">
  <div class="formRow">
        <p class="box_protitlemain"><label>Tìm sản phẩm</label></p>
        <div class="timkiem">
          <input type="text" class="search_input" value="" placeholder="Nhập từ khóa tìm kiếm " style="width:30%;float:left;">
          <button type="button" class="blueB search_lienket" value="">Tìm kiếm</button>
        </div>
        <div class="clear"></div>
        <div class="prolienket_show" id="prolienket_show">

               
                     </div>
      </div>
      <div class="formRow">
           <p class="box_protitlemain"><label>Danh sách sản phẩm đã liên kết</label></p>
           <div class="prolienket_content" id="prolienket_content">
             <?php 
             if(!empty($prlk)){
                 $str_rs = '<div id="itemContainerlk" class="product-grid">';
                 foreach($prlk as $key=>$value) {
                    $link = 'index.php?com=product&act=edit&id_danhmuc='.$value['id_danhmuc'].'&id_list='.$value['id_list'].'&id_cat='.$value['id_cat'].'&id_item='.$value['id_item'].'&id_nhasanxuat='.$value['id_nhasanxuat'].'&type='.$value['type'].'&id='.$value['id'];
                    $img = _upload_sanpham.$value["thumb"];
                    $str_rs .= '<div class="pr-box">
                      <article>
                        <a href="'.$link.'">
                          <figure><img src="'.$img.'" alt="'.$value['ten'].'"></figure>
                          <h4>'.$value['ten'].'</h4>
                        </a>
                      </article>
                      <span class="btn_lienket" data-act="huylienket" data-idlienket="'.$value['id'].'" data-id="'.$_GET["id"].'">HỦY LIÊN KẾT</span>
                    </div>'; 
                 }
                 $str_rs .= '</div>';
             }
             echo $str_rs;
              ?>
                   </div>
         </div>
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
    $('.search_lienket').click(function(e){
          var keywords = $('.search_input').val();
          var act = '<?= $_GET["act"] ?>';
          var id = <?= $_GET["id"] ?>;
          $.ajax ({
            type: "POST",
            url: "ajax/search_lienket.php",
            data: {keywords:keywords,id:id,act:act},
            success: function(result){
              $(".prolienket_show").html(result);
            }
          });
            });
    /*---liên kết sản phẩm---*/
        $('body').on('click', '.btn_lienket', function(e) {
          var act = $(this).data('act');
          var id = $(this).data('id');
          var idlienket = $(this).data('idlienket');
          $.ajax ({
            type: "POST",
            url: "ajax/ajax_lienket.php",
            data: {act:act,id:id,idlienket:idlienket},
            success: function(result){
              if(act=="lienket"){
                if(result==1){
                  alert("Đã liên kết");
                  return false;
                }else{
                  alert('Liên kết thành công !');
                  $(".prolienket_content").html(result);  
                }
              }else{
                $(".prolienket_content").html(result);  
              }
            }
          });
            });
    $( "#ngayketthuc" ).datepicker({
      dateFormat: "dd-mm-yy",
      changeMonth: true,
      changeYear: true,
      dayNamesMin: [ "CN", "T2", "T3", "T4", "T5", "T6", "T7" ],
      monthNamesShort: [ "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12" ],
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
