<?php

session_start();
require('../../../register/connect.php');

$q_id = $_POST['q_id'];
$course_id = $_POST['course_id'];

echo $q_id;
echo $course_id;

$del_question_query = "DELETE FROM exam WHERE id=$q_id";
$del_question_result = mysqli_query($connection, $del_question_query) or die(mysqli_error($connection));

if($del_question_result) {
  header("Location: /userpgs/instructor/exam?course_id=$course_id");
}

?>