<?php
$gts_query="SELECT * FROM stucourse WHERE stu_id=$get_user_id";
$gts_result=mysqli_query($connection,$gts_query) or die(mysqli_error($connection));
$gts_count=mysqli_num_rows($gts_result);

$gts_pass_query="SELECT * FROM stucourse WHERE stu_id=$get_user_id AND exam_accepted=1";
$gts_pass_result=mysqli_query($connection,$gts_pass_query) or die(mysqli_error($connection));
$gts_pass_count=mysqli_num_rows($gts_pass_result);
?>