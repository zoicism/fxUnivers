<?php
if(isset($_POST['classId'])) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
    $classId=$_POST['classId'];
    
    $add_to_screen_q = "INSERT INTO screen(class_id) VALUES($classId)";
    $add_to_screen_r = mysqli_query($fxinstructor_connection, $add_to_screen_q);

    if($add_to_screen_r) echo 1;
    else echo 0;
}

?>
