<?php

require('conn/fxpartner.php');

$get_partner_query="SELECT * FROM on_user WHERE partner=$get_user_id ORDER BY id DESC";
$get_partner_result=mysqli_query($fxpartner_connection,$get_partner_query) or die(mysqli_error($fxpartner_connection));
$get_partner_count=mysqli_num_rows($get_partner_result);

?>