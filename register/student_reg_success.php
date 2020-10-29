<?php
session_start();
require('connect.php');

if($_SESSION['username']) {
  $username = $_SESSION['username'];
  require('../php/get_user.php');
}


$student_existence_query = "SELECT * FROM plans WHERE id=$get_user_id";
$student_existence_result = mysqli_query($connection, $student_existence_query) or die(mysqli_error($connection));
$student_existence_count = mysqli_num_rows($student_existence_result);

if(isset($_POST['phone']) && !empty($_POST['phone'])) {
  $phone = $_POST['phone'];
  $student_phone_query = "UPDATE user SET phone='$phone' WHERE username='$username'";
  $student_phone_result = mysqli_query($connection, $student_phone_query) or die(mysqli_error($connection));
}

if($student_existence_count > 0) {
  if($fxuniversitystu) {
    $student_existence = 1;
  } else {
    $student_existence = 0;
    $student_update_query = "UPDATE plans SET fxuniversitystu_req = 1, fxuniversitystu = 1 WHERE id=$get_user_id";
    $student_update_result = mysqli_query($connection, $student_update_query) or die(mysqli_error($connection));
  }
} else {
  $student_query = "INSERT INTO plans(id, fxuniversitystu_req, fxuniversitystu) VALUES($get_user_id, 1, 1)";
  $student_result = mysqli_query($connection, $student_query) or die(mysqli_error($connection));
  if($student_result) {
    $msg = "Submitted successfully";
  } else {
    $msg = "Error in submittion!";
  }
  $student_existence = 0;
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
		  <?php if(!$student_existence) { ?>
		    <h2 style="color: #FFF">Congratulations! You are now an fxStudent!</h2><h3 style="color: #FFF">Now let's start learning by going to the student dashboard.</h2>
		  <?php } else { ?>
		    <h2 style="color: #FFF">You are already a student!</h2>
		    <h3 style="color: #FFF"><a href="/#contact-section">Contact us</a> for possible difficulties you may have encountered.</h3>
		  <?php } ?>
		  <form action="/userpgs/student">
		    <input type="submit" class="btn btn-primary btn-pill" value="Student Dashboard">
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