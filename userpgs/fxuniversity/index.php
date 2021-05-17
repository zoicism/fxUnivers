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
	<script>
	 if(screen.width >= 629) {
	     $(document).ready(function() {
		 $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items"><a href="/userpgs/instructor/" class="link-main"><div class="head">Teach (<?php echo $course_count ?>)</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Create unlimited courses and make fxStars as students enroll in them.</p></div></div><div class="bar-items"><a href="/userpgs/student/" class="link-main"><div class="head">Learn (<?php echo $gss_count_alive ?>)</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Enroll in courses, get certified, and start making fxStars right after by teaching.</p></div></div></div>');
		 $('.bar-items').hover(function() {
		     $(this).find('.extra-info-cnt').show();
		 }, function() {
		     $(this).find('.extra-info-cnt').hide();
		 });
	     });
	     
	 }
	</script>
	<div class="blur mobile-main">
	    
	    <div class="sidebar"></div>
	    <?php require('../../php/sidebar.php'); ?>


	    
	    <div class="relative-main-content">

		<div class="main-content-mob">

		    <ul class="main-flex-container">
			<li class="main-items">
			    <a href="/userpgs/instructor" class="link-main">
				<div class="head">Teach (<?php echo $course_count ?>)</div>
			    </a>
			</li>
			<li class="main-items">
			    <a href="/userpgs/student" class="link-main">
				<div class="head">Learn (<?php echo $gss_count_alive ?>)</div>
			    </a>
			</li>
			
		    </ul>

		</div>


		<div class="content-box">
				<h2>Courses Count</h2>
				<div class="icon-txt" style="opacity:1;font-size:1.6rem;">
				    <p><?php echo $course_count + $gss_count_alive?> courses</p>
				</div>
                </div>
		

		<div class="description">
		    <h3>How to make fxStars using fxUniversity?</h3>
		    <p>There are two ways to make fxStars:</p>
		    <ol>
			<li><p>Click on <a href="/userpgs/instructor/" ><strong>Teach</strong></a> above, create a course, and publish it for a price. As students purchase and enroll in your courses, you will gain fxStars. We have provided various tools for you to use and attract as many students as possible. What's more, each student will potentially increase your fxStars directly by creating fxSubCourses. See below to learn more.</p></li>
			<li><p>Click on <a href="/userpgs/student/" ><strong>Learn</strong></a> above, enroll in your favorite courses, and after getting the certification, start teaching your own fxSubCourses as an fxSubInstructor which helps you make fxStars very quickly. See below to learn more.</p></li>
		    </ol>

		    <h3>How to create a course?</h3>
		    <p>After you enter <a href="/userpgs/instructor/" >Teach</a> section, click on <a href="/userpgs/instructor/course_management/new_course.php">Add New Course</a>, enter a title, a description, and put a price on the course. Right after this you can publish the course, however you can also consider applying the following options to make more fxStars or to just set it as you prefer.</p>
		    <ul>
			<li>
			    <p><b>Make the course private:</b> By making a course private, you alone can send invitations to students and have them consider enrolling in the course. Remember, by making a course private, it will no show up in search results for public.</p>
			</li>
			<li>
			    <p><b>Let students create fxSubCourses:</b> By applying this option, the students who enroll in your course, and get certified by the Certification Exam, will be able to create fxSubCourses under this course. This is a profitable option in two ways; for one, more students will be attracted to enroll, since they will see a future profitibility for themselves, and secondly you will get a share of such fxSubCourses when other students enroll in them.</p>
			</li>
			<li>
			    <p><b id="fxsubcourse-hili">Make this course an fxSubCourse:</b> In case you have already enrolled in a course and obtained a certificate from, you will be able to make this course an fxSubCourse of that course.</p>
			    <p>All you need to do is to simply click on the option which will show you a list of the courses you have enrolled in, and got a certificate from. Choose one, and it will be set as an fxSubCourse.</p>
			    <p>It's profitable, because your course will be displayed at the fxCourse's page for its viewers and students.</p>
			</li>
			<li><p><b>Make the course's price Negotiable:</b> By doing so, users who are not able to pay the price in full, will be able to send you their suggested price. Then you will see a list of such propositions in your course's page as <em>Bargains</em>, which are approvable or rejectable.</p>
			</li>
		    </ul>
		    <p>By using these options you can help spread your knowledge as effectively and beneficially as possible.</p>

		    <h3>How to enroll in a course?</h3>
		    <p>You can search for courses either by entering the <a href="/userpgs/student/" >Learn</a> section or clicking on <a href="/search/" >Search</a> icon.</p>
		    <p>After enrolling in a course and passing the certification exam, if enabled by the instructor, you will be able to create your own fxSubCourses for it. This way, your course will be displayed to the viewers and students of that course, hence increasing your profits. Read the <span id="hili-fxsubcourse" style="cursor:pointer;color:blue;">Make this course and fxSubCourse</span> above to learn how to do so.</p>
		    
		    
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
	 $('#hili-fxsubcourse').click(function() {
	     $('#fxsubcourse-hili').css('background-color','lightblue');
	     setTimeout(function() {
		 $('#fxsubcourse-hili').css('background-color', 'unset');
	     }, 1000);
	 });
	</script>
	
    </body>
</html>
