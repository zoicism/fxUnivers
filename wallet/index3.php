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
    header('Location: /register/logout.php');
    exit();
}

require('../php/get_user.php');
$id = $get_user_id;

require('../userpgs/php/notif.php');

require('../php/get_plans.php');

require('../php/get_rel.php');

require('php/get_fxcoin_count.php');

//require('../php/get_trans.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width"/>
<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
<title>fxWallet</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/skinblue.css"/><!-- change skin color here -->
<link rel="stylesheet" type="text/css" href="/css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="/css/list/rotated_nav.css"/>
<link rel="stylesheet" type="text/css" href="/css/toptobottom.css"/>
<link rel="stylesheet" type="text/css" href="/css/odometer.css"/>
<link rel="stylesheet" type="text/css" href="/css/box.css"/>
<link rel="stylesheet" type="text/css" href="/css/hor_fnds.css"/>
    
<!-- new stylesheets -->
<link rel="stylesheet" type="text/css" href="/css/roundcorner.css"/>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

<script src="/js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->
<script src="/js/function.js"></script>
<script src="http://cdnks.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- to Sandbox Paypal acnt -->
<script src="https://www.paypal.com/sdk/js?client-id=AamVi8YxFRCNHDKC8cNfMuhM7IoNwGFbx59cMUQrd-Wd6d53EjjhhHJoWtCQeIXXxIIUCTfY6iVZ1gRQ"></script>
    <!-- to real-world Paypal acnt -->
<!--<script src="https://www.paypal.com/sdk/js?client-id=ARS5GFZ290HgkTD6KmPQ1Y5CRxPgZ6GIBwDQ3j4b_NKzQhPXYciKGOSlINhE93SmEZ6SKR47wohz4h6M"></script>-->
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
    $path="../userpgs/avatars/";
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


			    <table style="margin-top: 10px; line-height: 0;"class="lsb-screensize" class="lsb-screensize">
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

          <p id="rcorners1" style="font-size: 1rem; font-weight: bold; margin-bottom: 20px;" class="show-wallet-ss"><span style="float: left"><img src="/images/leftsidebar/fxcoin.png" style="height: 15px; width: 11.25px"></span><span style="float:right; font-family: courier;"><?php echo $get_fxcoin_count ?></span></p>

          <hr class="hrtitle show-wallet-ss" style="border-color: #25252533">
          
			</div>

			<!-- MAIN CONTENT -->
			<div class="c3">
			     <div class="rightsidebar">
			     	  <h2 class="title stresstitle">Wallet</h2>
				  <hr class="hrtitle" >

          <h3 style="margin-bottom:0">My Transactions</h3>
          <button class="btn" id="showTrans">Show/Hide Transactions</button>
          <div id="transList" style="display:none">

<?php
          if($get_trans_count>0) {
              echo '<table style="border: 1px solid #ccc;">';
              echo '<tr style="border-bottom: 1px solid #ccc;font-weight:bold;"><td style="text-align:center;">#</td><td>FROM</td><td>TO</td><td>AMOUNT (fxStars)</td><td>DATE & TIME (ET)</td></tr>';
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
                      $tr_color='background-color:rgba(255,149,149,0.75)';
                  } else {
                      $tr_color='background-color:rgba(115,191,223,0.55)';
                  }
                  echo "<tr style=\"".$tr_color.";border-bottom: 1px solid #ccc;\"><td style=\"text-align:center\">".$trans_i."</td><td><a href=\"/user/".$trans_from_un."\">@".$trans_from_un."</a></td><td><a href=\"/user/".$trans_to_un."\">@".$trans_to_un."</a></td><td>".$trans_row['amnt']."</td><td>".$trans_row['dt']."</td></tr>";
                  $trans_i++;
              }
              echo '</table>';
          } else {
              echo 'No results found.';
          }
?>
          
          </div>

<hr class="hrtitle" style="border-color: #25252533">

				  <h3 style="margin-bottom: 0">Buy fxStars</h3>

				  <p>How many fxStars would you like to purchase?</p>
				  <table style="width: 80%">
				    <tr>
				      <td>
				        <form>
    				          <input type="number" min="0" max="1000000000" id="fxCoinAmnt" style="font-size: 2rem; font-family: courier; background-color: #dadddf; margin-bottom: 0;" value="1" style="display:block" autocomplete="off">
  				        </form>
				      </td>
				    </tr>
          <tr>
          <td>Total cost (USD): <span id="totalCost">2</span></td>
          </tr>
				    <tr>
				      <td><div id="paypal-button-container"></div></td>
				    </tr>
				  </table>
			     

			       <hr class="hrtitle" style="border-color: #25252533">

			       

			       

			       <!-- REQUEST FXCOINS -->
			       <h3 style="margin-bottom: 0">Request fxStars</h3>
			       <p>You can only request fxStars from a friend! Click the button below to get redirected to your list of friends to whom you can issue a request.</p>
			       <button class="btn" style="float: none" onclick="showReq()">Request fxStars</button>
			       <!-- GRAB FRIENDS TO REQUEST FXCOIN -->
			       <div class="scrollmenu" style="display: none" id="req-fxcoins-friends">
				 <?php while($row=$get_rel_friends_result->fetch_assoc()) {
				   if($row['user1']==$get_user_id) {
				     $fnd_user_id=$row['user2'];
				   } else {
				     $fnd_user_id=$row['user1'];
				   }
				   $fnd_user_query = "SELECT * FROM user WHERE id=$fnd_user_id";
				   $fnd_user_result = mysqli_query($connection, $fnd_user_query) or die(mysqli_error($connection));
				   $fnd_user_fetch = mysqli_fetch_array($fnd_user_result);
				 ?>
				   <a class="toggleReqFinal"><?php echo '@'.$fnd_user_fetch['username']?></a>
				 <?php
				   //mysqli_data_seek($get_rel_friends_result,0);
				 } ?>
			       </div>
			       <div id="req-fxcoins-final" style="display: none">
			         <form id="reqToFndForm" style="width: 300px; margin-top: 20px;">
				   Requestee Username: <input type="text" name="reqFrom" id="reqToId" readonly/>
				   Amount of fxStars to be requested: <input type="number" name="reqAmnt" id="reqToAmnt" min="1" max="1000000" style="font-family: courier; background-color: #dadddf;" value="1" required/>
          <p>Total cost for your friend (fxStar): <span id="totalReqCost">2</span></p>
				   <button class="btn" type="submit">Submit</button>
				 </form>
			       </div>

			       <!-- SEND FXCOINS -->
			       <hr class="hrtitle" style="border-color: #25252533">
			       <h3 style="margin-bottom: 0">Send fxStars</h3>
			       <p>You can send fxStars to your fxFriends from right here with just a few clicks.</p>
			       <button class="btn" onclick="toggleSend()" style="float: none">Send fxStars</button>
			       <!-- GRAB FRIENDS TO SEND FXCOIN -->
			       <div class="scrollmenu" style="display: none" id="send-fxcoins-friends">
				 <?php while($row=$get_rel_friends_result2->fetch_assoc()) {
				   if($row['user1']==$get_user_id) {
				     $fnd_user_id=$row['user2'];
				   } else {
				     $fnd_user_id=$row['user1'];
				   }
				   $fnd_user_query = "SELECT * FROM user WHERE id=$fnd_user_id";
				   $fnd_user_result = mysqli_query($connection, $fnd_user_query) or die(mysqli_error($connection));
				   $fnd_user_fetch = mysqli_fetch_array($fnd_user_result);
				 ?>
				   <a class="toggleSendFinal"><?php echo '@'.$fnd_user_fetch['username']?></a>
				 <?php } ?>
			       </div>
			       <div id="send-fxcoins-final" style="display: none">
			         <form id="sendToFndForm" style="width: 300px; margin-top: 20px;">
				   Recepient Username: <input type="text" name="sendTo" id="sendToId" readonly/>
				   Amount of fxStars to be sent: <input type="number" name="sendAmnt" id="sendToAmnt" min="1" max="1000000" style="font-family: courier; background-color: #dadddf;" value="1" required/>
          <p>Total cost (fxStar): <span id="totalSendCost">2</span></p>
				   <button class="btn" type="submit">Send</button>
				 </form>
			       </div>

			       <hr class="hrtitle" style="border-color: #25252533">
			       <h3 style="margin-bottom: 0">Take Courses</h3>
			       <p>Register as a student and take courses from the top instructors worldwide and become a pro trader! Click the following botton to be taken to the fxUniversity page!</p>
			       <a href="/userpgs/student"><button class="btn" style="float: none">Student Dashboard</button></a>
			       
			       <hr class="hrtitle" style="border-color: #25252533">
			       <h3 style="margin-bottom: 0">Cash Out</h3>
			       <p>The minimum number of fxStars that you can cash out are <u>100 fxStars</u>. Select one of the following methods in order to do so.</p>
			     </div>

                   
			</div>
                   <div class="c33">
                   <h3 style="margin-bottom: 0; margin-top: 48px;">Make fxStars</h3>
			       <p>The following are the ways with which you can make fxStars in short and long run.</p>

				   <table>
			    <tr>
			      <td>
			        <a href="/userpgs/trader"><img src="/images/ads/universe.png" class="ads" id="ads1" style="margin-top: 5px"></a>
			      </td>
			    </tr>
			    <tr>
			      <td>
			        <a href="/userpgs/partner"><img src="/images/ads/partner.png" class="ads" id="ads2"></a>
			      </td>
			    </tr>
			    <tr>
			      <td>
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
					  } ?>"><img src="/images/ads/instructor.png" class="ads" id="ads3"></a>
			      </td>
			    </tr>
                
			  </table>

          
                   </div>
                   
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

<!-- JAVASCRIPTS
================================================== -->
<!-- all -->
<script src="/js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="/js/common.js"></script>

<!-- slider -->
<script src="/js/jquery.cslider.js"></script>

<!-- cycle -->
<script src="/js/jquery.cycle.js"></script>

<!-- carousel items -->
<script src="/js/jquery.carouFredSel-6.0.3-packed.js"></script>

<!-- twitter -->
<script src="/js/jquery.tweet.js"></script>

<!-- Call Showcase - min:4 and max:4 is the range of the items i want 2b visible -->
<script type="text/javascript">
$(window).load(function(){			
			$('#recent-projects').carouFredSel({
				responsive: true,
				width: '100%',
				auto: true,
				circular	: true,
				infinite	: false,
				prev : {
					button		: "#car_prev",
					key			: "left",
						},
				next : {
					button		: "#car_next",
					key			: "right",
							},
				swipe: {
					onMouse: true,
					onTouch: true
					},
				scroll : 2000,
				items: {
					visible: {
						min: 4,
						max: 4
					}
				}
			});
		});	
</script>

<!-- Call opacity on hover images from carousel-->
<script type="text/javascript">
$(document).ready(function(){
    $("img.imgOpa").hover(function() {
      $(this).stop().animate({opacity: "0.6"}, 'slow');
    },
    function() {
      $(this).stop().animate({opacity: "1.0"}, 'slow');
    });
  });
</script>

<script>
                   $("#fxCoinAmnt").each(function() {
                       var elem=$(this);

                       //current value
                       elem.data('oldVal', elem.val());

                       // look for changes
                       elem.bind("propertychange change click keyup input paste", function(event) {
                           if(elem.data('oldVal')!=elem.val()) {
                               elem.data('oldVal', elem.val());
                               
                               //$('#totalCost').html('OK');
                               //var numfxs=$("#fxCoinAmnt").val();
                               //var tCost=ceil(numfxs*0.1)+numfxs;
                               $("#totalCost").html(Math.ceil(elem.val()*0.1)+parseInt(elem.val()));
                           }
                       });
                   
                       
                   });
</script>

<script>
                   $('#reqToAmnt').each(function() {
                       var elem2=$(this);
                       elem2.data('oldVal', elem2.val());
                       elem2.bind("propertychange change click keyup input paste", function(event) {
                           if(elem2.data('oldVal')!=elem2.val()) {
                               elem2.data('oldVal', elem2.val());
                               $('#totalReqCost').html(Math.ceil(elem2.val()*0.1)+parseInt(elem2.val()));
                           }
                       });
                   });
</script>

<script>
$('#sendToAmnt').each(function() {
    var elem3=$(this);
    elem3.data('oldVal', elem3.val());
    elem3.bind('propertychange change click keyup input paste', function(event) {
        if(elem3.data('oldVal')!=elem3.val()) {
            elem3.data('oldVal', elem3.val());
            $('#totalSendCost').html(Math.ceil(elem3.val()*0.1)+parseInt(elem3.val()));
        }
    });
});
</script>
                   
                   
<script>


  paypal.Buttons({
    createOrder: function(data, actions) {
      var amntTxt = document.getElementById("fxCoinAmnt").value;
      var amntToBase10 = parseInt(amntTxt, 10);
      var amntPlusIn=amntToBase10+parseInt(Math.ceil(amntToBase10*0.1));
      var amnt = amntPlusIn.toString();
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: amnt
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      
      var amntTxt = document.getElementById("fxCoinAmnt").value;
      var amntToBase10 = parseInt(amntTxt, 10);
      return actions.order.capture().then(function(details) {
        alert('Transaction completed by ' + details.payer.name.given_name);
	    jQuery.ajax({
	      data: 'numOfFxCoins=' + amntToBase10,
	      url: 'php/buy_coin.php',
          method: 'POST',
	      success: function(msg) {
	        //alert('success');
	    }
	});
	location.reload();
        // Call your server to save the transaction
        return fetch('/paypal-transaction-complete', {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            orderID: data.orderID
          })
        });
      });
    }
  }).render('#paypal-button-container');



</script>

<script>
var inputNum = document.getElementById('fxCoinAmnt');
inputNum.onkeydown = function(e) {
  if(!((e.keyCode>95 && e.keyCode<106) || (e.keyCode > 47 && e.keyCode < 58) || e.keyCode == 8)) {
    return false;
  }
}
</script>

<script>
var inputNumTr = document.getElementById('sendToAmnt');
inputNumTr.onkeydown = function(e) {
  if(!((e.keyCode>95 && e.keyCode<106) || (e.keyCode > 47 && e.keyCode < 58) || e.keyCode == 8)) {
    return false;
  }
}
</script>

<script>
var inputNumReq = document.getElementById('reqToAmnt');
inputNumReq.onkeydown = function(e) {
  if(!((e.keyCode>95 && e.keyCode<106) || (e.keyCode > 47 && e.keyCode < 58) || e.keyCode == 8)) {
    return false;
  }
}
</script>

<script>
var inputNum = document.getElementById('fxCoinAmnt');
inputNum.oninput = function() {
  if(this.value.length > 10) {
    this.value = this.value.slice(0,10);
  }
}
</script>

<script>
function showReq() {
  document.getElementById('req-fxcoins-friends').style.display="block";
}
</script>

<script>
$('.toggleReqFinal').click(function() {
  document.getElementById('req-fxcoins-final').style.display="block";
  document.getElementById('reqToId').value=$(this).text();
});
</script>


<script>
$(function() {
  $('#sendToFndForm').on('submit', function(e) {
      e.preventDefault();
   var recepientUname = document.getElementById('sendToId').value;
   var recepientAmnt = document.getElementById('sendToAmnt').value;
   if(confirm('Please confirm transferring '+recepientAmnt+' fxStars from your wallet to '+recepientUname+'.')) {
    //e.preventDefault();
    
    jQuery.ajax({
      type: 'POST',
      url: '/wallet/php/fxCoinFnd.php',
      data: $('#sendToFndForm').serialize(),
      success: function(result) {
            if(result=='success') {
                alert('The transaction completed successfully!');
                location.reload();
                //alert('OK');
                /*jQuery.ajax({
                  type: 'POST',
                  url: '/wallet/php/get_fxcoin_count.php',
                  data: $(this).serialize(),
                  success: function() {
                        $("#fxCoinCount").load(window.location.href + " #fxCoinCount");
                        document.getElementById('sendToAmnt').value="";
                  }
                  });*/
            } else if(result=='failed') {
                alert('Insufficient Funds!');
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
function toggleSend() {
  var sendFnds = document.getElementById('send-fxcoins-friends');
  sendFnds.style.display="block";
}
</script>

<script>
$('.toggleSendFinal').click(function() {
  document.getElementById('send-fxcoins-final').style.display="block";
  document.getElementById('sendToId').value = $(this).text();
});
</script>

<script>
$(function() {
  $('#reqToFndForm').on('submit', function(e) {
   var reqUname = document.getElementById('reqToId').value;
   var reqAmnt = document.getElementById('reqToAmnt').value;
   if(confirm('Please confirm requesting '+reqAmnt+' fxStars from '+reqUname+'.')) {
    e.preventDefault();
    jQuery.ajax({
      type: 'POST',
      url: '/wallet/php/reqfxCoinFnd.php',
      data: $('#reqToFndForm').serialize(),
      success: function() {
        //alert('OK');
      }
    });
   } else {
     return false;
   }
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
        $('#ads1').css({opacity:0.6});
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ads2').hover(function() {
        $('#ads2').css({opacity:1});
    }, function() {
        $('#ads2').css({opacity:0.6});
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ads3').hover(function() {
        $('#ads3').css({opacity:1});
    }, function() {
        $('#ads3').css({opacity:0.6});
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ads4').hover(function() {
        $('#ads4').css({opacity:1});
    }, function() {
        $('#ads4').css({opacity:0.6});
    });
});
</script>
<!-- EO BUTTONS -->

<!-- NOTIFS -->
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
                $('#notif_a').css('background-color', '#3282b8');
            }

            jQuery.ajax({
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

                   <script>
                   $('#showTrans').click(function() {
                       $('#transList').toggle();
                   });
                   </script>
</body>
</html>