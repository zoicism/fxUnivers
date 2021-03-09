<?php
if(isset($_POST['classId'])) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
    $classId=$_POST['classId'];
    
    $add_to_wb_q = "INSERT INTO whiteboard(class_id) VALUES($classId)";
    $add_to_wb_r = mysqli_query($fxinstructor_connection, $add_to_wb_q);

    if($add_to_wb_r) echo 1;
    else echo 0;
}
?>
