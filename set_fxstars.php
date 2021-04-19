<?php
require($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');
require($_SERVER['DOCUMENT_ROOT'].'/wallet/php/wallet_connect.php');
$fxusers_q = "SELECT * FROM user";
$fxusers_r = mysqli_query($connection, $fxusers_q) or die(mysqli_error($connection));

while($row = $fxusers_r -> fetch_assoc()) {
	$user_id = $row['id'];

	$fxstars_q = "INSERT INTO fxstars(user_id) VALUES($user_id)";
	$fxstars_r = mysqli_query($wallet_connection, $fxstars_q) or die(mysqli_error($wallet_connection));
}

echo 1;
?>
