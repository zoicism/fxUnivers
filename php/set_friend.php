<?php
require('../register/connect.php');

if(isset($_POST['requester'])) $requester=$_POST['requester'];
if(isset($_POST['requestee'])) $requestee=$_POST['requestee'];
if(isset($_POST['requesterU'])) $requesterUn=$_POST['requesterU'];

$friendship_query="SELECT * FROM friend WHERE (( user1=$requester AND user2=$requestee ) OR (user1=$requestee AND user2=$requester ))";
$friendship_result=mysqli_query($connection,$friendship_query) or die(mysqli_error($connection));
$friendship=mysqli_num_rows($friendship_result);
$friendship_fetch=mysqli_fetch_array($friendship_result);

if($friendship==0) {
    // there's no friendship record, so add one
    $set_fnd_q="INSERT INTO friend(user1,user2) VALUES($requester,$requestee)";
    $set_fnd_r=mysqli_query($connection,$set_fnd_q) or die(mysqli_error($connection));

    // update notif for requestee
    $utc_timestamp = date('Y-m-d H:i:s');
    
    $fnd_notif_q="INSERT INTO notif(user_id,body,from_id,reason,sent_dt) VALUES($requestee,'<a id=\"badA\" href=\"/user/$requesterUn\">@$requesterUn</a> has sent you a friend request.',$requester,'friendRequest','$utc_timestamp')";
    $fnd_notif_r=mysqli_query($connection,$fnd_notif_q) or die(mysqli_error($connection));
} else {
    // there's a friendship record, so delete it
    $del_fnd_q="DELETE FROM friend WHERE (( user1=$requester AND user2=$requestee ) OR (user1=$requestee AND user2=$requester ))";
    $del_fnd_r=mysqli_query($connection,$del_fnd_q);
    //echo 'friendDel';

    if($friendship_fetch['fnd']==0) {
        $del_request_q="DELETE FROM notif WHERE user_id=$requestee AND reason='friendRequest'";
        $del_request_r=mysqli_query($connection,$del_request_q) or die(mysqli_error($connection));
    }
}

echo $friendship;

?>
    