<?php
require('../wallet/php/wallet_connect.php');

if(isset($_POST['courseId'])) {
  $courseId=$_POST['courseId'];
} else {
  exit();
}

$bid_exists_q="SELECT * FROM locked WHERE course_id=$courseId";
$bid_exists_r=mysqli_query($wallet_connection,$bid_exists_q);
$bid_exists=mysqli_num_rows($bid_exists_r);

if($bid_exists>0) {
  $bid_fetch = mysqli_fetch_array($bid_exists_r);
  $bid_amount = $bid_fetch['amount'];
  $bid_raw_amount = $bid_fetch['raw_amount'];
  $last_bid_owner = $bid_fetch['from_id'];

  
  echo $bid_raw_amount;
} else {
  echo 'no_offer';
}

?>