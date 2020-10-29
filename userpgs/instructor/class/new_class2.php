<?php
session_start();
require('../../../register/connect.php');

$username = $_SESSION['username'];

if(isset($_GET['course_id'])) {
  $course_id = $_GET['course_id'];
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
					<li><a href="/payment">Wallet</a></li>
                                     </ul>
				</div>
				<br/>
				
				<h7>Dashboards</h7>
				<div id="list4">
				     <ul>
					<li><a href="">Trader <small>[Activate!]</small></a></li>
					<li><a href="" style="color: #BDCFE0; background-color: #425362;">Instructor</a></li>
					<li><a href="">Student</a></li>
					<li><a href="">Partner <small>[Activate!]</small></a></li>
				     </ul>
				</div>

			</div>

			<!-- RIGHT SIDE -->
			<div class="c3-1">
			     <div class="rightsidebar">
			     	  <h2 class="title stresstitle">New Class</h2>
				  <hr class="hrtitle">

				  <div class="container">
				       <form class="form-signin" method="POST" action="new_post.php">
				       	     <h2 class="form-signin-heading"></h2>
				       	     <div class="input-group">
				       	    <span class="input-group-addon" id="basic-addon1">Title</span>
					    <input type="text" name="header" class="form-control" required autofocus>
					    <span class="input-group-addon" id="basic-addon1">Body</span>
					    <textarea name="description" class="form-control" rows="13" required></textarea>
					    <span class="input-group-addon" id="basic-addon1">Video Embed</span>
					    <input type="text" name="video" class="from-control" required>
					    In order to add your class video, upload it on YouTube, Vimeo, or any other video-streaming website and paste the embedded link here.
					    <input type="hidden" name="course_id" value="<?php echo $course_id ?>" />
				       	    </div>
				       	    <button class="btn btn-lg btn-primary btn-block" type="submit"><font color="#FFF">Post</font></button>
				       </form>
				  </div>
			     </div>
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
                                <img src="/images/logo_small.png" style="padding-top: 20px;" height="98" width="75" alt="">
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

</div>
</div>

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
    });
  });
</script>

</body>
</html>