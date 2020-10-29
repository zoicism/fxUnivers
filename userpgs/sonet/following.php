<?php

session_start();
//require('../register/connect.php');
/*
if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
}
*/
$user1_query = "SELECT * FROM user WHERE username='$username'";
$user1_result = mysqli_query($connection, $user1_query) or die(mysqli_error($connection));
$user1_fetch = mysqli_fetch_array($user1_result);
$user1_id = $user1_fetch['id'];

$following_query = "SELECT * FROM following WHERE id1=$user1_id";
$following_result = mysqli_query($connection, $following_query);
$following_count = mysqli_num_rows($following_result);
if($following_count>0) {
  $following_fetch = mysqli_fetch_array($following_result);
  $first_following = $following_fetch["id2"];

  $posts_query = "SELECT * FROM sonet WHERE ( uid=$user1_id OR uid=$first_following";

  if($following_result->num_rows > 0) {
	while($row = $following_result->fetch_assoc()) {
        //$this.
		$posts_query = $posts_query . ' OR uid='.$row["id2"];
	}
  }

  $posts_query = $posts_query . ") ORDER BY id DESC;";

  $sonet_query = $posts_query;
  $sonet_result = mysqli_query($connection, $sonet_query);
  $sonet_count = mysqli_num_rows($sonet_result);
  $sonet_fetch = mysqli_fetch_array($sonet_result);
  $sonet_body = $sonet_fetch['body'];
  $sonet_uid = $sonet_fetch['uid'];
  $sonet_postId=$sonet_fetch['id'];
} else {
  $sonet_query = "SELECT * FROM sonet WHERE uid=$user1_id ORDER BY id DESC";
  $sonet_result = mysqli_query($connection, $sonet_query);// or die(mysqli_error($connection));
  $sonet_fetch = mysqli_fetch_array($sonet_result);
  $sonet_body = $sonet_fetch['body'];
  $sonet_uid = $sonet_fetch['uid'];
  $sonet_postId=$sonet_fetch['id'];
}


?>