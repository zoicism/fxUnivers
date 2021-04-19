<?php

session_start();
require('../../register/connect.php');
if(isset($_SESSION['username'])) $username = $_SESSION['username'];
require('../../php/get_user.php');

require('wallet_connect.php');
require('get_fxcoin_count.php');
if(isset($_POST['reason'])) $reason = $_POST['reason'];
if(isset($_POST['sender'])) $sender = $_POST['sender'];
if(isset($_POST['receiver'])) $receiver = $_POST['receiver'];
if(isset($_POST['amnt'])) $amnt = $_POST['amnt'];
if(isset($_POST['notif'])) $notif = $_POST['notif'];
if(isset($_POST['accepted'])) $accepted = $_POST['accepted'];

$tar_id=$receiver;
require('../../php/get_tar_id.php');
$receiver_un = $tar_user_fetch['username'];

//$log_file = fopen("log.txt", "w") or die("log error");
//fwrite($log_file, $reason.' '.$sender.' '.$receiver.' '.$amnt.' '.$notif);
//fclose($log_file);

// get interest
$interest=ceil(0.1*$amnt);

// current dt
//date_default_timezone_set('America/New_York');
$trans_dt=date('Y-m-d H:i:s');

if($get_fxcoin_count>$amnt+$interest && $accepted==1) {
    $fxunivers_id = 1;

    $receiver_old_balance_q = "SELECT balance FROM fxstars WHERE user_id = $receiver";
    $receiver_old_balance_r = mysqli_query($wallet_connection, $receiver_old_balance_q);
    $receiver_old_balance_f = mysqli_fetch_array($receiver_old_balance_r);
    $receiver_old_balance = $receiver_old_balance_f['balance'];
    
    $sender_new_balance = $get_fxcoin_count - $amnt - $interest;
    $receiver_new_balance = $receiver_old_balance + $amnt;

    $accept_q = "UPDATE fxstars SET balance = $sender_new_balance WHERE user_id = $sender; UPDATE fxstars SET balance = $receiver_new_balance WHERE user_id = $receiver; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($interest, $sender, $fxunivers_id, '$trans_dt'); INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($amnt, $sender, $receiver, '$trans_dt'); UPDATE fxcoin_req SET accepted=1 WHERE notif=$notif;";
    $accept_r = mysqli_multi_query($wallet_connection, $accept_q);

    if($accept_r) {
	// update the notification
	$rfc_body = "You accepted the request of @$receiver_un and sent them $amnt fxCoins.";
	$rfc_notif_query = "UPDATE notif SET body='$rfc_body', active=0 WHERE id=$notif";
	$rfc_notif_result = mysqli_query($connection, $rfc_notif_query);

	// update the fxcoin_req table that the sender has accepted to transfer
	//echo $rfc_acc_query = "";
	//$rfc_acc_result = mysqli_query($wallet_connection, $rfc_acc_query) or die(mysqli_error($wallet_connection));
	
	// send receiver a notif of acceptance
	$rfc_re_body="@$username accepted your request of $amnt fxCoins.";
	$rfc_re_notif="INSERT INTO notif(user_id,body,from_id,sent_dt) VALUES($receiver,'$rfc_re_body',$sender, '$trans_dt')";
	$rfc_re_result=mysqli_query($connection,$rfc_re_notif);
	
	

	echo 'success';
    } else {
	echo 'failed';
    }

	/*
	   // send the reviever $amnt fxCoins  
	   $rfc_query = "UPDATE link SET userId=$receiver WHERE userId=$sender LIMIT $amnt";
	   $rfc_result = mysqli_query($wallet_connection, $rfc_query) or die(mysqli_error($wallet_connection));
	   // set transfer data
	   $trans_from=$sender;
	   $trans_to=$receiver;
	   $trans_amnt=$amnt;
	   $trans_query="INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($trans_from, $trans_to, $trans_amnt, '$trans_dt')";
	   $trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));
	   

	   // send fxUnivers our share ($interest)
	   $transfer_interest_query="UPDATE link SET userId=1 WHERE userId=$sender LIMIT $interest";
	   $transfer_interest_result=mysqli_query($wallet_connection,$transfer_interest_query) or die(mysqli_error($wallet_connection));
	   // set transfer data
	   $trans_from=$sender;
	   $trans_to=1;
	   $trans_amnt=$interest;
	   $trans_query="INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($trans_from, $trans_to, $trans_amnt, '$trans_dt')";
	   $trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));
	 */

	
    } elseif($get_fxcoin_count<$amnt+$interest && $accepted==1) {
	echo 'insuff';
    } elseif($accepted==0) {
	// Decline and update sender notif
	$rfcd_body="You declined the request of @$receiver_un to send them $amnt fxCoins.";
	$rfcd_notif_query="UPDATE notif SET body='$rfcd_body', active=0 WHERE id=$notif";
	$rfcd_notif_result=mysqli_query($connection, $rfcd_notif_query) or die(mysqli_error($connection));
	
	// Send notif to the receiver
	$utc_timestamp = date('Y-m-d H:i:s');
	$rfcds_notif_body="@$username has declined your request of $amnt fxCoins.";
	$rfcds_notif_query="INSERT INTO notif(user_id,body,from_id, sent_dt) VALUES($receiver,'$rfcds_notif_body',$sender, '$utc_timestamp')";
	$rfcds_notif_result=mysqli_query($connection,$rfcds_notif_query) or die(mysqli_error($connection));
	
	// Update the fxcoin_req table to declined
	$rfc_dec_query="UPDATE fxcoin_req SET accepted=0 WHERE notif=$notif";
	$rfc_dec_result=mysqli_query($wallet_connection,$rfc_dec_query) or die(mysqli_error($wallet_connection));

	echo 'declined';
    }

    /*else {
       header('HTTP/1.1 500 Internal Server Error');
       //echo "foobar";
       }*/

?>
