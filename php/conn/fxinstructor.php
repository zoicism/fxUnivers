<?php

$fxinstructor_connection = mysqli_connect('localhost', 'root', 'helloworld');
if(!$fxinstructor_connection)
  die("Database connection failed: ".mysqli_error($fxinstructor_connection));
$fxinstructor_select_db = mysqli_select_db($fxinstructor_connection, 'fxinstructor');
if(!$fxinstructor_select_db)
  die("Database selection failed: ".mysqli_error($fxinstructor_connection));

?>