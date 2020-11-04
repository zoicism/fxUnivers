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
    header('Location: /register/logout.php');
    exit();
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
    <script src="/js/upperbar.js"></script>

<div class="blur mobile-main">
    
	<div class="sidebar">
		<div class="logo-sidebar logo-25"></div>
		<div>
            <?php
                    $path="../userpgs/avatars/";
                    if(file_exists($path.$get_user_id.'.jpg')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../userpgs/avatars/'.$get_user_id.'.jpg\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.jpeg')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../userpgs/avatars/'.$get_user_id.'.jpeg\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.png')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../userpgs/avatars/'.$get_user_id.'.png\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.gif')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../userpgs/avatars/'.$get_user_id.'.gif\');"></a>');
                    } else {
                        echo('<a class="link avatar-sidebar"></a>');
                    }
                ?>
			<a class="id-sidebar" href="#">@Neo</a>
		</div>
		<div class="elements">
		    <a href="/wallet" class="sidebar-icon fxstar-sidebar" id="sidebar-active">fxStar</a>
		    <a href="#" class="sidebar-icon fxuniversity-sidebar">fxUniversity</a>
		    <a href="#" class="sidebar-icon fxpartner-sidebar">fxPartner</a>
		    <a href="#" class="sidebar-icon fxuniverse-sidebar">fxUniverse</a>
		    <a href="#" class="sidebar-icon fxsonet-sidebar">fxSonet</a>
		    
	    </div>
                          <div class="policy">
                          With all due Reserves, © fxUnivers 2017-2020 All rights reserved. <a href="#">Policy</a>
                          </div>
	</div>







                          
    <div class="main-content">

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





  <div class="relative-main-content">
                            <div class="content-box">
                              <h2>fxStar</h2>
                              <p>Balance: <strong><?php echo $get_fxcoin_count?> fxStars</strong></p>
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








                          <div class="description" style="margin-bottom:55px;font-size:0.6rem;">
                          <h2 style="width:100%;font-size:1rem">fxStar Functions</h2>
                          <h3 style="font-size:0.8rem">Buy fxStars</h3>
<p style="font-size:0.8rem">To use most parts of the fxUnivers you need fxStars and here is where you can buy some. 10 fxStars cost 11 USD.</p>

                          <h3 style="font-size:0.8rem">Cash-out fxStars</h3>
                          <p style="font-size:0.8rem">With a minimum number of 100 fxStars you can request cash-outs which may take place within 3 business days. Coming soon, you will also be able to request cash-outs with various cryptocurrencies.</p>
                          

                          <h3 style="font-size:0.8rem">Transactions</h3>
                          <p style="font-size:0.8rem">The history of your fxStar transactions.</p>

                          <h3 style="font-size:0.8rem">Send fxStars</h3>
                          <p style="font-size:0.8rem">Send your friends fxStars instantly and securely! They will get the fxStars and be informed of the transaction right away.</p>

                          <h3 style="font-size:0.8rem">Request fxStars</h3>
                          <p style="font-size:0.8rem">Request a specific number of fxStars from friends! They will get informed immediately and may send you the requested ammount with one click.</p>
                        </div>
  </div>




                          
 </div>                         
                        


                          <div class="footbar blur"></div>
                          <script src="/js/footbar.js"></script>






                          <!-- SCRIPTS -->

  <script>
                          $('#page-header').html('fxStar');
$('#page-header').attr('href','/wallet');
</script>

</body>
</html>
