<?php
if(isset($_POST['classId'])) {
    $class_id = $_POST['classId'];
    require_once($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

    $del_ins_live_q = "DELETE FROM ins_live WHERE class_id=$class_id; DELETE FROM live_exists WHERE class_id=$class_id;";
    $del_ins_live_r = mysqli_multi_query($fxinstructor_connection, $del_ins_live_q);

    $kill_query = "UPDATE class SET alive=0 WHERE id=$class_id";
    $kill_result = mysqli_query($connection, $kill_query);

    if($kill_result && $del_ins_live_r) {
	echo 1;
    } else {
	echo 0;
    }
}

?>
