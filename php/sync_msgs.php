<?php

require_once('../contact/message_connect.php');

if(isset($_POST['user_id'])) $get_user_id=$_POST['user_id'];
if(isset($_POST['guest_id'])) $guest_id=$_POST['guest_id'];

function formatSize($bytes) {
	if($bytes >= 1073741824) {
		$bytes = number_format($bytes/1073741824, 2). ' GB';
	} elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

	return $bytes;
}


$sync_msgs_q = "SELECT * FROM messenger WHERE (user2id=$get_user_id AND user1id=$guest_id AND read_dt IS NULL)";
$sync_msgs_r = mysqli_query($msg_connection,$sync_msgs_q);
$sync_msgs_count = mysqli_num_rows($sync_msgs_r);

if($sync_msgs_count>0) {
  $readd_query="UPDATE messenger SET read_dt=UTC_TIMESTAMP() WHERE (user2id=$get_user_id AND user1id=$guest_id AND read_dt IS NULL)";
  $readd_result=mysqli_query($msg_connection,$readd_query) or die(mysqli_error($msg_connection));

  $sync_fetch = mysqli_fetch_array($sync_msgs_r);

  $sent_time = new DateTime($sync_fetch['sent_dt']);

  if($sync_fetch['msg_type']=='file') {

    echo '
        <div class="messages message-recieved upload-container" onclick="window.location.href=\'dl_msg_file.php?filename='.urlencode($sync_fetch['file_enc']).'\';">
                  	      <div class="upload-recieved">
                    	        <img src="/images/background/file-recieved.svg">
                  	      </div>
                  	      <div class="file-name">'.$sync_fetch['text'].'<div>'.$formatSize($sync_fetch['file_size']).'</div></div>
                  	      <span class="time">'.$sent_time->format('H:i').'</span>
                	    </div>
       ';

  } else {
  
    echo '<div class="messages message-recieved">
          <p>'.$sync_fetch['text'].'</p>
	  <span class="time">'.$sent_time->format('H:i').'</span>
	</div>';

  }
}
?>
