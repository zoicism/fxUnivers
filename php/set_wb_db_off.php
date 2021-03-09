<?php

if(isset($_POST['classId'])) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
    $classId=$_POST['classId'];
    
    $del_wb_q = "DELETE FROM whiteboard WHERE class_id=$classId";
    $del_wb_r = mysqli_query($fxinstructor_connection, $del_wb_q);
    
    if($del_wb_r) echo 1;
    else echo 0;
}

?>
