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
        $session_id_q="SELECT id FROM user WHERE username='$username'";
        $session_id_r=mysqli_query($connection,$session_id_q) or die(mysqli_error($connection));
        $session_id_fetch=mysqli_fetch_array($session_id_r);
        $session_id=$session_id_fetch['id'];
} else {
    header("Location: /register/logout.php");
}

if(isset($_GET['tar'])) {
  $tarname = rtrim($_GET['tar'], "/");
}

//$tarname = substr(getcwd(), 19);
//$tarname = 'neo';
require('../php/get_tar_user.php');

$user_query = "SELECT * FROM user WHERE username='$tarname'";
$user_result = mysqli_query($connection, $user_query) or die(mysqli_error($connection));
// [CODE] if user does not exist, throw error!
$user_fetch = mysqli_fetch_array($user_result);
$fname = $user_fetch['fname'];
$lname = $user_fetch['lname'];
$id = $user_fetch['id'];
$bio = $user_fetch['bio'];


// fetch the sonet records
//require('../userpgs/sonet/following.php');

// Get the notification!
require('../userpgs/php/notif.php');

// Get the plans!
$get_user_id=$id;
require('../php/get_plans.php');

require('../wallet/php/get_fxcoin_count.php');

require('../php/get_sonet.php');

require('../php/get_tar_rel.php');

require('../php/get_tar_plans.php');

if($get_tar_plans_fxuniversityins) require('../php/get_tar_courses.php');
if($get_tar_plans_fxuniversitystu) require('../php/get_tar_stu.php');

require('../php/get_fxinstructor_profile.php');

require('../php/get_follow_fnd.php');

?>

<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title><?php echo $tarname ?></title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/skinblue.css"/><!-- change skin color here -->
<link rel="stylesheet" type="text/css" href="/css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="/css/list/rotated_nav.css"/>
<link rel="stylesheet" type="text/css" href="/css/toptobottom.css"/>
<link rel="stylesheet" type="text/css" href="/css/odometer.css"/>
<link rel="stylesheet" type="text/css" href="/css/profile.css"/>
<link rel="stylesheet" type="text/css" href="/css/roundcorner.css"/>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

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
                                        <h2 class="title stresstitle"><?php echo $tarname?></h2>
                                        <hr class="hrtitle">
					<img src="/images/artwork/checker.png" style="width: 100%; position: relative;">
<?php
$path="../userpgs/avatars/";
if(file_exists($path.$id.'.jpg')) {
    echo('<div class="userpic lsb-sub-prof userpagepic" style="position: absolute; top: 92px; background-image: url(\'/userpgs/avatars/'.$id.'.jpg\');"></div>');   
} elseif(file_exists($path.$id.'.jpeg')) {
    echo('<div class="userpic lsb-sub-prof userpagepic" style="position: absolute; top: 92px; background-image: url(\'/userpgs/avatars/'.$id.'.jpeg\');"></div>');
} elseif(file_exists($path.$id.'.png')) {
    echo('<div class="userpic lsb-sub-prof userpagepic" style="position: absolute; top: 92px; background-image: url(\'/userpgs/avatars/'.$id.'.png\');"></div>');
} elseif(file_exists($path.$id.'.gif')) {
    echo('<div class="userpic lsb-sub-prof userpagepic" style="position: absolute; top: 92px; background-image: url(\'/userpgs/avatars/'.$id.'.gif\');"></div>');
} else {
    echo('<div class="userpic avatarr lsb-sub-prof userpagepic" style="position: absolute; top: 92px; "></div>');
}
?>
					<h2 style="text-align: center; font-size: 1.2rem; margin-bottom: 0; margin-top: 53px;"><?php echo "$tar_fname $tar_lname"; ?></h2>
					<h3 style="text-align: center; font-size: 1rem; margin-bottom: 0;"><?php echo "@$tarname"; ?></h3>
					<div class="profile">
      <!--<p><?php echo $tar_bio ?><?php if($tarname==$username) { echo ' <a onclick="editBio(this)">Edit</a>'; } ?></p>-->
					  <!--<p><img src="/images/location.png" style="width: 15px; height: 15px;"> Cambridge, MA</p>-->
<?php if($tarname!=$username) { ?>
      <button class="btn" style="display: block; margin-left: auto; margin-right: auto;" onclick="setFriend()" id="friendSet"><?php if($get_fnd_count==0) { echo 'Friend'; } else { if($get_fnd==1) { echo 'Unfriend'; } else { echo 'Cancel Friend Request'; } } ?></button>
<button onclick="setFollow()" class="btn" id="followSet" style="display: block; margin-left: auto; margin-right: auto;"><?php if($get_follow==0) { echo 'Follow'; } else { echo 'Unfollow'; } ?></button>
<?php } ?>
					  
      <table style="margin-top: 10px; line-height: 0; width: 214px;" class="center-this rel-nums">
                  <tr>
				    <td style="width: 33.3%; text-align: left;"><a href="/userpgs/rel/user.php?act=friends&u=<?php echo $tarname?>" style="color: black"><strong><?php echo $get_rel_friends_count ?></strong></a></td>
				    <td style="width: 33.3%; text-align: center;"><a href="/userpgs/rel/user.php?act=following&u=<?php echo $tarname?>" style="color: black"><strong><?php echo $get_rel_following_count ?></strong></a></td>
				    <td style="width: 33.3%; text-align: right;"><a href="/userpgs/rel/user.php?act=followers&u=<?php echo $tarname?>" style="color: black"><strong><?php echo $get_rel_followers_count ?></strong></a></td>
				  </tr>
				  <tr>
				    <td style="width: 33.3%; text-align: left;"><a href="/userpgs/rel?act=friends" style="color: black">Friends</a></td>
				    <td style="width: 33.3%; text-align: center;"><a href="/userpgs/rel?act=following" style="color: black">Following</a></td>
				    <td style="width: 33.3%; text-align: right;"><a href="/userpgs/rel?act=followers" style="color: black">Followers</a></td>
				  </tr>
				</table>
      
      <p id="rcorners1" style="font-size: 1rem; font-weight: bold; margin-bottom: 0;" class="lsb-sub"><span style="float: left"><img src="/images/leftsidebar/fxcoin.png" style="height: 15px; width: 11.25px"></span><span style="float:right; font-family: courier;"><?php echo $get_fxcoin_count ?></span></p>
					  <!--<table style="background-color: #dadddf; margin-top: 10px;">
				  	    <tr>
				    	      <td style="width: 20%; height: 4px; "><img src="/images/small_fxstar.png" style="height: 20px; width: 15px"></td>
				    	      <td style="width: 80%; text-align: right;"><p style="font-size: 2rem; font-family: courier; color: black;"><?php echo $get_fxcoin_count ?></p></td>
				  	    </tr>
					  </table>-->

					  
                                        </div>
					<?php if($get_tar_plans_fxuniversityins) { ?>
					<div class="teamdescription jobfile">
					  <p><img src="/images/artwork/briefcase.png" style="width: 15px; height: 15px;opacity:0.5;margin-right:4px;vertical-align:sub;"> <strong>Instructor</strong> at <strong>fxUnivers</strong> <?php if($tarname==$username) { ?><input type="button" class="btn" onclick="toggleEdit()" value="Edit" id="editCancel"><?php } ?></p>
					  
					  <div id="oldFxIns" style="display: block">
					  <?php if($get_fxins_prof_info) { ?><p style="text-indent: 2em"><img src="/images/artwork/dot.png" style="width:8px;height:8px;vertical-align:inherit;margin-right:4px;opacity:0.5;"> <?php echo $get_fxins_prof_info?></p><?php } ?>
					  <p style="text-indent: 2em;cursor: pointer; color: #008bc6;" id="pubPop"><img src="/images/artwork/dot.png" style="width:8px;height:8px;vertical-align:inherit;margin-right:4px;opacity:0.5;"> Published Courses (<?php echo $get_tar_courses_count ?>)</p>


<div id="pubCourses" style="display:none">
<?php
         if($get_tar_courses_count>0) {
             while($pubbed=$get_tar_courses_result->fetch_assoc()) {
                 echo '<a href="/userpgs/instructor/course_management/course.php?course_id='.$pubbed["id"].'"><p style="text-indent: 3.5em"><img src="/images/artwork/dot.png" style="opacity:0.2;width:8x;height:8px;margin-right:4px;"/>'.$pubbed["header"].'</p></a>';
             }
         }
?>
</div>

                                
					  <?php if($get_fxins_prof_edu) { ?><p style="text-indent: 2em"><img src="/images/artwork/dot.png" style="width:8px;height:8px;vertical-align:inherit;margin-right:4px;opacity:0.5;"> <?php echo $get_fxins_prof_edu?></p><?php } ?>
					  <?php if($get_fxins_prof_emp) { ?><p style="text-indent: 2em"><img src="/images/artwork/dot.png" style="width:8px;height:8px;vertical-align:inherit;margin-right:4px;opacity:0.5;"> <?php echo $get_fxins_prof_emp?></p><?php } ?>
					  <?php if($get_fxins_prof_ref) { ?><p style="text-indent: 2em;  color: #5d5d5d;"><img src="/images/artwork/dot.png" style="width:8px;height:8px;vertical-align:inherit;margin-right:4px;opacity:0.5;"> References available upon request.</p> <?php } ?>
					  </div>

					  <div id="editFxIns" style="display: none">
					  <form action="/php/update_ins_prof.php" method="POST">
					  <p style="text-indent: 2em"><img src="/images/artwork/info.png" style="width: 15px; height: 15px;"> <textarea name="info" style="width: 350px; display: inline;" placeholder="Personal statement as fxUniversity instructor"><?php echo $get_fxins_prof_info?></textarea></p>
					  <p style="text-indent: 2em"><img src="/images/artwork/course.png" style="width: 15px; height: 15px;"> Published Courses (<?php echo $get_tar_courses_count ?>)</p>
					  <p style="text-indent: 2em"><img src="/images/artwork/ed.png" style="width: 15px; height: 15px;"> <textarea name="edu" style="width: 350px; display: inline;" placeholder="Educational history"><?php echo  $get_fxins_prof_edu?></textarea></p>
					  <p style="text-indent: 2em"><img src="/images/artwork/employment.png" style="width: 15px; height: 15px;"> <textarea name="emp" style="width: 350px; display: inline;" placeholder="Employment history"><?php echo $get_fxins_prof_emp?></textarea></p>
					  <p style="text-indent: 2em;  color: #5d5d5d;"><img src="/images/artwork/tick.png" style="width: 15px; height: 15px;"> References available upon request. (Show this reference message? <input type="checkbox" name="ref" value="Yes" style="display: inline" <?php if($get_fxins_prof_ref) echo 'checked'?> >) </p>
					  <input type="hidden" name="tarId" value="<?php echo $tar_id?>">
					  <input type="hidden" name="tarName" value="<?php echo $tarname?>">
					  <input type="submit" class="btn" value="Save">
					  </form>
					  </div>
					  
					</div>
					<?php } ?>

<?php if($get_tar_plans_fxuniversitystu) { ?>
    <div class="teamdescription jobfile">
       <p><img src="/images/artwork/briefcase.png" style="width: 15px; height: 15px;opacity:0.5;margin-right:4px;vertical-align:sub;"> <strong>Student</strong> at <strong>fxUnivers</strong></p>
       <p style="text-indent: 2em;cursor: pointer; color: #008bc6;" id="coursesPop"><img src="/images/artwork/dot.png" style="width:8px;height:8px;vertical-align:inherit;margin-right:4px;opacity:0.5;"> Purchased Courses (<?php echo $gts_count ?>)</p>
<div id="takenCourses" style="display:none">
<?php
         if($gts_count>0) {
             while($courses=$gts_result->fetch_assoc()) {
                 $course_query='SELECT * FROM teacher WHERE id='.$courses['course_id'];
                 $course_result=mysqli_query($connection,$course_query) or die(mysqli_error($connection));
                 $course_fetch=mysqli_fetch_array($course_result);
                 echo '<a href="/userpgs/instructor/course_management/course.php?course_id='.$course_fetch["id"].'"><p style="text-indent: 3.5em"><img src="/images/artwork/dot.png" style="opacity:0.2;width:8x;height:8px;margin-right:4px;"/>'.$course_fetch["header"].'</p></a>';
             }
         }
?>
</div>
         
         
       <p style="text-indent: 2em;cursor: pointer; color: #008bc6;" id="passPop"><img src="/images/artwork/dot.png" style="width:8px;height:8px;vertical-align:inherit;margin-right:4px;opacity:0.5;"> Passed Courses (<?php echo $gts_pass_count ?>)</p>

<div id="passedCourses" style="display:none">
<?php
         if($gts_pass_count>0) {
             while($passed=$gts_pass_result->fetch_assoc()) {
                 $pass_query='SELECT * FROM teacher WHERE id='.$passed['course_id'];
                 $pass_result=mysqli_query($connection,$pass_query) or die(mysqli_error($connection));
                 $pass_fetch=mysqli_fetch_array($pass_result);
                 echo '<a href="/userpgs/instructor/course_management/course.php?course_id='.$pass_fetch["id"].'"><p style="text-indent: 3.5em"><img src="/images/artwork/dot.png" style="opacity:0.2;width:8x;height:8px;margin-right:4px;"/>'.$pass_fetch["header"].'</p></a>';
             }
         }
?>
</div>

    </div>
<?php
}
?>
					
					  <p style="color: #403e37"><strong>Timeline</strong></p>
					  <hr class="hrtitle">
					  <?php
					if($sonet_result->num_rows > 0) {
						
						
						$row["uid"] = $sonet_uid; 
					     	
						   
						while($row = $sonet_result->fetch_assoc()) { ?>
						<table>
						
						<col width="10%">
						<col width="90%">
						
						<tr style="border-bottom: 1px solid #25252533">
						<td>
<?php
    $path="../userpgs/avatars/";
    if(file_exists($path.$id.'.jpg')) {
        echo('<div class="avatarpic" style="background-image: url(\'/userpgs/avatars/'.$id.'.jpg\');"></div>');
    } elseif(file_exists($path.$id.'.jpeg')) {
        echo('<div class="avatarpic" style="background-image: url(\'/userpgs/avatars/'.$id.'.jpeg\');"></div>');
    } elseif(file_exists($path.$id.'.png')) {
        echo('<div class="avatarpic" style="background-image: url(\'/userpgs/avatars/'.$id.'.png\');"></div>');
    } elseif(file_exists($path.$id.'.gif')) {
        echo('<div class="avatarpic" style="background-image: url(\'/userpgs/avatars/'.$id.'.jpg\');"></div>');
    } else {
        echo('<div class="avatarpic avatarr"></div>');
    }
?>
						</td>
						<td style="padding-left: 20px;">
							   <?php //require('php/username_retrieve.php');
                                                           	 echo "<a href='/user/$tarname' style='color: #000;'><b>$tar_fname $tar_lname</b> <span style='font-size: 0.9em; color: #696969'>@$tarname</style></a>";?><br/>
							   <p style="font-size: .87rem"><?php echo $row["body"]; ?></p>
						</td>
						</tr><!--
						<col width="10%">
							<col width="90%">
							<tr>
							<td></td>
							<td>
							<a href=""><div class="interaction like_heart"></div></a>
							<a href=""><div class="interaction repost"></div></a>
							<a href=""><div class="interaction comment"></div></a>
							<a href=""><div class="interaction paperplane"></div></a>
							</td>
							</tr>-->
						</table>

							   <?php
						}
					}
					?>
					  
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
function toggleEdit() {
  var oldDiv = document.getElementById('oldFxIns');
  var newDiv = document.getElementById('editFxIns');
  var editButt = document.getElementById('editCancel');
  if(oldDiv.style.display === "block") {
    oldDiv.style.display = "none";
    newDiv.style.display = "block";
    editButt.value= "Cancel";
  } else {
    oldDiv.style.display = "block";
    newDiv.style.display = "none";
    editButt.value= "Edit";
  }
  
  //document.getElementById('editFxIns').style.display="block";
  //document.getElementById('oldFxIns').style.display="none";
}
</script>

<script>
function setFriend() {
    var requesterId=<?php echo $session_id ?>;
    var requesteeId=<?php echo $tar_id ?>;
    var requesterUn='<?php echo $username ?>';
    $.ajax({
      type: 'POST',
      url: '/php/set_friend.php',
            data: {requester: requesterId, requestee: requesteeId, requesterU: requesterUn},
      success: function(result) {
            //var results=jQuery.parseJSON(result);
            if(result==0) {
                document.getElementById('friendSet').innerHTML='Cancel Friend Request';
            } else if(result==1) {
                document.getElementById('friendSet').innerHTML='Friend';
            }
      }
    });
}
</script>

<script>
function setFollow() {
    var requesterId=<?php echo $session_id ?>;
    var requesteeId=<?php echo $tar_id ?>;
    var requesterUn='<?php echo $username ?>';
    $.ajax({
      type: 'POST',
      url: '/php/set_follow.php',
            data: {requester: requesterId, requestee: requesteeId, requesterU: requesterUn},
      success: function(result) {
            //var results=jQuery.parseJSON(result);
            if(result==0) {
                document.getElementById('followSet').innerHTML='Unfollow';
            } else if(result==1) {
                document.getElementById('followSet').innerHTML='Follow';
            }
      }
    });
}
</script>

<script>
function editBio(x) {
    
}
</script>

<!-- BUTTONS -->
<script>
$(document).ready(function() {
    $('#traderBtn').hover(function() {
        var imgUrl='/images/leftsidebar/trader_b.png';
        $('#traderSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='/images/leftsidebar/trader_a.png';
        $('#traderSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#walletBtn').hover(function() {
        var imgUrl='/images/leftsidebar/wallet_b.png';
        $('#walletSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='/images/leftsidebar/wallet_a.png';
        $('#walletSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#instructorBtn').hover(function() {
        var imgUrl='/images/leftsidebar/instructor_b.png';
        $('#instructorSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='/images/leftsidebar/instructor_a.png';
        $('#instructorSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#partnerBtn').hover(function() {
        var imgUrl='/images/leftsidebar/partner_b.png';
        $('#partnerSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='/images/leftsidebar/partner_a.png';
        $('#partnerSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#studentBtn').hover(function() {
        var imgUrl='/images/leftsidebar/student_b.png';
        $('#studentSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='/images/leftsidebar/student_a.png';
        $('#studentSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

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
    $('#ubLogout').hover(function() {
        var imgUrl='/images/upperbar/logout_b.png';
        $('#ubiLogout').attr("src", imgUrl);
    }, function() {
        var imgUrl0='/images/upperbar/logout_a.png';
        $('#ubiLogout').attr("src",imgUrl0);
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
  var notifUserId=<?php echo $session_id ?>;
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

<script>
$('#coursesPop').click(function() {
    $('#takenCourses').toggle();
});
</script>
<script>
$('#passPop').click(function() {
    $('#passedCourses').toggle();
});
</script>
<script>
$('#pubPop').click(function() {
    $('#pubCourses').toggle();
});
</script> 
</body>
</html>