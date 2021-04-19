<?php
session_start();
require('../../register/connect.php');
require('wallet_connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

if(isset($_POST['user_id'])) $get_user_id=$_POST['user_id'];
if(isset($_POST['amnt'])) $amnt=$_POST['amnt'];

require($_SERVER['DOCUMENT_ROOT'].'/wallet/php/get_fxcoin_count.php');

$dt=date('Y-m-d H:i:s');

if($get_fxcoin_count >= $amnt && $amnt >= 100) {
    $fxunivers_share = ceil(0.1*$amnt);
    $user_share = $amnt - $fxunivers_share;
    $user_new_balance = $get_fxcoin_count - $amnt;
    $fxunivers_id = 1;
    
    $cashout_q = "UPDATE fxstars SET balance = $user_new_balance WHERE user_id = $get_user_id; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($fxunivers_share, $get_user_id, $fxunivers_id, '$dt'); INSERT INTO cashout(userId, amnt, dt) VALUES($get_user_id, $user_share, '$dt');";
    $cashout_r = mysqli_multi_query($wallet_connection, $cashout_q);
    
    if($cashout_r) {
	echo 'success';
    } else {
	echo 'failed';
    }
    

    /*
    // fxUnivers interest share
    $fxunivers_q="UPDATE link SET userId=1 WHERE userId=$userId LIMIT $interest";
    $fxunivers_r=mysqli_query($wallet_connection,$fxunivers_q) or die(mysqli_error($wallet_connection));

    // Return the valid amount to the cycle of use
    $zero_q="UPDATE link SET userId=0 WHERE userId=$userId LIMIT $valid_amnt";
    $zero_r=mysqli_query($wallet_connection,$zero_q) or die(mysqli_error($wallet_connection));

    // Amount to be changed in USD
    $cashout_q="INSERT INTO cashout(userId,amnt,dt) VALUES($userId,$valid_amnt,'$dt')";
    $cashout_r=mysqli_query($wallet_connection,$cashout_q) or die(mysqli_error($wallet_connection));
     */
    
} else {
    echo 'insuff';
}


?>
