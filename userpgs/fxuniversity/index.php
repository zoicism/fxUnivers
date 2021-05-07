<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
   $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   header("Location: $url");
   exit;
   }*/
session_start();
require('../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    require('../../php/get_user.php');
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

require('../instructor/php/courses.php');
require('../../php/get_stu_stucourse.php');


$gss_count_alive = 0;
if($gss_count > 0) {
    while($taken_row=$gss_result->fetch_assoc()) {
	$taken_course_id=$taken_row['course_id'];
        $get_stus_course_query="SELECT * FROM teacher WHERE id=$taken_course_id";
        $get_stus_course_result=mysqli_query($connection,$get_stus_course_query) or die(mysqli_error($connection));
        $gsc_fetch=mysqli_fetch_array($get_stus_course_result);
	if($gsc_fetch['alive'] == 1) {
	    $gss_count_alive++;
	}
    }
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
	<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
	<div class="blur mobile-main">
    
	<div class="sidebar"></div>
	<?php require('../../php/sidebar.php'); ?>

    <div class="main-content">

              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/userpgs/instructor" class="link-main">
                          <div class="head">Teach (<?php echo $course_count ?>)</div>
                      </a>
		      <div class="extra-info-cnt" style="display:none">
			  <p class="extra-info">Create unlimited courses and make fxStars as students enroll in them.</p>
		      </div>
                  </li>
                  <li class="main-items">
                      <a href="/userpgs/student" class="link-main">
                          <div class="head">Learn (<?php echo $gss_count_alive ?>)</div>
                      </a>
		      <div class="extra-info-cnt" style="display:none">
			  <p class="extra-info">Enroll in courses, get certified, and start making fxStars right after by teaching.</p>
		      </div>
                  </li>
                  
              </ul>

    </div>

	
  <div class="relative-main-content">
  <!--                          <div class="content-box">
			    	 <h2>fxUniversity</h2>
                              	 <p>Teaching: <strong></strong></p>
				 <p>Learning: <strong></strong></p>
                            </div>
-->


<div class="main-content-mob">

<ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/userpgs/instructor" class="link-main">
                          <div class="head">Teach (<?php echo $course_count ?>)</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/userpgs/student" class="link-main">
                          <div class="head">Learn (<?php echo $gss_count ?>)</div>
                      </a>
                  </li>
                  
              </ul>

</div>





			    <div class="description">
			    <h3>Options</h3>
			    <p><strong>Teach:</strong> Create courses, put a price on your courses, and gain fxStars as users purchase them.</p>
			    <p><strong>Learn:</strong> Purchase courses with your fxStars and learn from various courses.</p>
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

<script>
 $('.main-items').hover(function() {
     $(this).find('.extra-info-cnt').css('width',$(this).css('width')).show();
 }, function() {
     $(this).find('.extra-info-cnt').hide();
 });
</script>
</body>
</html>
