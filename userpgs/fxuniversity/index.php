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

<style>
  @media(max-width:629px) {
  .header-sidebar {
  margin:0;
  }
}
</style>

    </head>
    
    <body>
	<div class="header-sidebar"></div>
	<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
	<script>
	 if(screen.width >= 629) {
	     $(document).ready(function() {
		 $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/instructor/" class="link-main"><div class="head">Teach (<?php echo $course_count ?>)</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Create unlimited courses and make fxStars as students enroll in them.</p></div></div><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/student/" class="link-main"><div class="head">Learn (<?php echo $gss_count_alive ?>)</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Enroll in courses, get certified, and start making fxStars right after by teaching.</p></div></div></div>');
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


		<div class="contentbox-bg fxuniversity-contentbox">
		    <svg viewBox="0 25 273.7 116.5"><defs><style>.cls-1{fill:#efefef;}</style></defs><title>fxuniversity1</title><path d="M85.6,90.4v.7h6.9v-.7Z"/><path d="M170.3,95.2v.7h26.2v4.4h.7V95.2Zm0,0v.7h26.2v4.4h.7V95.2Zm0,0v.7h26.2v4.4h.7V95.2Zm0,0v.7h26.2v4.4h.7V95.2Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7ZM77,95.2V101H197.2V95.2Zm.7,5.1V95.9H196.5v4.4Zm92.6-5.1v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h26.2v4.4h.7V95.2Zm0,0v.7h26.2v4.4h.7V95.2Zm0,0v.7h26.2v4.4h.7V95.2Z"/><path d="M72.4,100.3v6.4H201.8v-6.4Zm.7,5.7v-5h128v5Z"/><path d="M68.4,106v5H205.9v-5Zm136.8,4.3H69.1v-3.6H205.2Z"/><path d="M82.4,90.4v5.5H95.8V90.4Zm.6,4.8V91.1H95.1v4.1Z"/><path d="M103.3,90.4v5.5h13.4V90.4Zm.7,4.8V91.1h12.1v4.1Z"/><path d="M156.9,90.4v5.5h13.4V90.4Zm.7,4.8V91.1h12.1v4.1Z"/><path d="M177.9,90.4v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v5.5h13.4V90.4Zm.7,4.8V91.1h12v4.1Zm-.7-4.8v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Z"/><path d="M93.8,44.8a1.6,1.6,0,0,0-1.5,1.6v.2a1.4,1.4,0,0,0,.2.7,1.7,1.7,0,0,0,1.3.7,1.6,1.6,0,1,0,0-3.2Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,93.8,47.3Z"/><path d="M84.3,44.8a1.6,1.6,0,1,0,0,3.2,1.7,1.7,0,0,0,1.3-.7,1.4,1.4,0,0,0,.2-.7c.1,0,.1-.1.1-.2A1.6,1.6,0,0,0,84.3,44.8Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,84.3,47.3Z"/><rect x="90.1" y="52.9" width="0.7" height="30.15"/><path d="M106.5,90.4v.7h7v-.7Z"/><path d="M105.3,44.8a1.6,1.6,0,1,0,0,3.2,1.5,1.5,0,0,0,1.2-.7.9.9,0,0,0,.3-.7v-.2A1.6,1.6,0,0,0,105.3,44.8Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,105.3,47.3Z"/><rect x="111.1" y="52.9" width="0.7" height="30.15"/><path d="M114.8,44.8a1.6,1.6,0,0,0-1.6,1.6c0,.1,0,.2.1.2a1.4,1.4,0,0,0,.2.7,1.7,1.7,0,0,0,1.3.7,1.6,1.6,0,1,0,0-3.2Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,114.8,47.3Z"/><path d="M122.1,64.7V95.9h15V64.7Zm14.3,30.5H122.8V65.3h13.6Z"/><rect x="133.3" y="77.5" width="0.7" height="3.82"/><path d="M136.8,8.9,91.2,33.2h91.3ZM93.9,32.6,136.8,9.7l43,22.9Z"/><path d="M122.1,50.1V62.2h15V50.1Zm14.3,11.4H122.8V50.8h13.6Z"/><path d="M181.1,90.4v.7h7v-.7Z"/><path d="M179.8,44.8a1.6,1.6,0,1,0,1.3,2.5c.2-.2.2-.4.3-.7v-.2A1.6,1.6,0,0,0,179.8,44.8Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,179.8,47.3Z"/><path d="M189.4,44.8a1.6,1.6,0,0,0-1.6,1.6v.2l.3.7a1.7,1.7,0,0,0,1.3.7,1.6,1.6,0,0,0,0-3.2Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,189.4,47.3Z"/><rect x="185.7" y="52.9" width="0.7" height="30.16"/><path d="M160.1,90.4v.7h7v-.7Z"/><path d="M158.8,44.8a1.6,1.6,0,0,0,0,3.2,1.4,1.4,0,0,0,1.3-.7.9.9,0,0,0,.3-.7v-.2A1.6,1.6,0,0,0,158.8,44.8Zm0,2.5a.9.9,0,0,1,0-1.8.9.9,0,1,1,0,1.8Z"/><rect x="164.7" y="52.9" width="0.7" height="30.15"/><path d="M267.1,21.1H166.2L136.9,5.5h-.2L107.4,21.1H6.6L0,28.1H4.3V111H67.8v-.7H5V30.8H89.2l-8,4.3H74.6l4.3,3.3v6h3.2a2.8,2.8,0,0,0-.8,2,2.9,2.9,0,0,0,3,3,3.1,3.1,0,0,0,1.3-.3V90.4h.6V48.7a2.6,2.6,0,0,0,.9-1.4H91a3,3,0,0,0,.9,1.3V90.4h.6V49.1a3.1,3.1,0,0,0,1.3.3,2.9,2.9,0,0,0,3-3,2.8,2.8,0,0,0-.8-2h7.1a2.8,2.8,0,0,0-.8,2,2.9,2.9,0,0,0,3,3,2.7,2.7,0,0,0,1.2-.3V90.4h.7V48.7a3.4,3.4,0,0,0,.9-1.4H112a2.2,2.2,0,0,0,.8,1.3V90.4h.7V49.1a2.8,2.8,0,0,0,1.3.3,2.9,2.9,0,0,0,3-3,2.8,2.8,0,0,0-.8-2h39.7a2.8,2.8,0,0,0-.8,2,2.9,2.9,0,0,0,2.9,3,2.8,2.8,0,0,0,1.3-.3V90.4h.7V48.6a3,3,0,0,0,.9-1.3h3.9a2.2,2.2,0,0,0,.9,1.4V90.4h.6V49.1a2.8,2.8,0,0,0,1.3.3,3,3,0,0,0,3-3,2.8,2.8,0,0,0-.8-2h7a3.2,3.2,0,0,0-.7,2,2.9,2.9,0,0,0,2.9,3,2.8,2.8,0,0,0,1.3-.3V90.4h.7V48.7a4.2,4.2,0,0,0,.9-1.4h3.8a3.4,3.4,0,0,0,.9,1.4V90.4h.7V49.1a2.8,2.8,0,0,0,1.3.3,3,3,0,0,0,3-3,2.9,2.9,0,0,0-.9-2h3.3v-6l4.3-3.3h-6.7l-8-4.3h84.3v79.5H205.9v.7h63.5V28.1h4.3ZM1.6,27.5l5.3-5.7h99.3L95.5,27.5ZM5,30.2V28.1H94.3l-3.8,2.1ZM96.1,46.4a2.3,2.3,0,0,1-2.3,2.3,2.2,2.2,0,0,1-1.3-.4c-.2-.2-.5-.4-.6-.7l-.2-.3a6.4,6.4,0,0,1-.2-.7H86.6a1.4,1.4,0,0,1-.2.7.8.8,0,0,1-.2.4,1.7,1.7,0,0,1-.6.6,2,2,0,0,1-1.3.4,2.3,2.3,0,0,1-1.1-4.3H94.9A2.3,2.3,0,0,1,96.1,46.4Zm21,0a2.3,2.3,0,0,1-2.3,2.3,2,2,0,0,1-1.3-.4,2.3,2.3,0,0,1-.7-.7c0-.1-.1-.2-.1-.3a1.4,1.4,0,0,1-.2-.7h-4.9a6.4,6.4,0,0,1-.2.7c-.1.1-.1.3-.2.4s-.4.5-.7.6a1.7,1.7,0,0,1-1.2.4,2.3,2.3,0,0,1-1.1-4.3h11.7A2.3,2.3,0,0,1,117.1,46.4Zm53.6,0a2.3,2.3,0,0,1-2.3,2.3,2,2,0,0,1-1.3-.4,1.7,1.7,0,0,1-.6-.6.8.8,0,0,1-.2-.4,1.4,1.4,0,0,1-.2-.7h-5a1.5,1.5,0,0,1-.1.7l-.2.3a2.3,2.3,0,0,1-.7.7,1.8,1.8,0,0,1-1.3.4,2.2,2.2,0,0,1-2.2-2.3,2.1,2.1,0,0,1,1.2-2h11.7A2.3,2.3,0,0,1,170.7,46.4Zm21,0a2.3,2.3,0,0,1-2.3,2.3,2,2,0,0,1-1.3-.4c-.3-.1-.5-.4-.7-.6s-.1-.3-.1-.4a1.4,1.4,0,0,1-.2-.7h-5a1.4,1.4,0,0,1-.2.7.4.4,0,0,1-.1.3,2.3,2.3,0,0,1-.7.7,2,2,0,0,1-1.3.4,2.3,2.3,0,0,1-2.3-2.3,2.3,2.3,0,0,1,1.2-2h11.8A2.3,2.3,0,0,1,191.7,46.4Zm2.4-2.7H79.5v-5H194.1Zm3-7.9L194.2,38H79.4l-2.8-2.2Zm-6.1-.7H82.7l7.9-4.3.9-.4,4.2-2.3.4-.2,11.5-6.1.6-.3L136.8,6.2l28.6,15.3.6.3,11.6,6.1.3.2,4.3,2.3.8.4Zm77.7-4.9H183.2l-3.8-2.1h89.3Zm-90.6-2.7-10.6-5.7h99.3l5.3,5.7Z"/><path d="M168.4,44.8a1.6,1.6,0,0,0-1.6,1.6v.2l.3.7a1.7,1.7,0,0,0,1.3.7,1.6,1.6,0,0,0,0-3.2Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,168.4,47.3Z"/><path d="M136.4,64.7V95.9h15.2V64.7Zm14.5,30.5H137.1V65.3h13.8Z"/><rect x="139.7" y="77.5" width="0.7" height="3.82"/><path d="M136.4,50.1V62.2h15.2V50.1Zm14.5,11.4H137.1V50.8h13.8Z"/><path d="M137,12.7a5.8,5.8,0,0,0-5.9,5.9,5.9,5.9,0,0,0,5.9,6,6,6,0,0,0,6-6A5.9,5.9,0,0,0,137,12.7Zm0,11.2a5.3,5.3,0,1,1,5.3-5.3A5.2,5.2,0,0,1,137,23.9Z"/><path d="M138.9,21.2l-.3-.2-1.9-2.3V14.8a.3.3,0,0,1,.3-.3c.2,0,.4.1.4.3v3.7l1.7,2.1a.4.4,0,0,1,0,.5Z"/><path d="M116.7,25.8v3.9a1.7,1.7,0,0,1-.5,1.2,1.7,1.7,0,0,1-2.2,0,1.7,1.7,0,0,1-.5-1.2V25.8H113v4a2,2,0,0,0,.6,1.4,2.5,2.5,0,0,0,1.5.5l1.1-.2.7-.7a3.8,3.8,0,0,0,.3-1v-4Z"/><path d="M122.8,25.8v5l-3.3-5H119v5.8h.5v-5l3.3,5h.5V25.8Z"/><path d="M125.3,25.8v5.8h.5V25.8Z"/><path d="M131.5,25.8l-1.8,5.1h-.1l-1.8-5.1h-.5l2.1,5.8h.5l2.2-5.8Z"/><path d="M133.9,31.2V28.8h2.7v-.4h-2.7V26.2H137v-.4h-3.6v5.8H137v-.4Z"/><path d="M141.2,29.1a1.6,1.6,0,0,0,.8-.6,1.3,1.3,0,0,0,.4-1,1.5,1.5,0,0,0-.6-1.3,2,2,0,0,0-1.4-.4h-1.9v5.8h.5V29.2h1.7l1.4,2.4h.5Zm-.7-.3H139V26.2h1.4a2,2,0,0,1,1.1.3,1.8,1.8,0,0,1,.4,1,1.3,1.3,0,0,1-.4.9A1.8,1.8,0,0,1,140.5,28.8Z"/><path d="M147.7,29.4a1,1,0,0,0-.6-.5,3.5,3.5,0,0,0-1.2-.5,2.3,2.3,0,0,1-1.1-.5,1,1,0,0,1-.4-.7,1.2,1.2,0,0,1,.4-.8,2,2,0,0,1,1.1-.3,1.4,1.4,0,0,1,1.1.4,1,1,0,0,1,.4.9h.5a2.9,2.9,0,0,0-.2-.9l-.7-.6-1.1-.2a2.1,2.1,0,0,0-1.4.4,1.3,1.3,0,0,0-.5,1.1,1.2,1.2,0,0,0,.5,1.1l1.4.6a2.3,2.3,0,0,1,1.2.5,1,1,0,0,1,.4.8,1,1,0,0,1-.5.8,2.1,2.1,0,0,1-2.3-.1,1.1,1.1,0,0,1-.4-1h-.5a3,3,0,0,0,.2,1l.8.6,1.1.2a2.4,2.4,0,0,0,1.5-.4,1.4,1.4,0,0,0,.6-1.1A1.1,1.1,0,0,0,147.7,29.4Z"/><path d="M149.6,25.8v5.8h.5V25.8Z"/><path d="M151.4,25.8v.4h2v5.4h.5V26.2h2v-.4Z"/><path d="M160.9,25.8,159.1,29l-1.8-3.2h-.6l2.1,3.6v2.2h.5V29.4l2.1-3.6Z"/><path d="M200.3,37.7V48.3H216V37.7Zm7.8,9.9H201V38.3h7.1Zm7.2,0h-6.6V41.8h6.6Zm0-6.5h-6.6V38.3h6.6Z"/><path d="M224.4,37.7V48.3h15.7V37.7Zm7.8,9.9h-7.1V38.3h7.1Zm7.3,0h-6.6V41.8h6.6Zm0-6.5h-6.6V38.3h6.6Z"/><path d="M248.1,37.7V48.3h15.7V37.7Zm7.7,9.9h-7.1V38.3h7.1Zm7.3,0h-6.6V41.8h6.6Zm0-6.5h-6.6V38.3h6.6Z"/><path d="M200.3,56.8V67.5H216V56.8Zm7.8,10H201V57.5h7.1Zm7.2,0h-6.6V60.9h6.6Zm0-6.5h-6.6V57.5h6.6Z"/><path d="M224.4,56.8V67.5h15.7V56.8Zm7.8,10h-7.1V57.5h7.1Zm7.3,0h-6.6V60.9h6.6Zm0-6.5h-6.6V57.5h6.6Z"/><path d="M248.1,56.8V67.5h15.7V56.8Zm7.7,10h-7.1V57.5h7.1Zm7.3,0h-6.6V60.9h6.6Zm0-6.5h-6.6V57.5h6.6Z"/><path d="M200.3,76V86.7H216V76Zm7.8,10H201V76.7h7.1Zm7.2,0h-6.6V80.1h6.6Zm0-6.6h-6.6V76.7h6.6Z"/><path d="M224.4,76V86.7h15.7V76Zm7.8,10h-7.1V76.7h7.1Zm7.3,0h-6.6V80.1h6.6Zm0-6.6h-6.6V76.7h6.6Z"/><path d="M248.1,76V86.7h15.7V76Zm7.7,10h-7.1V76.7h7.1Zm7.3,0h-6.6V80.1h6.6Zm0-6.6h-6.6V76.7h6.6Z"/><path d="M57.6,37.7V48.3H73.4V37.7Zm8,.6h7.1v9.3H65.6Zm-7.3,3.5h6.6v5.8H58.3Zm0-3.5h6.6v2.8H58.3Z"/><path d="M33.5,37.7V48.3H49.3V37.7Zm8,.6h7.1v9.3H41.5Zm-7.3,3.5h6.6v5.8H34.2Zm0-3.5h6.6v2.8H34.2Z"/><path d="M9.9,37.7V48.3H25.6V37.7Zm7.9.6h7.1v9.3H17.8Zm-7.3,3.5h6.6v5.8H10.5Zm0-3.5h6.6v2.8H10.5Z"/><path d="M57.6,56.8V67.5H73.4V56.8Zm8,.7h7.1v9.3H65.6Zm-7.3,3.4h6.6v5.9H58.3Zm0-3.4h6.6v2.8H58.3Z"/><path d="M33.5,56.8V67.5H49.3V56.8Zm8,.7h7.1v9.3H41.5Zm-7.3,3.4h6.6v5.9H34.2Zm0-3.4h6.6v2.8H34.2Z"/><path d="M9.9,56.8V67.5H25.6V56.8Zm7.9.7h7.1v9.3H17.8Zm-7.3,3.4h6.6v5.9H10.5Zm0-3.4h6.6v2.8H10.5Z"/><path d="M57.6,76V86.7H73.4V76Zm8,.7h7.1V86H65.6Zm-7.3,3.4h6.6V86H58.3Zm0-3.4h6.6v2.7H58.3Z"/><path d="M33.5,76V86.7H49.3V76Zm8,.7h7.1V86H41.5Zm-7.3,3.4h6.6V86H34.2Zm0-3.4h6.6v2.7H34.2Z"/><path d="M9.9,76V86.7H25.6V76Zm7.9.7h7.1V86H17.8Zm-7.3,3.4h6.6V86H10.5Zm0-3.4h6.6v2.7H10.5Z"/></svg>
		    <div class="content-box">
			<div class="contentbox-word">Courses Count</div>
			<div class="icon-txt" style="opacity:1;font-size:1.6rem;">
			    <p><?php echo $course_count + $gss_count_alive?> courses</p>
			</div>
                    </div>

		</div>
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
		

		<div class="description fxuniversity-desc-cnt">
		    <h3 class="fxuniversity-desc question-header1" style="cursor:pointer">How to make fxStars using fxUniversity?</h3>
		    <div class="answer-header1" style="display:none">
		    <p>There are two ways to make fxStars:</p>
		    <ol>
			<li><p>1. Click on <a href="/userpgs/instructor/" >Teach</a> above, create a course, and publish it for a price. As students purchase and enroll in your courses, you will gain fxStars. We have provided various tools for you to use and attract as many students as possible. What's more, each student will potentially increase your fxStars directly by creating fxSubCourses. See below to learn more.</p></li>
			<li><p>2. Click on <a href="/userpgs/student/" >Learn</a> above, enroll in your favorite courses, and after getting the certification, start teaching your own fxSubCourses as an fxSubInstructor which helps you make fxStars very quickly. See below to learn more.</p></li>
		    </ol>
            </div>
            
            
		    <h3 class="question-header2" style="cursor:pointer">How to create a course?</h3>
		    <div class="answer-header2" style="display:none" >
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
            </div>



		    <h3 class="question-header3" style="cursor:pointer">How to enroll in a course?</h3>
		    <div class="answer-header3" style="display:none">
		    <p>You can search for courses either by entering the <a href="/userpgs/student/" >Learn</a> section or clicking on <a href="/search/" >Search</a> icon.</p>
		    <p>After enrolling in a course and passing the certification exam, if enabled by the instructor, you will be able to create your own fxSubCourses for it. This way, your course will be displayed to the viewers and students of that course, hence increasing your profits. Read the <span id="hili-fxsubcourse" style="cursor:pointer;color:blue;">Make this course and fxSubCourse</span> above to learn how to do so.</p>
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

    <script>
        $('.question-header1').click(function() {
            $('.answer-header1').slideToggle();
        });
        $('.question-header2').click(function() {
            $('.answer-header2').slideToggle();
        });
        $('.question-header3').click(function() {
            $('.answer-header3').slideToggle();
        });
    </script>
	
    </body>
</html>
