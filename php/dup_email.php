<?php

require('../register/connect.php');
if(isset($_POST['email'])) $email=$_POST['email'];

$dup_query="SELECT email FROM user WHERE email='$email'";
$dup_result=mysqli_query($connection,$dup_query) or die(mysqli_error($connection));
$dup_count=mysqli_num_rows($dup_result);
if($dup_count>0) {
  echo 'dup';
} else {
  echo 'nodup';
}

?>