<?php

require('conn/fxinstructor.php');

$tar_id_query = "SELECT * FROM user WHERE username='$tarname'";
$tar_id_result = mysqli_query($connection, $tar_id_query) or die(mysqli_error($connection));
$tar_id_fetch = mysqli_fetch_array($tar_id_result);
$tar_id = $tar_id_fetch['id'];

$get_fxins_prof_query = "SELECT * FROM profile WHERE userId=$tar_id";
$get_fxins_prof_result = mysqli_query($fxinstructor_connection, $get_fxins_prof_query) or die(mysqli_error($fxinstructor_connection));
$get_fxins_prof_fetch = mysqli_fetch_array($get_fxins_prof_result);

$get_fxins_prof_info = $get_fxins_prof_fetch['info'];
$get_fxins_prof_edu = $get_fxins_prof_fetch['edu'];
$get_fxins_prof_emp = $get_fxins_prof_fetch['employment'];
$get_fxins_prof_ref = $get_fxins_prof_fetch['ref'];

?>