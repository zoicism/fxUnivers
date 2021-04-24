<?php
if(isset($_POST['classId'])) {
    $class_id = $_POST['classId'];
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

    $del_ins_live_q = "DELETE FROM ins_live WHERE class_id=$class_id; DELETE FROM live_exists WHERE class_id=$class_id;";
    $del_ins_live_r = mysqli_multi_query($fxinstructor_connection, $del_ins_live_q);

    if($del_ins_live_r) echo 1; else echo 0;
}
?>
