<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

if(isset($_POST['instructorId'])) {
    $instructor_id = $_POST['instructorId'];
    $cost = $_POST['fxstars'];

    if(!is_int((int)$cost) || (int)$cost < 0) {
	echo 0;
	exit();
    }
    
    $set_cost_q = "UPDATE one_on_one SET fxstars = $cost WHERE instructor_id = $instructor_id";
    $set_cost_r = mysqli_query($fxinstructor_connection, $set_cost_q);

    if($set_cost_r) {
	echo 1;
    } else {
	echo 0;
    }
} else {
    echo 'err';
}
    
?>
