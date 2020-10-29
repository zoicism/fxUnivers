<?php

session_start();
require('../../../register/connect.php');

$question = nl2br($_POST['question']);
$question = mysqli_real_escape_string($connection,$question);

$option_a = nl2br($_POST['answer_a']);
$option_a = mysqli_real_escape_string($connection,$option_a);

$option_b = nl2br($_POST['answer_b']);
$option_b = mysqli_real_escape_string($connection,$option_b);

$option_c = nl2br($_POST['answer_c']);
$option_c = mysqli_real_escape_string($connection,$option_c);

$option_d = nl2br($_POST['answer_d']);
$option_d = mysqli_real_escape_string($connection,$option_d);

$course_id = $_POST['course_id'];
$question_id = $_POST['question_id'];
$cor_ans = $_POST['cor_ans'];


$question_query = "INSERT INTO exam(course_id, question_id, question, option_a, option_b, option_c, option_d, correct_op) VALUES($course_id, $question_id, '$question', '$option_a', '$option_b', '$option_c', '$option_d', '$cor_ans')";
$question_result = mysqli_query($connection, $question_query) or die(mysqli_error($connection));

if($question_result) {
  header("Location: /userpgs/instructor/exam?course_id=$course_id");
}

?>