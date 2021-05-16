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
                            <a href="/userpgs/fxuniversity" class="link fxuniversity-bg" id="fxuniversity-link" >
				<div class="inner-element">
					<div class="head" id="main-info">
					    <div class="in-icon">
						<svg viewBox="0 0 16 16"><defs><style>.cls-1 {fill: #393939;}</style></defs><path class="cls-1" d="M15.6,3.9,8.2.3H7.8L.4,3.9c-.3.1-.2.7.2.7H15.4C15.8,4.6,15.9,4,15.6,3.9Z"/><path class="cls-1" d="M13.5,13.7H2.5L.2,14.9A.6.6,0,0,0,.6,16H15.4a.6.6,0,0,0,.4-1.1Z"/><rect class="cls-1" x="2.5" y="6.3" width="1.7" height="5.69" transform="translate(6.7 18.3) rotate(180)"/><rect class="cls-1" x="11.8" y="6.3" width="1.7" height="5.69" transform="translate(25.3 18.3) rotate(180)"/><rect class="cls-1" x="7.1" y="6.3" width="1.7" height="5.69" transform="translate(16 18.3) rotate(180)"/></svg>
					    </div>
					    <div class="head-txt">fxUniversity</div>
					    <div class="icon-txt" >
						<p class="sub"><?php echo $course_count+$gss_count_alive?> courses</p>
					    </div>
					</div>
				 </div>
				<div class="icon-txt" style="display:none" id="extra-info"><p class="sub">Create and sell courses or enroll and learn</p></div>
                            </a>
                </li>
		<li class="items">
                            <a href="/userpgs/partner" class="link fxpartner-bg" id="fxpartner-link">
				<div class="inner-element">
					<div class="head" id="main-info">
					    <div class="in-icon" >
						<svg viewBox="0 0 16 16"><defs><style>.cls-1 {fill: #393939;}</style></defs><path class="cls-1" d="M16,3.1V9a.9.9,0,0,1-.9.9h-.7V9.1a.9.9,0,0,0-.3-.6L10.8,5.1,9.6,3.9,7.5,5H6.9a1.3,1.3,0,0,1-1.2-.8,1.3,1.3,0,0,1,.6-1.7l1.9-.9.6-.3.4-.2h.7l1.5.6h0l2.2.9,1.2-.4A.9.9,0,0,1,16,3.1Z"/><path class="cls-1" d="M12.5,9.7a3.1,3.1,0,0,1-.5,1L8.5,14.1a2.3,2.3,0,0,1-3,.1L.8,9.9H0V2.8a.9.9,0,0,1,.9-.9H4.6a2.9,2.9,0,0,0-.5,3.2l.6.8a3.2,3.2,0,0,0,2,.8h.9L8,6.4l1.3-.6h0l3,3.1A.8.8,0,0,1,12.5,9.7Z"/></svg>
					    </div>
					    <div class="head-txt">fxPartner</div>
					    <div class="icon-txt">
						<div class="fxstar-price">
						    <svg viewBox="0 0 16 16"><defs><style>.cls-1 {fill: #393939;</style></defs><path class="cls-1" d="M15.3,5.6l-4.5-.7L8.8.8A.9.9,0,0,0,7.2.8l-2,4.1L.7,5.6A.8.8,0,0,0,.3,7l3.2,3.2-.8,4.5a.9.9,0,0,0,1.3.9l4-2.1,4,2.1a.9.9,0,0,0,1.3-.9l-.8-4.5L15.7,7A.8.8,0,0,0,15.3,5.6ZM9.8,6.8H9A1.1,1.1,0,0,0,7.9,8v.5H9.8v1.7H7.9v1.7H6.2V8a2.3,2.3,0,0,1,.2-1.2A2.8,2.8,0,0,1,9,5.1h.8Z"/></svg>
						</div>
						<p class="sub"><?php echo $pTotal ?></p>
					    </div>
					</div>
				 </div>
				<div class="icon-txt" style="display:none" id="extra-info" ><p class="sub">Make easy money by partnering with us in interests. Click to learn more</p></div>
                            </a>
                </li>
		<li class="items">
                                <a href="/wallet" class="link fxstar-bg">
				    <div class="inner-element">
					    <div class="head" id="main-info">
						<div class="in-icon" >
						    <svg viewBox="0 0 16 16"><defs><style>.cls-1 {fill: #393939;</style></defs><path class="cls-1" d="M15.3,5.6l-4.5-.7L8.8.8A.9.9,0,0,0,7.2.8l-2,4.1L.7,5.6A.8.8,0,0,0,.3,7l3.2,3.2-.8,4.5a.9.9,0,0,0,1.3.9l4-2.1,4,2.1a.9.9,0,0,0,1.3-.9l-.8-4.5L15.7,7A.8.8,0,0,0,15.3,5.6ZM9.8,6.8H9A1.1,1.1,0,0,0,7.9,8v.5H9.8v1.7H7.9v1.7H6.2V8a2.3,2.3,0,0,1,.2-1.2A2.8,2.8,0,0,1,9,5.1h.8Z"/></svg>
						</div>
						<div class="head-txt">fxStar</div>
						<div class="icon-txt" >
						    <div class="fxstar-price">
							<svg viewBox="0 0 16 16"><defs><style>.cls-1 {fill: #393939;</style></defs><path class="cls-1" d="M15.3,5.6l-4.5-.7L8.8.8A.9.9,0,0,0,7.2.8l-2,4.1L.7,5.6A.8.8,0,0,0,.3,7l3.2,3.2-.8,4.5a.9.9,0,0,0,1.3.9l4-2.1,4,2.1a.9.9,0,0,0,1.3-.9l-.8-4.5L15.7,7A.8.8,0,0,0,15.3,5.6ZM9.8,6.8H9A1.1,1.1,0,0,0,7.9,8v.5H9.8v1.7H7.9v1.7H6.2V8a2.3,2.3,0,0,1,.2-1.2A2.8,2.8,0,0,1,9,5.1h.8Z"/></svg>
						    </div>
						    <p class="sub"><?php echo $get_fxcoin_count?></p>
						</div>
					    </div>
				     </div>
				    <div class="icon-txt" style="display:none" id="extra-info"><p class="sub">Buy fxStars and use them to purchase courses or send/receive them securely among friends</p></div>
                                </a>
                        </li>
                        
                        
                        <li class="items">
                                <a onclick="coming()" class="link fxuniverse-bg" id="fxuniverse-link">
				    <div class="inner-element">
					    <div class="head" id="main-info">
						<div class="in-icon" >
						    <svg viewBox="0 0 16 16"><defs><style>.cls-1 {fill: #393939;}</style></defs><path class="cls-1" d="M4.4,4.7,1.1,4A8,8,0,0,1,7.8,0C6.3.2,5,2,4.4,4.7Z"/><path class="cls-1" d="M9.9,4.8H6.1C6.6,2.9,7.5,1.7,8,1.7S9.4,2.9,9.9,4.8Z"/><path class="cls-1" d="M14.9,4a23.6,23.6,0,0,1-3.3.7C11,2,9.7.2,8.2,0A8,8,0,0,1,14.9,4Z"/><path class="cls-1" d="M4.1,9.7a20.2,20.2,0,0,0-3.7.7A6.4,6.4,0,0,1,0,8,6.1,6.1,0,0,1,.4,5.6a20.2,20.2,0,0,0,3.7.7A9.7,9.7,0,0,0,4,8,9.7,9.7,0,0,0,4.1,9.7Z"/><path class="cls-1" d="M7.8,16a8,8,0,0,1-6.7-4l3.3-.7C5,14,6.3,15.8,7.8,16Z"/><path class="cls-1" d="M8,14.3c-.5,0-1.4-1.2-1.9-3.1H9.9C9.4,13.1,8.5,14.3,8,14.3Z"/><path class="cls-1" d="M5.8,9.5A7.6,7.6,0,0,1,5.7,8a7.6,7.6,0,0,1,.1-1.5h4.4A7.6,7.6,0,0,1,10.3,8a7.6,7.6,0,0,1-.1,1.5H5.8Z"/><path class="cls-1" d="M11.6,11.3a23.6,23.6,0,0,1,3.3.7,8,8,0,0,1-6.7,4C9.7,15.8,11,14,11.6,11.3Z"/><path class="cls-1" d="M16,8a7.3,7.3,0,0,1-.4,2.5,14.3,14.3,0,0,0-3.7-.8A9.7,9.7,0,0,0,12,8a9.7,9.7,0,0,0-.1-1.7,14.3,14.3,0,0,0,3.7-.8A6.9,6.9,0,0,1,16,8Z"/></svg>
						</div>
						<div class="head-txt>fxUniverse</div>
						<div class="icon-txt">
						    <p class="sub">coming soon</p>
						</div>
					    </div>
					</div>
				    <div class="icon-txt" style="display:none" id="extra-info"><p class="sub">Universe of Forex Trading, coming soon</p></div>
                                </a>
                        </li>
                        <li class="items">
                                <a onclick="coming()" class="link fxsonet-bg" id="fxsonet-link">
				    <div class="inner-element">
					    <div class="head" id="main-info">
						<div class="in-icon" >
						    <svg viewBox="0 0 16 16"><defs><style>.cls-1 {fill: #393939;}</style></defs><path class="cls-1" d="M16,12a3.1,3.1,0,0,0-3.1-3.1H12L10.3,6.1A3,3,0,0,0,11.1,4,3.1,3.1,0,0,0,4.9,4a3,3,0,0,0,.8,2.1L4,9H3.1A3.1,3.1,0,0,0,0,12a3.1,3.1,0,0,0,3.1,3.1A3.1,3.1,0,0,0,6.2,12a3,3,0,0,0-.8-2.1L7.2,7l.8.2L8.9,7l1.7,2.9A3,3,0,0,0,9.8,12,3.1,3.1,0,1,0,16,12Z"/></svg>
						</div>
						<div class="head-txt">fxSonet</div>
						<div class="icon-txt">
						    <p class="sub">coming soon</p>
						</div>
					    </div>
					</div>
				    <div class="icon-txt" style="display:none" id="extra-info"><p class="sub">A trading social network for traders; coming soon</p></div>
				    
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
 $('.link').hover(function() {
     $(this).find('#main-info').hide();
     $(this).find('#extra-info').show();
 }, function() {
     $(this).find('#extra-info').hide();
     $(this).find('#main-info').show();
 });
</script>


</body>
</html>
