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
    $session_id_q="SELECT * FROM user WHERE username='$username'";
    $session_id_r=mysqli_query($connection,$session_id_q) or die(mysqli_error($connection));
    $session_id_fetch=mysqli_fetch_array($session_id_r);
    $session_id=$session_id_fetch['id'];
    $session_avatar=$session_id_fetch['avatar'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
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

//if($get_tar_plans_fxuniversityins)
require('../php/get_tar_courses.php');
//if($get_tar_plans_fxuniversitystu)
require('../php/get_tar_stu.php');

require('../php/get_fxinstructor_profile.php');

require('../php/get_follow_fnd.php');

require('../php/get_partner_profile.php');

require('../php/get_visibility.php');


require('../php/get_stu_stucourse_profile.php');

require('../php/get_my_accepted_courses_profile.php');
$get_user_id=$session_id;

$get_oneonone_q = "SELECT * FROM one_on_one WHERE instructor_id = $tar_id";
$get_oneonone_r = mysqli_query($fxinstructor_connection, $get_oneonone_q);
$get_oneonone = mysqli_num_rows($get_oneonone_r);
if($get_oneonone) {
    $get_oneonone_f = mysqli_fetch_array($get_oneonone_r);
    $oneonone_enrolled_q = "SELECT * FROM stu_oneonone WHERE instructor_id = $tar_id AND student_id = $session_id";
    $oneonone_enrolled_r = mysqli_query($fxinstructor_connection, $oneonone_enrolled_q);
    $oneonone_enrolled = mysqli_num_rows($oneonone_enrolled_r);
    if($oneonone_enrolled) $oneonone_enrolled_f = mysqli_fetch_array($oneonone_enrolled_r);
}
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
	<script src="/js/jquery.form.js"></script>
    </head>

    <body>
	<div class="header-sidebar"></div>
	<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>

	<div class="blur mobile-main">
	    <div class="sidebar"></div>
	    <?php require('../php/sidebar.php'); ?>
	    <div class="relative-main-content">
		<div class="profile-container profile-top-mob">
		    <div class="profile-top">
			<div class="avatar-profile-container">

			    <?php
			    $avatar_path=$_SERVER['DOCUMENT_ROOT'];
			    $avatar_path.='/userpgs/avatars/';
			    $avatar_ex = glob($avatar_path.$tarid.'.*');
			    if(count($avatar_ex) > 0) {
				$avatar_arr = explode('.', $avatar_ex[0]);
				$avatar_extension = end($avatar_arr);

				echo '<div class="avatar-profile" style="background-image:url(\'/userpgs/avatars/'.$tarid.'.'.$avatar_extension.'\');"></div>';
			    } else {
				echo '<div class="avatar-profile"></div>';
			    }
			    ?>
			    


			</div>
			<div class="info-profile">
			    <div class="id-profile"><?php echo $tarname ?> <?php if($verified) echo '<img src="/images/background/verified.png" style="width:1.5rem; height:1.5rem;">'; ?></div>
			    <?php if($tarname != 'fxUniversity') { ?>
			    <a class="follower-profile" id="open-friends">
				<div class="follower-num"><?php echo $get_tar_friends_count ?></div>
				<div class="follower-word">friends</div>
			    </a>
			<?php } ?> 
			    <div class="profile-desktop">
				<div class="name-profile"><?php echo $tar_fname.' '.$tar_lname ?></div>
				<div class="bio-profile"><?php echo $tar_bio ?></div>
				<div class="edit-profile-con">
				    <?php if($session_id==$tarid) { ?>
					<a id="open-edit-profile" class="edit-profile">Edit Profile</a>
				    <?php } else {



					if($get_fnd_count==1 && $get_fnd==0 && $get_fnd_fetch['user1']!=$session_id) {
					    
					    $friend_req_q = "SELECT * FROM notif WHERE from_id=$tarid AND user_id=$session_id AND reason='friendRequest'";
					    $friend_req_r = mysqli_query($connection,$friend_req_q) or die(mysqli_error($connection));
					    $friend_req_f = mysqli_fetch_array($friend_req_r);
					    $fnd_req_notif_id=$friend_req_f['id'];
					    

					    echo '<a class="edit-profile" id="accept-fnd">Accept Friend Request</a>';
					}
					if($tarname != 'fxUniversity') {
					  echo '<a class="edit-profile" id="friendship">';
					
					  if($get_fnd_count==0) {
					    echo 'Add Friend';
					  } else {
					    if($get_fnd==1) {
					      echo 'Unfriend';
					    } else {
					      if($get_fnd_fetch['user1']==$session_id) {
						echo 'Cancel Friend Request';
					      } else {
						echo 'Decline Friend Request';
					      }
					    }
					  }
					echo '</a>';
					
					

					echo '<a class="edit-profile" id="send-msg-btn">Send Message</a>';
					}
			    }
				    ?>
				    
				</div>
			    </div>
			</div>
		    </div>
		    <div class="profile-top-mob">
			<div class="info-profile">
			    <div class="name-profile"><?php echo $tar_fname.' '.$tar_lname ?></div>
			    <div class="bio-profile"><?php echo $tar_bio ?></div>
			    <div class="edit-profile-con">
				<?php if($session_id==$tarid) { ?>
				    <a id="open-edit-profile-mob" class="edit-profile">Edit Profile</a>
				<?php } else {



				    if($get_fnd_count==1 && $get_fnd==0 && $get_fnd_fetch['user1']!=$session_id) {
					
					$friend_req_q = "SELECT * FROM notif WHERE from_id=$tarid AND user_id=$session_id AND reason='friendRequest'";
					$friend_req_r = mysqli_query($connection,$friend_req_q) or die(mysqli_error($connection));
					$friend_req_f = mysqli_fetch_array($friend_req_r);
					$fnd_req_notif_id=$friend_req_f['id'];
					

					echo '<a class="edit-profile" id="accept-fnd-mob">Accept</a>';
				    }
				    if($tarname != 'fxUniversity') {
				    echo '<a class="edit-profile" id="friendship-mob">';
				    
				    if($get_fnd_count==0) {
					echo 'Add Friend';
				    } else {
					if($get_fnd==1) {
					    echo 'Unfriend';
					} else {
					    if($get_fnd_fetch['user1']==$session_id) {
						echo 'Cancel Friend Request';
					    } else {
						echo 'Decline';
					    }
					}
				    }
				    echo '</a>';

				    echo '<a class="edit-profile" id="send-msg-btn-mob">Send Message</a>';
				    }
				}
				?>
				
			    </div>
			</div>
		    </div>
		    <div class="profile-bottom">
			<ul class="flex-container">
			    <li class="items">
				<div class="link">
				    <div class="head">
					fxStar
					<p class="sub"><?php echo $get_fxcoin_count?> fxStars</p>
				    </div>
				</div>
			    </li>
			    <li class="items">
				<a id="open-fxuniversity" class="link">
				    <div class="head">
					fxUniversity
					<p class="sub"><span id="total-courses">0</span> courses</p>
				    </div>
				</a>
			    </li>
			    <li class="items">
				<div class="link">
				    <div class="head">
					fxPartner
					<p class="sub"><?php $pTotal=0;
						       while($row=$get_partner_result->fetch_assoc()) {
							   $pTotal+=$row['income'];
						       }
						       echo $pTotal; ?> fxStars</p>
				    </div>
				</div>
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

			    if($session_id==$tarid) {
				if($fnd_row['user1'] == $get_user_id) {
				    $fnd_user_id=$fnd_row['user2'];
				} else {
				    $fnd_user_id=$fnd_row['user1'];
				}
			    } else {
				if($fnd_row['user1'] == $tarid) {
				    $fnd_user_id=$fnd_row['user2'];
				} else {
				    $fnd_user_id=$fnd_row['user1'];
				}
			    }

			    $fnd_user_query = "SELECT * FROM user WHERE id=$fnd_user_id";
			    $fnd_user_result = mysqli_query($connection, $fnd_user_query) or die(mysqli_error($connection));
			    $fnd_user_fetch = mysqli_fetch_array($fnd_user_result);


			    if($fnd_user_fetch['avatar']!=NULL) {
				$avatar_url='/userpgs/avatars/'.$fnd_user_fetch['avatar'];
			    } else {
				$avatar_url='/images/background/avatar.png';
			    }






			    echo '<li class="friends" onclick="location.href=\'/user/'.$fnd_user_fetch['username'].'\';">
	               <a class="photo-friends" style="background-image: url(\''.$avatar_url.'\');"></a>
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
            $stu1_q="SELECT id FROM teacher WHERE user_id=$id AND alive=1";
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
			<a id="teach-tab">Teach (<?php if($get_tar_courses_count!='') echo $get_tar_courses_count; else echo 0;?>)</a>
		    </div>
		    <div class="learn-word">
			<a id="learn-tab">Learn (<span id="learn-count">0</span>)</a>
		    </div>
		</div>
		<ul id="teach-tab-content">
		    

<?php

if($get_oneonone && $session_id != $tar_id) {
    $oneonone_cost = $get_oneonone_f['fxstars'];
    if($oneonone_cost == 0) {
	$oneonone_cost = '<b>free</b>';
    } else {
	$oneonone_cost = '<b>'.$oneonone_cost.' fxStars</b>';
    }

    echo '<div style="display:flex; flex-flow:column; justify-content:center;align-items:center;">';
    if($oneonone_enrolled) {
	echo '<p>You have enrolled to '.$tarname.'\'s 1-on-1 session.</p>';
	echo '<a href="/userpgs/instructor/class/live/oneonone.php?oooid='.$oneonone_enrolled_f['id'].'"><button class="submit-btn" id="1on1-session">Enter 1-on-1 Session</button></a>';
    } else {
	echo '<p id="enroll-p">Enroll to the one-on-one live session with '.$tarname.' for '.$oneonone_cost.'.</p>';
	echo '<button class="submit-btn" id="1on1-req">Enroll 1-on-1</button>';
    }
    echo '</div>';
}



require('../php/limit_str.php');

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

if($get_tar_courses_count>0) {
    while($row3=$get_tar_courses_result->fetch_assoc()) {
        $coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$row3['id'];
        $coursecounter_r=mysqli_query($connection,$coursecounter_q);
        $coursecounts=mysqli_num_rows($coursecounter_r);

	$descrip=preg_replace("/<br\W*?\/>/"," ",$row3['description']);

	if($row3['video_url']!=null) {
	    $link_text = $row3['video_url'];
	    if(strpos($link_text,'youtube.com') !== false) {			    
		$video_id = get_string_between($link_text,'embed/','" frameborder');
		$video_thumbnail = 'https://img.youtube.com/vi/'.$video_id.'/0.jpg';
	    } elseif(strpos($link_text,'vimeo.com') !== false) {
		$video_id = get_string_between($link_text,'video/','" frameborder');
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
		
		$video_thumbnail = $hash[0]['thumbnail_medium'];
	    }

	} else {
 	    $video_thumbnail = '/images/background/course.svg';
	}

	echo '<li class="course-profile" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$row3['id'].'\';">
			        <div class="photo-course-container">
				
            			    <a class="photo-course" style="background-image: url(\''.$video_thumbnail.'\');"></a>
				</div>
				<div class="course-text">
            			    <a class="name"><b>'.$row3['header'].'</b></a>
            			    <p class="desc">';
	echo limited($descrip,70).'</p>
          			</div>
        		      </li>';


    }
    $get_tar_courses_result->free();
}
?>




		</ul>
		<ul id="learn-tab-content" style="display:none">
  <?php
  if($gss_count>0) {
      $learn_count=0;
      while($taken_row=$gss_result->fetch_assoc()) {
          $taken_course_id=$taken_row['course_id'];
          $get_stus_course_query="SELECT * FROM teacher WHERE id=$taken_course_id AND alive=1";
          $get_stus_course_result=mysqli_query($connection,$get_stus_course_query) or die(mysqli_error($connection));


	  
	  
	  if($get_stus_course_result->num_rows>0) {

	      $learn_count++;
	      
              $gsc_fetch=mysqli_fetch_array($get_stus_course_result);
              $course_link="/userpgs/instructor/course_management/course.php?course_id=".$gsc_fetch['id'];

	      

	      $descrip=preg_replace("/<br\W*?\/>/"," ",$row3['description']);


	      if($gsc_fetch['video_url']!=null) {
		  
                  $link_text = $gsc_fetch['video_url'];
		  if(strpos($link_text,'youtube.com') !== false) {			    
		      $video_id = get_string_between($link_text,'embed/','" frameborder');
		      $video_thumbnail = 'https://img.youtube.com/vi/'.$video_id.'/0.jpg';
		  } elseif(strpos($link_text,'vimeo.com') !== false) {
		      $video_id = get_string_between($link_text,'video/','" frameborder');
		      $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
		      
		      $video_thumbnail = $hash[0]['thumbnail_medium'];
		  }


	      } else {
 		  $video_thumbnail = '/images/background/course.svg';
	      }


	      echo '<li class="course-profile" onclick="location.href=\''.$course_link.'\';">
			        <div class="photo-course-container">

            			    <a class="photo-course" style="background-image: url(\''.$video_thumbnail.'\');"></a>
				</div>
				<div class="course-text">
            			    <a class="name"><b>'.$gsc_fetch['header'].'</b></a>
            			    <p class="desc">'.$gsc_fetch['description'].'</p>
          			</div>
        		      </li>';
	  }



      }
      $gss_result->free();
  }

  $total_courses=$get_tar_courses_count+$learn_count;
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
			    <?php
			    if(count($avatar_ex) > 0) {
				echo '<div class="avatar-profile" style="background-image:url(\'/userpgs/avatars/'.$get_user_id.'.'.$avatar_extension.'\');"></div>';
			    } else {
				echo '<div class="avatar-profile"></div>';
			    }
			    ?>
			</div>
		    </div>	
		    <div class="edit-profile-text">
			<a class="name"><?php echo $username?></a>
			<div class="dropdown">
			    <a onclick="myFunction()" class="change-profile-photo">Change Profile Photo</a>
			    <div id="myDropdown" class="dropdown-content">
				<a id="upload-photo-btn" class="upload-photo">Upload Photo</a>
				<a id="del-photo-btn" class="remove-photo">Remove Current Photo</a>

				<form id="avatar-form" style="display:none" method="POST" action="/php/upload_avatar.php" enctype="multipart/form-data">
				    <input type="file" name="avatar_img" id="avatarFile">
      				    <input type="hidden" name="username" value="<?php echo $username ?>">
    				    <button type="submit" class="taste-rand" style="float: left" id="avatarBtn">Upload</button>
   				</form>


				<form method="POST" style="display:none" id="del-photo-form" action="/php/remove_avatar.php">
				    <input type="hidden" name="userId" value="<?php echo $get_user_id ?>"/>
				    <input type="hidden" name="del-username" value="<?php echo $username?>">
				    <input type="submit">
				</form>    

			    </div>
			</div>
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
	<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>




	<script>
	 $('#page-header').html('fxUnivers');
	 $('#page-header').attr('href','/');
	 $('#learn-count').html('<?php if($learn_count!='') echo $learn_count; else echo 0;?>');
	 $('#total-courses').html('<?php echo $total_courses?>');
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
	 $('#open-edit-profile-mob').click(function() {
	     $('#edit-profile-overlay').show();
	 });
	 $('#close-edit-profile').click(function() {
	     $('#edit-profile-overlay').hide();
	 });
	</script>

	<script>
	 function myFunction() {
	     document.getElementById("myDropdown").classList.toggle("show");
	 }
	 window.onclick = function(event) {
	     if (!event.target.matches('.change-profile-photo')) {
		 var dropdowns = document.getElementsByClassName("dropdown-content");
		 var i;
		 for (i = 0; i < dropdowns.length; i++) {
		     var openDropdown = dropdowns[i];
		     if (openDropdown.classList.contains('show')) {
			 openDropdown.classList.remove('show');
		     }
		 }
	     }
	 }
	</script>

	<script>
	 $('#upload-photo-btn').click(function() {
	     $('#avatarFile').click();
	 });

	 $('#avatarFile').change(function() {
	     $('#avatar-form').submit();
	 });

	 $(function() {
	     $('#avatar-form').ajaxForm(function(response) {
		 if(response==1) {
		     window.location.reload();
		 }
		 
	     });
	 });


	</script>

	<script>
	 $('#del-photo-btn').click(function() {
	     $('#del-photo-form').submit();
	 });
	</script>

	<!-- FRIEND REQUEST -->
	<?php if($fnd_req_notif_id!=null) { ?>
	    <script>
	     $('#accept-fnd').click(function() {

		 var myNotifId = <?php echo $fnd_req_notif_id ?>;
		 
		 
		 jQuery.ajax({
		     type:'POST',
		     url:'/php/acceptFndReq.php',
		     data: {notifId: myNotifId, requesteeUN: '<?php echo $username?>'},
		     success: function(response) {
			 if(response==1) {
			     alert('Friend request accepted.');
			     window.location.reload();
			 } else {
			     alert('Failed to accept friend request. Please try again.');
			 }
		     }
		 });
	     });
	    </script>
	    <script>
	     $('#accept-fnd-mob').click(function() {

		 var myNotifId = <?php echo $fnd_req_notif_id ?>;
		 
		 
		 jQuery.ajax({
		     type:'POST',
		     url:'/php/acceptFndReq.php',
		     data: {notifId: myNotifId, requesteeUN: '<?php echo $username?>'},
		     success: function(response) {
			 if(response==1) {
			     alert('Friend request accepted.');
			     window.location.reload();
			 } else {
			     alert('Failed to accept friend request. Please try again.');
			 }
		     }
		 });
	     });
	    </script>
	<?php } ?>
	<script>
	 $('#friendship').click(function() {
	     var requesterId=<?php echo $session_id ?>;
	     var requesteeId=<?php echo $tar_id ?>;
	     var requesterUn='<?php echo $username ?>';
	     jQuery.ajax({
		 type: 'POST',
		 url: '/php/set_friend.php',
		 data: {requester: requesterId, requestee: requesteeId, requesterU: requesterUn},
		 success: function(result) {
		     //var results=jQuery.parseJSON(result);
		     if(result==0) {
			 document.getElementById('friendship').innerHTML='Cancel Friend Request';
			 window.location.reload();
		     } else if(result==1) {
			 document.getElementById('friendship').innerHTML='Add Friend';
			 window.location.reload();
		     }
		 }
	     });
	 });
	</script>
	<script>
	 $('#friendship-mob').click(function() {
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
			 document.getElementById('friendship-mob').innerHTML='Cancel Request';
			 window.location.reload();
		     } else if(result==1) {
			 document.getElementById('friendship-mob').innerHTML='Add Friend';
			 window.location.reload();
		     }
		 }
	     });
	 });
	</script>

	<script>
	 $('#send-msg-btn').click(function() {
	     
	     var getFnd=0;
	     <?php if($get_fnd!=null) {
		 echo 'getFnd = '.$get_fnd.';';
	     }?>
	     
	     if(getFnd) {
		 window.location.replace('/msg/<?php echo $tarname?>');
	     } else {
		 alert('You can send messages to the friends only.');
	     }
	 });
	</script>
	<script>
	 $('#send-msg-btn-mob').click(function() {
	     var getFnd=0;
	     <?php if($get_fnd!=null) {
		 echo 'getFnd = '.$get_fnd.';';
	     }?>
	     
	     if(getFnd) {
		 window.location.replace('/msg/<?php echo $tarname?>');
	     } else {
		 alert('You can send messages to the friends only.');
	     }
	 });
	</script>

	<script>
	 $('#1on1-req').click(function() {
	     var fxinstructor_un = '<?php echo $tarname ?>';
	     var oneononeCost = '<?php echo $get_oneonone_f["fxstars"] ?>';
	     if(confirm('Please confirm enrolling to a 1-on-1 live session with fxInstructor '+fxinstructor_un+' for '+oneononeCost+' fxStars.')) {
		 $.ajax({
		     url: '/php/set_1on1_req.php',
		     type: 'POST',
		     data: {studentId: '<?php echo $session_id ?>', instructorId: '<?php echo $tar_id ?>'},
		     success: function(response) {
			 if(response == 1) {
			     $('#enroll-p').html('You are enrolled successfully.');
			     $('#1on1-req').html('Enter 1-on-1 Session');
			 } else if(response == 'insuff') {
			     alert('Your fxStars is insufficient to purchase this 1-on-1 session. Please increase your fxStars first and try again.');
			 } else {
			     alert('Failed to enroll. Please try again.');
			 }
		     }
		 });
	     }
	 });
	</script>
    </body>
</html>
