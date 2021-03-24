<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$input = $_FILES['audio_data']['tmp_name'];
$filetxt = 'fxuniversityaudio'.generateRandomString();
$output = 'audio/'.$filetxt.'.mp3';

if(move_uploaded_file($input, $output)) {

    $msgUserId = $_POST['msgUserId'];
    $msgClassId = $_POST['msgClassId'];

    $dt=date('Y-m-d H:i:s');

    $setclasschat_q="INSERT INTO chat(userId, classId, dt, txt) VALUES($msgUserId, $msgClassId,'$dt', '$filetxt')";
    $setclasschat_r=mysqli_query($fxinstructor_connection,$setclasschat_q) or die(mysqli_error($fxinstructor_connection));

    if($setclasschat_r) {
	echo 1;
    } else {
	echo 0;
    }
} else {
    echo 0;
}
?>
