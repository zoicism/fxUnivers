<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
   $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   header("Location: $url");
   exit;
   }*/
session_start();
require($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

require('../../php/get_user.php');
$id = $get_user_id;

require('../php/notif.php');

require('../../php/get_plans.php');

require('../../php/get_rel.php');

require('../../php/get_stu_stucourse.php');

require('../../php/get_my_accepted_courses.php');

require('../../wallet/php/get_fxcoin_count.php');

require('../instructor/php/courses.php');

$get_oneonone_q = "SELECT * FROM stu_oneonone WHERE student_id = $get_user_id";
$get_oneonone_r = mysqli_query($fxinstructor_connection, $get_oneonone_q);
$get_oneonone_count = mysqli_num_rows($get_oneonone_r);

$gss_count_alive = 0;
if($gss_count > 0) {
  while($taken_row=$gss_result->fetch_assoc()) {
    $taken_course_id=$taken_row['course_id'];
    $get_stus_course_query="SELECT * FROM teacher WHERE id=$taken_course_id";
    $get_stus_course_result=mysqli_query($connection,$get_stus_course_query) or die(mysqli_error($connection));
    $gsc_fetch=mysqli_fetch_array($get_stus_course_result);
    if($gsc_fetch['alive'] == 1) {
      $gss_count_alive++;
    }
  }
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
	<div class="header-sidebar"></div>
	<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
	<script>
	 if(screen.width >= 629) {
	     $(document).ready(function() {
		 $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/instructor/" class="link-main"><div class="head">Teach(<?php echo $course_count ?>)</div></a></div><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/student/" id="active-main" class="link-main"><div class="head">Learn(<?php echo $gss_count_alive ?>)</div></a></div></div>');
	     });
	 }
	</script>
	

	<div class="blur mobile-main">
	    
	    <div class="sidebar"></div>
	    <?php require('../../php/sidebar.php'); ?>





	    <div class="relative-main-content">

		<div class="add-box">

		    
		    Search Courses <span><img src="/images/background/magnifier.svg" onclick="location.href='/search?type=course';"></span>

		</div>


		<div class="obj-box">
		    <?php
		    if($get_oneonone_count > 0) {
			echo '
			<hr class="hr-tct" style="width:100%" >
			<h3 style="text-align:left;width:100%;margin-bottom:0;">1-on-1 Sessions</h3>
			';
			while($ooo = $get_oneonone_r -> fetch_assoc()) {

			    $instructor_user_q = "SELECT * FROM user WHERE id = ".$ooo['instructor_id'];
			    $instructor_user_r = mysqli_query($connection, $instructor_user_q);
			    $instructor_user = mysqli_fetch_array($instructor_user_r);
			    

			    $fxstars_q = 'SELECT * FROM fxstars WHERE user_id ='. $instructor_user['id'];
			    $fxstars_r = mysqli_query($wallet_connection, $fxstars_q);
			    $fxstars_f = mysqli_fetch_array($fxstars_r);
			    $fxstars = $fxstars_f['balance'];

			    


			    echo '<div class="object-user" onclick="location.href=\'/userpgs/instructor/class/live/oneonone.php?oooid='.$ooo['id'].'\';">';

			    if($instructor_user['avatar']==NULL) {
				echo '<div class="preview-user">
			       <img src="/images/background/avatar.png">
			     </div>';
			    } else {
				echo '<div class="preview-user">
			          <img src="/userpgs/avatars/'.$instructor_user['avatar'].'">
				</div>';
			    }

			    echo '<div class="details-user">';

			    echo '<p><strong>'.$instructor_user['username'].'</strong></p>';
			    echo '<p>'.$instructor_user['fname'].' '.$instructor_user['lname'].'</p>';

			    echo '<div class="detail-bottom">';

			    if($fxstars>0) {
				echo '<div class="little-box"><span>'.$fxstars.' fxStars</span></div>';
			    } else {
				echo '<div class="little-box"><span>0 fxStars</span></div>';
			    }
			    echo '</div>';
			    
			    echo '</div></div>';


			}
			$get_oneonone_r -> free();

			echo '<hr class="hr-tct" style="width:100%">';
		    }
		    ?>
		    
		    
		    

	         <?php

		 require('../../php/limit_str.php');
		 $gss_count_alive = 0;
		 if($gss_count>0) {


		     function get_string_between($string, $start, $end){
    			 $string = ' ' . $string;
    			 $ini = strpos($string, $start);
    			 if ($ini == 0) return '';
    			 $ini += strlen($start);
    			 $len = strpos($string, $end, $ini) - $ini;
    			 return substr($string, $ini, $len);
		     }


		     while($taken_row=$gss_result->fetch_assoc()) {
			 
			 $taken_course_id=$taken_row['course_id'];
                         $get_stus_course_query="SELECT * FROM teacher WHERE id=$taken_course_id";
                         $get_stus_course_result=mysqli_query($connection,$get_stus_course_query) or die(mysqli_error($connection));
                         $gsc_fetch=mysqli_fetch_array($get_stus_course_result);

			 if($gsc_fetch['alive']==1) {
			     $gss_count_alive++;
                             $course_link="/userpgs/instructor/course_management/course.php?course_id=".$gsc_fetch['id'];



                             $coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$taken_row['course_id'];
                             $coursecounter_r=mysqli_query($connection,$coursecounter_q);
                             $coursecounts=mysqli_num_rows($coursecounter_r);

			     $teacher_un_q = 'SELECT username,verified FROM user WHERE id='.$gsc_fetch['user_id'];
			     $teacher_un_r = mysqli_query($connection,$teacher_un_q);
			     $teacher_un_f = mysqli_fetch_array($teacher_un_r);
			     $teacher_un = $teacher_un_f['username'];
			     $teacher_verified = $teacher_un_f['verified'];
			     
			     echo '<div class="object" onclick="location.href=\''.$course_link.'\';">';



			     $thumb_path = '../instructor/course_management/thumbnails/';
			     $thumb = glob($thumb_path.$gsc_fetch['id'].'.jpg');

			     if(count($thumb)>0) {
			         echo '<div class="preview">
				  <img src="'.$thumb_path.$gsc_fetch['id'].'.jpg">
				</div>';
			     } elseif($gsc_fetch['video_url']!=null) {

				 $link_text = $gsc_fetch['video_url'];
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
				  	<path class="cls-1" d="M659.7,889.3l-1.8-1.1v1.4l-25.4,16a.6.6,0,0,1-.9-.4V895a1.6,1.6,0,0,1,.8-1.4l26.8-16.3a1.1,1.1,0,0,0,.6-1.1h0a1.2,1.2,0,0,0-.7-1l-37.2-18a5.4,5.4,0,0,0-4.8.1l-25.8,13.6a2.2,2.2,0,0,0-1.2,2v12.9a1.1,1.1,0,0,0,.6,1.1L628.5,907a4.5,4.5,0,0,0,4.6-.2l26.6-16.3a.7.7,0,0,0,.4-.6h0A.9.9,0,0,0,659.7,889.3Zm-31,4.8-36.4-19.7a.7.7,0,0,1-.3-1h0a.8.8,0,0,1,1-.3l36.4,19.8a.6.6,0,0,1,.3.9h0A.6.6,0,0,1,628.7,894.1Z" transform="translate(-590.1 -856.7)"></path>
				  </svg>
				</div>';
				 
			     }

			     echo '<div class="details">';
			     $ctitle=preg_replace("/<br\W*?\/>/"," ",$gsc_fetch['header']);
			     
			     echo '<p><strong>'.$ctitle.'</strong></p>';

			     /*
				$descrip=preg_replace("/<br\W*?\/>/"," ",$gsc_fetch['description']);
				echo '<p>';
				echo limited($descrip,85).'</p>';
			      */
			     
			     

			     if($teacher_verified) {
				 echo '<div class="little-box teacher-id">'.$teacher_un.' <img src="/images/background/verified.png" style="width:1rem; height:1rem;"></div>';
			     } else {
				 echo '<div class="little-box teacher-id">'.$teacher_un.'</div>';
			     }
			     
			     echo '<div class="detail-bottom">
			    	   <div class="detail-row">
				    <div class="little-box blue-bg">
			     '.$coursecounts.' <span>students</span>
				    </div>
				    <div class="little-box"><span>'.date("M jS, Y", strtotime($gsc_fetch['start_date'])).'</span></div>
				    </div>';

			     if($gsc_fetch['cost'] > 0) {
				 if($gsc_fetch['negotiable']) {
				     echo '<div style="display:flex; flex-flow:row nowrap;"><div class="price gold-bg" style="width:50%;"><div class="fxstar-white"></div>'.$gsc_fetch['cost'].'</div><div style="width:50%;" class="price medseagreen-bg">Negotiable</div></div>';
				 } else {
				     echo '<div class="price gold-bg"><div class="fxstar-white"></div>'.$gsc_fetch['cost'].'</div>';
				 }
			     } else {
				 echo '<div class="price green-bg" style="padding: 4px 20px;">Free</div>';
			     }

			     /*
			     if($gsc_fetch['biddable']) {
				 require_once('../../wallet/php/wallet_connect.php');
				 $locked_q = 'SELECT * FROM locked WHERE course_id='.$gsc_fetch['id'];
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
				      <span>Base </span> '.$gsc_fetch['cost'].' <span>fxStars</span>
				    </div>';
				 }
		             } else {

				 if($gsc_fetch['cost']>0) {	  
				     echo '<div class="price gold-bg">
				     '.$gsc_fetch['cost'].' <span>fxStars</span>
				    </div>';
				 } else {
			      	     echo '<div class="price green-bg" style="padding: 4px 20px;">
				      Free
				    </div>';
				 }

			     }
			     */


			     

			     echo ' </div>
				  </div>
				  </div>';
			 }
		  	 
		     }     

		 } else {
		     echo '<p class="gray">No courses added yet</p>';
		 }
if($gss_count_live < 1) {
  echo '<p class="gray">No courses added yet.<br>Use <a href="/search?type=course">Search Courses</a> button above to look for your favorite courses.</p>';
}

		 
		 ?>
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


	<!-- fxUniversity sidebar active -->
	<script>
	 $('.fxuniversity-sidebar').attr('id','sidebar-active');
	</script>

	<script>
	 $(document).ready(function() {
	     var class_count = '<?php echo $gss_count_alive ?>';
	     $('#class-count').html(class_count);
	 });
	</script>
    </body>
</html>
