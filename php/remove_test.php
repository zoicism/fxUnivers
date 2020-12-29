<?php
require_once('conn/fxinstructor.php');
require_once('../register/connect.php');

if(isset($_POST['courseId'])) {
  $course_id = $_POST['courseId'];

  $del_q = "DELETE FROM question WHERE course_id=$course_id";
  $del_r = mysqli_query($fxinstructor_connection,$del_q);

  if($del_r) {
    $del_teacher_q = "UPDATE teacher SET test_duration=NULL,test_num=NULL WHERE id=$course_id";
    $del_teacher_r = mysqli_query($connection,$del_teacher_q);
  }

  if($del_teacher_r) {
    echo 1;
  } else {
    echo 0;
  }
}

?>