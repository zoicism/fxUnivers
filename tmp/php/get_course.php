<?php
session_start();

$get_course_query = "SELECT * FROM teacher WHERE id=$course_id";
$get_course_result = mysqli_query($connection, $get_course_query) or die(mysqli_error($connection));
$get_course_fetch = mysqli_fetch_array($get_course_result);

$get_course_teacher_id = $get_course_fetch['user_id'];

?>