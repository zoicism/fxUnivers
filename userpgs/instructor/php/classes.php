<?php
session_start();
$class_query = "SELECT * FROM class WHERE course_id=$course_id AND alive=1";
$class_result = mysqli_query($connection, $class_query) or die(mysqli_error($connection));
$class_num=mysqli_num_rows($class_result);
/*$fetch_class = mysqli_fetch_array($class_result);

$first_title = $fetch_class['title'];
$first_body = $fetch_class['body'];
$first_class_id = $fetch_class['id'];
*/
?>