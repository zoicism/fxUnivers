<?php

if(isset($_POST['classId'])) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
    $classId=$_POST['classId'];
    
    $del_screen_q = "DELETE FROM screen WHERE class_id=$classId";
    $del_screen_r = mysqli_query($fxinstructor_connection, $del_screen_q);
    
    if($del_screen_r) echo 1;
    else echo 0;
}

?>
