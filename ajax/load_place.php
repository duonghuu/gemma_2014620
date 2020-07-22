<?php 
include ("ajax_config.php");
$act =  (string)magic_quote(trim(strip_tags($_POST['act'])));

switch($act){
    case "dist":
        load_dist();
        break;
    case "ward":
        load_ward();
        break;
    case "street":
        load_street();
        break;
    default:
        break;
}
function load_dist()
{
    $id = (int)($_POST['id']);
    $sql="select id,ten from table_place_dist where id_city='".$id."' and hienthi=1 order by id";     
    $stmt = get_result($sql);
    $str='<option value="0">Chọn danh mục</option>';
    foreach ($stmt as $key => $value) {
        $str.='<option value='.$value["id"].'>'.$value["ten"].'</option>';      
    }
    echo $str;
}
function load_ward()
{
    $id = (int)($_POST['id']);
    $sql="select id,ten from table_place_ward where id_dist='".$id."' and hienthi=1 order by id";     
    $stmt = get_result($sql);
    $str='<option value="0">Chọn danh mục</option>';
    foreach ($stmt as $key => $value) {
        $str.='<option value='.$value["id"].'>'.$value["ten"].'</option>';      
    }
    echo $str;
}
function load_street()
{
    $id = (int)($_POST['id']);
    $sql="select id,ten from table_place_street where id_ward='".$id."' and hienthi=1 order by id";     
    $stmt = get_result($sql);
    $str='<option value="0">Chọn danh mục</option>';
    foreach ($stmt as $key => $value) {
        $str.='<option value='.$value["id"].'>'.$value["ten"].'</option>';      
    }
    echo $str;
}