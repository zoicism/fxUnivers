<?php
session_start();

$course_query = "SELECT * FROM teacher WHERE user_id=$tarid ORDER BY id DESC";
$course_result = mysqli_query($connection, $course_query) or die(mysqli_error($connection));
/*$fetch_course = mysqli_fetch_array($course_result);
$course_title = $fetch_course['header'];
$course_desc = $fetch_course['description'];
$course_id = $fetch_course['id'];*/
$course_count = mysqli_num_rows($course_result);
?>