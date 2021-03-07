<?php
require('../register/connect.php');
if(isset($_POST['notif_userId'])) $user_id=$_POST['notif_userId'];
$notif_icon_query="SELECT * FROM notif WHERE (user_id=$user_id AND active=1) ORDER BY id DESC";
$notif_icon_result=mysqli_query($connection,$notif_icon_query) or die(mysqli_error($connection));
$notif_count=mysqli_num_rows($notif_icon_result);
$notif_fetch = mysqli_fetch_array($notif_icon_result);

if($notif_count>0) {
    
    $from_id=$notif_fetch['from_id'];

    require_once('../register/connect.php');
    $notif_from_q = "SELECT * FROM user WHERE id=$from_id";
    $notif_from_r = mysqli_query($connection,$notif_from_q);
    $notif_from = mysqli_fetch_array($notif_from_r);

    $time_diff = time() - strtotime($notif_fetch['sent_dt']);

    $notif_arr = array();
    $notif_arr[0] = $notif_count;
    $notif_arr[1] = $notif_from['username'];
    $notif_arr[2] = $notif_fetch['body'];
    $notif_arr[3] = $time_diff;
    $notif_arr[4] = $notif_fetch['reason'];
    

    echo json_encode($notif_arr);
    exit();
}
?>
