<?php

session_start();
require('../register/connect.php');

if(isset($_GET['course_id'])) {
  $course_id = $_GET['course_id'];
}

$del_course_query = "DELETE FROM teacher WHERE id=$course_id";
$del_course_result = mysqli_query($connection, $del_course_query) or die(mysqli_error($connection));

header("Location: /userpgs/instructor");

?>