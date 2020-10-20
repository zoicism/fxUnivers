<?php


$g_c_query = "SELECT * FROM exam WHERE id=$q_id";
$g_c_result = mysqli_query($connection, $g_c_query) or die(mysqli_error($connection));
$g_c_fetch = mysqli_fetch_array($g_c_result);

?>