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
  <title>fxUnivers</title>
  <link rel="stylesheet" type="text/css" href="/css/styles.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="/js/jquery-3.4.1.min.js"></script>
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
	<input type="submit" class="login-button" value="Log in" id="desktop-login-btn">
      </form>
      
      <a class="login-button" id="goto-login">Login</a>
      <a class="signup-button" id="goto-signup">Sign up</a>
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


<!------ LOGIN OVERLAY ------->
<div class="overlay-container" style="display:none" id="login-overlay">
<div class="overlay">
<div class="close-btn" id="login-close-btn">×</div>
  <h1>Login</h1>
  <form action="/php/login.php" method="POST">
    <input class="txt-input" type="text" placeholder="Username or Email" name="username" <?php if(isset($_GET['un'])) echo 'value="'.$_GET['un'].'"'; ?> required>
    <input class="txt-input" type="password" name="password" placeholder="Password" required>
    
    <?php 
	 if(isset($_GET['err']) && $_GET['err']=='wup') {
	 echo '<p class="red">Wrong username or password.</p>';
	 }
    ?>
    <a class="login-forgot">Forgot your password?</a>
    <input type="submit" class="login-button" value="Log in">
  </form>

  

</div>
</div>

<!---------------- Signup Overlay ---------------->
  <div class="overlay-container" style="display:none" id="signup-overlay">
  
    <div class="overlay">
    <div class="close-btn" id="signup-close-btn">×</div>
      <h1 id="overlay-title">Create Account</h1>
      <form  method="POST" autocomplete="off" id="regForm">

        <input class="signup-input" type="text" name="email" placeholder="Email" id="deskEmail">
	<p class="tooltip red" id="dupEmail">This email is already used.</p>
        <p class="tooltip red"  id="badEmail">Invalid email address</p>


        <input class="signup-input" type="password" name="password" placeholder="Password" id="pass">
        <p class="tooltip red" class="tooltip" id="badPass">Weak password</p>


        <input class="signup-input" type="password" name="password2" placeholder="Repeat Password" id="confpass">
	<p class="tooltip red" class="tooltip" id="noMatch">Passwords do not match</p>
	
        <label class="checkbox">I agree to <a href="#">terms and conditions</a>
        <input type="radio" name="policycb" required>
        <span class="checkmark"></span>
        </label>

	<?php 
         if(isset($_GET['partner'])) {
             $partner=$_GET['partner'];
             echo '<input type="hidden" name="partner" value="'.$partner.'">';
         }
        ?>

        <input type="submit" value="Sign up" class="signup-button" id="sup-btn">
      </form>
      <p id="overlay-text" style="display:none">Check your email inbox or spam folder for an activation email we just sent you.</p>
    </div>
  </div>


<!-- SCRIPTS -->
<script>
$('#goto-signup').click(function() {
$('#signup-overlay').show();
});
</script>

<script>
$('#goto-login').click(function() {
$('#login-overlay').show();
});
</script>

<!-- Email Validation -->
<script type="text/javascript">
$('#deskEmail').each(function() {
  var elem=$(this);

  // current val
  elem.data('oldVal', elem.val());

  //look for changes
  elem.bind("propertychange change click keyup input paste", function(event) {
    if(elem.data('oldVal')!=elem.val()) {
      elem.data('oldVal', elem.val());

      if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(elem.val())) {
          $('#badEmail').hide();
          jQuery.ajax({
            type: 'POST',
            url: '/php/dup_email.php',
            data: $('#deskEmail').serialize(),
            success: function(data) {
              if(data=='dup') {
                  $('#dupEmail').show();
              } else {
                  $('#dupEmail').hide();
              }
            }
          });
      } else {
          $('#badEmail').show();
      }
    }
  });
});
</script>



<!-- Bad Password -->
<script type="text/javascript">
$('#pass').each(function() {
  var elem1=$(this);
  elem1.data('oldVal', elem1.val());
  elem1.bind("propertychange change click keyup input paste", function(event) {
    if(elem1.data('oldVal')!=elem1.val()) {
      elem1.data('oldVal', elem1.val());
      if(elem1.val().length > 8) {
        $('#badPass').hide();
      } else {
        $('#badPass').show();
      }
    }
  });
});
</script>




<!-- Password Confirmation -->
<script type="text/javascript">
    $('#confpass').each(function() {
        var elem2=$(this);
        elem2.data('oldVal', elem2.val());
        elem2.bind("propertychange change click keyup input paste", function(event) {
            if(elem2.data('oldVal')!=elem2.val()) {
                elem2.data('oldVal', elem2.val());
                if(elem2.val()!=$('#pass').val()) {
                    $('#noMatch').show();
                } else {
                    $('#noMatch').hide();
                }
            }
        });
    });
</script>


<!-- SIGNUP FORM SUBMIT -->
<script>
$('#regForm').submit(function(event) {
        event.preventDefault();

    if(($('#pass').val().length <= 8) || ($('#confpass').val()!=$('#pass').val()) || !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#deskEmail').val()))) {
        alert('Enter valid data!');
    } else {
       $('#sup-btn').css('opacity','0.85');
       $('#sup-btn').prop('disabled',true);
       $('#sup-btn').val('Signing up...');
       jQuery.ajax({
         type:'POST',
	 url: '/register/reg.php',
	 data: $(this).serialize(),
	 success: function(response) {
	   if(response==1) {
	     $('#overlay-title').html('Confirm Your Email Address');
	     $('#overlay-text').show();
	     $('#regForm').hide();
	   } else {
	     $('#overlay-title').html('Error!');
	     $('#overlay-text').show();
	     $('#overlay-text').html('Something went wrong! :/ Try again.');
	     $('#regForm').hide();
	   }
	 }
       });
    }
});
</script>

<!-- CLOSE OVERLAY -->
<script>
$('#login-close-btn').click(function() {
  $('#login-overlay').hide();
});

$('#signup-close-btn').click(function() {
  $('#signup-overlay').hide();
});
  
</script>

</body>
</html>
