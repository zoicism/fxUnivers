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



// pull the raw binary data from the POST array
$data = substr($_POST['data'], strpos($_POST['data'], ",") + 1);
$msgUserId = 144; //$_POST['msgUserId'];
$msgClassId = 159; //$_POST['msgClassId'];
$msgtxt = 'fxuniversityaudio'.generateRandomString();

// decode it
$decodedData = base64_decode($data);
// print out the raw data, 
//echo ($decodedData);
$filename = 'audio/'.$msgtxt.'.mp3';
// write the data out to the file
$fp = fopen($filename, 'wb');
fwrite($fp, $decodedData);
fclose($fp);

$msgtxt=mysqli_real_escape_string($fxinstructor_connection,$msgtxt);
$dt=date('Y-m-d H:i:s');

$setclasschat_q="INSERT INTO chat(userId, classId, dt, txt) VALUES($msgUserId, $msgClassId,'$dt', '$msgtxt')";
$setclasschat_r=mysqli_query($fxinstructor_connection,$setclasschat_q) or die(mysqli_error($fxinstructor_connection));
?>
