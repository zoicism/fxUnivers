<?php
require('../../../register/connect.php');

if(isset($_POST['course_id']) && isset($_POST['embed_link'])) {
  $courseId=$_POST['course_id'];
  $embedLink=mysqli_real_escape_string($connection,$_POST['embed_link']);

  $embed_q='UPDATE teacher SET video_url="'.$embedLink.'" WHERE id='.$courseId;
  $embed_r=mysqli_query($connection,$embed_q);

  if($embed_r) {
    echo 1;
  } else {
    echo 0;
  }
} else {
  echo 0;
}
?>