<?php
if(isset($_POST['classId'])) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
    $classId=$_POST['classId'];
    
    $add_to_ins_q = "INSERT INTO ins_live(class_id) VALUES($classId); INSERT INTO live_exists(class_id) VALUES($classId);";
    $add_to_ins_r = mysqli_multi_query($fxinstructor_connection, $add_to_ins_q);

    if($add_to_ins_r) echo 1;
    else echo 0;
}

?>
