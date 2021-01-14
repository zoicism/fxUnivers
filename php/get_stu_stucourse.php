<?php

$gss_query="SELECT * FROM stucourse WHERE stu_id=$get_user_id ORDER BY id DESC";
$gss_result=mysqli_query($connection,$gss_query);
$gss_count=mysqli_num_rows($gss_result);

?>