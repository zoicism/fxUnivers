<?php

require('../contact/message_connect.php');
$get_msg_query = "SELECT * FROM messenger WHERE (user1id=$get_user_id OR user2id=$get_user_id) AND last=1 ORDER BY id DESC";
$get_msg_result = mysqli_query($msg_connection, $get_msg_query) or die(mysqli_error($msg_connection));
$get_msg_count = mysqli_num_rows($get_msg_result);
?>