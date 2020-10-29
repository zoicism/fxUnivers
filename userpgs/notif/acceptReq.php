<?php
$accept_query = "UPDATE friend SET fnd=1, reason='friend' WHERE (user1=20 AND user2=114)";
$accept_result = mysqli_query($connection, $accept_query) or die(mysqli_error($connection));
?>