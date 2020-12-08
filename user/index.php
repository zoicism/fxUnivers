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
$tarid=$id;
$bio = $user_fetch['bio'];
$verified = $user_fetch['verified'];


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

require('../php/get_partner_profile.php');

require('../php/get_visibility.php');


require('../php/get_stu_stucourse_profile.php');

require('../php/get_my_accepted_courses_profile.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>fxUser</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/icons.css">
  <link rel="stylesheet" href="/css/logo.css">
  <script src="/js/jquery-3.4.1.min.js"></script>
</head>

<body>
	<div class="header-sidebar"></div>
  <script src="/js/upperbar.js"></script>

  <div class="blur mobile-main">
<div class="sidebar"></div>
	<?php require('../php/sidebar.php'); ?>
  <div class="relative-main-content">
    <div class="profile-container profile-top-mob">
      <div class="profile-top">
        <div class="avatar-profile-container">
          <div class="avatar-profile"></div>
        </div>
        <div class="info-profile">
          <div class="id-profile"><?php echo $tarname ?> <?php if($verified) echo '<img src="/images/background/verified.png" style="width:1.5rem; height:1.5rem;">'; ?></div>
          <a class="follower-profile" id="open-friends">
            <div class="follower-num"><?php echo $get_tar_friends_count ?></div>
            <div class="follower-word">friends</div>
          </a>
          <div class="profile-desktop">
            <div class="name-profile"><?php echo $tar_fname.' '.$tar_lname ?></div>
            <div class="bio-profile"><?php echo $tar_bio ?></div>
            <div class="edit-profile-con">
              <a id="open-edit-profile" class="edit-profile">Edit Profile</a>
            </div>
          </div>
        </div>
      </div>
      <div class="profile-top-mob">
        <div class="info-profile">
          <div class="name-profile"><?php echo $tar_fname.' '.$tar_lname ?></div>
          <div class="bio-profile"><?php echo $tar_bio ?>This is the bio of the mobile view: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua.</div>
          <div class="edit-profile-con">
            <a href="#" class="edit-profile">Edit Profile</a>
          </div>
        </div>
      </div>
      <div class="profile-bottom">
        <ul class="flex-container">
          <li class="items">
            <a href="#" class="link">
              <div class="head">
                fxStar
                <p class="sub"><?php echo $get_fxcoin_count?> fxStars</p>
              </div>
            </a>
          </li>
          <li class="items">
            <a id="open-fxuniversity" class="link">
              <div class="head">
                fxUniversity
                <p class="sub"><?php $total_courses=$$get_tar_courses_count+$gts_count; echo $total_courses?> courses</p>
              </div>
            </a>
          </li>
          <li class="items">
            <a href="#" class="link">
              <div class="head">
                fxPartner
                <p class="sub"><?php $pTotal=0;
                    while($row=$get_partner_result->fetch_assoc()) {
                        $pTotal+=$row['income'];
                  }
		  echo $pTotal; ?> fxStars</p>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-------------------------------- friends overlay starts -------------------------------->

  <div class="frame-container" style="display:none" id="friends-overlay">
    <div class="frame">
      <div class="frame-header">
        <div class="friends-word">Friends</div>
        <a  class="closebtn" id="close-friends-overlay" >×</a>
      </div>
      <ul>


           <?php

	   if($get_tar_friends_count > 0) {
	   
	     while($fnd_row = $get_tar_friends_r -> fetch_assoc()) {
	       if($fnd_row['user1'] == $get_user_id) {
	         $fnd_user_id=$fnd_row['user2'];
	       } else {
	         $fnd_user_id=$fnd_row['user1'];
	       }

	       $fnd_user_query = "SELECT * FROM user WHERE id=$fnd_user_id";
               $fnd_user_result = mysqli_query($connection, $fnd_user_query) or die(mysqli_error($connection));
               $fnd_user_fetch = mysqli_fetch_array($fnd_user_result);


	       echo '<li class="friends">
	               <a class="photo-friends" style="background-image: url(\'/images/background/avatar.svg\');"></a>
		       <div class="desc-contact">
		         <a class="name">'.$fnd_user_fetch['fname'].' '.$fnd_user_fetch['lname'].'</a>
			 <p class="username-friends">@'.$fnd_user_fetch['username'].'</p>
		       </div>
		     </li>';
	     }
	   } else {
	      echo '<p class="gray">No friends yet</p>';
	   }
	   
	   ?>


            
      </ul>
    </div>
  </div>

<!-------------------------------- friends overlay ends -------------------------------->



<!-------------------------------- fxuniversity overlay starts -------------------------------->

  <div class="frame-container" id="fxuniversity-overlay" style="display:none">
<?php
                $stu1_q="SELECT id FROM teacher WHERE user_id=$id";
                $stu1_r=mysqli_query($connection,$stu1_q) or die(mysqli_error($connection));

                $stu_count=0;
                while($row=$stu1_r->fetch_assoc()) {
                    $course_id=$row['id'];
                    $stu2_q="SELECT id FROM stucourse WHERE course_id=$course_id";
                    $stu2_r=mysqli_query($connection,$stu2_q) or die(mysqli_error($connection));
                    $stu_count+=mysqli_num_rows($stu2_r);
                }

                $acc_count=0;
                $stu1_r=mysqli_query($connection,$stu1_q) or die(mysqli_error($connection));
                while($row2=$stu1_r->fetch_assoc()) {
                    $course_id=$row2['id'];
                    $acc_q="SELECT id FROM stucourse WHERE course_id=$course_id AND exam_accepted=1";
                    $acc_r=mysqli_query($connection,$acc_q) or die(mysqli_error($connection));
                    $acc_count+=mysqli_num_rows($acc_r);
                }
?>
    <div class="frame-fxuniversity">
      <div class="frame-header">
        <div class="fxuniversity-word"><?php echo $tarname?>'s fxUniversity</div>
        <a id="close-fxuniversity-overlay" class="closebtn">×</a>
      </div>
      <div class="frame-header-fxuniversity">
        <div class="teach-word active-tab">
          <a id="teach-tab">Teach</a>
        </div>
        <div class="learn-word">
          <a id="learn-tab">Learn</a>
        </div>
      </div>
      <ul id="teach-tab-content">
      <p><strong><?php echo $get_tar_courses_count?></strong> courses</p>
                <p><strong><?php echo $stu_count ?></strong> students</p>
                <p><strong><?php echo $acc_count ?></strong> accepted students</p>






<?php
                require('../php/limit_str.php');
                
                if($get_tar_courses_count>0) {
                    while($row3=$get_tar_courses_result->fetch_assoc()) {
                        $coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$row3['id'];
                        $coursecounter_r=mysqli_query($connection,$coursecounter_q);
                        $coursecounts=mysqli_num_rows($coursecounter_r);

			$descrip=preg_replace("/<br\W*?\/>/"," ",$row3['description']);

			echo '<li class="course-profile" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$row3['id'].'\';">
			        <div class="photo-course-container">
            			    <a class="photo-course" style="background-image: url(\'/images/background/course.png\');opacity:0.5;"></a>
				</div>
				<div class="course-text">
            			    <a class="name"><b>'.$row3['header'].'</b></a>
            			    <p class="desc">';
				    echo limited($descrip,70).'</p>
          			</div>
        		      </li>';


/*
                        echo '<div class="col-1 pointer" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$row3['id'].'\';">';
                        echo '<h3>'.$row3['header'].'</h3>';
                        $descrip=preg_replace("/<br\W*?\/>/"," ",$row3['description']);
                        //$descrip=str_replace(array("\r\n","\r")," ",$row3['description']);
                        echo '<p><strong>'.$coursecounts.'</strong> students</p>';
                        echo '<p>'.limited($descrip,70).'</p>';
                        echo '</div>';
*/
                    }
                    $get_tar_courses_result->free();
                }
?>




      </ul>
      <ul id="learn-tab-content" style="display:none">
  <?php
       echo '<p style="text-align:right"><strong>'.$gss_count.'</strong> courses</p>';
                echo '<p style="text-align:right"><b>'.$gmac_count.'</b> accepted courses</p>';


	if($gss_count>0) {
                    while($taken_row=$gss_result->fetch_assoc()) {
                        $taken_course_id=$taken_row['course_id'];
                        $get_stus_course_query="SELECT * FROM teacher WHERE id=$taken_course_id";
                        $get_stus_course_result=mysqli_query($connection,$get_stus_course_query) or die(mysqli_error($connection));
                        $gsc_fetch=mysqli_fetch_array($get_stus_course_result);
                        $course_link="/userpgs/instructor/course_management/course.php?course_id=".$gsc_fetch['id'];



			$descrip=preg_replace("/<br\W*?\/>/"," ",$row3['description']);

			echo '<li class="course-profile" onclick="location.href=\''.$course_link.'\';">
			        <div class="photo-course-container">
            			    <a class="photo-course" style="background-image: url(\'/images/background/course.png\');opacity:0.5;"></a>
				</div>
				<div class="course-text">
            			    <a class="name"><b>'.$gsc_fetch['header'].'</b></a>
            			    <p class="desc">'.$gsc_fetch['description'].'</p>
          			</div>
        		      </li>';

/*
                        echo '<div class="col-1 pointer" onclick="location.href=\''.$course_link.'\';">';
                        echo '<h3>'.$gsc_fetch['header'].'</h3>';
                        echo '<p>'.$gsc_fetch['description'].'</p>';
                       echo '</div>';
		       */
                    }
                    $gss_result->free();
                }
   ?>
      
      </ul>
    </div>
  </div>

<!-------------------------------- fxuniversity overlay ends -------------------------------->


<!-------------------------------- edit profile overlay starts -------------------------------->

  <div class="frame-container" style="display:none" id="edit-profile-overlay">
    <div class="frame-edit">
      <div class="frame-header">
        <div class="editprofile-word">Edit Profile</div>
        <a class="closebtn" id="close-edit-profile">×</a>
      </div>
      <div class="edit-avatar">
        <div class="avatar-prf-cnt">
          <div class="avatar-profile-container">
            <div class="avatar-profile" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>
          </div>
        </div>
        <div class="edit-profile-text">
          <a class="name"><?php echo $username?></a>
          <a href="#" class="change-profile-photo">change Profile Photo</a>
        </div>
      </div>
      <form action="/php/set_bio.php" method="POST">
      <div class="edit-input-container">
        <div class="edit-firstname">
          <div class="edit-input-text"><div class="first-name-word">First Name</div></div>
          <input name="fname" class="edit-input" type="text" placeholder="First Name" value="<?php echo $fname?>">
        </div>
        <div class="edit-lastname">
          <div class="edit-input-text"><div class="last-name-word">Last Name</div></div>
          <input name="lname" class="edit-input" type="text" placeholder="Last Name" value="<?php echo $lname?>">
        </div>
        <div class="edit-bio">
          <div class="edit-input-text"><div class="bio-word">Bio</div></div>
          <textarea name="bio" class="edit-input-bio" type="text" placeholder="Bio"><?php echo $bio?></textarea>
        </div>
      </div>
      <input type="hidden" name="user_id" value="<?php echo $get_user_id?>">
      <input type="hidden" name="username" value="<?php echo $username?>">
      <input type="submit" class="edit-button" value="Apply Edit">
    </div>
    </form>
  </div>

<!-------------------------------- edit profile overlay ends -------------------------------->





  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script>




  <script>
    $('#page-header').html('fxStar');
    $('#page-header').attr('href','/wallet');
  </script>


<script>
$('#open-friends').click(function() {
  $('#friends-overlay').show();
});
$('#close-friends-overlay').click(function() {
  $('#friends-overlay').hide();
  });
  </script>

<script>
$('#open-fxuniversity').click(function() {
  $('#fxuniversity-overlay').show();
});
$('#close-fxuniversity-overlay').click(function() {
  $('#fxuniversity-overlay').hide();
  });
  </script>


<script>
$('#teach-tab').click(function() {
  $('.teach-word').addClass('active-tab');
  $('.learn-word').removeClass('active-tab');

  $('#teach-tab-content').show();
  $('#learn-tab-content').hide();
});
$('#learn-tab').click(function() {
  $('.teach-word').removeClass('active-tab');
  $('.learn-word').addClass('active-tab');

  $('#teach-tab-content').hide();
  $('#learn-tab-content').show();
});
</script>

<script>
$('#open-edit-profile').click(function() {
  $('#edit-profile-overlay').show();
});
$('#close-edit-profile').click(function() {
  $('#edit-profile-overlay').hide();
});
</script>


</body>
</html>
