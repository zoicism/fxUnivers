<?php
$connection = mysqli_connect('localhost', 'fxuniver_neo', 'lyWk_m92fcHQ', 'fxuniver_main');
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'fxuniver_main');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
?>
