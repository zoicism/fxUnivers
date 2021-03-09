<?php
if(isset($_POST['classId'])) {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
    $class_id = $_POST['classId'];

    $screen_check_q = "SELECT * FROM screen WHERE class_id=$class_id";
    $screen_check_r = mysqli_query($fxinstructor_connection, $screen_check_q);
    $screen_check = mysqli_num_rows($screen_check_r);

    $screen_wb = array();
    
    if($screen_check > 0) {
	$screen_wb[0]=1;
    } else {
	$screen_wb[0]=0;
    }

    $wb_check_q = "SELECT * FROM whiteboard WHERE class_id=$class_id";
    $wb_check_r = mysqli_query($fxinstructor_connection, $wb_check_q);
    $wb_check = mysqli_num_rows($wb_check_r);

    if($wb_check > 0) {
	$screen_wb[1]=1;
    } else {
	$screen_wb[1]=0;
    }


    $ins_check_q = "SELECT * FROM ins_live WHERE class_id=$class_id";
    $ins_check_r = mysqli_query($fxinstructor_connection, $ins_check_q);
    $ins_check = mysqli_num_rows($ins_check_r);

    if($ins_check > 0) {
	$screen_wb[2]=1;
    } else {
	$screen_wb[2]=0;
    }

    
    echo json_encode($screen_wb);
    

} else {
    echo 0;
}

?>
