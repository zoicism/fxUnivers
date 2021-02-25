<?php
if(isset($_POST['classId'])) {
    $class_id = $_POST['classId'];
    require_once($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');

    $kill_query = "UPDATE class SET alive=0 WHERE id=$class_id";
    $kill_result = mysqli_query($connection, $kill_query);

    if($kill_result) {
	echo 1;
    } else {
	echo 0;
    }
}

?>
