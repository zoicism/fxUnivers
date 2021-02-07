<?php

if(isset($_POST['class_id'])) {
  $class_id=$_POST['class_id'];
}


$path='live/uploads/';
$file_ex=glob($path.$class_id.'.*');
if(count($file_ex)>0) {
  //$vid_arr=explode('.', $file_ex[0]);
  //$vid_ext=end($vid_arr);
  //unlink('live/uploads/'.$class_id.'.'.$vid_ext);

  exec("rm live/uploads/$class_id.*");

  //header('Location: /userpgs/instructor/course_management/course.php?course_id='.$course_id);
  echo 1;
} else {
  echo 0;
  //header('Location: /userpgs/instructor/course_management/course.php?course_id='.$course_id);
}


?>