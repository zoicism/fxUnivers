<?php
//if(isset($_POST['notifUserId'])) $id=$_POST['notifUserId'];
$notif_query = "SELECT * FROM notif WHERE user_id=$id ORDER BY id DESC";
$notif_result = mysqli_query($connection, $notif_query) or die(mysqli_error($connection));

$notif_count = mysqli_num_rows($notif_result);
/*$notif_fetch = mysqli_fetch_array($notif_result);
$first_notif_reason = $notif_fetch['reason'];
$first_notif_body = $notif_fetch['body'];
$first_notif_id = $notif_fetch['id'];
$first_notif_active = $notif_fetch['active'];
*/
//$response=array('last_notif'=>$first_notif_active);
//echo json_encode($response);
?>