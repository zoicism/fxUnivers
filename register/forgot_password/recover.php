<?php
session_start();
require('../connect.php');

if(isset($_SESSION['username'])) {
    header('Location: /register/logout.php');
    exit();
}

if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])) {
    $email=$_GET['email'];
    $hash=$_GET['hash'];
} else {
    header('Location: /');
    exit();
}

// check hash
$forgot_q="SELECT * FROM forgot_pass WHERE email='$email' AND hash='$hash' AND used=0";
$forgot_r=mysqli_query($connection,$forgot_q) or die(mysqli_error($connection));
$forgot_count=mysqli_num_rows($forgot_r);

if($forgot_count==1) {
    $permission=1;
} else {
    $permission=0;
    header('Location: /register/forgot_password?err=exp');
    exit();
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
    <form action="/register/forgot_password/setnew.php" method="POST" autocomplete="off">
		    <h3>
<?php
    if($permission) {
        echo '<h3>Set a new password</h3>';
    } else {
        echo 'Error!';
    }
?>
</h3>
		    <p style="margin-bottom:10px">Enter your new password below.</p>
    <input type="password" name="password" id="pswd1" placeholder="New Password" required autofocus>
    <span class="tooltip" id="weakPass">Enter a stronger password</span>
    <span class="tooltip" style="background:lightgreen" id="strongPass">Acceptable!</span>
    <input type="password" name="repeat" id="pswd2" placeholder="Repeat New Password" required>
    <span class="tooltip" id="noMatch">Passwords do not match!</span>
    <input type="hidden" name="email" value="<?php echo $email ?>">
    <input type="submit" id="changebtn" value="Change Password" style="opacity:0.5" disabled>
   
		  </form>
    </div>

    <div class="footer"></div>
    <script src="/js/footer.js"></script>

<script>
  $("#pswd1").each(function() {
    var elem=$(this);
    //current value
    elem.data('oldVal', elem.val());

    // look for changes
    elem.bind("propertychange change click keyup input paste", function(event) {
    if(elem.data('oldVal')!=elem.val()) {
      elem.data('oldVal', elem.val());

      if(elem.val().length <9) {
          $('#weakPass').show();
      } else {
          $('#weakPass').hide();
      }
          
    }
  });
});
</script>
<script>
  $("#pswd2").each(function() {
    var elem2=$(this);
    //current value
    elem2.data('oldVal', elem2.val());

    // look for changes
    elem2.bind("propertychange change click keyup input paste", function(event) {
    if(elem2.data('oldVal')!=elem2.val()) {
      elem2.data('oldVal', elem2.val());

      if(elem2.val()!=$('#pswd1').val()) {
          $('#changebtn').prop('disabled',true);
          $('#changebtn').fadeTo('fast',0.5);
          $('#noMatch').show();
      } else {
          $('#changebtn').removeAttr('disabled');
          $('#changebtn').fadeTo('fast',1);
          $('#noMatch').hide();
      }
    }
    
    });
  });
</script>
    
</body>
</html>