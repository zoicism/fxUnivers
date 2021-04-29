<?php

require('conn/fxinstructor.php');

if(isset($_POST['msgBody'])) $msgtxt=$_POST['msgBody'];
if(isset($_POST['msgUserId'])) $msgUserId=$_POST['msgUserId'];
if(isset($_POST['msgClassId'])) $msgClassId=$_POST['msgClassId'];

$msgtxt=mysqli_real_escape_string($fxinstructor_connection,$msgtxt);
$dt=date('Y-m-d H:i:s');

$setclasschat_q="INSERT INTO chat_ooo(userId, classId, dt, txt) VALUES($msgUserId, $msgClassId,'$dt', '$msgtxt')";
$setclasschat_r=mysqli_query($fxinstructor_connection,$setclasschat_q) or die(mysqli_error($fxinstructor_connection));

//echo $setclasschat_r;

?>
