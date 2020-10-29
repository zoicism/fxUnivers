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
    header('Location: /register/logout.php');
    exit();
}

require('../../php/get_user.php');
$id = $get_user_id;

require('../../userpgs/php/notif.php');

require('../../php/get_plans.php');

require('../../php/get_rel.php');

require('../php/get_fxcoin_count.php');

//require('../php/get_trans.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Buy fxStar</title>
    <meta charset="utf-8">
	<link rel="stylesheet" href="sidebarstyle.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <script src="/js/jquery-3.4.1.min.js"></script>

    <!-- to Sandbox Paypal acnt -->
    <script src="https://www.paypal.com/sdk/js?client-id=AamVi8YxFRCNHDKC8cNfMuhM7IoNwGFbx59cMUQrd-Wd6d53EjjhhHJoWtCQeIXXxIIUCTfY6iVZ1gRQ"></script>
    
    <!-- to real-world Paypal acnt -->
    <!--<script src="https://www.paypal.com/sdk/js?client-id=ARS5GFZ290HgkTD6KmPQ1Y5CRxPgZ6GIBwDQ3j4b_NKzQhPXYciKGOSlINhE93SmEZ6SKR47wohz4h6M"></script>-->
</head>
    
<body>
	<div class="header-sidebar"></div>
    <script src="/js/upperbar.js"></script>


    
	<div class="sidebar">
		<div class="logo-sidebar logo-25"></div>
		<div>
            <?php
                    $path="../../userpgs/avatars/";
                    if(file_exists($path.$get_user_id.'.jpg')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../../userpgs/avatars/'.$get_user_id.'.jpg\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.jpeg')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../../userpgs/avatars/'.$get_user_id.'.jpeg\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.png')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../../userpgs/avatars/'.$get_user_id.'.png\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.gif')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../../userpgs/avatars/'.$get_user_id.'.gif\');"></a>');
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
	    <div class="socialmedia">
			<a href="#" class="sm facebook"></a>
			<a href="#" class="sm instagram"></a>
			<a href="#" class="sm twitter"></a>
			<a href="#" class="policy">Policy</a>

                          <div class="copyright">
                          With all due Reserves, © fxUnivers 
                          </div>
                          <div class="copyright">
                          2017-2020 All rights reserved.
                          </div>
  		</div>

                          
	</div>







                          
    <div class="main-content">

              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/wallet/buy" class="link-main" id="active-main">
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

                          <h2>Buy fxStars</h2>
<p>Number of fxStars to purchase:</p>
                          
    <input type="number" class="num-input" min="0" max="1000000000" id="fxCoinAmnt" value="1" autocomplete="off">
                          
  <p>Total cost: <strong><span id="totalCost">2</span> USD</strong></p>
                          
  <div id="paypal-button-container"></div>


</div>
  </div>


  <!-- SCRIPTS -->
                          <script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>

<script src="/js/notif_msg.js"></script>

<script>
                $("#fxCoinAmnt").each(function() {
                    var elem=$(this);

                    //current value
                    elem.data('oldVal', elem.val());
                    
                    // look for changes
                       elem.bind("propertychange change click keyup input paste", function(event) {
                           if(elem.data('oldVal')!=elem.val()) {
                               elem.data('oldVal', elem.val());
                               
                               //$('#totalCost').html('OK');
                               //var numfxs=$("#fxCoinAmnt").val();
                               //var tCost=ceil(numfxs*0.1)+numfxs;
                               $("#totalCost").html(Math.ceil(elem.val()*0.1)+parseInt(elem.val()));
                           }
                       });
                       
                       
                });
</script>


<script>


  paypal.Buttons({
    createOrder: function(data, actions) {
      var amntTxt = document.getElementById("fxCoinAmnt").value;
      var amntToBase10 = parseInt(amntTxt, 10);
      var amntPlusIn=amntToBase10+parseInt(Math.ceil(amntToBase10*0.1));
      var amnt = amntPlusIn.toString();
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: amnt
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      
      var amntTxt = document.getElementById("fxCoinAmnt").value;
      var amntToBase10 = parseInt(amntTxt, 10);
      return actions.order.capture().then(function(details) {
          jQuery.ajax({
	      data: 'numOfFxCoins=' + amntToBase10,
	      url: '../php/buy_coin.php',
          method: 'POST',
	      success: function(msg) {
	        
	      }   
	    });
	    alert('Transaction completed by ' + details.payer.name.given_name);
        
	    
	    location.reload();
        // Call your server to save the transaction
        return fetch('/paypal-transaction-complete', {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            orderID: data.orderID
          })
        });
      });
    }
  }).render('#paypal-button-container');



</script>
<script>
var inputNum = document.getElementById('fxCoinAmnt');
inputNum.onkeydown = function(e) {
  if(!((e.keyCode>95 && e.keyCode<106) || (e.keyCode > 47 && e.keyCode < 58) || e.keyCode == 8)) {
    return false;
  }
}
</script>
<script>
var inputNum = document.getElementById('fxCoinAmnt');
inputNum.oninput = function() {
  if(this.value.length > 10) {
    this.value = this.value.slice(0,10);
  }
}
</script>
</body>
</html>