<?php
require('message_connect.php');

echo 's'.$_POST['fname'];

if(isset($_POST['fname']) and !empty($_POST['fname'])) {
  $fname = $_POST['fname'];
}

if(isset($_POST['lname'])) {
  $lname = $_POST['lname'];
}

if(isset($_POST['subject']) and !empty($_POST['subject'])) {
  $subject = $_POST['subject'];
}

if(isset($_POST['email'])) {
  $email = $_POST['email'];
}

if(isset($_POST['body'])) {
  $body = $_POST['body'];
}

$msg_query = "INSERT INTO messageus(fname, lname, subject, email, body) VALUES('fname', '$lname', '$subject', '$email', '$body')";
$msg_result = mysqli_query($msg_connection, $msg_query) or die(mysqli_error($msg_connection));
/*
if($msg_result) {
  echo "success";
  echo $fname.' '.$lname;
  header("Location: /#contact-section?msg=sent");
} else {
  header("Location: /?#contact-section?msg=failed");
}
*/
?>
