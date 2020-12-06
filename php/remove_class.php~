<?php
require('../register/connect.php');
require('conn/fxinstructor.php');

if(isset($_POST['rm_courseId'])) $course_id=$_POST['rm_courseId'];
if(isset($_POST['rm_classId'])) $class_id=$_POST['rm_classId'];
$remove_class_query="DELETE FROM class WHERE id=$class_id";
$remove_class_result=mysqli_query($connection,$remove_class_query) or die(mysqli_error($connection));
if($remove_class_result) {
    $remove_class_file_q="DELETE FROM class_files WHERE classId=$class_id";
    $remove_class_file_r=mysqli_query($fxinstructor_connection,$remove_class_file_q) or die(mysqli_error($fxinstructor_connection));
}

header('Location: /userpgs/instructor/course_management/course.php?course_id='.$course_id);
?>