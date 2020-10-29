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
$bio = $user_fetch['bio'];

// add new post to the timeline
if(isset($_POST['new_post'])) {
	$raw_newpost = nl2br($_POST['new_post']);
	$newpost = mysqli_real_escape_string($connection, $raw_newpost);
	$newpost_query = "INSERT INTO sonet(uid, body) VALUES($id, '$newpost')";
	$newpost_result = mysqli_query($connection, $newpost_query) or die(mysqli_error($connection));
}

// fetch the sonet records
require('sonet/following.php');

// Get the notification!
require('php/notif.php');

// Get the plans!
$get_user_id=$id;
require('../php/get_plans.php');

require('../php/get_rel.php');

require('../wallet/php/get_fxcoin_count.php');

//require('../php/get_likes_dislikes.php');

?>

<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Home</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="css/icons.css"/>
<link rel="stylesheet" type="text/css" href="css/skinblue.css"/><!-- change skin color here -->
<link rel="stylesheet" type="text/css" href="/css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="/css/list/rotated_nav.css"/>
<link rel="stylesheet" type="text/css" href="/css/toptobottom.css"/>
<link rel="stylesheet" type="text/css" href="/css/odometer.css"/>
<link rel="stylesheet" type="text/css" href="/css/roundcorner.css"/>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">--><!-- icon library -->


<script src="/js/jquery-1.9.0.min.js"></script>
<script src="/js/function.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- the rest of the scripts at the bottom of the document -->
</head>



<body>

<!-- UPPER BAR -->
<section class="nav-bar">
  <div class="nav-container">
    
    <div class="brand">
      <a href="/"><div class="logoimg toplogo"></div></a>
    </div>
   
    <nav>
      <div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
      <ul class="nav-list">
        <li>
          <a href="/" id="ubHome"><img id="ubiHome" src="/images/upperbar/home_a.png" alt="Home"></a>
        </li>
        <!--<li class="profile-ss">
          <a href="/user/<?php echo $username?>" id="ubProfile"><img id="ubiProfile" src="/images/upperbar/profile_a.png" alt="Prof"></a>
        </li>-->
        <li>
          <a href="/search" id="ubSearch"><img id="ubiSearch" src="/images/upperbar/search_a.png" alt="Search"></a>
        </li>
	<li>
          <a href="/userpgs/notif" id="notif_a"><img id="ubiNotif" src="/images/upperbar/notification_a.png" alt="Notifs"></a>
        </li>
        <li>
          <a href="/msg/inbox.php" id="msg_bar"><img id="ubiMsg" src="/images/upperbar/message_a.png" alt="Messages"></a>
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
          <a href="/register/logout.php" id="ubLogout"><img id="ubiLogout" src="/images/upperbar/logout_a.png" alt="Logout" ></a>
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
                <div class="shadowundertop"></div>
                <div class="row">

                <!-- LEFT SIDEBAR -->
                <div class="c9">

<?php
    $path="avatars/";
    if(file_exists($path.$get_user_id.'.jpg')) {
        echo('<button class="userpic lsb-sub" style="background-image: url(\'avatars/'.$get_user_id.'.jpg\'); color: black; font-weight: bold;" id="showUpButt"></button>');
    } elseif(file_exists($path.$get_user_id.'.jpeg')) {
        echo('<button class="userpic lsb-sub" style="background-image: url(\'avatars/'.$get_user_id.'.jpeg\'); color: black; font-weight: bold;" id="showUpButt"></button>');
    } elseif(file_exists($path.$get_user_id.'.png')) {
        echo('<button class="userpic lsb-sub" style="background-image: url(\'avatars/'.$get_user_id.'.png\'); color: black; font-weight: bold;" id="showUpButt"></button>');
    } elseif(file_exists($path.$get_user_id.'.gif')) {
        echo('<button class="userpic lsb-sub" style="background-image: url(\'avatars/'.$get_user_id.'.gif\'); color: black; font-weight: bold;" id="showUpButt"></button>');
    } else {
        echo('<button class="userpic avatarr lsb-sub" id="showUpButt"></button>');
    }
?>


    <div id="upButt" style="display: none; margin-bottom: 80px;">
      <form method="POST" action="/php/upload_avatar.php" enctype="multipart/form-data">
        <input type="file" name="avatar_img" id="avatarFile">
        <input type="hidden" name="username" value="<?php echo $username ?>">
        <button type="submit" class="taste-rand" style="float: left" id="avatarBtn">Upload</button>
      </form>


          <form method="POST" action="/php/remove_avatar.php">
            <input type="hidden" name="userId" value="<?php echo $get_user_id ?>"/>
          
          <button type="submit" class="taste-rand" style="float:right;">Remove</button>
          </form>


          
    </div>
          <h2 style="text-align: center; font-size: 1rem; margin-top: 1px; margin-bottom: 0;" class="lsb-sub"><?php echo '<a href="/user/'.$username.'" style="color: black">'.$fname.' '.$lname.' <span style="font-size: 0.9rem">@'.$username.'</span></a>'; ?></h2>
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
                    <h2 class="title stresstitle">Home</h2>
                    <hr class="hrtitle">
						<form method="POST" action="#" autocomplete="off">
							<textarea name="new_post" class="form-control" style="margin-bottom: 2px" rows="1" placeholder="New Post" required></textarea>
          <button class="taste-rand" style="float:right" type="submit" value="New_Post">Post</button>
						</form>
				</div>
          <hr class="hrtitle" style="border-color: #25252533;">
				<div class="rightsidebar">

					<?php
					if($sonet_result->num_rows > 0) {?>
						
						<table>
							<tr style="border-bottom: 1px solid #25252533" class="hoverable">
							<td style="width: 10%">
<?php
                                                     $row["uid"] = $sonet_uid; 
                                                     require('php/username_retrieve.php');
                                                     echo '<a href="/user/'.$sou_username.'">';
    $path="avatars/";
    if(file_exists($path.$sonet_uid.'.jpg')) {
        echo('<div class="avatarpic" style="background-image: url(\'avatars/'.$sonet_uid.'.jpg\');"></div>');
    } elseif(file_exists($path.$sonet_uid.'.jpeg')) {
        echo('<div class="avatarpic" style="background-image: url(\'avatars/'.$sonet_uid.'.jpeg\');"></div>');
    } elseif(file_exists($path.$sonet_uid.'.png')) {
        echo('<div class="avatarpic" style="background-image: url(\'avatars/'.$sonet_uid.'.png\');"></div>');
    } elseif(file_exists($path.$sonet_uid.'.gif')) {
        echo('<div class="avatarpic" style="background-image: url(\'avatars/'.$sonet_uid.'.gif\');"></div>');
    } else {
        echo('<div class="avatarpic avatarr"></div>');
    }
                                                     echo '</a>';
?>
							</td>
							<td style="padding-left: 20px; width: 80%;">				
						
						<?php 
						
					     	   
                               require('../php/get_likes_dislikes.php');
					     	   echo "<a href='/user/".$sou_username."' style='color: #000;'><b>$sou_firstname $sou_lastname</b> <span style='font-size: 0.9em; color: #696969'>@$sou_username</span></a>"; ?> <br/>
						   <p style="font-size: .87rem"><?php echo $sonet_body; ?></p>
						   
							</td>
                                                     <td style="width: 10%">
                                                     <span onclick="thumbsUp(this)" class="likethis" style="margin-left: 20px; color: <?php if($get_i_like) { echo 'rgb(0,139,198)'; } else { echo 'rgba(115,191,223,0.55)'; } ?>;" id="<?php echo $sonet_postId ?>"><?php echo $get_likes ?></span>
                              <span onclick="thumbsDown(this)" class="dislikethis" style="margin-left: 20px; color: <?php if($get_i_dislike) { echo 'rgb(210,70,70)'; } else { echo 'rgba(255,149,149,0.75)'; } ?>;" id="<?php echo $sonet_postId ?>"><?php echo $get_dislikes ?></span>
                                                     </td>
							</tr>
						</table>
						   
						<?php while($row = $sonet_result->fetch_assoc()) { ?>
						
						<table>						
						<tr style="border-bottom: 1px solid #25252533" class="hoverable">
						<td style="width: 10%">
<?php
                                                     require('php/username_retrieve.php');
                                                     echo '<a href="/user/'.$sou_username.'">';
                                                     
    $path="avatars/";
    if(file_exists($path.$row['uid'].'.jpg')) {
        echo('<div class="avatarpic" style="background-image: url(\'avatars/'.$row['uid'].'.jpg\');"></div>');
    } elseif(file_exists($path.$row['uid'].'.jpeg')) {
        echo('<div class="avatarpic" style="background-image: url(\'avatars/'.$row['uid'].'.jpeg\');"></div>');
    } elseif(file_exists($path.$row['uid'].'.png')) {
        echo('<div class="avatarpic" style="background-image: url(\'avatars/'.$row['uid'].'.png\');"></div>');
    } elseif(file_exists($path.$row['uid'].'.gif')) {
        echo('<div class="avatarpic" style="background-image: url(\'avatars/'.$row['uid'].'.gif\');"></div>');
    } else {
        echo('<div class="avatarpic avatarr"></div>');
    }
                                                     echo '</a>';
?>
						</td>
						<td style="padding-left: 20px; width: 80%;">
							   <?php 
                                                     $sonet_postId=$row['id'];
                               require('../php/get_likes_dislikes.php');
                                                           	 echo "<a href='/user/$sou_username' style='color: #000;'><b>$sou_firstname $sou_lastname</b> <span style='font-size: 0.9em; color: #696969'>@$sou_username</style></a>";?><br/>
							   <p style="font-size: .87rem"><?php echo $row["body"]; ?></p>
						</td>
                                                     <td style="width: 10%">
                                                     <span onclick="thumbsUp(this)" class="likethis" style="margin-left: 20px; color: <?php if($get_i_like) { echo 'rgb(0,139,198)'; } else { echo 'rgba(115,191,223,0.55)'; } ?>;" id="<?php echo $sonet_postId ?>"><?php echo $get_likes ?></span>
                              <span onclick="thumbsDown(this)" class="dislikethis" style="margin-left: 20px; color: <?php if($get_i_dislike) { echo 'rgb(210,70,70)'; } else { echo 'rgba(255,149,149,0.75)'; } ?>;" id="<?php echo $sonet_postId ?>"><?php echo $get_dislikes ?></span>
                                                     </td>
						</tr>
						</table>

							   <?php
						}
					}
					?>
                                </div>
                        </div>
			<!-- end sidebar -->

			<div class="c33">
			  <table>
			    <tr>
			      <td>
			        <a href="/userpgs/trader"><img src="/images/ads/universe.png" class="ads" id="ads1" style="margin-top: 38px"></a>
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
                <tr>
			      <td>
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
					} ?>"><img src="/images/ads/student.png" class="ads" id="ads4"></a>
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

<!-- odometer -->
<script src="/js/odometer.js"></script>

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
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>


<!-- odometer -->
<script type="text/javascript">
setTimeout(function() {
	odometer.innerHTML = 1000000;
});
</script>

<script>
  var div = document.createElement('div');
  div.className = 'fb-customerchat';
  div.setAttribute('page_id', '1839310292958109');
  div.setAttribute('ref', 'b64:bGl2ZS1jaGF0');
  document.body.appendChild(div);
  window.fbMessengerPlugins = window.fbMessengerPlugins || {
    init: function () {
      FB.init({
        appId            : '1678638095724206',
        autoLogAppEvents : true,
        xfbml            : true,
        version          : 'v3.3'
      });
    }, callable: []
  };
  window.fbAsyncInit = window.fbAsyncInit || function () {
    window.fbMessengerPlugins.callable.forEach(function (item) { item(); });
    window.fbMessengerPlugins.init();
  };
  setTimeout(function () {
    (function (d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) { return; }
      js = d.createElement(s);
      js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  }, 0);
</script>

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

<script>
$(document).ready(function() {
    $('#showUpButt').click(function() {
        $('#upButt').show("slow");
    });
});
</script>

<script>
function thumbsUp(x) {
    var post_id=x.id;
    var user_id=<?php echo $get_user_id ?>;
    // like post
    $.ajax({
      type: 'POST',
      url: '/php/like_post.php',
      data: {userId: user_id, postId: post_id},
      success: function(result) {
            var results=jQuery.parseJSON(result);
            if(results.like=='liked') {
                x.style.color="rgb(0,139,198)";
                x.innerHTML=results.count+1;
            } else if(results.like=='unliked') {
                x.style.color="rgba(115,191,223,0.55)";
                x.innerHTML=results.count-1;
            }
      }
    });
}
</script>

<script>
function thumbsDown(x) {
    var post_id=x.id;
    var user_id=<?php echo $get_user_id ?>;
    // dislike post
    $.ajax({
      type: 'POST',
      url: '/php/dislike_post.php',
      data: {userId: user_id, postId: post_id},
      success: function(result) {
            var results=jQuery.parseJSON(result);
            if(results.dislike=='disliked') {
                x.style.color="rgb(210,70,70)";
                x.innerHTML=results.count+1;
            } else if(results.dislike=='undisliked') {
                x.style.color="rgba(255,149,149,0.75)";
                x.innerHTML=results.count-1;
            }
      }
    });
}
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

<!-- PROFILE -->
<script>
$(document).ready(function() {
    $('#ubProfile').hover(function() {
        var imgUrl='../../images/upperbar/profile_b.png';
        $('#ubiProfile').attr("src", imgUrl);
    }, function() {
        var imgUrl0='../../images/upperbar/profile_a.png';
        $('#ubiProfile').attr("src",imgUrl0);
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
    $('.userpic').hover(function() {
        $('.userpic').html('CHANGE');
    }, function() {
        $('.userpic').html('');
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


</body>
</html>