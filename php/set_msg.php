<?php
require('../contact/message_connect.php');

if(isset($_POST['msgBody'])) {
    $msgBody = $_POST['msgBody'];
    $msgBody=mysqli_real_escape_string($msg_connection,$msgBody);
}
if(isset($_POST['clientId'])) $clientId = $_POST['clientId'];
if(isset($_POST['guestId'])) $guestId = $_POST['guestId'];

if(1) {
  $set_last_query = "UPDATE messenger SET last=0 WHERE ((user1id=$clientId AND user2id=$guestId) OR (user1id=$guestId AND user2id=$clientId)) AND last=1";
  $set_last_result = mysqli_query($msg_connection, $set_last_query) or die(mysqli_error($msg_connection));
}

$set_msg_query = "INSERT INTO messenger(user1id, user2id, text) VALUES($clientId, $guestId, '$msgBody')";
$set_msg_result = mysqli_query($msg_connection, $set_msg_query) or die(mysqli_error($msg_connection));



?>