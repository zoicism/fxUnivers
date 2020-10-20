<?php

$get_tar_plans_query = "SELECT * FROM plans WHERE id=$tar_id";
$get_tar_plans_result = mysqli_query($connection, $get_tar_plans_query) or die(mysqli_error($connection));
$get_tar_plans_fetch = mysqli_fetch_array($get_tar_plans_result);


if(mysqli_num_rows($get_tar_plans_result) > 0) {

  $tar_plans_msg = 1;

  if($get_tar_plans_fetch['fxuniversityins']) {
    $get_tar_plans_fxuniversityins = 1;
  } else {
    $get_tar_plans_fxuniversityins = 0;
  }

  if($get_tar_plans_fetch['fxuniversityins_req']) {
    $get_tar_plans_fxuniversityins_req = 1;
  } else {
    $get_tar_plans_fxuniversityins_req = 0;
  }

  if($get_tar_plans_fetch['fxuniversitystu']) {
    $get_tar_plans_fxuniversitystu = 1;
  } else {
    $get_tar_plans_fxuniversitystu = 0;
  }

  if($get_tar_plans_fetch['fxuniversitystu_req']) {
    $get_tar_plans_fxuniversitystu_req = 1;
  } else {
    $get_tar_plans_fxuniversitystu_req = 0;
  }

  if($get_tar_plans_fetch['fxuniverse']) {
    $get_tar_plans_fxuniverse = 1;
  } else {
    $get_tar_plans_fxuniverse = 0;
  }

  if($get_tar_plans_fetch['fxuniverse_req']) {
    $get_tar_plans_fxuniverse_req = 1;
  } else {
    $get_tar_plans_fxuniverse_req = 0;
  }

  if($get_tar_plans_fetch['fxpartner']) {
    $get_tar_plans_fxpartner = 1;
  } else {
    $get_tar_plans_fxpartner = 0;
  }

  if($get_tar_plans_fetch['fxpartner_req']) {
    $get_tar_plans_fxpartner_req = 1;
  } else {
    $get_tar_plans_fxpartner_req = 0;
  }

} else {
  $tar_plans_msg = 0;
}

?>