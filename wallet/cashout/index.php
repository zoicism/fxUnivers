<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/

session_start();
require('../../register/connect.php');
require('../php/wallet_connect.php');

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
<div class="blur mobile-main">



<div class="sidebar"></div>
<?php require('../../php/sidebar.php'); ?>



  <div class="main-content">

              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/wallet/buy" class="link-main">
                          <div class="head">Buy fxStars</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/wallet/cashout" class="link-main" id="active-main">
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

                          <h2>Request Cash-out</h2>
                          <p>Your current balance: <strong><?php echo $get_fxcoin_count?> fxStars</strong></p>
                          <p>You need a minimum of 100 fxStars to request cash-out.</p>

                          <form id="cashout-form" method="POST">
                          <input type="hidden" name="user_id" value="<?php echo $get_user_id?>">
                          <input type="number" class="num-input" name="amnt" id="amntinput" placeholder="How many fxStars" min="100" max="<?php echo $get_fxcoin_count?>" value="100" required>
                          <input type="hidden" name="coin_count" value="<?php echo $get_fxcoin_count?>">
                          <p>Total cash-out amount: <strong><span id="totalCash">90</span> USD</strong></p>
                          <input type="submit" class="submit-btn" id="reqButt" value="Request" <?php if($get_fxcoin_count<100) echo 'style="opacity:0.5" disabled'?>>
                          </form>

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
$('#amntinput').each(function() {
    var elem=$(this);
    elem.data('oldVal', elem.val());
    elem.bind('propertychange change click keyup input paste', function(event) {
        if(elem.data('oldVal')!=elem.val()) {
            elem.data('oldVal', elem.val());
            $('#totalCash').html(parseInt(elem.val())-Math.ceil(elem.val()*0.1));

            if(parseInt(elem.val())<100 || parseInt(elem.val())><?php echo $get_fxcoin_count?> || elem.val()=='') {
                $('#reqButt').fadeTo('medium',0.5);
                $('#reqButt').attr("disabled", true);
            } else {
                $('#reqButt').fadeTo('medium',1);
                $('#reqButt').removeAttr('disabled');
            }
        }
    });
});
</script>

<script>
$('#amntinput').keydown(function (e) {
	if (e.shiftKey || e.ctrlKey || e.altKey) {
		e.preventDefault();
	} else {
	var key = e.keyCode;
		if (!((key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57)      || (key >= 96 && key <= 105))) {
			e.preventDefault();
		}
	}
});
</script>

<?php
if(isset($_GET['res']) && $_GET['res']=='success') {
    echo '<script>';
    echo 'alert("Request submitted successfully");';
    echo '</script>';
}
?>

<script>
                          $('#page-header').html('fxStar');
$('#page-header').attr('href','/wallet');
</script>

<!-- fxStar sidebar active -->
<script>
$('.fxstar-sidebar').attr('id','sidebar-active');
</script>


<script>
$('#cashout-form').submit(function(event) {
  event.preventDefault();

  jQuery.ajax({
    url:'/wallet/php/cashout.php',
    type:'POST',
    data:$(this).serialize(),
    success: function(response) {
      if(response=='success') {
        alert('Cash-out request submitted.');
	window.location.reload();
      } else {
        alert('Insufficient fxStars.');
      }
    }
  });
});
</script>
</body>
</html>