<?php
session_start();
require('../register/connect.php');
require('conn/fxinstructor.php');

if(isset($_POST['courseId'])) {
  $course_id = $_POST['courseId'];
  $user_type=$_POST['userType'];
}

if($user_type=='instructor') {
    $classes_q="SELECT * FROM class WHERE course_id=$course_id";
    $classes_r=mysqli_query($connection,$classes_q) or die(mysqli_error($connection));
    $classes_count=mysqli_num_rows($classes_r);
    if($classes_count>0) {
        while($classes=$classes_r->fetch_assoc()) {
            $class_id=$classes['id'];
            
            
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
            
            
        }
    }
    
    $course_vid_path='../userpgs/instructor/course_management/videos/';
    $course_vid=glob($course_vid_path.$course_id.'.*');
    if(count($course_vid)>0) unlink($course_vid[0]);
    
    $del_course_query = "DELETE FROM teacher WHERE id=$course_id";
    $del_course_result = mysqli_query($connection, $del_course_query) or die(mysqli_error($connection));
    if($del_course_result) {
        header('Location: /userpgs/instructor');
        exit();
    }
} else {
    header('Location: /register/logout.php');
}

?>