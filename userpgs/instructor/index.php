<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
   $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   header("Location: $url");
   exit;
   }*/
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}



require('../../php/get_user.php');
$id = $get_user_id;
require('php/courses.php');
require('../php/notif.php');

require('../../php/get_plans.php');

require('../../php/get_rel.php');

require('../../wallet/php/get_fxcoin_count.php');

require('../../php/get_stu_stucourse.php');

$get_oneonone_q = "SELECT * FROM one_on_one WHERE instructor_id = $get_user_id";
$get_oneonone_r = mysqli_query($fxinstructor_connection, $get_oneonone_q);
$get_oneonone = mysqli_num_rows($get_oneonone_r);
if($get_oneonone) $get_oneonone_f = mysqli_fetch_array($get_oneonone_r);

$get_oneonone_q = "SELECT * FROM stu_oneonone WHERE instructor_id = $get_user_id";
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
		 $('.header-sidebar').prepend('<div style="width:100%; display:flex; flex-flow:row nowrap; justify-content:left;"><a href="/userpgs/instructor/" class="link-main" id="active-main"><div class="head">Teach (<?php echo $course_count ?>)</div></a><a href="/userpgs/student/" class="link-main"><div class="head">Learn (<?php echo $gss_count_alive ?>)</div></a></div>');
	     });
	 }
	</script>
	<div class="blur mobile-main">
	    
	    <div class="sidebar"></div>
	    <?php require('../../php/sidebar.php'); ?>



	    <div class="relative-main-content">
		<div class="inner-content-box"><div class="options" >
		    <p>Create courses about your favorite topics and make fxStars as more and more students enroll to it.</p>
		    <div class="add-allow-cnt">
			    <div class="add-box blue-button" onclick="location.href='/userpgs/instructor/course_management/new_course.php';">
				Add New Course
			    </div>

			    
			    <div class="add-box">
				<label class="checkbox switch">Allow 1-on-1 Live Request
				    <input type="checkbox" name="one-on-one" value="1on1" <?php if($get_oneonone) echo 'checked' ?>>
				    <span class="checkmark"></span>
				</label>
			    </div>
			    
			    <!--<div class="add-box">
				<h3 style="padding-right:10px">Allow 1-on-1 Live Request</h3>
				<label class="switch" >
				    <input type="checkbox" name="one-on-one" id="1on1" <?php if($get_oneonone) echo 'checked' ?>>
				    <div class="slider round"></div>
				</label>
			    </div>-->
			    
			    <div class="add-box" <?php if(!$get_oneonone) echo 'display:none;' ?>" id="1on1-cost">
				<input type="number" class="num-input" id="1on1-cost-input" placeholder="Cost (fxStars)" <?php if($get_oneonone) echo 'value="'.$get_oneonone_f['fxstars'].'"'; ?> min="0" required>
				<button class="submit-btn" id="1on1-cost-btn">Apply Cost</button>
			    </div>
		    </div>
		    <p>Can a user ask for a one-on-one live session between you and them? Determine the price for requesting such sessions and we will connect you to the students.</p>
		</div>
		</div>

		
		<div class="obj-box">


		    
		    <?php
		    if($get_oneonone_count > 0) {
			echo '
			<hr class="hr-tct" style="width:100%" >
			<h3 style="text-align:left;width:100%;margin-bottom:0;">1-on-1 Sessions</h3>
			';
			while($ooo = $get_oneonone_r -> fetch_assoc()) {

			    $student_user_q = "SELECT * FROM user WHERE id = ".$ooo['student_id'];
			    $student_user_r = mysqli_query($connection, $student_user_q);
			    $student_user = mysqli_fetch_array($student_user_r);
			    

			    $fxstars_q = 'SELECT * FROM fxstars WHERE user_id ='. $student_user['id'];
			    $fxstars_r = mysqli_query($wallet_connection, $fxstars_q);
			    $fxstars_f = mysqli_fetch_array($fxstars_r);
			    $fxstars = $fxstars_f['balance'];

			    


			    echo '<div class="object-user" onclick="location.href=\'/userpgs/instructor/class/live/oneonone.php?oooid='.$ooo['id'].'\';">';

			    if($student_user['avatar']==NULL) {
				echo '<div class="preview-user">
			       <img src="/images/background/avatar.png">
			     </div>';
			    } else {
				echo '<div class="preview-user">
			          <img src="/userpgs/avatars/'.$student_user['avatar'].'">
				</div>';
			    }

			    echo '<div class="details-user">';

			    echo '<p><strong>'.$student_user['username'].'</strong></p>';
			    echo '<p>'.$student_user['fname'].' '.$student_user['lname'].'</p>';

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

		 if($course_count>0) {

		     function get_string_between($string, $start, $end){
    			 $string = ' ' . $string;
    			 $ini = strpos($string, $start);
    			 if ($ini == 0) return '';
    			 $ini += strlen($start);
    			 $len = strpos($string, $end, $ini) - $ini;
    			 return substr($string, $ini, $len);
		     }

		     while($row3=$course_result->fetch_assoc()) {
                         $coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$row3['id'];
                         $coursecounter_r=mysqli_query($connection,$coursecounter_q);
                         $coursecounts=mysqli_num_rows($coursecounter_r);

			 echo '<div class="object" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$row3['id'].'\';">';



			 $thumb_path = 'course_management/thumbnails/';
			 $thumb = glob($thumb_path.$row3['id'].'.jpg');
			 
			 if(count($thumb)>0) {
			     echo '<div class="preview">
				  <img src="'.$thumb_path.$row3['id'].'.jpg">
				</div>';
			     
			 } elseif($row3['video_url']!=null) {
			     $link_text = $row3['video_url'];
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

			 $ctitle=preg_replace("/<br\W*?\/>/"," ",$row3['header']);
			 
			 echo '<p><strong>'.$ctitle.'</strong></p>';
			 
			 /*$descrip=preg_replace("/<br\W*?\/>/"," ",$row3['description']);
			    echo '<p>';
			    echo limited($descrip,85).'</p>';*/

			 if($get_user_verified) {
			     echo '<div class="little-box teacher-id">'.$username.' <img src="/images/background/verified.png" style="width:1rem; height:1rem;"></div>';
			 } else {
			     echo '<div class="little-box teacher-id">'.$username.'</div>';
			 }

			 
			 echo '
			        
			          <div class="detail-bottom">
				  <div class="detail-row">
				    <div class="little-box blue-bg detail">
			 '.$coursecounts.' <span>students</span></div>
				    
				  <div class="little-box detail"><span>'.date("M jS, Y", strtotime($row3['start_date'])).'</span></div>
				  </div>';

			 if($row3['cost'] > 0) {
			     if($row3['negotiable']) {
				 echo '<div style="display:flex; flex-flow:row nowrap;"><div class="price gold-bg" style="width:50%;"><div class="fxstar-white"></div>'.$row3['cost'].'</div><div style="width:50%;" class="price medseagreen-bg">Negotiable</div></div>';
			     } else {
				 echo '<div class="price gold-bg"><div class="fxstar-white"></div>'.$row3['cost'].'</div>';
			     }
			 } else {
			     echo '<div class="price green-bg" style="padding: 4px 20px;">Free</div>';
			 }

			 /*
		            if($row3['biddable']) {
			    require_once('../../wallet/php/wallet_connect.php');
			    $locked_q = 'SELECT * FROM locked WHERE course_id='.$row3['id'];
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
			    <span>Base </span> '.$row3['cost'].' <span>fxStars</span>
			    </div>';
		            }
		            } else {

			    if($row3['cost']>0) {	  
			    echo '<div class="price gold-bg">
			    '.$row3['cost'].' <span>fxStars</span>
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
		     
		     

		 } else {
		     echo '<p class="gray">No courses added yet</p>';
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
	 $('#1on1').change(function() {
	     if(this.checked) {
		 $.ajax({
		     url: '/php/set_one_on_one.php',
		     type: 'POST',
		     data: {instructorId: '<?php echo $get_user_id ?>', addOrRemove: 1},
		     success: function(response) {
			 $('#1on1-cost').show();
			 $('#1on1-cost-input').val('');
			 $('#1on1-cost-input').focus();
		     }
		 });
	     } else {
		 $.ajax({
		     url: '/php/set_one_on_one.php',
		     type: 'POST',
		     data: {instructorId: '<?php echo $get_user_id ?>', addOrRemove: 0},
		     success: function(response) {
			 $('#1on1-cost').hide();
		     }
		 });
		 
	     }
	 });
	</script>
	<script>
	 $('#1on1-cost-btn').click(function() {
	     var OneOnOnePrice = $('#1on1-cost-input').val();
	     if(OneOnOnePrice != '') {
		 $.ajax({
		     url: '/php/set_oneonone_fxstars.php',
		     type: 'POST',
		     data: {instructorId: '<?php echo $get_user_id ?>', fxstars: OneOnOnePrice},
		     success: function(response) {
			 console.log(response);
			 if(response == 1) {
			     alert('One-on-one live session cost is applied.');
			 } else if(response == 0) {
			     alert('Please enter a valid number of fxStars as the cost of your one-on-one live session requests.');
			 } else {
			     alert('Failed to apply the cost. Please try again.');
			 }
		     }
		 });
	     } else {
		 alert('Please enter a valid number of fxStars as the cost of your one-on-one live session requests.');
	     }
	 });
	</script>
    </body>
</html>
