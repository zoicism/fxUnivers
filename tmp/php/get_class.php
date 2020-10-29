<?php

$get_class_query="SELECT * FROM class WHERE id=$class_id";
$get_class_result=mysqli_query($connection,$get_class_query) or die(mysqli_error($connection));
$get_class=mysqli_fetch_array($get_class_result);

require('conn/fxinstructor.php');
$get_class_file_query="SELECT * FROM class_files WHERE classId=$class_id";
$get_class_file_result=mysqli_query($fxinstructor_connection,$get_class_file_query) or die(mysqli_error($fxinstructor_connection));
$get_class_file=mysqli_fetch_array($get_class_file_result);
$get_class_file_count=mysqli_num_rows($get_class_file_result);
?>