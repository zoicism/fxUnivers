<?php

$tar_id_query = "SELECT * FROM user WHERE username='$tarname'";
$tar_id_result = mysqli_query($connection, $tar_id_query) or die(mysqli_error($connection));
$tar_id_fetch = mysqli_fetch_array($tar_id_result);
$tar_id = $tar_id_fetch['id'];

$tar_fname = $tar_id_fetch['fname'];
$tar_lname = $tar_id_fetch['lname'];
$tar_body = $tar_id_fetch['body'];
$tar_bio = $tar_id_fetch['bio'];

$sonet_query = "SELECT * FROM sonet WHERE uid=$tar_id ORDER BY id DESC";
$sonet_result = mysqli_query($connection, $sonet_query) or die(mysqli_error($connection));

?>