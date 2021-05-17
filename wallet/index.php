<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
   $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   header("Location: $url");
   exit;
   }*/

session_start();
require('../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

require('../php/get_user.php');
$id = $get_user_id;

require('../userpgs/php/notif.php');

require('../php/get_plans.php');

require('../php/get_rel.php');

require('php/get_fxcoin_count.php');

//require('../php/get_trans.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>fxStar</title>
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
     $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items"><a href="/wallet/buy" class="link-main"><div class="head">Buy fxStars</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Buy fxStars and use them to enroll in courses.</p></div></div><div class="bar-items"><a href="/wallet/send" class="link-main"><div class="head">Transfer</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Send fxStars to friends securely and instantaneously.</p></div></div><div class="bar-items"><a href="/wallet/req" class="link-main"><div class="head">Request</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Request fxStars from friends and the transaction will take place as soon as they accept it.</p></div></div><div class="bar-items"><a href="/wallet/txn" class="link-main"><div class="head">Transactions</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">History of fxStar transactions.</p></div></div><div class="bar-items"><a href="/wallet/cashout" class="link-main"><div class="head">Cash-out</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Request cash-out within 3-business-day delivery in USD, coming soon in all major cryptocurrencies.</p></div></div></div>');
     $('.bar-items').hover(function() {
         $(this).find('.extra-info-cnt').css('width',$(this).css('width')).show();
     }, function() {
         $(this).find('.extra-info-cnt').hide();
     });
       });
   }
  </script>
  <div class="blur mobile-main">
    
  <div class="sidebar"></div>
  <?php require('../php/sidebar.php'); ?>

                          
    <!--<div class="main-content">
  
              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/wallet/buy" class="link-main">
                          <div class="head">Buy fxStars</div>
        
          </a>
          <div class="extra-info-cnt" style="display:none">
        <p class="extra-info">Buy fxStars and use them to enroll in courses.</p>
          </div>
          
                  </li>
                  <li class="main-items">
                      <a href="/wallet/cashout" class="link-main">
                          <div class="head">Cash-out fxStars</div>
                      </a>
          <div class="extra-info-cnt" style="display:none">
        <p class="extra-info">Request cash-out within 3-business-day delivery in USD, coming soon in all major cryptocurrencies.</p>
          </div>
                  </li>
                  <li class="main-items">
                      <a href="/wallet/txn" class="link-main">
                          <div class="head">Transactions</div>
                      </a>
          <div class="extra-info-cnt" style="display:none">
        <p class="extra-info">History of fxStar transactions.</p>
          </div>
                  </li>
                  <li class="main-items">
                      <a href="/wallet/send" class="link-main">
                          <div class="head">Send fxStars</div>
                      </a>
          <div class="extra-info-cnt" style="display:none">
        <p class="extra-info">Send fxStars to friends securely and instantaneously.</p>
          </div>
                  </li>
                  <li class="main-items">
                      <a href="/wallet/req" class="link-main">
                          <div class="head">Request fxStars</div>
                      </a>
          <div class="extra-info-cnt" style="display:none">
        <p class="extra-info">Request fxStars from friends and the transaction will take place as soon as they accept it.</p>
          </div>
                  </li>
              </ul>

    </div>-->





  <div class="relative-main-content">
                            <div class="content-box">
        <h2>fxStar Balance</h2>
        <div class="icon-txt" style="opacity:1;font-size:1.6rem;">
            <p><div class="fxstar-price"></div><?php echo $get_fxcoin_count?></p>
        </div>
                            </div>




                          <div class="main-content-mob">

              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/wallet/buy" class="link-main">
                          <div class="head">Buy fxStars</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/wallet/cashout" class="link-main">
                          <div class="head">Cash-out fxStars</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/wallet/txn" class="link-main">
                          <div class="head">Transactions</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/wallet/send" class="link-main">
                          <div class="head">Send fxStars</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/wallet/req" class="link-main">
                          <div class="head">Request fxStars</div>
                      </a>
                  </li>
              </ul>

                          </div>








                          <div class="description">
            <h3>What to use fxStars for?</h3>
            <p>You can use fxStars to:</p>
            <ul>
          <li>
              <p>Enroll in courses and make fxStars by creating fxSubCourses. <a href="/about#fxuniversity" >Learn more</a></p>
          </li>
          <li>
              <p>Send fxStars to your friends securely and instantaneously.</p>
          </li>
            </ul>
                          <h3>How to Buy fxStars</h3>
                          <p>Click on the <a href="/wallet/buy" ><strong>Buy fxStars</strong></a> above to buy fxStars. The cost of 10 fxStars is 11 USD.</p>

        <h3>How to Transfer fxStars</h3>
        <p>Click on the <a href="/wallet/send" ><strong>Transfer</strong></a> above, enter how many fxStars and to whom you wish to send, and your friends will receive the fxStars instantly and securely! They will be informed of the transaction right away.</p>

        <h3>How to Request fxStars</h3>
        <p>Click on the <strong><a href="/wallet/req" >Request</a></strong> above and request a specific number of fxStars from any of your friends. They will get informed immediately and will send you the requested amount if they want to, with just one click.</p>

        <h3>How to see the Transactions</h3>
        <p>Click on the <strong><a href="/wallet/txn" >Transactions</a></strong> above to get a list of all your incoming and outgoing transactions.</p>

        <h3>How to Cash-out</h3>
        <p>Click on the <strong><a href="/wallet/cashout" >Cash-out</a></strong> and submit a cash-out request of at least 100 fxStars which will take place within 3 business days. Coming soon, you will also be able to request instantaneous cash-outs with various cryptocurrencies.</p>                     
                        </div>
  </div>




                          
 </div>                         
                        


                          <div class="footbar blur"></div>
                          <script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>






                          <!-- SCRIPTS -->

  <script>
                          $('#page-header').html('fxStar');
$('#page-header').attr('href','/wallet');
</script>


<!-- fxStar sidebar active -->
<script>
 $('.fxstar-sidebar').attr('id','sidebar-active');
</script>

<script>
 
 
</script>
</body>
</html>
