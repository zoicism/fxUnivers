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

require('../php/get_partner_profile.php');

require('../php/get_visibility.php');
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
          <div class="id-profile"><?php echo $tarname ?></div>
          <a class="follower-profile" id="open-friends">
            <div class="follower-num"><?php echo $get_rel_friends_count ?></div>
            <div class="follower-word">friends</div>
          </a>
          <div class="profile-desktop">
            <div class="name-profile"><?php echo $tar_fname.' '.$tar_lname ?></div>
            <div class="bio-profile"><?php echo $tar_bio ?>This is the bio of the mobile view: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua.</div>
            <div class="edit-profile-con">
              <a href="#" class="edit-profile">Edit Profile</a>
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
            <li class="friends">
              <a class="photo-friends" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
                  <div class="desc-contact">
                    <a class="name">Elsie Amador</a>
                    <p class="username-friends">@elsie_amador</p>
                  </div>
            </li>
            <li class="friends">
              <a class="photo-friends" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
                  <div class="desc-contact">
                    <a class="name">Elsie Amador</a>
                    <p class="username-friends">@elsie_amador</p>
                  </div>
            </li>
            <li class="friends">
              <a class="photo-friends" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
                  <div class="desc-contact">
                    <a class="name">Elsie Amador</a>
                    <p class="username-friends">@elsie_amador</p>
                  </div>
            </li>
            <li class="friends">
              <a class="photo-friends" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
                  <div class="desc-contact">
                    <a class="name">Elsie Amador</a>
                    <p class="username-friends">@elsie_amador</p>
                  </div>
            </li>
            <li class="friends">
              <a class="photo-friends" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
                  <div class="desc-contact">
                    <a class="name">Elsie Amador</a>
                    <p class="username-friends">@elsie_amador</p>
                  </div>
            </li>
            <li class="friends">
              <a class="photo-friends" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
                  <div class="desc-contact">
                    <a class="name">Elsie Amador</a>
                    <p class="username-friends">@elsie_amador</p>
                  </div>
            </li>
            <li class="friends">
              <a class="photo-friends" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
                  <div class="desc-contact">
                    <a class="name">Elsie Amador</a>
                    <p class="username-friends">@elsie_amador</p>
                  </div>
            </li>
            <li class="friends">
              <a class="photo-friends" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
                  <div class="desc-contact">
                    <a class="name">Elsie Amador</a>
                    <p class="username-friends">@elsie_amador</p>
                  </div>
            </li>
            <li class="friends">
              <a class="photo-friends" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
                  <div class="desc-contact">
                    <a class="name">Elsie Amador</a>
                    <p class="username-friends">@elsie_amador</p>
                  </div>
            </li>
      </ul>
    </div>
  </div>

<!-------------------------------- friends overlay ends -------------------------------->



<!-------------------------------- fxuniversity overlay starts -------------------------------->

  <div class="frame-container" id="fxuniversity-overlay" style="display:none">
    <div class="frame-fxuniversity">
      <div class="frame-header">
        <div class="fxuniversity-word">zoicism's fxUniversity</div>
        <a id="close-fxuniversity-overlay" class="closebtn">×</a>
      </div>
      <div class="frame-header-fxuniversity">
        <div class="teach-word active">
          <a href="#">Teach</a>
        </div>
        <div class="learn-word">
          <a href="#">Learn</a>
        </div>
      </div>
      <ul>
        <li class="course-profile">
          <div class="photo-course-container">
            <a class="photo-course" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
          </div>
          <div class="course-text">
            <a class="name">Computational neuroscience</a>
            <p class="desc">Computational neuroscience is a branch of neuroscience which employs mathematical models</p>
          </div>
        </li>
        <li class="course-profile">
          <div class="photo-course-container">
            <a class="photo-course" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
          </div>
          <div class="course-text">
            <a class="name">Computational neuroscience</a>
            <p class="desc">Computational neuroscience is a branch of neuroscience which employs mathematical models</p>
          </div>
        </li>
        <li class="course-profile">
          <div class="photo-course-container">
            <a class="photo-course" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
          </div>
          <div class="course-text">
            <a class="name">Computational neuroscience</a>
            <p class="desc">Computational neuroscience is a branch of neuroscience which employs mathematical models</p>
          </div>
        </li>
        <li class="course-profile">
          <div class="photo-course-container">
            <a class="photo-course" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
          </div>
          <div class="course-text">
            <a class="name">Computational neuroscience</a>
            <p class="desc">Computational neuroscience is a branch of neuroscience which employs mathematical models</p>
          </div>
        </li>
        <li class="course-profile">
          <div class="photo-course-container">
            <a class="photo-course" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
          </div>
          <div class="course-text">
            <a class="name">Computational neuroscience</a>
            <p class="desc">Computational neuroscience is a branch of neuroscience which employs mathematical models</p>
          </div>
        </li>
        <li class="course-profile">
          <div class="photo-course-container">
            <a class="photo-course" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
          </div>
          <div class="course-text">
            <a class="name">Computational neuroscience</a>
            <p class="desc">Computational neuroscience is a branch of neuroscience which employs mathematical models</p>
          </div>
        </li>
        <li class="course-profile">
          <div class="photo-course-container">
            <a class="photo-course" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
          </div>
          <div class="course-text">
            <a class="name">Computational neuroscience</a>
            <p class="desc">Computational neuroscience is a branch of neuroscience which employs mathematical models</p>
          </div>
        </li>
        <li class="course-profile">
          <div class="photo-course-container">
            <a class="photo-course" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
          </div>
          <div class="course-text">
            <a class="name">Computational neuroscience</a>
            <p class="desc">Computational neuroscience is a branch of neuroscience which employs mathematical models</p>
          </div>
        </li>
        <li class="course-profile">
          <div class="photo-course-container">
            <a class="photo-course" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
          </div>
          <div class="course-text">
            <a class="name">Computational neuroscience</a>
            <p class="desc">Computational neuroscience is a branch of neuroscience which employs mathematical models</p>
          </div>
        </li>
        <li class="course-profile">
          <div class="photo-course-container">
            <a class="photo-course" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></a>
          </div>
          <div class="course-text">
            <a class="name">Computational neuroscience</a>
            <p class="desc">Computational neuroscience is a branch of neuroscience which employs mathematical models</p>
          </div>
        </li>
      </ul>
    </div>
  </div>

<!-------------------------------- fxuniversity overlay ends -------------------------------->


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
</body>
</html>
