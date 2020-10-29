<?php
$connection = mysqli_connect('localhost', 'root', 'helloworld');
if(!$connection) {
	die("error" . mysqli_error($connection));
}

$select_db = mysqli_select_db($connection, 'newdb');
if(!$select_db) {
	die("error" . mysqli_error($connection));
}
?>
