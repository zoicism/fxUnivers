<?php
require('../../../register/connect.php');

if(isset($_POST['course_id'])) {
  $courseId=$_POST['course_id'];

  $del_q='UPDATE teacher SET video_url=NULL WHERE id='.$courseId;
  $del_r=mysqli_query($connection,$del_q) or die(mysqli_error($connection));

  if($del_r) {
    echo 1;
  } else {
    echo 0;
  }
} else {
  echo 0;
}
?>