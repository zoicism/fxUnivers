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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=ARS5GFZ290HgkTD6KmPQ1Y5CRxPgZ6GIBwDQ3j4b_NKzQhPXYciKGOSlINhE93SmEZ6SKR47wohz4h6M"></script>
</head>
    
<body>
	<div class="header-sidebar"></div>
    <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
    <script>
     if(screen.width >= 629) {
	 $(document).ready(function() {
	     $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxstar-bar-items"><a href="/wallet/buy" class="link-main" id="active-main" ><div class="head">Buy fxStars</div></a></div><div class="bar-items fxstar-bar-items"><a href="/wallet/send" class="link-main"><div class="head">Transfer</div></a></div><div class="bar-items fxstar-bar-items"><a href="/wallet/req" class="link-main"><div class="head">Request</div></a></div><div class="bar-items fxstar-bar-items"><a href="/wallet/txn" class="link-main"><div class="head">Transactions</div></a></div><div class="bar-items fxstar-bar-items"><a href="/wallet/cashout" class="link-main"><div class="head">Cash-out</div></a></div></div>');
	 });
     }
    </script>

    <div class="blur mobile-main">

    



<div class="sidebar"></div>
	<?php require('../../php/sidebar.php'); ?>




<div class="relative-main-content">

<div class="inner-content-box inner-content-margin">

                          <h2>Buy fxStars</h2>
<p>Number of fxStars to purchase:</p>
                          
    <input type="number" class="num-input" min="0" max="1000000000" id="fxCoinAmnt" value="1" autocomplete="off">
                          
  <p>Total cost: <strong><span id="totalCost">2</span> USD</strong></p>
                          
  <div id="paypal-button-container"></div>


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
	      data: {'amnt': details.purchase_units[0].amount.value, 'requested': amntToBase10},
	      url: '../php/buy_coin.php',
              method: 'POST',
	      success: function(msg) {
	          console.log(msg);
		  alert('Transaction completed by ' + details.payer.name.given_name + ' ' + details.payer.name.surname);
		  window.location.reload();
	      }   
	  });
	            
	  
	  //location.reload();
        // Call your server to save the transaction
        /*return fetch('/paypal-transaction-complete', {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            orderID: data.orderID
          })
        });*/
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

<script>
                          $('#page-header').html('fxStar');
$('#page-header').attr('href','/wallet');
</script>

<!-- fxStar sidebar active -->
<script>
$('.fxstar-sidebar').attr('id','sidebar-active');
</script>
</body>
</html>
