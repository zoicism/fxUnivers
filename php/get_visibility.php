<?php
require('conn/sonet.php');

$vis_q="SELECT * FROM visibility WHERE userid=$get_user_id";
$vis_r=mysqli_query($sonet_connection,$vis_q) or die(mysqli_error($sonet_connection));
$vis=mysqli_fetch_array($vis_r);

?>