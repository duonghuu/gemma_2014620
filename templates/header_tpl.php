<?php
// $dem_datban = get_result("select count(id) as dem from #_lienhe where type='datban' and hienthi=0");
$dem_thu = get_result("select count(id) as dem from #_lienhe where type='lienhe' and hienthi=0");
// $dem_user = get_result("select count(id) as dem from #_user where active=0");
?>
<div class="wrapper">
    <div class="menu_mobi"><i class="fa fa-bars" aria-hidden="true"></i></div>
    <div class="welcome">
        <a href="#" title="">
            <img src="images/userPic.png" alt="" />
        </a>
        <span>Xin chào, <?=$_SESSION['login_admin']['username']?>!</span>
    </div>
    <div class="userNav">
        <ul>
                <?php /* 
                <li><a href="//<?=$config_url?>" title="" target="_blank">
                <img src="./images/icons/topnav/mainWebsite.png" alt="" /> 
                <span>Vào trang web</span></a></li>
                */?>
            <li><a href="index.php?com=user&act=admin_edit" title="" >
            <span>Tài Khoản</span></a></li>
            <?php /* 
            <li><a href="index.php?com=order&act=man" title=""><img src="./images/icons/topnav/cart.png" 
            alt="" style="height: 15px;margin-top: 6px;" /><span>Đơn hàng</span></a></li>

            <li><a href="index.php?com=user&act=man" title="" target="_blank">
            <img src="./images/icons/topnav/profile.png" alt="" style="height: 15px;margin-top: 6px;" />
            <span>Quản lý thành viên</span><span class="numberTop"><?=$dem_user[0]['dem']?></span></a></li>

            <li><a href="sitemap.php" title="" target="_blank"><img src="./images/icons/topnav/export-icon.png" 
            alt="" style="height: 15px;margin-top: 6px;" /><span>Cập nhật sitemap</span></a></li> 

            <li class="ddnew2"><a title="" class="hien_menu"><img src="images/icons/topnav/profile.png" 
            alt="" /><span>Thành viên</span><span class="numberTop"></span></a> <ul class="menu_header"> 
            <?php phanquyen_menu('Đăng ký','about','capnhat','dangky'); ?> 
            <?php phanquyen_menu('Đăng nhập','about','capnhat','dangnhap'); ?> 
            <?php phanquyen_menu('Quên mật khẩu','about','capnhat','quenmatkhau'); ?> 
            <?php phanquyen_menu('Thay đổi thông tin','about','capnhat','thaydoithongtin'); ?> 
            <?php phanquyen_menu('Quản lý thành viên','user','man',''); ?> </ul> </li>
            
            <li><a title="Có <?=$dem_datban[0]['dem']?> chưa đọc" href="index.php?com=lienhe&act=man&type=datban" title=""><img src="images/icons/topnav/messages.png" alt="" /><span>Liên hệ báo giá</span><span class="numberTop"><?=$dem_datban[0]['dem']?></span></a></li>
            <li><a title="Có <?=$dem_thu[0]['dem']?> chưa đọc" href="index.php?com=lienhe&act=man&type=lienhe"
             title=""><img src="images/icons/topnav/messages.png" alt="" /><span>Thư liên hệ</span>
             <span class="numberTop"><?=$dem_thu[0]['dem']?></span></a></li>
            */?>
            <li><a href="index.php?com=user&act=logout" title=""><?php /* 
            <img src="images/icons/topnav/logout.png"
                         alt="" /> 
            */?><span>Đăng xuất</span></a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>
