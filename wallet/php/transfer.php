<?php

require('wallet_connect.php');

// We need the following:
//  1. Person A id	$stu_id	
//  2. Person B id	$instructor_id
//  3. fxCoin amnt	$cost
//  4. Date & time	NA

$personA_id = $stu_id;
$personB_id = $instructor_id;

date_default_timezone_set('America/New_York');
$current_date_time_ny = date("Y-m-d h:i:s");

require('encrypt_transfer.php');

$transfer_cipher_query = "INSERT INTO transactions(ciphertext) VALUES('$ciphertext')";
$transfer_cipher_result = mysqli_query($wallet_connection, $transfer_cipher_query) or die(mysqli_error($wallet_connection));


?>