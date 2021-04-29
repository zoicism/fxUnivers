<?php
require_once('../register/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
if(isset($_POST['class_id'])) $classId=$_POST['class_id'];
//require_once('get_class_chat.php');

$oldNum = $_POST['numOfMsgs'];

$getclasschat_q="SELECT * FROM chat_ooo WHERE classId = $classId ORDER BY id DESC";
$getclasschat_r=mysqli_query($fxinstructor_connection,$getclasschat_q) or die(mysqli_error($fxinstructor_connection));
$getclasschat_count=mysqli_num_rows($getclasschat_r);

//echo '>> old: '.$oldNum.' >> new: '.$getclasschat_count;

if($getclasschat_count>0) {
    $theDiv='';
    $counter = 0;
    $newOnes = $getclasschat_count - $oldNum;
    
    while($chatrow=$getclasschat_r->fetch_assoc()) {
        $get_username_q="SELECT username FROM user WHERE id=".$chatrow['userId'];
        $get_username_r=mysqli_query($connection,$get_username_q) or die(mysqli_error($connection));
        $fetch_username=mysqli_fetch_array($get_username_r);
        $chat_username=$fetch_username['username'];

	
	if($newOnes > 0) {
	    $counter++;
	    if($newOnes < $counter) break;
	    if(substr($chatrow['txt'],0,17) == 'fxuniversityaudio') {
		$theDiv .= '<div class="one-msg">
                            <p class="id-time-con"><span>'.$chat_username.'</span> '.$chatrow['dt'].'</p>
	                    <p><audio controls src="audio/'.$chatrow["txt"].'.mp3"></audio></p>
	                   </div>';
	    } else {
		$theDiv .= '<div class="one-msg">
                            <p class="id-time-con"><span>'.$chat_username.'</span> '.$chatrow['dt'].'</p>
	                    <p>'.$chatrow["txt"].'</p>
	                   </div>';
	    }
	}
    }
    echo $theDiv;
    //echo $getclasschat_count;
} else {
    echo 'empty';
}
?>
