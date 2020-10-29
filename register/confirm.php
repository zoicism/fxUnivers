<?php
require('connect.php');
// if the values are posted, insert them into the database.
if(isset($_POST['username']) && isset($_POST['password'])) {
	$username=$_POST['username'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$phone=$_POST['phone'];
	$plan_fxuniversity = $_POST['fxuniversity']=='yes' ? 1 : 0;
	$plan_fxuniverse = $_POST['fxuniverse']=='yes' ? 1 : 0;
	$plan_fxpartner = $_POST['fxpartner']=='yes' ? 1 : 0;
	
	

	$user_query = "SELECT * FROM `user` WHERE username='$username'";
	$user_result = mysqli_query($connection, $user_query) or die(mysqli_error($connection));
	$count = mysqli_num_rows($user_result);

	$id_query = "SELECT id FROM user WHERE username='$username'";
	$id_result = mysqli_query($connection, $id_query) or die(mysqli_error($connection));
	$id_fetch = mysqli_fetch_array($id_result);
	$id = $id_fetch['id'];
	
	$query = "UPDATE `user` SET password = '$password', fname = '$fname', lname = '$lname', phone = '$phone' WHERE username = '$username'";
	$result=mysqli_query($connection, $query);
	$id_query = "SELECT id FROM user WHERE username='$username'";
	$id_result = mysqli_query($connection, $id_query) or die(mysqli_error($connection));
        $id_fetch = mysqli_fetch_array($id_result);
	$id = $id_fetch['id'];

	if($result) {
		$smsg="User Created Successfully!";
		$plan_query = "INSERT INTO `plans` (id, fxuniversity, fxuniverse, fxpartner) VALUES ($id, $plan_fxuniversity, $plan_fxuniverse, $plan_fxpartner)";
		$plan_result = mysqli_query($connection, $plan_query) or die(mysqli_query($connection));
	} else {
		if($count>1) {
			$fmsg="ID not available";
		} else {
			$fmsg="User Registeration Failed!";
			$url = "reg_level2.php?reg=failed";
			header('Location: ' . $url);
		}
	}
		
}
?>



<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Confirm</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/icons.css"/>
<link rel="stylesheet" type="text/css" href="css/skinblue.css"/><!-- change skin color here -->
<link rel="stylesheet" type="text/css" href="css/responsive.css"/>
<script src="../js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->
</head>
<body>
<div id="bar">
<ul>
        <li><a class="active" href="/userpgs/general.php">Home</a></li>
  
        <li><a href="logout.php">Logout</a></li>
</ul>
</div>
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
                                <li class="active"><a href="register.php"><font size="+1">SIGN IN</font><span class="showmobile">Sign Up</span></a></li>
                                <li><a href="../../about/fxuniversity/university.html">FxUniversity</a>
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
				<h1 class="titlehead">Congrats!</h1>
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
                                <span>You're In!</span>
                                </h1>
				<?php
                                        if(isset($smsg)) {
                                ?>
                                                <div class="alert alert-success" rolde="alert">
                                                <?php echo $smsg; ?>
                                                </div>
						<div class="container">
							<p>Enter your workspace now:</p>
							<form class="form-signin" action="login.php">
								<button class="btn" type="submit">Login!</button>
							</form>
						</div>
                                <?php
                                        }
                                ?>

                                <?php
                                        if(isset($fmsg)) {
                                ?>
                                                <div class="alert alert-danger" rolde="alert">
                                                <?php echo $fmsg; ?>
                                                </div>
                                <?php
                                        }
                                ?>
<!--
				<?php if($registered == false) { ?>
				<label class="sr-only">Enter the code sent to your email, here:</label>
                                <input type="text" name="email_conf" class="from-control" id="conf_text" autofocus><br/>
                                <button class="btn btn-lg btn-primary btn-block" onclick="compareFunction()">Confirm!</button>
				<?php } ?>
				<label class="sr-only">Enter the code sent to your phone, here:</label><br>
				<input type="text" name="email_conf" class="from-control" id="conf_text">
				<button class="btn btn-lg btn-primary btn-block" onclick"compareFunction()">Confirm!</button>
-->
                        </div>
		</div>
<p id="success"></p>
</div>

<!-- FOOTER  -->

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
                		<div class="row">
	                        <div class="c6">
	                         With all due Reserves,
	                        </div>
	                </div>
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
    });
  });
</script>
<script type="text/javascript">
function compareFunction() {
        var msg;
        var recieved = document.getElementById("conf_text").value;
        var sent = "<?php echo $email_conf; ?>";
        document.getElementById("sent").innerHTML = sent;
        if(recieved == "33666") {
                msg = "success";
        } else {
                msg = "failure";
        }
        
        document.getElementById("success").innerHTML = msg;
}
</script>
</body>
</html>
