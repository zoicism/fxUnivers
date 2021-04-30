<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');

if(isset($_POST['course_id']) && isset($_POST['negotiable'])) {
    $course_id = $_POST['course_id'];
    $negotiable = $_POST['negotiable'];

    $set_negotiable_q = "UPDATE teacher SET negotiable = $negotiable WHERE id = $course_id";
    $set_negotiable_r = mysqli_query($connection, $set_negotiable_q);

    if($set_negotiable_r) {
	echo 1;
    } else {
	echo 0;
    }
} else {
    echo 'failed';
}
?>
