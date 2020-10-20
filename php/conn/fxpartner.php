<?php

$fxpartner_connection = mysqli_connect('localhost', 'fxuniver_neo', 'lyWk_m92fcHQ', 'fxuniver_fxpartner');
if(!$fxpartner_connection)
  die("Database connection failed: ".mysqli_error($fxpartner_connection));
$fxpartner_select_db = mysqli_select_db($fxpartner_connection, 'fxuniver_fxpartner');
if(!$fxpartner_select_db)
  die("Database selection failed: ".mysqli_error($fxpartner_connection));
?>