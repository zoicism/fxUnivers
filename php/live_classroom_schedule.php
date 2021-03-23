<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

$theDate = $_POST['theDate'];
$theTime = $_POST['theTime'];
$courseId = $_POST['courseId'];
$teacherId = $_POST['teacherId'];

$dt = $_POST['theDate'].' '.$_POST['theTime'];
$dt_timestamp = strtotime($dt);
$time_diff = $dt_timestamp - time();


if($time_diff > 0) {

    require_once($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');

    // if the values of the post is set, post it
    $header='Scheduled Live Session';
    $description='';


    $query = "INSERT INTO `class` (teacher_id, course_id, title, body, dt, theTime) VALUES ($teacherId, $courseId, '$header', '$description', '$theDate', '$theTime')";
    $result = mysqli_query($connection, $query);


    
    if($result) {
	echo 1;
    } else {
	echo 0;
    }
} else {
    echo 'in_the_past';
}
?>
