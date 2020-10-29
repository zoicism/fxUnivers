<?php

$get_exam_acc_query="SELECT * FROM stucourse WHERE (stu_id=$get_user_id AND course_id=$course_id)";
$get_exam_acc_result = mysqli_query($connection, $get_exam_acc_query) or die(mysqli_error($connection));
$get_exam_acc_fetch = mysqli_fetch_array($get_exam_acc_result);

?>