<?php
session_start();
require('../register/connect.php');

if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
	$smsg = "Successfully logged in!";
} else {
	echo "could not get the username!";
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
?>

<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Workspace</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/skinblue.css"/><!-- change skin color here -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="/css/list/rotated_nav.css"/>
<link rel="stylesheet" type="text/css" href="/css/toptobottom.css"/>

<script src="/js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->

<!-- Load the required checkout.js script -->
<script src="https://www.paypalobjects.com/api/checkout.js" data-version-4></script>
<!-- Load the required Braintree components. --> 
<script src="https://js.braintreegateway.com/web/3.39.0/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.39.0/js/paypal-checkout.min.js"></script>
<script>
paypal.Button.render({
  braintree: braintree,
  // Other configuration
}, '#id-of-element-where-paypal-button-will-render');
</script>

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
               
                
        </div>
</div>

<!-- LEFT PANEL
================================================== -->


<div class="grid">
                <div class="shadowundertop">
                </div>
                <div class="row">

                        <!-- LEFT SIDE -->
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
					<li><a href="" style="color: #BDCFE0; background-color: #425362;">Wallet</a></li>
                                     </ul>
				</div>
				<br/>
				
				<h7>Dashboards</h7>
				<div id="list4">
				     <ul>
					<li><a href="">Trader <small>[Activate!]</small></a></li>
					<li><a href="">Instructor</a></li>
					<li><a href="">Student</a></li>
					<li><a href="">Partner <small>[Activate!]</small></a></li>
				     </ul>
				</div>

			</div>

			<!-- RIGHT SIDE -->
			<div class="c3">
			    <h2 class="title stresstitle">Wallet</h2>
			    <hr class="hrtitle">
			    

			<table border="1" style="padding-top: 1px; padding-bottom: 1px;">

			<tr class="bottomtopless">
			<th style="width: 50%">Get fxStars</th>
			<th style="width: 50%">Make fxStars</th>
			</tr>
			<tr style="border-bottom: 1px solid #c8c8c8" class="bottomtopless"><td>
			

			  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			  <input type="hidden" name="cmd" value="_s-xclick">
			  <input type="hidden" name="hosted_button_id" value="L9HBR677FNWL6">
			  <table>
			    <tr><td><input type="hidden" name="on0" value="Enter number of fxStars &#128966;">Enter number of fxStars &#128966;</td></tr><tr><td><input type="text" name="os0" maxlength="200"></td></tr>
			  </table>
			  <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			  <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			  </form>


			
			</td>

			<td class="leftborder">

			  <ul class="disc">
			    <li><a href="/userpgs/teacher">As an Instructor</a></li>
			    <li><a href="/userpgs/partner">As a Partner</a></li>
			    <li><a href="/userpgs/trader">As a Signal Provider</a></li>
			  </ul>

			</td>
			
			</tr>

			<tr>
			<th style="width: 50%">Request fxStars</th>
			<th style="width: 50%">Send fxStars</h6></th>
			</tr>

			<tr style="border-bottom: 1px solid #c8c8c8" class="bottomtopless">

			<td>

			You can only request fxStars from a friend! Click the button below to get redirected to your list of friends to whom you can issue a request.<br><br>
			<button class="btn"><font color="#FFF">See Friends</font></button>

			</td>


			<td class="leftborder">

			You can send fxStars to any account you wish by filling out a form to which you will be redirected by clicking on the button below. The requirements are the username of the recipient and the number of fxStars you wish to dispatch.<br><br>
			<button class="btn"><font color="#FFF">Send fxStars</font></button>

			</td>
			</tr>

			<tr>
			<th style="width: 50%">Take Courses</th>
			<th style="width: 50%">Forex Account</th>
			</tr>
			<tr style="border-bottom: 1px solid #c8c8c8" class="bottomtopless" >
			<td>
			Register as a student and take courses from the top instructors worldwide and become a pro trader! Click the following botton to be taken to the student page!<br><br>
			<button class="btn"><font color="#FFF">Student Dashboard</font></button>
			</td>
			<td class="leftborder">
			Open real Forex account! (Coming soon)
			</td>
			</tr>


			<table>

			<tr>
			<th style="width: 100%">Cash out</th>
			</tr>
			
			<tr style="border-bottom: 1px solid #c8c8c8" class="bottomtopless">

			<td>The minimum number of fxStars that you can cash out are &#128966;100. Select one of the following methods in order to do so.
			<ul class="disc">
			  <li><a href="">PayPal</a> (Coming soon)</a></li>
			  <li><a href="">BTC</a> (Click to request)</li>
			  <li><a href="">SWIFT International / IBAN / ACH</a> (Click to request)</li>
			  <li><a href="">Other Cryptocurrencies</a> (Request now)
			    <blockquote>Please describe your requested cryptocurrency type and full procedure of approval.</blockquote>
			  </li>
			  <li><a href="">Other Assets</a>
			    <blockquote>Please describe your requested non-disposable asset type and full procedure of approval.</blockquote>
			</td>

			</tr>

			</table>
 			</div>	


                        

		<div class="c33">

		</div>

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
                                <img src="/images/logo_small.png" style="padding-top: 20px;" alt="" width="75" height="98">
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
				<!-- by Milad <milad@fxunivers.com> --> </span>
			</div>
		</div>
	</div>
</div>

<!-- fixed footer -->


<!-- JAVASCRIPTS
================================================== -->
<!-- all -->
<script src="js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="js/common.js"></script>

<!-- slider -->
<script src="js/jquery.cslider.js"></script>

<!-- cycle -->
<script src="js/jquery.cycle.js"></script>

<!-- carousel items -->
<script src="js/jquery.carouFredSel-6.0.3-packed.js"></script>

<!-- twitter -->
<script src="js/jquery.tweet.js"></script>

<!-- Call Showcase - min:4 and max:4 is the range of the items i want 2b visible -->
<script type="text/javascript">
$(window).load(function(){			
			$('#recent-projects').carouFredSel({
				responsive: true,
				width: '100%',
				auto: true,
				circular	: true,
				infinite	: false,
				prev : {
					button		: "#car_prev",
					key			: "left",
						},
				next : {
					button		: "#car_next",
					key			: "right",
							},
				swipe: {
					onMouse: true,
					onTouch: true
					},
				scroll : 2000,
				items: {
					visible: {
						min: 4,
						max: 4
					}
				}
			});
		});	
</script>

<!-- Call opacity on hover images from carousel-->
<script type="text/javascript">
$(document).ready(function(){
    $("img.imgOpa").hover(function() {
      $(this).stop().animate({opacity: "0.6"}, 'slow');
    },
    function() {
      $(this).stop().animate({opacity: "1.0"}, 'slow');
