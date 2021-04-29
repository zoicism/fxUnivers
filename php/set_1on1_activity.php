<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
if(isset($_POST['oooid'])) {
    $oooid = $_POST['oooid'];
    $activity = $_POST['activity'];

    $set_activity_q = "UPDATE stu_oneonone SET active = $activity WHERE id = $oooid";
    $set_activity_r = mysqli_query($fxinstructor_connection, $set_activity_q);

    if($set_activity_r) echo 1; else echo 0;
}
?>
