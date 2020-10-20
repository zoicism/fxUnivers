<?php

session_start();
require('../register/connect.php');

if(isset($_POST['username'])) $username=$_POST['username'];
require('get_user.php');
//echo $username.'<br>';
/*
function compress($source, $destination, $quality) {
    
    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}
*/
function resize_image($file, $w, $h, $crop=FALSE) {
    $info=getimagesize($file);
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    if ($info['mime'] == 'image/jpeg') $src = imagecreatefromjpeg($file);
    elseif ($info['mime'] == 'image/gif') $src = imagecreatefromgif($file);
    elseif ($info['mime'] == 'image/png') $src = imagecreatefrompng($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    imagejpeg($dst,$file);
    
    return $dst;
}

if(isset($_FILES['avatar_img'])) {
    //echo '[OK]  $_FILES isset<br>';
    $uploadOK=1;
    $success=0;
    $path="../userpgs/avatars/";
    $upfile=$path . basename($_FILES['avatar_img']['name']);
    $file_type=strtolower(pathinfo($upfile,PATHINFO_EXTENSION));

    $upfile=$path . $get_user_id . '.' . $file_type;


    // remove any file with the same name and different extension
    if(file_exists($path.$get_user_id.'.jpg')) {
        unlink($path.$get_user_id.'.jpg');
    } elseif(file_exists($path.$get_user_id.'.jpeg')) {
        unlink($path.$get_user_id.'.jpeg');
    } elseif(file_exists($path.$get_user_id.'.png')) {
        unlink($path.$get_user_id.'.png');
    } elseif(file_exists($path.$get_user_id.'.gif')) {
        unlink($path.$get_user_id.'.gif');
    }

    
    // limit file size
    if($_FILES['avatar_img']['size'] > 50000000) {
        $uploadOK=0;
        //echo '[ERR] File size exceeds 50MB<br>';
    }

    // limit file type
    if($file_type!='jpg' && $file_type!='jpeg' && $file_type!='png' && $file_type!='gif') {
        $uploadOK=0;
        //echo '[ERR] file type is invalid<br>';
    }
    
    if($uploadOK) {
        //echo '[OK] $uploadOK<br>';
        if(move_uploaded_file($_FILES['avatar_img']['tmp_name'], $upfile)) {
            //echo '[OK]  move_uploaded_file<br>';
            //$d=compress($upfile,$upfile,30);
            $dst=resize_image($upfile,300,300);
            $success=1;
        } else {
            //echo '[ERR] move_uploaded_file<br>';
            //print_r($_FILES);
        }
    } else {
        //echo '[ERR] $uploadOK<br>';
    }
} else {
    //echo '[OK]  $_FILES isset<br>';
}

if($success) {
    header('Location: /user/'.$username);
} else {
    header('Location: /user/'.$username);
}
?>