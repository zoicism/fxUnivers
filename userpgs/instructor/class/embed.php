<?php
require('../../../register/connect.php');

if(isset($_POST['class_id']) && isset($_POST['embed_link'])) {
  $classId=$_POST['class_id'];
  $embedLink=mysqli_real_escape_string($connection,$_POST['embed_link']);

  $embed_q='UPDATE class SET video="'.$embedLink.'" WHERE id='.$classId;
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