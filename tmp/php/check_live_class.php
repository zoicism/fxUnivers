<?php

$check_live_class_query = "SELECT * FROM liveclass WHERE class_id=$class_id";
$check_live_class_result = mysqli_query($msg_connection, $check_live_class_query) or die(mysqli_error($msg_connection));
$check_live_class_num = mysqli_num_rows($check_live_class_result);

?>