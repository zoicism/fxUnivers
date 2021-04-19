<?php

session_start();
require('wallet_connect.php');

if(isset($_POST['amnt'])) {
    $amnt = $_POST['amnt'];
    $requested = $_POST['requested'];
}

require('../../register/connect.php');
$username = $_SESSION['username'];
require('../../php/get_user.php');

$trans_dt = date("Y-m-d H:i:s");

/*** fxStars ***/
$fxunivers_id = 1;
$fxunivers_share = $amnt - $requested;
$user_share = $requested;
//$fxunivers_share = ceil($amnt * 0.1);
//$user_share = $amnt - $fxunivers_share;

$get_balance_q = "SELECT * FROM fxstars WHERE user_id = $get_user_id";
$get_balance_r = mysqli_query($wallet_connection, $get_balance_q);
$get_balance_f = mysqli_fetch_array($get_balance_r);
$get_balance = $get_balance_f['balance'];

$user_new_balance = $get_balance + $user_share;

$set_balance_q = "UPDATE fxstars SET balance = $user_new_balance WHERE user_id = $get_user_id; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($user_share, $fxunivers_id, $get_user_id, '$trans_dt'); INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($fxunivers_share, $get_user_id, $fxunivers_id, '$trans_dt');";

$set_balance_r = mysqli_multi_query($wallet_connection, $set_balance_q) or die(mysqli_error($wallet_connection));




/*
   $link_query = "UPDATE link SET userId=$get_user_id WHERE userId=0 LIMIT $amnt";
   $link_result = mysqli_query($wallet_connection, $link_query) or die(mysqli_error($wallet_connection));


   // current dt
   date_default_timezone_set('America/New_York');
   $trans_dt=date('Y-m-d H:i:s');

   // set transfer data
   $trans_from=1;
   $trans_to=$get_user_id;
   $trans_amnt=$amnt;
   $trans_query="INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($trans_from, $trans_to, $trans_amnt, '$trans_dt')";
   $trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));

   //header("Location: /wallet");
   //echo $link_query.' --- '.$trans_result;
 */


//$set_user_txn = "UPDATE
?>
