<?php
$tar_user_query = "SELECT * FROM user WHERE id=$tar_id";
$tar_user_result = mysqli_query($connection, $tar_user_query) or die(mysqli_error($connection));
$tar_user_fetch = mysqli_fetch_array($tar_user_result);
?>