<?php

session_start();
require('../contact/message_connect.php');

if(isset($_POST['subject'])) $subject = $_POST['subject'];
if(isset($_POST['body'])) $body = $_POST['body'];
if(isset($_POST['interest'])) $interest = $_POST['interest'];
if(isset($_POST['user_id'])) $userId = $_POST['user_id'];

$partner_msg_query = "INSERT INTO partner(subject, body, interest, userId) VALUES('$subject', '$body', '$interest', $userId)";
$partner_msg_result = mysqli_query($msg_connection, $partner_msg_query) or die(mysqli_error($msg_connection));

?>