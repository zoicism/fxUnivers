<?php
session_start();
require('../register/connect.php');

// Fetch the body of the sonet table
$sonet_query = "SELECT body FROM sonet WHERE uid=$user2_id ORDER BY id DESC";
$sonet_result = mysqli_query($connection, $sonet_query) or die(mysqli_error($connection));

?>