<?php

session_start();
require('../register/connect.php');

$firstname = $_POST['firstname'];
$firstname=mysqli_real_escape_string($connection,$firstname);
$lastname = $_POST['lastname'];
$lastname=mysqli_real_escape_string($connection,$lastname);
$username = $_POST['username'];
$username=mysqli_real_escape_string($connection,$username);
$email = $_POST['email'];
$email=mysqli_real_escape_string($connection,$email);
$hash = $_POST['hash'];
if(isset($_POST['phonenumber']) && !empty($_POST['phonenumber'])) {
  $phonenumber = $_POST['phonenumber'];
} else {
  $phonenumber = 'NA';
}
$uname_dup_query = "SELECT * FROM user WHERE username='$username'";
$uname_dup_result = mysqli_query($connection, $uname_dup_query) or die(mysqli_error($connection));
$uname_dup_num = mysqli_num_rows($uname_dup_result);

$un_valid=1;

if($uname_dup_num>0) {
  $un_valid = 0;
  header("Location: /register/verify_email.php?email=".$email."&hash=".$hash."&err=dup");
}

if($un_valid) {
   $signup2_query = "UPDATE user SET fname='$firstname', lname='$lastname', username='$username', phone='$phonenumber' WHERE email='$email'";
   $signup2_result = mysqli_query($connection, $signup2_query) or die(mysqli_error($connection));

  if($signup2_result) {
    $_SESSION['username'] = $username;
    header("Location: /userpgs");
  }

}
?>