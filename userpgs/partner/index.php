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

<style>
  @media(max-width:629px) {
  .header-sidebar {
  margin:0;
  }
}
</style>
  </head>
    
  <body>
  <div class="header-sidebar"></div>
  <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
  <script>
  if(screen.width >= 629) {
    $(document).ready(function() {
	$('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxpartner-bar-items"><a href="/userpgs/partner/positions" class="link-main"><div class="head">fxHR</div>\
</a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Copy and share the link provided here and we will share our interests with you.</p></div></div><div class="bar-items fxpartner-bar-items"><a href="/userpgs/partner/income" class="link-main"><div class="head">Earnings History</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">History of the income you have made by sharing your fxHR link and building up our workforce</p></div></div></div>');
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
      <div class="contentbox-bg fxpartner-contentbox">
	  <svg viewBox="0 0 273.7 116"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M156.9,96.8,139.3,81.6l17.5,15.1Z"></path><path class="cls-1" d="M225,54.5l-17.5-50a4.5,4.5,0,0,0-5.8-2.8L183.9,7.9a4.7,4.7,0,0,0-2.9,5.9l.5,1.2-6.6,2.8a6.9,6.9,0,0,1-4,.5l-3.1-.7q-10.2-2-20.4-3.3l-8.1-1.1a10.8,10.8,0,0,0-6.6,1.3,10.9,10.9,0,0,0-1.7,1.3l-6.9,6H107.2l-9-5.4.3-.5a4.6,4.6,0,0,0-1.8-6.2L80.1.6A4.7,4.7,0,0,0,76.6.3a4.5,4.5,0,0,0-2.7,2.2L48.6,49a4.1,4.1,0,0,0-.4,3.4,4.4,4.4,0,0,0,2.2,2.8l16.6,9a4.3,4.3,0,0,0,2.2.6l1.3-.2a4.9,4.9,0,0,0,2.7-2.2l1.2-2.2,3.7,2.7a11.6,11.6,0,0,1,2.6,2.8l4.4,6.9-.7.9a7.2,7.2,0,0,0-1.6,4.4,7,7,0,0,0,2.6,5.4,6.8,6.8,0,0,0,4.4,1.6,6.9,6.9,0,0,0,2.5-.4,7.4,7.4,0,0,0-.8,3.9,7,7,0,0,0,2.6,4.8,6.9,6.9,0,0,0,4.4,1.5,8,8,0,0,0,3.3-.8,6.3,6.3,0,0,0-.3,2.7,7.1,7.1,0,0,0,2.5,4.7,6.9,6.9,0,0,0,7.8.7,7.6,7.6,0,0,0-.3,2.1,7.1,7.1,0,0,0,2.5,5.4,7.3,7.3,0,0,0,4.4,1.5,7,7,0,0,0,5.5-2.5l1-1.3,8.2,7a7.3,7.3,0,0,0,5,1.9,7.6,7.6,0,0,0,5.8-2.7,7.3,7.3,0,0,0,1.4-7.3l2,1.6a7.4,7.4,0,0,0,5.1,1.9h.6a7.6,7.6,0,0,0,5.3-2.7,7.8,7.8,0,0,0,1.5-7.6l.5.5a8.6,8.6,0,0,0,5.4,2,8.3,8.3,0,0,0,6.3-2.9,8.1,8.1,0,0,0,2-6,8.7,8.7,0,0,0-.5-2.2l.4.3a7.4,7.4,0,0,0,5.1,2h.6a7.5,7.5,0,0,0,5.4-2.7,7.8,7.8,0,0,0-.8-11.1l-3.8-3.4a46.2,46.2,0,0,0,12.3-10,10,10,0,0,1,4.3-2.9l1.1-.3.4,1.2a4.5,4.5,0,0,0,4.3,3.1,4,4,0,0,0,1.5-.3l17.9-6.2A4.6,4.6,0,0,0,225,54.5ZM73.5,59.6l-1.2,2.3a3.4,3.4,0,0,1-2.1,1.6,3.6,3.6,0,0,1-2.7-.2L50.9,54.2a3.6,3.6,0,0,1-1.7-2.1,3.9,3.9,0,0,1,.3-2.6L74.8,3a3.9,3.9,0,0,1,2.1-1.7h1a3.3,3.3,0,0,1,1.7.4l16.6,9a3.6,3.6,0,0,1,1.4,4.8l-.3.5ZM86.1,82.5a5.8,5.8,0,0,1-2.2-4.6,5.7,5.7,0,0,1,1.4-3.7l5.3-6.5a5.8,5.8,0,0,1,4.6-2.2,5.8,5.8,0,0,1,3.7,1.3,6,6,0,0,1,2.2,4.6,6.4,6.4,0,0,1-1.3,3.7l-5.5,6.6v.2A5.9,5.9,0,0,1,86.1,82.5Zm8.6,9.8a6.1,6.1,0,0,1-2.1-4A5.7,5.7,0,0,1,93.9,84L95,82.6h.1v-.2l5.4-6.6,4-4.9a5.7,5.7,0,0,1,4-2.1h.6a5.9,5.9,0,0,1,3.7,1.4,5.9,5.9,0,0,1,.8,8.3L112,80.5l-9,11A5.9,5.9,0,0,1,94.7,92.3Zm10,8.2a5.9,5.9,0,0,1-.8-8.3l8.9-10.9a5.8,5.8,0,0,1,4.5-2.2,6.2,6.2,0,0,1,3.8,1.4,5.9,5.9,0,0,1,.8,8.3L113,99.6A5.9,5.9,0,0,1,104.7,100.5Zm18.3,7.3a5.9,5.9,0,0,1-8.3.8,5.8,5.8,0,0,1-2.2-4.5,5.9,5.9,0,0,1,1.4-3.8l3.7-4.5a5.8,5.8,0,0,1,4.5-2.2,5.9,5.9,0,0,1,3.8,1.4,5.9,5.9,0,0,1,.8,8.3Zm60.5-27.9a6.7,6.7,0,0,1,.7,9.6,6.7,6.7,0,0,1-9.6.7l-3.4-2.9L152.7,71.2l-4-3.4-.7.8,4,3.5,18.4,16a6.7,6.7,0,0,1,2.5,4.9,7,7,0,0,1-1.7,5.2A7.3,7.3,0,0,1,161,99l-3.5-3.1L140,80.8l-1.9-1.7-.7.8,1.9,1.7,17.5,15.1h.1a6.8,6.8,0,0,1,.6,9.4,6.4,6.4,0,0,1-4.6,2.3,6.2,6.2,0,0,1-4.9-1.6l-4.9-4.2-.9-.8-12.7-11-.7.8,12.7,11.1,1,.8h0a6.6,6.6,0,0,1-8.7,9.8l-8.2-7.1,2-2.3a7.1,7.1,0,0,0-1.1-9.9,6.9,6.9,0,0,0-6.6-1.2l2.8-3.4a6.8,6.8,0,0,0,1.6-4.4,7,7,0,0,0-9.3-6.7,6.2,6.2,0,0,0,1.1-4.4,7,7,0,0,0-12.4-3.8l-1.6,2.1v-.9A6.9,6.9,0,0,0,99.6,66a7.1,7.1,0,0,0-9.9,1l-3.8,4.8-4.3-6.7A12.2,12.2,0,0,0,78.7,62l-3.8-2.8L97.7,17.4l9.3,5.5h15.9l-10.2,8.9a5.3,5.3,0,0,0-1.8,3.9v23h.2a7,7,0,0,0,5.5,2.1c2.8-.2,5.5-2.3,8-6a23.6,23.6,0,0,0,3.3-8.2l.4-2.2a10.1,10.1,0,0,1,4.9-7.1l.7-.4h.2l27,23.4,18.3,15.9Zm13.2-18.1a10.8,10.8,0,0,0-4.9,3.2,43.1,43.1,0,0,1-12.3,10l-.2-.3L161.8,59.6l-27-23.4a1.3,1.3,0,0,0-1.3-.2l-.8.4a11.5,11.5,0,0,0-5.5,7.9l-.4,2.2a20.3,20.3,0,0,1-3.1,7.8c-2.3,3.4-4.7,5.3-7.2,5.5a6,6,0,0,1-4.5-1.6V35.7a3.7,3.7,0,0,1,1.4-3l12.4-10.9,5.9-5.2a9.5,9.5,0,0,1,1.6-1.2,9,9,0,0,1,5.8-1.1l8.1,1c6.8.9,13.6,2,20.3,3.4l3.2.6a7.2,7.2,0,0,0,4.6-.5l6.5-2.8,15.9,45.5Zm25.1-2.5L204,65.5a3.4,3.4,0,0,1-4.5-2.1l-.4-1.2L182.5,14.6l-.4-1.2a3.5,3.5,0,0,1,2.1-4.5L202,2.7l1.2-.2a3.5,3.5,0,0,1,3.3,2.4L224,54.8A3.6,3.6,0,0,1,221.8,59.3Z"></path><polygon class="cls-1" points="179.3 74.7 161.8 59.6 161.8 59.6 179.3 74.7"></polygon><polygon class="cls-1" points="161.8 59.6 161.8 59.6 134.8 36.2 161.8 59.6"></polygon></svg>
          <div class="content-box">
          <?php
          $total=0;
          while($row=$get_partner_result->fetch_assoc()) {
          $total+=$row['income'];
          }
          ?>
	      <div class="contentbox-word">fxPartner Earnings</div>
<div class="icon-txt">
	<svg viewBox="0 0 16 16"><defs><style>{fill: #393939;</style></defs><path d="M15.3,5.6l-4.5-.7L8.8.8A.9.9,0,0,0,7.2.8l-2,4.1L.7,5.6A.8.8,0,0,0,.3,7l3.2,3.2-.8,4.5a.9.9,0,0,0,1.3.9l4-2.1,4,2.1a.9.9,0,0,0,1.3-.9l-.8-4.5L15.7,7A.8.8,0,0,0,15.3,5.6ZM9.8,6.8H9A1.1,1.1,0,0,0,7.9,8v.5H9.8v1.7H7.9v1.7H6.2V8a2.3,2.3,0,0,1,.2-1.2A2.8,2.8,0,0,1,9,5.1h.8Z"></path></svg>
	      <p><?php echo $total ?></p>
</div>
	  </div>
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



  <div class="description fxpartner-desc-cnt">
  <h3 class="fxpartner-desc">How to make fxStars using fxPartner</h3>
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
