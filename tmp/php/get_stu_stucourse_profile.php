<?php

$gss_query="SELECT * FROM stucourse WHERE stu_id=$tarid ORDER BY id DESC";
$gss_result=mysqli_query($connection,$gss_query) or die(mysqli_error($connection));
//$gss_fetch=mysqli_fetch_array($gss_result);
$gss_count=mysqli_num_rows($gss_result);
/*
$first_gss_header=$gss_fetch['header'];
$first_gss_desc=$gss_fetch['description'];
$first_gss_courseId=$gss_fetch['course_id'];
*/

?>