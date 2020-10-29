<?php
require('../register/connect.php');
require('conn/fxinstructor.php');

if(isset($_POST['rm_courseId'])) $course_id=$_POST['rm_courseId'];
if(isset($_POST['rm_classId'])) $class_id=$_POST['rm_classId'];
$remove_class_query="DELETE FROM class WHERE id=$class_id";
$remove_class_result=mysqli_query($connection,$remove_class_query) or die(mysqli_error($connection));
if($remove_class_result) {
    $class_files_q="SELECT * FROM class_files WHERE classId=$class_id";
    $class_files_r=mysqli_query($fxinstructor_connection,$class_files_q) or die(mysqli_error($fxinstructor_connection));
    $class_files_count=mysqli_num_rows($class_files_r);
    
    if($class_files_count>0) {
        while($frow=$class_files_r->fetch_assoc()) {
            unlink('../userpgs/instructor/class/uploads/'.$frow['fileName']);
        }
    }
    $remove_class_file_q="DELETE FROM class_files WHERE classId=$class_id";
    $remove_class_file_r=mysqli_query($fxinstructor_connection,$remove_class_file_q) or die(mysqli_error($fxinstructor_connection));
    
    $video_path='../userpgs/instructor/class/live/uploads/';
    $prev_vid=glob($video_path.$class_id.'.*');
    if(count($prev_vid)>0) unlink($prev_vid[0]);
}

header('Location: /userpgs/instructor/course_management/course.php?course_id='.$course_id);
?>