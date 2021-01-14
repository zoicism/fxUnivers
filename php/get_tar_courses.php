<?php

$get_tar_courses_query = "SELECT * FROM teacher WHERE user_id=$tar_id AND alive=1";
$get_tar_courses_result = mysqli_query($connection, $get_tar_courses_query) or die(mysqli_error($connection));
$get_tar_courses_count = mysqli_num_rows($get_tar_courses_result);

?>