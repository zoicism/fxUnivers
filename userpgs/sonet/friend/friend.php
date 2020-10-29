<?php


// First step is to fetch the ids of the first and second users
// user 1 id
$user1id_query = "SELECT id FROM user WHERE username='$username'";
$user1id_result = mysqli_query($connection, $user1id_query) or die(mysqli_error($connection));
$user1id_fetch = mysqli_fetch_array($user1id_result);
$user1id = $user1id_fetch['id'];
// user 2 id
$user2id_query = "SELECT id FROM user WHERE username='$selected_user'";
$user2id_result = mysqli_query($connection, $user2id_query) or die(mysqli_error($connection));
$user2id_fetch = mysqli_fetch_array($user2id_result);
$user2id = $user2id_fetch['id'];

$friend_query = "SELECT * FROM friend WHERE ((user1=$user1id AND user2=$user2id) OR (user1=$user2id AND user2=$user1id))";
$friend_result = mysqli_query($connection, $friend_query) or die(mysqli_error($connection));
$friend_count = mysqli_num_rows($friend_result);
$friend_fetch = mysqli_fetch_array($friend_result);
$fnd = $friend_fetch['fnd'];

// If such a row exists, the users are already friends. Else, friendship is 0.
if($friend_count > 0) {
  $friendship = 1;
} else {
  $friendship = 0;
}
?>