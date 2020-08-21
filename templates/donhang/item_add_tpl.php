<?php 
if($_GET["id_khachhang"]){
  $get_khachhang = get_fetch("select ten,email,dienthoai from #_khachhang where id='".(int)$_GET["id_khachhang"]."'");
}
 ?>
<?php
function tinhtrang($i=0)
{
  global $d;
  $sql="select * from table_tinhtrang order by id";
  $d->query($sql);
  $result = $d->result_array();
  $str='<select id="tinhtrang" name="tinhtrang" class="main_font">
  ';
  foreach ($result as $key => $row) {
    if($row["id"]==$i)
      $selected="selected";
    else
      $selected="";
    $str.='<option value='.$row["id"].' '.$selected.'>'.$row["trangthai"].'</option>';
  }
  $str.='</select>';
  return $str;
}
function hinhthucgiaohang($i=0)
{
  global $d;
  $sql="select * from table_hinhthucgiaohang order by id";
  $d->query($sql);
  $result = $d->result_array();
  $str='<select id="hinhthucgiaohang" name="hinhthucgiaohang" class="main_font">
  ';
  foreach ($result as $key => $row) {
    if($row["id"]==$i)
      $selected="selected";
    else
      $selected="";
    $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
  }
  $str.='</select>';
  return $str;
}
?>
<?php
$d->reset();
$sql_chitietdonhang = "select * from #_chitietdonhang where madonhang='".$item['madonhang']."' order by stt,id desc";
$d->query($sql_chitietdonhang);
$chitietdonhang = $d->result_array();
$tongtiendonhang = 0;
?>
<script type="text/javascript">
  function TreeFilterChanged2(){    
    $('#validate').submit();    
  }
  function update(id){
    if(id>0){
      var sl=$('#product'+id).val();
      if(sl>0){
        $('#ajaxloader'+id).css('display', 'block');
        jQuery.ajax({
          type: 'POST',
          url: "ajax.php?do=cart&act=update",
          data: {'id':id, 'sl':sl},       
          success: function(data) { 
            $('#ajaxloader'+id).css('display', 'none'); 
            var getData = $.parseJSON(data);
            $('#id_price'+id).html(addCommas(getData.thanhtien)+'&nbsp;VNĐ');
            $('#sum_price').html(addCommas(getData.tongtien)+'&nbsp;VNĐ');
          }
        });     
      }else alert('Số lượng phải lớn hơn 0');
    }
  }
  function del(id,id_order){
    if(id>0){       
      jQuery.ajax({
        type: 'POST',
        url: "ajax.php?do=cart&act=delete",
        data: {'id':id,'id_order':id_order},      
        success: function(data) {                   
          var getData = $.parseJSON(data);
          $('#productct'+id).css('display', 'none');  
          $('#sum_price').html(addCommas(getData.tongtien)+'&nbsp;VNĐ');
        }
      });
    }
  }
</script>  
<script language="javascript">        
  function select_onchange()
  {       
    var a=document.getElementById("thanhpho_item");
    window.location ="index.php?com=order&act=<?php if($_REQUEST['act']=='edit') echo 'edit'; else echo 'add';?><?php if($_REQUEST['id']!='') echo"&id=".$_REQUEST['id']; ?>&thanhpho_item="+a.value; 
    return true;
  }
  function select_onchange1()
  {       
    var a=document.getElementById("thanhpho_item");
    var b=document.getElementById("thanhpho");
    window.location ="index.php?com=order&act=<?php if($_REQUEST['act']=='edit') echo 'edit'; else echo 'add';?><?php if($_REQUEST['id']!='') echo"&id=".$_REQUEST['id']; ?>&thanhpho_item="+a.value+"&thanhpho="+b.value;  
    return true;
  }
  function select_onchange2()
  {
    var chuoi = "";if("<?=$_GET['act']?>"=='add' && "<?=$_GET['id_khachhang']?>"<=0)
    chuoi= "&id_khachhang="+document.getElementById("id_khachhang").value;
    window.location = location.href.replace("id_khachhang=<?=$_GET['id_khachhang']?>", "id_khachhang="+document.getElementById("id_khachhang").value)+chuoi;
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
      $str='<select id="id_khachhang" name="id_khachhang" onchange="select_onchange2()" class="main_select select_danhmuc">
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
function get_httt()
{
  global $d;
  $sql="select * from table_httt";
  $d->query($sql);
  $result = $d->result_array();     
  $str='<select id="httt" name="httt" class="main_select " 
  >
  <option>Hình thức thanh toán</option>       ';        
  foreach ($result as $key => $row) {
    if($row["id"]==(int)@$_REQUEST["httt"])
      $selected="selected";
    else
      $selected="";
    $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
  }
  $str.='</select>';
  return $str;
}
function get_thanhpho_item()
{
  global $d;
  $sql="select * from table_place_city order by stt";
  $d->query($sql);
  $result = $d->result_array();     
  $str='<select id="thanhpho_item" name="thanhpho_item" class="main_select select_danhmuc" 
  onchange="select_onchange()">
  <option>Tỉnh/Thành phố</option>    ';        
  foreach ($result as $key => $row) {
    if($row["id"]==(int)@$_REQUEST["thanhpho_item"])
      $selected="selected";
    else
      $selected="";
    $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
  }
  $str.='</select>';
  return $str;
}
function get_thanhpho()
{
  global $d;
  $sql="select * from table_place_dist where id_city=".$_REQUEST['thanhpho_item']."  
  order by stt";
  $d->query($sql);
  $result = $d->result_array();     
  $str='<select id="thanhpho" name="thanhpho" class="main_select select_danhmuc" 
  onchange="select_onchange1()">
  <option>Quận/Huyện</option>';        
  foreach ($result as $key => $row) {
    if($row["id"]==(int)@$_REQUEST["thanhpho"])
      $selected="selected";
    else
      $selected="";
    $str.='<option value='.$row["id"].' '.$selected.'>'.$row["ten"].'</option>';
  }
  $str.='</select>';
  return $str;
}
function get_phuong()
{
  global $d;
  $sql="select * from table_place_ward where id_dist=".$_REQUEST['thanhpho']."  
  order by stt";
  $d->query($sql);
  $result = $d->result_array();     
  $str='<select id="phuong" name="phuong" class="main_select select_danhmuc" 
  >
  <option>Phường/Xã</option> ';        
  foreach ($result as $key => $row) {
    if($row["id"]==(int)@$_REQUEST["phuong"])
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
     <li><a href="index.php?com=order&act=mam"><span>Đơn hàng</span></a></li>
     <li class="current"><a href="#" onclick="return false;">Xem và sửa đơn hàng</a></li>
   </ul>
   <div class="clear"></div>
 </div>
</div>
<form name="supplier" id="validate" class="form" action="index.php?com=order&act=save" method="post" enctype="multipart/form-data">
  <div class="widget">
    <div class="title"><img src="./images/icons/dark/list.png" alt="" class="titleIcon" />
      <h6>Thông tin người mua</h6>
    </div>
     <div class="formRow">
      <label>Chọn khách hàng</label>
      <div class="formRight">
        <?=get_main_khachhang()?>
      </div>
      <div class="clear"></div>
    </div>
    <div class="formRow">
      <label>Họ tên</label>
      <div class="formRight">
       <input type="text" name="hoten" readonly="true" title="Họ tên khách hàng" id="hoten" class="tipS "
        value="<?=($get_khachhang['ten'])?$get_khachhang['ten']:$item['hoten']?>" />
     </div>
     <div class="clear"></div>
   </div>  
   <div class="formRow">
    <label>Điện thoại</label>
    <div class="formRight">
     <input type="text" name="dienthoai" readonly="true" title="Số điện thoại khách hàng" id="dienthoai" 
     class="tipS  " value="<?=($get_khachhang['dienthoai'])?$get_khachhang['dienthoai']:$item['dienthoai']?>" /> 
   </div>
   <div class="clear"></div>
 </div>            
 <div class="formRow">
  <label>Email</label>
  <div class="formRight">
   <input type="text" name="email" readonly="true" title="Email khách hàng" id="email" class="tipS" 
   value="<?=($get_khachhang['email'])?$get_khachhang['email']:$item['email']?>" />
 </div>
 <div class="clear"></div>
</div>  
<div class="formRow">
  <label>Nhân viên KD</label>
  <div class="formRight">
    <input type="text" name="nhanvien" title="Nhập nội dung" id="nhanvien" class="tipS" value="<?=@$item['nhanvien']?>" />
 </div>
 <div class="clear"></div>
</div>  
<div class="formRow">
  <label>Giá Trị Thẻ</label>
  <div class="formRight">
   <input type="text" name="gia" title="Nhập nội dung" id="gia" class="tipS" value="<?=@$item['gia']?>" />
 </div>
 <div class="clear"></div>
</div>  
<div class="formRow">
  <label>Member</label>
  <div class="formRight">
   <input type="text" name="member" title="Nhập nội dung" id="member" class="tipS" value="<?=@$item['member']?>" />
 </div>
 <div class="clear"></div>
</div>  
<div class="formRow">
  <?php $ngaytt = ($item['hansudung'] > 0)?$item['hansudung']:time(); ?>
  <label>Hạn sử dụng thẻ <br>(mm/dd/yyyy)</label>
  <div class="formRight">
   <input type="date" name="hansudung" title="Hạn sử dụng thẻ" id="hansudung" class="tipS" 
   value="<?= date('Y-m-d',$ngaytt) ?>" />
 </div>
 <div class="clear"></div>
</div>  
<div class="formRow">
  <?php $ngaytt = ($item['ngaythanhtoan'] > 0)?$item['ngaythanhtoan']:time(); ?>
  <label>Ngày thanh toán <br>(mm/dd/yyyy)</label>
  <div class="formRight">
   <input type="date" name="ngaythanhtoan" title="Ngày thanh toán" id="ngaythanhtoan" class="tipS" 
   value="<?= date('Y-m-d',$ngaytt) ?>" />
 </div>
 <div class="clear"></div>
</div>  
<div class="formRow">
  <label>Người thu phí</label>
  <div class="formRight">
   <input type="text" name="nguoithu" title="Nhập nội dung" id="nguoithu" class="tipS" value="<?=@$item['nguoithu']?>" />
 </div>
 <div class="clear"></div>
</div>
<div class="formRow">
  <label>Hình thức thanh toán</label>
  <div class="formRight">
    <?=get_httt();?>
  </div>
  <div class="clear"></div>
</div>  
</div>
<div class="widget">
  <div class="title"><img src="./images/icons/dark/list.png" alt="" class="titleIcon" />
    <h6>Thông tin thêm</h6>
  </div>
  <div class="formRow">
    <label>Ghi chú:</label>
    <div class="formRight">
      <textarea rows="8" cols="" title="Viết ghi chú cho đơn hàng" class="tipS" name="ghichu" id="ghichu"><?=@$item['ghichu']?></textarea>
    </div>
    <div class="clear"></div>
  </div>  
  <div class="formRow">
    <label>Tình trạng</label>
    <div class="formRight">
      <div class="selector">
        <?=tinhtrang($item['tinhtrang'])?>
      </div>
    </div>
    <div class="clear"></div>
  </div>  
  <div class="formRow">
    <div class="formRight">      
      <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
      <input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Cập nhật" />
    </div>
    <div class="clear"></div>
  </div>
</div>
</form>  