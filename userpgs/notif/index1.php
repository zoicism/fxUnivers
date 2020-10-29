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
<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Notifications</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/skinblue.css"/><!-- change skin color here -->
<link rel="stylesheet" type="text/css" href="/css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="/css/list/rotated_nav.css"/>
<link rel="stylesheet" type="text/css" href="/css/toptobottom.css"/>
<link rel="stylesheet" type="text/css" href="/css/modal.css"/>
<link rel="stylesheet" type="text/css" href="/css/roundcorner.css"/>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

<script src="/js/jquery-3.4.1.min.js"></script>
<script src="/js/function.js"></script>
<!-- the rest of the scripts at the bottom of the document -->
</head>
<body>
<!-- UPPER BAR -->
<section class="nav-bar">
  <div class="nav-container">
    <div class="brand">
      <div class="logoimg toplogo"></div>
    </div>
    <nav>
      <div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
      <ul class="nav-list">
        <li>
          <a href="/" id="ubHome"><img id="ubiHome" src="/images/upperbar/home_a.png" alt="Home"></a>
        </li>
        <li>
          <a href="/search" id="ubSearch"><img id="ubiSearch" src="/images/upperbar/search_a.png" alt="Search"></a>
        </li>
	<li>
          <a href="/userpgs/notif" id="notif_a"><img id="ubiNotif" src="/images/upperbar/notification_a.png" style="height: 19px; width: 15.77px;" alt="Notifs"></a>
        </li>
        <li>
          <a href="/msg/inbox.php" id="msg_bar"><img id="ubiMsg" src="/images/upperbar/message_a.png" style="height: 15.77px; width: 19px;" alt="Messages"></a>
	    <!--
	    <ul class="nav-dropdown">
            <li>
              <a href="#">test1</a>
            </li>
            <li>
              <a href="#">test2</a>
            </li>
            <li>
              <a href="#">test3</a>
            </li>
          </ul>
	  -->
        </li>
        <li>
          <a href="/register/logout.php" id="ubLogout"><img id="ubiLogout" src="/images/upperbar/logout_a.png" style="height: 15.77px; width: 19px;" alt="Logout" ></a>
        </li>
      </ul>
    </nav>
  </div>
</section>


<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
        <div class="row space-bot">
               
                
        </div>
</div>

<!-- LEFT PANEL
================================================== -->
<div class="grid">
                <div class="shadowundertop">
                </div>
                <div class="row">

                        <!-- LEFT SIDE -->
                        <div class="c9">
    <?php
    $path="../avatars/";
    if(file_exists($path.$get_user_id.'.jpg')) {
        echo('<div class="userpic lsb-sub" style="background-image: url(\'/userpgs/avatars/'.$get_user_id.'.jpg\');"></div>');
    } elseif(file_exists($path.$get_user_id.'.jpeg')) {
        echo('<div class="userpic lsb-sub" style="background-image: url(\'/userpgs/avatars/'.$get_user_id.'.jpeg\');"></div>');
    } elseif(file_exists($path.$get_user_id.'.png')) {
        echo('<div class="userpic lsb-sub" style="background-image: url(\'/userpgs/avatars/'.$get_user_id.'.png\');"></div>');
    } elseif(file_exists($path.$get_user_id.'.gif')) {
        echo('<div class="userpic lsb-sub" style="background-image: url(\'/userpgs/avatars/'.$get_user_id.'.gif\');"></div>');
    } else {
        echo('<div class="userpic avatarr lsb-sub" id="showUpButt"></div>');
    }
?>
			<h2 style="text-align: center; font-size: 1rem; margin-top: 1px; margin-bottom: 0;" class="lsb-sub"><?php echo '<a href="/user/'.$username.'" style="color: black">'.$get_user_fname.' '.$get_user_lname.' <span style="font-size: 0.9rem">@'.$username.'</span></a>'; ?></h2>
				<!--<?php echo "$bio" ?>-->

          <p id="rcorners1" style="font-size: 1rem; font-weight: bold; margin-bottom: 0;" class="lsb-sub"><span style="float: left"><img src="/images/leftsidebar/fxcoin.png" style="height: 15px; width: 11.25px"></span><span style="float:right; font-family: courier;"><?php echo $get_fxcoin_count ?></span></p>


			    <table style="margin-top: 10px; line-height: 0;" class="lsb-screensize">
                  <tr>
				    <td style="width: 33.3%; text-align: left;"><a href="/userpgs/rel?act=friends" style="color: black"><strong><?php echo $get_rel_friends_count ?></strong></a></td>
				    <td style="width: 33.3%; text-align: center;"><a href="/userpgs/rel?act=following" style="color: black"><strong><?php echo $get_rel_following_count ?></strong></a></td>
				    <td style="width: 33.3%; text-align: right;"><a href="/userpgs/rel?act=followers" style="color: black"><strong><?php echo $get_rel_followers_count ?></strong></a></td>
				  </tr>
				  <tr>
				    <td style="width: 33.3%; text-align: left;"><a href="/userpgs/rel?act=friends" style="color: black">Friends</a></td>
				    <td style="width: 33.3%; text-align: center;"><a href="/userpgs/rel?act=following" style="color: black">Following</a></td>
				    <td style="width: 33.3%; text-align: right;"><a href="/userpgs/rel?act=followers" style="color: black">Followers</a></td>
				  </tr>
				</table>
          
          
          <a href="/"><button class="taste taste-lsb-ss" id="homeBtn"><span class="lsblogoimg lsblogo" id="homeSpan"></span><span class="lsb-screensize">HOME</span></button></a>
          <a href="/wallet"><button class="taste taste-lsb-ss" id="walletBtn"><span class="smallicon smallicon_wallet_a" id="walletSpan"></span><span class="lsb-screensize">WALLET</span></button></a>
          <a href="/userpgs/trader"><button class="taste taste-lsb-ss" id="traderBtn"><span class="smallicon smallicon_trader_a" id="traderSpan"></span><span class="lsb-screensize">TRADER</span></button></a>
          <a href="<?php 
					if($plans_msg) {
					  if($get_plans_fxuniversityins) {
					      echo '/userpgs/instructor'; 
					    } elseif($get_plans_fxuniversityins_req) {
					      echo '/register/instructor_wait.php';
					    } else {
					      echo '/register/instructor_reg.php';
					    }
					  } else {
					    echo '/register/instructor_reg.php';
					  } ?>"><button class="taste taste-lsb-ss" id="instructorBtn"><span class="smallicon smallicon_instructor_a" id="instructorSpan"></span><span class="lsb-screensize">INSTRUCTOR</span></button></a>
          <a href="<?php
					if($plans_msg) {
					  if($get_plans_fxuniversitystu) {
					    echo '/userpgs/student';
					  } elseif($get_plans_fxuniversitystu_req) {
					    echo '/register/student_wait.php';
					  } else {
					    echo '/register/student_reg.php';
					  }
					} else {
					  echo '/register/student_reg.php';
					} ?>"><button class="taste taste-lsb-ss" id="studentBtn"><span class="smallicon smallicon_student_a" id="studentSpan"></span><span class="lsb-screensize">STUDENT</span></button></a>
          <a href="/userpgs/partner"><button class="taste taste-lsb-ss" id="partnerBtn"><span class="smallicon smallicon_partner_a" id="partnerSpan"></span><span class="lsb-screensize">PARTNER</span></button></a>
          
          <hr class="hrtitle" style="border-color: #25252533">
          
			</div>
			
			<!-- MAIN CONTENT -->
			<div class="c3">
                                <div class="rightsidebar">
                                        <div id="result"><h2 class="title stresstitle">Notifications</h2></div>
                                        <hr class="hrtitle">
					<div class="teamdescription">
					  <?php require('../php/notif.php');
					    require('../../wallet/php/wallet_connect.php');
					  ?>
					  <div id="notif_update" class="notif_update">
					  <table>
					  <?php if($notif_count>0) { ?>
					    <?php if($first_notif_reason=="fxCoinReq") {
					    $fxCoinReq_query = "SELECT * FROM fxcoin_req WHERE notif=$first_notif_id";
					    $fxCoinReq_result = mysqli_query($wallet_connection, $fxCoinReq_query) or die(mysqli_error($wallet_connection));
					    $fxCoinReq_fetch = mysqli_fetch_array($fxCoinReq_result);
					    ?>
					      <tr style="border-bottom: solid 1px #25252533">
					      	<td style="width: 70%"><?php echo $first_notif_body ?></td>
						<?php if(!isset($fxCoinReq_fetch['accepted'])) { ?>
					      	 <td style="width: 15%">
						  <form class="reqFxCoinForm">
						    <input type="hidden" name="reason" value="<?php echo $first_notif_reason ?>">
						    <input type="hidden" name="sender" value="<?php echo $fxCoinReq_fetch['sender'] ?>">
						    <input type="hidden" name="reciever" value="<?php echo $fxCoinReq_fetch['reciever'] ?>">
						    <input type="hidden" name="amnt" value="<?php echo $fxCoinReq_fetch['amnt'] ?>">
						    <input type="hidden" name="notif" value="<?php echo $fxCoinReq_fetch['notif'] ?>">
						    <input type="hidden" name="accepted" value="1">
						    <button type="submit" class="btn">Send</button>
						  </form>
						 </td>
						<td style="width: 15%">
						  <form class="reqFxCoinFormDecline">
						     <input type="hidden" name="reason" value="<?php echo $first_notif_reason ?>">
						     <input type="hidden" name="sender" value="<?php echo $fxCoinReq_fetch['sender'] ?>">
						     <input type="hidden" name="reciever" value="<?php echo $fxCoinReq_fetch['reciever'] ?>">
						     <input type="hidden" name="amnt" value="<?php echo $fxCoinReq_fetch['amnt'] ?>">
						     <input type="hidden" name="notif" value="<?php echo $fxCoinReq_fetch['notif'] ?>">
						     <input type="hidden" name="accepted" value="0">
						     <button class="btn">Decline</button>
						  </form>
						</td>
<?php } ?>
					      </tr>
					    <?php } elseif($first_notif_reason=="friendRequest") { ?>
					      <tr style="border-bottom: solid 1px #25252533">
					      	<td style="width: 70%"><?php echo $first_notif_body ?></td>
					        <td style="width: 15%">
                                                 <form class="addFriendAccept">
                                                 <input type="hidden" name="notifId" value="<?php echo $first_notif_id ?>">
                               <input type="hidden" name="requesteeUN" value="<?php echo $username?>">
                                                 <button type="submit" class="btn">Accept</button>
         
                                                 </form>
                            </td>
                            <td style="width: 15%">
                                                 <form class="addFriendDecline">
                                                 <input type="hidden" name="notifId" value="<?php echo $first_notif_id ?>">
                                                 <button type="submit" class="btn">Decline</button>
                                                 </form>
                            </td>
                                                 
					      </tr>
					    <?php } else { ?>
					      <tr style="border-bottom: solid 1px #25252533">
					      	<td style="width: 60%"><?php echo $first_notif_body ?></td>
					      </tr>
					    <?php } ?>
					    <?php while($row = $notif_result->fetch_assoc()) { ?>
					      <?php if($row['reason']=='friendRequest') { ?>
                                <tr style="border-bottom: solid 1px #25252533">
					      	<td style="width: 70%"><?php echo $row['body'] ?></td>
					        <td style="width: 15%">
                                                 <form class="addFriendAccept">
                                                 <input type="hidden" name="notifId" value="<?php echo $row['id'] ?>">
                                     <input type="hidden" name="requesteeUN" value="<?php echo $username?>">
                                                 <input type="submit" class="btn" style="color: white" value="Accept"/>
                                                 </form>
                            </td>
                            <td style="width: 15%">
                                                 <form class="addFriendDecline">
                                                 <input type="hidden" name="notifId" value="<?php echo $row['id'] ?>">
                                                 <input type="submit" class="btn" style="color: white" value="Decline"/>
                                                 </form>
                            </td>
                                                 <!--
					      </tr>
					        <tr style="border-bottom: solid 1px #25252533">
					      	  <td style="width: 60%"><?php echo $row['body'] ?></td>
					      	  <td style="width: 20%"><button class="btn"><font color="#FFF">Accept</font></button></td>
					      	  <td style="width: 20%"><button class="btn"><font color="#FFF">Decline</font></button></td>
					    	</tr>-->
					      <?php } elseif($row['reason']=='fxCoinReq') {
					        $fxCoinReq_query = "SELECT * FROM fxcoin_req WHERE notif=".$row['id'];
					    	$fxCoinReq_result = mysqli_query($wallet_connection, $fxCoinReq_query) or die(mysqli_error($wallet_connection));
					    	$fxCoinReq_fetch = mysqli_fetch_array($fxCoinReq_result);
					      ?>
					        <tr style="border-bottom: solid 1px #25252533">
					      	  <td style="width: 70%"><?php echo $row['body'] ?></td>	      
					      	  <?php if(!isset($fxCoinReq_fetch['accepted'])) { ?>
					      	   <td style="width: 15%">
						    <form class="reqFxCoinForm">
						      <input type="hidden" name="reason" value="<?php echo $row['reason'] ?>">
						      <input type="hidden" name="sender" value="<?php echo $fxCoinReq_fetch['sender'] ?>">
						      <input type="hidden" name="reciever" value="<?php echo $fxCoinReq_fetch['reciever'] ?>">
						      <input type="hidden" name="amnt" value="<?php echo $fxCoinReq_fetch['amnt'] ?>">
						      <input type="hidden" name="notif" value="<?php echo $fxCoinReq_fetch['notif'] ?>">
						      <input type="hidden" name="accepted" value="1">
						      <button type="submit" class="btn">Send</button>
						    </form>
						   </td>
						   <td style="width: 15%">
						    <form class="reqFxCoinFormDecline">
						     <input type="hidden" name="reason" value="<?php echo $row['reason'] ?>">
						     <input type="hidden" name="sender" value="<?php echo $fxCoinReq_fetch['sender'] ?>">
						     <input type="hidden" name="reciever" value="<?php echo $fxCoinReq_fetch['reciever'] ?>">
						     <input type="hidden" name="amnt" value="<?php echo $fxCoinReq_fetch['amnt'] ?>">
						     <input type="hidden" name="notif" value="<?php echo $fxCoinReq_fetch['notif'] ?>">
						     <input type="hidden" name="accepted" value="0">
						     <button class="btn">Decline</button>
						    </form>
						   </td>
						  <?php } ?>
					        </tr>
					      <?php } else { ?>
					        <tr style="border-bottom: solid 1px #25252533">
					      	  <td style="width: 60%"><?php echo $row['body'] ?></td>
					        </tr>
					      <?php } ?>
					    <?php } ?>
					  <?php } ?>
					</table>
					</div>
                                        </div>
                                </div>
                        </div>
			<!-- end sidebar -->
                </div>
</div>



<!-- FOOTER
================================================== -->
<div id="wrapfooter">
        <div class="grid">
                <div class="row" id="footer">
                        <!-- to top button  -->
                        <!--<p class="back-top floatright">
                                <a href="#top"><span></span></a>
                        </p>-->
                        <!-- 1st column -->
			<div class="c4">
                          <div class="logoimgbig biglogo" style="margin-left: 0"></div>
                        </div>
                        <!-- 2nd column -->
                        <div class="c4">
                                <h2 class="title">Contact</h2>
                                <hr class="footerstress">
                                <dl>
                                        <dt>New Horizon Building, Ground Floor,
                                                <br />3 1/2 Miles Philip S.W. Goldson Highway,
                                                <br />Belize City, Belize,
                                                <br />Central America</dt>
                                        <dd>E-mail: <a href="#">contact@fxunivers.com</a></dd>
                                </dl>
                                <ul class="social-links" style="margin-top:15px;">
                                        <li class="facebook-link smallrightmargin">
                                        <a href="https://www.facebook.com/fxunivers" class="facebook has-tip" target="_blank" title="Join us on Facebook">Facebook</a>
                                        </li>
                                        <li class="linkedin-link smallrightmargin">
                                        <a href="https://www.linkedin.com/company/fxunivers/" class="linkedin has-tip" title="Linkedin" target="_blank">Linkedin</a>
                                        </li>
                                        <li class="twitter-link smallrightmargin">
                                        <a href="https://twitter.com/fxunivers" class="twitter has-tip" target="_blank" title="Follow Us on Twitter">Twitter</a>
                                        </li>
                                </ul>
                        </div>
                        <!-- 3rd column -->
                        <div class="c4">
                                <h2 class="title">Policy</h2>
                                <hr class="footerstress">
                                <a href="/policy">Policy and Agreements</a>
                        </div>
                </div>
        </div>
</div>

<!-- copyright area -->
<div class="copyright">
        <div class="grid">
		<div class="row">
                        <div class="c6">
                                With all due Reserves,
                        </div>
                </div>
                <div class="row">
                        <div class="c6">
                                 fxUnivers &copy; 2017-2020. All Rights Reserved.
                        </div>
                        <div class="c6">
                                <span class="right">
                                <!-- by Milad, milad@fxunivers.com --> </span>
                        </div>
                </div>
        </div>
</div>


<!-- The Modal -->
<div id="insuffFund" class="modal">
  <!-- Modal Content -->
  <div class="modal-content">
    <span class="close" id="closeX">&times;</span>
    <img src="/images/artwork/wallet.png" style="height: 50px; width: 50px;">
    <h6 style="font-size: 1.5rem;">Insufficient Funds</h6>
    <p>Please boost your fxCoins in your fxWallet or decline the request.</p>
    <table>
      <tr>
        <td><a href="/wallet"><button class="btn">Go to fxWallet</button></a></td>
	<td><button class="btn">Decline</button></td>
      </tr>
    </table>
  </div>
</div>



<!-- JAVASCRIPTS
================================================== -->
<!-- all -->
<script src="/js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="/js/common.js"></script>

<!-- cycle -->
<script src="/js/jquery.cycle.js"></script>

<!-- twitter -->
<script src="/js/jquery.tweet.js"></script>

<!-- filtering -->
<script src="/js/jquery.isotope.min.js"></script>

<!-- CALL filtering & masonry-->
<script>
$(document).ready(function(){
var $container = $('#content');
  $container.imagesLoaded( function(){
        $container.isotope({
        filter: '*',
        animationOptions: {
     duration: 750,
     easing: 'linear',
     queue: false,
   }
});
});
$('#nav a').click(function(){
  var selector = $(this).attr('data-filter');
    $container.isotope({ 
        filter: selector,
        animationOptions: {
     duration: 750,
     easing: 'linear',
     queue: false,
   }
  });
  return false;
});
$('#nav a').click(function (event) {
    $('a.selected').removeClass('selected');
    var $this = $(this);
    $this.addClass('selected');
    var selector = $this.attr('data-filter');
    $container.isotope({
         filter: selector
    });
    return false; // event.preventDefault()
});
});
 </script>

 <!-- Call opacity on hover images-->
<script type="text/javascript">
$(document).ready(function(){
    $(".boxcontainer img").hover(function() {
      $(this).stop().animate({opacity: "0.6"}, 'slow');
    },
    function() {
      $(this).stop().animate({opacity: "1.0"}, 'slow');
                                                                                       289,55        97%
    });
  });
</script>


<script>
var modal=document.getElementById('insuffFund');
window.onclick=function(event) {
  if(event.target==modal) {
    modal.style.display='none';
  }
}

document.getElementById('closeX').onclick=function() {
  document.getElementById('insuffFund').style.display='none';
}
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
                    if(result=='success') {
                        alert('The transaction is completed successfully.');
                        location.reload();
                        //e.preventDefault();
                        /*jQuery.ajax({
                          type: 'POST',
                          url: '/wallet/php/get_fxcoin_count.php',
                          data: $(this).serialize(),
                          success: function() {
                                $("#fxCoinCount").load(window.location.href + " #fxCoinCount");
                                //e.preventDefault();
                                jQuery.ajax({
                                  type: 'POST',
                                  url: '/userpgs/php/notif.php',
                                  data: $(this).serialize(),
                                  success: function() {
                                        $('#notif_update').load(window.location.href+' #notif_update');
                                  }
                                });
                          }
                        });*/
                    } else if(result=='insuff') {
                        alert('Insufficient Funds!');
                    } else if(result=='declined') {
                        alert('The request is declined.');
                        location.reload();
                        //e.preventDefault();
                        /*jQuery.ajax({
                          type: 'POST',
                          url: '/userpgs/php/notif.php',
                          data: $(this).serialize(),
                          success: function() {
                                $('#notif_update').load(window.location.href+' #notif_update');
                          }
                        });*/
                    }
              }
            
            });
        } else {
            return false;
        }
    });
});

/*$(function() {
    $('.reqFxCoinForm').on('submit', function(e) {
        //alert('OK');
        e.preventDefault();
        if(confirm('Please confirm the transfer request and send! Note that this transfer includes 10% interest rate.')) {
            jQuery.ajax({
              type: 'POST',
              url: '/wallet/php/req_fxcoin.php',
              data: $(this).serialize(),
              success: function(result) {
                    if(result=='success') {
                        //e.preventDefault();
                        $.ajax({
                          type: 'POST',
                          url: '/wallet/php/get_fxcoin_count.php',
                          data: $(this).serialize(),
                          success: function() {
                                $("#fxCoinCount").load(window.location.href + " #fxCoinCount");
                                //e.preventDefault();
                                $.ajax({
                                  type: 'POST',
                                  url: '/userpgs/php/notif.php',
                                  data: $(this).serialize(),
                                  success: function() {
                                        $('#notif_update').load(window.location.href+' #notif_update');
                                  }
                                });
                          }
                        });
                    } else if(result=='insuff') {
                        alert('insuff funds');
                    } else if(result=='declined') {
                        e.preventDefault();
                        $.ajax({
                          type: 'POST',
                          url: '/userpgs/php/notif.php',
                          data: $(this).serialize(),
                          success: function() {
                                $('#notif_update').load(window.location.href+' #notif_update');
                          }
                        });
                    }
              }
            
            });
        } else {
            return false;
        }
    });
    });*/
</script>

<script>
$(function() {
    $('.addFriendAccept').on('submit', function(e) {
        //alert('ok');
        //alert('<?php echo $first_notif_id ?>');
        e.preventDefault();
        jQuery.ajax({
          type: 'POST',
          url: '/php/acceptFndReq.php',
          data: $(this).serialize(),
          success: function(result) {
                //alert(result);
                $('#notif_update').load(window.location.href+' #notif_update');
          }
        });
    });
});
</script>

<script>
$(function() {
    $('.addFriendDecline').on('submit', function(e) {
        //alert('ok');
        //alert('<?php echo $first_notif_id ?>');
        e.preventDefault();
        jQuery.ajax({
          type: 'POST',
          url: '/php/declineFndReq.php',
          data: $(this).serialize(),
          success: function(result) {
                //alert(result);
                $('#notif_update').load(window.location.href+' #notif_update');
          }
        });
    });
});
</script>

<!-- BUTTONS -->
<script>
$(document).ready(function() {
    $('#traderBtn').hover(function() {
        var imgUrl='../../images/leftsidebar/trader_b.png';
        $('#traderSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/leftsidebar/trader_a.png';
        $('#traderSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#walletBtn').hover(function() {
        var imgUrl='../../images/leftsidebar/wallet_b.png';
        $('#walletSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/leftsidebar/wallet_a.png';
        $('#walletSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#instructorBtn').hover(function() {
        var imgUrl='../../images/leftsidebar/instructor_b.png';
        $('#instructorSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/leftsidebar/instructor_a.png';
        $('#instructorSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#partnerBtn').hover(function() {
        var imgUrl='../../images/leftsidebar/partner_b.png';
        $('#partnerSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/leftsidebar/partner_a.png';
        $('#partnerSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#studentBtn').hover(function() {
        var imgUrl='../../images/leftsidebar/student_b.png';
        $('#studentSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/leftsidebar/student_a.png';
        $('#studentSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#homeBtn').hover(function() {
        var imgUrl='../../images/logos/fxlogo_a.png';
        $('#homeSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/logos/fxlogo_b.png';
        $('#homeSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#notif_a').hover(function() {
        var imgUrl='../../images/upperbar/notification_b.png';
        $('#ubiNotif').attr("src", imgUrl);
    }, function() {
        var imgUrl0='../../images/upperbar/notification_a.png';
        $('#ubiNotif').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubHome').hover(function() {
        var imgUrl='../../images/upperbar/home_b.png';
        $('#ubiHome').attr("src", imgUrl);
    }, function() {
        var imgUrl0='../../images/upperbar/home_a.png';
        $('#ubiHome').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubLogout').hover(function() {
        var imgUrl='../../images/upperbar/logout_b.png';
        $('#ubiLogout').attr("src", imgUrl);
    }, function() {
        var imgUrl0='../../images/upperbar/logout_a.png';
        $('#ubiLogout').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#msg_bar').hover(function() {
        var imgUrl='../../images/upperbar/message_b.png';
        $('#ubiMsg').attr("src", imgUrl);
    }, function() {
        var imgUrl0='../../images/upperbar/message_a.png';
        $('#ubiMsg').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubSearch').hover(function() {
        var imgUrl='../../images/upperbar/search_b.png';
        $('#ubiSearch').attr("src", imgUrl);
    }, function() {
        var imgUrl0='../../images/upperbar/search_a.png';
        $('#ubiSearch').attr("src",imgUrl0);
    });
});
</script>


<script>
$(document).ready(function() {
    $('#ads1').hover(function() {
        $('#ads1').css({opacity:1});
    }, function() {
        $('#ads1').css({opacity:0.8});
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ads2').hover(function() {
        $('#ads2').css({opacity:1});
    }, function() {
        $('#ads2').css({opacity:0.8});
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ads3').hover(function() {
        $('#ads3').css({opacity:1});
    }, function() {
        $('#ads3').css({opacity:0.8});
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ads4').hover(function() {
        $('#ads4').css({opacity:1});
    }, function() {
        $('#ads4').css({opacity:0.8});
    });
});
</script>
<!-- EO BUTTONS -->

<!-- NOTIFS -->
<script>
$(document).ready(function() {
  var notifUserId=<?php echo $get_user_id ?>;
  setInterval(function() {
    $.ajax({
      type: 'POST',
      url: '/php/notif_icon.php',
      data: {notif_userId: notifUserId},
      success: function(response) {
            //var json=$.parseJSON(response);
            //alert(json.last_notif);
            //alert(response);
            if(response==='1') {
                //alert('its 1');
                $('#notif_a').css('background-color', '#3282b8');
            }

            $.ajax({
              type: 'POST',
              url: '/php/msg_icon.php',
              data: {msg_userId: notifUserId},
              success: function(result) {
                    if(result>0) {
                        $('#msg_bar').css('background-color', '#3282b8');
                    }
              }
            });
      }
    });
  }, 2000);
});
</script>
<!-- EO NOTIFS -->
</body>
</html>