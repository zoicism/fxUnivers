<?php

session_start();

$username = $_SESSION['username'];
if(isset($_GET['teacher_un'])) {
  $teacher_un = $_GET['teacher_un'];
}

$query = "SELECT * FROM user WHERE username='$teacher_un'";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
$fetch_user = mysqli_fetch_array($result);
$id = $fetch_user['id'];

$course_query = "SELECT * FROM teacher WHERE user_id=$id ORDER BY id DESC";
$course_result = mysqli_query($connection, $course_query) or die(mysqli_error($connection));
$fetch_course = mysqli_fetch_array($course_result);
$course_title = $fetch_course['header'];
$course_desc = $fetch_course['description'];
$course_id = $fetch_course['id'];

?>