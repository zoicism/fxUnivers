<?php
//session_start();
require('../register/connect.php');

if(isset($_POST['notifId'])) $notif_id=$_POST['notifId'];
if(isset($_POST['requesteeUN'])) $requestee=$_POST['requesteeUN'];

// get requester
$requester_id_q="SELECT * FROM notif WHERE id=$notif_id";
$requester_id_r=mysqli_query($connection,$requester_id_q) or die(mysqli_error($connection));
$requester_id_fetch=mysqli_fetch_array($requester_id_r);
$requester_id=$requester_id_fetch['from_id'];
$requestee_id=$requester_id_fetch['user_id'];
//echo $requestee_id;

// create friendship
$acceptFnd_q="UPDATE friend SET fnd=1 WHERE (user1=$requester_id AND user2=$requestee_id)";
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
$update_fnd_notif_body="You accepted the friend request of <a href=\"/user/$requester_un\">@$requester_un</a>.";
$update_fnd_notif_q="UPDATE notif SET body='$update_fnd_notif_body', active=0, reason=NULL WHERE id=$notif_id";
$update_fnd_notif_r=mysqli_query($connection,$update_fnd_notif_q) or die(mysqli_error($connection));

// send requestee a notif of acceptance
$requestee_n_body="<a href=\"/user/$requestee\">@$requestee</a> accepted your friend request";
$requestee_notif_q="INSERT INTO notif(user_id,body,from_id) VALUES($requester_id,'$requestee_n_body',$requestee_id)";
$requestee_notif_r=mysqli_query($connection,$requestee_notif_q) or die(mysqli_error($connection));

if($acceptFnd_r) {
  echo 1;
} else {
  echo 0;
}
?>