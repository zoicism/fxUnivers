<?php
if(isset($_POST['class_id'])) $class_id=$_POST['class_id'];
if(isset($_POST['course_id'])) $course_id=$_POST['course_id'];
//echo '>>'.$_FILES['video_up']['name'];
if(isset($_FILES['video_up'])) {
    $video_path='live/uploads/';
    $prev_vid=glob($video_path.$class_id.'.*');
    if(count($prev_vid)>0) unlink($prev_vid[0]);
    
    $video_array=explode('.', $_FILES['video_up']['name']);
    $video_ext=end($video_array);
    $path="live/uploads/".$class_id.'.'.$video_ext;
    if(move_uploaded_file($_FILES['video_up']['tmp_name'], $path)) {
        /*$video_upload_ok=1;
        exec("ffmpeg -i $path -b:v 0 -crf 30 live/uploads/$class_id.webm");
        exec("rm $path");*/
    } else {
        //print_r($_FILES);
        //$video_upload_ok=0;
    }
}
header('Location: /userpgs/instructor/class?course_id='.$course_id.'&class_id='.$class_id);
//echo $video_upload_ok;
?>