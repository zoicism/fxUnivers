<?php

$wallet_connection = mysqli_connect('localhost', 'root', 'helloworld');
if(!$wallet_connection) {
  die("fxWallet Database Connection failed " . mysqli_error($wallet_connection));
}

$select_db = mysqli_select_db($wallet_connection, 'fxwallet');
if(!$select_db) {
  die("fxWallet database selection failed " . mysqli_error($wallet_connection));
}

?>