<?php
session_start();
require('../../register/connect.php');
require('wallet_connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: /register/logout.php');
    exit();
}

if(isset($_POST['user_id'])) $userId=$_POST['user_id'];
if(isset($_POST['amnt'])) $amnt=$_POST['amnt'];
if(isset($_POST['coin_count'])) $fxcoins=$_POST['coin_count'];

//date_default_timezone_set('America/New_York');
$dt=date('Y-m-d H:i:s');

if($fxcoins>=$amnt && $amnt>=100) {
    $interest=ceil(0.1*$amnt);
    $valid_amnt=$amnt-$interest;
    
    // fxUnivers interest share
    $fxunivers_q="UPDATE link SET userId=1 WHERE userId=$userId LIMIT $interest";
    $fxunivers_r=mysqli_query($wallet_connection,$fxunivers_q) or die(mysqli_error($wallet_connection));

    // Return the valid amount to the cycle of use
    $zero_q="UPDATE link SET userId=0 WHERE userId=$userId LIMIT $valid_amnt";
    $zero_r=mysqli_query($wallet_connection,$zero_q) or die(mysqli_error($wallet_connection));

    // Amount to be changed in USD
    $cashout_q="INSERT INTO cashout(userId,amnt,dt) VALUES($userId,$valid_amnt,'$dt')";
    $cashout_r=mysqli_query($wallet_connection,$cashout_q) or die(mysqli_error($wallet_connection));

    echo 'success';

    //header('Location: /wallet/cashout?res=success');
    
} else {
    echo 'insuff';

}


?>