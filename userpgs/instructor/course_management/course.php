<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
   $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   header("Location: $url");
   exit;
   }*/
session_start();
require('../../../register/connect.php');
require_once('../../../php/conn/fxinstructor.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

if(isset($_GET['course_id'])) $course_id = $_GET['course_id'];

$course_query = "SELECT * FROM `teacher` WHERE id=$course_id AND alive=1";
$course_result = mysqli_query($connection, $course_query) or die(mysqli_error($connection));
$course_fetch = mysqli_fetch_array($course_result);

$course_count=mysqli_num_rows($course_result);
if($course_count!=1) {
    header('Location: /error');
}

$user_id = $course_fetch['user_id'];
$get_course_teacher_id = $user_id;
$header = $course_fetch['header'];
$description = $course_fetch['description'];
$video = $course_fetch['video_url'];
$s_date = $course_fetch['start_date'];
$e_date = $course_fetch['exam_date'];
$cost = $course_fetch['cost'];
$test_date = $course_fetch['test_date'];
$course_biddable=$course_fetch['biddable'];
$test_exists = $course_fetch['test_duration'];
$course_subbable = $course_fetch['subbable'];
$course_private = $course_fetch['private'];
$course_negotiable = $course_fetch['negotiable'];
//$totalCost = $cost + ceil(0.1*$cost);

require('../../../php/get_user.php');
$id = $get_user_id;
require('../php/classes.php');
require('../../php/notif.php');

require('../../../php/get_user_type.php');

require('../../../php/get_exam.php');
$get_exam_fetch=mysqli_fetch_array($get_exam_result);

require('../../../php/get_stucourse.php');

require('../../../wallet/php/get_fxcoin_count.php');

$tar_id=$get_course_teacher_id;
require('../../../php/get_tar_id.php');

$course_likes_q = "SELECT * FROM courseLikes WHERE courseId=$course_id";
$course_likes_r = mysqli_query($fxinstructor_connection,$course_likes_q);
$course_likes = mysqli_num_rows($course_likes_r);

$my_like_q = "SELECT * FROM courseLikes WHERE courseId=$course_id AND userId=$get_user_id";
$my_like_r = mysqli_query($fxinstructor_connection,$my_like_q);
$my_like = mysqli_num_rows($my_like_r);

$course_dislikes_q = "SELECT * FROM courseDislikes WHERE courseId=$course_id";
$course_dislikes_r = mysqli_query($fxinstructor_connection,$course_dislikes_q);
$course_dislikes = mysqli_num_rows($course_dislikes_r);

$my_dislike_q = "SELECT * FROM courseDislikes WHERE courseId=$course_id AND userId=$get_user_id";
$my_dislike_r = mysqli_query($fxinstructor_connection,$my_dislike_q);
$my_dislike = mysqli_num_rows($my_dislike_r);

if($course_biddable) require_once('../../../wallet/php/wallet_connect.php');

$subcourse_of_q = "SELECT * FROM subcourses WHERE course_id = $course_id";
$subcourse_of_r = mysqli_query($fxinstructor_connection, $subcourse_of_q);
$subcourse_of_count = mysqli_num_rows($subcourse_of_r);

$subcourses_q = "SELECT * FROM subcourses WHERE sub_of_id = $course_id";
$subcourses_r = mysqli_query($fxinstructor_connection, $subcourses_q);
$subcourses_count = mysqli_num_rows($subcourses_r);

require_once($_SERVER['DOCUMENT_ROOT'].'/php/limit_str.php');

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


$stucourse_query = "SELECT * FROM stucourse WHERE course_id = $course_id";
$stucourse_result = mysqli_query($connection, $stucourse_query);
$stucourse_count = mysqli_num_rows($stucourse_result);

if($course_private && $user_type != 'instructor' && $user_type != 'student') {
    $private_students_q = "SELECT * FROM private WHERE course_id = $course_id AND student_id = $get_user_id";
    $private_students_r = mysqli_query($fxinstructor_connection, $private_students_q);
    if($private_students_r -> num_rows == 0) {
	echo '<!DOCTYPE html>
      <head>
	<title>fxUniversity</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/icons.css">
	<link rel="stylesheet" href="/css/logo.css">
	<script src="/js/jquery-3.4.1.min.js"></script>
      </head>
    
      <body>
         <div style="display:flex; align-items:center; width:100%; height:100%; justify-content:center;flex-flow:column wrap;">
           <p>This course is private and students can enroll by invitation-only.</p>
           <button onclick="window.history.back()" class="submit-btn">Go Back</button>
         </div>
      </body>';
	exit();
    }
}

if($course_negotiable) {
    $bargain_q = "SELECT * FROM bargains WHERE course_id = $course_id ORDER BY fxstars DESC";
    $bargain_r = mysqli_query($fxinstructor_connection, $bargain_q);
    $bargain_count = mysqli_num_rows($bargain_r);
}

?>

<!DOCTYPE html>
<html>
    <head>
	<title>fxUniversity</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/icons.css">
	<link rel="stylesheet" href="/css/logo.css">
	<script src="/js/jquery-3.4.1.min.js"></script>
    </head>
    
    <body>
	<div class="header-sidebar" style="margin-bottom:0;"></div>
	<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
	<script>
	 if(screen.width >= 629) {
	     $(document).ready(function() {
		 $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/instructor/" class="link-main" <?php if($user_type=='instructor') echo 'id="active-main"'; ?>><div class="head">Teach</div></a></div><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/student/" class="link-main" <?php if($user_type!='instructor') echo 'id="active-main"'; ?>><div class="head">Learn</div></a></div></div>');
	     });
	 }
	</script>
	<div class="blur mobile-main">
	    
	    <div class="sidebar"></div>
	    <?php require('../../../php/sidebar.php'); ?>
	    

	    <div class="relative-main-content">

		<div class="course-content">
		    
		    <div class="left-content" style="padding-top:0">

			<div class="course-upperleft" style="display:flex">
			    <!-- VIDEO -->
			    <?php
			    $path='videos/';
			    $file_ex=glob($path.$course_id.'.*');
			    if(count($file_ex)>0) {
				$vid_arr=explode('.', $file_ex[0]);
				$vid_ext=end($vid_arr);
			    ?>
				<div class="video-holder">
				    <!--
					 <video controls>
					 <source src="<?php echo 'videos/'.$course_id.'.'.$vid_ext ?>" type="video/<?php echo $vid_ext?>"> 
					 </video>
				    -->

				    <video controls>
					<source src="<?php echo 'videos/'.$course_id.'.mp4'?>" type="video/mp4">
					<source src="<?php echo 'videos/'.$course_id.'.ogv'?>" type="video/ogg">
					<source src="<?php echo 'videos/'.$course_id.'.webm'?>" type="video/webm">
				    </video>
				</div>

				<!-- Title, description, and info -->
	  <?php
	  } elseif($video!='') {
	      echo '<div class="video-holder">';
              echo $video;
	      echo '</div>';
	  } else {

	  ?>

				    <div class="video-placeholder">
         				<img src="/images/background/novid.svg">
		   			<p>No video</p>	
				    </div>





			    <?php

			    }

			    ?>


			    <div class="bulletin">
				<div class="bulletin-txt-con">
				    <p style="font-weight:bold;text-align:center;font-size:1rem;margin:0;">Bulletin</p>
				    <div class="bulletin-txt">
					<?php
					require_once('../../../php/conn/fxinstructor.php');
					$bulletin_q = "SELECT * FROM bulletin WHERE courseId=$course_id ORDER BY id DESC";
					$bulletin_r = mysqli_query($fxinstructor_connection,$bulletin_q);

					if($bulletin_r->num_rows > 0) {
					    while($bulletin_row = $bulletin_r->fetch_assoc()) {
						$bulletin_date = $bulletin_row['theDate'];
						echo '<p>'.$bulletin_row['body'].'</p>';
						echo '<p style="font-size:0.7rem;text-align:right;" class="gray">'.date("M jS, Y", strtotime($bulletin_date)).'</p>';
						echo '<hr class="hr-tct">';
					    }
					} else {
					    echo '<p class="gray" style="text-align:center">Empty</p>';
					}
					?>

				    </div>

				</div>


				<?php
				$coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$course_id;
				$coursecounter_r=mysqli_query($connection,$coursecounter_q);
				$coursecounts=mysqli_num_rows($coursecounter_r);
				?>
				<div class="course-info-con">
				    <div class="little-box-con">
					<div class="little-box blue-bg">
					    <?php
					    if($coursecounts==0) {
						echo '<span>No students</span>';
					    } else if($coursecounts==1) {
						echo $coursecounts.' <span>student</span>';
					    } else {
						echo $coursecounts.' <span>students</span>';
					    }
					    ?>
					</div>
					<?php echo '<div class="little-box"><span>'.date("M jS, Y", strtotime($s_date)).'</span></div>';?>
				    </div>
				    <div class="detail-bottom">

					


					<?php
					if($cost > 0) {
					    if($course_negotiable) {
						echo '<div style="display:flex; flex-flow:row nowrap;"><div class="price gold-bg" style="width:50%;"><div class="fxstar-white"></div>'.$cost.'</div><div style="width:50%;" class="price medseagreen-bg">Negotiable</div></div>';
					    } else {
						echo '<div class="price gold-bg"><div class="fxstar-white"></div>'.$cost.'</div>';
					    }
					} else {
					    echo '<div class="price green-bg" style="width:100%;">Free</div>';
					}

					/*
					   if($course_biddable) {

					   $locked_q = 'SELECT * FROM locked WHERE course_id='.$course_id;
					   $locked_r = mysqli_query($wallet_connection,$locked_q);
					   $locked_count = mysqli_num_rows($locked_r);

					   if($locked_count>0) {
					   $locked=mysqli_fetch_array($locked_r);
					   if($locked['finalized']) {
					   echo '<div class="price gray-bg">
					   <span>Sold</span> '.$locked['raw_amount'].' <span>fxStars</span>
					   </div>';
					   } else {
					   echo '<div class="price purple-bg">
				           <span>High </span> '.$locked['raw_amount'].' <span>fxStars</span>
					   </div>';
					   }
					   } else {
					   echo '<div class="price purple-bg">
					   <span>Base </span> '.$cost.' <span>fxStars</span>
					   </div>';
					   }

					   } else {
					   if($cost>0) {	  
					   echo '<div class="price gold-bg" style="width:100%;">
					   '.$cost.' <span>fxStars</span>
					   </div>';
					   } else {
			      		   echo '<div class="price green-bg" style="width:100%;">
					   Free
					   </div>';
					   }
					   }*/



					?>
				    </div>
				</div>







			    </div>

			</div>


			<div class="course-des-con">
			    <?php

			    if($tar_user_fetch['avatar']!=NULL) {
				$avatar_url='/userpgs/avatars/'.$tar_user_fetch['avatar'];
			    } else {
				$avatar_url='/images/background/avatar.png';
			    }



 			    echo '<div class="pub-avatar" style="cursor:auto">';
			    
			    echo '<div class="inner-pub-avatar">';	
			    echo '<div class="pub-avatar-cnt">';
	     		    echo '<div class="pub-img avatar" onclick="location.href=\'/user/'.$tar_user_fetch['username'].'\'" style="background-image:url(\''.$avatar_url.'\');cursor:pointer;">';
			    echo '</div>';
			    echo '<div class="pub-name" style="cursor:pointer" onclick="location.href=\'/user/'.$tar_user_fetch['username'].'\'">';


			    if($tar_user_fetch['verified']) {
				echo '<p class="username">'.$tar_user_fetch['username'].' <img src="/images/background/verified.png" style="width:1rem; height:1rem;"></p>';
			    } else {
				echo '<p class="username">'.$tar_user_fetch['username'].'</p>';
			    }

			    echo '<p class="fullname">'.$tar_user_fetch['fname'].' '.$tar_user_fetch['lname'].'</p>';
			    
			    echo '</div>';


			    if($my_like==1) $my_like_word='<span class="blue">▲</span>'; else $my_like_word='▲';
			    if($my_dislike==1) $my_dislike_word='<span class="blue">▼</span>'; else $my_dislike_word='▼';


			    echo '<div class="like-dislike">';
			    
				

			    echo '<span style="cursor:pointer;" id="likeBtn"><span id="like-num">'.$course_likes.'</span> <span id="like-word">'.$my_like_word.'</span></span>';
			    echo '       <span style="cursor:pointer;" id="dislikeBtn"><span id="dislike-word">'.$my_dislike_word.' </span> <span id="dislike-num">'.$course_dislikes.'</span></span>';
				
			    echo '</div>';
			    echo '</div>';
			    echo '</div>';


			    echo '</div>';

			    echo '<div class="course-name-desc">';
			    echo '<h2>'.$header.'</h2>';
			    echo '<p>'.$description.'</p>';


			    if($subcourse_of_count > 0) {
				
				$subcourse_of_f = mysqli_fetch_array($subcourse_of_r);
				$subcourse_of = $subcourse_of_f['sub_of_id'];

				$subcourse_of_course_q = "SELECT * FROM teacher WHERE id = $subcourse_of";
				$subcourse_of_course_r = mysqli_query($connection, $subcourse_of_course_q);
				$subcourse_of_course = mysqli_fetch_array($subcourse_of_course_r);

				$super_user_q = 'SELECT * FROM user WHERE id = '.$subcourse_of_course['user_id'];
				$super_user_r = mysqli_query($connection, $super_user_q);
				$super_user = mysqli_fetch_array($super_user_r);

				$course_counts_q = 'SELECT * FROM stucourse WHERE course_id = '.$subcourse_of_course['id'];
				$course_counts_r = mysqli_query($connection, $course_counts_q);
				$course_counts = mysqli_num_rows($course_counts_r);

				
				echo '<hr class="hr-tct">';
				echo '<h3>fxSuperCourse:</h3>';				
				
				echo '<div class="obj-box" style="margin-top:0; justify-content:left;">';
				echo '<div class="object" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$subcourse_of.'\';">';
				$thumb_path = 'course_management/thumbnails/';
				$thumb = glob($thumb_path.$subcourse_of.'.jpg');

				if(count($thumb)>0) {
				    echo '<div class="preview">
				            <img src="'.$thumb_path.$subcourse_of.'.jpg">
				          </div>';
				} elseif($subcourse_of_course['video_url']!=null) {
				    $link_text = $subcourse_of_course['video_url'];
				    if(strpos($link_text,'youtube.com') !== false) {			    
					$video_id = get_string_between($link_text,'embed/','" frameborder');
					echo '<div class="preview"> <img src="https://img.youtube.com/vi/'.$video_id.'/0.jpg">	</div>';
				    } elseif(strpos($link_text,'vimeo.com') !== false) {
					$video_id = get_string_between($link_text,'video/','" frameborder');
					$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
					
					echo '<div class="preview"> <img src="'.$hash[0]['thumbnail_medium'].'"> </div>';
				    }
				} else {
			            echo '<div class="preview">
				  <svg viewBox="0 0 70 50.8">
				  	<path d="M659.7,889.3l-1.8-1.1v1.4l-25.4,16a.6.6,0,0,1-.9-.4V895a1.6,1.6,0,0,1,.8-1.4l26.8-16.3a1.1,1.1,0,0,0,.6-1.1h0a1.2,1.2,0,0,0-.7-1l-37.2-18a5.4,5.4,0,0,0-4.8.1l-25.8,13.6a2.2,2.2,0,0,0-1.2,2v12.9a1.1,1.1,0,0,0,.6,1.1L628.5,907a4.5,4.5,0,0,0,4.6-.2l26.6-16.3a.7.7,0,0,0,.4-.6h0A.9.9,0,0,0,659.7,889.3Zm-31,4.8-36.4-19.7a.7.7,0,0,1-.3-1h0a.8.8,0,0,1,1-.3l36.4,19.8a.6.6,0,0,1,.3.9h0A.6.6,0,0,1,628.7,894.1Z" transform="translate(-590.1 -856.7)"></path>
				  </svg>
				</div>';
				}

				echo '<div class="details">';

				$ctitle=preg_replace("/<br\W*?\/>/"," ",$subcourse_of_course['header']);
				
				echo '<p><strong>';
				echo limited($ctitle,40).'</strong></p>';
				
				/*$descrip=preg_replace("/<br\W*?\/>/"," ",$subcourse_of_course['description']);
				   echo '<p>';
				   echo limited($descrip,85).'</p>';*/

				if($get_user_verified) {
				    echo '<div class="little-box teacher-id">'.$super_user['username'].' <img src="/images/background/verified.png" style="width:1rem; height:1rem;"></div>';
				} else {
				    echo '<div class="little-box teacher-id">'.$super_user['username'].'</div>';
				}

				
				echo '
			        
			          <div class="detail-bottom">
				  <div class="detail-row">
				    <div class="little-box blue-bg detail">
				'.$course_counts.' <span>students</span></div>
				    
				  <div class="little-box detail"><span>'.date("M jS, Y", strtotime($subcourse_of_course['start_date'])).'</span></div>
				  </div>';


				if($subcourse_of_course['cost'] > 0) {
				    if($subcourse_of_course['negotiable']) {
					echo '<div style="display:flex; flex-flow:row nowrap;"><div class="price gold-bg" style="width:50%;"><div class="fxstar-white"></div>'.$subcourse_of_course['cost'].'</div><div style="width:50%;" class="price medseagreen-bg">Negotiable</div></div>';
				    } else {
					echo '<div class="price gold-bg"><div class="fxstar-white"></div>'.$subcourse_of_course['cost'].'</div>';
				    }
				} else {
				    echo '<div class="price green-bg" style="padding: 4px 20px;">Free</div>';
				}
				/*
				   if($subcourse_of_course['biddable']) {
				   require_once('../../wallet/php/wallet_connect.php');
				   $locked_q = 'SELECT * FROM locked WHERE course_id='.$subcourse_of_course['id'];
				   $locked_r = mysqli_query($wallet_connection,$locked_q);
				   $locked_count = mysqli_num_rows($locked_r);
				   
				   

				   if($locked_count>0) {
				   $locked=mysqli_fetch_array($locked_r);
				   if($locked['finalized']) {
				   echo '<div class="price gray-bg">
				   <span>Sold</span> '.$locked['raw_amount'].' <span>fxStars</span>
				   </div>';
				   } else {
				   echo '<div class="price purple-bg">
				   <span>High </span> '.$locked['raw_amount'].' <span>fxStars</span>
				   </div>';
				   }
				   } else {
				   echo '<div class="price purple-bg">
				   <span>Base </span> '.$subcourse_of_course['cost'].' <span>fxStars</span>
				   </div>';
				   }
				   } else {

				   if($subcourse_of_course['cost']>0) {	  
				   echo '<div class="price gold-bg">
				   '.$subcourse_of_course['cost'].' <span>fxStars</span>
				   </div>';
				   } else {
			      	   echo '<div class="price green-bg" style="padding: 4px 20px;">
				   Free
				   </div>';
				   }

				   }*/

				echo '</div></div></div></div>';
				
			    }

			    if($subcourses_count > 0) {
				echo '<hr class="hr-tct">';
				echo '<h3>fxSubCourses</h3>';
				echo '<div class="obj-box" style="flex-flow: row nowrap; margin-top:0; justify-content:left;overflow-x:auto;">';
				while($subcourse = $subcourses_r -> fetch_assoc()) {
				    $subcourse_q = 'SELECT * FROM teacher WHERE id ='.$subcourse['course_id'];
				    $subcourse_r = mysqli_query($connection, $subcourse_q);
				    $subcourse_f = mysqli_fetch_array($subcourse_r);
				    
				    $sub_user_q = 'SELECT * FROM user WHERE id='.$subcourse_f['user_id'];
				    $sub_user_r = mysqli_query($connection, $sub_user_q);
				    $sub_user = mysqli_fetch_array($sub_user_r);
				    
				    $sub_course_counts_q = 'SELECT * FROM stucourse WHERE course_id = '.$subcourse_f['id'];
				    $sub_course_counts_r = mysqli_query($connection, $sub_course_counts_q);
				    $sub_course_counts = mysqli_num_rows($sub_course_counts_r);
				    
				    
				    echo '<div class="object" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$subcourse_f['id'].'\';">';
				    $thumb_path = 'course_management/thumbnails/';
				    $thumb = glob($thumb_path.$subcourse_f['id'].'.jpg');

				    if(count($thumb)>0) {
					echo '<div class="preview">
				            <img src="'.$thumb_path.$subcourse_f['id'].'.jpg">
				          </div>';
				    } elseif($subcourse_f['video_url']!=null) {
					$link_text = $subcourse_f['video_url'];
					if(strpos($link_text,'youtube.com') !== false) {			    
					    $video_id = get_string_between($link_text,'embed/','" frameborder');
					    echo '<div class="preview"> <img src="https://img.youtube.com/vi/'.$video_id.'/0.jpg">	</div>';
					} elseif(strpos($link_text,'vimeo.com') !== false) {
					    $video_id = get_string_between($link_text,'video/','" frameborder');
					    $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
					    
					    echo '<div class="preview"> <img src="'.$hash[0]['thumbnail_medium'].'"> </div>';
					}
				    } else {
					echo '<div class="preview">
				  <svg viewBox="0 0 70 50.8">
				  	<path d="M659.7,889.3l-1.8-1.1v1.4l-25.4,16a.6.6,0,0,1-.9-.4V895a1.6,1.6,0,0,1,.8-1.4l26.8-16.3a1.1,1.1,0,0,0,.6-1.1h0a1.2,1.2,0,0,0-.7-1l-37.2-18a5.4,5.4,0,0,0-4.8.1l-25.8,13.6a2.2,2.2,0,0,0-1.2,2v12.9a1.1,1.1,0,0,0,.6,1.1L628.5,907a4.5,4.5,0,0,0,4.6-.2l26.6-16.3a.7.7,0,0,0,.4-.6h0A.9.9,0,0,0,659.7,889.3Zm-31,4.8-36.4-19.7a.7.7,0,0,1-.3-1h0a.8.8,0,0,1,1-.3l36.4,19.8a.6.6,0,0,1,.3.9h0A.6.6,0,0,1,628.7,894.1Z" transform="translate(-590.1 -856.7)"></path>
				  </svg>
				</div>';
				    }

				    echo '<div class="details">';

				    $ctitle=preg_replace("/<br\W*?\/>/"," ",$subcourse_f['header']);
				    
				    echo '<p><strong>';
				    echo limited($ctitle,40).'</strong></p>';
				    
				    /*$descrip=preg_replace("/<br\W*?\/>/"," ",$subcourse_f['description']);
				       echo '<p>';
				       echo limited($descrip,85).'</p>';*/

				    if($get_user_verified) {
					echo '<div class="little-box teacher-id">'.$sub_user['username'].' <img src="/images/background/verified.png" style="width:1rem; height:1rem;"></div>';
				    } else {
					echo '<div class="little-box teacher-id">'.$sub_user['username'].'</div>';
				    }

				    
				    echo '
			        
			          <div class="detail-bottom">
				  <div class="detail-row">
				    <div class="little-box blue-bg detail">
				    '.$sub_course_counts.' <span>students</span></div>
				    
				  <div class="little-box detail"><span>'.date("M jS, Y", strtotime($subcourse_f['start_date'])).'</span></div>
				  </div>';


				    if($subcourse_f['cost'] > 0) {
					if($subcourse_f['negotiable']) {
					    echo '<div style="display:flex; flex-flow:row nowrap;"><div class="price gold-bg" style="width:50%;"><div class="fxstar-white"></div>'.$subcourse_f['cost'].'</div><div style="width:50%;" class="price medseagreen-bg">Negotiable</div></div>';
					} else {
					    echo '<div class="price gold-bg"><div class="fxstar-white"></div>'.$subcourse_f['cost'].'</div>';
					}
				    } else {
					echo '<div class="price green-bg" style="padding: 4px 20px;">Free</div>';
				    }
				    
				    /*
				       if($subcourse_f['biddable']) {
				       require_once('../../wallet/php/wallet_connect.php');
				       $locked_q = 'SELECT * FROM locked WHERE course_id='.$subcourse_f['id'];
				       $locked_r = mysqli_query($wallet_connection,$locked_q);
				       $locked_count = mysqli_num_rows($locked_r);
				       
				       

				       if($locked_count>0) {
				       $locked=mysqli_fetch_array($locked_r);
				       if($locked['finalized']) {
				       echo '<div class="price gray-bg">
				       <span>Sold</span> '.$locked['raw_amount'].' <span>fxStars</span>
				       </div>';
				       } else {
				       echo '<div class="price purple-bg">
				       <span>High </span> '.$locked['raw_amount'].' <span>fxStars</span>
				       </div>';
				       }
				       } else {
				       echo '<div class="price purple-bg">
				       <span>Base </span> '.$subcourse_f['cost'].' <span>fxStars</span>
				       </div>';
				       }
				       } else {

				       if($subcourse_f['cost']>0) {	  
				       echo '<div class="price gold-bg">
				       '.$subcourse_f['cost'].' <span>fxStars</span>
				       </div>';
				       } else {
			      	       echo '<div class="price green-bg" style="padding: 4px 20px;">
				       Free
				       </div>';
				       }

				       }*/

				    echo '</div></div></div>';










				    
				}
				echo '</div>';
			    }


			    
			    echo '</div>';
			    ?>
			    





			</div>



			
		    </div>
		    <div class="right-content">
			<?php
			require_once('../../../php/limit_str.php');



			if($user_type=='instructor') {
			    echo '<div class="options">';
			    echo '<div class="add-box" id="live-add-box">Live Classroom</div>';
			    
			    echo '<div class="course-addbox-con">';
			    echo '<div class="start-schedule-con">';
			    
			    
			    echo '<div id="live-div" style="display:none"></div>';

			    echo '<div style="display:none" id="schedule-div">';

			    echo '<div class="start-live-back-con">';
			    echo '<div class="back-icon-cnt" id="schedule-back" isaudio="false">
			    <svg viewBox="0 0 32 32"><path d="M32,16a1.1,1.1,0,0,1-1,1H3.1l4,3.3,2.8,2.4,6.7,5.6a1,1,0,0,1,0,1.5h0a.9.9,0,0,1-1.3,0L8.6,24.2,5.1,21.3.8,17.6a2,2,0,0,1,0-3.2l4.3-3.7L8.6,7.8l6.7-5.6a.9.9,0,0,1,1.3,0h0a1,1,0,0,1,0,1.5L9.9,9.3,7.1,11.7,3.1,15H31A1.1,1.1,0,0,1,32,16Z"></path></svg>
			    </div>';
			    echo '<button id="live-now" class="submit-btn" >Start Live Classroom Now</button>';
			    echo '</div>';

			    echo '<form class="date-time-live-con" id="schedule-form" >
			    <div  class="date-input">
			    <div class="date-txt">Date</div>
			    <input name="theDate" type="date" class="txt-input" id="theDateId" required>
			    </div>
			    <div class="time-input">
			    <div class="time-txt">Time(UTC)</div>
			    <input name="theTime" type="time" class="txt-input" id="theTimeId" required>
			    </div>
			    <input type="hidden" name="courseId" value="'.$course_id.'">
			    <input type="submit" class="submit-btn" value="Schedule">
			    </form>

			    
			    </div>';
			    echo '</div></div>';

			    echo '<div class="add-box-con">';


			    


			    echo '<div class="add-box-mg">';
			    echo '<div class="add-box" onclick="location.href=\'/userpgs/instructor/course_management/edit_course.php?course_id='.$course_id.'\';">
			    <svg viewBox="0 0 32 32">
			    <path d="M16,11.5A4.5,4.5,0,1,1,11.5,16,4.5,4.5,0,0,1,16,11.5m0-2A6.5,6.5,0,1,0,22.5,16,6.5,6.5,0,0,0,16,9.5Z"></path>
			    <path d="M21.5,2h.3a.7.7,0,0,1,.4.6l.4,3.5A3.1,3.1,0,0,0,23.5,8l.5.5a3.1,3.1,0,0,0,1.8.9l3.5.4a.7.7,0,0,1,.6.4.8.8,0,0,
					  1-.1.8l-2.2,2.8a2.6,2.6,0,0,0-.7,1.8.9.9,0,0,1,0,.8,2.6,2.6,0,0,0,.7,1.8L29.8,21a.8.8,0,0,1,.1.8.7.7,0,0,1-.6.4l-3.5.4a3.1,
					  3.1,0,0,0-1.8.9l-.5.5a3.1,3.1,0,0,0-.9,1.8l-.4,3.5a.7.7,0,0,1-.4.6h-.3l-.5-.2-2.8-2.2a2.8,2.8,0,0,0-1.7-.7h-1a2.8,2.8,0,0,
					  0-1.7.7L11,29.8l-.5.2h-.3a.7.7,0,0,1-.4-.6l-.4-3.5A3.1,3.1,0,0,0,8.5,24L8,23.5a3.1,3.1,0,0,0-1.8-.9l-3.5-.4a.7.7,0,0,1-.6-.4.8.8,
					  0,0,1,.1-.8l2.2-2.8A2.5,2.5,0,0,0,5,16.4v-.8a2.5,2.5,0,0,0-.6-1.8L2.2,11a.8.8,0,0,1-.1-.8.7.7,0,0,1,.6-.4l3.5-.4A3.1,3.1,0,0,0,8,
					  8.5L8.5,8a3.1,3.1,0,0,0,.9-1.8l.4-3.5a.7.7,0,0,1,.4-.6h.3l.5.2,2.8,2.2a2.8,2.8,0,0,0,1.7.7h1a2.8,2.8,0,0,0,1.7-.7L21,2.2l.5-.2m-11-2L9.5.2h0A2.7,
					  2.7,0,0,0,7.8,2.5L7.4,6a.8.8,0,0,1-.2.5l-.7.7L6,7.4l-3.5.4A2.7,2.7,0,0,0,.2,9.5h0a2.6,2.6,0,0,0,.4,2.7L2.9,15a1.3,1.3,0,0,1,.1.6V16H3v.4a1.3,1.3,0,0,
					  1-.1.6L.6,19.8a2.6,2.6,0,0,0-.4,2.7h0a2.7,2.7,0,0,0,2.3,1.7l3.5.4.5.2a2.3,2.3,0,0,0,.7.7.8.8,0,0,1,.2.5l.4,3.5a2.7,2.7,0,0,0,1.7,2.3h0l1,.2a2.7,2.7,0,0,
					  0,1.7-.6L15,29.1l.5-.2h1l.5.2,2.8,2.3a2.7,2.7,0,0,0,1.7.6l1-.2h0a2.7,2.7,0,0,0,1.7-2.3l.4-3.5a.8.8,0,0,1,.2-.5,2.3,2.3,0,0,0,.7-.7l.5-.2,3.5-.4a2.7,2.7,
					  0,0,0,2.3-1.7h0a2.6,2.6,0,0,0-.4-2.7L29.1,17a1.4,1.4,0,0,1-.2-.6c.1-.1.1-.2.1-.4h0c0-.2,0-.3-.1-.4a1.4,1.4,0,0,1,.2-.6l2.3-2.8a2.6,2.6,0,0,0,.4-2.7h0a2.7,
					  2.7,0,0,0-2.3-1.7L26,7.4l-.5-.2a2.3,2.3,0,0,0-.7-.7.8.8,0,0,1-.2-.5l-.4-3.5A2.7,2.7,0,0,0,22.5.2h0l-1-.2a2.7,2.7,0,0,0-1.7.6L17,2.9l-.5.2h-1L15,2.9,12.2.6A2.7,2.7,0,0,0,10.5,0Z"></path>
			    </svg>
			    Manage Course


			    </div>';
			    
			    echo '<div class="extra-info-cnt" style="display:none">
			    <p class="extra-info">Add or remove Intro Video to the course, add Bulletin to inform students, or change title, cost, and other settings. </p>
			    </div>
			    </div>';

			    echo '<div class="add-box-mg">';
			    echo '<div class="add-box" onclick="location.href=\'/userpgs/instructor/class/new_class.php?course_id='.$course_id.'\';">
			    <svg viewBox="0 0 32 32">
			    <path d="M16,2A14,14,0,1,1,2,16,14,14,0,0,1,16,2m0-2A16,16,0,1,0,32,16,16,16,0,0,0,16,0Z"></path>
			    <path d="M25.9,16h0a1,1,0,0,1-1,1H17v7.9a1,1,0,0,1-1,1h0a1,1,0,0,1-1-1V17H7.1a1,1,0,0,1-1-1h0a1,1,0,0,1,1-1H15V7.1a1,1,0,0,1,1-1h0a1,1,0,0,1,1,1V15h7.9A1,1,0,0,1,25.9,16Z"></path>
			    </svg>
			    Add Session
			    </div>';
			    echo '<div class="extra-info-cnt" style="display:none">
			    <p class="extra-info">Add sessions to your course which are only available to the enrolled students.</p>
			    </div>
			    </div>';
			    

			    echo '<div class="add-box-mg">';
			    echo '<div class="add-box" id="manageTestId">
			    <svg viewBox="0 0 32 32">
			    <path d="M16,2A14,14,0,1,1,2,16,14,14,0,0,1,16,2m0-2A16,16,0,1,0,32,16,16,16,0,0,0,16,0Z"></path>
			    <path d="M13.4,22.4h0l-.7-.3L7.1,16.5a1.4,1.4,0,0,1,0-1.5,1.4,1.4,0,0,1,1.5,0l4.8,4.9,10-10a1.4,1.4,0,0,1,1.5,0,1.4,1.4,0,0,1,0,1.5L14.2,22.1A1.9,1.9,0,0,1,13.4,22.4Z"></path>
			    </svg>
			    Certificate Exam
			    </div>';
			    echo '<div class="extra-info-cnt" style="display:none">
			    <p class="extra-info">Add or remove questions, determine testing interval and how many of these questions should be asked of the students randomly.</p>
			    </div>
			    </div>';
			    

			    echo '</div>';
			    echo '</div>';
			    
			} elseif($user_type=='student') {

			    echo '<div class="options">';

			    echo '<div class="add-box" id="student-live-add-box" style="display:none;">Live Classroom Now. Click!</div>';

			    echo '<div class="add-box-con">';

			    if($course_subbable) {
				echo '<div class="add-box" id="addSub"><svg viewBox="0 0 32 32">
			    <path d="M16,2A14,14,0,1,1,2,16,14,14,0,0,1,16,2m0-2A16,16,0,1,0,32,16,16,16,0,0,0,16,0Z"></path>
			    <path d="M13.4,22.4h0l-.7-.3L7.1,16.5a1.4,1.4,0,0,1,0-1.5,1.4,1.4,0,0,1,1.5,0l4.8,4.9,10-10a1.4,1.4,0,0,1,1.5,0,1.4,1.4,0,0,1,0,1.5L14.2,22.1A1.9,1.9,0,0,1,13.4,22.4Z"></path>
			    </svg>
			    Create fxSubCourse</div>';
			    }
			    

			    
			    echo '<div class="add-box" id="examId"><svg viewBox="0 0 32 32">
			    <path d="M16,2A14,14,0,1,1,2,16,14,14,0,0,1,16,2m0-2A16,16,0,1,0,32,16,16,16,0,0,0,16,0Z"></path>
			    <path d="M13.4,22.4h0l-.7-.3L7.1,16.5a1.4,1.4,0,0,1,0-1.5,1.4,1.4,0,0,1,1.5,0l4.8,4.9,10-10a1.4,1.4,0,0,1,1.5,0,1.4,1.4,0,0,1,0,1.5L14.2,22.1A1.9,1.9,0,0,1,13.4,22.4Z"></path>
			    </svg>
			    Certificate Exam</div>';
			    if($stucourse_fetch['last_exam']!=null) {
				echo '<div class="add-box" style="cursor:auto"><p>Your Score: '.round($stucourse_fetch['score']*10,1).'</p></div>';
			    } else {
				echo '<div class="add-box" style="cursor:auto"><p>Your Score: Not Taken</p></div>';
			    }
			    echo '<form action="/userpgs/instructor/exam/take_exam.php" id="goToExam" method="POST" style="display:none"><input type="hidden" name="course_id" value="'.$course_id.'"></form>';
			    echo '</div>';
			    echo '</div>';
			} else {
			    
			    echo '<div class="options">';
			    
			    echo '<div class="add-box-con" style="width:100%">';


			    
			    /*
			       if($course_biddable) {


			       
			       $bidding_q="SELECT * FROM locked WHERE course_id=$course_id";
			       $bidding_r=mysqli_query($wallet_connection,$bidding_q);

			       
			       
			       $bidding_finalized=0;
			       if($bidding_r->num_rows > 0) {
			       $bidding=mysqli_fetch_array($bidding_r);
			       if($bidding['finalized']) $bidding_finalized=1;

			       $sold2user_q = 'SELECT * FROM user WHERE id='.$bidding['from_id'];
			       $sold2user_r=mysqli_query($connection,$sold2user_q) or die(mysqli_error($connection));
			       if($sold2user_r) $sold2user=mysqli_fetch_array($sold2user_r);
			       }

			       if($bidding_finalized) {
			       echo '<div class="add-box">
			       <p>Sold to <a href="/user/'.$sold2user['username'].'">@'.$sold2user['username'].'</a> for '.$bidding['raw_amount'].' fxStars</p>
			       </div>';
			       } else {


			       echo '<div>Make an offer: <p>Highest offer: <span id="highest">'.$cost.'</span> fxStars</p>
			       <form id="bidForm">
			       <input type="number" name="amount" class="num-input" id="offer-input" placeholder="Your offer" min="1" required>
			       <p>Total cost: <span id="totalOfferCost">0</span> fxStars</p>
			       <input type="hidden" name="from_id" value="'.$get_user_id.'">
			       <input type="hidden" name="course_id" value="'.$course_id.'">
			       <input type="hidden" name="to_id" value="'.$get_course_teacher_id.'">
			       <input type="hidden" name="initial_bid" value="'.$cost.'">
			       
			       
			       <input type="submit" class="submit-btn" value="Make Offer">
			       </form>
			       </div>';
			       }
			       } else {*/
			    
			    echo '<div class="add-box blue-button"  id="purchbutt">Enroll</div>';

			    if($course_negotiable) {
				$check_prev_bargains_q = "SELECT * FROM bargains WHERE course_id = $course_id AND student_id = $get_user_id";
				$check_prev_bargains_r = mysqli_query($fxinstructor_connection, $check_prev_bargains_q);
				$check_prev_bargains = 0;
				if($check_prev_bargains_r) {
				    $check_prev_bargains = mysqli_num_rows($check_prev_bargains_r);
				    if($check_prev_bargains > 0) {
					$check_prev_bargains_f = mysqli_fetch_array($check_prev_bargains_r);
				    }
				}
				echo '<div class="add-box info-box">';
				echo '<p>If you cannot pay this course in full, you can request to enroll for a reasonable cost. The instructor may or may not approve your suggestion, in which case your fxStars will be returned.</p>';
				if($check_prev_bargains == 0) {
				    echo '<input type="number" class="num-input" name="myBargain" min="0" max="'.($cost-1).'" placeholder="fxStars" id="myBargainId">';
				    echo '<button class="submit-btn" id="applyBargain">Apply</button>';
				} else {
				    echo '<input type="number" class="num-input" name="myBargain" min="0" max="'.($cost-1).'" placeholder="fxStars" value="'.$check_prev_bargains_f['fxstars'].'" id="myBargainId" disabled>';
				    echo '<button class="submit-btn" id="withdrawBargain" bargainId="'.$check_prev_bargains_f['id'].'">Withdraw</button>';
				}
				echo '</div>';
			    }
			    
			    //}
			    echo '</div>';
			    //echo '</div>';
			    echo '</div>';
			    
			}


			echo '<div class="sessions">';
			?>

			<div class="tabs">
			    <div class="tab-student active-tab" id="sessions-tab"><div>Sessions(<?php echo $class_num ?>)</div></div>
			    <div class="tab-student" id="students-tab"><div>Students(<?php echo $coursecounts ?>)</div></div>
			    <?php if($course_negotiable && $user_type == 'instructor') { ?>
				<div class="tab-student" id="bargains-tab"><div id="bargains-count">Bargains(<?php echo $bargain_count ?>)</div></div>
			    <?php } ?>
			</div>

<?php 	  
//echo '<div class="sess-title"><h3>Sessions ('.$class_num.')</h3></div>';
echo '<div class="sess-list">';

if($class_result->num_rows>0) {

    // CHECK SESSIONS WHERE INSTRUCTOR IS LIVE
    $instructor_q = 'SELECT * FROM user WHERE id='.$get_course_teacher_id;
    $instructor_r = mysqli_query($connection,$instructor_q);
    $instructor = mysqli_fetch_array($instructor_r);

    $session_counter=0;
    
    while($row=$class_result->fetch_assoc()) {

	$session_counter++;

        if($user_type=='instructor' || $user_type=='student') {
            $onclickurl="location.href='/userpgs/instructor/class?course_id=".$course_id."&class_id=".$row['id']."'";
        } else {
            // not purchased
            $onclickurl="unpurchased()";
        }
	echo '<div class="session">';
	



	$thumb_path = '../class/thumbnails/';
	$thumb = glob($thumb_path.$row['id'].'.jpg');

	if(count($thumb)>0) {
	    echo '<div class="session-prev" onclick="'.$onclickurl.'">
				  <img src="'.$thumb_path.$row['id'].'.jpg" style="height:100%;width:100%;border-radius:10px;">
				</div>';
	    
	} elseif($row['video'] != null) {
	    $link_text = $row['video'];
	    if(strpos($link_text,'youtube.com') !== false) {			    
		$video_id = get_string_between($link_text,'embed/','" frameborder');
		echo '<div class="session-prev" onclick="'.$onclickurl.'"><img src="https://img.youtube.com/vi/'.$video_id.'/0.jpg"></div>';
	    } elseif(strpos($link_text,'vimeo.com') !== false) {
		$video_id = get_string_between($link_text,'video/','" frameborder');
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
		
		echo '<div class="session-prev" onclick="'.$onclickurl.'"> <img src="'.$hash[0]['thumbnail_medium'].'"> </div>';
	    } else { echo 'shit'; }
	} else {
	    echo ' <div class="session-prev" onclick="'.$onclickurl.'">
			   <svg viewBox="0 0 70 50.8">
				  	<path d="M659.7,889.3l-1.8-1.1v1.4l-25.4,16a.6.6,0,0,1-.9-.4V895a1.6,1.6,0,0,1,.8-1.4l26.8-16.3a1.1,1.1,0,0,0,.6-1.1h0a1.2,1.2,0,0,0-.7-1l-37.2-18a5.4,5.4,0,0,0-4.8.1l-25.8,13.6a2.2,2.2,0,0,0-1.2,2v12.9a1.1,1.1,0,0,0,.6,1.1L628.5,907a4.5,4.5,0,0,0,4.6-.2l26.6-16.3a.7.7,0,0,0,.4-.6h0A.9.9,0,0,0,659.7,889.3Zm-31,4.8-36.4-19.7a.7.7,0,0,1-.3-1h0a.8.8,0,0,1,1-.3l36.4,19.8a.6.6,0,0,1,.3.9h0A.6.6,0,0,1,628.7,894.1Z" transform="translate(-590.1 -856.7)"></path>
				  </svg>
			  </div>';
	    
	}

	echo '<div class="session-desc" onclick="'.$onclickurl.'">';

	if((time()-strtotime($row['dt'].' '.$row['theTime']) < 0)) {
	    echo '<p><strong><span class="gray-bg">'.$session_counter.'</span> '.$row['title'].'</strong> [SCHEDULED]</p>';
	    $liveExists=1;
	    $liveSession=$row['id'];
	} elseif((time()-strtotime($instructor['lastseen']) < 15) && ($instructor['lsPage']=='live/#'.$row['id'])) {
	    
	    echo '<p><strong><span class="gray-bg">'.$session_counter.'</span> '.$row['title'].'</strong> <img src="/images/background/live6.png" style="width:32px" class="blink_me"></p>';
	    $liveExists=1;
	    $liveSession=$row['id'];
	} else {
            echo '<p><strong><span class="gray-bg">'.$session_counter.'</span> '.$row['title'].'</strong></p>'.$row['lastseen'];
	}
        if($row['body']=='') {
            //$descrip='<span class="gray">(No description)</span>';
        } else {
            $descrip=preg_replace("/<br\W*?\/>/", " ", $row['body']);
        }
        echo '<p>';
	echo limited($descrip,70).'</p>';
	
        echo '</div>';

	if($user_type=='instructor') {
	    echo '<div class="session-mng" onclick="location.href=\'/userpgs/instructor/class/edit_class.php?course_id='.$course_id.'&class_id='.$row['id'].'\'"><svg viewBox="0 0 32 32">
				          <path d="M16,11.5A4.5,4.5,0,1,1,11.5,16,4.5,4.5,0,0,1,16,11.5m0-2A6.5,6.5,0,1,0,22.5,16,6.5,6.5,0,0,0,16,9.5Z"></path>
					  <path d="M21.5,2h.3a.7.7,0,0,1,.4.6l.4,3.5A3.1,3.1,0,0,0,23.5,8l.5.5a3.1,3.1,0,0,0,1.8.9l3.5.4a.7.7,0,0,1,.6.4.8.8,0,0,
					  1-.1.8l-2.2,2.8a2.6,2.6,0,0,0-.7,1.8.9.9,0,0,1,0,.8,2.6,2.6,0,0,0,.7,1.8L29.8,21a.8.8,0,0,1,.1.8.7.7,0,0,1-.6.4l-3.5.4a3.1,
					  3.1,0,0,0-1.8.9l-.5.5a3.1,3.1,0,0,0-.9,1.8l-.4,3.5a.7.7,0,0,1-.4.6h-.3l-.5-.2-2.8-2.2a2.8,2.8,0,0,0-1.7-.7h-1a2.8,2.8,0,0,
					  0-1.7.7L11,29.8l-.5.2h-.3a.7.7,0,0,1-.4-.6l-.4-3.5A3.1,3.1,0,0,0,8.5,24L8,23.5a3.1,3.1,0,0,0-1.8-.9l-3.5-.4a.7.7,0,0,1-.6-.4.8.8,
					  0,0,1,.1-.8l2.2-2.8A2.5,2.5,0,0,0,5,16.4v-.8a2.5,2.5,0,0,0-.6-1.8L2.2,11a.8.8,0,0,1-.1-.8.7.7,0,0,1,.6-.4l3.5-.4A3.1,3.1,0,0,0,8,
					  8.5L8.5,8a3.1,3.1,0,0,0,.9-1.8l.4-3.5a.7.7,0,0,1,.4-.6h.3l.5.2,2.8,2.2a2.8,2.8,0,0,0,1.7.7h1a2.8,2.8,0,0,0,1.7-.7L21,2.2l.5-.2m-11-2L9.5.2h0A2.7,
					  2.7,0,0,0,7.8,2.5L7.4,6a.8.8,0,0,1-.2.5l-.7.7L6,7.4l-3.5.4A2.7,2.7,0,0,0,.2,9.5h0a2.6,2.6,0,0,0,.4,2.7L2.9,15a1.3,1.3,0,0,1,.1.6V16H3v.4a1.3,1.3,0,0,
					  1-.1.6L.6,19.8a2.6,2.6,0,0,0-.4,2.7h0a2.7,2.7,0,0,0,2.3,1.7l3.5.4.5.2a2.3,2.3,0,0,0,.7.7.8.8,0,0,1,.2.5l.4,3.5a2.7,2.7,0,0,0,1.7,2.3h0l1,.2a2.7,2.7,0,0,
					  0,1.7-.6L15,29.1l.5-.2h1l.5.2,2.8,2.3a2.7,2.7,0,0,0,1.7.6l1-.2h0a2.7,2.7,0,0,0,1.7-2.3l.4-3.5a.8.8,0,0,1,.2-.5,2.3,2.3,0,0,0,.7-.7l.5-.2,3.5-.4a2.7,2.7,
					  0,0,0,2.3-1.7h0a2.6,2.6,0,0,0-.4-2.7L29.1,17a1.4,1.4,0,0,1-.2-.6c.1-.1.1-.2.1-.4h0c0-.2,0-.3-.1-.4a1.4,1.4,0,0,1,.2-.6l2.3-2.8a2.6,2.6,0,0,0,.4-2.7h0a2.7,
					  2.7,0,0,0-2.3-1.7L26,7.4l-.5-.2a2.3,2.3,0,0,0-.7-.7.8.8,0,0,1-.2-.5l-.4-3.5A2.7,2.7,0,0,0,22.5.2h0l-1-.2a2.7,2.7,0,0,0-1.7.6L17,2.9l-.5.2h-1L15,2.9,12.2.6A2.7,2.7,0,0,0,10.5,0Z"></path>
			              </svg></div>';
	}
	
	
	echo '</div>';
    }
    $class_result->free();
} else {
    echo '<p class="gray" style="text-align:center;">No sessions yet.</p>';
}
?>
			
		    </div>


		    <div class="online-list" id="online-list" style="display:none">
			<?php
			if($stucourse_count > 0) {
			    while($stud_i = $stucourse_result -> fetch_assoc()) {
				$student_user_q = 'SELECT * FROM user WHERE id = '.$stud_i['stu_id'];
				$student_user_r = mysqli_query($connection, $student_user_q);
				$student_user = mysqli_fetch_array($student_user_r);

				if($student_user['avatar'] != NULL) {
				    $avatar_url = '/userpgs/avatars/'.$student_user['avatar'];
				} else {
				    $avatar_url='/images/background/avatar.png';
				}

				echo '
		      <div class="user" onclick="window.location.href = \'/user/'.$student_user['username'].'\';">
                      <div class="user-img avatar" style="background-image:url(\''.$avatar_url.'\');"></div>
    	              <div class="user-name">
	              <p class="fullname">'.$student_user['username'].'</p>
      	              <p>'.$student_user['fname'].' '.$student_user['lname'].' </p>
      		      
		      </div>
		      </div>
			';
			    }
			    $stucourse_result->free();
			} else {
			    echo '<p class="gray" style="text-align:center;">No students yet.</p>';
			}
			?>
		    </div>

		    <?php
		    if($course_negotiable && $user_type == 'instructor') {
			echo '<div class="online-list" id="bargains">';
			if($bargain_count > 0) {
			    while($bargain = $bargain_r -> fetch_assoc()) {
				$bargainer_q = 'SELECT * FROM user WHERE id = '.$bargain['student_id'];
				$bargainer_r = mysqli_query($connection, $bargainer_q);
				$bargainer = mysqli_fetch_array($bargainer_r);

				if($bargainer['avatar'] != NULL) {
				    $avatar_url = '/userpgs/avatars/'.$bargainer['avatar'];
				} else {
				    $avatar_url='/images/background/avatar.png';
				}

				echo '<div style="display:flex; justify-content: space-around; width:100%;flex-flow: row nowrap; align-items:center;border-bottom:1px solid #00000020;" id="bargain'.$bargain['id'].'">';
				
				echo '
		      <div class="user" onclick="window.location.href = \'/user/'.$bargainer['username'].'\';" style="width:25%">
                      <div class="user-img avatar" style="background-image:url(\''.$avatar_url.'\');"></div>
    	              <div class="user-name" >
	              <p class="fullname" style="margin-top:revert">'.$bargainer['username'].'</p>
      	              
      		      
		      </div>
		      </div>
		      ';

				echo '<p style="font-weight:bold">'.$bargain['fxstars'].' fxStars</p>';
				echo '<button class="submit-btn accept-bargain" style="background: #86fab3;" bargainId="'.$bargain['id'].'" id="accept-bargain" studentId="'.$bargain['student_id'].'">Accept</button>';
				echo '<button class="submit-btn reject-bargain" style="background: #faa386;" bargainId="'.$bargain['id'].'" id="reject-bargain" studentId="'.$bargain['student_id'].'">Decline</button>';

				echo '</div>';
			    }
			} else {
			    echo '<p class="gray" style="text-align:center;">No bargains yet.</p>';
			}
			echo '</div>';
		    }
		    ?>



		    
		</div>
	    </div> 
	    
	</div>


	 </div>
	 

	 <div class="footbar blur"></div>
	 <script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>



	 <!-- SCRIPTS -->
	 <script>
	  $('#page-header').html('fxUniversity');
	  $('#page-header').attr('href','/userpgs/fxuniversity');
	 </script>

	 <script>
	  $('#students-tab').click(function() {
	      $('#sessions-tab').removeClass('active-tab');
	      $('#bargains-tab').removeClass('active-tab');
	      $('#students-tab').addClass('active-tab');

	      $('#bargains').hide();
	      $('.sess-list').hide();
	      $('#online-list').show();
	  });
	  $('#sessions-tab').click(function() {	     
	      $('#students-tab').removeClass('active-tab');
	      $('#bargains-tab').removeClass('active-tab');
	      $('#sessions-tab').addClass('active-tab');

	      $('#online-list').hide();
	      $('#bargains').hide();
	      $('.sess-list').show();
	  });
	  $('#bargains-tab').click(function() {
	      $('#sessions-tab').removeClass('active-tab');
	      $('#students-tab').removeClass('active-tab');
	      $('#bargains-tab').addClass('active-tab');
	      
	      $('.sess-list').hide();
	      $('#online-list').hide();
	      $('#bargains').show();
	  });
	 </script>
	 
	 <!-- fxUniversity sidebar active -->
	 <script>
	  $('.fxuniversity-sidebar').attr('id','sidebar-active');
	 </script>

	 <script>
	  if(screen.width < 629) {
	      var vhWidth = $('.video-holder').width();
	      $('.video-holder').height(vhWidth/1.78);
	  }
	 </script>

	 <script>
	  /*
	     $('#bidForm').submit(function(event) {
	     event.preventDefault();

	     jQuery.ajax({
	     url:'/php/course_bid.php',
	     type:'POST',
	     data:$(this).serialize(),
	     success: function(response) {
	     //console.log(response);
	     if(response=='low') {
	     alert('Your offer must be higher than the highest bid.');
	     } else if(response=='initlow') {
	     alert('Your offer must be higher than the reserve declared by the instructor.');
	     } else if(response=='insuff') {
	     alert('You have insufficient fxStars.');
	     } else if(response=='assigned') {
	     alert('Your offer is assigned.');
	     } else if(response=='initassigned') {
	     alert('Your offer is assigned as the first bid.');
	     }
	     }
	     });
	     });*/
	 </script>

	 <script>
	  /*
	     $(document).ready(function() {
	     setInterval(function() {
	     jQuery.ajax({
	     type:'POST',
	     url:'/php/get_hi_bid.php',
	     data:{courseId:<?php echo $course_id?>},
	     success:function(response) {
	     if(response=='no_offer') {
	     $('#highest').text('<?php echo $cost?>');
	     } else {
	     $('#highest').text(response);
	     }
	     }
	     });
	     }, 2000);
	     });*/
	 </script>

	 <script>
	  /*
	     $(document).ready(function() {
	     setInterval(function() {
	     jQuery.ajax({
	     type:'POST',
	     url:'/php/get_hi_bid.php',
	     data:{courseId:<?php echo $course_id?>},
	     success:function(response) {
	     if(response=='no_offer') {
	     $('#highest-ins').text('None');
	     } else {
	     $('#highest-ins').text(response+' fxStars');
	     }
	     }
	     });
	     }, 2000);
	     });*/
	 </script>

	 <script>
	  $('#offer-input').each(function() {

	      var elem=$(this);
	      elem.data('oldVal', elem.val());
	      elem.bind('propertychange change click keyup input paste', function(event) {
		  if(elem.data('oldVal')!=elem.val()) {
		      elem.data('oldVal', elem.val());
		      
		      $('#totalOfferCost').html(Math.ceil(elem.val()*0.1)+parseInt(elem.val()));

		  }
	      });
	  });
	  $('#offer-input').keydown(function (e) {
	      if (e.shiftKey || e.ctrlKey || e.altKey) {
		  e.preventDefault();
	      } else {
		  var key = e.keyCode;
		  if (!((key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57)      || (key >= 96 && key <= 105))) {
		      e.preventDefault();
		  }
	      }
	  });
	 </script>

	 <script>
	  /*
	     $('#acceptBid').click(function() {
	     if(confirm("Confirm accepting the highest bid.")) {
	     
	     jQuery.ajax({
	     url:'/php/accept_bid.php',
	     type:'POST',
	     data:{course_id:<?php echo $course_id?>},
	     success:function(response) {
	     if(response=='transferred') {
	     alert('Course is sold.');
	     window.location.reload();
	     } else if(response=='nooffer') {
	     alert('No offer has been made yet.');
	     } else {
	     alert('Failed to finalize the deal. Please try again.');
	     }
	     }
	     });

	     }
	     
	     });*/
	 </script>


	 <script>
	  $(document).ready(function() {
	      $('#examId').click(function(e) {
		  if('<?php echo $user_type?>'=='student') {
		      jQuery.ajax({
			  url:'/php/exam_exists.php',
			  type:'POST',
			  data:{courseId:<?php echo $course_id?>},
			  dataType:'json',
			  success: function(response) {
			      var wanted_num = response[0];
			      var actual_num = response[1];

			      if(wanted_num==null) {		  
				  alert('Instructor has not added any questions yet.');
			      } else {		  
				  if(actual_num >= wanted_num) {
				      jQuery.ajax({
					  url:'/php/exam_date.php',
					  type:'POST',
					  data:{last_date:'<?php echo $stucourse_fetch["last_exam"]?>'},
					  success: function(report) {
					      console.log(report);
					      if(report>=7) {
						  if(confirm('By starting the quiz for this course you will not be able to retake it for 7 days.')) {
						      window.location.href="/userpgs/student/exam?courseId=<?php echo $course_id?>";
						  }
					      } else {
						  var wait_days = 7-report;
               					  alert('You have taken the quiz '+report+' days ago. You have to wait '+wait_days+' days to be able to retake it.');
					      }
					  }		    
				      });
				  } else {
				      alert('Instructor has not added enough questions yet.');
				  }
			      }
			  }
		      });
		  } else if('<?php echo $user_type?>'=='neither') {
		      alert('You need to purchase the course first.');
		  }
	      });
	  });


	  $(document).ready(function() {
	      var testExists = '<?php echo $test_exists?>';
	      $('#manageTestId').click(function() {
		  //console.log(testExists);
		  if(testExists != '') {
		      window.location.href='/userpgs/instructor/exam/mng_question?courseId=<?php echo $course_id?>';
		  } else {
		      window.location.href='/userpgs/instructor/exam/new_question?courseId=<?php echo $course_id?>';
		  }
	      });  
	  });
	 </script>



	 <!-- COURSE PURCHASE -->
	 <script>
          $(document).ready(function() {
              var courseId=<?php echo $course_id?>;
              var stuId=<?php echo $get_user_id?>;
	      var totalCost = <?php echo $cost?>;

	      
              $('#purchbutt').click(function(e) {
		  if(confirm('Confirm spending '+totalCost+' fxStars to purchase this course.')) {
		      
                      jQuery.ajax({
                          type:'POST',
                          url:'/wallet/php/purchase.php',
                          data: {item:'course', course_id:courseId, stu_id:stuId},
			  //dataType: 'json',
                          success: function(response) {
			      console.log(response);
			      
                              if(response=='success') {
                                  alert('Course purchased successfully.');
                                  window.location.reload();
                              } else if(response=='insuff') {
				  alert('Insufficient fxStars to purchase this course.');
			      } else {
				  alert('Failed to purchase the course. Please try again.');
			      }
                          }
                      });
                  }   
              });
	      
          });
	 </script>

	 <!-- LC -->
	 <script>
	  $('#live-add-box').on('click',function() {
	      $('.add-box-con').hide();
	      $('#schedule-div').show();
	      $(this).hide();
	  });
	  $('#schedule-back').click(function() {
	      $('.add-box-con').show();
	      $('#schedule-div').hide();
	      $('#live-add-box').show();
	  });
	  
	  $('#schedule-form').submit(function(event) {
	      event.preventDefault();
	      jQuery.ajax({
		  url:'/php/set_live_from_course.php',
		  data:$(this).serialize(),
		  type:'POST',
		  success: function(response) {
		      if(response==0) {
			  alert('Failed to create a live session. Please try again.');
		      } else if(response=='in_the_past') {
			  alert('Choose a date and time in the future.');
		      } else {
			  var theTimeVal = $('#theTimeId').val();
			  var theDateVal = $('#theDateId').val();

			  console.log(theTimeVal+theDateVal);

			  $.ajax({
			      url: '/php/set_bulletin.php',
			      type: 'POST',
			      data: {'bulletin-body': 'Live classroom scheduled for <b>'+ theDateVal +'</b> at <b>'+ theTimeVal +' (UTC)</b>',
				     'course-id': '<?php echo $course_id?>',
				     'teacher-id': '<?php echo $get_course_teacher_id?>',
				     'course-header': '<?php echo $header?>' },
			      success: function(bulletinResponse) {
				  console.log(bulletinResponse);

				  window.location.href = '/userpgs/instructor/class/live/?course_id=<?php echo $course_id ?>&class_id='+response;
			      }
			  });
			  
			  
		      }
		  }
	      });
	      
	  });

	  $('#live-now').click(function() {
	      event.preventDefault();
	      jQuery.ajax({
		  url:'/php/set_live_from_course.php',
		  data:{courseId: '<?php echo $course_id?>'},
		  type:'POST',
		  success: function(response) {
		      if(response==0) {
			  alert('Failed to create a live session. Please try again.');
		      } else {
			  window.location.href = '/userpgs/instructor/class/live/?course_id=<?php echo $course_id ?>&class_id='+response;
		      }
		  }
	      });
	      
	  });

	  <?php if($liveExists) { ?>
	  
	  $('#student-live-add-box').show();
	  $('#student-live-add-box').click(function() {
	      var liveSession=<?php echo $liveSession ?>;
	      window.location.href='/userpgs/instructor/class/live/?course_id=<?php echo $course_id ?>&class_id='+liveSession;
	  });
	  <?php } ?>
	  
	 </script>

	 <!-- LIKES/DISLIKE COURSE -->
	 <script>
	  var userType='<?php echo $user_type?>';

	  $('#likeBtn').click(function() {
	      if(userType=='student' || userType=='instructor') {
		  jQuery.ajax({
		      url:'/php/set_course_like.php',
		      type:'POST',
		      data:{userId:'<?php echo $get_user_id?>', courseId:'<?php echo $course_id?>'},
		      success: function(response) {
			  var response = $.trim(response);
			  var likeNum = parseInt($('#like-num').text());
			  var dislikeNum = parseInt($('#dislike-num').text());
			  console.log(likeNum);
			  console.log(response);
			  if(response=='liked') {
			      var newLikeNum = likeNum+1;
			      $('#like-num').text(newLikeNum);
			      $('#like-word').html('<span class="blue">▲</span>');
			  } else if(response=='unliked') {
			      var newLikeNum = likeNum-1;
			      $('#like-num').text(newLikeNum);
			      $('#like-word').html('▲');
			  } else if(response=='undisliked and liked') {
			      var newLikeNum = likeNum+1;
			      $('#like-num').text(newLikeNum);
			      $('#like-word').html('<span class="blue">▲</span>');
			      var newDislikeNum = dislikeNum-1;
			      $('#dislike-num').text(newDislikeNum);
			      $('#dislike-word').html('▼');
			  }
		      }
		  });
	      } else {
		  alert('You need to be a student of this course to vote.');
	      }
	  });
	 </script>
	 <script>
	  var userType='<?php echo $user_type?>';
	  $('#dislikeBtn').click(function() {
	      if(userType=='student' || userType=='instructor') {
		  jQuery.ajax({
		      url:'/php/set_course_dislike.php',
		      type:'POST',
		      data:{userId:'<?php echo $get_user_id?>', courseId:'<?php echo $course_id?>'},
		      success: function(response) {
			  var response = $.trim(response);
			  var dislikeNum = parseInt($('#dislike-num').text());
			  var likeNum = parseInt($('#like-num').text());
			  console.log(dislikeNum);
			  console.log(response);
			  if(response=='disliked') {
			      var newDislikeNum = dislikeNum+1;
			      $('#dislike-num').text(newDislikeNum);
			      $('#dislike-word').html('<span class="blue">▼</span>');
			  } else if(response=='undisliked') {
			      var newDislikeNum = dislikeNum-1;
			      $('#dislike-num').text(newDislikeNum);
			      $('#dislike-word').html('▼');
			  } else if(response=='unliked and disliked') {
			      var newDislikeNum = dislikeNum+1;
			      $('#dislike-num').text(newDislikeNum);
			      $('#dislike-word').html('<span class="blue">▼</span>');
			      var newLikeNum = likeNum-1;
			      $('#like-num').text(newLikeNum);
			      $('#like-word').html('▲');
			  }
		      }
		  });
	      } else {
		  alert('You need to be a student of this course to vote.');
	      }
	  });
	 </script>

	 <script>
	  var lastExam = "<?php echo $stucourse_fetch['last_exam']; ?>";

	  $('#addSub').click(function() {
	      if(lastExam=='') {
		  alert('You need to take and pass the Certification Exam first.');
	      } else if(lastExam < 5) {
		  alert('You need to pass the Certification Exam by scoring more than 5.');
	      } else {
		  window.location.href = '/userpgs/instructor/course_management/new_course.php?sub=<?php echo $course_id ?>';
	      }
	  });
	 </script>

	 <!-- BARGAINING -->
	 <?php if($user_type=='instructor') { ?>
	     <script>
	      $('.accept-bargain').click(function() {
		  var bargain_id = $(this).attr('bargainId');
		  var student_id = $(this).attr('studentId');
		  var course_id = '<?php echo $course_id ?>';
		  var bargains_count = '<?php echo $bargain_count ?>';
		  
		  $.ajax({
		      url: '/wallet/php/accept_course_bargain.php',
		      type: 'POST',
		      data: {courseId: course_id, bargainId: bargain_id, stuId: student_id, item: 'course'},
		      success: function(response) {
			  console.log(response);
			  if(response == 1) {
			      var newBargainsCount = bargains_count - 1;
			      $('#bargain'+bargain_id).remove();
			      $('#bargains-count').html('Bargains('+newBargainsCount+')');
			  } else {
			      alert('Failed to accept. Please try again.');
			  }
		      }
		  });
	      });
	     </script>
	     <script>
	      $('.reject-bargain').click(function() {
		  var bargain_id = $(this).attr('bargainId');
		  var student_id = $(this).attr('studentId');
		  var course_id = '<?php echo $course_id ?>';
		  var bargains_count = '<?php echo $bargain_count ?>';
		  
		  $.ajax({
		      url: '/wallet/php/reject_course_bargain.php',
		      type: 'POST',
		      data: {courseId: course_id, bargainId: bargain_id, stuId: student_id, item: 'course'},
		      success: function(response) {
			  console.log(response);
			  if(response == 1) {
			      var newBargainsCount = bargains_count - 1;
			      $('#bargain'+bargain_id).remove();
			      $('#bargains-count').html('Bargains('+newBargainsCount+')');
			  } else {
			      alert('Failed to accept. Please try again.');
			  }
		      }
		  });
	      });
	     </script>
	 <?php } else { ?>

	     <script>
	      $('#applyBargain').click(function() {
		  var myBargain = $('#myBargainId').val();
		  var courseId = '<?php echo $course_id ?>';
		  var studentId = '<?php echo $get_user_id ?>';
		  var realCost = '<?php echo $cost ?>';

		  $.ajax({
		      url: '/php/set_bargain.php',
		      type: 'POST',
		      data: {my_bargain: myBargain, course_id: courseId, student_id: studentId, real_cost: realCost},
		      success: function(response) {
			  if(response == 1) {
			      alert('Your request is sent. We will let you know when the instructor accepts or rejects your offer.');
			      window.location.reload();
			  } else if(response == 'insuff') {
			      alert('You have insufficient fxStars.');
			  } else if(response == 'more_than_real_cost') {
			      alert('Your request must be less than the original cost of the course.');
			  } else if(response == 'invalid') {
			      alert('Please enter a valid number of fxStars.');
			  } else {
			      alert('Failed to apply the request. Please try again.');
			  }
		      }
		  });
	      });
	     </script>

	     <script>
	      $('#withdrawBargain').click(function() {
		  var bargain_id = $(this).attr('bargainId');
		  var student_id = '<?php echo $get_user_id ?>';
		  var course_id = '<?php echo $course_id ?>';
		  var user_type = '<?php echo $user_type ?>';
		  
		  $.ajax({
		      url: '/wallet/php/reject_course_bargain.php',
		      type: 'POST',
		      data: {courseId: course_id, bargainId: bargain_id, stuId: student_id, item: 'course', user_type: userType},
		      success: function(response) {
			  console.log(response);
			  if(response == 1) {
			      alert('Request is widthdrawn and your fxStars are returned.');
			      window.location.reload();
			  } else {
			      alert('Failed to withdraw the request. Please try again.');
			  }
		      }
		  });
	      });
	     </script>

	     
	 <?php } ?>

	 <script>
	  function unpurchased() {
	      alert('You must enroll to the course first.');
	  }
	 </script>

	 <script>
	  $('.add-box-mg').hover(function() {
	      $(this).find('.extra-info-cnt').css('width',$(this).css('width')).show();
	  }, function() {
	      $(this).find('.extra-info-cnt').hide();
	  });
	 </script>
    </body>
</html>
