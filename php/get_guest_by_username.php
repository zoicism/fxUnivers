<?php

$get_guest_by_username_query = "SELECT * FROM user WHERE username='$guest'";
$get_guest_by_username_result = mysqli_query($connection, $get_guest_by_username_query) or die(mysqli_error($connection));
$get_guest_by_username = mysqli_fetch_array($get_guest_by_username_result);

?>