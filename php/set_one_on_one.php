<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

if(isset($_POST['instructorId'])) {
    $instructor_id = $_POST['instructorId'];
    $add_or_remove = $_POST['addOrRemove'];

    if($add_or_remove) {
	$oneonone_q = "INSERT INTO one_on_one(instructor_id) VALUES($instructor_id)";
	$oneonone_r = mysqli_query($fxinstructor_connection, $oneonone_q);

	if($oneonone_r) {
	    echo 1;
	} else {
	    echo 0;
	}
    } else {
	$oneonone_q = "DELETE FROM one_on_one WHERE instructor_id = $instructor_id";
	$oneonone_r = mysqli_query($fxinstructor_connection, $oneonone_q);

	if($oneonone_r) {
	    echo 1;
	} else {
	    echo 0;
	}
    }
}

?>
