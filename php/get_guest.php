<?php

$get_guest_query = "SELECT * FROM user WHERE id=$sidebar_guest_id";
$get_guest_result = mysqli_query($connection, $get_guest_query) or die(mysqli_error($connection));
$get_guest = mysqli_fetch_array($get_guest_result);

require('../contact/message_connect.php');
$get_unread_q = "SELECT * FROM messenger WHERE (user1id=$sidebar_guest_id AND user2id=$get_user_id AND read_dt IS NULL)";
$get_unread_r = mysqli_query($msg_connection,$get_unread_q) or die(mysqli_error($msg_connection));
$get_unread_count = mysqli_num_rows($get_unread_r);
?>