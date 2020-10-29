<?php

session_start();
require('../../register/connect.php');
if(isset($_SESSION['username'])) $username = $_SESSION['username'];
require('../../php/get_user.php');

require('wallet_connect.php');
require('get_fxcoin_count.php');
if(isset($_POST['reason'])) $reason = $_POST['reason'];
if(isset($_POST['sender'])) $sender = $_POST['sender'];
if(isset($_POST['reciever'])) $reciever = $_POST['reciever'];
if(isset($_POST['amnt'])) $amnt = $_POST['amnt'];
if(isset($_POST['notif'])) $notif = $_POST['notif'];
if(isset($_POST['accepted'])) $accepted = $_POST['accepted'];

$tar_id=$reciever;
require('../../php/get_tar_id.php');
$reciever_un = $tar_user_fetch['username'];

//$log_file = fopen("log.txt", "w") or die("log error");
//fwrite($log_file, $reason.' '.$sender.' '.$reciever.' '.$amnt.' '.$notif);
//fclose($log_file);

// get interest
$interest=ceil(0.1*$amnt);

// current dt
date_default_timezone_set('America/New_York');
$trans_dt=date('Y-m-d H:i:s');

if($get_fxcoin_count>$amnt+$interest && $accepted==1) {
    // send the reviever $amnt fxCoins  
    $rfc_query = "UPDATE link SET userId=$reciever WHERE userId=$sender LIMIT $amnt";
    $rfc_result = mysqli_query($wallet_connection, $rfc_query) or die(mysqli_error($wallet_connection));
    // set transfer data
    $trans_from=$sender;
    $trans_to=$reciever;
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

    // update the notification
    $rfc_body = "You accepted the request of @$reciever_un and sent them $amnt fxCoins.";
    $rfc_notif_query = "UPDATE notif SET body='$rfc_body', active=0 WHERE id=$notif";
    $rfc_notif_result = mysqli_query($connection, $rfc_notif_query) or die(mysqli_error($connection));

    // update the fxcoin_req table that the sender has accepted to transfer
    $rfc_acc_query = "UPDATE fxcoin_req SET accepted=1 WHERE notif=$notif";
    $rfc_acc_result = mysqli_query($wallet_connection, $rfc_acc_query) or die(mysqli_error($wallet_connection));
    
    // send reciever a notif of acceptance
    $rfc_re_body="@$username accepted your request of $amnt fxCoins.";
    $rfc_re_notif="INSERT INTO notif(user_id,body,from_id) VALUES($reciever,'$rfc_re_body',$sender)";
    $rfc_re_result=mysqli_query($connection,$rfc_re_notif) or die(mysqli_error($connection));
    
    // FXWALLET.TRANSACTIONS //
    date_default_timezone_set('America/New_York');
    $current_date_time_ny=date("Y-m-d h:i:s");
    $personA_id=$sender;
    $personB_id=$reciever;
    $cost=$amnt;
    require('encrypt_transfer.php');
    $send_req_trans_query="INSERT INTO transactions(ciphertext) VALUES('$ciphertext')";
    $send_req_trans_result=mysqli_query($wallet_connection, $send_req_trans_query) or die(mysqli_error($wallet_connection));

    echo 'success';
} elseif($get_fxcoin_count<$amnt+$interest && $accepted==1) {
    echo 'insuff';
} elseif($accepted==0) {
    // Decline and update sender notif
    $rfcd_body="You declined the request of @$reciever_un of sending them $amnt fxCoins.";
    $rfcd_notif_query="UPDATE notif SET body='$rfcd_body', active=0 WHERE id=$notif";
    $rfcd_notif_result=mysqli_query($connection, $rfcd_notif_query) or die(mysqli_error($connection));
    
    // Send notif to the reciever
    $rfcds_notif_body="@$username has declined your request of $amnt fxCoins.";
    $rfcds_notif_query="INSERT INTO notif(user_id,body,from_id) VALUES($reciever,'$rfcds_notif_body',$sender)";
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