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
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
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
		 $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxpartner-bar-items"><a href="/userpgs/partner/positions" class="link-main" id="active-main"><div class="head">fxHR</div></a></div><div class="bar-items fxpartner-bar-items"><a href="/userpgs/partner/income" class="link-main"><div class="head">Earnings History</div></a></div></div>');
	     });
	 }
	</script>
	<div class="blur mobile-main">



<div class="sidebar"></div>
	<?php require('../../../php/sidebar.php'); ?>



  <div class="relative-main-content">
  <div class="inner-content-box inner-content-margin">
                          <h2>fxHR</h2>
                          
<p>Share the following link with your friends who are not an fxUnivers user yet. Right after they register, we will share 50% of the profit gained from those users from any fxUnivers platform for 90 days.</p>

<input type="text" id="theLink" class="txt-input" value="https://fxunivers.com/?partner=<?php echo $username?>" readonly>
<button class="submit-btn" id="cpLink">Copy</button>



  </div>
  </div>
</div>

<div class="footbar blur"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>


                          <!-- SCRIPTS -->
<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>


<script>
$('#page-header').html('fxPartner');
$('#page-header').attr('href','/userpgs/partner');
</script>


<!-- fxPartner sidebar active -->
<script>
$('.fxpartner-sidebar').attr('id','sidebar-active');
</script>

<script>
$('#cpLink').click(function() {
  var copyText=document.getElementById('theLink');
  copyText.select();
  copyText.setSelectionRange(0,99999);
  document.execCommand('copy');

  $('#cpLink').text('Copied');
  $('#cpLink').css('opacity','0.6');
});
</script>



</body>
</html>
