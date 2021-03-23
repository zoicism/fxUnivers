<?php
require('../register/connect.php');
if(isset($_POST['class_id'])) $classId=$_POST['class_id'];
require('get_class_chat.php');
// there must be a problem with this require shit! just figure it fucking out!

if($getclasschat_count>0) {
    while($chatrow=$getclasschat_r->fetch_assoc()) {
        $get_username_q="SELECT username FROM user WHERE id=".$chatrow['userId'];
        $get_username_r=mysqli_query($connection,$get_username_q) or die(mysqli_error($connection));
        $fetch_username=mysqli_fetch_array($get_username_r);
        $chat_username=$fetch_username['username'];
        echo '<div class="one-msg">';
        echo '<p class="id-time-con"><span>'.$chat_username.'</span> '.$chatrow['dt'].'</p>';
        echo '<p>'.$chatrow["txt"].'</p>';
        echo '</div>';
    }
} else {
    echo '<p style="color:gray">Empty</p>';
}
?>
