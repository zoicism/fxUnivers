<?php

session_start();
require('../register/connect.php');

$test_date = $_POST['exam_date'];
$course_id = $_POST['course_id'];

$exam_date_query = "UPDATE teacher SET test_date='$test_date' WHERE id=$course_id";
$exam_date_result = mysqli_query($connection, $exam_date_query) or die(mysqli_error($connection));

$reset_exam_accepted_query="UPDATE stucourse SET exam_accepted=NULL WHERE (course_id=$course_id AND exam_accepted=0)";
$reset_exam_accepted_result=mysqli_query($connection,$reset_exam_accepted_query) or die(mysqli_error($connection));

if($exam_date_result) {
    header("Location: /userpgs/instructor/course_management/course.php?course_id=$course_id");
}

?>