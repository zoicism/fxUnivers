<?php
session_start();
session_destroy();

if(isset($_COOKIE['password'])) {
    setcookie('username','',time()-7000000,'/');
    setcookie('password','',time()-7000000,'/');
}

header('Location: /');
?>

