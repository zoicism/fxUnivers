<?php

$sonet_connection = mysqli_connect('localhost', 'root', 'helloworld');
if(!$sonet_connection)
  die("Database connection failed: ".mysqli_error($sonet_connection));
$sonet_select_db = mysqli_select_db($sonet_connection, 'sonet');
if(!$sonet_select_db)
  die("Database selection failed: ".mysqli_error($sonet_connection));

?>