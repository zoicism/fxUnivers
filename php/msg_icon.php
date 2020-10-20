<?php
require('../contact/message_connect.php');
if(isset($_POST['msg_userId'])) $msg_user_id=$_POST['msg_userId'];
$msg_icon_query="SELECT * FROM messenger WHERE (user2id=$msg_user_id AND readd=0)";
$msg_icon_result=mysqli_query($msg_connection,$msg_icon_query) or die(mysqli_error($msg_connection));
$msg_icon_count=mysqli_num_rows($msg_icon_result);
echo $msg_icon_count;
?>