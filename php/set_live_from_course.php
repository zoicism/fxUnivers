<?php

session_start();
require_once('../register/connect.php');

if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	$id_query = "SELECT * FROM user WHERE username='$username'";
	$id_result = mysqli_query($connection, $id_query) or die(mysqli_error($connection));
	$id_fetch = mysqli_fetch_array($id_result);
	$id = $id_fetch['id'];
}

// if the values of the post is set, post it
$header='Live Session';
$description='';
if(isset($_POST['courseId'])) $course_id = $_POST['courseId'];


$query = "INSERT INTO `class` (teacher_id, course_id, title, body, dt) VALUES ($id, $course_id, '$header', '$description', NOW())";
$result = mysqli_query($connection, $query);

$classId_query="SELECT * FROM class WHERE teacher_id=$id ORDER BY id DESC LIMIT 1";
$classId_result=mysqli_query($connection,$classId_query) or die(mysqli_error($connection));
$classId_fetch=mysqli_fetch_array($classId_result);
$classId=$classId_fetch['id'];


if($result) {
	//header("Location: /userpgs/instructor/class?course_id=$course_id&class_id=$classId");
	$live_q="UPDATE class SET live=1 WHERE id=$classId";
  	$live_r=mysqli_query($connection,$live_q);

	if($live_r) {
	    //echo '<form action="/userpgs/instructor/class/live/#'.$classId.'" method="POST" id="LiveForm"><input type="hidden" name="course_id" value="'.$course_id.'"><input type="hidden" name="class_id" value="'.$classId.'"></form>';
	    echo $classId;
	} else {
	  echo 0;
	}
} else {
	echo 0;
}

?>
