<?php

  session_start();
  require('../../../register/connect.php');

  if(isset($_GET['course_id']))
   $course_id = $_GET['course_id'];

  $course_query = "SELECT * FROM `teacher` WHERE id=$course_id";
  $course_result = mysqli_query($connection, $course_query) or die(mysqli_error($connection));
  $course_fetch = mysqli_fetch_array($course_result);

  $user_id = $course_fetch['user_id'];
  $header = $course_fetch['header'];
  $description = $course_fetch['description'];
  $video = $course_fetch['video_url'];

  require('../../teacher/php/classes.php');
  
?>


<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Course </title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/css/slider.css"/>
<link rel="stylesheet" type="text/css" href="/css/skinblue.css"/><!-- Change skin color here -->
<link rel="stylesheet" type="text/css" href="/css/responsive.css"/>
<script src="/js/jquery-1.9.0.min.js"></script><!-- scripts at the bottom of the document -->
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
			  <?php echo $description ?>
			  <p><i>Year</i> : 2013</p>

			  <hr class="hrtitle"><br>
			  <div class="c6">			    
			    <h1 class="maintitle">			      
			      <span>Classes</span>		      
			    </h1>
			  </div>
			  
			
			  <table>
			    <col width="10%">
			    <col width="20%">
			    <col width="70%">
			    

			    <tr style="border-bottom: 1px solid black;">
			      <td><img src="/images/teacher/class.png" height="40" width="50"></td>
			      <td style="text-align: center"><b><?php echo $first_title ?></b></td>
			      <td><?php echo $first_body ?></td>
			    </tr>

			    <?php if($class_result->num_rows > 0) {
			    while($row = $class_result->fetch_assoc()) { ?>
			    
			    <tr style="border-bottom: 1px solid black;">
			      <td><img src="/images/teacher/class.png" height="40" width="50"></td>
			      <td style="text-align: center"><b><?php echo $row['title'] ?></b></td>
			      <td><?php echo $row['body'] ?></td>
			    </tr>

			    <?php }
				  }
				  ?>
			  </table>
			  
			</div><!-- end description area -->
				
			<!-- begin slider area -->
			<div class="c6">
				<div class="flexslider">
					<ul class="slides">
						<li><?php echo $video ?></li>
					</ul>
				</div>
				
				<table style="border: 1px black solid">
				  <col width="50%">
				  <col width="50%">
				  <tr>
				    <td style="text-align: right"><b>Instructor name</b></td><td>Neo Abramson</td>
				  </tr>
				  <tr>
				    <td style="text-align: right"><b>Fee</b></td><td>100 f<small>x</small>Stars</td>
				  </tr>
				  <tr>
				    <td style="text-align: right"><b>Top bid</b></td><td>110 f<small>x</small>Stars</td>
				  </tr>
				    <td style="text-align: right"><b>Bid it!</b></td><td><input type="text" value="fxStars"><button>Bid it!</button></td>
				  <tr>
				    <td style="text-align: right"><b>Number of classes</b></td><td>12</td>
				  </tr>
				</table>
				
				<button class="btn">Subscribe</button>
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
                                <img src="/images/logo_small.png" style="padding-top: 20px;" width="75" height="98" alt="">
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
