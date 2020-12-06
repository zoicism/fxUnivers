<?php
require_once('../wallet/php/wallet_connect.php');

$conf=0;

if(isset($_POST['amount'])) {
  $raw_amount=$_POST['amount'];
  $amount=$raw_amount+ceil($raw_amount*0.1);
  $fromId=$_POST['from_id'];
  $toId=$_POST['to_id'];
  $courseId=$_POST['course_id'];
  $initialBid=$_POST['initial_bid'];
}



// BUDGET CHECK

$user_balance_q="SELECT * FROM link WHERE userId=$fromId";
$user_balance_r=mysqli_query($wallet_connection,$user_balance_q);
$user_balance=mysqli_num_rows($user_balance_r);

if($user_balance<$amount) {
  echo 'insuff';
  exit();
}





// FIRST OR N-TH BID

$bid_exists_q="SELECT * FROM locked WHERE course_id=$courseId AND finalized=0";
$bid_exists_r=mysqli_query($wallet_connection,$bid_exists_q);
$bid_exists=mysqli_num_rows($bid_exists_r);
  
if($bid_exists) {
    $bid_fetch = mysqli_fetch_array($bid_exists_r);
    $bid_amount = $bid_fetch['amount'];
    $last_bid_owner = $bid_fetch['from_id'];



    // COMPARE WITH HIGHEST BID
    if($amount > $bid_amount) {
      //echo $last_bid_owner;
      
      // RETURN LAST BID TO OWNER
      $return_bid_q = "UPDATE link SET userId=$last_bid_owner WHERE userId=2 LIMIT $bid_amount";
      $return_bid_r = mysqli_query($wallet_connection, $return_bid_q);

      // ASSIGN NEW BID
      $new_bid_q = "UPDATE link SET userId=2 WHERE userId=$fromId LIMIT $amount";
      $new_bid_r = mysqli_query($wallet_connection, $new_bid_q);

      // UPDATE locked
      $new_locked_q = "UPDATE locked SET from_id=$fromId, amount=$amount, raw_amount=$raw_amount, dt=NOW() WHERE course_id=$courseId";
      $new_locked_r = mysqli_query($wallet_connection, $new_locked_q);

      echo 'assigned';
      
    } else {
      echo 'low';
    }




} else {

    // COMPARE WITH INITIAL
    if($amount > $initialBid) {

      // ADD FIRST BID TO locked
      $add_first_bid_q = "INSERT INTO locked(from_id, to_id, amount, raw_amount, course_id) VALUES($fromId, $toId, $amount, $raw_amount, $courseId)";
      $add_first_bid_r = mysqli_query($wallet_connection,$add_first_bid_q);
      
      // ASSIGN FIRST BID
      $first_bid_q = "UPDATE link SET userId=2 WHERE userId=$fromId LIMIT $amount";
      $first_bid_r = mysqli_query($wallet_connection,$first_bid_q);

      echo 'initassigned';
    } else {
      echo 'initlow';
    }
    
}


?>