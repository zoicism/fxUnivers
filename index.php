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
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">   
    <title>fxUnivers</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <link rel="stylesheet" href="/css/colors.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script>
    $(document).ready(function() {
        var uname='<?php echo $uname?>';
        var pass='<?php echo $pass?>';
        if(uname!="" && pass!="") {
            jQuery.ajax({
              url:'/php/login.php',
                    method:'POST',
                    data: {username:uname,password:pass},
                    success: function(response) {
                }
            });
        }
    });
    </script>
    </head>

<body>



<div id="deskView">

<div class="col-50 left-col" style="min-height:86vh;background:#00afe8;padding-top:6%;">

    <div class="col-1" style="text-align:left;">
      <div class="icon intro-icon fxstar-white"></div>
   
      <h3 class="white">fxStar</h3>
      <p class="white">Purchase products/services, or send/recieve as gift.</p>
    </div>

    <div class="col-1 " style="text-align:left">
      <div class="icon intro-icon fxuniversity-white"></div>
      <h3 class="white">fxUniversity</h3>
      <p class="white">Create courses as instructor & make fxStars, or browse to take them as student.</p>
    </div>


    <div class="col-1 " style="text-align:left">
      <div class="icon intro-icon fxpartner-white"></div>
      <h3 class="white">fxPartner</h3>
      <p class="white">Partner us & make easy fxStars.</p>
    </div>

    <div class="col-1 " style="text-align:left">
      <div class="icon intro-icon fxuniverse-white"></div>
      <h3 class="white">fxUniverse</h3>
      <p class="white">Universe of trading (Coming soon for public)</p>
    </div> 

    <div class="col-1 " style="text-align:left">
      <div class="icon intro-icon fxsonet-white"></div>
      <h3 class="white">fxSonet</h3>
      <p class="white">Next level of worldwide connection (Coming soon for public)</p>                   
    </div>
    
</div>




    

<div class="col-50 right-col" style="padding-top:4%">
    
    
    <div class="col-1">
      <div class="logo logo-200 horizontal-center"></div>
    <h3 style="font-size:2rem;font-weight:bold;" class="light-blue">fxUnivers</h3>
      <p style="font-size:1.6rem;font-weight:bold;" class="light-blue">Universe of Possibilities</p>
    </div>
    
    <div class="col-1">
    <?php
    if(isset($_GET['log']) && $_GET['log']=='signup') {
    ?>
      <h3>Sign up</h3>
      <form action="/register/reg.php" method="POST" autocomplete="off" id="regForm">
    
        <span class="tooltip" id="dupEmail">This email is already used</span>
    <span class="tooltip" id="badEmail">Invalid email address</span>
        <input type="text" name="email" placeholder="Email" style="width:25%" required id="deskEmail">
        <span class="tooltip" id="badPass">Weak password</span>
        <input type="password" name="password" placeholder="Password" id="pass" style="width:25%;" required>
        <span class="tooltip" id="noMatch">Passwords do not match</span>
        <input type="password" name="password2" placeholder="Repeat password" id="confpass" style="width:25%;" required>
        
        <input type="checkbox" name="policyCB" value="one" style="display:inline" required>
        <label for="policyCB"><a href="/policy" style="margin-bottom:10px;" target="_blank">I agree to terms & conditions</a></label><br>
        <?php 
         if(isset($_GET['partner'])) {
             $partner=$_GET['partner'];
             echo '<input type="hidden" name="partner" value="'.$partner.'">';
         }
        ?>
<p style="margin-top:10px;margin-bottom:10px;"><a href="/" class="dark-blue">Already a member? Click here to sign in!</a></p>
        <input type="submit" value="Sign up" id="submeat">                                     
      </form>
<?php
    } else {
?>
      <h3>Login</h3>
      <form action="/php/login.php" method="POST">
        <?php if(isset($_GET['err']) && $_GET['err']=='wup') { ?>
        <span class="tooltip" style="display:block">Wrong username or password</span><br>
        <?php } ?>
        <input type="text" name="username" placeholder="Username or Email" required style="width:25%;margin-bottom:10px;">
        <input type="password" name="password" placeholder="Password" required style="width:25%;margin-bottom:10px;">
        <input type="checkbox" id="rememberme" name="rememberme" value="remember" style="display:inline">
        <label for="rememberme">Remember me</label>
        
        <p style="margin-bottom:10px;"><a href="/register/forgot_password" >Forgot password?</a></p>
        <p style="margin-bottom:10px;"><a href="/?log=signup" class="dark-blue" >Not a member yet? Click here to sign up fast!</a></p>
        
        <input type="submit" value="login">
      </form>
<?php
    }
?>
    </div>
</div>

</div>








                
<!-- PHONE VIEW -->
<div id="phoneView" style="display:none;width:100%;">

<div class="col-1">
      <div class="logo logo-100 horizontal-center"></div>
      <p style="font-size:2rem;font-weight:bold;" class="light-blue">Universe of Functionalities</p>
    </div>
    
    <div class="col-1">
    <?php
    if(isset($_GET['log']) && $_GET['log']=='signup') {
    ?>
      <h3>Sign up</h3>
      <form action="/register/reg.php" method="POST" autocomplete="off" id="phoneRegForm">
        <span class="tooltip" id="phoneDupEmail">This email is already used</span>
        <span class="tooltip" id="phoneBadEmail">Invalid email address</span>
        <input type="text" name="email" placeholder="Email" style="width:60%" required id="phoneEmail">
        <span class="tooltip" id="phoneBadPass">Weak password</span>
        <input type="password" name="password" placeholder="Password" id="phonePass" style="width:60%;" required >
        <span class="tooltip" id="phoneNoMatch">Passwords do not match</span>
        <input type="password" name="password2" placeholder="Repeat password" id="phoneConfpass" style="width:60%;" required >
        
        <input type="checkbox" name="policyCB" value="one" style="display:inline" required>
        <label for="policyCB"><a href="/policy" style="margin-bottom:10px;">I agree to terms & conditions</a></label><br>
        <?php 
         if(isset($_GET['partner'])) {
             $partner=$_GET['partner'];
             echo '<input type="hidden" name="partner" value="'.$partner.'">';
         }
        ?>
<p style="margin-top:10px;margin-bottom:10px;"><a href="/" class="dark-blue">Already a member? Click here to sign in!</a></p>
        <input type="submit" value="Sign up" id="phoneSubmeat" >                                     
      </form>
<?php
    } else {
?>
      <h3>Login</h3>
      <form action="/php/login.php" method="POST">
        <?php if(isset($_GET['err']) && $_GET['err']=='wup') { ?>
        <span class="tooltip" style="display:block">Wrong username or password</span><br>
        <?php } ?>
        <input type="text" name="username" placeholder="Username or Email" required style="width:60%">
        <input type="password" name="password" placeholder="Password" required style="width:60%">
        
        <p style="margin-bottom:10px;"><a href="/register/forgot_password" >Forgot password?</a></p>
        <p style="margin-bottom:10px;"><a href="/?log=signup" class="dark-blue" >Not a member yet? Click here to sign up fast!</a></p>
        
        <input type="submit" value="login">
      </form>
<?php
    }
?>
    </div>




    

    
  <div class="col-1 " style="background:#00afe8;padding-top:6%;float:left;">

    <div class="col-1" style="text-align:left;">
      <div class="icon intro-icon fxstar-white"></div>
      <h3 class="white" style="margin-top:10px">fxStar</h3>
      <p class="white" style="font-size:0.9rem">Purchase products/services, or send/recieve as gift.</p>
    </div>

    <div class="col-1 " style="text-align:left">
      <div class="icon intro-icon fxuniversity-white"></div>
      <h3 class="white" style="margin-top:10px">fxUniversity</h3>
      <p class="white" style="font-size:0.9rem">Create courses as instructor & make fxStars, or browse to take them as student.</p>
    </div>


    <div class="col-1 " style="text-align:left">
      <div class="icon intro-icon fxpartner-white"></div>
      <h3 class="white" style="margin-top:10px">fxPartner</h3>
      <p class="white" style="font-size:0.9rem">Partner us & make easy fxStars.</p>
    </div>

    <div class="col-1 " style="text-align:left">
      <div class="icon intro-icon fxuniverse-white"></div>
      <h3 class="white" style="margin-top:10px">fxUniverse</h3>
      <p class="white" style="font-size:0.9rem">Universe of trading (Coming soon for public)</p>
    </div> 

    <div class="col-1 " style="text-align:left">
      <div class="icon intro-icon fxsonet-white"></div>
      <h3 class="white" style="margin-top:10px">fxSonet</h3>
      <p class="white" style="font-size:0.9rem">Next level of worldwide connection (Coming soon for public)</p>                   
    </div>
    
    
</div>
   

</div>

                                                

<div class="footer"></div>
<script src="/js/footer.js"></script>



                                                       

<!-- Tidy Cols -->
<script>
if(screen.width<480) {
    $('#deskView').hide();
    $('#phoneView').show();
}
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

<script>
$('#regForm').submit(function(event) {
    if(($('#pass').val().length <= 8) || ($('#confpass').val()!=$('#pass').val()) || !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#deskEmail').val()))) {
        event.preventDefault();
        alert('Enter valid data please!');
    }
});
</script>







<!-- PHONE VIEW JS -->
<!-- Email Validation -->
<script type="text/javascript">
$('#phoneEmail').each(function() {
  var elem=$(this);

  // current val
  elem.data('oldVal', elem.val());

  //look for changes
  elem.bind("propertychange change click keyup input paste", function(event) {
    if(elem.data('oldVal')!=elem.val()) {
      elem.data('oldVal', elem.val());

      if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(elem.val())) {
          $('#phoneBadEmail').hide();
          jQuery.ajax({
            type: 'POST',
            url: '/php/dup_email.php',
            data: $('#phoneEmail').serialize(),
            success: function(data) {
              if(data=='dup') {
                  $('#phoneDupEmail').show();
              } else {
                  $('#phoneDupEmail').hide();
              }
            }
          });
      } else {
          $('#phoneBadEmail').show();
      }
    }
  });
});
</script>


<!-- Bad Password -->
<script type="text/javascript">
$('#phonePass').each(function() {
  var elem1=$(this);
  elem1.data('oldVal', elem1.val());
  elem1.bind("propertychange change click keyup input paste", function(event) {
    if(elem1.data('oldVal')!=elem1.val()) {
      elem1.data('oldVal', elem1.val());
  
      if(elem1.val().length > 8) {
        $('#phoneBadPass').hide();
      } else {
        $('#phoneBadPass').show();
      }
    }
  });
});
</script>

<!-- Password Confirmation -->
<script type="text/javascript">
    $('#phoneConfpass').each(function() {
        var elem2=$(this);
        elem2.data('oldVal', elem2.val());
        elem2.bind("propertychange change click keyup input paste", function(event) {
            if(elem2.data('oldVal')!=elem2.val()) {
                elem2.data('oldVal', elem2.val());
                if(elem2.val()!=$('#phonePass').val()) {
                    $('#phoneNoMatch').show();
                } else {
                    $('#phoneNoMatch').hide();
                }
            }
        });
    });                     
</script>


<script>
$('#phoneRegForm').submit(function(event) {
    if(($('#phonePass').val().length <= 8) || ($('#phoneConfpass').val()!=$('#phonePass').val()) || !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#phoneEmail').val()))) {
        event.preventDefault();
        alert('Enter valid data please!');
    }
});
</script>
</body>
</html>