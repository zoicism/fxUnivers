<?php
if(isset($_GET['file_name'])) $fileName=$_GET['file_name'];
if(isset($_GET['course_id'])) $course_id=$_GET['course_id'];
if(isset($_GET['class_id'])) $class_id=$_GET['class_id'];


require('../../../php/conn/fxinstructor.php');

$dropFile_q="DELETE FROM `class_files` WHERE fileName='$fileName'";
$dropFile_r=mysqli_query($fxinstructor_connection,$dropFile_q) or die(mysqli_error($fxinstructor_connection));

if($dropFile_r) {
    unlink('uploads/'.$fileName);
}

header('Location: /userpgs/instructor/class?course_id='.$course_id.'&class_id='.$class_id);
?>