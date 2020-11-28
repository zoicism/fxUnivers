<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/

session_start();
require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
	header("Location: /register/logout.php");
    exit();
}

require('../../../php/get_user.php');
$id = $get_user_id;

require('../../php/notif.php');

require('../../../php/get_plans.php');

require('../../../php/get_rel.php');

require('../../../php/get_partner.php');

require('../../../wallet/php/get_fxcoin_count.php');

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
    <style>.col-1 p {text-align:left}</style>
    <script src="/js/jquery-3.4.1.min.js"></script>
    </head>

<body>

<div class="upperbar"></div>
<script src="/js/upperbar.js"></script>

<div class="col-33 left-col">
<div class="col-1" id="oneone">
  <h3>HR</h3>
  <p>By clicking on any of the positions the link will be copied to your clipboard so that you can share it with your potential clients. If they accept, you will get a 50% share from the profit of their activities for 90 days.</p>
  <p>You can also share this link generally:</p>
    <input type="text" style="width:auto" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="cpLink" readonly>
</div>
</div>

    <div class="col-33 mid-col">

<div class="col-1 pointer " id="onetwo">
  <h3>fxInstructor</h3>
  <p>We need technical university partners to bring university professional staff to do business with us together for income/profit.</p>
</div>

<div class="col-1 pointer " id="onethree">
  <h3>fxPartner</h3>
  <p>We need partners to bring in professional staff to do business with us together for income/profit.  Partners help with talent acquisition and guidance to new users in order to succeed and generate revenue for profit sharing.</p>
</div>

<div class="col-1 pointer " id="twoone">
  <h3>fxTeacher</h3>
  <p>We need teaching partners to teach, create teaching materials, and bring more professional teachers to do business with us together for income/profit.</p>
</div>

<div class="col-1 pointer " id="twotwo">
  <h3>fxTrainer</h3>
  <p>We need trainers to train our trainees within any expertise and do business with us together for income/profit.</p>
</div>

<div class="col-1 pointer " id="twothree">
  <h3>fxExecutive</h3>
  <p>We need executives to recruit and manage specialty partners while monitor and grow generated revenue within any expertise to do business with us together for income/profit.</p>
</div>

<div class="col-1 pointer " id="threeone">
  <h3>fxAnalyst</h3>
  <p>We need Analysts to analyze the current markets and maximize generated revenue within any expertise to do business with us together for income/profit.</p>
</div>

<div class="col-1 pointer " id="threetwo">
  <h3>fxSalesman</h3>
  <p>We need Sales professionals to sell our products that are highly demanded from teaching materials, courses, services, to financial platforms, manage contracts within any markets and maintain business with us together for income/profit.</p>
</div>

<div class="col-1 pointer " id="threethree">
  <h3>fxMarketer</h3>
  <p>We need Marketing professionals to analyze the current markets and promote and do marketing of our products and services that are highly demanded from teaching materials, courses, services, to financial platforms, manage contracts within any markets and maintain business with us together for income/profit.</p>
</div>

<div class="col-1 pointer " id="fourone">
  <h3>fxHR</h3>
  <p>We need Human Resources professionals to analyze the current hiring markets and recruit workforce for our many services to be offered.  Talent acquisition is one of our top priority areas of investment as our main assets are talents absorbed to maintain business with us together for income/profit.</p>
</div>

<div class="col-1 pointer " id="fourtwo">
  <h3>fxDoctor</h3>
  <p>We need Doctors of all specialties to: 1. Teach/train students. 2. Create/Provide informative solutions and materials for general public seeking doctor’s advise/sessions.</p>
</div>

<div class="col-1 pointer " id="fourthree">
  <h3>fxNurse</h3>
  <p>We need Nurses of all specialties to: 1. Teach/train other nurses. 2. Create/Provide informative solutions and materials for general public seeking nurse’s advise/sessions.</p>
</div>

<div class="col-1 pointer " id="fiveone">
  <h3>fxSpecialist</h3>
  <p>We need Specialists of all specialties to: 1. Teach/train other specialists. 2. Create/Provide informative solutions and materials for general public seeking specialist’s advise/sessions.</p>
</div>

<div class="col-1 pointer " id="fivetwo">
  <h3>fxProfessor</h3>
  <p>We need Professors of all specialties to: 1. Teach/train other professors. 2. Teach/train students. 3. Create/Provide informative solutions and sessions for general public seeking professor’s private sessions.</p>
</div>
</div>

   <div class="footer"></div>
<script src="/js/footer.js"></script>

<div class="footbar"></div>
<script src="/js/footbar.js"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>

<script src="/js/notif_msg.js"></script>

<script>
                $('.col-1').click(function() {

                    var copyText=document.getElementById('cpLink');
                    copyText.select();
                    copyText.setSelectionRange(0,99999);
                    document.execCommand('copy');
                    
                    var h3=$(this).find('h3').text();
                    alert('Partner link is copied to the clipboard. Share it and gain fxStars!');
                });
</script>

</body>
</html>