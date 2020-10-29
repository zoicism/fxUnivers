<?php
session_start();
require('../../../register/connect.php');

if(isset($_GET['course_id'])) {
	$course_id = $_GET['course_id'];
}

$course_query = "SELECT * FROM `teacher` WHERE id=$course_id";
$course_result = mysqli_query($connection, $course_query) or die(mysqli_error($connection));
$course_fetch = mysqli_fetch_array($course_result);

$user_id = $course_fetch['user_id'];
$header = $course_fetch['header'];
$description = $course_fetch['description'];
$video = $course_fetch['video'];
$img = $course_fetch['img'];

?>

<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Course </title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/css/slider.css"/>
<link rel="stylesheet" type="text/css" href="/css/skinblue.css"/><!-- Change skin color here -->
<link rel="stylesheet" type="text/css" href="/css/responsive.css"/>
<script src="/js/jquery-1.9.0.min.js"></script><!-- scripts at the bottom of the document -->
</head>
<body>
<!-- UPPER BAR -->
<div class="navbar">
        <a href="/userpgs/general.php" class="active" href="javascript:void(0)">Home</a>
        <a href="/register/logout.php">Logout</a>
        <div class="dropdownbar">
                <button class="dropbtn">
                        <?php if($plan=="teacher") {
                                echo "Teacher";
                        } elseif($plan=="student") {
                                echo "Student";
                        } elseif($plan=="partner") {
                                echo "Partner";
                        } else {
                                echo "General User";
                        } ?>
                <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdownbar-content">
                <a href="/userpgs/general.php?plan=none">General</a>
                <?php if($plans_fxuniversity==1) { ?>
                <a href="/userpgs/general.php?plan=teacher">Teacher</a>
                <a href="/userpgs/general.php?plan=student">Student</a>
                <?php
                }
                if($plans_fxpartner==1) {
                ?>
                <a href="/userpgs/general.php?plan=partner">Partner</a>
                <?php
                }
                ?>
                </div>
        </div>
</div>
<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
        <div class="row space-bot">
                <!--Logo-->
                <div class="c4">
                        <a href="/index.php">
                                <img src="/images/logo_small.png" class="logo" alt="">
                        </a>
                </div>
                <!--Menu-->
                <div class="c8">
                        <nav id="topNav">
                        <ul id="responsivemenu">
                                <li class="active"><a href="/register/register.php"><font size="+1">SIGN IN</font><span class="showmobile">Sign Up</span></a></li>
                                <li><a href="/about/fxuniversity/fxuniversity.php">FxUniversity</a>
                                </li>
                                <li><a href="/about/fxuniverse/fxuniverse.php">FxUniverse</a>
                                </li>
                                <li><a href="/about/fxpartner/fxpartner.php">FxPartner</a>
                                <li><a href="/about/fxstar/fxstar.php">FxStar</a>
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

<!-- HEADER
================================================== -->
<div class="undermenuarea">
	<div class="boxedshadow">
	</div>
	<div class="grid">
		<div class="row">
			<div class="c8">
				<h1 class="titlehead">Single Project</h1>
			</div>
			<div class="c4">
				<h1 class="titlehead rightareaheader"><i class="icon-map-marker"></i> contact@fxunivers.com</h1>
			</div>
		</div>
	</div>
</div>
<!-- CONTENT
================================================== -->
<div class="grid">
		<div class="shadowundertop">
		</div>
		<div class="row">
			<div class="c12">
				<h1 class="maintitle ">
				<span><?php echo $header ?></span>
				</h1>
			</div>
		</div>
		<div class="row">
		
			<!-- begin description area -->
			<div class="c6">
				<p><?php echo $description ?></p>
			</div><!-- end description area -->
				
			<!-- begin slider area -->
			<div class="c6">
				<div class="flexslider">
					<ul class="slides">
						<li>
							<?php echo $video ?>
						</li>
					</ul>
				</div>
			</div><!-- end slider area -->
				
		</div>
</div><!-- end grid -->

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
                                <img src="/images/logo_small.png" style="padding-top: 20px;" alt="">
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
                                        <li class="linkedin-link smallrightmargin">
                                        <a href="#" class="linkedin has-tip" title="Linkedin" target="_blank">Linkedin</a>
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
<script src="/js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="/js/common.js"></script>

<!-- twitter -->
<script src="/js/jquery.tweet.js"></script>

<!-- cycle -->
<script src="/js/jquery.cycle.js"></script>

<!-- flexslider -->
<script src="/js/jquery.flexslider-min.js"></script>

<!-- CALL flexslder -->
<script>
// Can also be used with $(document).ready()
$(window).load(function() {
$('.flexslider').flexslider({
animation: "slide"
});
});
</script>
</body>
</html>
