<?php
session_start();
require('../register/connect.php');

if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
	$smsg = "Successfully logged in!";
} else {
	echo "could not get the username!";
}

require('../php/get_user.php');

$id = $get_user_id;


if(isset($_GET['guest'])) {
	$guest = $_GET['guest'];
	require('../php/get_guest_by_username.php');
	$guest_id = $get_guest_by_username['id'];
}


require('../userpgs/php/notif.php');

$get_user_id = $id;
require('../php/get_plans.php');

require('../php/get_rel.php');

require('../wallet/php/get_fxcoin_count.php');

require('../php/get_msg.php');

require('../php/get_messenger.php');

?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 

    <title>fxUnivers</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/avatar.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <link rel="stylesheet" href="/css/colors.css">
    <link rel="stylesheet" href="/css/msg.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
    </head>

<body>

<div class="upperbar"></div>
<script src="/js/upperbar.js"></script>

    <div class="col-33 left-col">
    <div class="col-1">
    <h3>Messaging</h3>
    <p><?php echo '@'.$guest?></p>
    <?php echo '<p>'.$get_guest_by_username['fname'].' '.$get_guest_by_username['lname'].'</p>';?>
    </div>
    </div>

<div class="col-33 mid-col">
    
  
  <div id="skroll">
  <div id="newMsgs" style="width:100%">              
  <?php
                while($row = $get_messenger_result->fetch_assoc()) {
                    if($row['user2id']==$get_user_id) {
                        echo '<div class="col-1" style="text-align:left;width:70%;float:left;background:#eaeaea;">';
                        echo '<p>'.$row['text'].'</p>';
                        echo '<p style="font-size:0.8rem;color:#6a6a6a;text-align:right;">@'.$guest.'</p>';
                        echo '</div>';
                    } else {
                        echo '<div class="col-1" style="text-align:left;width:70%;float:right;position:relative;background:#eaeaea;">';
                        echo '<p>'.$row['text'].'</p>';
                        echo '<p style="font-size:0.8rem;color:#6a6a6a;text-align:right;">@'.$username.'</p>';
                        echo '</div>';
                    }
                }
  ?>
  </div>
  </div>
  <div class="col-1 txtCon">
                <form id="sendMsg" autocomplete="off">
                  <input type="hidden" name="clientId" value="<?php echo $get_user_id?>">
                  <input type="hidden" name="guestId" value="<?php echo $guest_id?>">
                  <input type="text" name="msgBody" id="inputMsgTxt" placeholder="Type" style="float:left;width:70%;margin-top:10px;max-height:30px;" autofocus required>
                  <input type="submit" value="Send" style="float:right;width:20%;">
                </form>
  </div>
</div>


    
<script>
                
                $(document).ready(function() {
                    setInterval(function() {
                        jQuery.ajax({
                          type:"POST",
                          url:'/php/get_messenger.php',
                          data:$(this).serialize(),
                          success: function(response) {
                              $('#newMsgs').load(window.location.href+' #newMsgs');
                          }
                        });

                        var element = document.getElementById("skroll");
                        element.scrollTop = element.scrollHeight;
                    },500);
                });
                              
</script>

<script>
                $(document).ready(function() {
                    $('#sendMsg').submit(function(e) {
                        
                        e.preventDefault();
                        jQuery.ajax({
                          type:"POST",
                          url:'/php/set_msg.php',
                          data:$(this).serialize(),
                          success:function(response) {
                                $('#inputMsgTxt').val('');
                                $('#inputMsgTxt').focus();
                          }
                        });
                    });
                });
</script>


</body>
</html>