<?php


$crt_live_class_query = "INSERT INTO liveclass(inst_id, class_id, hash) VALUES($get_user_id, $class_id, '$liveClassId')";
$crt_live_class_result = mysqli_query($msg_connection, $crt_live_class_query) or die(mysqli_error($msg_connection));


?>