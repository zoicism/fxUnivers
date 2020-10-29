<?php
$connection = mysqli_connect('localhost', 'root', 'helloworld');
if (!$connection) {
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'newdb');
if (!$select_db) {
    die("Database Selection Failed" . mysqli_error($connection));
}
?>
