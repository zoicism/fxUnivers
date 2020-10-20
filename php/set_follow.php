<?php

require('../register/connect.php');

if(isset($_POST['requester'])) $requester=$_POST['requester'];
if(isset($_POST['requestee'])) $requestee=$_POST['requestee'];
if(isset($_POST['requesterU'])) $requesterUn=$_POST['requesterU'];

$check_follow_q="SELECT * FROM following WHERE id1=$requester AND id2=$requestee";
$check_follow_r=mysqli_query($connection,$check_follow_q) or die(mysqli_error($connection));
$check_follow_count=mysqli_num_rows($check_follow_r);

if($check_follow_count==0) {
    // requester is not following and wants to follow
    $set_follow_q="INSERT INTO following(id1,id2) VALUES($requester,$requestee)";
    $set_follow_r=mysqli_query($connection,$set_follow_q) or die(mysqli_error($connection));

    // notif requestee of the following
    $follow_notif_q="INSERT INTO notif(user_id,body,from_id,reason) VALUES($requestee,'<a href=\"/user/$requesterUn\">@$requesterUn</a> is now following you.',$requester,'following')";
    $follow_notif_r=mysqli_query($connection,$follow_notif_q);
} else {
    $del_follow_q="DELETE FROM following WHERE id1=$requester AND id2=$requestee";
    $del_follow_r=mysqli_query($connection,$del_follow_q) or die(mysqli_error($connection));
}

echo $check_follow_count;

?>