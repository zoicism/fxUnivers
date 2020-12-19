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
	header("Location: /register/logout.php");
}

$user_query = "SELECT * FROM user WHERE username='$username'";
$user_result = mysqli_query($connection, $user_query) or die(mysqli_error($connection));
$user_fetch = mysqli_fetch_array($user_result);
$fname = $user_fetch['fname'];
$lname = $user_fetch['lname'];
$id = $user_fetch['id'];
//$bio = $user_fetch['bio'];

// add new post to the timeline
if(isset($_POST['new_post'])) {
	$raw_newpost = nl2br($_POST['new_post']);
	$newpost = mysqli_real_escape_string($connection, $raw_newpost);
	$newpost_query = "INSERT INTO sonet(uid, body) VALUES($id, '$newpost')";
	$newpost_result = mysqli_query($connection, $newpost_query) or die(mysqli_error($connection));
}

// fetch the sonet records
//require('sonet/following.php');
// Get the notification!
require('php/notif.php');
// Get the plans!
$get_user_id=$id;
require('../php/get_plans.php');
require('../php/get_rel.php');
require('../wallet/php/get_fxcoin_count.php');
//require('../php/get_likes_dislikes.php');
require('../php/get_partner.php');

require('instructor/php/courses.php');
require('../php/get_stu_stucourse.php');
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
    <link rel="stylesheet" href="/css/avatar.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
    </head>

    
<body>    
<div class="upperbar"></div>
<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>



<!-- LEFT COL -->        
<div class="col-33 left-col">

<div class="col-1 pointer" onclick="location.href='/user/<?php echo $username?>';">
<?php
                $path="avatars/";
                if(file_exists($path.$get_user_id.'.jpg')) {
                    echo('<div class="avatar" style="margin:auto;background-image: url(\'avatars/'.$get_user_id.'.jpg\'); color: black; font-weight: bold;"></div>');
                } elseif(file_exists($path.$get_user_id.'.jpeg')) {
                    echo('<div class="avatar" style="margin:auto;background-image: url(\'avatars/'.$get_user_id.'.jpeg\'); color: black; font-weight: bold;"></div>');
                } elseif(file_exists($path.$get_user_id.'.png')) {
                    echo('<div class="avatar" style="margin:auto;background-image: url(\'avatars/'.$get_user_id.'.png\'); color: black; font-weight: bold;"></div>');
                } elseif(file_exists($path.$get_user_id.'.gif')) {
                    echo('<div class="avatar" style="margin:auto;background-image: url(\'avatars/'.$get_user_id.'.gif\'); color: black; font-weight: bold;"></div>');
                } else {
                    echo('<div class="avatar" style="margin:auto;"></div>');
                }
?>
                <h3><?php echo 'fx'.strtoupper($username[0]).substr($username,1)?></h3>
                <p><?php echo '<b>'.$get_rel_friends_count.'</b> friends' ?><p>
</div>



</div>








<!-- MID COL -->
<div class="col-33 mid-col">
                
<div class="col-1 pointer" onclick="location.href='/wallet';">
    <div class="main fxstar-color"></div>
    <div class="icon col-icon fxstar-bg"></div>
    <h3>fxStar</h3>
    <p><strong><?php echo $get_fxcoin_count?></strong> fxStars</p>
</div>

<div class="col-1 pointer" onclick="location.href='/userpgs/fxuniversity';">
  <div class="main fxuniversity-color"></div>
                      <div class="icon col-icon fxuniversity-bg"></div>
  <h3>fxUniversity</h3>
<p><strong><?php echo $course_count+$gss_count?></strong> courses</p>
</div>




<?php
                $pTotal=0;
                while($row=$get_partner_result->fetch_assoc()) {
                    $pTotal+=$row['income'];
                }
?>
<div class="col-1 pointer" onclick="location.href='/userpgs/partner';">
  <div class="main fxpartner-color"></div>
                    <div class="icon col-icon fxpartner-bg"></div>
  <h3>fxPartner</h3>
  <p><strong><?php echo $pTotal ?></strong> fxStars</p>
</div>

                    <div class="col-1 pointer" onclick="coming()">
                    <div class="main fxuniverse-color"></div>
                    <div class="icon col-icon fxuniverse-bg"></div>
  <h3>fxUniverse</h3>
   <p>(coming soon for public)</p>                   
</div> 

<div class="col-1 pointer" style="margin-bottom:50px" onclick="coming()">
                    <div class="main fxsonet-color"></div>
                    <div class="icon col-icon fxsonet-bg"></div>
  <h3>fxSonet</h3>
  <p>(coming soon for public)</p>
</div>

                
</div>


                
                



<!-- RIGHT COL -->
<div class="col-33 right-col">
<div class="col-1 pointer" onclick="location.href='/register/logout.php';">
                    <h3>Logout</h3>
</div>


</div>








<div class="footer"></div>
<script src="/js/footer.js"></script>

<div class="footbar"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>



<script>
function coming() {
    alert('Wait for it...!');
}
</script>
</body>
</html>
    
    