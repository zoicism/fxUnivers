<?php
if(isset($_POST['course_id'])) $class_id=$_POST['course_id'];
if(isset($_FILES['video_up'])) {
    $video_path='videos/';
    //$prev_vid=glob($video_path.$class_id.'.*');
    //if(count($prev_vid)>0) unlink($prev_vid[0]);

    exec("rm videos/$class_id.*");

    $video_array=explode('.', $_FILES['video_up']['name']);
    $video_ext=end($video_array);
    $path="videos/".$class_id.'.'.$video_ext;
  
    if(move_uploaded_file($_FILES['video_up']['tmp_name'], $path)) {
        $video_upload_ok=1;
        if($video_ext=='mp4') {
            //exec("ffmpeg -i $path -f webm -vcodec libvpx-vp9 -vb 1024k videos/$class_id.webm");
        } elseif($video_ext=='webm') {
            //exec("ffmpeg -i $path -vcodec libx264 -f mp4 -vb 1024k -preset slow videos/$class_id.mp4");
        } else {
            //exec("ffmpeg -i $path -f webm -vcodec libvpx-vp9 -vb 1024k videos/$class_id.webm");
            //exec("ffmpeg -i $path -vcodec libx264 -f mp4 -vb 1024k -preset slow videos/$class_id.mp4");
            //exec("rm $path");
        }
    } else {
        $video_upload_ok=0;
    }
}
header('Location: /userpgs/instructor/course_management/edit_course.php?course_id='.$class_id);
//echo $video_upload_ok;
?>