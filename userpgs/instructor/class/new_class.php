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

require('../../../php/get_plans.php');
require('../../../php/get_rel.php');
require('../../../wallet/php/get_fxcoin_count.php');

require('../../../php/get_course.php');
require('../../../php/get_user_type.php');
if($user_type!='instructor') {
    header("Location: /");
    
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
	     $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/instructor/" class="link-main" id="active-main"><div class="head">Teach</div></a></div><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/student/" class="link-main"><div class="head">Learn</div></a></div></div>');
	 });
     }
    </script>
<div class="blur mobile-main">
    
	<div class="sidebar"></div>
	<?php require('../../../php/sidebar.php'); ?>






<div class="relative-main-content">
	<div class="inner-content-box add-session-box">
		<div class="add-session-con">
			<h2>Add Session</h2>
			<form method="POST" action="new_post.php" autocomplete="off">
				<input type="text" name="header" class="txt-input" placeholder="Session title" required>
				<textarea name="description" placeholder="Session description (optional)" rows="10"></textarea>
				<input type="hidden" name="course_id" value="<?php echo $course_id ?>">
				<input type="submit" value="Publish" class="submit-btn">
                	</form>
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

</body>
</html>
