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
<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>

<!-- LEFT COL -->
<div class="col-33 left-col">
<div class="col-1">
    <div class="main fxstar-color"></div>
    <div class="icon col-icon fxstar-bg" onclick="location.href='/wallet';"></div>
    
    <h3>Cash-out</h3>
    <p>Balance: <?php echo $get_fxcoin_count?> fxStars</p>
    <p>You need a minimum of 100 fxStars to request cash-out.</p>
</div>
</div>



<div class="col-33 mid-col">
    <div class="col-1">
    <p><b>fxStars to cash-out</b></p>
    
    <form id="cform" method="POST" action="/wallet/php/cashout.php">
      <input type="hidden" name="user_id" value="<?php echo $get_user_id?>">
      <input type="number" name="amnt" id="amntinput" placeholder="How many fxStars" min="100" max="<?php echo $get_fxcoin_count?>" value="100" required>
      <input type="hidden" name="coin_count" value="<?php echo $get_fxcoin_count?>">
      <p>Total cash-out amount (USD): <span id="totalCash">90</span></p>
    <input type="submit" id="reqButt" value="Request" <?php if($get_fxcoin_count<100) echo 'style="opacity:0.5" disabled'?>>
    </form>
    
    </div>
</div>

<div class="col-33 right-col">
    <div class="col-1">
    <b>Cash-out history</b>
    </div>

<?php
$chistory_q="SELECT * FROM cashout WHERE userId=$get_user_id ORDER BY id DESC";
$chistory_r=mysqli_query($wallet_connection,$chistory_q);
$chistory_count=mysqli_num_rows($chistory_r);
if($chistory_count>0) {
    while($row=$chistory_r->fetch_assoc()) {
        $amnt=$row['amnt'];
        $amntUSD=$amnt-ceil(0.1*$amnt);
        if($row['paid']==1) {
            $paid='Cashed out';
            $bgc='#b9ffb9';
        } else {
            $paid='Requested';
            $bgc='#eaeaea';
        }
        echo '<div class="col-1" style="background:'.$bgc.'">';
        echo '<p><b>'.$amnt.' fxStars</b></p>';
        echo '<p>'.$amntUSD.' USD</p>';
        echo '<p>'.$paid.'</p>';
        echo '<p>'.$row['dt'].' (ET)</p>';
        echo '</div>';
    }
} else {
    echo '<p style="color:gray;text-align:center;">No fxStars cashed out yet</p>';
}
?>

</div>

<div class="footer"></div>
<script src="/js/footer.js"></script>            


<div class="footbar"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

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

</body>
</html>