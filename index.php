<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
    }*/

session_start();
require('register/connect.php');

if(isset($_SESSION['username'])) {
	$registered=true;
	header("Location: /userpgs");
	exit();
}

if(isset($_GET['err'])) {
  $error=$_GET['err'];
}

if(isset($_GET['msg'])) {
  $msg=$_GET['msg'];
}

if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $uname=$_COOKIE['username'];
    $pass=$_COOKIE['password'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>fx login</title>
  <link rel="stylesheet" type="text/css" href="/css/styles.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <div class="login-container">
    <div class="login-form">
      <div class="fxunivers-logo">
        <img src="/images/logos/fxunivers-logo.svg">
        <span>fxUnivers</span>
        <p>Universe of Possibilities</p>
      </div>
      <h2>Log in to fxUnivers</h2>
      <form action="/php/login.php" method="POST">
	<input class="login-input" type="text" placeholder="Username or Email" name="username" <?php if(isset($_GET['un'])) echo 'value="'.$_GET['un'].'"'; ?> required>
	<input class="login-input" type="password" name="password" placeholder="Password" required>

	<?php 
	 if(isset($_GET['err']) && $_GET['err']=='wup') {
	 echo '<p class="red">Wrong username or password.</p>';
}
?>
	<a class="login-forgot">Forgot your password?</a>
	<input type="submit" class="login-button" value="Log in">
      </form>
      
      <a class="signup-button">Sign up</a>
    </div>
      
    <div class="login-description">
      <div class="login-text">
        <div class="fx-icon fxstar-icon"><span>fxStar</span><p>Purchase products/services, or send/recieve as gift</p></div>
        <div class="fx-icon fxuniversity-icon"><span>fxUniversity</span><p>Create courses as instructor & make fxStars, or browse to take them as student</p></div>
        <div class="fx-icon fxpartner-icon"><span>fxPartner</span><p>Partner us & make easy fxStars</p></div>
        <div class="fx-icon fxuniverse-icon"><span>fxUniverse</span><p>Universe of trading (Coming soon for public)</p></div>
        <div class="fx-icon fxsonet-icon"><span>fxSonet</span><p>Next level of worldwide connection (Coming soon for public)</p></div>
      </div>
    </div>
  </div>
</body>
</html>
