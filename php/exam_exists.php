<?php
require_once('../register/connect.php');
require_once('conn/fxinstructor.php');

if(isset($_POST['courseId'])) {
    $courseId = $_POST['courseId'];

    $exists_q = "SELECT * FROM teacher WHERE id=$courseId";
    $exists_r = mysqli_query($connection,$exists_q);
    $exists_f = mysqli_fetch_array($exists_r);
    $exists = $exists_f['test_num'];

    $q_num=0;
    if($exists) {
        $q_num_q = "SELECT * FROM question WHERE course_id=$courseId";
        $q_num_r = mysqli_query($fxinstructor_connection,$q_num_q);
    	$q_num = mysqli_num_rows($q_num_r);
    }

    $arr = array();
    $arr[0] = $exists;
    $arr[1] = $q_num;

    echo json_encode($arr);
}
?>