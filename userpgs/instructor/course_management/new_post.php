<?php
session_start();
require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $id_query = "SELECT * FROM user WHERE username='$username'";
    $id_result = mysqli_query($connection, $id_query) or die(mysqli_error($connection));
    $id_fetch = mysqli_fetch_array($id_result);
    $id = $id_fetch['id'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

    // if the values of the post is set, post it
    if(isset($_POST['header']) && isset($_POST['description'])) {
	$header = $_POST['header'];
	$header=mysqli_real_escape_string($connection,$header);
	$description = nl2br($_POST['description']);
	$description=mysqli_real_escape_string($connection,$description);


	if(isset($_POST['course_fxstar'])) $cost = $_POST['course_fxstar'];

	//$_POST['biddable'];
	if(isset($_POST['biddable'])) {
	    $biddable=1;
	} else {
	    $biddable=0;
	}

	if(isset($_POST['subbable'])) {
	    $subbable = 1;
	} else {
	    $subbable = 0;
	}
	
	$query = "INSERT INTO `teacher` (user_id, header, description, cost, start_date, biddable, subbable) VALUES ($id, '$header', '$description', $cost, NOW(), $biddable, $subbable)";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

	$sub_check = 1;
	if(isset($_POST['subOf']) && !empty($_POST['subOf'])) {
	    require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
	    $sub_of = $_POST['subOf'];

	    $get_course_id_q = "SELECT * FROM teacher WHERE user_id = $id ORDER BY id DESC LIMIT 1";
	    $get_course_id_r = mysqli_query($connection, $get_course_id_q);
	    $get_course_id_f = mysqli_fetch_array($get_course_id_r);
	    $get_course_id = $get_course_id_f['id'];
	    
	    $sub_q = "INSERT INTO subcourses(course_id, sub_of_id) VALUES($get_course_id, $sub_of)";
	    $sub_r = mysqli_query($fxinstructor_connection, $sub_q);

	    if(!$sub_r) $sub_check = 0;
	}

	if($result && $sub_check) {
	    header("Location: /userpgs/instructor");
	} else {
	    //echo "failed";
	}
    }
?>
