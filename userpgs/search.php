<?php
session_start();
require('../register/connect.php');
header("Cache-Control: no cache");

if(isset($_POST['username']) and isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM `user` WHERE username='$username' and password='$password'";

        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        $count = mysqli_num_rows($result);

        if($count == 1) {
                $_SESSION['username'] = $username;
        } else {
                $fmsg = "invalid login credentials";
        }
}

if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
	$smsg = "Successfully logged in!";
} else {}

if(isset($_POST['search'])) {
	$uname = $_POST['search'];

	$query = "SELECT * FROM user WHERE username LIKE '$uname%'";
	$search_result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}

// fetch the first name of the user
$fname_query = "SELECT fname FROM user WHERE username='$username'";
$fname_result = mysqli_query($connection, $fname_query) or die(mysqli_error($connection));
$fname_fetch = mysqli_fetch_array($fname_result);
$fname = $fname_fetch['fname'];

// fetch the last name of the user
$lname_query = "SELECT lname FROM user WHERE username='$username'";
$lname_result = mysqli_query($connection, $lname_query) or die(mysqli_error($connection));
$lname_fetch = mysqli_fetch_array($lname_result);
$lname = $lname_fetch['lname'];

// fetch id of the user
$id_query = "SELECT id FROM user WHERE username='$username'";
$id_result = mysqli_query($connection, $id_query) or die(mysqli_error($connection));
$id_fetch = mysqli_fetch_array($id_result);
$id = $id_fetch['id'];

// fetch the plans the user is registered to
$plans_query = "SELECT * FROM plans WHERE id = $id";
$plans_result = mysqli_query($connection, $plans_query) or die(mysqli_error($connection));
$plans_fetch = mysqli_fetch_array($plans_result);
$plans_fxuniversity = $plans_fetch['fxuniversity'];
$plans_fxuniverse = $plans_fetch['fxuniverse'];
$plans_fxpartner = $plans_fetch['fxpartner'];

if(isset($_GET['plan'])) {
	$plan = $_GET['plan'];
}

// add new post to the timeline
if(isset($_POST['new_post'])) {
	$newpost = $_POST['new_post'];
	$newpost_query = "INSERT INTO sonet(uid, body) VALUES($id, '$newpost')";
	$newpost_result = mysqli_query($connection, $newpost_query) or die(mysqli_error($connection));
}

// fetch the sonet records
require('sonet/following.php');

?>

<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Workspace</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/icons.css"/>
<link rel="stylesheet" type="text/css" href="css/skinblue.css"/><!-- change skin color here -->
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="/css/list/rotated_nav.css"/>
<link rel="stylesheet" type="text/css" href="/css/toptobottom.css"/>
<script src="js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->
</head>
<body>

<!-- UPPER BAR -->
<div class="navbar">
	
	<a href="/userpgs" class="active" href="javascript:void(0)"><img src="/images/upperbar/home.png" wdith="25px" height="25px" alt="Home"></a>
	<a href="/userpgs/search.php"><img src="/images/upperbar/search.png" width="25px" height="25px" alt="Search"></a>
	<a href=""><img src="/images/upperbar/notif.png" width="25px" height="25px" alt="Notifications"></a>
	<a href=""><img src="/images/upperbar/message.png" width="25px" height="25px" alt="Messages"></a>
	<a href="/register/logout.php"><img src="/images/upperbar/logout.png" width="25px" height="25px" alt="Logout" ></a>
	<img src="/images/logo_small.png" id="logo">

	

</div>  

<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
        <div class="row space-bot">
                
        </div>
</div>

<!-- LEFT PANEL
================================================== -->
<div class="grid">
                <div class="shadowundertop">
                </div>
                <div class="row">

                        <!-- MAIN CONTENT -->
			 <div class="c9"><!--
                                <h1 class="maintitle space-top">
                                <span>User Profile</span>
                                </h1>-->
				<div class="userpic avatarr">
				</div><br/><br/>
				<h2><?php echo "$fname $lname"; ?></h2>
                        	
				<h3><?php echo "@$username"; ?></h3>

				<h7>Navigation</h7>
				<div id="list4">
				     <ul>
					<?php if($plan=="teacher") {?>
					      <li><a href="/userpgs/teacher/course_management">Courses / Tests</a></li>
					<?php } ?>
					<li><a href="/payment">Wallet</a></li>
                                     </ul>
				</div>
				<br/>
				
				<h7>Dashboards</h7>
				<div id="list4">
				     <ul>
					<li><a href="">Trader <small>[Activate!]</small></a></li>
					<li><a href="/userpgs/teacher">Instructor</a></li>
					<li><a href="">Student</a></li>
					<li><a href="">Partner <small>[Activate!]</small></a></li>
				     </ul>
				</div>

			</div>
			
			<!-- SIDEBAR -->
			<div class="c3">
                                <div class="rightsidebar">
                                        <h2 class="title stresstitle" style="color: #FFF">Search</h2>
                                        <hr class="hrtitle">
                                        <div class="teamdescription">
                                                <h1>Enter Keywords Here:</h1>
						<form method="POST" action="#">
							<input type="text" name="search" autofocus placeholder="example: search for lessons, teacher, student, etc"><br />
							<button class="btn" type="submit" value="Search">Search</button>
						</form>
                                        </div>
					<div class="teamdescription">
					<?php
					if($search_result->num_rows > 0) {                      
 						while($row = $search_result->fetch_assoc()) {
					?>
						<img src="../images/background/avatar.png" width="100px" height="100px" align="left">
					<?php
				        		echo "@" . "<a href=\"s_profile.php?user=".$row["username"]."\">" . $row["username"] . "</a>" . "<br>" . $row["fname"] . "<br>" . $row["lname"] . "<br>" . $row["bio"] . "<br><br><br>";
					?><hr><?php
						}       
					} else {
						echo "0 results";
					}
					?>
					</div>
                                </div>			
                        </div>
			<!-- end sidebar -->

                </div>

</div>

<!-- FOOTER
================================================== -->
<div id="wrapfooter">
        <div class="grid">
                <div class="row" id="footer">
                        <!-- to top button  -->
                        <p class="back-top floatright">
                                <a href="#top"><span></span></a>
                        </p>
                        <!-- 1st column -->
			<div class="c3">
                                <img src="/images/logo_small.png" style="padding-top: 20px;" height="98" width="85" alt="">
                        </div>
                        <!-- 2nd column -->
                        <div class="c3">
                                <h2 class="title"><i class="icon-envelope-alt"></i> Contact</h2>
                                <hr class="footerstress">
                                <dl>
                                        <dt>New Horizon Building, Ground Floor,
                                                <br />3 1/2 Miles Philip S.W. Goldson Highway,
                                                <br />Belize City, Belize,
                                                <br />Central America</dt>
                                        <dd>E-mail: <a href="#">contact@fxunivers.com</a></dd>
                                </dl>
                                <ul class="social-links" style="margin-top:15px;">
                                        <li class="facebook-link smallrightmargin">
                                        <a href="https://www.facebook.com/fxunivers" class="facebook has-tip" target="_blank" title="Join us on Facebook">Facebook</a>
                                        </li>
                                        <li class="linkedin-link smallrightmargin">
                                        <a href="https://www.linkedin.com/company/fxunivers/" class="linkedin has-tip" title="Linkedin" target="_blank">Linkedin</a>
                                        </li>
                                        <li class="twitter-link smallrightmargin">
                                        <a href="https://twitter.com/fxunivers" class="twitter has-tip" target="_blank" title="Follow Us on Twitter">Twitter</a>
                                        </li>
                                        <li class="google-link smallrightmargin">
                                        <a href="#" class="google has-tip" title="Google +" target="_blank">Google</a>
                                        </li>
                                </ul>
                        </div>
			<!-- 3rd column -->
                        <div class="c3">
                                <h2 class="title"><i class="icon-link"></i> Links</h2>
                                <hr class="footerstress">
                                <ul>
                                        <li>Services</li>
                                        <li>Privacy Policy</li>
                                        <li>Shortcodes</li>
                                        <li>Columns</li>
                                        <li>Portfolio</li>
                                        <li>Blog</li>
                                        <li>Font Awesome</li>
                                        <li>Single Project</li>
                                        <li>Home</li>
                                </ul>
                        </div>
                        <!-- 4th column -->
                        <div class="c3">
                                <h2 class="title">(c) Copyright Details</h2>
                                <hr class="footerstress">
                                <div id="ticker" class="query">
                                </div>
                        </div>
                        <!-- end 4th column -->
                </div>
        </div>
</div>
<!-- copyright area -->
<div class="copyright">
        <div class="grid">
		<div class="row">
                        <div class="c6">
                                With all due Reserves,
                        </div>
                </div>
                <div class="row">
                        <div class="c6">
                                 FXUNIVERS &copy; 2017. All Rights Reserved.
                        </div>
                        <div class="c6">
                                <span class="right">
                                <!-- by Milad, milad@fxunivers.com --> </span>
                        </div>
                </div>
        </div>
</div>

</div>

<!-- JAVASCRIPTS
================================================== -->
<!-- all -->
<script src="js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="js/common.js"></script>

<!-- cycle -->
<script src="js/jquery.cycle.js"></script>

<!-- twitter -->
<script src="js/jquery.tweet.js"></script>

<!-- filtering -->
<script src="js/jquery.isotope.min.js"></script>

<!-- CALL filtering & masonry-->
<script>
$(document).ready(function(){
var $container = $('#content');
  $container.imagesLoaded( function(){
        $container.isotope({
        filter: '*',
        animationOptions: {
     duration: 750,
     easing: 'linear',
     queue: false,
   }
});
});
$('#nav a').click(function(){
  var selector = $(this).attr('data-filter');
    $container.isotope({ 
        filter: selector,
        animationOptions: {
     duration: 750,
     easing: 'linear',
     queue: false,
   }
  });
  return false;
});
$('#nav a').click(function (event) {
    $('a.selected').removeClass('selected');
    var $this = $(this);
    $this.addClass('selected');
    var selector = $this.attr('data-filter');
    $container.isotope({
         filter: selector
    });
    return false; // event.preventDefault()
});
});
 </script>

 <!-- Call opacity on hover images-->
<script type="text/javascript">
$(document).ready(function(){
    $(".boxcontainer img").hover(function() {
      $(this).stop().animate({opacity: "0.6"}, 'slow');
    },
    function() {
      $(this).stop().animate({opacity: "1.0"}, 'slow');
                                                                                       289,55        97%
    });
  });
</script>
</body>
</html>

