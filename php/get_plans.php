<?php

$get_plans_query = "SELECT * FROM plans WHERE id=$get_user_id";
$get_plans_result = mysqli_query($connection, $get_plans_query) or die(mysqli_error($connection));
$get_plans_fetch = mysqli_fetch_array($get_plans_result);


if(mysqli_num_rows($get_plans_result) > 0) {

  $plans_msg = 1;

  if($get_plans_fetch['fxuniversityins']) {
    $get_plans_fxuniversityins = 1;
  } else {
    $get_plans_fxuniversityins = 0;
  }

  if($get_plans_fetch['fxuniversityins_req']) {
    $get_plans_fxuniversityins_req = 1;
  } else {
    $get_plans_fxuniversityins_req = 0;
  }

  if($get_plans_fetch['fxuniversitystu']) {
    $get_plans_fxuniversitystu = 1;
  } else {
    $get_plans_fxuniversitystu = 0;
  }

  if($get_plans_fetch['fxuniversitystu_req']) {
    $get_plans_fxuniversitystu_req = 1;
  } else {
    $get_plans_fxuniversitystu_req = 0;
  }

  if($get_plans_fetch['fxuniverse']) {
    $get_plans_fxuniverse = 1;
  } else {
    $get_plans_fxuniverse = 0;
  }

  if($get_plans_fetch['fxuniverse_req']) {
    $get_plans_fxuniverse_req = 1;
  } else {
    $get_plans_fxuniverse_req = 0;
  }

  if($get_plans_fetch['fxpartner']) {
    $get_plans_fxpartner = 1;
  } else {
    $get_plans_fxpartner = 0;
  }

  if($get_plans_fetch['fxpartner_req']) {
    $get_plans_fxpartner_req = 1;
  } else {
    $get_plans_fxpartner_req = 0;
  }

} else {
  $plans_msg = 0;
}

?>