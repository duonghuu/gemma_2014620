<script type="text/javascript">
  $(document).ready(function() {
    $('.update_stt').keyup(function(event) {
      var id = $(this).attr('rel');
      var table = 'baiviet';
      var value = $(this).val();
      $.ajax ({
        type: "POST",
        url: "ajax/update_stt.php",
        data: {id:id,table:table,value:value},
        success: function(result) {
        }
      });
    });
    $('.timkiem button').click(function(event) {
      var keyword = $(this).parent().find('input').val();
      window.location.href="index.php?com=baiviet&act=man&type=<?=$_GET['type']?>&keyword="+keyword;
    });
    $("#xoahet").click(function(){
      var listid="";
      $("input[name='chon']").each(function(){
        if (this.checked) listid = listid+","+this.value;
      })
      listid=listid.substr(1);   //alert(listid);
      if (listid=="") { alert("Bạn chưa chọn mục nào"); return false;}
      hoi= confirm("Bạn có chắc chắn muốn xóa?");
      if (hoi==true) document.location = "index.php?com=baiviet&act=delete&type=<?=$_GET['type']?>&curPage=<?=$_GET['curPage']?>&listid=" + listid;
    });
  });
</script>
<div class="control_frm" style="margin-top:25px;">
  <div class="bc">
    <ul id="breadcrumbs" class="breadcrumbs">
      <li><a href="index.php?com=pushOnesignal&act=man<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Quản lý Push OneSignal</span></a></li>
      <?php if($_GET['keyword']!=''){ ?>
      <li class="current"><a href="#" onclick="return false;">Kết quả tìm kiếm " <?=$_GET['keyword']?> " </a></li>
      <?php }  else { ?>
      <li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
      <?php } ?>
    </ul>
    <div class="clear"></div>
  </div>
</div>
<form name="f" id="f" method="post">
  <div class="control_frm" style="margin-top:0;">
    <div style="float:left;">
      <input type="button" class="blueB" value="Thêm" onclick="location.href='index.php?com=pushOnesignal&act=add<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>'" />
      <input type="button" class="blueB" value="Xoá Chọn" id="xoahet" />
    </div>  
  </div>
  <div class="widget">
    <div class="title"><span class="titleIcon">
      <input type="checkbox" id="titleCheck" name="titleCheck" />
    </span>
    <h6>Chọn tất cả</h6>
    <div class="timkiem">
      <input type="text" value="" placeholder="Nhập từ khóa tìm kiếm ">
      <button type="button" class="blueB"  value="">Tìm kiếm</button>
    </div>
  </div>
  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td></td>
        <?php /*?> <td class="tb_data_small"><a href="#" class="tipS" style="margin: 5px;">Thứ tự</a></td>   <?php */?>   
        <td class="sortCol"><div>Tên bài viết<span></span></div></td>      
        <td width="200">Gửi thông báo</td>
        <td width="200">Thao tác</td>
      </tr>
    </thead>
    <tbody>
     <?php for($i=0, $count=count($items); $i<$count; $i++){?>
     <tr>
       <td>
        <input type="checkbox" name="chon" value="<?=$items[$i]['id']?>" id="check<?=$i?>" />
      </td><?php /*?> 
            <td align="center">
              <input type="text" value="<?=$items[$i]['number']?>" name="ordering[]" onkeypress="return OnlyNumber(event)" class="tipS smallText update_stt" original-title="Nhập số thứ tự bài viết" rel="<?=$items[$i]['id']?>" />
              <div id="ajaxloader"><img class="numloader" id="ajaxloader<?=$items[$i]['id']?>" src="images/loader.gif" alt="loader" /></div>
            </td> <?php */?> 
      <td class="title_name_data">
        <a href="index.php?com=pushOnesignal&act=edit&id=<?=$items[$i]['id']?>" class="tipS SC_bold"><?=$items[$i]['ten_vi']?></a>
      </td>
      <?php /*?> SYNC.............. <?php */?>
      <td class="actBtns">
        <a href="index.php?com=pushOnesignal&act=sync&id=<?=$items[$i]['id']?>" onClick="if(!confirm('Xác nhận gửi')) return false;" title="" class="smallButton tipS" original-title="Gửi thông tin đi"><img src="data:image/png;base64,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" alt=""></a>
      </td>
      <td class="actBtns">
        <a href="index.php?com=pushOnesignal&act=edit&id=<?=$items[$i]['id']?>" title="" class="smallButton tipS" original-title="Sửa bài viết"><img src="./images/icons/dark/pencil.png" alt=""></a>
        <a href="index.php?com=pushOnesignal&act=delete&id=<?=$items[$i]['id']?>" onClick="if(!confirm('Xác nhận xóa')) return false;" title="" class="smallButton tipS" original-title="Xóa bài viết"><img src="./images/icons/dark/close.png" alt=""></a>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>
</form>  
<div class="paging"><?=$paging?></div>