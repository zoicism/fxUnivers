<?php
//session_start();
require('../register/connect.php');

if(isset($_POST['notifId'])) $notif_id=$_POST['notifId'];

// get requester and requestee
$requester_id_q="SELECT * FROM notif WHERE id=$notif_id";
$requester_id_r=mysqli_query($connection,$requester_id_q) or die(mysqli_error($connection));
$requester_id_fetch=mysqli_fetch_array($requester_id_r);
$requester_id=$requester_id_fetch['from_id'];
$requestee_id=$requester_id_fetch['user_id'];

// decline friendship
$acceptFnd_q="DELETE FROM friend WHERE (user1=$requester_id AND user2=$requestee_id)";
$acceptFnd_r=mysqli_query($connection,$acceptFnd_q) or die(mysqli_error($connection));


// remove the notif
//$remove_fnd_notif_q="DELETE FROM notif WHERE id=$notif_id";
//$remove_fnd_notif_r=mysqli_query($connection,$remove_fnd_notif_q) or die(mysqli_error($connection));


// get requester's username
$requester_un_q="SELECT * FROM user WHERE id=$requester_id";
$requester_un_r=mysqli_query($connection,$requester_un_q) or die(mysqli_error($connection));
$requester_un_fetch=mysqli_fetch_array($requester_un_r);
$requester_un=$requester_un_fetch['username'];

// update notif
$update_dec_notif_body="You declined the friend request of <a href=\"/user/$requester_un\">@$requester_un.";
$update_dec_notif_q="UPDATE notif SET body='$update_dec_notif_body', active=0, reason=NULL WHERE id=$notif_id";
$update_dec_notif_r=mysqli_query($connection,$update_dec_notif_q) or die(mysqli_error($connection));

if($acceptFnd_r) {
  echo 1;
} else {
  echo 0;
}
?>