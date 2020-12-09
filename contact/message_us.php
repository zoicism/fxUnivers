<?php
require('message_connect.php');

//echo 's'.$_POST['fname'];

if(isset($_POST['fname']) and !empty($_POST['fname'])) {
  $fname = mysqli_real_escape_string($msg_connection,$_POST['fname']);
}

if(isset($_POST['lname'])) {
  $lname = mysqli_real_escape_string($msg_connection,$_POST['lname']);
}

if(isset($_POST['subject']) and !empty($_POST['subject'])) {
  $subject = mysqli_real_escape_string($msg_connection,$_POST['subject']);
}

if(isset($_POST['email'])) {
  $email = mysqli_real_escape_string($msg_connection,$_POST['email']);
}

if(isset($_POST['body'])) {
  $body = mysqli_real_escape_string($msg_connection,$_POST['body']);
}

$msg_query = "INSERT INTO messageus(fname, lname, subject, email, body) VALUES('$fname', '$lname', '$subject', '$email', '$body')";
$msg_result = mysqli_query($msg_connection, $msg_query) or die(mysqli_error($msg_connection));

if($msg_result) {
  echo "sent";
} else {
  echo "failed";
}

?>
