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
	$_POST['biddable'];
	if(isset($_POST['biddable'])) {
	    $biddable=1;
	} else {
	    $biddable=0;
	}

	
	
	$query = "INSERT INTO `teacher` (user_id, header, description, cost, start_date, biddable) VALUES ($id, '$header', '$description', $cost, NOW(), $biddable)";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

	

	if($result) {
	    
	    header("Location: /userpgs/instructor");
	} else {
	    //echo "failed";
	}
    }
?>
