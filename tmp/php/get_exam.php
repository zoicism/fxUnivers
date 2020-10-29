<?php

$get_exam_query = "SELECT * FROM exam WHERE course_id=$course_id";
$get_exam_result = mysqli_query($connection, $get_exam_query) or die(mysqli_error($connection));
$get_exam_result2 = mysqli_query($connection, $get_exam_query) or die(mysqli_error($connection));
//$get_exam_fetch = mysqli_fetch_array($get_exam_result);

$get_exam_count = mysqli_num_rows($get_exam_result);

?>
