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
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
    //header("Location: /register/logout.php");
}

$user_query = "SELECT * FROM user WHERE username='$username'";
$user_result = mysqli_query($connection, $user_query) or die(mysqli_error($connection));
$user_fetch = mysqli_fetch_array($user_result);
$fname = $user_fetch['fname'];
$lname = $user_fetch['lname'];
$id = $user_fetch['id'];
//$bio = $user_fetch['bio'];
$verified = $user_fetch['verified'];
$session_avatar=$user_fetch['avatar'];
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
  <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
<div class="mobile-main blur">

<section>
                <ul class="flex-container height-18">
                        <li class="items" >
                            <?php
			    $avatar_path=$_SERVER['DOCUMENT_ROOT'];
                    $avatar_path.='/userpgs/avatars/';
		    $avatar_ex = glob($avatar_path.$get_user_id.'.*');
		    if(count($avatar_ex) > 0) {
		      $avatar_arr = explode('.', $avatar_ex[0]);
		      $avatar_extension = end($avatar_arr);

		      echo '<a href="/user/'.$username.'" class="link avatar" style="background-image:url(\'/userpgs/avatars/'.$get_user_id.'.'.$avatar_extension.'\');"></a>';
		    } else {
		      echo '<a href="/user/'.$username.'" class="link avatar"></a>';
		    }
                ?>
  <a class="id" href="/user?tar=<?php echo $username?>"><?php echo '@'.$username?> <?php if($verified) echo '<img src="/images/background/verified.png" style="height:1.5rem; width:1.5rem">'; ?></a>
                        </li>
                </ul>
        </section>

  <?php
                $pTotal=0;
                while($row=$get_partner_result->fetch_assoc()) {
                    $pTotal+=$row['income'];
                }
?>  
	

	<section>
		<ul class="flex-container">
			<li class="items">
                                <a href="/wallet" class="link" id="fxwallet-link">
                                    <div class="head"><div class="in-icon" ><img src="/images/icons/platforms/fxstar.svg" ></div>fxStar
					<div class="icon-txt" >
					    <div class="fxstar-price"></div>
                                            <p class="sub"><?php echo $get_fxcoin_count?></p>
                                        </div>
				    </div>
                                </a>
                        </li>
                        <li class="items">
                            <a href="/userpgs/fxuniversity" class="link" id="fxuniversity-link" >
				<div class="head"><div class="in-icon"><img src="/images/icons/platforms/fxuniversity.svg" ></div>fxUniversity
				    <div class="icon-txt" >
				        <p class="sub"><?php echo $course_count+$gss_count?> courses</p>
				    </div>
                                </div>
                            </a>
                        </li>
                        <li class="items">
                            <a href="/userpgs/partner" class="link" id="fxpartner-link">
				<div class="head"><div class="in-icon" ><img src="/images/icons/platforms/fxpartner.svg" ></div>fxPartner
				    <div class="icon-txt">
					<div class="fxstar-price"></div>
                                        <p class="sub"><?php echo $pTotal ?></p>
				    </div>
                                </div>
                            </a>
                        </li>
                        <li class="items">
                                <a onclick="coming()" class="link" id="fxuniverse-link">
                                    <div class="head"><div class="in-icon" ><img src="/images/icons/platforms/fxuniverse.svg" ></div>fxUniverse
					<div class="icon-txt">
                                            <p class="sub">coming soon</p>
					</div>
                                    </div>
                                </a>
                        </li>
                        <li class="items">
                                <a onclick="coming()" class="link" id="fxsonet-link">
                                    <div class="head"><div class="in-icon" ><img src="/images/icons/platforms/fxsonet.svg" ></div>fxSonet
					<div class="icon-txt">
                                            <p class="sub">coming soon</p>
					</div>
                                    </div>
                                </a>
                        </li>
		</ul>
                    
	</section>
</div>

<div class="footer"></div>


<!-- SCRIPTS -->

<script src="/js/footer.js"></script>
<script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>
                    
<div class="footbar blur"></div>
<script src="/js/footbar.js"></script>

<script>
function coming() {
    alert('Coming soon for public!');
}
</script>


<script>

$('#page-header').html('fxUnivers');
$('#page-header').attr('href','/');
</script>

<script>
  $('#nav-home .filled').show();
  $('#nav-home .stroked').hide();
</script>

<script>
 var fxwalletB4 = $('#fxwallet-link').html();
 $('#fxwallet-link').hover(function() {
     $(this).html('<div class="icon-txt"><p class="sub">Buy fxStars and use them to purchase courses or send/receive them securely among friends</p></div>');
 }, function() {
     $(this).html(fxwalletB4);
 });

 var fxuniversityB4 = $('#fxuniversity-link').html();
 $('#fxuniversity-link').hover(function() {
     $(this).html('<div class="icon-txt"><p class="sub">Create and sell courses or enroll and learn</p></div>');
 }, function() {
     $(this).html(fxuniversityB4);
 });

 var fxpartnerB4 = $('#fxpartner-link').html();
 $('#fxpartner-link').hover(function() {
     $(this).html('<div class="icon-txt"><p class="sub">Make easy money by partnering with us in interests. Click to learn more</p></div>');
 }, function() {
     $(this).html(fxpartnerB4);
 });

 var fxuniverseB4 = $('#fxuniverse-link').html();
 $('#fxuniverse-link').hover(function() {
     $(this).html('<div class="icon-txt"><p class="sub">Universe of Forex Trading, coming soon</p></div>');
 }, function() {
     $(this).html(fxuniverseB4);
 });

 var fxsonetB4 = $('#fxsonet-link').html();
 $('#fxsonet-link').hover(function() {
     $(this).html('<div class="icon-txt"><p class="sub">Social network to make direct money from; coming soon</p></div>');
 }, function() {
     $(this).html(fxsonetB4);
 });
</script>
</body>
</html>
