<?php

$get_tar_friends_q = "SELECT * FROM friend WHERE (user1=$tar_id OR user2=$tar_id)";
$get_tar_friends_r = mysqli_query($connection, $get_tar_friends_q);

$get_tar_friends_count = mysqli_num_rows($get_tar_friends_r);

/*
$get_rel_following_query = "SELECT * FROM following WHERE id1=$tar_id";
$get_rel_following_result = mysqli_query($connection, $get_rel_following_query) or die(mysqli_error($connection));

$get_rel_following_count = mysqli_num_rows($get_rel_following_result);

$get_rel_followers_query = "SELECT * FROM following WHERE id2=$tar_id";
$get_rel_followers_result = mysqli_query($connection, $get_rel_followers_query) or die(mysqli_error($connection));

$get_rel_followers_count = mysqli_num_rows($get_rel_followers_result);
*/
?>