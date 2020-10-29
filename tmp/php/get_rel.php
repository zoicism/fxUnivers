<?php

$get_rel_friends_query = "SELECT * FROM friend WHERE (user1=$get_user_id OR user2=$get_user_id)";
$get_rel_friends_result = mysqli_query($connection, $get_rel_friends_query) or die(mysqli_error($connection));
$get_rel_friends_result2 = mysqli_query($connection, $get_rel_friends_query) or die(mysqli_error($connection));

$get_rel_friends_count = mysqli_num_rows($get_rel_friends_result);

$get_rel_following_query = "SELECT * FROM following WHERE id1=$get_user_id";
$get_rel_following_result = mysqli_query($connection, $get_rel_following_query) or die(mysqli_error($connection));

$get_rel_following_count = mysqli_num_rows($get_rel_following_result);

$get_rel_followers_query = "SELECT * FROM following WHERE id2=$get_user_id";
$get_rel_followers_result = mysqli_query($connection, $get_rel_followers_query) or die(mysqli_error($connection));

$get_rel_followers_count = mysqli_num_rows($get_rel_followers_result);

?>