<?php

session_start();

$user1_query = "SELECT * FROM user WHERE username='$username'";
$user1_result = mysqli_query($connection, $user1_query) or die(mysqli_error($connection));
$user1_fetch = mysqli_fetch_array($user1_result);
$user1_id = $user1_fetch['id'];

$query = "SELECT bio FROM user WHERE username='$selected_user'";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
$bio = mysqli_fetch_array($result);
$bio_txt = $bio['bio'];

// fetch the first name of the user
$fname_query = "SELECT fname FROM user WHERE username='$selected_user'";
$fname_result = mysqli_query($connection, $fname_query) or die(mysqli_error($connection));
$fname_fetch = mysqli_fetch_array($fname_result);
$fname = $fname_fetch['fname'];

// fetch the last name of the user
$lname_query = "SELECT lname FROM user WHERE username='$selected_user'";
$lname_result = mysqli_query($connection, $lname_query) or die(mysqli_error($connection));
$lname_fetch = mysqli_fetch_array($lname_result);
$lname = $lname_fetch['lname'];

// FETCH USER2
$user2_query = "SELECT id FROM user WHERE username='$selected_user'";
$user2_result = mysqli_query($connection, $user2_query) or die(mysqli_error($connection));
$user2_fetch = mysqli_fetch_array($user2_result);
$user2_id = $user2_fetch['id'];

// FETCH PLANS OF USER2
$user2_plans_query = "SELECT * FROM plans WHERE id='$user2_id'";
$user2_plans_result = mysqli_query($connection, $user2_plans_query) or die(mysqli_error($connection));
$user2_plans_fetch = mysqli_fetch_array($user2_plans_result);
$user2_plans_fxuniversity = $user2_plans_fetch['fxuniversity'];


// FOLLOWING
$following_query = "SELECT * FROM following WHERE (id1=$user1_id AND id2=$user2_id)";
$following_result = mysqli_query($connection, $following_query);
$following_count = mysqli_num_rows($following_result);
$following_fetch = mysqli_fetch_array($following_result);

if(isset($_GET['following'])) {
	if($following_count > 0) {
	        $following_bi = 0;
		$follow_query = "DELETE FROM following WHERE (id1=$user1_id AND id2=$user2_id)";
		$follow_result = mysqli_query($connection, $follow_query) or die(mysqli_error($connection));
	} else {
                $following_bi = 1;        
                $follow_query = "INSERT INTO following(id1, id2) VALUES($user1_id, $user2_id)";
                $follow_result = mysqli_query($connection, $follow_query) or die(mysqli_error($connection));
	}
} else {
if($following_count > 0) {
	$following_bi = 1;
} else {
	$following_bi = 0;
}
}

// Fetch the sonet records for user2
require('sonet/profile_timeline.php');

?>