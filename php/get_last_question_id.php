<?php

$glqid_query="SELECT question_id FROM exam WHERE course_id=$course_id ORDER BY id DESC LIMIT 1";
$glqid_result=mysqli_query($connection,$glqid_query) or die(mysqli_error($connection));
$glqid_fetch=mysqli_fetch_array($glqid_result);
$last_question_id=$glqid_fetch['question_id'];

?>