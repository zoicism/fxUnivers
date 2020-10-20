<?php

$get_guest_query = "SELECT * FROM user WHERE id=$guest_id";
$get_guest_result = mysqli_query($connection, $get_guest_query) or die(mysqli_error($connection));
$get_guest = mysqli_fetch_array($get_guest_result);

?>