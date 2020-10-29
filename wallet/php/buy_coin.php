<?php

session_start();
require('wallet_connect.php');

if(isset($_POST['numOfFxCoins'])) $amnt = $_POST['numOfFxCoins'];

require('../../register/connect.php');
$username = $_SESSION['username'];
require('../../php/get_user.php');

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
?>