<?php

require('../register/connect.php');
if(isset($_POST['username'])) $username=$_POST['username'];

$dup_un_query="SELECT username FROM user WHERE username='$username'";
$dup_un_result=mysqli_query($connection,$dup_un_query) or die(mysqli_error($connection));
$dup_un_count=mysqli_num_rows($dup_un_result);

if($dup_un_count>0) {
  echo 'dup';
} else {
  echo 'notdup';
}

?>