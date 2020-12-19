<?php
require('../contact/message_connect.php');

if(isset($_POST['msgBody'])) {
    $msgBody = $_POST['msgBody'];
    $msgBody=mysqli_real_escape_string($msg_connection,$msgBody);
}
if(isset($_POST['clientId'])) $clientId = $_POST['clientId'];
if(isset($_POST['guestId'])) $guestId = $_POST['guestId'];


$set_last_query = "UPDATE messenger SET last=0 WHERE ((user1id=$clientId AND user2id=$guestId) OR (user1id=$guestId AND user2id=$clientId)) AND last=1";
$set_last_result = mysqli_query($msg_connection, $set_last_query) or die(mysqli_error($msg_connection));

$utc_timestamp = date('Y-m-d H:i:s');

$set_msg_query = "INSERT INTO messenger(user1id, user2id, text, sent_dt) VALUES($clientId, $guestId, '$msgBody', '$utc_timestamp')";
$set_msg_result = mysqli_query($msg_connection, $set_msg_query) or die(mysqli_error($msg_connection));

if($set_msg_query) {
  echo '<div class="messages message-sent">
          <p>'.$msgBody.'</p>
	  <span class="time">'.date('H:i').'</span>
	  </div>';
}

?>