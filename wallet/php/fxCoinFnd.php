<?php
session_start();
require('../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: /register/logout.php');
    exit();
}
require('../../php/get_user.php');
require('wallet_connect.php');
require('get_fxcoin_count.php');

if(isset($_POST['sendTo'])) $receiver=$_POST['sendTo'];
if(isset($_POST['sendAmnt'])) $sendAmnt=$_POST['sendAmnt'];

$tarname=substr($receiver,1);
require('../../php/get_tar_user.php');

/*
$log_file = fopen("log.txt", "w") or die("log error");
fwrite($log_file, $tarname);
fclose($log_file);
*/

//echo '<script>alert("'.$sendAmnt.'");</script>';

// current dt
date_default_timezone_set('America/New_York');
$trans_dt=date('Y-m-d H:i:s');

//function to determine the interest; I=ceil(0.1*m)
$interest=ceil(0.1*$sendAmnt);

// if user has [m+I] fxCoins condition
if($get_fxcoin_count>$sendAmnt+$interest) {

    
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
    $trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));

    

    // send notif to the receiver
    $send_notif_body="@$username sent you $sendAmnt fxStars.";
    $fxcoin_send_notif_query="INSERT INTO notif(user_id,body,from_id) VALUES($tar_id,'$send_notif_body',$get_user_id)";
    $fxcoin_send_notif_result=mysqli_query($connection,$fxcoin_send_notif_query) or die(mysqli_error($connection));

    echo 'success';
} else {
    echo 'failed';
}

?>