<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/wallet/php/wallet_connect.php');

if(isset($_POST['my_bargain']) && isset($_POST['course_id']) && isset($_POST['student_id'])) {
    $my_bargain = $_POST['my_bargain'];
    $course_id = $_POST['course_id'];
    $student_id= $_POST['student_id'];
    $real_cost = $_POST['real_cost'];

    $my_bargain_whole = floor($my_bargain);
    $my_bargain_dec = $my_bargain - $my_bargain_whole;
    
    if(!is_int((int)$my_bargain) || (int)$my_bargain < 0 || abs($my_bargain_dec) > 0) {
	echo 'invalid';
	exit();
    }

    $check_prev_bargains_q = "SELECT * FROM bargains WHERE course_id = $course_id AND student_id = $student_id";
    $check_prev_bargains_r = mysqli_query($fxinstructor_connection, $check_prev_bargains_q);
    if($check_prev_bargains_r) {
	$check_prev_bargains = mysqli_num_rows($check_prev_bargains_r);
	if($check_prev_bargains > 0) {
	    echo 'bargained_already';
	    exit();
	}

	$check_fxstars_q = "SELECT * FROM fxstars WHERE user_id = $student_id";
	$check_fxstars_r = mysqli_query($wallet_connection, $check_fxstars_q);
	$check_fxstars = mysqli_fetch_array($check_fxstars_r);
	$student_old_balance = $check_fxstars['balance'];

	if($my_bargain >= $real_cost) {
	    echo 'more_than_real_cost';
	    exit();
	} else if($student_old_balance < $my_bargain) {
	    echo 'insuff';
	    exit();
	} else {
	    $bargain_fxstars_q = "UPDATE fxstars SET balance = balance - $my_bargain WHERE user_id = $student_id";
	    $bargain_fxstars_r = mysqli_query($wallet_connection, $bargain_fxstars_q);
	    
	    if($bargain_fxstars_r) {
		$add_bargain_q = "INSERT INTO bargains(course_id, student_id, fxstars) VALUES($course_id, $student_id, $my_bargain)";
		$add_bargain_r = mysqli_query($fxinstructor_connection, $add_bargain_q);
	    } else {
		echo 'err: bargain_fxstars';
		exit();
	    }
	}
	
	if($add_bargain_r) {
	    echo 1;
	} else {
	    echo 0;
	}
    } else {
	echo 0;
	exit();
    }
} else {
    echo 0;
}

?>
