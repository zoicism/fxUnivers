<?php

require('../connect.php');

if(isset($_POST['email'])) {
    $email=$_POST['email'];
} else {
    header('Location: /');
    exit();
}

$hash = md5(rand(0,1000)); // Random 32-char hash

$forgot_q = "INSERT INTO fogot_pass(email, hash) VALUES('$email', '$hash')";
$forgot_r = mysqli_query($connection, $forgot_q) or die(mysqli_error($connection));

if($forgot_r) {
    header('Location: /register/forgot_password/check.php');
} else {
    header('Location: /register/forgot_password/?err=failed');
}

?>