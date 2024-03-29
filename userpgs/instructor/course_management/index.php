<?php
session_start();
require('../../../register/connect.php');

// fetch the username
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $smsg = "successfully logged in";
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

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
<title>Tutor Workspace</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/css/prettyPhoto.css"/>
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
<!-- END UPPER BAR -->

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
                                <li class="active"><a href="/register/login.php?prev=fxuniverse"><font size="+1">SIGN IN</font><span class="showmobile">Sign Up</span></a></li>
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
				<h1 class="titlehead">Course Management</h1>
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
		<div class="shadowundertop"></div>
		<div class="row">
		<div class="c12">
			<h1 class="maintitle space-top">
			<span>Actions</span>
			</h1>
		</div>
		</div>
		<div class="row space-top">
			<div id="content">
				<!-- image 1 -->
				<div class="boxfourcolumns cat1">
					<div class="boxcontainer">
						<span class="gallery">
						<a href="upload.php"><img src="/images/teacher/add_course.png" alt="Add Title" class="imgOpa"/></a>
						</span>
						<h1><a href="/userpgs/teacher/course_management/upload.php">Add Course</a></h1>
						<p>
							Add a new course.
						</p>
					</div>
				</div>
				<!-- image 2 -->
				<div class="boxfourcolumns cat1">
					<div class="boxcontainer">
						<span class="gallery">
						<a href="/userpgs/teacher/course_management/edit_course.php"><img src="/images/teacher/edit_course.png" alt="Add Title" class="imgOpa"/></a>
						</span>
						<h1><a href="edit_course.php">Edit Courses</a></h1>
						<p>
							Edit previously added courses. Republish or delete them.
						</p>
					</div>
				</div>
				<!-- image 3 -->
				<div class="boxfourcolumns cat1">
					<div class="boxcontainer">
						<span class="gallery">
						<a href="/userpgs/teacher/course_management/exam_upload.php"><img src="/images/teacher/add_test.png" alt="Add Title" class="imgOpa"/></a>
						</span>
						<h1><a href="/userpgs/teacher/course_management/exam_upload.php">New Exam</a></h1>
						<p>
							 Create a new exam.
						</p>
					</div>
				</div>
				<!-- image 4 -->
                                <div class="boxfourcolumns cat1">
                                        <div class="boxcontainer">
                                                <span class="gallery">
                                                <a href="/userpgs/teacher/course_management/edit_exam.php"><img src="/images/teacher/edit_test.png" alt="Add Title" class="imgOpa"/></a>
                                                </span>
                                                <h1><a href="/userpgs/teacher/course_management/edit_exam">Manage Exams</a></h1>
                                                <p>
                                                        Manage added exams.
                                                </p>
                                        </div>
                                </div>

				
			</div>
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

<!-- twitter -->
<script src="/js/jquery.tweet.js"></script>

<script src="/js/jquery.cycle.js"></script>

<!-- filterable -->
<script src="/js/jquery.isotope.min.js"></script>

<!-- gallery -->
<script src="/js/jquery.prettyPhoto.js"></script>

<!-- CALL opacity on hover images -->
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

<!-- CALL filtering -->
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
 
  
<!-- CALL lightbox prettyphoto -->
<!-- CALL lightbox prettyphoto -->
<script type="text/javascript">
  $(document).ready(function(){
    $("a[data-gal^='prettyPhoto']").prettyPhoto({social_tools:'', animation_speed: 'normal' , theme: 'dark_rounded'});
  });
</script>

</body>
</html>
