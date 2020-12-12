<?php
if(isset($_POST['userId'])) $userId=$_POST['userId'];
if(isset($_POST['del-username'])) $username=$_POST['del-username'];

/*
$path="../userpgs/avatars/";
if(file_exists($path.$userId.'.jpg')) {
    unlink($path.$userId.'.jpg');
} elseif(file_exists($path.$userId.'.jpeg')) {
    unlink($path.$userId.'.jpeg');
} elseif(file_exists($path.$userId.'.png')) {
    unlink($path.$userId.'.png');
} elseif(file_exists($path.$userId.'.gif')) {
    unlink($path.$userId.'.gif');
}*/

$avatar_path=$_SERVER['DOCUMENT_ROOT'];
                    $avatar_path.='/userpgs/avatars/';
		    $avatar_ex = glob($avatar_path.$userId.'.*');
		    if(count($avatar_ex) > 0) {
		      $avatar_arr = explode('.', $avatar_ex[0]);
		      $avatar_extension = end($avatar_arr);
		      unlink($avatar_path.$userId.'.'.$avatar_extension);
		      
		      header('Location: /user/'.$username);
		    } else {
		      header('Location: /user/'.$username);
		     }
?>