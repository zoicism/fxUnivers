<?php

require('../contact/message_connect.php');
$get_messenger_query = "SELECT * FROM messenger WHERE (user1id=$get_user_id AND user2id=$guest_id) OR (user1id=$guest_id AND user2id=$get_user_id)";
$get_messenger_result = mysqli_query($msg_connection, $get_messenger_query) or die(mysqli_error($msg_connection));
$get_messenger_count = mysqli_num_rows($get_messenger_result);


// set readd=1 if this user is online
$readd_query="UPDATE messenger SET readd=1 WHERE (user2id=$get_user_id AND readd=0)";
$readd_result=mysqli_query($msg_connection,$readd_query) or die(mysqli_error($msg_connection));
?>