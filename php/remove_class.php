<?php
require('../register/connect.php');
require('conn/fxinstructor.php');

if(isset($_POST['rm_courseId'])) $course_id=$_POST['rm_courseId'];
if(isset($_POST['rm_classId'])) $class_id=$_POST['rm_classId'];

$remove_class_query="UPDATE class SET alive=0 WHERE id=$class_id";
$remove_class_result=mysqli_query($connection,$remove_class_query) or die(mysqli_error($connection));

if($remove_class_result) {
  echo 'deleted';
} else {
  echo 'error';
}


?>