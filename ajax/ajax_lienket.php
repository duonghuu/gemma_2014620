<?php
    include ("ajax_config.php");
    $act =  (string)magic_quote(trim(strip_tags($_POST['act'])));
    $id = (int)($_POST['id']);
    $idlienket = (int)($_POST['idlienket']);
    
    $prthuoctinh = get_fetch("select thuoctinh from table_product where id='".$id."'");
    $a_thuoctinh = array();
    if(!empty($prthuoctinh["thuoctinh"])){
        $a_thuoctinh = json_decode($prthuoctinh["thuoctinh"],true);
    }
    if($act == "lienket"){
        if(!in_array($idlienket, $a_thuoctinh)){
            //add $idlienket into $a_thuoctinh
            $a_thuoctinh[] = $idlienket;
            $d->reset();
            $d->setTable("product");
            $d->setWhere("id",$id);
            $data["thuoctinh"] = json_encode($a_thuoctinh);
            $d->update($data);
            $condition = implode(',', $a_thuoctinh);

            if(!empty($condition)){

                $str_rs = "";
                $prlk = get_result("select ten,id,thumb,type,id_danhmuc,id_list,id_cat,id_item,id_nhasanxuat,type from table_product where id in (".$condition.") order by id desc");
               
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
                         <span class="btn_lienket" data-act="huylienket" data-idlienket="'.$value['id'].'" data-id="'.$id.'">HỦY LIÊN KẾT</span>
                       </div>'; 
                    }
                    $str_rs .= '</div>';
                }
            }
        }else{
            $str_rs = "1";
        }
    }else{
        if (($keyvt = array_search($idlienket, $a_thuoctinh)) !== false) {
            unset($a_thuoctinh[$keyvt]);
        }
        $d->reset();
        $d->setTable("product");
        $d->setWhere("id",$id);
        $data["thuoctinh"] = json_encode($a_thuoctinh);
        $d->update($data);
        $condition = implode(',', $a_thuoctinh);

        if(!empty($condition)){

            $str_rs = "";
            $prlk = get_result("select ten,id,thumb,type,id_danhmuc,id_list,id_cat,id_item,id_nhasanxuat,type from table_product where id in (".$condition.") order by id desc");
           
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
                     <span class="btn_lienket" data-act="huylienket" data-idlienket="'.$value['id'].'" data-id="'.$id.'">HỦY LIÊN KẾT</span>
                   </div>'; 
                }
                $str_rs .= '</div>';
            }
        }
    }
    
    
    
    
    // $a_test = array(1,2,3,4,5);
    // $jsec_a = json_encode($a_test);
    // echo '<pre>js encode'; print_r($jsec_a); echo '</pre>';
    // $jsdc_a = json_decode($jsec_a);
    // echo '<pre>js decode'; print_r($jsdc_a); echo '</pre>';
    // if(in_array(9, $jsdc_a)){
    // }
    // else{
    //   $jsdc_a[] = 9;
    // }
    // if (($key = array_search($del_val, $messages)) !== false) {
    //     unset($messages[$key]);
    // }
    echo $str_rs;