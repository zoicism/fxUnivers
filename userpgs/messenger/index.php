<?php
session_start();
require('../../register/connect.php');

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
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

if(isset($_POST['search'])) {
    $uname = $_POST['search'];

    $query = "SELECT * FROM user WHERE username LIKE '$uname%'";
    $search_result = mysqli_query($connection, $query) or die(mysqli_error($connection));
}

// fetch the first name of the user
$fname_query = "SELECT * FROM user WHERE username='$username'";
$fname_result = mysqli_query($connection, $fname_query) or die(mysqli_error($connection));
$fname_fetch = mysqli_fetch_array($fname_result);
$fname = $fname_fetch['fname'];
$lname = $fname_fetch['lname'];
$user_id = $fname_fetch['id'];

// fetch the last name of the user
/*$lname_query = "SELECT lname FROM user WHERE username='$username'";
   $lname_result = mysqli_query($connection, $lname_query) or die(mysqli_error($connection));
   $lname_fetch = mysqli_fetch_array($lname_result);
   $lname = $lname_fetch['lname'];*/

$mess_query = "SELECT id2 FROM messenger WHERE id1=$user_id UNION SELECT id1 FROM messenger WHERE id2=$user_id";
$mess_result = mysqli_query($connection, $mess_query) or die(mysqli_error($connection));
$mess_fetch = mysqli_fetch_array($mess_result);
$mess = $mess_fetch["id2"];

?>

<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Workspace</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../css/icons.css"/>
<link rel="stylesheet" type="text/css" href="../css/skinblue.css"/><!-- change skin color here -->
<link rel="stylesheet" type="text/css" href="../css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="/css/list/rotated_nav.css"/>
<link rel="stylesheet" type="text/css" href="/css/toptobottom.css"/>
<script src="/js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->
</head>
<body>
<!-- UPPER BAR -->
<section class="nav-bar">
  <div class="nav-container">
    <div class="brand">
      <div class="logoimg toplogo"></div>
    </div>
    <nav>
      <div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
      <ul class="nav-list">
        <li>
          <a href="/"><img src="/images/upperbar/home.png" style="height: 25px; width: 25px;" alt="Home"></a>
        </li>
        <li>
          <a href="/search"><img src="/images/upperbar/search.png" style="height: 25px; width: 25px;" alt="Search"></a>
        </li>
	<li>
          <a href="/userpgs/notif" id="notif_a"><img src="/images/upperbar/notif.png" style="height: 25px; width: 21px;" alt="Notifs"></a>
        </li>
        <li>
          <a href="/msg/inbox.php"><img src="/images/upperbar/message.png" style="height: 21px; width: 25px;" alt="Messages"></a>
	    <!--
	    <ul class="nav-dropdown">
            <li>
              <a href="#">test1</a>
            </li>
            <li>
              <a href="#">test2</a>
            </li>
            <li>
              <a href="#">test3</a>
            </li>
          </ul>
	  -->
        </li>
        <li>
          <a href="/register/logout.php"><img src="/images/upperbar/logout.png" style="height:21px; width: 25px;" alt="Logout" ></a>
        </li>
      </ul>
    </nav>
  </div>
</section>

<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
        <div class="row space-bot">
                <!--Logo-->
                <div class="c4">
                        <a href="../index1.html">
                                <img src="/images/logo_small.png" class="logo" alt="">
                        </a>
                </div>
                <!--Menu-->
                <div class="c8">
                        <nav id="topNav">
                        <ul id="responsivemenu">
                                <li class="active"><a href="/register/login.php"><font size="+1">SIGN IN</font><span class="showmobile">Sign Up</span></a></li>
                                <li><a href="tutorials.html">FxUniversity</a>
                                </li>
                                <ul style="display: none;">
                                </ul>
                                <li><a href="#">FxUnivers</a>
                                <ul style="display: none;">
                                        <li><a href="#">List of Traders</a></li>
                                        <li><a href="#">Top Traders</a></li>
                                        <li><a href="#">Market Sentiment</a></li>
                                        <li><a href="#">FAQ</a></li>
                                </ul>
                                </li>
                                <li><a href="#">FxPartner</a>
                                <li><a href="#">FxStar</a>
                                <li><a href="#">Tools</a>
                                <ul>
                                        <li><a href="xhttps://www.dukascopy.com/swiss/english/marketwatch/converter/currency-exchange/" target="_blank">Calculator</a></li>
                                        <li><a href="http://www.econoday.com/economic-calendar.aspx" target="_blank">Calendar</a></li>
                                        <li><a href="#">FAQ</a></li>
                                </ul>
                                </li>
                        </ul>
                        </nav>
                </div>
        </div>
</div>

<!-- LEFT PANEL
================================================== -->
<div class="undermenuarea">
        <div class="boxedshadow">
        </div>
        <div class="grid">
                <div class="row">
                        <div class="c8">
                                <h1 class="titlehead">Welcome, <?php echo $username; ?>!</h1>
                        </div>
                        <div class="c4">
                                <h1 class="titlehead rightareaheader"><i class="icon-map-marker"></i> contact@fxunivers.com</h1>
                        </div>
                </div>
        </div>
</div>

<div class="grid">
                <div class="shadowundertop">
                </div>
                <div class="row">

                        <!-- MAIN CONTENT -->
                        <div class="c9">
                                <h1 class="maintitle space-top">
                                <span>User Profile</span>
                                </h1>
				<hr class="style18">
				<div class="userpic one">
				</div>
				<hr class="style18">
				<h2><?php echo "$fname $lname"; ?></h2>
                        	
				<h3><?php echo "@$username"; ?></h3>
				
				<div id="list4">
				     <ul>
					<li><a href="/userpgs/general.php">Timeline</a></li>
				     	<li><a href="">Messenger</a></li>
				     	<li><a href="/userpgs/search.php">Search</a></li>
					<?php if($plan=="teacher") {?>
					      <li><a href="/userpgs/teacher/course_management">Courses / Tests</a></li>
					<?php } ?>
					<li><a href="">Stars</a></li>
                                     </ul>
				</div>

			</div>
			
			<!-- RIGHT BAR -->
			<div class="c3">
                                <div class="rightsidebar">
                                        <h2 class="title stresstitle">Messages</h2>
                                        <hr class="hrtitle">
					<div class="teamdescription">
					<?php
					if($mess_result->num_rows > 0) {
					?>
						<img src="/images/background/user.jpg" width="100px" height="100px" align="left">
					<?php

						echo $mess . "<br><br><br>";?><hr><?php

 						while($row = $mess_result->fetch_assoc()) {
					?>
						<img src="/images/background/user.jpg" width="100px" height="100px" align="left">
					<?php
				        		echo $row["id2"] . "<br><br><br>";
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
                                <img src="/images/logo_small.png" style="padding-top: 70px;" alt="">
                        </div>
                        <!-- 2nd column -->
                        <div class="c3">
                                <h2 class="title">(c) Copyright Details</h2>
                                <hr class="footerstress">
                                <div id="ticker" class="query">
                                </div>
                        </div>
                        <!-- 3rd column -->
                        <div class="c3">
                                <h2 class="title"><i class="icon-envelope-alt"></i> Contact</h2>
                                <hr class="footerstress">
                                <dl>
                                        <dt>New Horizon Building, Ground Floor,
                                                <br />3 1/2 Miles Philip S.W. Goldson Highway,
                                                <br />Belize City, Belize,
                                                <br />Central America</dt>
                                        <dd><span>Telephone:</span>501-223-2144</dd>
                                        <dd><span>Fax:</span>501-223-2143</dd>
                                        <dd><span>P.O. Box</span>1922</dd>
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
                                        <li class="linkedin-link smallrightmargin">
                                        <a href="#" class="linkedin has-tip" title="Linkedin" target="_blank">Linkedin</a>
                                        </li>
                                </ul>
                        </div>
                        <!-- 4th column -->
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
                        <!-- end 4th column -->
                </div>
        </div>
</div>
<!-- copyright area -->
<div class="copyright">
        <div class="grid">
                <div class="row">
                        <div class="c6">
                                 FXUNIVERS &copy; 2017. All Rights Reserved.
                        </div>
                        <div class="c6">
                                <span class="right">
                                <!-- by Milad, milad@fxunivers.com --></span>
                        </div>
                </div>
        </div>
</div>

</div>

<!-- JAVASCRIPTS
================================================== -->
<!-- all -->
<script src="/js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="/js/common.js"></script>

<!-- cycle -->
<script src="/js/jquery.cycle.js"></script>

<!-- twitter -->
<script src="/js/jquery.tweet.js"></script>

<!-- filtering -->
<script src="/js/jquery.isotope.min.js"></script>

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

