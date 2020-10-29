<?php
require('connect.php');
// if the values are posted, insert them into the database.
if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
	$username=$_POST['username'];
	$email=$_POST['email'];
	$password = $_POST['password'];
	$email_conf = rand(245861,666666);

	$user_query = "SELECT * FROM `user` WHERE username='$username'";
	$user_result = mysqli_query($connection, $user_query) or die(mysqli_error($connection));
	$count = mysqli_num_rows($user_result);

	$query = "INSERT INTO `user` (username, password, email) VALUES ('$username', '$password', '$email')";
	$result=mysqli_query($connection, $query);
	if($result) {
		$smsg="Congrats! You're in.";
	} else {
		if($count>1) {
			$fmsg="ID not available, try again with a new username";
		} else {
			$fmsg="User Registeration Failed!";
		}
	}
}

//header('Refresh: 5; URL=/about/'.$_POST['prev'].'/'.$_POST['prev'].'.php');

/*
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();                            // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                     // Enable SMTP authentication
$mail->Username = 'milad';          // SMTP username
$mail->Password = '993131839Moscow'; // SMTP password
$mail->SMTPSecure = 'ssl';                  // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                          // TCP port to connect to

$mail->setFrom('miladabramson@gmail.com', 'fxUnivers');
$mail->addReplyTo('miladabramson@gmail.com', 'fxUnivers');
$mail->addAddress('milad01010@gmail.com');   // Add a recipient
$mail->addCC('milad01010@gmail.com');
$mail->addBCC('milad01010@gmail.com');

$mail->isHTML(true);  // Set email format to HTML

$bodyContent = '<h1>How to Send Email using PHP in Localhost by CodexWorld</h1>';
$bodyContent .= '<p>This is the HTML email sent from localhost using PHP script by <b>CodexWorld</b></p>';

$mail->Subject = 'Email from Localhost by CodexWorld';
$mail->Body    = $bodyContent;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
*/
?>



<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Confirm</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/skinblue.css"/><!-- change skin color here -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/responsive.css"/>
<script src="/js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->
</head>
<body>
<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
        <div class="row space-bot">
                <!--Logo-->
                <div class="c4">
                        <a href="/index1.html">
                                <img src="/images/logo_small.png" class="logo" alt="">
                        </a>
                </div>
                <!--Menu-->
                <div class="c8">
                        <nav id="topNav">
                        <ul id="responsivemenu">
                                <li class="active"><a href="register.php"><font size="+1">SIGN IN</font><span class="showmobile">Sign Up</span></a></li>
                                <li><a href="/about/fxuniversity/fxuniversity.php">FxUniversity</a>
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
					     <h3 class="form-signin-heading">Get Started!</h3>
					     <p>Now you can either get going with your workspace by signing in or signup for a plan below.</p>
					     <form class="form-signin" action="/register/login.php">
					     	   <button class="btn" type="submit">Login</button>
				             </form>
					</div>
                                        <div class="container">
						<h3 class="form-signin-heading">Experience More!</h3>
						<p>Choose one of the following plans to get more of fxUnivers</p>
						<form class="form-signin" action="/about/fxuniversity/fxuniversity.php">
							<button class="btn" type="submit">fxUniversity</button>
						</form>
						<form class="form-signin" action="/about/fxuniverse/fxuniverse.php">
                                                        <button class="btn" type="submit">fxUniverse</button>
                                                </form>
						<form class="form-signin" action="/about/fxpartner/fxpartner.php">
                                                        <button class="btn" type="submit">fxPartner</button>
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
				<label class="sr-only">Enter the code sent to your email, here:</label>
				<input type="text" name="email_conf" class="from-control" id="conf_text" autofocus><br/>
				<button class="btn btn-lg btn-primary btn-block" onclick="compareFunction()">Confirm!</button>
-->
                        </div>
		</div>

<p id="success"></p>
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
