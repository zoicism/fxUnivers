<?php
session_start();
require('connect.php');

if($_SESSION['username']) {
  $username = $_SESSION['username'];
  require('../php/get_user.php');
} else {
    header('Location: /');
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <title>Email Verification</title>
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
		  <form action="/register/student_reg_success.php" method="POST" class="form-box" autocomplete="off">
		    <h3 class="h4 text-black mb-4">Good day, dear <?php echo $get_user_fname ?>,</h3>
    <p style="color:black">Click on the button below to extend your fxUnivers plan as a student!</p>
    <p style="color:black">By registering as a student, you are agreeing to our <a onclick="regPop()" style="cursor:pointer;color:#8bcae5;">registration policy</a> and <a onclick="policyPop()" style="cursor:pointer;color:#8bcae5;">terms and conditions</a>.</p>
    
    <p style="font-size: 0.7rem;color:#25252510; display:none;color:black;" id="registerP"><strong>Registration Policy</strong><br/>By joining fxUnivers, users agree to be part of fxUnivers products/services. fxUnivers reserves the right to offer services to only certain individuals/companies at its own discretion.  Also can revoke/terminate services from any individual/company without cause/reason at any given time, by discretion, upon settlement offered by fxUnivers when applicable. By subscribing or using any fxUnivers services/products, users agree fxUnivers is not to be blamed for any kind of responsibilities, liabilities, damages, occurrences, harassment, losses, misinformation, misinterpretation, misusing, misunderstanding, mistaking, mispresenting, nor negativity.  All such behaviors are solely at risk of users while fxUnivers is to be used by choice only, in a way fxUnivers is not responsible for anything.  By using fxUnivers services, users waive all rights to take any legal or other actions against fxUnivers, its employees, developers, owners, and affiliates.  In case of any disputes or issues, users agree to communicate with fxUnivers and raise/discuss the issue, and fxUnivers is expected to review the issue and propose the resolution which should be taken as final and accepted by users (users elect by choice to accept all fxUnivers decisions as final in advance). By subscribing, all users accept any materials, courses, videos, or contects shared via fxUnivers is opinion based by other users and shall not carry any liability, advise, value, nor weight of any kind; using such data is pure choice of users and fxUnivers is not responsible for any of contents nor behaviors of any kind. fxUnivers takes privacy seriously and does not share any private data to any third parties/authorities nor is responsible for behavior of users.</p>
<p style="font-size: 0.7rem;color:#25252510; display:none;color:black;" id="policyP"><strong>Terms of Use</strong><br/>fxUnivers reserves the right to offer services to only certain individuals/companies at its own discretion.  Also can revoke/terminate services from any individual/company without cause/reason at any given time, by discretion, upon settlement offered by fxUnivers when applicable. By subscribing or using any fxUnivers services/products, users agree fxUnivers is not to be blamed for any kind of responsibilities, liabilities, damages, occurrences, harassment, losses, misinformation, misinterpretation, misusing, misunderstanding, mistaking, mispresenting, nor negativity.  All such behaviors are solely at risk of users while fxUnivers is to be used by choice only, in a way fxUnivers is not responsible for anything.  By using fxUnivers services, users waive all rights to take any legal or other actions against fxUnivers, its employees, developers, owners, and affiliates.  In case of any disputes or issues, users agree to communicate with fxUnivers and raise/discuss the issue, and fxUnivers is expected to review the issue and propose the resolution which should be taken as final and accepted by users (users elect by choice to accept all fxUnivers decisions as final in advance). By subscribing, all users accept any materials, courses, videos, or contects shared via fxUnivers is opinion based by other users and shall not carry any liability, advise, value, nor weight of any kind; using such data is pure choice of users and fxUnivers is not responsible for any of contents nor behaviors of any kind. fxUnivers takes privacy seriously and does not share any private data to any third parties/authorities nor is responsible for behavior of users.</p>
    
		    <?php if($get_user_phone == "NA") { ?>
		    <div class="form-group">
		      <input type="text" name="phone" class="form-control" placeholder="Phone Number (required)" required>
		    </div>
		    <?php } ?>
		    
		    <div class="form-group">
		      <input type="submit" class="btn btn-primary btn-pill" value="Agree and Register!">
		    </div>
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
<script src="/first/js/jquery-3.3.1.min.js"></script>
<script>
    function regPop() {
        $('#registerP').toggle();
        $('#policyP').hide();
    }
</script>
<script>
function policyPop() {
    $('#policyP').toggle();
    $('#registerP').hide();
}
</script>
</body>
</html>