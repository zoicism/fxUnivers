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
$q_id = $_POST['q_id'];


$question_query = "UPDATE exam SET question_id=$question_id, question='$question', option_a='$option_a', option_b='$option_b', option_c='$option_c', option_d='$option_d', correct_op='$cor_ans' WHERE id=$q_id";
$question_result = mysqli_query($connection, $question_query) or die(mysqli_error($connection));

if($question_result) {
    //header("Location: /userpgs/instructor/course_management/course.php?course_id=$course_id");
    header("Location: /userpgs/instructor/exam/edit_exam.php?q_id=$q_id&course_id=$course_id");
}

?>