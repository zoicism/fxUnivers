<?php

  session_start();
  require('../../../register/connect.php');

  if(isset($_SESSION['username'])) {
    $username=$_SESSION['username'];
  }

  require('../../../php/get_user.php');
  $id = $get_user_id;

  require('../../php/notif.php');

  if(isset($_GET['course_id'])) {
    $course_id=$_GET['course_id'];
  }
  require('../../../php/get_course.php');

  //require('../../../php/get_user_type.php');

  require('../../../php/get_stucourse.php');

  require('../../../php/get_exam.php');

  require('../../../php/get_exam_acceptance.php');

?>


<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Course <?php echo $user_type ?></title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/css/slider.css"/>
<link rel="stylesheet" type="text/css" href="/css/skinblue.css"/><!-- Change skin color here -->
<link rel="stylesheet" type="text/css" href="/css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="/css/toptobottom.css"/>
<link rel="stylesheet" type="text/css" href="/css/modal.css"/>
<link rel="stylesheet" type="text/css" href="/css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="/css/lessons.css"/>
<link rel="stylesheet" type="text/css" href="/css/buttons/exam.css"/>
<link rel="stylesheet" type="text/css" href="/css/radio.css"/>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
<script src="/js/jquery-1.9.0.min.js"></script><!-- scripts at the bottom of the document -->
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


<!-- CONTENT
================================================== -->
<div class="grid">
		<div class="shadowundertop">
		</div>
		<div class="row">
			<div class="c12">
				<h2 style="text-align:center;margin-bottom:40px;"><?php echo $get_course_fetch["header"].' Exam Result' ?></h2>
      
      <span style="text-align:center">
      <?php
      echo '<p style="font-size:1.8rem">First Name: <b>'.$get_user_fname.'</b></p><hr class="hrtitle" style="border-color:#25252533">';
echo '<p style="font-size:1.8rem">Last Name: <b>'.$get_user_lname.'</b></p><hr class="hrtitle" style="border-color:#25252533">';
echo '<p style="font-size:1.8rem">fxUsername: <b>'.$username.'</b></p><hr class="hrtitle" style="border-color:#25252533">';
echo '<p style="font-size:1.8rem">Course Name: <b>'.$get_course_fetch["header"].'</b></p><hr class="hrtitle" style="border-color:#25252533">';
echo '<p style="font-size:1.8rem">Score: <b>'.$stucourse_fetch["score"].'</b> correct answers from <b>'.$get_exam_count.'</b> questions</p><hr class="hrtitle" style="border-color:#25252533">';

if($get_exam_acc_fetch['exam_accepted']) {
    echo '<p style="font-size:1.8rem">Result: <span style="color: green"><strong>ACCEPTED</strong></span>';
} else {
    echo '<p style="font-size:1.8rem">Result: <span style="color: red"><strong>FAILED</strong></span>';
}
      ?>
      </span>




      
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

<script src="/js/modal.js"></script>

<!-- menu & scroll to top -->
<script src="/js/common.js"></script>

<!-- slider -->
<script src="js/jquery.cslider.js"></script>

<!-- twitter -->
<script src="/js/jquery.tweet.js"></script>

<!-- cycle -->
<script src="/js/jquery.cycle.js"></script>

<!-- flexslider -->
<script src="/js/jquery.flexslider-min.js"></script>

<!-- CALL flexslder -->
<script>
// Can also be used with $(document).ready()
$(window).load(function() {
$('.flexslider').flexslider({
animation: "slide"
});
});
</script>

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


<!-- Not purchased script -->
<script>
function notPurchased() {
  alert("You need to purchase the course first in order to access the classes!");
}
</script>

<script>
function examNotPurchased() {
  alert("You need to purchase the course before being able to take the exam!");
}
</script>

<!-- BUTTONS -->
<script>
$(document).ready(function() {
    $('#homeBtn').hover(function() {
        var imgUrl='/images/logos/fxlogo_a.png';
        $('#homeSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='/images/logos/fxlogo_b.png';
        $('#homeSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#notif_a').hover(function() {
        var imgUrl='/images/upperbar/notification_b.png';
        $('#ubiNotif').attr("src", imgUrl);
    }, function() {
        var imgUrl0='/images/upperbar/notification_a.png';
        $('#ubiNotif').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubHome').hover(function() {
        var imgUrl='/images/upperbar/home_b.png';
        $('#ubiHome').attr("src", imgUrl);
    }, function() {
        var imgUrl0='/images/upperbar/home_a.png';
        $('#ubiHome').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#msg_bar').hover(function() {
        var imgUrl='/images/upperbar/message_b.png';
        $('#ubiMsg').attr("src", imgUrl);
    }, function() {
        var imgUrl0='/images/upperbar/message_a.png';
        $('#ubiMsg').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubSearch').hover(function() {
        var imgUrl='/images/upperbar/search_b.png';
        $('#ubiSearch').attr("src", imgUrl);
    }, function() {
        var imgUrl0='/images/upperbar/search_a.png';
        $('#ubiSearch').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubLogout').hover(function() {
        var imgUrl='/images/upperbar/logout_b.png';
        $('#ubiLogout').attr("src", imgUrl);
    }, function() {
        var imgUrl0='/images/upperbar/logout_a.png';
        $('#ubiLogout').attr("src",imgUrl0);
    });
});
</script>

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
