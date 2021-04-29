<?php
if(isset($_GET['file_name'])) $fileName=$_GET['file_name'];
//echo $fileName.'<br>';
require_once('conn/fxinstructor.php');

$dropFile_q="DELETE FROM `class_files_ooo` WHERE fileName='$fileName'";
$dropFile_r=mysqli_query($fxinstructor_connection,$dropFile_q) or die(mysqli_error($fxinstructor_connection));

if($dropFile_r) {
    unlink('../userpgs/instructor/class/live/ooo_files/'.$fileName);
}
?>
