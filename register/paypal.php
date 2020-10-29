<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Student Registeration</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/icons.css"/>
<link rel="stylesheet" type="text/css" href="css/slider.css"/>
<link rel="stylesheet" type="text/css" href="css/skinblue.css"/><!-- change skin color -->
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<script src="js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->

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
<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
	<div class="row space-bot">
		<!--Logo-->
		<div class="c4">
			<a href="../index1.html">
				<img src="../images/logo_small.png" class="logo" alt="">
			</a>
		</div>
		<!--Menu-->
		<div class="c8">
			<nav id="topNav">
			<ul id="responsivemenu">
				<li class="active"><a href="../register/register.php"><font size="+1">SIGN IN</font><span class="showmobile">Sign Up</span></a></li>
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
<!-- HEADER
================================================== -->
<div class="undermenuarea">
	<div class="boxedshadow">
	</div>
	<div class="grid">
		<div class="row">
			<div class="c8">
				<h1 class="titlehead">PayPal Registeration</h1>
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
				<span>PayPal Subscription</span>
				</h1>
			<!-- Registeration Form -->
			<div class="container">
				<!-- <form class="form-signin" method="POST" action="confirm.php">
					<h2 class="form-signin-heading">Register Here</h2>
					<div class="input-group">-->
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<p>Click the subscribe button below to get redirected to the PayPal subscription page.</p>
						<!-- Identify your business so that you can collect the payments. -->
						<input type="hidden" name="business" value="gohardorgohoume@gmail.com">

						<!-- Specify a Subscribe button. -->	
						<input type="hidden" name="cmd" value="_xclick-subscriptions">
						<!-- Identify the subscription. -->
						<input type="hidden" name="item_name" value="fxUnivers Registeration">
						<input type="hidden" name="item_number" value="DIG Weekly">

						<!-- Set the terms of the regular subscription. -->
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="a3" value="1.00">
						<input type="hidden" name="p3" value="1">
						<input type="hidden" name="t3" value="Y">

						<!-- Set recurring payments until canceled. -->
						<input type="hidden" name="src" value="1">

						<!-- Display the payment button. -->
						<input type="image" name="submit"
						src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_subscribe_113x26.png"
						alt="Subscribe">
						<img alt="" width="1" height="1"
						src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
					</form>

					<!--</div>
					<p><h5>Policy Agreement</h5>The agreement goes here to which the users should agree in order to be able to register</p>
					<input type="checkbox" name="agree" id="inputAgree" value="No" required>  I agree! <br /><br /><br />
					<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
					<a class="btn btn-lg btn-primary btn-block" href="login.php">Login</a>
				</form>-->
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
				<img src="../images/logo_small.png" style="padding-top: 70px;" alt="">
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
				by Milad, milad@fxunivers.com </span>
			</div>
		</div>
	</div>
</div>

</div>
<!-- JAVASCRIPTS
================================================== -->
<!-- all -->
<script src="../js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="../js/common.js"></script>

<!-- cycle -->
<script src="../js/jquery.cycle.js"></script>

<!-- twitter -->
<script src="../js/jquery.tweet.js"></script>

</body>
</html>
