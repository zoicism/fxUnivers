<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}
require('../../php/get_user.php');
require('wallet_connect.php');
require('get_fxcoin_count.php');

if(isset($_POST['sendTo'])) $receiver=$_POST['sendTo'];
if(isset($_POST['sendAmnt'])) $sendAmnt=$_POST['sendAmnt'];

$tarname=$receiver;
require('../../php/get_tar_user.php');

// current dt
//date_default_timezone_set('America/New_York');
$trans_dt=date('Y-m-d H:i:s');

//function to determine the interest; I=ceil(0.1*m)
$interest=ceil(0.1*$sendAmnt);

// if user has [m+I] fxCoins condition
if($get_fxcoin_count>$sendAmnt+$interest) {

    $fxunivers_id = 1;

    $receiver_old_balance_q = "SELECT * FROM fxstars WHERE user_id = $tar_id";
    $receiver_old_balance_r = mysqli_query($wallet_connection, $receiver_old_balance_q);
    $receiver_old_balance_f = mysqli_fetch_array($receiver_old_balance_r);
    $receiver_old_balance = $receiver_old_balance_f['balance'];
    $receiver_new_balance = $receiver_old_balance + $sendAmnt;

    $sender_new_balance = $get_fxcoin_count - $sendAmnt - $interest;
    
    $fxstar_send_q = "UPDATE fxstars SET balance = $sender_new_balance WHERE user_id=$get_user_id; UPDATE fxstars SET balance = $receiver_new_balance WHERE user_id = $tar_id; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($interest, $get_user_id, $fxunivers_id, '$trans_dt');INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($sendAmnt, $get_user_id, $tar_id, '$trans_dt');";
    $fxstar_send_r = mysqli_multi_query($wallet_connection, $fxstar_send_q);
    
    // send notif to the receiver
    $send_notif_body="$get_user_fname $get_user_lname sent you $sendAmnt fxStars.";
    $fxcoin_send_notif_query="INSERT INTO notif(user_id, body, from_id, sent_dt) VALUES($tar_id,'$send_notif_body',$get_user_id, '$trans_dt')";
    $fxcoin_send_notif_result=mysqli_query($connection,$fxcoin_send_notif_query);

    if($fxstar_send_r) {
	echo 'success';
    } else {
	echo 'failed';
    }

    

    /*
       // Update the ownership of the fxCoins
       $transfer_fxcoin_query = "UPDATE link SET userId=$tar_id WHERE userId=$get_user_id LIMIT $sendAmnt";
       
       $transfer_fxcoin_result = mysqli_query($wallet_connection, $transfer_fxcoin_query) or die(mysqli_error($wallet_connection));
       // set transfer data
       $trans_from=$get_user_id;
       $trans_to=$tar_id;
       $trans_amnt=$sendAmnt;
       $trans_query="INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($trans_from, $trans_to, $trans_amnt, '$trans_dt')";
       $trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));

       


       

       $transfer_interest_query="UPDATE link SET userId=1 WHERE userId=$get_user_id LIMIT $interest";
       $transfer_interest_result=mysqli_query($wallet_connection, $transfer_interest_query) or die(mysqli_error($wallet_connection));
       // set transfer data
       $trans_from=$get_user_id;
       $trans_to=1;
       $trans_amnt=$interest;
       $trans_query="INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($trans_from, $trans_to, $trans_amnt, '$trans_dt')";
       $trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));*/

    
    
} else {
    echo 'insuff';
}

?>
