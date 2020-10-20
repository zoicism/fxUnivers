<?php
require('../register/connect.php');
if(isset($_POST['notif_userId'])) $user_id=$_POST['notif_userId'];
$notif_icon_query="SELECT * FROM notif WHERE (user_id=$user_id AND active=1)";
$notif_icon_result=mysqli_query($connection,$notif_icon_query) or die(mysqli_error($connection));
$notif_count=mysqli_num_rows($notif_icon_result);
echo $notif_count;
?>