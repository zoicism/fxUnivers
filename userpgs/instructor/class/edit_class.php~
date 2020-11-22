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
<html>
<head>
	<title>fxUniversity</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
</head>
    
<body>
	<div class="header-sidebar"></div>
    <script src="/js/upperbar.js"></script>

<div class="blur mobile-main">
    
	<div class="sidebar"></div>
	<?php require('../../../php/sidebar.php'); ?>







                          
    <div class="main-content">

              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/userpgs/instructor" class="link-main" id="active-main">
                          <div class="head">Teach</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/userpgs/student" class="link-main">
                          <div class="head">Learn</div>
                      </a>
                  </li>
                  
              </ul>

    </div>





  <div class="relative-main-content">
                            <div class="content-box">
			      <h2>Session Management</h2>

<h3>Title & Description
<form method="POST" action="edit_post.php">
                  <input type="text" name="header" placeholder="Session title" value="<?php echo $get_class['title']?>" class="txt-input" required>
                  <textarea name="description" rows="10" placeholder="Description"><?php echo preg_replace('#<br\s*/?>#i',"",$get_class['body'])?></textarea>
                  <input type="hidden" name="class_id" value="<?php echo $class_id?>">
                  <input type="hidden" name="course_id" value="<?php echo $course_id?>">

                  <input type="submit" value="Update" class="submit-btn">
                </form>





<h3>Video upload</h3>
  <form method="POST"  action="file_uploader.php" enctype="multipart/form-data" >
    <input name="video_up" type="file" accept=".avchd, .avi, .flv, .mkv, .mov, .mp4, .webm, .wmv">
    <input name="course_id" type="hidden" value="<?php echo $course_id?>">
    <input name="class_id" type="hidden" value="<?php echo $class_id?>">
    <input type="submit" value="Upload" class="submit-btn">
  </form>









<h3>File upload</h3>
    <form method="POST" action="class_file_upload.php" enctype="multipart/form-data">
    <input type="hidden" name="inst_id" value="<?php echo $get_user_id?>">
    <input name="class_id" type="hidden" value="<?php echo $class_id?>">
    <input name="course_id" type="hidden" value="<?php echo $course_id?>">
    <input type="file" name="uploaded_file" id="fileToUpload">
    <input type="submit" value="Upload file" class="submit-btn">
    </form>




<h3>Delete Session</h3>
<p style="max-width:400px">By deleting a session, all of the related videos and files will be lost permenantly, so think twice before deciding to do so.</p>
<form action="/php/remove_class.php" method="POST">
                  <input type="hidden" name="rm_courseId" value="<?php echo $course_id ?>">
                  <input type="hidden" name="rm_classId"  value="<?php echo $class_id ?>">
                  <input type="submit" value="Delete Session" class="submit-btn">
                </form>

                            </div>






    </div>



    


</div>


<div class="footbar blur"></div>
                          <script src="/js/footbar.js"></script>



<!-- SCRIPTS -->
<script>
                          $('#page-header').html('fxUniversity');
$('#page-header').attr('href','/userpgs/fxuniversity');
</script>


<!-- fxUniversity sidebar active -->
<script>
$('.fxuniversity-sidebar').attr('id','sidebar-active');
</script>

</body>
</html>
