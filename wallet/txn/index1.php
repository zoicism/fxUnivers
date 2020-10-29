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

require('../../php/get_trans.php');
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

<div class="col-33 left-col">
<div class="col-1">
    <div class="main fxstar-color"></div>
    <div class="icon col-icon fxstar-bg" onclick="location.href='/wallet';"></div>
    
    <h3>Transactions</h3>
    <p>Balance: <?php echo $get_fxcoin_count?> fxStars</p>

</div>
</div>

<div class="col-33 mid-col">
<?php
          if($get_trans_count>0) {
              $trans_i=1;
              while($trans_row=$get_trans->fetch_assoc()) {
                  $trans_from_un_q='SELECT * FROM user WHERE id='.$trans_row['from_id'];
                  $trans_from_un_r=mysqli_query($connection,$trans_from_un_q) or die(mysqli_error($connection));
                  $trans_from_un_fetch=mysqli_fetch_array($trans_from_un_r);
                  $trans_from_un=$trans_from_un_fetch['username'];

                  $trans_to_un_q='SELECT * FROM user WHERE id='.$trans_row['to_id'];
                  $trans_to_un_r=mysqli_query($connection,$trans_to_un_q) or die(mysqli_error($connection));
                  $trans_to_un_fetch=mysqli_fetch_array($trans_to_un_r);
                  $trans_to_un=$trans_to_un_fetch['username'];

                  if($username==$trans_from_un) {
                      $tr_border='background: #ffcc4f';
                  } else {
                      $tr_border='background: #1EFFBC';
                  }
                  echo '<div class="col-1" style="'.$tr_border.'"><p>From <strong><a href="/user/'.$trans_from_un.'">'.$trans_from_un.'</a></strong> to <strong><a href="/user/'.$trans_to_un.'">'.$trans_to_un.'</a></strong></p><p><strong>'.$trans_row['amnt'].'</strong> fxStars</p><p>on '.$trans_row['dt'].' (ET)</p></div>';
                  $trans_i++;
              }
          } else {
              echo '<div class="col-1"><p>no transactions yet</p></div>';
          }
?>
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