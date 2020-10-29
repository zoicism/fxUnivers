<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
    }*/

session_start();
require('../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
        header("Location: /register/logout.php");
}

$user_query = "SELECT * FROM user WHERE username='$username'";
$user_result = mysqli_query($connection, $user_query) or die(mysqli_error($connection));
$user_fetch = mysqli_fetch_array($user_result);
$fname = $user_fetch['fname'];
$lname = $user_fetch['lname'];
$id = $user_fetch['id'];
//$bio = $user_fetch['bio'];

// add new post to the timeline
if(isset($_POST['new_post'])) {
        $raw_newpost = nl2br($_POST['new_post']);
        $newpost = mysqli_real_escape_string($connection, $raw_newpost);
        $newpost_query = "INSERT INTO sonet(uid, body) VALUES($id, '$newpost')";
        $newpost_result = mysqli_query($connection, $newpost_query) or die(mysqli_error($connection));
}

// fetch the sonet records
//require('sonet/following.php');
// Get the notification!
require('php/notif.php');
// Get the plans!
$get_user_id=$id;
require('../php/get_plans.php');
require('../php/get_rel.php');
require('../wallet/php/get_fxcoin_count.php');
//require('../php/get_likes_dislikes.php');
require('../php/get_partner.php');

require('instructor/php/courses.php');
require('../php/get_stu_stucourse.php');
?>



<!DOCTYPE html>
<html>

<head>
<title>fxUnivers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display\
=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/icons.css">
 <!--   <link rel="stylesheet" href="/css/logo.css">-->
    <link rel="stylesheet" href="/css/colors.css">
<!--    <link rel="stylesheet" href="/css/avatar.css">-->
    <script src="/js/jquery-3.4.1.min.js"></script>
  <link rel="stylesheet" href="/css/styles.css">
</head>

<body>

	<div class="header"></div>
  <script src="/js/upperbar.js"></script>


<section>
                <ul class="flex-container height-18">
                        <li class="items" >
                            <?php
                    $path="avatars/";
                    if(file_exists($path.$get_user_id.'.jpg')) {
                        echo('<a class="link avatar" style="background-image: url(\'avatars/'.$get_user_id.'.jpg\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.jpeg')) {
                        echo('<a class="link avatar" style="background-image: url(\'avatars/'.$get_user_id.'.jpeg\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.png')) {
                        echo('<a class="link avatar" style="background-image: url(\'avatars/'.$get_user_id.'.png\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.gif')) {
                        echo('<a class="link avatar" style="background-image: url(\'avatars/'.$get_user_id.'.gif\');"></a>');
                    } else {
                        echo('<a class="link avatar"></a>');
                    }
                ?>
                                <a class="id" href="#"><?php echo '@'.$username?></a>
                        </li>
                </ul>
        </section>

  <?php
                $pTotal=0;
                while($row=$get_partner_result->fetch_assoc()) {
                    $pTotal+=$row['income'];
                }
?>  
	

	<section style="margin-bottom:50px">
		<ul class="flex-container">
			<li class="items">
                                <a href="/wallet" class="link">
                                        <div class="head">fxStar
                                         <p class="sub"><?php echo $get_fxcoin_count?> fxStars</p>
                                        </div>
                                </a>
                        </li>
                        <li class="items">
                                <a href="/userpgs/fxuniversity" class="link">
                                        <div class="head">fxUniversity
                                         <p class="sub"><?php echo $course_count+$gss_count?> courses</p>
                                        </div>
                                </a>
                        </li>
                        <li class="items">
                                <a href="/userpgs/partner" class="link">
                                        <div class="head">fxPartner
                                                <p class="sub"><?php echo $pTotal ?> fxStars</p>
                                        </div>
                                </a>
                        </li>
                        <li class="items">
                                <a onclick="coming()" class="link">
                                        <div class="head">fxUniverse
                                                <p class="sub">coming soon</p>
                                        </div>
                                </a>
                        </li>
                        <li class="items">
                                <a onclick="coming()" class="link">
                                        <div class="head">fxSonet
                                                <p class="sub">coming soon</p>
                                        </div>
                                </a>
                        </li>
		</ul>
                    
	</section>

<div class="footer"></div>
<script src="/js/footer.js"></script>

                    
<div class="footbar"></div>
<script src="/js/footbar.js"></script>

<script>
function coming() {
    alert('Coming soon for public!');
}
</script>

                    
</body>
</html>
