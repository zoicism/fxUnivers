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
    $username=$_COOKIE['username'];
    $password=$_COOKIE['password'];


    $login_query = "SELECT * FROM user WHERE ((username='$username' and password='$password') or (email='$username' and password='$password'))";
    $login_result = mysqli_query($connection, $login_query);

    $login_count = mysqli_num_rows($login_result);

    if($login_count == 1) {
	
	if(strpos($username, '@') !== false) {
	    $uname_query = "SELECT * FROM user WHERE email='$username'";
	    $uname_result = mysqli_query($connection, $uname_query) or die(mysqli_error($connection));
	    $uname_fetch = mysqli_fetch_array($uname_result);
	    $username = $uname_fetch['username'];
	}

	$_SESSION['username'] = $username;

	if(1) {
            setcookie('username',$username,time()+60*60*24*30,'/');
            setcookie('password',$password,time()+60*60*24*30,'/');
	} else {
            setcookie("username","");
            setcookie("password","");
	}
	
	header('Location: /userpgs');
	//exit;
	
    } else {
	header('Location: /?err=wup&un='.$username);
    }
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

	<label class="checkbox remember-me">Remember me
        <input type="checkbox" name="rememberme" value="remember">
        <span class="checkmark"></span></label>


	
	<?php 
	 if(isset($_GET['err']) && $_GET['err']=='wup') {
	 echo '<p class="red">Wrong username or password.</p>';
}
?>
	<a class="login-forgot" id="open-forgot-overlay">Forgot your password?</a>
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

    <label class="checkbox">Remember me
        <input type="checkbox" name="rememberme" value="remember">
        <span class="checkmark"></span></label>
    
    <?php 
	 if(isset($_GET['err']) && $_GET['err']=='wup') {
	 echo '<p class="red">Wrong username or password.</p>';
	 }
    ?>
    <a class="mob-login-forgot" id="open-forgot-overlay-mob">Forgot your password?</a>
    <input type="submit" class="login-button" value="Log in">
  </form>

  

</div>
</div>

<!---------------- Signup Overlay ---------------->
  <div class="overlay-container" style="display:none" id="signup-overlay">
  
    <div class="overlay">
    <div class="close-btn" id="signup-close-btn">×</div>
      <h1 id="overlay-title">Create Account</h1>
      <form autocomplete="off" id="regForm">

        <input class="signup-input" type="text" name="email" placeholder="Email" id="deskEmail">
	<p class="tooltip red" id="dupEmail">This email is already used.</p>
        <p class="tooltip red"  id="badEmail">Invalid email address</p>


        <input class="signup-input" type="password" name="password" placeholder="Password" id="pass">
        <p class="tooltip red" class="tooltip" id="badPass">Weak password</p>


        <input class="signup-input" type="password" name="password2" placeholder="Repeat Password" id="confpass">
	<p class="tooltip red" class="tooltip" id="noMatch">Passwords do not match</p>
	
        <label class="checkbox">I agree to <a href="/policy" target="_blank">terms and conditions</a>
        <input type="checkbox" name="policycb" required>
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
      <p id="overlay-text" style="display:none">Check your email inbox or spam folder for an activation link we just sent you. It may take a few minutes for you to get the email.</p>
    </div>
  </div>


<!---------------- Forgot Password Overlay starts ---------------->
  <div class="overlay-container" id="forgot-overlay" style="display:none">
    <div class="overlay-forgot">
      <div class="forgot-header">
        <h1>Forgot Your Password?</h1>
        <a id="close-forgot-overlay" class="closebtn" onclick="closeNav()">×</a>
      </div>

      <form id="forgot-form">
        <div class="forgot-content">
          <p>Enter your email address below.</p>
          <input class="forgot-input" type="text" placeholder="Email" name="email" spellcheck="false" required>
        </div>
          <input type="submit" class="forgot-button" value="Send Email">
      </form>
    </div>
  </div>
<!---------------- Forgot Password Overlay ends ---------------->



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
	     console.log(response);
	     
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


<script>
$('#close-forgot-overlay').click(function() {
  $('#forgot-overlay').hide();
});
$('#open-forgot-overlay').click(function() {
  $('#forgot-overlay').show();
});
$('#open-forgot-overlay-mob').click(function() {
  $('#login-overlay').hide();
  $('#forgot-overlay').show();
});
</script>

<script>
$('#forgot-form').submit(function(event) {
  event.preventDefault();
  jQuery.ajax({
    type:'POST',
    url:'/register/forgot_password/forgotpass.php',
    data:$(this).serialize(),
    success: function(response) {
      if(response=='no_res') {
        alert('No account found with this email address');
      } else if(response==1) {
        alert('We sent you an email with the instructions to reset your password.');
	window.location.reload();
      } else {
        alert('Failed to send the email. Please try again.');
      }
    }
  });
});
</script>

</body>
</html>
