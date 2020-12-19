<?php
session_start();
require('../../../register/connect.php');

$username = $_SESSION['username'];

require('../../../php/get_user.php');
$id = $get_user_id;

require('../../php/notif.php');

if(isset($_GET['course_id'])) $course_id = $_GET['course_id'];
if(isset($_GET['class_id'])) $class_id=$_GET['class_id'];

require('../../../php/get_plans.php');
require('../../../php/get_rel.php');
require('../../../wallet/php/get_fxcoin_count.php');
require('../../../php/get_class.php');


function get_string_between($string, $start, $end){
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);   
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}

require('../../../wallet/php/get_fxcoin_count.php');

require('../../../php/get_course.php');
require('../../../php/get_user_type.php');
if($user_type!='instructor') {
    header("Location: /");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">  
    <title>fxUnivers</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <link rel="stylesheet" href="/css/colors.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
    </head>

<body>
    <div class="upperbar"></div>
<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>

    <div class="col-33 left-col">
  <div class="col-1">
    <div class="main fxuniversity-color"></div>
    <div class="icon col-icon fxuniversity-bg" onclick="location.href='/userpgs/fxuniversity';"></div>
                    
                <h3>Edit Class</h3>
  </div>
</div>



    <div class="col-33 mid-col">
    <div class="col-1">
    
<form method="POST" action="edit_post.php">
                  <input type="text" name="header" placeholder="Title" value="<?php echo $get_class['title']?>" style="width:90%" required><br>
                  <textarea name="description" rows="10" placeholder="Description" style="width:90%"><?php echo preg_replace('#<br\s*/?>#i',"",$get_class['body'])?></textarea><br>
                  <input type="hidden" name="class_id" value="<?php echo $class_id?>">
                  <input type="hidden" name="course_id" value="<?php echo $course_id?>">

                  <input type="submit" value="Update" style="margin-right:0">
                </form>

                <form action="/php/remove_class.php" method="POST">
                  <input type="hidden" name="rm_courseId" value="<?php echo $course_id ?>">
                  <input type="hidden" name="rm_classId"  value="<?php echo $class_id ?>">
                  <input type="submit" value="Delete" style="margin-right:0">
                </form>
    </div>
    </div>

<div class="col-33 right-col">
    <div class="col-1">
  <h3>Video upload</h3>
  <form method="POST"  action="file_uploader.php" enctype="multipart/form-data" >
    <input name="video_up" type="file" accept=".avchd, .avi, .flv, .mkv, .mov, .mp4, .webm, .wmv">
    <input name="course_id" type="hidden" value="<?php echo $course_id?>">
    <input name="class_id" type="hidden" value="<?php echo $class_id?>">
    <input type="submit" value="Upload video" style="margin-top:0">
  </form>
  </div>

  <div class="col-1">
    <h3>File upload</h3>
    <form method="POST" action="class_file_upload.php" enctype="multipart/form-data">
    <input type="hidden" name="inst_id" value="<?php echo $get_user_id?>">
    <input name="class_id" type="hidden" value="<?php echo $class_id?>">
    <input name="course_id" type="hidden" value="<?php echo $course_id?>">
    <input type="file" name="uploaded_file" id="fileToUpload">
    <input type="submit" value="Upload file" style="margin-top:0">
    </form>
  </div>
</div>

<div class="footer"></div>
<script src="/js/footer.js"></script>

<div class="footbar"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>



</body>
</html>