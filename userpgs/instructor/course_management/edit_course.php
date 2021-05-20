<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
   $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   header("Location: $url");
   exit;
   }*/
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

if(isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
}

require('../../../php/get_course.php');

require('../../../php/get_plans.php');

require('../../../php/get_rel.php');
require('../../../wallet/php/get_fxcoin_count.php');

require('../../../php/get_user_type.php');
if($user_type!='instructor') {
    header('Location: /');
}

$video_path='videos/';
$prev_vid=glob($video_path.$course_id.'.*');
if(count($prev_vid)>0) $video_exists=1; else $video_exists=0;

if($get_course_fetch['video_url']!='') $embed_exists=1; else $embed_exists=0;
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
		    <h2 class="course-management-txt">Course Management</h2>
		    <div class="course-management-boxes">
			<div class="inner-content-box left">
			    <h3>Title, Description, Cost</h3>
			    <form class="form" id="edit-post" autocomplete="off">
				<input type="text" class="txt-input" name="header" placeholder="Course title" value="<?php echo $get_course_fetch['header']?>" required>
				<textarea name="description" rows="10" placeholder="Description" required><?php echo preg_replace('/\<br(\s*)?\/?\>/i', "",$get_course_fetch['description']) ?></textarea>
				<input type="number" class="num-input" name="course_fxstar" placeholder="Cost (fxStars)" id="newCost" min="0" value="<?php echo $get_course_fetch['cost'] ?>" required>
				<input type="hidden" name="course_id" value="<?php echo $course_id?>">
				<input type="submit" class="submit-btn" value="Update Details and Cost">
			    </form>
			    <h3>Privacy</h3>
			    
			    <?php
			    if($get_course_fetch['private']) {
				echo '<div style="width:100%; border-bottom: 1px solid #3333332e;display:flex; align-items:center; justify-content:center; padding-bottom:20px; flex-flow:wrap;">';
				echo '<div style="display:flex; width:100%;align-items:center;justify-content:center;padding-bottom:20px;flex-flow:wrap;">';
				echo '<p style="padding-right:15px" id="privateP">This course is private. Make it public:</p> <label class="switch" >
				<input type="checkbox" name="private" id="privateId" checked>
				<span class="slider round" ></span>
				</label>';
				echo '</div>';
				echo '<div>';
				echo '<!--<p>Invite fxUsers:</p>-->
				<div  style="display:flex; flex-flow:row wrap; justify-content:space-between;">
                                <input type="text" list="fxUsersList" name="query" id="fxInvitee" class="txt-input" placeholder="fxUser">
<div id="datalistDiv">
                                <datalist id="fxUsersList">
                                  
                                </datalist>
</div>
                                <button class="submit-btn" id="private-invite">Invite</button></div>';
				echo '</div></div>';
			    } else {
				echo '<div style="display:flex; border-bottom: 1px solid #3333332e; width:100%;align-items:center;justify-content:center;padding-bottom:20px;flex-flow:wrap;">';
				echo '<p style="padding-right:15px" id="privateP">This course is public. Make it private:</p> <label class="switch" >
				<input type="checkbox" name="private" id="privateId">
				<span class="slider round" ></span>
				</label>';
				echo '</div>';
			    }
			    ?>


			    <div>
				<div  style="display:flex; flex-flow:row wrap; justify-content:center; border-bottom: 1px solid #3333332e;padding-bottom:20px;">
				<h3>Negotiable Cost</h3>
				<p>Do you want the cost of this course be negotiable? It will help attract underprivileged students.</p>
				<label class="switch" >
				    <?php
				    if($get_course_fetch['negotiable']) {
					echo '<input type="checkbox" name="negotiable" id="negotiableId" checked>';
				    } else {
					echo '<input type="checkbox" name="negotiable" id="negotiableId">';
				    }
				    ?>
				    
				    <span class="slider round" ></span>
				</label>
				</div>
			    </div>

			    
			    <div class="delete-course-con">
				<h3>Delete Course</h3>
				<p>By deleting a course, all of the related sessions and videos will be lost permenantly, so think twice before deciding to do so.</p>
				<form id="delCourseForm"><input type="hidden" name="course_id" value="<?php echo $course_id?>"><input type="submit" class="submit-btn" value="Delete Course"></form>
			    </div>
			</div>
			<div class="video-bulletin-con">
			    <div class="inner-content-box video">
				<div class="upload-video-con">
				    <h3>Video</h3>
				    <p style="display:none;" id="up-vid-p">Upload a video from your device.</p>
				    <button class="submit-btn" id="up-vid-id" style="display:none">Upload Video</button>
				    <form method="POST" style="display:none" id="up-vid-form" action="file_uploader.php" enctype="multipart/form-data" >
					<input name="video_up" type="file" id="vid-file-up">
					<input name="course_id" type="hidden" value="<?php echo $course_id?>">
					<input type="submit" value="Upload" class="submit-btn">
				    </form>

				    <p style="display:none;" id="del-vid-p">Remove your uploaded video for the course.</p>
				    <button id="del-vid-id" class="submit-btn" style="display:none">Delete Video</button>
				    <form id="vid-embed" autocomplete="off" style="display:none">
					<p>Paste a YouTube/Vimeo link here as your course video. In case you have already uploaded a video using the button above, that video will be shown instead of the link.</p>
					<input type="text" class="txt-input" name="embed_link" placeholder="Video link" id="link-text" required>
					<input type="hidden" name="course_id" value="<?php echo $course_id?>">
					<input type="submit" class="submit-btn" value="Link Video" id="embedBtn">
				    </form>
				    <form id="del-embed" style="display:none">
					<p>Remove your linked video.</p>
					<input type="hidden" name="course_id" value="<?php echo $course_id?>">
					<input type="submit" class="submit-btn" value="Remove Link" id="delEmbedBtn">
				    </form>
				</div>
			    </div>
			    <div class="inner-content-box">
				<div class="add-bulletin-con">
				    <h3>Bulletin</h3>
				    <p>Bulletins are available to the public in your course page. Adding a bulletin will inform your learners by notification and email.</p>
				    <form id="bulletin-form">
					<input type="text" name="bulletin-body" class="txt-input" placeholder="Bulletin text" id="bulletin-txt" required>
					<input type="hidden" name="course-id" value="<?php echo $course_id?>">
					<input type="hidden" name="teacher-id" value="<?php echo $get_user_id?>">
					<input type="hidden" name="course-header" value="<?php echo $get_course_fetch['header']?>">
					<input type="submit" class="submit-btn" value="Add Bulletin">
				    </form>
				</div>
			    </div>
			</div>
		    </div>
		    <button onclick="window.location.replace('/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id ?>')" class="submit-btn" style="margin-left:auto">Done</button>
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



	<!-- fxUniversity sidebar active -->
	<script>
	 $('.fxuniversity-sidebar').attr('id','sidebar-active');
	</script>

	<!-- VIDEO EMBED -->
	<script>
	 $('#vid-embed').submit(function(event) {
	     event.preventDefault();

	     var uploadOk=0;

	     var embedLink = $('#link-text').val();
	     var vimeo = embedLink.match("vimeo.com/(.*)");
	     var yt = embedLink.match("v=(.*)");

	     if(yt!==null) {
		 var ytHash = yt[1].match("(.*)&");
		 if(ytHash!==null) {
		     var ytLink = ytHash[1];
		 } else {
		     var ytLink = yt[1];
		 }
		 
		 embedLink = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'+ytLink+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
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
		     data: {embed_link: embedLink, course_id: '<?php echo $course_id?>' },
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

	<script>
	 $('#delCourseForm').submit(function(event) {
	     event.preventDefault();
	     if(confirm("Are you sure you want to delete this course?")) {
		 jQuery.ajax({
		     url:'/php/del_course.php',
		     type:'POST',
		     data:$(this).serialize(),
		     success:function(response) {
			 if(response=='deleted') {
			     window.location.replace('/userpgs/instructor');
			 } else {
			     alert('Could not delete your course at this moment. Please try again.');
			 }
		     }
		 });
	     } else {
	     }
	 });
	</script>

	<script>
	 $('#del-vid-id').click(function() {
	     if(confirm("Are you sure you want to delete course's video?")) {
		 $('#del-vid-id').css('opacity','0.6');
		 $('#del-vid-id').html('Deleting...');
		 
		 jQuery.ajax({
		     type:'POST',
		     url:'/userpgs/instructor/course_management/delete_vid.php',
		     data:{course_id:'<?php echo $course_id?>'},
		     success: function(response) {
			 if(response==1) {
			     alert('Course video is deleted.');
			     window.location.reload();
			 } else {
			     alert('This course does not have a video.');
			 }
		     }
		 });
	     }
	 });
	</script>

	<script>
	 $('#bulletin-form').submit(function(event) {
	     event.preventDefault();
	     jQuery.ajax({
		 url:'/php/set_bulletin.php',
		 data:$(this).serialize(),
		 type:'POST',
		 success: function(response) {
		     console.log(response);
		     if(response==1) {
			 alert('Bulletin is added.');
			 $('#bulletin-txt').val('');
		     } else {
			 alert('Failed to add the bulletin. Please try again.');
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
			 alert('Course details are updated.');
		     } else {
			 alert('Failed to update the course details. Please try again.');
		     }
		 }
	     });
	 });
	</script>

	<script>
	 $('#privateId').click(function() {
	     if($('#privateId').prop('checked') == true) {
		 var currentPrivacy = 0;
	     } else {
		 var currentPrivacy = 1;
	     }
	     
	     $.ajax({
		 url: '/php/set_fxcourse_privacy.php',
		 data: {courseId: '<?php echo $course_id ?>', privacy: currentPrivacy},
		 type: 'POST',
		 success: function(response) {
		     if(response == 1) {
			 if(currentPrivacy == 0) {
			     $('#privateP').html('This course is private. Make it public:');
			     window.location.reload();
			 } else if(currentPrivacy == 1) {
			     $('#privateP').html('This course is public. Make it private:');
			     window.location.reload();
			 }
		     } else {
			 alert('Failed to change the privacy. Please try again.');
			 window.location.reload();
		     }
		 }
	     });
	 });
	</script>

	<script>
	 $('#fxInvitee').each(function() {
	     var elem = $(this);
	     elem.data('oldVal', elem.val());
	     elem.bind("propertychange change click keyup input paste", function(event) {
		 if(elem.data('oldVal')!=elem.val()) {
		     elem.data('oldVal', elem.val());

		     $.ajax({
			 url: '/php/search_fxusers.php',
			 type: 'POST',
			 data: $(this).serialize(),
			 success: function(response) {
			     if(response != 0) {
				 $('#datalistDiv').html(response);
			     }
			 }
		     });
		 }
	     });
	 });	 
	</script>

	<script>
	 $('#private-invite').click(function() {
	     var fxUserName = $('#fxInvitee').val();
	     var fxCourse_id = '<?php echo $course_id ?>';
	     var fxCourse_header = "<?php echo $get_course_fetch['header']?>";
	     var instructor_id = '<?php echo $get_user_id ?>';
	     var instructor_un = '<?php echo $username ?>';
	     $.ajax({
		 url: '/php/set_private_course_invitation.php',
		 type: 'POST',
		 data: {inviteeUsername: fxUserName, courseId: fxCourse_id, courseHeader: fxCourse_header, instructorId: instructor_id, instructorUn: instructor_un},
		 success: function(response) {
		     console.log(response);
		     if(response == 1) {
			 alert(fxUserName + ' is invited to join the fxCourse.');
		     } else if(response == 'not_found') {
			 alert('No user by the username of ' + fxUserName + ' is found.');
		     } else if(response == 'dup') {
			 alert('You have already sent an invitation to this user.');
		     } else {
			 alert('Failed to send the invitation. Please try again.');
		     }
		 }
	     });
	 });
	</script>

	<!-- NEGOTIABLE -->
	<script>
	 $('#negotiableId').click(function() {
	     var courseId = '<?php echo $course_id ?>';
	     if($(this).prop('checked') == true) {
		 $.ajax({
		     url: '/php/set_negotiable_course.php',
		     type: 'POST',
		     data: {course_id: courseId, negotiable: '1'},
		     success: function(response) {
			 //console.log(response);
		     }
		 });
	     } else {
		 $.ajax({
		     url: '/php/set_negotiable_course.php',
		     type: 'POST',
		     data: {course_id: courseId, negotiable: '0'},
		     success: function(response) {
			 //console.log(response);
		     }
		 });
	     }
	 });
	</script>
    </body>
</html>
