<?php
require_once('../contact/message_connect.php');
if(isset($_POST['msg_userId'])) $msg_user_id=$_POST['msg_userId'];
$msg_icon_query="SELECT * FROM messenger WHERE (user2id=$msg_user_id AND readd=0) ORDER BY id DESC";
$msg_icon_result=mysqli_query($msg_connection,$msg_icon_query) or die(mysqli_error($msg_connection));
$msg_icon_count=mysqli_num_rows($msg_icon_result);
$msg_fetch = mysqli_fetch_array($msg_icon_result);

if($msg_icon_count>0) {
  $sender_id = $msg_fetch['user1id'];

  require_once('../register/connect.php');
  $msg_from_q = "SELECT * FROM user WHERE id=$sender_id"; 
  $msg_from_r = mysqli_query($connection,$msg_from_q);
  $msg_from = mysqli_fetch_array($msg_from_r);

  $time_diff = time() - strtotime($msg_fetch['sent_dt']);

  $msg_arr = array();
  $msg_arr[0] = $msg_icon_count;
  $msg_arr[1] = $msg_fetch['text'];
  $msg_arr[2] = $msg_from['username'];
  $msg_arr[3] = $time_diff;
  $msg_arr[4] = $msg_fetch['msg_type'];
  
  echo json_encode($msg_arr);
  exit();
}
?>