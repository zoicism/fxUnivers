<?php

require($_SERVER['DOCUMENT_ROOT'].'/wallet/php/wallet_connect.php');

$get_trans_in_q = "SELECT * FROM fxstar_txn WHERE from_id = $get_user_id ORDER BY id DESC";
$get_trans_in = mysqli_query($wallet_connection, $get_trans_in_q);
$get_trans_in_count=mysqli_num_rows($get_trans_in);

$get_trans_out_q = "SELECT * FROM fxstar_txn WHERE to_id = $get_user_id ORDER BY id DESC";
$get_trans_out=mysqli_query($wallet_connection, $get_trans_out_q);
$get_trans_out_count=mysqli_num_rows($get_trans_out);

/*
$get_trans_in_q="SELECT * FROM transactions WHERE from_id=$get_user_id ORDER BY id DESC";
$get_trans_in=mysqli_query($wallet_connection,$get_trans_in_q) or die(mysqli_error($wallet_connection));
$get_trans_in_count=mysqli_num_rows($get_trans_in);

$get_trans_out_q="SELECT * FROM transactions WHERE to_id=$get_user_id ORDER BY id DESC";
$get_trans_out=mysqli_query($wallet_connection,$get_trans_out_q) or die(mysqli_error($wallet_connection));
$get_trans_out_count=mysqli_num_rows($get_trans_out);
*/
?>
