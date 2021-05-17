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

		<div class="contentbox-bg fxuniversity-contentbox">
		    <svg viewBox="20 0 273.7 116.5"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M66.1,93.7v.8h7.8v-.8Z"></path><path class="cls-1" d="M159.7,99.1v.7h28.9v4.8h.7V99.1Zm0,0v.7h28.9v4.8h.7V99.1Zm0,0v.7h28.9v4.8h.7V99.1Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm-103,0v6.3H189.3V99.1Zm.8,5.5V99.8H188.6v4.8Zm102.2-5.5v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7H168v-.7Zm0,0v.7h28.9v4.8h.7V99.1Zm0,0v.7h28.9v4.8h.7V99.1Zm0,0v.7h28.9v4.8h.7V99.1Zm0,0v.7h28.9v4.8h.7V99.1Z"></path><path class="cls-1" d="M51.7,104.6v7.1H194.4v-7.1Zm.7,6.3v-5.5H193.6v5.5Z"></path><path class="cls-1" d="M47.2,110.9v5.6H198.9v-5.6Zm150.9,4.8H47.9v-4H198.1Z"></path><path class="cls-1" d="M62.6,93.7v6.1H77.4V93.7Zm.8,5.4V94.5H76.7v4.6Z"></path><path class="cls-1" d="M85.7,93.7v6.1h14.8V93.7Zm.8,5.4V94.5H99.8v4.6Z"></path><path class="cls-1" d="M144.9,93.7v6.1h14.8V93.7Zm.7,5.4V94.5h13.3v4.6Z"></path><path class="cls-1" d="M168,93.7v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v6.1h14.8V93.7Zm.8,5.4V94.5h13.3v4.6Zm-.8-5.4v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Zm0,0v5.4h.8V94.5h2.8v-.8Z"></path><path class="cls-1" d="M75.3,43.5a1.7,1.7,0,0,0-1.8,1.7c0,.1.1.2.1.3a1.1,1.1,0,0,0,.3.7,1.7,1.7,0,0,0,1.4.7,1.7,1.7,0,1,0,0-3.4Zm0,2.7a1,1,0,0,1,0-2,1,1,0,0,1,0,2Z"></path><path class="cls-1" d="M64.8,43.5a1.7,1.7,0,1,0,1.3,2.7,2.5,2.5,0,0,0,.4-.7v-.3A1.7,1.7,0,0,0,64.8,43.5Zm0,2.7a1,1,0,0,1,0-2,1,1,0,0,1,0,2Z"></path><rect class="cls-1" x="71.2" y="52.4" width="0.8" height="33.27"></rect><path class="cls-1" d="M89.3,93.7v.8H97v-.8Z"></path><path class="cls-1" d="M87.9,43.5a1.7,1.7,0,0,0,0,3.4,1.7,1.7,0,0,0,1.4-.7,1.1,1.1,0,0,0,.3-.7v-.3A1.7,1.7,0,0,0,87.9,43.5Zm0,2.7a1,1,0,1,1,1-1A1.1,1.1,0,0,1,87.9,46.2Z"></path><rect class="cls-1" x="94.4" y="52.4" width="0.8" height="33.27"></rect><path class="cls-1" d="M98.4,43.5a1.7,1.7,0,0,0-1.7,1.7v.3a1.1,1.1,0,0,0,.3.7,1.7,1.7,0,0,0,1.4.7,1.7,1.7,0,0,0,0-3.4Zm0,2.7a1,1,0,0,1,0-2,1,1,0,0,1,0,2Z"></path><path class="cls-1" d="M106.5,65.3V99.8H123V65.3Zm.7,33.8v-33h15v33Z"></path><rect class="cls-1" x="118.8" y="79.5" width="0.8" height="4.21"></rect><path class="cls-1" d="M122.7,3.8,72.4,30.7H173.1Zm0,.9,47.4,25.2H75.4Z"></path><path class="cls-1" d="M106.5,49.3V62.6H123V49.3Zm15.7,12.5h-15V50.1h15Z"></path><path class="cls-1" d="M171.6,93.7v.8h7.7v-.8Z"></path><path class="cls-1" d="M170.2,43.5a1.7,1.7,0,1,0,0,3.4,1.9,1.9,0,0,0,1.4-.7l.3-.7v-.3A1.7,1.7,0,0,0,170.2,43.5Zm0,2.7a1,1,0,0,1,0-2,1,1,0,0,1,0,2Z"></path><path class="cls-1" d="M180.7,43.5a1.7,1.7,0,0,0-1.8,1.7c0,.1.1.2.1.3a1.1,1.1,0,0,0,.3.7,1.5,1.5,0,0,0,1.4.7,1.7,1.7,0,1,0,0-3.4Zm0,2.7a1,1,0,0,1,0-2,1,1,0,0,1,0,2Z"></path><rect class="cls-1" x="176.6" y="52.4" width="0.8" height="33.27"></rect><path class="cls-1" d="M148.4,93.7v.8h7.7v-.8Z"></path><path class="cls-1" d="M147,43.5a1.7,1.7,0,0,0,0,3.4,1.7,1.7,0,0,0,1.4-.7,1.1,1.1,0,0,0,.3-.7v-.3A1.6,1.6,0,0,0,147,43.5Zm0,2.7a1,1,0,0,1,0-2,1,1,0,0,1,0,2Z"></path><rect class="cls-1" x="153.5" y="52.4" width="0.8" height="33.27"></rect><path class="cls-1" d="M266.4,17.3H155.1L122.8.1h-.2L90.3,17.3H0V18H88.9L77.2,24.3H0V25H75.8l-4.2,2.3H0V28H70.2l-8.8,4.7H54l4.8,3.7V43h3.5a3.1,3.1,0,0,0-.8,2.2,3.3,3.3,0,0,0,3.3,3.3,3.1,3.1,0,0,0,1.3-.3V93.7h.8v-46a3.1,3.1,0,0,0,1-1.5h4.2a4,4,0,0,0,1,1.5v46h.8V48.2a3.2,3.2,0,0,0,1.4.3,3.3,3.3,0,0,0,3.3-3.3,3.2,3.2,0,0,0-.9-2.2h7.8a2.8,2.8,0,0,0-.9,2.2,3.3,3.3,0,0,0,3.3,3.3,3.2,3.2,0,0,0,1.4-.3V93.7H90v-46a3.1,3.1,0,0,0,1-1.5h4.3a3.8,3.8,0,0,0,.9,1.5v46H97V48.2a3.2,3.2,0,0,0,1.4.3,3.3,3.3,0,0,0,3.3-3.3,2.8,2.8,0,0,0-.9-2.2h43.8a3.2,3.2,0,0,0-.9,2.2,3.3,3.3,0,0,0,3.3,3.3,3.2,3.2,0,0,0,1.4-.3V93.7h.8v-46a2.9,2.9,0,0,0,.9-1.5h4.3a3.1,3.1,0,0,0,1,1.5v46h.7V48.2a3.5,3.5,0,0,0,1.4.3,3.3,3.3,0,0,0,3.3-3.3,2.8,2.8,0,0,0-.9-2.2h7.8a3.1,3.1,0,0,0-.8,2.2,3.3,3.3,0,0,0,3.3,3.3,3.5,3.5,0,0,0,1.4-.3V93.7h.7v-46a3.1,3.1,0,0,0,1-1.5h4.2a4,4,0,0,0,1,1.5v46h.8V48.2a3.2,3.2,0,0,0,1.4.3,3.3,3.3,0,0,0,3.3-3.3,3.2,3.2,0,0,0-.9-2.2h3.6V36.4l4.7-3.7h-7.3L175.2,28h93v87.7H198.9v.8h70V25h4.8ZM77.8,45.2a2.5,2.5,0,0,1-2.5,2.5,2.3,2.3,0,0,1-1.4-.4,3,3,0,0,1-.8-.8l-.2-.3c-.1-.2-.1-.5-.2-.7H67.3a1.9,1.9,0,0,1-.2.7c-.1.1-.1.3-.2.4a2.7,2.7,0,0,1-.8.7,2,2,0,0,1-1.3.4A2.5,2.5,0,0,1,63.5,43h13A2.4,2.4,0,0,1,77.8,45.2Zm23.2,0a2.6,2.6,0,0,1-2.6,2.5,2.3,2.3,0,0,1-1.4-.4,3,3,0,0,1-.8-.8c0-.1-.1-.2-.1-.3a1.9,1.9,0,0,1-.2-.7H90.4a1.9,1.9,0,0,1-.2.7l-.2.4a2.3,2.3,0,0,1-.7.7,2.3,2.3,0,0,1-1.4.4,2.5,2.5,0,0,1-2.5-2.5A2.4,2.4,0,0,1,86.7,43H99.6A2.5,2.5,0,0,1,101,45.2Zm59.1,0a2.6,2.6,0,0,1-2.6,2.5,2.3,2.3,0,0,1-1.4-.4,2.3,2.3,0,0,1-.7-.7c-.1-.1-.1-.3-.2-.4a1.9,1.9,0,0,1-.2-.7h-5.5a1.9,1.9,0,0,1-.2.7c0,.1-.1.2-.1.3a3,3,0,0,1-.8.8,2.3,2.3,0,0,1-1.4.4,2.5,2.5,0,0,1-2.5-2.5,2.4,2.4,0,0,1,1.3-2.2h12.9A2.5,2.5,0,0,1,160.1,45.2Zm23.1,0a2.5,2.5,0,0,1-2.5,2.5,2.3,2.3,0,0,1-1.4-.4,2.7,2.7,0,0,1-.8-.7.8.8,0,0,0-.2-.4c-.1-.2-.1-.5-.2-.7h-5.4a1.9,1.9,0,0,1-.2.7l-.2.3a2.7,2.7,0,0,1-.7.8,2.3,2.3,0,0,1-1.4.4,2.5,2.5,0,0,1-1.3-4.7h13A2.4,2.4,0,0,1,183.2,45.2Zm2.7-3H59.5V36.7H185.9Zm3.3-8.7L186,35.9H59.4l-3.2-2.4Zm-6.7-.8H62.9L71.8,28l.9-.5L77.4,25l.4-.2L90.5,18l.7-.3L122.7.9l31.5,16.8.7.3,12.7,6.8.5.2,4.6,2.5,1,.5Zm85.7-5.4H173.8L169.7,25h98.5Zm-100-3L156.5,18H266.1l5.8,6.3ZM0,116.5H46.6v-.8H0Z"></path><path class="cls-1" d="M157.5,43.5a1.7,1.7,0,0,0-1.7,1.7v.3l.3.7a1.7,1.7,0,0,0,1.4.7,1.7,1.7,0,1,0,0-3.4Zm0,2.7a1,1,0,0,1,0-2,1,1,0,0,1,0,2Z"></path><path class="cls-1" d="M122.2,65.3V99.8H139V65.3Zm.8,33.8v-33h15.2v33Z"></path><rect class="cls-1" x="125.9" y="79.5" width="0.8" height="4.21"></rect><path class="cls-1" d="M122.2,49.3V62.6H139V49.3Zm16,12.5H123V50.1h15.2Z"></path><path class="cls-1" d="M122.9,8a6.6,6.6,0,1,0,6.6,6.5A6.5,6.5,0,0,0,122.9,8Zm0,12.4a5.9,5.9,0,1,1,5.9-5.9A5.8,5.8,0,0,1,122.9,20.4Z"></path><path class="cls-1" d="M125,17.4c-.1,0-.3-.1-.3-.2l-2.1-2.5V10.3a.3.3,0,0,1,.3-.3c.3,0,.4.1.4.3v4.1l1.9,2.3a.4.4,0,0,1,0,.6Z"></path><path class="cls-1" d="M100.5,22.4v4.4A1.7,1.7,0,0,1,100,28a1.7,1.7,0,0,1-1.3.5A1.7,1.7,0,0,1,97,26.8V22.4h-.5v4.5a2,2,0,0,0,.6,1.5,2.3,2.3,0,0,0,1.6.6,2.1,2.1,0,0,0,1.2-.3,1.9,1.9,0,0,0,.8-.7,2.4,2.4,0,0,0,.3-1.2V22.4Z"></path><path class="cls-1" d="M107.3,22.4v5.5l-3.7-5.5H103v6.5h.6V23.4l3.7,5.5h.5V22.4Z"></path><path class="cls-1" d="M110,22.4v6.5h.6V22.4Z"></path><path class="cls-1" d="M116.9,22.4l-2.1,5.7h0l-2.1-5.7h-.5l2.4,6.5h.5l2.4-6.5Z"></path><path class="cls-1" d="M119.5,28.4V25.8h3v-.5h-3V22.9h3.4v-.5h-4v6.5h4v-.5Z"></path><path class="cls-1" d="M127.5,26.1l1-.7a2,2,0,0,0,.3-1.1,1.8,1.8,0,0,0-.6-1.4,2.3,2.3,0,0,0-1.6-.5h-2.1v6.5h.6V26.2H127l1.5,2.7h.6Zm-.7-.4h-1.7V22.9h1.5a1.6,1.6,0,0,1,1.2.4,1.2,1.2,0,0,1,.5,1,1.5,1.5,0,0,1-.4,1A1.5,1.5,0,0,1,126.8,25.7Z"></path><path class="cls-1" d="M134.8,26.4l-.7-.6-1.3-.5a3.2,3.2,0,0,1-1.3-.5,1.2,1.2,0,0,1-.4-.8,1.1,1.1,0,0,1,.5-.9,2.1,2.1,0,0,1,2.3.1,1.4,1.4,0,0,1,.5,1.1h.5a1.6,1.6,0,0,0-.2-1,2.7,2.7,0,0,0-.8-.7,2.4,2.4,0,0,0-1.2-.3,2.5,2.5,0,0,0-1.5.5,1.5,1.5,0,0,0,0,2.4,2.6,2.6,0,0,0,1.5.6,4.8,4.8,0,0,1,1.4.6,1.2,1.2,0,0,1,.3.9,1.1,1.1,0,0,1-.4.9,2.6,2.6,0,0,1-2.6-.1,1.4,1.4,0,0,1-.5-1.1h-.5a1.7,1.7,0,0,0,.3,1,1.4,1.4,0,0,0,.8.7,2.9,2.9,0,0,0,2.9-.2,1.4,1.4,0,0,0,.6-1.2A2.9,2.9,0,0,0,134.8,26.4Z"></path><path class="cls-1" d="M136.8,22.4v6.5h.5V22.4Z"></path><path class="cls-1" d="M138.8,22.4v.5H141v6h.6v-6h2.2v-.5Z"></path><path class="cls-1" d="M149.2,22.4l-1.9,3.5-2-3.5h-.6l2.3,4v2.5h.6V26.4l2.3-4Z"></path><path class="cls-1" d="M192.7,35.5V47.3h17.4V35.5Zm8.6,11.1h-7.8V36.3h7.8Zm8,0H202V40.1h7.3Zm0-7.3H202v-3h7.3Z"></path><path class="cls-1" d="M219.3,35.5V47.3h17.4V35.5Zm8.6,11.1h-7.8V36.3h7.8Zm8,0h-7.3V40.1h7.3Zm0-7.3h-7.3v-3h7.3Z"></path><path class="cls-1" d="M245.4,35.5V47.3h17.4V35.5ZM254,46.6h-7.8V36.3H254Zm8,0h-7.2V40.1H262Zm0-7.3h-7.2v-3H262Z"></path><path class="cls-1" d="M192.7,56.7V68.5h17.4V56.7Zm8.6,11h-7.8V57.5h7.8Zm8,0H202V61.2h7.3Zm0-7.2H202v-3h7.3Z"></path><path class="cls-1" d="M219.3,56.7V68.5h17.4V56.7Zm8.6,11h-7.8V57.5h7.8Zm8,0h-7.3V61.2h7.3Zm0-7.2h-7.3v-3h7.3Z"></path><path class="cls-1" d="M245.4,56.7V68.5h17.4V56.7Zm8.6,11h-7.8V57.5H254Zm8,0h-7.2V61.2H262Zm0-7.2h-7.2v-3H262Z"></path><path class="cls-1" d="M192.7,77.9V89.6h17.4V77.9Zm8.6,11h-7.8V78.6h7.8Zm8,0H202V82.4h7.3Zm0-7.3H202v-3h7.3Z"></path><path class="cls-1" d="M219.3,77.9V89.6h17.4V77.9Zm8.6,11h-7.8V78.6h7.8Zm8,0h-7.3V82.4h7.3Zm0-7.3h-7.3v-3h7.3Z"></path><path class="cls-1" d="M245.4,77.9V89.6h17.4V77.9Zm8.6,11h-7.8V78.6H254Zm8,0h-7.2V82.4H262Zm0-7.3h-7.2v-3H262Z"></path><path class="cls-1" d="M35.4,35.5V47.3H52.7V35.5Zm8,11.1H36.1V40.1h7.3Zm0-7.3H36.1v-3h7.3ZM52,46.6H44.1V36.3H52Z"></path><path class="cls-1" d="M8.8,35.5V47.3H26.1V35.5Zm8,11.1H9.5V40.1h7.3Zm0-7.3H9.5v-3h7.3Zm8.6,7.3H17.5V36.3h7.9Z"></path><path class="cls-1" d="M35.4,56.7V68.5H52.7V56.7Zm8,11H36.1V61.2h7.3Zm0-7.2H36.1v-3h7.3ZM52,67.7H44.1V57.5H52Z"></path><path class="cls-1" d="M8.8,56.7V68.5H26.1V56.7Zm8,11H9.5V61.2h7.3Zm0-7.2H9.5v-3h7.3Zm8.6,7.2H17.5V57.5h7.9Z"></path><path class="cls-1" d="M35.4,77.9V89.6H52.7V77.9Zm8,11H36.1V82.4h7.3Zm0-7.3H36.1v-3h7.3ZM52,88.9H44.1V78.6H52Z"></path><path class="cls-1" d="M8.8,77.9V89.6H26.1V77.9Zm8,11H9.5V82.4h7.3Zm0-7.3H9.5v-3h7.3Zm8.6,7.3H17.5V78.6h7.9Z"></path></svg>
		    <div class="content-box">
			<div class="contentbox-word">Courses Count</div>
			<div class="icon-txt" style="opacity:1;font-size:1.6rem;">
			    <p><?php echo $course_count + $gss_count_alive?> courses</p>
			</div>
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
