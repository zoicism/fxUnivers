<?php
require_once('../contact/message_connect.php');

if(isset($_POST['senderId'])) $sender_id = $_POST['senderId'];
if(isset($_POST['recId'])) $rec_id = $_POST['recId'];


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function formatBytes($size, $precision = 2) {
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');   

    return round(pow(1024, $base - floor($base)), $precision);
}

if(isset($_FILES['theFile'])) {
  $up_file = mysqli_real_escape_string($msg_connection,basename($_FILES['theFile']['name']));
  $file_ext = strtolower(pathinfo($up_file, PATHINFO_EXTENSION));
  $file_name = generateRandomString(20);
  $file_name_ext = $file_name . '.' . $file_ext;
  $path = '../msg/files/' . $file_name . '.' . $file_ext;  

  $sent_dt = date('Y-m-d H:i:s');

  $file_size = $_FILES['theFile']['size'];
  $file_size_mb = formatBytes($file_size,0);
  
  if(move_uploaded_file($_FILES['theFile']['tmp_name'], $path)) {


    $set_last_query = "UPDATE messenger SET last=0 WHERE ((user1id=$sender_id AND user2id=$rec_id) OR (user1id=$rec_id AND user2id=$sender_id)) AND last=1";
    $set_last_result = mysqli_query($msg_connection, $set_last_query) or die(mysqli_error($msg_connection));

    $file_msg_q = "INSERT INTO messenger(user1id,user2id,text,sent_dt,msg_type,file_enc,file_size) VALUES($sender_id, $rec_id, '$up_file', '$sent_dt', 'file', '$file_name_ext', $file_size_mb)";
    $file_msg_r = mysqli_query($msg_connection, $file_msg_q);

    if($file_msg_r) {

      echo '
        <div class="messages message-sent upload-container" onclick="window.location.href=\'dl_msg_file.php?filename='.urlencode($file_msg_ext).'\';">
            <div class="upload-sent">
               <img src="/images/background/file-sent.svg">
             </div>
             <div class="file-name">'.$up_file.'<div>'.$file_size_mb.' MB</div></div>
             <span class="time">'.date('H:i').'</span>
         </div>
       ';


    } else {
      echo 0;
    }
  } else {
    echo 0;
  }
  
}


?>