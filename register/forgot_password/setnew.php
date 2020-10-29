<?php

session_start();
require('../connect.php');

if(isset($_SESSION['username'])) {
    header('Location: /register/logout.php');
    exit();
}

if(isset($_POST['password'])) $pswd=$_POST['password'];
if(isset($_POST['repeat'])) $rpt=$_POST['repeat'];
if(isset($_POST['email'])) $email=$_POST['email'];

if(strcmp($pswd,$rpt)==0) {
    $setnew_q="UPDATE user SET password='$pswd' WHERE email='$email'";
    $setnew_r=mysqli_query($connection,$setnew_q) or die(mysqli_error($connection));

    $setnew2_q="UPDATE forgot_pass SET used=1 WHERE email='$email'";
    $setnew2_r=mysqli_query($connection,$setnew2_q) or die(mysqli_error($connection));
    

    $ok=1;
} else {
    // pswds don't match
    $ok=0;
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
    if($ok) {
        echo '<h3>Password is set</h3>';
    }
?>
<p>Click below to log in with the new password!</p>
		  <form action="/">
		    <input style="margin-left:10px" type="submit" value="Login">
		  </form>
</div>



    <div class="footer"></div>
    <script src="/js/footer.js"></script>
</body>
</html>