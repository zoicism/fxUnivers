<?php
  // Requiring https
  /*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
    }*/

session_start();
require('../../register/connect.php');

if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
} else {
  require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

require('../../php/get_user.php');
$id = $get_user_id;

require('../php/notif.php');

require('../../php/get_plans.php');
require('../../php/get_rel.php');

require('../../php/get_partner.php');

require('../../wallet/php/get_fxcoin_count.php');
?>

<!DOCTYPE html>
<html>
<head>
<title>fxPartner</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/icons.css">
  <link rel="stylesheet" href="/css/logo.css">
  <script src="/js/jquery-3.4.1.min.js"></script>
  </head>
    
  <body>
  <div class="header-sidebar"></div>
  <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
  <script>
  if(screen.width >= 629) {
    $(document).ready(function() {
	$('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items"><a href="/userpgs/partner/positions" class="link-main"><div class="head">fxHR</div>\
</a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Copy and share the link provided here and we will share our interests with you.</p></div></div><div class="bar-items"><a href="/userpgs/partner/income" class="link-main"><div class="head">Earnings History</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">History of the income you have made by sharing your fxHR link and building up our workforce</p></div></div></div>');
	$('.bar-items').hover(function() {
	    $(this).find('.extra-info-cnt').show();
	  }, function() {
	    $(this).find('.extra-info-cnt').hide();
	  });
      });
  }
</script>

<div class="blur mobile-main">
    
  <div class="sidebar"></div>
  <?php require('../../php/sidebar.php'); ?>
<!--
<div class="main-content">

  <ul class="main-flex-container">
  <li class="main-items">
  <a href="/userpgs/partner/positions" class="link-main">
  <div class="head">fxHR</div>
  </a>
  <div class="extra-info-cnt" style="display:none">
  <p class="extra-info">Copy and share the link provided here and we will share our interests with you.</p>
  </div>
  </li>
  </li>
  <li class="main-items">
  <a href="/userpgs/partner/income" class="link-main">
  <div class="head">Earnings History</div>
  </a>
  <div class="extra-info-cnt" style="display:none">
  <p class="extra-info">History of the income you have made by sharing your fxHR link and building up our workforce</p>
  </div>

  </li>
                  
  </ul>

  </div>
-->
  <div class="relative-main-content">
  <div class="content-box">
  <?php
  $total=0;
while($row=$get_partner_result->fetch_assoc()) {
  $total+=$row['income'];
}
?>
<h2>fxPartner</h2>
<p>Earnings: <strong><?php echo $total ?> fxStars</strong></p>
</div>




<div class="main-content-mob">
  <ul class="main-flex-container">
  <li class="main-items">
  <a href="/userpgs/partner/positions" class="link-main">
  <div class="head">fxHR</div>
  </a>
  
  <li class="main-items">
  <a href="/userpgs/partner/income" class="link-main">
  <div class="head">Earnings History</div>
  </a>
  </li>
                  
  </ul>
  </div>



  <div class="description">
  <h3>How to make fxStars using fxPartner</h3>
  <p>Click on <a href="/userpgs/partner/positions/">fxHR</a> above and share the link we have decdicated to you. When your invitees register on fxUnivers using that link, you will automatically get 50% of our interests concerning them for 90 days. You can visit your <a href="/userpgs/partner/income">Earnings History</a> from all your registered invitees, right above this page.</p>
  </div>


  </div>



    


  </div>


  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>



  <!-- SCRIPTS -->
  <script>
  $('#page-header').html('fxPartner');
$('#page-header').attr('href','/userpgs/partner/index.php');
</script>


<!-- fxPartner sidebar active -->
<script>
$('.fxpartner-sidebar').attr('id','sidebar-active');
</script>

<script>
$('.main-items').hover(function() {
    $(this).find('.extra-info-cnt').css('width',$(this).css('width')).show();
  }, function() {
    $(this).find('.extra-info-cnt').hide();
  });
</script>

</body>
</html>
