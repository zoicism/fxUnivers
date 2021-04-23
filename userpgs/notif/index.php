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
<html>
<head>
	<title>fxUnivers</title>
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

  <div class="relative-main-content">
    <div class="notif-header">
      Notifications
    </div>
    <div class="notif-container">
        <div class="notifications">
          <ul>



	    <?php
                require('../php/notif.php');
                require('../../wallet/php/wallet_connect.php');

                if($notif_count>0) {
            while($row = $notif_result->fetch_assoc()) {


	    $notif_from_q = 'SELECT * FROM user WHERE id='.$row['from_id'];
	    $notif_from_r = mysqli_query($connection,$notif_from_q) or die(mysqli_error($connection));
	    $notif_from_fetch = mysqli_fetch_array($notif_from_r);
	    $notif_from_un=$notif_from_fetch['username'];
	    $notif_dt = $row['sent_dt'];
	    
            echo '<li class="notification" tabindex="1">';

	    if($notif_from_fetch['avatar']!=NULL) {
	      $avatar_url='/userpgs/avatars/'.$notif_from_fetch['avatar'];
	    } else {
	      $avatar_url='/images/background/avatar.png';
	    }
	    
	      echo '<div class="avatar-container"><div class="photo avatar" onclick="location.href=\'/user/'.$notif_from_un.'\';" style="background-image:url(\''.$avatar_url.'\');"></div></div>';
	      

	      

	      echo '<div class="desc-contact">';
		echo '<a class="name" href="/user/'.$notif_from_un.'">'.$notif_from_un.'</a> <span style="opacity:0.6;font-size:0.8rem;">'.date("M jS, Y @ H:i", strtotime($notif_dt)).'</span>';
		
                        if($row['reason']=='friendRequest') {
                            echo '<p class="notif-message">'.$row['body'].'</p>';
?>
                            <form class="addFriendAccept">
                              <input type="hidden" name="notifId" value="<?php echo $row['id'] ?>">
                              <input type="hidden" name="requesteeUN" value="<?php echo $username?>">
                              <input type="submit" value="Accept">
                            </form>
                            <form class="addFriendDecline">
                              <input type="hidden" name="notifId" value="<?php echo $row['id'] ?>">
                              <input type="submit" value="Decline"/>
                            </form>

<?php
                        } elseif($row['reason']=='fxCoinReq') {
                            $fxCoinReq_query = "SELECT * FROM fxcoin_req WHERE notif=".$row['id'];
                            $fxCoinReq_result = mysqli_query($wallet_connection, $fxCoinReq_query) or die(mysqli_error($wallet_connection));
                            $fxCoinReq_fetch = mysqli_fetch_array($fxCoinReq_result);
                            echo '<p class="notif-message">'.$row['body'].'</p>';
                            if(!isset($fxCoinReq_fetch['accepted'])) {
?>
                                <form class="reqFxCoinForm">
                                  <input type="hidden" name="reason" value="<?php echo $row['reason'] ?>">
                                  <input type="hidden" name="sender" value="<?php echo $fxCoinReq_fetch['sender'] ?>">
                                  <input type="hidden" name="receiver" value="<?php echo $fxCoinReq_fetch['reciever'] ?>">
                                  <input type="hidden" name="amnt" value="<?php echo $fxCoinReq_fetch['amnt'] ?>">
                                  <input type="hidden" name="notif" value="<?php echo $fxCoinReq_fetch['notif'] ?>">
                                  <input type="hidden" name="accepted" value="1">
                                  <input type="submit" value="Send">
                                </form>
                                <form class="reqFxCoinFormDecline">
                                  <input type="hidden" name="reason" value="<?php echo $row['reason'] ?>">
                                  <input type="hidden" name="sender" value="<?php echo $fxCoinReq_fetch['sender'] ?>">
                                  <input type="hidden" name="receiver" value="<?php echo $fxCoinReq_fetch['reciever'] ?>">
                                  <input type="hidden" name="amnt" value="<?php echo $fxCoinReq_fetch['amnt'] ?>">
                                  <input type="hidden" name="notif" value="<?php echo $fxCoinReq_fetch['notif'] ?>">
                                  <input type="hidden" name="accepted" value="0">
                                  <input type="submit" value="Decline">
                                </form>
<?php
                                }
                            } else {
                                echo '<p class="notif-message">'.$row['body'].'</p>';
                        }
                        echo '</div></li>';
                    }
                } else {
                    echo '<p>No notifications yet</p>';
                }
                
?>





	    
            
          </ul>
        </div>
  </div>


  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>




  <script>
    $('#page-header').html('Notifications');
    $('#page-header').attr('href','/userpgs/notif');
  </script>

  <div class="footbar"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>




<script>
$(function() {
  $('.reqFxCoinFormDecline').on('submit', function(e) {
  //alert('OK');
   e.preventDefault();
   if(confirm('Confirm decline!')) {
    jQuery.ajax({
      type: 'POST',
      url: '/wallet/php/req_fxcoin.php',
      data: $(this).serialize(),
      success: function() {
	//alert('success');
	$.ajax({
	  type: 'POST',
	  url: '/userpgs/php/notif.php',
	  data: $(this).serialize(),
	  success: function() {
            alert('The request is declined.');
            location.reload();
            //$('#notif_update').load(window.location.href+' #notif_update');
	  }
        });
      }
    });
   } else {
     return false;
   }
  });
});
</script>



<script>
$(function() {
    $('.reqFxCoinForm').on('submit', function(e) {
        //alert('OK');
        e.preventDefault();
        if(confirm('Please confirm the transfer request and send! Note that this transfer includes 10% interest rate.')) {
            jQuery.ajax({
              type: 'POST',
              url: '/wallet/php/req_fxcoin.php',
              data: $(this).serialize(),
              success: function(result) {
	            console.log(result);
                    if(result=='success') {
                        alert('The transaction is completed successfully.');
                        window.location.reload();
                        
                    } else if(result=='insuff') {
                        alert('Insufficient Funds!');
                    } else if(result=='declined') {
                        alert('The request is declined.');
                        window.location.reload();
                        
                    } else {
		        alert('Failed to complete the transaction. Please try again.');
	            }
              }
            
            });
        } else {
            return false;
        }
    });
});

</script>


<script>
$(function() {
    $('.addFriendDecline').on('submit', function(e) {
        e.preventDefault();
        jQuery.ajax({
          type: 'POST',
          url: '/php/declineFndReq.php',
          data: $(this).serialize(),
          success: function(result) {
                if(result==1) {
		  alert('Declined friend request.');
		  window.location.reload();
		} else {
		  alert('Failed to decline. Please try again.');
		}
          }
        });
    });
});
</script>

<script>
    $('.addFriendAccept').submit(function(event) {
        event.preventDefault();
	console.log('submitted');
        jQuery.ajax({
          type: 'POST',
          url: '/php/acceptFndReq.php',
          data: $(this).serialize(),
          success: function(result) {
	    console.log(result);
	    if(result==1) {
	      alert('Friend request accepted.');
	      window.location.reload();
	    } else {
	      alert('Failed to accept friend request. Please try again.');
	    }
          }
        });
    });
</script>


<script>
  $('#nav-notif .filled').show();
  $('#nav-notif .stroked').hide();
</script>
</body>
</html>
