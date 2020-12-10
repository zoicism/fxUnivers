<?php
session_start();
require('../connect.php');

if(isset($_SESSION['username'])) {
    header('Location: /register/logout.php');
    exit();
}

if(isset($_POST['email'])) {
    $email=$_POST['email'];
} else {
    header('Location: /');
    exit();
}

$checkex_q="SELECT * FROM user WHERE email='$email'";
$checkex_r=mysqli_query($connection,$checkex_q) or die(mysqli_error($connection));
$checkex_count=mysqli_num_rows($checkex_r);
if($checkex_count<1) {
    header('Location: /register/forgot_password?err=no_res');
    exit();
}

$hash = md5(rand(0,1000)); // Random 32-char hash

$forgot_q = "INSERT INTO forgot_pass(email, hash) VALUES('$email', '$hash')";
$forgot_r = mysqli_query($connection, $forgot_q) or die(mysqli_error($connection));


// RECOVERY EMAIL //

$to=$email;
$subject='fxUnivers Password Recovery';
$msg_link='https://fxunivers.com/register/forgot_password/recover.php?email='.$email.'&hash='.$hash;
$message = '
<html>
  <head>
    <title>fxUnivers Password Recovery</title>
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
    <p style="font-size:1rem">Dear fxUser,</p>
    <p style="font-size:1rem">Click on the following link to set yourself a new password.</p>
    <p style="font-size:1rem">If the link does not work, you will need to copy/paste it to your browser.</p>
    <p><a href="'.$msg_link.'">'.$msg_link.'</a></p>




    
    <table style="font-size:0.9rem;margin-top:70px;background:#ececec;border-radius:12px;padding-left:20px;padding-right:20px;">
      <tr>
	<td style="vertical-align:top;"><a href="https://fxunivers.com"><img src="https://fxunivers.com/images/logo/logo-100.png" style="width:100px;height:100px;margin-top:15px;"></a></td>
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

// headers
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// additional headers
$headers[] = 'From: fxUnivers <no-reply@fxunivers.com>';

// EO recovery email //

if($forgot_r) {
    // Mail it!
    mail($to, $subject, $message, implode("\r\n", $headers));
    $success=1;
} else {
    $success=0;
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>fxUnivers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">   
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
  </head>

<body>

<div class="center">
<?php
                if($success) {
                    echo '<h3>We have emailed you a password recovery link.</h3>';
                    echo '<p>Please check your inbox!</p>';
                    echo '<p><a href="https://mail.google.com" target="_blank">Gmail</a> - <a href="https://mail.yahoo.com" target="_blank">Yahoo Mail</a></p>';
                } else {
                    echo '<h3>Error :( <a href="/register/forgot_password">Try again!</a></h3>';
                }
?>
</div>

<div class="footer" style="bottom:0;position:fixed;"></div>
<script src="/js/footer.js"></script>
</body>
</html>