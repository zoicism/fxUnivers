<?php
require('conn/fxinstructor.php');

if(isset($_POST['class_id'])) $classId=$_POST['class_id'];

$getclasschat_q="SELECT * FROM chat WHERE classId = $classId ORDER BY id DESC";
$getclasschat_r=mysqli_query($fxinstructor_connection,$getclasschat_q) or die(mysqli_error($fxinstructor_connection));
$getclasschat_count=mysqli_num_rows($getclasschat_r);

//echo $_POST['class_id'];

?>