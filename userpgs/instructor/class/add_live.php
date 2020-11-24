<?php
require('../../../register/connect.php');

if(isset($_POST['classId'])) {
  $class_id=$_POST['classId'];

  $live_q="UPDATE class SET live=1 WHERE id=$class_id";
  $live_r=mysqli_query($connection,$live_q) or die(mysqli_error($connection));

  if($live_r) {
    echo 1;
  } else {
    echo 0;
  }
}

?>

