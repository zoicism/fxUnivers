<?php
require('conn/sonet.php');

if(isset($_POST['card'])) $card=$_POST['card'];
if(isset($_POST['userId'])) $get_user_id=$_POST['userId'];

require('get_visibility.php');
if($vis[$card]==0) $newvis=1; else $newvis=0;

$setvis_q="UPDATE visibility SET ".$card."=".$newvis." WHERE userid=".$get_user_id;
$setvis_r=mysqli_query($sonet_connection,$setvis_q) or die(mysqli_error($sonet_connection));

?>