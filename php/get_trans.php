<?php

require('../../wallet/php/wallet_connect.php');

$get_trans_q="SELECT * FROM transactions WHERE from_id=$get_user_id OR to_id=$get_user_id";
$get_trans=mysqli_query($wallet_connection,$get_trans_q) or die(mysqli_error($wallet_connection));
$get_trans_count=mysqli_num_rows($get_trans);

?>