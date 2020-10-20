<?php

$join_live_class_query = "SELECT * FROM liveclass WHERE class_id=$class_id ORDER BY id DESC LIMIT 1";
$join_live_class_result = mysqli_query($msg_connection, $join_live_class_query) or die(mysqli_error($msg_connection));
$join_live_class_fetch = mysqli_fetch_array($join_live_class_result);
$join_live_class_roomid = $join_live_class_fetch['hash'];

?>