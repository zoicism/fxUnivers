<?php

$stucourse_query = "SELECT * FROM stucourse WHERE (course_id=$course_id AND stu_id=$get_user_id)";
$stucourse_result = mysqli_query($connection, $stucourse_query) or die(mysqli_error($connection));
$stucourse_fetch = mysqli_fetch_array($stucourse_result);

?>