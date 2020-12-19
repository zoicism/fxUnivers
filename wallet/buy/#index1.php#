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

//require('../../php/get_trans.php');
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
    <script src="/js/jquery-3.4.1.min.js"></script>
    <!-- to Sandbox Paypal acnt -->
<script src="https://www.paypal.com/sdk/js?client-id=AamVi8YxFRCNHDKC8cNfMuhM7IoNwGFbx59cMUQrd-Wd6d53EjjhhHJoWtCQeIXXxIIUCTfY6iVZ1gRQ"></script>
    <!-- to real-world Paypal acnt -->
<!--<script src="https://www.paypal.com/sdk/js?client-id=ARS5GFZ290HgkTD6KmPQ1Y5CRxPgZ6GIBwDQ3j4b_NKzQhPXYciKGOSlINhE93SmEZ6SKR47wohz4h6M"></script>-->
</head>
<body>
<div class="upperbar"></div>
<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
    <div class="col-33 left-col">
<div class="col-1">
    <div class="main fxstar-color"></div>
    <div class="icon col-icon fxstar-bg" onclick="location.href='/wallet';"></div>
    
    <h3>Buy fxStars</h3>
    <p>Balance: <?php echo $get_fxcoin_count?> fxStars</p>
</div>
</div>

<div class="col-33 mid-col">
    <div class="col-1">
  <p>number of fxStars to purchase:</p>
    <input type="number" min="0" max="1000000000" id="fxCoinAmnt" value="1" autocomplete="off">
  <p>total cost (USD): <strong><span id="totalCost">2</span></strong></p>
  <div id="paypal-button-container"></div>
    </div>
</div>

                
<div class="footer"></div>
<script src="/js/footer.js"></script>

<div class="footbar"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

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