<?php

session_start();
require('../register/connect.php');

$q_id = $_POST['q_id'];
$submit_ans_check_query = "SELECT correct_op FROM exam WHERE id=$q_id";
$submit_ans_check_result = mysqli_query($connection, $submit_ans_check_query) or die(mysqli_error($connection));
$submit_ans_check_fetch = mysqli_fetch_array($submit_ans_check_result);
$correct_option = $submit_ans_check_fetch['correct_op'];

if(isset($_POST['radio'])) {
  $selected_option = $_POST['radio'];
} else {
  echo 'POST is not set!';
}

$course_id = $_POST['course_id'];
require('get_exam.php');
$get_user_id = $_POST['student_id'];
echo 'course_id='.$course_id.'<br>get_user_id='.$get_user_id;

$submit_ans_get_score_query= "SELECT * FROM stucourse WHERE (course_id=$course_id AND stu_id=$get_user_id)";
$submit_ans_get_score_result= mysqli_query($connection, $submit_ans_get_score_query) or die(mysqli_error($connection));
$submit_ans_get_score_fetch = mysqli_fetch_array($submit_ans_get_score_result);
$submit_ans_get_score = $submit_ans_get_score_fetch['score'];

if($correct_option == $selected_option) {
  $submit_ans_get_score=$submit_ans_get_score+1;
  $submit_ans_correct_query = "UPDATE stucourse SET score=$submit_ans_get_score WHERE (course_id=$course_id AND stu_id=$get_user_id)";
  $submit_ans_correct_result = mysqli_query($connection, $submit_ans_correct_query) or die(mysqli_error($connection));

} else {
  echo 'wrong';
  echo $submit_ans_get_score;
}

$question_id = $_POST['question_id'];
$next_question_id=$question_id+1;
echo '<br>next question id='.$next_question_id;

$next_question_query = "SELECT id FROM exam WHERE (question_id>$question_id AND course_id=$course_id) LIMIT 1";
$next_question_result = mysqli_query($connection, $next_question_query) or die(mysqli_error($connection));
$next_question_fetch = mysqli_fetch_array($next_question_result);
$next_q_id = $next_question_fetch['id'];
echo '<br>next q id='.$next_q_id;

if($next_question_result->num_rows>0) {
  $red_location = "Location: /userpgs/instructor/exam/take_exam.php?q_id=$next_q_id&course_id=$course_id";
} else {

  if($submit_ans_get_score/$get_exam_count>=0.5) {
    $exam_acceptance_query = "UPDATE stucourse SET exam_accepted=1 WHERE (course_id=$course_id AND stu_id=$get_user_id)";
  } else {
    $exam_acceptance_query = "UPDATE stucourse SET exam_accepted=0 WHERE (course_id=$course_id AND stu_id=$get_user_id)";
  }
  $exam_acceptance_result = mysqli_query($connection, $exam_acceptance_query) or die(mysqli_error($connection));

  $red_location = "Location: /userpgs/instructor/exam/result.php?course_id=$course_id";
}
header($red_location);

?>