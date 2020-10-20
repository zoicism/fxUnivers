<?php
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: /register/logout.php');
    exit();
}

require('../wallet/php/wallet_connect.php');

/*
if(isset($_POST['from_id'])) $from_id=$_POST['from_id']; else header('Location: /register/logout.php');
if(isset($_POST['to_id'])) $to_id=$_POST['to_id']; else header('Location: /register/logout.php');
if(isset($_POST['trans_amnt'])) $amnt=$_POST['trans_amnt']; else header('Location: /register/logout.php');
*/

$trans_query="INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($trans_from, $trans_to, $trans_amnt, '$trans_dt')";
$trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));
?>

