<?php

if(isset($_POST['classId'])) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
    $classId=$_POST['classId'];
    
    $del_ins_live_q = "DELETE FROM ins_live WHERE class_id=$classId";
    $del_ins_live_r = mysqli_query($fxinstructor_connection, $del_ins_live_q);
    
    if($del_ins_live_r) echo 1;
    else echo 0;
}

?>
