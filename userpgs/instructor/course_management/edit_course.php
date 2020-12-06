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
	header("/register/logout.php");
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
			      <h2>Course Management</h2>

<h3>Title, Description, Cost</h3>

			      <form method="POST" action="edit_post.php" autocomplete="off">
			      
				<input type="text" class="txt-input" name="header" placeholder="Course title" value="<?php echo $get_course_fetch['header']?>" required>
				
				<textarea name="description" rows="10" placeholder="Description" required><?php echo preg_replace('/\<br(\s*)?\/?\>/i', "",$get_course_fetch['description']) ?></textarea>
				
				<input type="number" class="num-input" name="course_fxstar" placeholder="Cost (fxStars)" id="newCost" min="0" value="<?php echo $get_course_fetch['cost'] ?>" required>
				
				<input type="submit" class="submit-btn" value="Update">
				
			      </form>

			      
			      <h3>Video</h3>
			      
			      <form method="POST"  action="file_uploader.php" enctype="multipart/form-data">
			      <p style="max-width:400px">Uploading a new video will replace the previous course video in case there is one already.</p>
                      <input name="video_up" type="file">
                      <input name="course_id" type="hidden" value="<?php echo $course_id?>">
                      <input type="submit" value="Upload" class="submit-btn">
                    </form>

<form><input type="submit" class="submit-btn" value="Delete Video"></form>

<p style="max-width:400px">You could link a video from websites like YouTube and Vimeo by embedding it here:</p>
<form id="vid-embed" autocomplete="off">
  <input type="text" class="txt-input" name="embed_link" placeholder="Copy embed link here" required>
  <input type="hidden" name="course_id" value="<?php echo $course_id?>">
  <input type="submit" class="submit-btn" value="Embed Video" id="embedBtn">
</form>
<form id="del-embed">
  <input type="hidden" name="course_id" value="<?php echo $course_id?>">
  <input type="submit" class="submit-btn" value="Remove Embed" id="delEmbedBtn">
</form>


<h3>Delete Course</h3>
<p style="max-width:400px">By deleting a course, all of the related sessions and videos will be lost permenantly, so think twice before deciding to do so.</p>
			      <form id="delCourseForm"><input type="hidden" name="course_id" value="<?php echo $course_id?>"><input type="submit" class="submit-btn" value="Delete Course"></form>
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

<!-- VIDEO EMBED -->
<script>
$('#vid-embed').submit(function(event) {
  event.preventDefault();
  console.log('Submitting...');
  jQuery.ajax({
    url:'embed.php',
    type:'POST',
    data: $(this).serialize(),
    success: function(response) {
      if(response==1) {
        $('#embedBtn').css('opacity','0.8');
        $('#embedBtn').prop('disabled',true);
	$('#embedBtn').val('Embedded');
	console.log('Embed link updated.');
      }
    }
  });
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
        $('#delEmbedBtn').css('opacity','0.8');
	$('#delEmbedBtn').prop('disabled',true);
	$('#delEmbedBtn').val('Embed removed');
	console.log('Embed link removed.');
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

</body>
</html>
