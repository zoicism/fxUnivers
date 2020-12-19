<?php
session_start();
require('../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    require('../../php/get_user.php');
    $get_real_user_id=$get_user_id;
} else {
	header('Location: /');
}


if(isset($_GET['tar'])) $username=$_GET['tar'];

require('../../php/get_user.php');

//require('../php/notif.php');

require('../../php/get_plans.php');

require('../../php/get_rel.php');

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
    <link rel="stylesheet" href="/css/avatar.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <link rel="stylesheet" href="/css/colors.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
    </head>

<body>
<?php $username=$_SESSION['username'];require('../../php/get_user.php'); ?>
<div class="upperbar"></div>
<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
<?php $username=$_GET['tar'];require('../../php/get_user.php'); ?>
<div class="col-33 left-col">
<div class="col-1">
                <h3><?php echo '@'.$username?></h3>
                <p><b><?php echo $get_user_fname.' '.$get_user_lname?></b></p>
                <p><b><?php echo $get_rel_friends_count ?></b> friends</p>
</div>
</div>

<div class="col-33 mid-col">
<?php
                if($get_rel_friends_count>0) {
                    while($row = $get_rel_friends_result->fetch_assoc()) {
                        if($row['user1']==$get_user_id) {
                            $fnd_user_id=$row['user2'];
                        } else {
                            $fnd_user_id=$row['user1'];
                        }
                        $fnd_user_query = "SELECT * FROM user WHERE id=$fnd_user_id";
                        $fnd_user_result = mysqli_query($connection, $fnd_user_query) or die(mysqli_error($connection));
                        $fnd_user_fetch = mysqli_fetch_array($fnd_user_result);

                        
                        echo '<div class="col-1 pointer" onclick="location.href=\'/user/'.$fnd_user_fetch['username'].'\';">';


                        
                        $path="../avatars/";
                        if(file_exists($path.$fnd_user_fetch['id'].'.jpg')) {
                            echo('<div class="avatar float-left" style="background-image: url(\'../avatars/'.$fnd_user_fetch['id'].'.jpg\');"></div>');
                        } elseif(file_exists($path.$fnd_user_fetch['id'].'.jpeg')) {
                            echo('<div class="avatar float-left" style="background-image: url(\'../avatars/'.$fnd_user_fetch['id'].'.jpeg\');"></div>');
                        } elseif(file_exists($path.$fnd_user_fetch['id'].'.png')) {
                            echo('<div class="avatar float-left" style="background-image: url(\'../avatars/'.$fnd_user_fetch['id'].'.png\');"></div>');
                        } elseif(file_exists($path.$fnd_user_fetch['id'].'.gif')) {
                            echo('<div class="avatar float-left" style="background-image: url(\'../avatars/'.$fnd_user_fetch['id'].'.gif\');"></div>');
                        } else {
                            echo('<div class="avatar float-left"></div>');
                        }

                        
                        echo '<h3>@'.$fnd_user_fetch['username'].'</h3>';
                        echo '<p><b>'.$fnd_user_fetch["fname"].' '.$fnd_user_fetch["lname"].'</b></p>';
                        echo '</div>';

                    }
                    $get_rel_friends_result->free();
                } else {
                    echo '<p>No friends yet</p>';
                }
?>
</div>

<?php $username=$_SESSION['username'];require('../../php/get_user.php'); ?>
<div class="footer"></div>
<script src="/js/footer.js"></script>

<div class="footbar"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>

<?php $username=$_SESSION['tar'];require('../../php/get_user.php'); ?>


</body>
</html>