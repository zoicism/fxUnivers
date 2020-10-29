<?php
session_start();
require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
	$smsg = "Successfully logged in!";

	$id_query = "SELECT * FROM `user` WHERE username='$username'";
	$id_result = mysqli_query($connection, $id_query) or die(mysqli_error($connection));
	$id_fetch = mysqli_fetch_array($id_result);
	$id = $id_fetch['id'];
} else {}

$query = "SELECT * FROM user WHERE username='$username'";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
$bio = mysqli_fetch_array($result);
$bio_txt = $bio['bio'];
$fname = $bio['fname'];
$lname = $bio['lname'];

// COURSES OF THE TEACHERS
$course_query = "SELECT * FROM teacher WHERE user_id=$id";
$course_result = mysqli_query($connection, $course_query) or die(mysqli_error($connection));

?>

<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Course Management</title>
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
                                <li class="active"><a href="register.php"><font size="+1">SIGN IN</font><span class="showmobile">Sign Up</span></a></li>
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
                                <li><a href="#">News</a>
                                <ul style="display: none;">
                                        <li><a href="https://www.wsj.com/" target="_blank">WSJ</a></li>
                                        <li><a href="https://www.bloomberg.com/" target="_blank">Bloomberg</a></li>
                                        <li><a href="https://www.cnbc.com/" target="_blank">CNBC</a></li>
                                        <li><a href="money.cnn.com/" target="_blank">CNN Money</a></li>
                                        <li><a href="https://www.ft.com/" target="_blank">Financial Times</a></li>
                                        <li><a href="https://www.reuters.com/" target="_blank">Reuters</a></li>
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
                                <h1 class="titlehead">Manage Exams</h1>
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
			
			<!-- SIDEBAR -->
			<div class="c3">
                                <div class="rightsidebar">
                                        <h2 class="title stresstitle">Exam List</h2>
                                        <hr class="hrtitle">
					<div class="teamdescription">
                                                <h1>Click to edit!</h1>
						<!-- COURSE BOXES -->
						<div class="row space-top">
				                        <div id="content">
			                                <!-- BOX 1 -->
								<div class="boxthreecolumns cat1">
				                                        <div class="boxcontainer">
								
				                                                <div class="mosaic-block cover">
			                                                                <a href="/userpgs/teacher/singleproject_test.php"><img src="/images/training/billgates.jpg" alt=""></a>
				                                                </div>
				                                                <h1><a href="/userpgs/teacher/singleproject_test.php">Billie on Books</a></h1>
				                                        </div>
				                                </div>
							<!-- EO BOX 1 -->
							<?php
							if($course_result->num_rows > 0) {
								while($row = $course_result->fetch_assoc()) {
							?>
									<!-- BOX -->
									<div class="boxthreecolumns cat1">
										<div class="boxcontainer">
											<div class="mosaic-block cover">
												<a href="/userpgs/teacher/singleproject.php?course_id=<?php echo $row["id"] ?>"><img src="<?php echo $row["img"] ?>" alt=""></a>
											</div>
											<h1><a href="/userpgs/teacher/singleproject.php?course_id=<?php echo $row["id"] ?>"><?php echo $row["header"] ?></a></h1>
										</div>
									</div>
							<?php
								}
							}
							?>
							</div>
						</div>
						<!-- EO COURSE BOXES -->
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
                                <!-- by Milad <milad@fxunivers.com> --> </span>
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

