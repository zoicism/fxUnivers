<?php
if(isset($_GET['file_name'])) $fileName=$_GET['file_name'];
//echo $fileName.'<br>';
require('conn/fxinstructor.php');

$dropFile_q="DELETE FROM `live_files` WHERE fileName='$fileName'";
$dropFile_r=mysqli_query($fxinstructor_connection,$dropFile_q) or die(mysqli_error($fxinstructor_connection));

if($dropFile_r) {
    unlink('../userpgs/instructor/class/live/files/'.$fileName);
}
?>