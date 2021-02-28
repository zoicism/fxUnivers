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


    if(isset($_POST['course_id'])) {
	$course_id = $_POST['course_id'];
    }

    // if the values of the post is set, post it
    if(isset($_POST['header']) && isset($_POST['description'])) {
	$header = $_POST['header'];
	$header=mysqli_real_escape_string($connection,$header);
	$description = nl2br($_POST['description']);
	$description=mysqli_real_escape_string($connection,$description);


	if(isset($_POST['start_date'])) $start_date = $_POST['start_date'];
	if(isset($_POST['exam_date'])) $exam_date = $_POST['exam_date'];
	//if(isset($_POST['video_url'])) $video = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$_POST["video_url"].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	if(isset($_POST['course_fxstar'])) $cost = $_POST['course_fxstar'];


	$query = "UPDATE `teacher` SET header='$header', description='$description', cost='$cost' WHERE id=$course_id";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	
	if($result) {
	    //echo "successful";
	    header("Location: /userpgs/instructor/course_management/course.php?course_id=".$course_id);
	} else {
	    //echo "failed";
	}
    }
?>
