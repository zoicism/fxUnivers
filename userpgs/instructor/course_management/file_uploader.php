<?php
if(isset($_POST['course_id'])) $class_id=$_POST['course_id'];
if(isset($_FILES['video_up'])) {
    $video_path='videos/';

    exec("rm videos/$class_id.*");

    $video_array=explode('.', $_FILES['video_up']['name']);
    $video_ext=end($video_array);
    $path="videos/".$class_id.'.'.$video_ext;
  
    if(move_uploaded_file($_FILES['video_up']['tmp_name'], $path)) {
        $video_upload_ok=1;
        if($video_ext=='mp4') {
	    exec("./ffmpeg/ffmpeg -i $path -codec:v libtheora -qscale:v 3 -codec:a libvorbis -qscale:a 3 -f ogv videos/$class_id.ogv");
        }
	exec("./ffmpeg/ffmpeg -i $path -ss 00:00:01.000 -vframes 1 thumbnails/$class_id.jpg");
    } else {
        $video_upload_ok=0;
    }
}
header('Location: /userpgs/instructor/course_management/edit_course.php?course_id='.$class_id);
//echo $video_upload_ok;
?>