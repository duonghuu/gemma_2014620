<?php
    include ("ajax_config.php");
    $v_bang =  (string)magic_quote(trim(strip_tags(str_replace('table_', '', $_POST['bang']))));
    $v_type =  (string)magic_quote(trim(strip_tags($_POST['type'])));
    $v_value =  (string)magic_quote(trim(strip_tags($_POST['value'])));
    $v_id =  (int)$_POST['id'];
    if($v_id > 0){
        $u_data = array();
        $u_data[$v_type] = $v_value;
        $d->reset();
        $d->setTable($v_bang);
        $d->setWhere("id", $v_id);
        $d->update($u_data);
        // echo $d->sql;
    }
?>
