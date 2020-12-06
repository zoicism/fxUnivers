<?php

session_start();
require('../register/connect.php');

if(isset($_POST['course_id'])) {
  $course_id = $_POST['course_id'];
}

$del_course_query = "UPDATE teacher SET alive=0 WHERE id=$course_id";
$del_course_result = mysqli_query($connection, $del_course_query) or die(mysqli_error($connection));

if($del_course_result) echo 'deleted';
else echo 'error';

?>