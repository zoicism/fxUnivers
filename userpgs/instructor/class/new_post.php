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
if(isset($_POST['header'])) {
    $header = $_POST['header'];
    $header=mysqli_real_escape_string($connection,$header);
}
if(isset($_POST['description'])) {
    $description = nl2br($_POST['description']);
    $description=mysqli_real_escape_string($connection,$description);
}
if(isset($_POST['course_id'])) $course_id = $_POST['course_id'];

$theTime = date('H:i');
$theDate = date('Y-m-d');


$query = "INSERT INTO `class` (teacher_id, course_id, title, body, dt, theTime) VALUES ($id, $course_id, '$header', '$description', '$theDate', '$theTime')";
//echo '>>'.$query;
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

$classId_query="SELECT * FROM class WHERE teacher_id=$id ORDER BY id DESC LIMIT 1";
$classId_result=mysqli_query($connection,$classId_query) or die(mysqli_error($connection));
$classId_fetch=mysqli_fetch_array($classId_result);
$classId=$classId_fetch['id'];


if($result) {    
    //echo "successful";
    header("Location: /userpgs/instructor/class?course_id=$course_id&class_id=$classId");
} else {
    //echo "failed";
}

?>
