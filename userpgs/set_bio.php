<?php
session_start();
require('../register/connect.php');

$username = $_SESSION['username'];
$bio = $_POST['bio'];
$query = "UPDATE user SET bio = '$bio' WHERE username='$username'";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

$profile = "profile.php";
header('Location: ' . $profile);

?>
