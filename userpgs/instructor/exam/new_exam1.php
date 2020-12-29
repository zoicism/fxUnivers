<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/
  session_start();
  require('../../../register/connect.php');

  if(isset($_GET['course_id'])) $course_id = $_GET['course_id'];

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
	header("Location: /register/logout.php");
}

  $course_query = "SELECT * FROM `teacher` WHERE id=$course_id";
  $course_result = mysqli_query($connection, $course_query) or die(mysqli_error($connection));
  $course_fetch = mysqli_fetch_array($course_result);

  $user_id = $course_fetch['user_id'];
  $get_course_teacher_id = $user_id;
  $header = $course_fetch['header'];
  $description = $course_fetch['description'];
  $video = $course_fetch['video_url'];
  $s_date = $course_fetch['start_date'];
  $e_date = $course_fetch['exam_date'];
  $cost = $course_fetch['cost'];

  require('../php/classes.php');


  require('../../../php/get_user.php');
  $id = $get_user_id;

  require('../../php/notif.php');

  require('../../../php/get_user_type.php');

  require('../../../php/get_exam.php');

require('../../../php/get_last_question_id.php');
  
?>


<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>New Exam Question</title>
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
<link rel="stylesheet" type="text/css" href="/css/roundcorner.css"/>
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



    
<!-- LEFT HALF -->
<div class="c3">
    <h2 style="text-align:center"><?php echo $header.' Exam' ?></h2>


<!-- QUESTION -->
    <form action="/userpgs/instructor/exam/submit_question.php" method="POST" id="question_form">
		        <!-- begin slider area -->
			     <hr class="hrtitle">
			     <h3>Question #<?php echo $get_exam_count+1 ?>:</h3>
                   <input type="hidden" name="question_id" style="height: 40px; width: 90px; margin-left: 10px; font-size: 2rem;" value="<?php echo $last_question_id+1 ?>" >
			<textarea name="question" class="form-control" rows="6" placeholder="Question ...?" required></textarea>

			<hr class="hrtitle" style="border-color:#25252533">
			  <h3>Choices:</h3>
    <p style="font-weight:bold">(A) <input type="text" name="answer_a" style="margin-left: 10px; display: inline; width: 500px;"></p>
    <p style="font-weight:bold">(B) <input type="text" name="answer_b" style="margin-left: 10px; display: inline; width: 500px;"></p>
    <p style="font-weight:bold">(C) <input type="text" name="answer_c" style="margin-left: 10px; display: inline; width: 500px;"></p>
    <p style="font-weight:bold">(D) <input type="text" name="answer_d" style="margin-left: 10px; display: inline; width: 500px;"></p>
    <hr class="hrtitle" style="border-color:#25252533">
    <h3>Correct Answer:</h3>
    <select name="cor_ans" style="width: 90px; display: inline; margin-top: 20px;">
				    <option value="a">A</option>
  				    <option value="b">B</option>
  				    <option value="c">C</option>
  				    <option value="d">D</option>
				  </select>
    <hr class="hrtitle" style="border-color:#25252533">
			    
			    <input type="hidden" name="course_id" value="<?php echo $course_id ?>">
			    <button type="submit" class="btn">Submit: Next</button>
		  </form>
<a href="/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id?>"><button class="btn">Done</button></a>

    <hr class="hrtitle" style="border-color:#25252533">
</div>




    
<!-- RIGHT HALF -->
<div class="c3">
<!-- Problems -->
			<h3 style="text-align:center">List of Questions</h3>
            
			<div class="list-type1">
		  	  <ol>
<?php if($get_exam_result->num_rows > 0) {
          $rowNum=1;
?>
			      <li><a href="/userpgs/instructor/exam/edit_exam.php?q_id=<?php echo $get_exam_fetch['id'].'&course_id='.$get_exam_fetch['course_id'] ?>"><strong><?php echo 'Question #'.$rowNum//.$get_exam_fetch['question_id'] ?></strong><br><?php echo $get_exam_fetch['question'] ?></a></li>
			    <?php
			      while($row = $get_exam_result->fetch_assoc()) {
                      $rowNum++;
			    ?>
                      <li><a href="/userpgs/instructor/exam/edit_exam.php?q_id=<?php echo $row['id'].'&course_id='.$row['course_id'] ?>"><strong><?php echo 'Question #'.$rowNum//$row['question_id'] ?></strong><br><?php echo $row['question'] ?></a></li>
			    <?php } ?>
<?php } else {
    echo '<p style="color:gray;text-align:center;">No questions have been added yet</p>';
}
?>
			    
		  	  </ol>
			</div>
</div>





























    
			<div class="c12">
				<h1 style="font-size: 2.3rem;">
				</h1>
			</div>
		</div>
		<div class="row">
		  
          
			<hr class="hrtitle">
			

			<hr class="hrtitle">
			
		  
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
