<script type="text/javascript">
  $(document).ready(function() {
    $('.main-search__btn').click(function(event) {
      var search_hoten = $("#search_hoten").val();
      var search_email = $("#search_email").val();
      var search_dienthoai = $("#search_dienthoai").val();
      var search_diachi = $("#search_diachi").val();
      var search_string = "";
      if(search_hoten != ""){
        search_string += "&hoten="+search_hoten;
      }
      if(search_email != ""){
        search_string += "&email="+search_email;
      }
      if(search_dienthoai != ""){
        search_string += "&dienthoai="+search_dienthoai;
      }
      if(search_diachi != ""){
        search_string += "&diachi="+search_diachi;
      }
      window.location.href="index.php?com=khachhang&act=man"+search_string;
    });
    $("#xoahet").click(function(){
      var listid="";
      $("input[name='chon']").each(function(){
        if (this.checked) listid = listid+","+this.value;
      })
      listid=listid.substr(1);   //alert(listid);
      if (listid=="") { alert("Bạn chưa chọn mục nào"); return false;}
      hoi= confirm("Bạn có chắc chắn muốn xóa?");
      if (hoi==true) document.location = "index.php?com=khachhang&act=delete&type=<?=$_GET['type']?>&curPage=<?=$_GET['curPage']?>&listid=" + listid;
    });
  });
</script>
<div class="main-title">
  <i class="fas fa-user"></i>Quản lý khách hàng
</div>
<form name="f" id="f" method="post">
  <div class="main-search">
    <div class="main-search__title">Điều kiện lọc</div>
    <div class="main-search__body">
    <div class="d-flex justify-content-between flex-wrap">
      <div class="form-group">
        <input type="text" placeholder="Họ và Tên" name="search_hoten" id="search_hoten" class="form-control">
      </div>
      <div class="form-group">
        <input type="text" placeholder="Số điện thoại" name="search_dienthoai" id="search_dienthoai" class="form-control">
      </div>
      <div class="form-group">
        <input type="text" placeholder="Email" name="search_email" id="search_email" class="form-control">
      </div>
      <div class="form-group">
        <input type="text" placeholder="Địa chỉ" name="search_diachi" id="search_diachi" class="form-control">
      </div>
    </div>
    </div>
    <div class="main-search__foot d-flex">
      <button class="btn btn-primary main-search__btn mx-auto" type="button">Tìm kiếm <i class="fas fa-search"></i></button>
    </div>

  </div>
  <div class="control_frm" style="margin-top:0;">
    <div style="float:left;">
      <input type="button" class="blueB" value="Thêm" onclick="location.href='index.php?com=khachhang&act=add'" />
      <input type="button" class="blueB" value="Xoá Chọn" id="xoahet" />
    </div>  
  </div>
  <div class="widget">
    <div class="title"><span class="titleIcon">
      <input type="checkbox" id="titleCheck" name="titleCheck" />
    </span>
    <h6>Chọn tất cả</h6>
   <?php /* 
    <div class="timkiem">
         <input type="text" value="" placeholder="Nhập từ khóa tìm kiếm ">
         <button type="button" class="blueB"  value="">Tìm kiếm</button>
       </div> 
   */?>
  </div>
  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td></td>
        <td class="tb_data_small"><a href="#" class="tipS" style="margin: 5px;">Thứ tự</a></td>           
        <td>Họ tên</td>
        <td>Số điện thoại</td>
        <?php /* <td>Nhóm thành viên </td> */?>
        <td>Email</td>
        <td>Địa chỉ</td>
        <?php /* <td class="tb_data_small">Kích hoạt</td> */?>
        <?php /* <td class="tb_data_small">Ẩn/Hiện</td> */?>
        <td width="200">Thao tác</td>
      </tr>
    </thead>
    <tbody>
     <?php for($i=0, $count=count($items); $i<$count; $i++){?>
      <tr>
       <td>
        <input type="checkbox" name="chon" value="<?=$items[$i]['id']?>" id="check<?=$i?>" />
      </td>
      <td align="center">
        <input data-val0="<?=$items[$i]['id']?>" data-val2="table_<?=$_GET['com']?>" type="text" 
        value="<?=$items[$i]['stt']?>" name="stt<?=$i?>" data-val3="stt" 
        onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" 
        class="tipS smallText update_stt" onblur="stt(this)" original-title="Nhập số thứ tự sản phẩm" 
        rel="<?=$items[$i]['id']?>" />
      </td> 
      <td class="title_name_data">
        <a href="index.php?com=khachhang&act=edit&id_list=<?=$items[$i]['id_list']?>&id_cat=<?=$items[$i]['id_cat']?>&id=<?=$items[$i]['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" class="tipS SC_bold"><?=$items[$i]['ten']?></a>
      </td>
      <td class="title_name_data"><?=$items[$i]['dienthoai']?></td>
    <?php /* <td class="title_name_data">
                <a href="index.php?com=khachhang&act=edit&id_list=<?=$items[$i]['id_list']?>&id_cat=<?=$items[$i]['id_cat']?>&id=<?=$items[$i]['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" class="tipS SC_bold">
            <?php
            $d->reset();
            $sql="select ten from #_phanquyen where id='".$items[$i]["nhom"]."'";
            $d->query($sql);
            $rs=$d->fetch_array();
            echo $rs["ten"];
            ?>
          </a>
          </td> */?>
          <td class="title_name_data"><?=$items[$i]['email']?></td>
          <td class="title_name_data"><?=$items[$i]['diachi']?></td>
        <?php /* <td align="center">
                  <a data-val2="table_<?=$_GET['com']?>" rel="<?=$items[$i]['active']?>" data-val3="active" class="diamondToggle <?=($items[$i]['active']==1)?"diamondToggleOff":""?>" data-val0="<?=$items[$i]['id']?>" ></a>   
                  </td> */?>
       <?php /*  <td align="center">
                 <a data-val2="table_<?=$_GET['com']?>" rel="<?=$items[$i]['hienthi']?>" data-val3="hienthi" class="diamondToggle <?=($items[$i]['hienthi']==1)?"diamondToggleOff":""?>" data-val0="<?=$items[$i]['id']?>" ></a>   
                 </td> */?>
                 <td class="actBtns">
                  <a href="index.php?com=khachhang&act=edit&id_list=<?=$items[$i]['id_list']?>&id_cat=<?=$items[$i]['id_cat']?>&id=<?=$items[$i]['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" title="" class="smallButton tipS" original-title="Sửa sản phẩm"><img src="./images/icons/dark/pencil.png" alt=""></a>
                  <a href="index.php?com=khachhang&act=delete&id=<?=$items[$i]['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" onClick="if(!confirm('Xác nhận xóa')) return false;" title="" class="smallButton tipS" original-title="Xóa sản phẩm"><img src="./images/icons/dark/close.png" alt=""></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </form>  
    <div class="pagination">  <?=pagesListLimitadmin($url_link , $totalRows , $pageSize, $offset)?></div>