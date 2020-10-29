<?php
session_start();

if($get_course_teacher_id == $get_user_id) {
  $user_type = 'instructor';
} else {
  $stucourse_query = "SELECT * FROM stucourse WHERE (stu_id = $get_user_id AND course_id = $course_id)";
  $stucourse_result = mysqli_query($connection, $stucourse_query) or die(mysqli_error($connection));
  if(mysqli_num_rows($stucourse_result)>0) {
    $user_type = 'student';
  } else {
    $user_type = 'neither';
  }
}

?>