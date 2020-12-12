<?php
session_start();

$get_user_query = "SELECT * FROM user WHERE username='$username'";
$get_user_result = mysqli_query($connection, $get_user_query) or die(mysqli_error($connection));
$get_user_fetch = mysqli_fetch_array($get_user_result);
$get_user_id = $get_user_fetch['id'];
$get_user_fname = $get_user_fetch['fname'];
$get_user_lname = $get_user_fetch['lname'];
$get_user_phone = $get_user_fetch['phone'];
$get_user_bio = $get_user_fetch['bio'];
$get_user_verified = $get_user_fetch['verified'];
$session_avatar = $get_user_fetch['avatar'];

?>