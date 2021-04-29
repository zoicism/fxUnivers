<?php
if(isset($_POST['classId'])) {
    $class_id = $_POST['classId'];
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

    $del_ins_live_q = "UPDATE stu_oneonone SET alive = 0, active = 0 WHERE id = $class_id";
    $del_ins_live_r = mysqli_query($fxinstructor_connection, $del_ins_live_q);

    if($del_ins_live_r) {
	echo 1;
    } else {
	echo 0;
    }
}

?>
