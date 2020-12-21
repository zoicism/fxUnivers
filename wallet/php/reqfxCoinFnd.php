<?php
session_start();
require('../../register/connect.php');
if(isset($_SESSION['username'])) $username = $_SESSION['username'];
require('../../php/get_user.php');
if(isset($_POST['reqFrom'])) $reqFrom = $_POST['reqFrom'];
if(isset($_POST['reqAmnt'])) $reqAmnt = $_POST['reqAmnt'];
$tarname=$reqFrom;
require('../../php/get_tar_user.php');
$body = "@$username has requested $reqAmnt fxCoins from you. Do you want to send $get_user_fname $get_user_lname, $reqAmnt fxCoins?";

$utc_timestamp = date('Y-m-d H:i:s');

$rfcf_query = "INSERT INTO notif(user_id, body, reason, from_id, active, sent_dt) VALUES($tar_id, '$body', 'fxCoinReq', $get_user_id, 1, '$utc_timestamp')";
$rfcf_result = mysqli_query($connection, $rfcf_query) or die(mysqli_error($connection));

$rfcf_id_query = "SELECT * FROM notif WHERE from_id=$get_user_id ORDER BY id DESC LIMIT 1";
$rfcf_id_result = mysqli_query($connection, $rfcf_id_query) or die(mysqli_error($connection));
$rfcf_id_fetch = mysqli_fetch_array($rfcf_id_result);
$rfcf_notif_id = $rfcf_id_fetch['id'];

require('wallet_connect.php');
$rfcf_wallet_query = "INSERT INTO fxcoin_req(reciever, sender, amnt, notif) VALUES($get_user_id, $tar_id, $reqAmnt, $rfcf_notif_id)";
$rfcf_wallet_result = mysqli_query($wallet_connection, $rfcf_wallet_query) or die(mysqli_error($wallet_connection));

if($rfcf_result && $rfcf_id_result && $rfcf_wallet_result) {
  echo 'success';
} else {
  echo 'failed';
}
?>