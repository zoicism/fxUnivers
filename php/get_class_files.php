<?php

require('conn/fxinstructor.php');

$gcf_query="SELECT * FROM class_files WHERE (instId=$get_course_teacher_id AND classId=$class_id)";
$gcf_result=mysqli_query($fxinstructor_connection,$gcf_query) or die(mysqli_error($fxinstructor_connection));
$gcf_count=mysqli_num_rows($gcf_result);
?>