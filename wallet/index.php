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
     $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items"><a href="/wallet/buy" class="link-main"><div class="head">Buy fxStars</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Buy fxStars and use them to enroll in courses.</p></div></div><div class="bar-items"><a href="/wallet/send" class="link-main"><div class="head">Transfer</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Send fxStars to friends securely and instantaneously.</p></div></div><div class="bar-items"><a href="/wallet/req" class="link-main"><div class="head">Request</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Request fxStars from friends and the transaction will take place as soon as they accept it.</p></div></div><div class="bar-items"><a href="/wallet/txn" class="link-main"><div class="head">Transactions</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">History of fxStar transactions.</p></div></div><div class="bar-items"><a href="/wallet/cashout" class="link-main"><div class="head">Cash-out</div></a><div class="extra-info-cnt" style="display:none"><p class="extra-info">Request cash-out within 3-business-day delivery in USD, coming soon in all major cryptocurrencies.</p></div></div></div>');
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
     <div class="contentbox-bg fxstar-contentbox">
        <svg viewBox="0 0 273.7 115"><defs><style>{fill:#efefef;}</style></defs><path d="M136.8,1.1a5.2,5.2,0,0,1,4.8,3L156.9,35l.2.5h.6l34.1,4.9a5.2,5.2,0,0,1,4.3,3.7,5,5,0,0,1-1.4,5.4L170.1,73.7l-.4.4v.5l5.8,34a5.3,5.3,0,0,1-1.1,4.4,5.6,5.6,0,0,1-6.7,1.3l-30.5-16-.5-.3-.5.3-30.4,16a6.2,6.2,0,0,1-2.6.6,5.3,5.3,0,0,1-4.1-1.9,5.7,5.7,0,0,1-1.2-4.4l5.9-34v-.5l-.4-.4L78.9,49.6a5.2,5.2,0,0,1-1.4-5.4,5.4,5.4,0,0,1,4.4-3.7L116,35.6h.6l.2-.5L132,4.1a5.4,5.4,0,0,1,4.8-3m0-1.1a6.2,6.2,0,0,0-5.7,3.6L115.8,34.5,81.7,39.4a6.4,6.4,0,0,0-3.5,11l24.6,24.1L97,108.4a6.4,6.4,0,0,0,6.3,7.6,6,6,0,0,0,3.1-.8l30.4-16,30.5,16a5.6,5.6,0,0,0,3,.8,6.5,6.5,0,0,0,6.4-7.6l-5.8-33.9,24.6-24.1a6.4,6.4,0,0,0-3.6-11l-34.1-4.9L142.6,3.6A6.4,6.4,0,0,0,136.8,0Z"></path><path d="M139.2,37.3a17,17,0,0,1,10.9,4.1l-3,3a12.2,12.2,0,0,0-7.9-2.9,12.4,12.4,0,0,0-12.4,12.3v6.8H144v4.1H126.8v7.6h11.3v4.1H126.8V87.9h-4.1V76.4h-5.9V72.3h5.9V64.7h-5.9V60.6h5.9V53.8a16.5,16.5,0,0,1,16.5-16.5m0-1.1a17.6,17.6,0,0,0-17.6,17.6v5.7h-5.9v6.3h5.9v5.4h-5.9v6.3h5.9V89h6.3V77.5h11.3V71.2H127.9V65.8h17.2V59.5H127.9V53.8a11.2,11.2,0,0,1,11.3-11.2,10.8,10.8,0,0,1,7.9,3.3h.1l4.4-4.6a17.9,17.9,0,0,0-12.4-5.1Z"></path></svg>
        <div class="content-box">
           <div class="contentbox-word">fxStar Balance</div>
           <div class="icon-txt">
		   <svg viewBox="0 0 16 16"><defs><style>{fill: #393939;</style></defs><path d="M15.3,5.6l-4.5-.7L8.8.8A.9.9,0,0,0,7.2.8l-2,4.1L.7,5.6A.8.8,0,0,0,.3,7l3.2,3.2-.8,4.5a.9.9,0,0,0,1.3.9l4-2.1,4,2.1a.9.9,0,0,0,1.3-.9l-.8-4.5L15.7,7A.8.8,0,0,0,15.3,5.6ZM9.8,6.8H9A1.1,1.1,0,0,0,7.9,8v.5H9.8v1.7H7.9v1.7H6.2V8a2.3,2.3,0,0,1,.2-1.2A2.8,2.8,0,0,1,9,5.1h.8Z"></path></svg>
						   <p><?php echo $get_fxcoin_count?></p>
           </div>
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








                          <div class="description fxstar-desc-cnt">
            <h3 class="fxstar-desc">What to use fxStars for?</h3>
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
                          <p>Click on the <a href="/wallet/buy" >Buy fxStars</a> above to buy fxStars. The cost of 10 fxStars is 11 USD.</p>

        <h3>How to Transfer fxStars</h3>
        <p>Click on the <a href="/wallet/send" >Transfer</a> above, enter how many fxStars and to whom you wish to send, and your friends will receive the fxStars instantly and securely! They will be informed of the transaction right away.</p>

        <h3>How to Request fxStars</h3>
        <p>Click on the <a href="/wallet/req" >Request</a> above and request a specific number of fxStars from any of your friends. They will get informed immediately and will send you the requested amount if they want to, with just one click.</p>

        <h3>How to see the Transactions</h3>
        <p>Click on the <a href="/wallet/txn" >Transactions</a> above to get a list of all your incoming and outgoing transactions.</p>

        <h3>How to Cash-out</h3>
        <p>Click on the <a href="/wallet/cashout" >Cash-out</a> and submit a cash-out request of at least 100 fxStars which will take place within 3 business days. Coming soon, you will also be able to request instantaneous cash-outs with various cryptocurrencies.</p>                     
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
