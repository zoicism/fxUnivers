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
	header("Location: /register/logout.php");
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





	<div class="relative-main-content fxuniversity-edit">
		<div class="course-management-con">
			<h2 class="course-management-txt">Course Management</h2>
			<div class="course-management-boxes">
				<div class="content-box left">
					<h3>Title, Description, Cost</h3>
					<form class="form" method="POST" action="edit_post.php" autocomplete="off">
						<input type="text" class="txt-input" name="header" placeholder="Course title" value="<?php echo $get_course_fetch['header']?>" required>
						<textarea name="description" rows="10" placeholder="Description" required><?php echo preg_replace('/\<br(\s*)?\/?\>/i', "",$get_course_fetch['description']) ?></textarea>
						<input type="number" class="num-input" name="course_fxstar" placeholder="Cost (fxStars)" id="newCost" min="0" value="<?php echo $get_course_fetch['cost'] ?>" required>
						<input type="hidden" name="course_id" value="<?php echo $course_id?>">
						<input type="submit" class="submit-btn" value="Update Details and Cost">
					</form>
					<div class="delete-course-con">
						<h3>Delete Course</h3>
						<p>By deleting a course, all of the related sessions and videos will be lost permenantly, so think twice before deciding to do so.</p>
						<form id="delCourseForm"><input type="hidden" name="course_id" value="<?php echo $course_id?>"><input type="submit" class="submit-btn" value="Delete Course"></form>
					</div>
				</div>
				<div class="video-bulletin-con">
					<div class="content-box video">
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
					<div class="content-box">
						<div class="add-bulletin-con">
							<h3>Bulletin</h3>
							<p>Bulletins are available to the public in your course page. Adding a bulletin will infor your learners by notification and email.</p>
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
</body>
</html>
