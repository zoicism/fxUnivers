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


if(isset($_GET['plan'])) {
	$plan = $_GET['plan'];
}


require('../userpgs/php/notif.php');

$get_user_id = $id;
require('../php/get_plans.php');

require('../php/get_rel.php');

require('../wallet/php/get_fxcoin_count.php');

require('../php/get_msg.php');

// set readd=1 in messenger DB
require('../contact/message_connect.php');
$readd_query="UPDATE messenger SET readd=1 WHERE (user2id=$get_user_id AND readd=0)";
$readd_result=mysqli_query($msg_connection,$readd_query) or die(mysqli_error($msg_connection));


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
    <h3>Messaging</h3>
    <p style="text-align:left">Click on a conversation to continue messaging or on an fxFriend to start a new one.</p>
    
    </div>
    </div>

<div class="col-33 mid-col">
                <div class="col-1">
                <h3>Conversations</h3>
                <p>Click on a conversation to continue messaging</p>
                </div>
  <?php
                if($get_msg_count>0) {
                    while($row = $get_msg_result->fetch_assoc()) {
                        if($row['user1id']==$get_user_id) {
                            $guest_id = $row['user2id'];
                        } else {
                            $guest_id = $row['user1id'];
                        }
                        require('../php/get_guest.php');
?>
                        <div class="col-1 pointer" onclick="location.href='/msg/<?php echo $get_guest["username"]?>';">
                    
  <?php
                        echo '<h3>@'.$get_guest['username'].'</h3>';
                        echo '<p>'.$row['text'].'</p>';
                        echo '</div>';

                    }
                } else {
                    echo '<p style="color:gray">No conversations started yet</p>';
                }
  ?>
</div>

<div class="col-33 right-col">
                <div class="col-1">
                  <h3>fxFriends</h3>
                  <p>Click on an fxFriend to start a new conversation</p>
                </div>
                <?php
                if($get_rel_friends_count > 0) {
                    while($row = $get_rel_friends_result->fetch_assoc()) {
                        if($row['user1']==$get_user_id) {
                            $fnd_user_id=$row['user2'];
                        } else {
                            $fnd_user_id=$row['user1'];
                        }
                        $fnd_user_query = "SELECT * FROM user WHERE id=$fnd_user_id";
                        $fnd_user_result = mysqli_query($connection, $fnd_user_query) or die(mysqli_error($connection));
                        $fnd_user_fetch = mysqli_fetch_array($fnd_user_result);
  ?>
                        <div class="col-1 pointer" onclick="location.href='/msg/<?php echo $fnd_user_fetch['username']?>';">
  <?php
                        echo '<h3>@'.$fnd_user_fetch['username'].'</h3>';
                        echo '<p>'.$fnd_user_fetch['fname'].' '.$fnd_user_fetch['lname'].'</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p style="color:gray">You have no fxFriends yet</p>';
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