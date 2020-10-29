<?php
session_start();
require('connect.php');

if($_SESSION['username']) {
  $username = $_SESSION['username'];
  require('../php/get_user.php');
}

if(isset($_POST['phone']) && !empty($_POST['phone'])) {
    $phone = $_POST['phone'];
    $instructor_phone_query = "UPDATE user SET phone='$phone' WHERE username='$username'";
    $instructor_phone_result = mysqli_query($connection, $instructor_phone_query) or die(mysqli_error($connection));
}

$instructor_existence_query = "SELECT * FROM plans WHERE id=$get_user_id";
$instructor_existence_result = mysqli_query($connection, $instructor_existence_query) or die(mysqli_error($connection));
$instructor_existence_count = mysqli_num_rows($instructor_existence_result);


if($instructor_existence_count > 0) {
  $ins_update_q = "UPDATE plans SET fxuniversityins=1 WHERE id=$get_user_id";
  $ins_update_r = mysqli_query($connection, $ins_update_q) or die(mysqli_error($connection));
} else {
/*
  if(isset($_POST['cv']) && !empty($_POST['cv'])) {
    $cv = $_POST['cv'];
    $cv_query = "INSERT INTO teacher(user_id) VALUES($get_user_id)";
    $cv_result = mysqli_query($connection, $cv_query) or die(mysqli_error($connection));
  }
*/
  $instructor_query = "INSERT INTO plans(id, fxuniversityins) VALUES($get_user_id, 1)";
  $instructor_result = mysqli_query($connection, $instructor_query) or die(mysqli_error($connection));
  if($instructor_result) {
    $msg = "Submitted successfully";
  } else {
    $msg = "Error in submittion!";
  }
}






?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <title>Instructor Submission</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="/first/fonts/icomoon/style.css">

    <link rel="stylesheet" href="/first/css/bootstrap.min.css">
    <link rel="stylesheet" href="/first/css/jquery-ui.css">
    <link rel="stylesheet" href="/first/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/first/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/first/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/first/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="/first/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="/first/fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="/first/css/aos.css">
    <link rel="stylesheet" href="/first/css/style.css">
    
  </head>
  <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
  
  <div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>


    <div class="intro-section" id="home-section">
      
      <div class="slide-1" style="background-image: url('/first/images/hero_1.png');" data-stellar-background-ratio="0.5">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12">
              <div class="row align-items-center">
                <div class="col-lg-6 mb-4">
		  <img src="/images/artwork/professor.png" style="width: 320px; height: 320px; display: block; margin-left: auto; margin-right: auto;">
		</div>
		<div class="col-lg-5 ml-auto">
		  
		    <h2 style="color: #FFF">Congratulations <?php echo $username?>,<br/>You are an <strong>Instructor at fxUnivers</strong> now.</h2>
		    <p>Get started now by going to your dashboard!</p>
		  <form action="/userpgs/instructor">
		    <input type="submit" class="btn btn-primary btn-pill" value="Instructor Dashboard">
		  </form>
		</div>
              </div>
	    </div>
	  </div>
	</div>
      </div>
    </div>
  </div>
</div>

</body>
</html>