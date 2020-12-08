<?php
require_once('../wallet/php/wallet_connect.php');

if(isset($_POST['course_id'])) {
  $courseId=$_POST['course_id'];
} else {
  exit();
}

// CHECK OFFERS
$biddings_q="SELECT * FROM locked WHERE course_id=$courseId";
$biddings_r=mysqli_query($wallet_connection,$biddings_q);
$biddings_count = mysqli_num_rows($biddings_r);

if($biddings_count>0) {

  // current dt
  date_default_timezone_set('America/New_York');
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


  echo 'transferred';
} else {
  echo 'nooffer';
}
?>