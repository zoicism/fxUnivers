<?php
session_start();
require('../register/connect.php');

$uid = $row["uid"];
$sou_query = "SELECT * FROM user WHERE id=$uid";
$sou_result = mysqli_query($connection, $sou_query) or die(mysqli_error($connection));
$sou_fetch = mysqli_fetch_array($sou_result);
$sou_username = $sou_fetch['username'];
$sou_firstname = $sou_fetch['fname'];
$sou_lastname = $sou_fetch['lname'];

?>