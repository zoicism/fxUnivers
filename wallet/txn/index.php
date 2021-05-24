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

require('../../userpgs/php/notif.php');

require('../../php/get_plans.php');

require('../../php/get_rel.php');

require('../php/get_fxcoin_count.php');

require('../../php/get_trans.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>fxStar</title>
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
	<script>
	 if(screen.width >= 629) {
	   $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxstar-bar-items"><a href="/w\
allet/buy" class="link-main"  ><div class="head">Buy fxStars</div></a></div><div class="bar-items f\
xstar-bar-items"><a href="/wallet/send" class="link-main"><div class="head">Transfer</div></a></div><div class="bar\
-items fxstar-bar-items"><a href="/wallet/req" class="link-main"><div class="head">Request</div></a></div><div clas\
s="bar-items fxstar-bar-items"><a href="/wallet/txn" class="link-main" id="active-main"><div class="head">Transactions</div></a></di\
v><div class="bar-items fxstar-bar-items"><a href="/wallet/cashout" class="link-main"><div class="head">Cash-out</d\
iv></a></div></div>');
	 }
	</script>
    <div class="blur mobile-main">



<div class="sidebar"></div>
	<?php require('../../php/sidebar.php'); ?>

  <div class="relative-main-content">
  <div class="inner-content-box" id="txn-content-box">
                          <h2>Transactions</h2>
                          
<div class="row-header" style="width:100%">                 
    <div class="col"><h3>Incoming</h3></div>
    <div class="col"><h3>Outgoing</h3></div>
</div>




                       
              <div class="row">
                          
                                                   
                  <div class="col">
		      <?php
		      if($get_trans_out_count>0) {
			  $trans_i=1;
			  while($trans_out_row=$get_trans_out->fetch_assoc()) {
			      $trans_from_un_q='SELECT * FROM user WHERE id='.$trans_out_row['from_id'];
			      $trans_from_un_r=mysqli_query($connection,$trans_from_un_q) or die(mysqli_error($connection));
			      $trans_from_un_fetch=mysqli_fetch_array($trans_from_un_r);
			      $trans_from_un=$trans_from_un_fetch['username'];
			      /*
				 $trans_to_un_q='SELECT * FROM user WHERE id='.$trans_out_row['to_id'];
				 $trans_to_un_r=mysqli_query($connection,$trans_to_un_q) or die(mysqli_error($connection));
				 $trans_to_un_fetch=mysqli_fetch_array($trans_to_un_r);
				 $trans_to_un=$trans_to_un_fetch['username'];
			       */
			      echo '<div class="transaction"><p>From: <strong><a href="/user/'.$trans_from_un.'">@'.$trans_from_un.'</a></strong></p> <p>Amount: <strong>'.$trans_out_row['amnt'].' fxStars</strong></p><p>Date & Time: <strong>'.date("M jS, Y H:i", strtotime($trans_out_row['dt'])).' (UTC)</strong></p></div>';
			      $trans_i++;
			  }
		      } else {
			  echo '<div><p style="color:gray">No incoming transaction yet</p></div>';
		      }
		      ?>



                  </div>

		  <div class="col">

		      <?php
		      if($get_trans_in_count>0) {
			  $trans_i=1;
			  while($trans_in_row=$get_trans_in->fetch_assoc()) {

			      if($trans_in_row['to_id']!=1) {
				  
				  $trans_to_un_q='SELECT * FROM user WHERE id='.$trans_in_row['to_id'];
				  $trans_to_un_r=mysqli_query($connection,$trans_to_un_q) or die(mysqli_error($connection));
				  $trans_to_un_fetch=mysqli_fetch_array($trans_to_un_r);
				  $trans_to_un=$trans_to_un_fetch['username'];

				  echo '<div class="transaction"><p>To: <strong><a href="/user/'.$trans_to_un.'">@'.$trans_to_un.'</a></strong></p> <p>Amount: <strong>'.$trans_in_row['amnt'].' fxStars (+'.ceil($trans_in_row['amnt']*0.1).' interest)</strong></p> <p>Date & Time: <strong>'.date("M jS, Y H:i", strtotime($trans_in_row['dt'])).' (UTC)</strong></p></div>';
				  $trans_i++;
				  
			      }
			  }
		      } else {
			  echo '<div><p style="color:gray">No outgoing transaction yet</p></div>';
		      }
		      ?>

                  </div>


			  
              </div>



  </div>
  </div>
</div>

<div class="footbar blur"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>


                          <!-- SCRIPTS -->
<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>


<script>
                          $('#page-header').html('fxStar');
$('#page-header').attr('href','/wallet');
</script>


<!-- fxStar sidebar active -->
<script>
$('.fxstar-sidebar').attr('id','sidebar-active');
</script>
</body>
</html>                         
