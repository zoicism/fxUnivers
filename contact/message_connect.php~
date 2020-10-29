<?php

$msg_connection = mysqli_connect('localhost', 'root', 'helloworld');
if(!$msg_connection) {
  die("Database connection failed" . mysqli_error($msg_connection));
}

$msg_select_db = mysqli_select_db($msg_connection, 'msg');
if(!$msg_select_db) {
  die("Database selection failed" . mysqli_error($msg_connection));
}

?>