<?php

$fxinstructor_connection = mysqli_connect('localhost', 'fxuniver_neo', 'lyWk_m92fcHQ', 'fxuniver_fxinstructor');
if(!$fxinstructor_connection)
  die("Database connection failed: ".mysqli_error($fxinstructor_connection));
$fxinstructor_select_db = mysqli_select_db($fxinstructor_connection, 'fxuniver_fxinstructor');
if(!$fxinstructor_select_db)
  die("Database selection failed: ".mysqli_error($fxinstructor_connection));

?>