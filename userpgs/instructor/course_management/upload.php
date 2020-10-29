<?php
session_start();
require('../../../register/connect.php');

$prev = $_GET['prev'];
if(isset($_SESSION['username'])) {
	$logged_in=true;
}
?>

<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Course Management</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/css/slider.css"/>
<link rel="stylesheet" type="text/css" href="/css/skinblue.css"/><!-- change skin color -->
<link rel="stylesheet" type="text/css" href="/css/responsive.css"/>
<script src="/js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->

<style>
	.bottom-left {
		position: fixed;
		bottom: 40px;
		left: 20px;
		height: 5%;
		width: 5%;
	}

	.alert {
		background: transparent;
		border: none;
	}

	.align-mid {
		left: 50%;
		transform: translateX(-50%);
	}

</style>

</head>
<body>
<?php
if(isset($_SESSION['username'])) {
?>
<div class="navbar">
        <a href="/userpgs/general.php">Home</a>
        <a href="/register/logout.php">Logout</a>
        <div class="dropdownbar">
                <button class="dropbtn">General User
                <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdownbar-content">
                <a href="/userpgs/general.php">General</a>
                </div>
        </div>
</div>
<?php
}
?>
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
                                <li class="active"><a href="/register/login.php?prev=fxuniversity"><font size="+1">SIGN IN</font><span class="showmobile"></span></a></li>
                                <li><a href="/about/fxuniversity/fxuniversity.php">FxUniversity</a>
                                </li>
                                <ul style="display: none;">
                                </ul>
                                <li><a href="/about/fxuniverse/fxuniverse.php">FxUniverse</a></li>
                                <li><a href="/about/fxpartner/fxpartner.php">FxPartner</a>
                                <li><a href="/about/fxstar/fxstar.php">FxStar</a>
                                <li><a href="">Tools</a>
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
				<h1 class="titlehead">Course Upload</h1>
			</div>
			<div class="c4">
				<h1 class="titlehead rightareaheader"><i class="icon-map-marker"></i> contact@fxunivers.com
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
			
			<!-- MAIN CONTENT -->
			<div class="c9">
				<h1 class="maintitle space-top">
				<span>Course Upload</span>
				</h1>

			<!-- Registeration Form -->
			<div class="container">
				<form class="form-signin" method="POST" action="new_post.php">
					<h2 class="form-signin-heading"></h2>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Course Subject</span>
						<input type="text" name="header" class="form-control" required autofocus>
						<span class="input-group-addon" id="basic-addon1">Description</span>
						<textarea name="description" class="form-control" rows="33" required></textarea>
						<span class="input-group-addon" id="basic-addon1">Paste the embedded link here:</span>
						<input type="text" name="video" class="from-control">
						<span class="input-group-addon" id="basic-addon1">Images to Upload</span>
						<input type="text" name="img" class="from-control">
					</div>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Post</button>
				</form>
			</div>



			</div><!-- end main content -->
			
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

</body>
</html>
