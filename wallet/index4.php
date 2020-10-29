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
</head>
    
<body>

<div class="upperbar"></div>
<script src="/js/upperbar.js"></script>

<!-- LEFT COL -->
<div class="col-33 left-col">
<div class="col-1">
    <div class="main fxstar-color"></div>
    <div class="icon col-icon fxstar-bg"></div>
    
    <h3>fxStar</h3>
    <p><b>Balance</b></p>
    <p><strong><?php echo $get_fxcoin_count?></strong> fxStars</p>
</div>
</div>




<!-- MID COL -->
<div class="col-33 mid-col">
<div class="col-1 pointer" onclick="location.href='/wallet/buy';">
    <h3>Buy fxStars</h3>
    <p>10 fxStars = 11 USD</p>
</div>

<div class="col-1 pointer" onclick="location.href='/wallet/txn';">
    <h3>Transactions</h3>
    <p>fxStar transactions history</p>
</div>

<div class="col-1 pointer" onclick="location.href='/wallet/req';">
    <h3>Request fxStars</h3>
    <p>Request from friends</p>
</div>

<div class="col-1 pointer" onclick="location.href='/wallet/send';">
    <h3>Send fxStars</h3>
    <p>Send to friends</p>
</div>

    <div class="col-1 pointer" onclick="location.href='/wallet/cashout';">
    <h3>Request cash-out</h3>
    <p>You must have a minimum of 100 fxStars to request cash-out.</p>
    </div>
    
</div>


<div class="footer"></div>
<script src="/js/footer.js"></script>

<div class="footbar"></div>
<script src="/js/footbar.js"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>
<script src="/js/notif_msg.js"></script>
</body>
</html>