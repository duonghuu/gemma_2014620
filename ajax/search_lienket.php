<?php
    include ("ajax_config.php");
    $act =  (string)magic_quote(trim(strip_tags($_POST['act'])));
    $keywords =  (string)magic_quote(trim(strip_tags($_POST['keywords'])));
    $id = (int)($_POST['id']);
    $prlk = get_result("select ten,id,thumb,type,id_danhmuc,id_list,id_cat,id_item,id_nhasanxuat,type from table_product where type='menu' and hienthi>0 order by id desc");
    $str_rs = '';
    if(!empty($prlk)){
        $str_rs = '<div id="itemContainerall" class="product-grid">';
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
              <span class="btn_lienket" data-act="lienket" data-idlienket="'.$value['id'].'" data-id="'.$id.'">LIÊN KẾT</span>
            </div>';
         }
        $str_rs .= '</div>';
    }
    echo $str_rs;