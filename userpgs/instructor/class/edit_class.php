<?php
session_start();
require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}


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

$video_path='live/uploads/';
$prev_vid=glob($video_path.$class_id.'.*');
if(count($prev_vid)>0) $video_exists=1; else $video_exists=0;

if($get_class['video']!='') $embed_exists=1; else $embed_exists=0;
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
	<script src="/js/jquery.form.js"></script>
    </head>
    
    <body>
	<div class="header-sidebar"></div>
	<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
	<script>
	 if(screen.width >= 629) {
	     $(document).ready(function() {
		 $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/instructor/" class="link-main" id="active-main"><div class="head">Teach</div></a></div><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/student/" class="link-main"><div class="head">Learn</div></a></div></div>');
	       });
	 }
	</script>

	<div class="blur mobile-main">
	    
	    <div class="sidebar"></div>
	    <?php require('../../../php/sidebar.php'); ?>




	    <div class="relative-main-content fxuniversity-edit">
		<div class="course-management-con">
		    <h2 class="course-management-txt">Session Management</h2>
		    <div class="course-management-boxes">
			<div class="left">
			    <div class="inner-content-box">
				    <h3>Title & Description</h3>
				    <form class="form" id="edit-post" autocomplete="off">
					<input type="text" name="header" placeholder="Session title" value="<?php echo $get_class['title']?>" class="txt-input" required>
					<textarea name="description" rows="10" placeholder="Description"><?php echo preg_replace('#<br\s*/?>#i',"",$get_class['body'])?></textarea>
					<input type="hidden" name="class_id" value="<?php echo $class_id?>">
					<input type="hidden" name="course_id" value="<?php echo $course_id?>">
					<input type="submit" value="Update Title and Description" class="submit-btn">
				    </form>
			    </div>
			    <div class="inner-content-box video">
				<div class="upload-video-con">
				    <h3>Video</h3>
				    <p style="display:none;" id="up-vid-p">Upload a video from your device.</p>
				    <button class="submit-btn" id="up-vid-id" style="display:none">Upload Video</button>
				    <form method="POST" id="up-vid-form"  action="file_uploader.php" enctype="multipart/form-data" style="display:none">
					<p>Uploading a new video will replace the previous session video if there is one already.</p>
					<input name="video_up" type="file" id="vid-file-up" accept=".avchd, .avi, .flv, .mkv, .mov, .mp4, .webm, .wmv">
					<input name="course_id" type="hidden" value="<?php echo $course_id?>">
					<input name="class_id" type="hidden" value="<?php echo $class_id?>">
					<input type="submit" value="Upload" class="submit-btn">
				    </form>

				    <p style="display:none;" id="del-vid-p">Remove your uploaded video for the session.</p>
				    <button id="del-vid-id" style="display:none" class="submit-btn">Delete Video</button>
				    <form id="vid-embed" autocomplete="off" style="display:none">
					<p>Paste a YouTube/Vimeo link here as your course video. In case you have already uploaded a video using the button above, that video will be shown instead of the link.</p>
					<input type="text" class="txt-input" name="embed_link" id="link-text" placeholder="Video link" required>
					<input type="hidden" name="class_id" value="<?php echo $class_id?>">
					<input type="submit" class="submit-btn" value="Embed Video" id="embedBtn">
				    </form>
				    <form id="del-embed" style="display:none">
					<p>Remove your linked video.</p>
					<input type="hidden" name="class_id" value="<?php echo $class_id?>">
					<input type="submit" class="submit-btn" value="Remove Link" id="delEmbedBtn">
				    </form>
				</div>
			    </div>
			</div>
			<div class="video-bulletin-con">
			    <div class="inner-content-box delete-course-con">
				<h3>Delete Session</h3>
				<p>By deleting a session, all of the related videos and files will be lost permenantly, so think twice before deciding to do so.</p>
				<form id="delClassForm">
				    <input type="hidden" name="rm_courseId" value="<?php echo $course_id ?>">
				    <input type="hidden" name="rm_classId"  value="<?php echo $class_id ?>">
				    <input type="submit" value="Delete Session" class="submit-btn">
				</form>
			    </div>
			    
			    <div class="inner-content-box">
				<div class="add-bulletin-con">
				    <h3>File upload</h3>
				    <form method="POST" id="fileForm" enctype="multipart/form-data" action="class_file_upload.php">
					<input type="hidden" name="inst_id" value="<?php echo $get_user_id?>">
					<input name="class_id" type="hidden" value="<?php echo $class_id?>">
					<input name="course_id" type="hidden" value="<?php echo $course_id?>">
					<input type="file" name="uploaded_file" id="fileToUpload" style="margin:auto">
					<p id="uploadMsg" style="display:none">Uploaded. You can upload another now.</p>
					<input type="submit" value="Upload file" class="submit-btn">
				    </form>
				</div>
			    </div>
			</div>
		    </div>
		    <button onclick="window.location.replace('/userpgs/instructor/class/?course_id=<?php echo $course_id ?>&class_id=<?php echo $class_id ?>')" class="submit-btn" style="margin-left:auto">Done</button>
		</div>
	    </div>
	</div>


	<div class="footbar blur"></div>
        <script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>



	<!-- SCRIPTS -->
	<script>
         $('#page-header').html('fxUniversity');
	 $('#page-header').attr('href','/userpgs/fxuniversity');
	</script>


	<!-- fxUniversity sidebar active -->
	<script>
	 $('.fxuniversity-sidebar').attr('id','sidebar-active');
	</script>

	<!-- VIDEO -->
	<script>
	 var videoExists = <?php echo $video_exists ?>;
	 if(videoExists) {
	     $('#del-vid-id').show();
	     $('#del-vid-p').show();
	 } else {
	     $('#up-vid-id').show();
	     $('#up-vid-p').show();
	 }
	 var embedExists = <?php echo $embed_exists ?>;
	 //console.log(embedExists);
	 if(embedExists) {
	     $('#del-embed').show();
	 } else {
	     $('#vid-embed').show();
	 }
	</script>

	<script>
	 $('#up-vid-id').click(function() {
	     $('#vid-file-up').click();
	 });

	 $('#vid-file-up').change(function() {
	     $('#up-vid-form').submit();
	     $('#up-vid-id').html('Uploading...');
	     $('#up-vid-id').css('opacity','0.6');
	 });
	</script>


	<!-- VIDEO EMBED -->
	<script>


	 $('#vid-embed').submit(function(event) {
	     event.preventDefault();
	     
	     var uploadOk=0;

	     var embedLink = $('#link-text').val();
	     var vimeo = embedLink.match("vimeo.com/(.*)");
	     var yt = embedLink.match("v=(.*)");

	     console.log(yt);
	     if(yt!==null) {
		 embedLink = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'+yt[1]+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
		 uploadOk=1;
	     } else if(vimeo!==null) {
		 embedLink = '<iframe width="560" height="315" src="https://player.vimeo.com/video/'+vimeo[1]+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
		 uploadOk=1;
	     } else {
		 alert('Please paste a valid YouTube/Vimeo link.');
	     }
	     
	     if(uploadOk) {
		 jQuery.ajax({
		     url:'embed.php',
		     type:'POST',
		     data: {embed_link: embedLink, class_id: '<?php echo $class_id?>' },
		     success: function(response) {
			 if(response==1) {
			     alert('Video is linked.');
			     window.location.reload();
			 }
		     }
		 });
	     }
	 });

	 $('#del-embed').submit(function(ev) {
	     ev.preventDefault();
	     console.log('Removing embed ...');
	     jQuery.ajax({
		 url:'del_embed.php',
		 type:'POST',
		 data:$(this).serialize(),
		 success: function(res) {
		     if(res==1) {
			 alert('Video link is removed.');
			 window.location.reload();
		     }
		 }
	     });
	 });
	</script>

	<!-- FILE UPLOAD -->
	<script>
	 $(function() {
	     $('#fileForm').ajaxForm(function(response) {
		 console.log('file is uploaded');
		 $('#fileToUpload').val('');
		 $('#uploadMsg').show();
		 setTimeout(function() {
		     $('#uploadMsg').hide();
		 }, 5000);
	     });
	 });
	</script>


	<script>
	 $('#delClassForm').submit(function(event) {
	     event.preventDefault();
	     if(confirm("Are you sure you want to delete this session?")) {
		 jQuery.ajax({
		     url:'/php/remove_class.php',
		     type:'POST',
		     data:$(this).serialize(),
		     success:function(response) {
			 if(response=='deleted') {
			     window.location.replace('/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id?>');
			 } else {
			     alert('Could not delete your session at this moment. Please try again.');
			 }
		     }
		 });
	     } else {}
	 });
	</script>

	<script>
	 $('#del-vid-id').click(function() {
	     jQuery.ajax({
		 type:'POST',
		 url:'/userpgs/instructor/class/delete_vid.php',
		 data:{class_id:'<?php echo $class_id?>'},
		 success: function(response) {
		     if(response==1) {
			 alert('Session video is deleted.');
			 window.location.reload();
		     } else {
			 alert('This session does not have a video.');
		     }
		 }
	     });
	 });
	</script>

	<script>
	 $('#edit-post').submit(function(event) {
	     event.preventDefault();

	     jQuery.ajax({
		 url: 'edit_post.php',
		 data: $(this).serialize(),
		 type: 'POST',
		 success: function(response) {
		     if(response==1) {
			 alert('Session details are updated.');
		     } else {
			 alert('Failed to update the session details. Please try again.');
		     }
		 }
	     });
	 });
	</script>

	
    </body>
</html>
