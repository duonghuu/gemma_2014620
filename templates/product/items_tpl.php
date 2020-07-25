<script language="javascript" type="text/javascript">
    $(document).ready(function() {
        $("#chonhet").click(function(){
            var status=this.checked;
            $("input[name='chon']").each(function(){this.checked=status;})
        });
        $("#xoahet").click(function(){
            var listid="";
            $("input[name='chon']").each(function(){
                if (this.checked) listid = listid+","+this.value;
            })
            listid=listid.substr(1);     //alert(listid);
            if (listid=="") { alert("Bạn chưa chọn mục nào"); return false;}
            hoi= confirm("Bạn có chắc chắn muốn xóa?");
            if (hoi==true) document.location = "index.php?com=product&act=delete&type=<?=$_REQUEST['type']?>&listid=" + listid;
        });
    });
    function select_onchange()
    {
        var a=document.getElementById("id_danhmuc");
        window.location ="index.php?com=product&act=man&type=<?=$_REQUEST['type']?>&id_danhmuc="+a.value;
        return true;
    }
    function select_onchange1()
    {
        var a=document.getElementById("id_danhmuc");
        var b=document.getElementById("id_list");
        window.location ="index.php?com=product&act=man&type=<?=$_REQUEST['type']?>&id_danhmuc="+a.value+"&id_list="+b.value;
        return true;
    }
    function select_onchange2()
    {
        var a=document.getElementById("id_danhmuc");
        var b=document.getElementById("id_list");
        var c=document.getElementById("id_cat");
        window.location ="index.php?com=product&act=man&type=<?=$_REQUEST['type']?>&id_danhmuc="+a.value+"&id_list="+b.value+"&id_cat="+c.value;
        return true;
    }
    function select_onchange3()
    {
        var a=document.getElementById("id_danhmuc");
        var b=document.getElementById("id_list");
        var c=document.getElementById("id_cat");
        var d=document.getElementById("id_item");
        window.location ="index.php?com=product&act=man&type=<?=$_REQUEST['type']?>&id_danhmuc="+a.value+"&id_list="+b.value+"&id_cat="+c.value+"&id_item="+d.value;
        return true;
    }
    $(document).keydown(function(e) {
        if (e.keyCode == 13) {
            timkiem();
        }
    });
    function timkiem()
    {
        // var a = $('input.key').val();
        // if(a=='Tên...') a='';
        // window.location ="index.php?com=product&act=man&type=<?=$_REQUEST['type']?>&key="+a;
        // return true;
        var search_hoten = $("#search_hoten").val();
        var search_email = $("#search_email").val();
        var search_dienthoai = $("#search_dienthoai").val();
        var search_diachi = $("#search_diachi").val();
        var id_danhmuc = $("#id_danhmuc").val();
        var datefm = document.getElementById("datefm").value;   
        var dateto = document.getElementById("dateto").value;
        var search_string = "&type=<?=$_REQUEST['type']?>";
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
        if(id_danhmuc != ""){
          search_string += "&id_danhmuc="+id_danhmuc;
        }
        if(datefm != ""){
          search_string += "&datefm="+datefm;
        }
        if(dateto != ""){
          search_string += "&dateto="+dateto;
        }
        window.location.href="index.php?com=product&act=man"+search_string;
    }
</script>
<?php
function get_main_danhmuc()
{
    $getdata = get_result("select * from table_product_danhmuc where type='".$_REQUEST['type']."' order by stt,id desc");
    $str='
    <select id="id_danhmuc" name="id_danhmuc" class="main_select">
    <option value="">Danh mục cấp 1</option>
    ';
    foreach($getdata as $key=>$row)
    {
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
    if(!empty($_REQUEST['id_danhmuc'])){
        $getdata = get_result("select * from table_product_list where 
            id_danhmuc=".$_REQUEST['id_danhmuc']." order by stt,id desc");        
    }
    $str='
    <select id="id_list" name="id_list" onchange="select_onchange1()" class="main_select">
    <option value="">Danh mục cấp 2</option>
    ';
    foreach($getdata as $key=>$row)
    {
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
    if(!empty($_REQUEST['id_list'])){
        $getdata = get_result("select * from table_product_cat where 
            id_list=".$_REQUEST['id_list']." order by stt,id desc");        
    }
    $str='
    <select id="id_cat" name="id_cat" onchange="select_onchange2()" class="main_select">
    <option value="">Danh mục cấp 3</option>
    ';
    foreach($getdata as $key=>$row)
    {
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
    $getdata = get_result("select * from table_product_item where id_cat=".$_REQUEST['id_cat']." order by stt,id desc");
    $str='
    <select id="id_item" name="id_item" onchange="select_onchange3()" class="main_select">
    <option value="">Danh mục cấp 4</option>
    ';
    foreach($getdata as $key=>$row_huyen)
    {
        if($row_huyen["id"]==(int)@$_REQUEST["id_item"])
            $selected="selected";
        else
            $selected="";
        $str.='<option value='.$row_huyen["id"].' '.$selected.'>'.$row_huyen["ten"].'</option>';
    }
    $str.='</select>';
    return $str;
}
?>
<div class="main-title">
  <i class="fas fa-user"></i>Quản lý Sử dụng dịch vụ
</div>
<?php /* 
<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
            <li><a href="index.php?com=product&act=man&type=<?=$_REQUEST['type']?>"><span>Quản lý <?=$title_main ?></span></a></li>
            <?php if($_GET['key']!=''){ ?>
                <li class="current"><a href="#" onclick="return false;">Kết quả tìm kiếm " <?=$_GET['key']?> " </a></li>
            <?php }  else { ?>
                <li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
            <?php } ?>
        </ul>
        <div class="clear"></div>
    </div>
</div> 
*/?>
<form name="frm" id="frm" method="post" 
action="index.php?com=product&act=savestt<?php if($_REQUEST['id_danhmuc']!='') echo'&id_danhmuc='.$_REQUEST['id_danhmuc'];?>
<?php if($_REQUEST['id_list']!='') echo'&id_list='.$_REQUEST['id_list'];?><?php if($_REQUEST['id_cat']!='') echo'&id_cat='.$_REQUEST['id_cat'];?>
<?php if($_REQUEST['id_item']!='') echo'&id_item='.$_REQUEST['id_item'];?><?php if($_REQUEST['p']!='') echo'&p='.$_REQUEST['p'];?>">
    <div class="main-search">
      <div class="main-search__title">Điều kiện lọc</div>
      <div class="main-search__body">
      <div class="d-flex flex-wrap">
        
        <div class="form-group">
          <input type="text" placeholder="Từ ngày.." name="ngaybd" id="datefm" class="form-control">
        </div>
        <div class="form-group">
          <input type="text" placeholder="Đến ngày.." name="ngaykt" id="dateto" class="form-control">
        </div>
        <div class="form-group">
          <?=get_main_danhmuc()?>
        </div>
      </div>
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
        <button class="btn btn-primary main-search__btn mx-auto" type="button" onclick="timkiem();">Tìm kiếm <i class="fas fa-search"></i></button>
      </div>

    </div>
    <div class="control_frm" style="margin-top:0;">
        <div style="float:left;">
            <input type="button" class="blueB" value="Thêm" 
            onclick="location.href='index.php?com=product&act=add<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>'" />
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
            <input type="text" value="" name="key" class="key"  placeholder="Nhập từ khóa tìm kiếm ">
            <button type="button" class="blueB" onclick="timkiem();" value="">Tìm kiếm</button>
        </div> 
    */?>
</div>
<table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
  <thead>
      <tr>
        <td></td>
        <td class="tb_data_small"><a href="#" class="tipS" >Thứ tự</a></td>
        <?php if(in_array('danhmuc',$config['type'])) { ?>
            <td class="tb_data_small">Loại dịch vụ</td>
        <?php } ?>
        <?php if(in_array('list',$config['type'])) { ?>
            <td class="tb_data_small"><?=get_main_list()?></td>
        <?php } ?>
        <?php if(in_array('cat',$config['type'])) { ?>
            <td class="tb_data_small "><?=get_main_category()?></td>
        <?php } ?>
        <?php if(in_array('item',$config['type'])) { ?>
        <?php } ?>
        <?php if(in_array('ten',$config['type'])) { ?>
            <td class="sortCol"><div>Tên <span></span></div></td>
        <?php } ?>
        <td class="tb_data_small">Điện thoại</td>
        <td class="tb_data_small">Email</td>
        <td class="tb_data_small">Ngày sử dụng</td>
        <td class="tb_data_small">Ẩn/Hiện</td>
        <td width="200">Thao tác</td>
    </tr>
</thead>
<tbody>
 <?php for($i=0, $count=count($items); $i<$count; $i++){
    $link_edit = "index.php?com=product&act=edit&id_danhmuc=".$items[$i]['id_danhmuc'];
    $link_edit .= "&id_khachhang=".$items[$i]['id_khachhang']."&ten=".$items[$i]['ten'];
    $link_edit .= "&email=".$items[$i]['email']."&dienthoai=".$items[$i]['dienthoai'];
    $link_edit .= "&type=".$items[$i]['type']."&p=".$items[$i]['p']."&id=".$items[$i]['id'];
    $link_edit =  (string)magic_quote(trim(strip_tags($link_edit)));
    ?>
    <tr>
      <td>
        <input type="checkbox" name="chon" value="<?=$items[$i]['id']?>" id="chon" />
    </td>
    <td align="center">
        <input data-val0="<?=$items[$i]['id']?>" data-val2="table_<?=$_GET['com']?>" type="text" 
        value="<?=$items[$i]['stt']?>" name="stt<?=$i?>" data-val3="stt" 
        onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" 
        class="tipS smallText update_stt" onblur="stt(this)" 
        original-title="Nhập số thứ tự sản phẩm" rel="<?=$items[$i]['id']?>" />
    </td>
    <?php if(in_array('danhmuc',$config['type'])) { ?>
        <td align="center">
            <?php
            $item_danhmuc = get_fetch("select ten from table_product_danhmuc where id='".$items[$i]['id_danhmuc']."'");
            echo @$item_danhmuc['ten'];
            ?>
        </td>
    <?php } ?>
    <?php if(in_array('list',$config['type'])) { ?>
        <td align="center">
            <?php
            $item_list = get_fetch("select ten from table_product_list where id='".$items[$i]['id_list']."'");
            echo @$item_list['ten'];
            ?>
        </td>
    <?php } ?>
    <?php if(in_array('cat',$config['type'])) { ?>
        <td align="center" >
            <?php
            $item_cat = get_fetch("select ten from table_product_cat where id='".$items[$i]['id_cat']."'");
            echo @$item_cat['ten'];
            ?>
        </td>
    <?php } ?>
    <?php if(in_array('item',$config['type'])) { ?>
        <td align="center" >
            <?php
            $item_item = get_fetch("select ten from table_product_item where id='".$items[$i]['id_item']."'");
            echo @$item_item['ten'];
            ?>
        </td>
    <?php } ?>
    <?php if(in_array('ten',$config['type'])) { ?>
        <td class="title_name_data">
            <a href="<?= $link_edit ?>" class="tipS SC_bold"><?=$items[$i]['ten']?></a>
        </td>
    <?php } ?>
    <td align="center"><?=$items[$i]['dienthoai']?></td>
    <td align="center"><?=$items[$i]['email']?></td>
    <td align="center"><?=date("d/m/Y",$items[$i]['ngaytao'])?></td>
        <td align="center">
          <a data-val2="table_<?=$_GET['com']?>" rel="<?=$items[$i]['hienthi']?>" 
            data-val3="hienthi" class="diamondToggle <?=($items[$i]['hienthi']==1)?"diamondToggleOff":""?>" 
            data-val0="<?=$items[$i]['id']?>" ></a>
        </td>
        <td class="actBtns">
            <a href="<?= $link_edit ?>" title="" class="smallButton tipS" original-title="Sửa sản phẩm">
                <img src="./images/icons/dark/pencil.png" alt=""></a>
                <a href="index.php?com=product&act=delete&id=<?=$items[$i]['id']?>&type=<?=$_REQUEST['type']?>&p=<?=$_REQUEST['p']?>" 
                    onClick="if(!confirm('Xác nhận xóa')) return false;" title="" class="smallButton tipS"
                    original-title="Xóa sản phẩm"><img src="./images/icons/dark/close.png" alt=""></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
  </table>
</div>
</form>
<div class="pagination">  <?=pagesListLimitadmin($url_link , $totalRows , $pageSize, $offset)?></div>
<script type="text/javascript">
$(document).ready(function(){                       
    var dates = $( "#datefm, #dateto" ).datepicker({
            defaultDate: "+1w",
            dateFormat: 'dd/mm/yy',
            changeMonth: true,          
            numberOfMonths: 3,
            onSelect: function( selectedDate ) {
                var option = this.id == "datefm" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
        
        });
        
</script>
