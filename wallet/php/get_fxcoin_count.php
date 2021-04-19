<?php

require('wallet_connect.php');
$get_count_query = "SELECT * FROM fxstars WHERE user_id = $get_user_id";
$get_count_result = mysqli_query($wallet_connection, $get_count_query);
$get_fxcoin_f = mysqli_fetch_array($get_count_result);
$get_fxcoin_count = $get_fxcoin_f['balance'];

/*get_count_query = "SELECT * FROM link WHERE userId=$get_user_id";
$get_count_result = mysqli_query($wallet_connection, $get_count_query) or die(mysqli_error($wallet_connection));
$get_fxcoin_count = mysqli_num_rows($get_count_result);*/

?>
