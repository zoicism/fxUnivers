<?php
require('connect.php');

if(isset($_POST['email'])) {
  $email = $_POST['email'];
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: /");
    exit();
  }
}

// Check if email is already registered 
$email_ver_q = "SELECT * FROM user WHERE email='$email'";
$email_ver_r = mysqli_query($connection,$email_ver_q);
$email_ver_count = mysqli_num_rows($email_ver_r);
if($email_ver_count > 0) {
	$exists = 1;
	// Check verification
	$email_ver_f = mysqli_fetch_array($email_ver_r);
	$verified = $email_ver_f['verified'];
	if($verified) {
		echo 403;
		exit();
	} else {
		$not_verified = 1;
	}
} else {
	$exists = 0;
	echo 404;
	exit();
}

if($not_verified && $exists) {
$hash = $email_ver_f['hash'];
///////////// Activation Email /////////////

$to = $email;
$subject = 'fxUnivers Email Address Verification';
/*if(isset($_POST['partner'])) {
  $msg_href='https://fxunivers.com/register/verify_email.php?email='.$email.'&hash='.$hash.'&partner='.$_POST['partner'];
} else {
  $msg_href='https://fxunivers.com/register/verify_email.php?email='.$email.'&hash='.$hash;
}*/

$msg_href='https://fxunivers.com/register/verify_email.php?email='.$email.'&hash='.$hash;
$message = '
<html>
  <head>
    <title>fxUnivers Email Verification</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
      html,body {
        font-family: "Roboto", sans-serif;
        background-color:#fafafa;
        color:darkslategray;
        margin:10px;
        padding:0;
      }
    </style>
  </head>
  <body>
    <p style="font-size:1rem;">Dear fxUser,</p>
    <p style="font-size:1rem;">Welcome to fxUnivers! Please click on the following link to confirm your email address and complete your registration!</p>
    <p style="font-size:1rem;">If the link does not work, you will need to copy/paste it to your browser.</p>
    <p><a href="'.$msg_href.'">'.$msg_href.'</a></p>

    <table style="font-size:0.9rem;margin-top:40px;background:#ececec;border-radius:12px;padding-left:20px;padding-right:20px;">
      <tr>
	<td style="vertical-align:top;"><a href="https://fxunivers.com"><img src="https://fxunivers.com/images/logos/fxunivers-logo.svg" style="width:100px;height:100px;margin-top:15px;"></a></td>
	<td style="padding-left:20px;">
	  <p style="font-style:italic;font-weight:bold;font-size:1rem;">fxUnivers Team,</p>
	  <p><span style="color:#0085b0">Address:</span><br>
	    New Horizon Building, Ground Floor,
            <br>3 1/2 Miles Philip S.W. Goldson Highway,
            <br>Belize City, Belize,
            <br>Central America
	  </p>
	  <p><span style="color:#0085b0">Email:</span> 
	    <a href="mailto: contact@fxunivers.com" style="color:darkslategray">contact@fxunivers.com</a>
	  </p>
	  <p><span style="color:#0085b0">Follow Us:</span> 
	    <a href="https://facebook.com/fxunivers"><img src="https://fxunivers.com/images/socialpack/dark/facebook.png" style="width: 15px;height: 15px;opacity: 0.6;"></a>
	    <span style="margin-left:3px;margin-right:3px;"></span>
	    <a href="https://twitter.com/fxunivers"><img src="https://fxunivers.com/images/socialpack/dark/twitter.png" style="width: 15px;height: 15px;opacity: 0.6;"></a>
	    <span style="margin-left:3px;margin-right:3px;"></span>
	    <a href="https://instagram.com/fxunivers"><img src="https://fxunivers.com/images/socialpack/dark/instagram.png" style="width: 15px;height: 15px;opacity: 0.6;"></a>
	  </p>
	</td>
      </tr>
    </table>
    
    
  </body>
</html>
';

// Headers
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers[] = 'From: fxUnivers <no-reply@fxunivers.com>';

// Mail it!
mail($to, $subject, $message, implode("\r\n", $headers));

////////////////////////////////////////////
echo 1;
} else {
	echo 0;
}


?>
