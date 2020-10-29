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
	header("Location: /register/logout.php");
}

require('php/courses.php');

require('../../php/get_user.php');
$id = $get_user_id;

require('../php/notif.php');

require('../../php/get_plans.php');

require('../../php/get_rel.php');

require('../../wallet/php/get_fxcoin_count.php');
?>

<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Instructor Dashboard</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/skinblue.css"/><!-- change skin color here -->
<link rel="stylesheet" type="text/css" href="/css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="/css/list/rotated_nav.css"/>
<link rel="stylesheet" type="text/css" href="/css/toptobottom.css"/>
<link rel="stylesheet" type="text/css" href="/css/odometer.css"/>
<link rel="stylesheet" type="text/css" href="/css/roundcorner.css"/>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    
<script src="/js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->
<script src="/js/function.js"></script>
<script src="http://cdnks.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
        echo('<div class="userpic avatarr lsb-sub"></div>');
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
			     	  <h2 class="title stresstitle">Instructor</h2>
				  <hr class="hrtitle" style="margin-bottom: 40px;">

				  
				  <!--<table>
				    <tr><td><p style="font-size: 7rem; color: #333;">0</p></td></tr>
				    <tr><td>Total number of Students<hr class="hrtitle"></td></tr>
				    <tr><td><p style="font-size: 7rem; color: #333;"></p></td></tr>
				    <tr><td>Published courses<hr class="hrtitle"></td></tr>
				    <tr><td><p style="font-size: 7rem; color: #333;">0</p></td></tr>
			    <tr><td>Granted certificates<hr class="hrtitle"></td></tr>
				  </table>-->




          <h3>Published Courses (<?php echo $course_count ?>)</h3>
          <table>
					<col width="15%">
					<col width="25%">
					<col width="60%">

					
					<?php if($course_count>0) { ?>
                                                <tr style="border-bottom: 1px solid #c3c3c3;cursor:pointer;" onclick="window.location='/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id ?>';" class="hoverable">
					<td style="vertical-align:middle;"><img src="/images/artwork/course.png"></td>
					<td style="vertical-align: middle;"><b><?php echo $course_title ?></b></td>
					<td style="text-align: left; vertical-align: middle;"><?php echo $course_desc ?></td>
					<?php } else { ?>
					<!--<td><a href="/userpgs/instructor/course_management/new_course.php" style="color: #000;"><img src="/images/artwork/new_course.png" style="width: 100px; height: 100px; margin-left: 0;"></a></td>
					<td><a href="/userpgs/instructor/course_management/new_course.php" style="color: #000; text-align: left;">Add a new course!</a></td>
					<td></td>-->
                                                </tr>
					<?php } ?>
					
				  
				  <?php if($course_result->num_rows > 0) {
				  	while($row = $course_result->fetch_assoc()) {
				  ?>
					
					<tr style="border-bottom: 1px solid #c3c3c3;cursor:pointer;" onclick="window.location='/userpgs/instructor/course_management/course.php?course_id=<?php echo $row['id'] ?>';" class="hoverable">
					<td style="vertical-align:middle;"><img src="/images/artwork/course.png"></td>
					<td style="vertical-align: middle;"><b><?php echo $row['header'] ?></b></td>
					<td style="text-align: left; vertical-align: middle;"><?php echo $row['description'] ?></td>
					</tr>
				  <?php }
				  } ?>
				  
				  </table>







          
			     </div>
			</div>

			<div class="c33" style="text-align: center">
			  <a href="/userpgs/instructor/course_management/new_course.php" style="color: #000"><img src="/images/artwork/new_course.png" style="height: 100px; width: 100px; margin-left: 0; margin-top: 30px;"><br>Add New Course</a>
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