<?php
require('../../../register/connect.php');

if(isset($_POST['class_id'])) {
  $classId=$_POST['class_id'];

  $del_q='UPDATE class SET video=NULL WHERE id='.$classId;
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