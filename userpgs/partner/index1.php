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
	header("Location: /register/logout.php");
    exit();
}

require('../../php/get_user.php');
$id = $get_user_id;

require('../php/notif.php');

require('../../php/get_plans.php');
require('../../php/get_rel.php');

require('../../php/get_partner.php');

require('../../wallet/php/get_fxcoin_count.php');
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

    
<?php
                $total=0;
                while($row=$get_partner_result->fetch_assoc()) {
                    $total+=$row['income'];
                }
?>
<div class="col-33 left-col">
<div class="col-1">
    <div class="main fxpartner-color"></div>
    <div class="icon col-icon fxpartner-bg" onclick="location.href='/userpgs/fxpartner';"></div>
    <h3>Income</h3>
    <p><strong><?php echo $total ?></strong> fxStars</p>
</div>
</div>

                    <div class="col-33 mid-col">
<div class="col-1 pointer fxpartner-color" onclick="location.href='/userpgs/partner/income';">
                    <h3>Earning History</h3>
                    <p>Click to see what you have earned</p>
</div>
<div class="col-1 pointer fxpartner-color" onclick="location.href='/userpgs/partner/positions';">
    <h3>fxHR</h3>
    <p>Click to see the open positions to partner us with in half-half profits.</p>
</div>

</div>

<div class="footer"></div>
<script src="/js/footer.js"></script>

<div class="footbar"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>



</body>
</html>