<?php


if(isset($_POST['userId'])) $userId=$_POST['userId'];

$path="../userpgs/avatars/";
if(file_exists($path.$userId.'.jpg')) {
    unlink($path.$userId.'.jpg');
} elseif(file_exists($path.$userId.'.jpeg')) {
    unlink($path.$userId.'.jpeg');
} elseif(file_exists($path.$userId.'.png')) {
    unlink($path.$userId.'.png');
} elseif(file_exists($path.$userId.'.gif')) {
    unlink($path.$userId.'.gif');
}

header('Location: /userpgs');
?>