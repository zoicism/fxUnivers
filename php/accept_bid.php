<?php
require_once('../wallet/php/wallet_connect.php');
require_once('../register/connect.php');

if(isset($_POST['course_id'])) {
  $courseId=$_POST['course_id'];
  $course_q="SELECT * FROM teacher WHERE id=$courseId";
  $course_r=mysqli_query($connection,$course_q);
  $course_f=mysqli_fetch_array($course_r);
} else {
  exit();
}

// CHECK OFFERS
$biddings_q="SELECT * FROM locked WHERE course_id=$courseId";
$biddings_r=mysqli_query($wallet_connection,$biddings_q);
$biddings_count = mysqli_num_rows($biddings_r);

if($biddings_count>0) {

  // current dt
  //date_default_timezone_set('America/New_York');
  $trans_dt=date('Y-m-d H:i:s');

  $bidding = mysqli_fetch_array($biddings_r);
  $bid_amount = $bidding['amount'];
  $bid_raw_amount = $bidding['raw_amount'];
  $bid_from_id = $bidding['from_id'];
  $bid_to_id = $bidding['to_id'];
  $bid_fxunivers_id = 1;
  $bid_id=2;

  $to_fxstars = $bid_raw_amount;
  $fxunivers_fxstars = $bid_amount-$bid_raw_amount;


  //echo '>'.$to_fxstars.' >'.$fxunivers_fxstars;

  // MAKE TRANSFER FROM BID TO to_id AND fxUnivers
  
  $transfer_user_q = "UPDATE link SET userId=$bid_to_id WHERE userId=$bid_id LIMIT $to_fxstars";
  $transfer_user_r = mysqli_query($wallet_connection,$transfer_user_q);

  if($transfer_r) {
    $txn_user_q = "INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($bid_from_id, $bid_to_id, $to_fxstars, $trans_dt)";
    $txn_user_r = mysqli_query($wallet_connection, $txn_user_q);
  }

  $transfer_fxu_q = "UPDATE link SET userId=$bid_fxunivers_id WHERE userId=$bid_id LIMIT $fxunivers_fxstars";
  $transfer_fxu_r = mysqli_query($wallet_connection, $transfer_fxu_q);

  if($transfer_fxu_r) {
    $txn_fxu_q = "INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($bid_from_id, $bid_fxunivers_id, $fxunivers_fxstars, $trans_dt)";
    $txn_user_r = mysqli_query($wallet_connection, $txn_fxu_q);
  }


  // UPDATE locked
  $locked_update_q = "UPDATE locked SET finalized=1 WHERE course_id=$courseId";
  $locked_update_r = mysqli_query($wallet_connection, $locked_update_q);

  if($locked_update_r) {
    $purchase_course_query = "INSERT INTO stucourse(stu_id, course_id) VALUES($bid_from_id, $courseId)";
    $purchase_course_result = mysqli_query($connection, $purchase_course_query) or die(mysqli_error($connection));

$utc_timestamp = date('Y-m-d H:i:s');

    // NOTIF
    $notif_query = 'INSERT INTO notif(user_id, body, from_id, sent_dt) VALUES('.$bid_from_id.', "Your offer is accepted as the highest for the course <a id="badA" href=\'/userpgs/instructor/course_management/course.php?course_id='.$courseId.'\'>'.$course_f['header'].'</a>", '.$bid_to_id.', "'.$utc_timestamp.'")';
    $notif_result = mysqli_query($connection,$notif_query);
  }
    
  echo 'transferred';
} else {
  echo 'nooffer';
}
?>