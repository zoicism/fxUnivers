<?php

$sonet_connection = mysqli_connect('localhost', 'fxuniver_neo', 'lyWk_m92fcHQ','fxuniver_sonet');
if(!$sonet_connection)
  die("Database connection failed: ".mysqli_error($sonet_connection));
$sonet_select_db = mysqli_select_db($sonet_connection, 'fxuniver_sonet');
if(!$sonet_select_db)
  die("Database selection failed: ".mysqli_error($sonet_connection));

?>