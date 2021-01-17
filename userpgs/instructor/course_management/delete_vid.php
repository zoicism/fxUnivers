<?php

if(isset($_POST['course_id'])) {
  $course_id=$_POST['course_id'];
}


$path='videos/';
$file_ex=glob($path.$course_id.'.*');
if(count($file_ex)>0) {
  $vid_arr=explode('.', $file_ex[0]);
  $vid_ext=end($vid_arr);
  unlink('videos/'.$course_id.'.'.$vid_ext);

  //header('Location: /userpgs/instructor/course_management/course.php?course_id='.$course_id);
  echo 1;
} else {
  echo 0;
  //header('Location: /userpgs/instructor/course_management/course.php?course_id='.$course_id);
}


?>