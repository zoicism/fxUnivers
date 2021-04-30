<?php
if(isset($_SESSION['username'])) {
    $username=$_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}
require_once('../../register/connect.php');
require('wallet_connect.php');

if(isset($_POST['bargainId'])) {
    $bargain_id = $_POST['bargainId'];
    $student_id = $_POST['stuId'];
    $user_type = $_POST['user_type'];

    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

    $bargain_q = "SELECT * FROM bargains WHERE id = $bargain_id";
    $bargain_r = mysqli_query($fxinstructor_connection, $bargain_q);
    $bargain_count = mysqli_num_rows($bargain_r);
    if($bargain_count > 0) {
	$bargain = mysqli_fetch_array($bargain_r);
	$cost = $bargain['fxstars'];
    } else {
	echo 0;
	exit();
    }
    
    // Return fxUser's fxStars
    $return_fxstars_q = "UPDATE fxstars SET balance = balance + $cost WHERE user_id = $student_id";
    $return_fxstars_r = mysqli_query($wallet_connection, $return_fxstars_q);

    if($return_fxstars_r) {
	$rm_bargain_q = "DELETE FROM bargains WHERE id=$bargain_id";
	$rm_bargain_r = mysqli_query($fxinstructor_connection, $rm_bargain_q);

	if($rm_bargain_r) echo 1;
	else echo 0;
    } else {
	echo 0;
	exit();
    }
    
    // Notify student of rejection
} else {
    echo 0;
    exit();
}
?>
