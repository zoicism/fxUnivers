<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');
if(isset($_POST['courseId']) && isset($_POST['privacy'])) {
    $course_id = $_POST['courseId'];
    $privacy = $_POST['privacy'];

    if($privacy == 1) {
	$new_privacy = 0;
    } else {
	$new_privacy = 1;
    }

    $set_privacy_q = "UPDATE teacher SET private = $new_privacy WHERE id = $course_id";
    $set_privacy_r = mysqli_query($connection, $set_privacy_q);

    if($set_privacy_r) {
	echo 1;
    } else {
	echo 0;
    }
} else {
    echo 'err';
}
?>
