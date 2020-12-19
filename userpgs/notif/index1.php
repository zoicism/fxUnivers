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


if(isset($_GET['plan'])) {
	$plan = $_GET['plan'];
}


require('../php/notif.php');

$get_user_id = $id;
require('../../php/get_plans.php');

require('../../php/get_rel.php');

require('../../wallet/php/get_fxcoin_count.php');

// Deactivate notifs
$dns_query="UPDATE notif SET active=0 WHERE (user_id=$get_user_id AND active=1)";
$dns_result=mysqli_query($connection,$dns_query) or die(mysqli_error($connection));

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
    
<div class="col-33 left-col">
    <div class="col-1">
    
    <h3>Notifications</h3>
    </div>
</div>
    
<div class="col-33 mid-col">
<?php
                require('../php/notif.php');
                require('../../wallet/php/wallet_connect.php');

                if($notif_count>0) {
                    while($row = $notif_result->fetch_assoc()) {
                        echo '<div class="col-1" style="background:#eaeaea">';
                        if($row['reason']=='friendRequest') {
                            echo '<p>'.$row['body'].'</p>';
?>
                            <form class="addFriendAccept">
                              <input type="hidden" name="notifId" value="<?php echo $row['id'] ?>">
                              <input type="hidden" name="requesteeUN" value="<?php echo $username?>">
                              <input type="submit" value="accept"/>
                            </form>
                            <form class="addFriendDecline">
                              <input type="hidden" name="notifId" value="<?php echo $row['id'] ?>">
                              <input type="submit" value="decline"/>
                            </form>

<?php
                        } elseif($row['reason']=='fxCoinReq') {
                            $fxCoinReq_query = "SELECT * FROM fxcoin_req WHERE notif=".$row['id'];
                            $fxCoinReq_result = mysqli_query($wallet_connection, $fxCoinReq_query) or die(mysqli_error($wallet_connection));
                            $fxCoinReq_fetch = mysqli_fetch_array($fxCoinReq_result);
                            echo '<p>'.$row['body'].'</p>';
                            if(!isset($fxCoinReq_fetch['accepted'])) {
?>
                                <form class="reqFxCoinForm">
                                  <input type="hidden" name="reason" value="<?php echo $row['reason'] ?>">
                                  <input type="hidden" name="sender" value="<?php echo $fxCoinReq_fetch['sender'] ?>">
                                  <input type="hidden" name="reciever" value="<?php echo $fxCoinReq_fetch['reciever'] ?>">
                                  <input type="hidden" name="amnt" value="<?php echo $fxCoinReq_fetch['amnt'] ?>">
                                  <input type="hidden" name="notif" value="<?php echo $fxCoinReq_fetch['notif'] ?>">
                                  <input type="hidden" name="accepted" value="1">
                                  <input type="submit" value="send">
                                </form>
                                <form class="reqFxCoinFormDecline">
                                  <input type="hidden" name="reason" value="<?php echo $row['reason'] ?>">
                                  <input type="hidden" name="sender" value="<?php echo $fxCoinReq_fetch['sender'] ?>">
                                  <input type="hidden" name="reciever" value="<?php echo $fxCoinReq_fetch['reciever'] ?>">
                                  <input type="hidden" name="amnt" value="<?php echo $fxCoinReq_fetch['amnt'] ?>">
                                  <input type="hidden" name="notif" value="<?php echo $fxCoinReq_fetch['notif'] ?>">
                                  <input type="hidden" name="accepted" value="0">
                                  <input type="submit" value="decline">
                                </form>
<?php
                                }
                            } else {
                                echo '<p>'.$row['body'].'</p>';
                        }
                        echo '</div>';
                    }
                } else {
                    echo '<p>no notifications yet.</p>';
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
$(document).ready(function() {
  var notifUserId=<?php echo $get_user_id ?>;
  setInterval(function() {
    jQuery.ajax({
      type: 'POST',
      url: '/php/notif_icon.php',
      data: {notif_userId: notifUserId},
      success: function(response) {
            //var json=$.parseJSON(response);
            //alert(json.last_notif);
            //alert(response);
            if(response==='1') {
                //alert('its 1');
                $('#notif_a').addClass('blink');
            }

            jQuery.ajax({
              type: 'POST',
              url: '/php/msg_icon.php',
              data: {msg_userId: notifUserId},
              success: function(result) {
                    if(result>0) {
                        $('#msg_bar').addClass('blink');
                    }
              }
            });
      }
    });
  }, 2000);
});
</script>

</body>
</html>