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

require('../../php/get_user.php');
$id = $get_user_id;

require('../php/notif.php');

require('../../php/get_plans.php');

require('../../php/get_rel.php');

require('../../php/get_stu_stucourse.php');

require('../../php/get_my_accepted_courses.php');

require('../../wallet/php/get_fxcoin_count.php');
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

<div class="blur mobile-main">
    
	<div class="sidebar"></div>
	<?php require('../../php/sidebar.php'); ?>







                          
    <div class="main-content">

              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/userpgs/instructor" class="link-main">
                          <div class="head">Teach</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/userpgs/student" class="link-main" id="active-main">
                          <div class="head">Learn</div>
                      </a>
                  </li>
                  
              </ul>

    </div>





    <div class="relative-main-content">

		<div class="add-box">

		 
		   Search Courses <span><img src="/images/background/magnifier.svg" onclick="location.href='/search?type=course';"></span>

		</div>


		<div class="obj-box">
			      

	         <?php

		 require('../../php/limit_str.php');

		 if($gss_count>0) {
		 	while($taken_row=$gss_result->fetch_assoc()) {
			
			$taken_course_id=$taken_row['course_id'];
                        $get_stus_course_query="SELECT * FROM teacher WHERE id=$taken_course_id";
                        $get_stus_course_result=mysqli_query($connection,$get_stus_course_query) or die(mysqli_error($connection));
                        $gsc_fetch=mysqli_fetch_array($get_stus_course_result);
                        $course_link="/userpgs/instructor/course_management/course.php?course_id=".$gsc_fetch['id'];



                            $coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$taken_row['course_id'];
                            $coursecounter_r=mysqli_query($connection,$coursecounter_q);
                            $coursecounts=mysqli_num_rows($coursecounter_r);
			    
			    echo '<div class="object" onclick="location.href=\''.$course_link.'\';">';

			    echo '<div class="preview">
				  <img src="/images/background/course.svg">
				</div>
				<div class="details">';

			    $ctitle=preg_replace("/<br\W*?\/>/"," ",$gsc_fetch['header']);
			    
			    echo '<p><strong>';
			    echo limited($ctitle,40).'</strong></p>';
			    
			    $descrip=preg_replace("/<br\W*?\/>/"," ",$gsc_fetch['description']);
			    echo '<p>';
			    echo limited($descrip,85).'</p>';

			    
			    echo '<div class="detail-bottom">
				    <div class="little-box blue-bg">
				      '.$coursecounts.' <span>students</span>
				    </div>';
				    

if($gsc_fetch['biddable']) {
			     require_once('../../wallet/php/wallet_connect.php');
			     $locked_q = 'SELECT * FROM locked WHERE course_id='.$gsc_fetch['id'];
			     $locked_r = mysqli_query($wallet_connection,$locked_q);
			     $locked_count = mysqli_num_rows($locked_r);
			     
			     

			     if($locked_count>0) {
			       $locked=mysqli_fetch_array($locked_r);
			       if($locked['finalized']) {
			         echo '<div class="little-box gold-bg">
				      <span>Sold</span> '.$locked['raw_amount'].' <span>fxStars</span>
				    </div>';
		               } else {
			         echo '<div class="little-box chocolate-bg">
				      <span>High </span> '.$locked['raw_amount'].' <span>fxStars</span>
				    </div>';
		               }
			     } else {
			       echo '<div class="little-box chocolate-bg">
				      <span>Base </span> '.$gsc_fetch['cost'].' <span>fxStars</span>
				    </div>';
		             }
		           } else {

			      if($gsc_fetch['cost']>0) {	  
				    echo '<div class="little-box gold-bg">
				      '.$gsc_fetch['cost'].' <span>fxStars</span>
				    </div>';
			      } else {
			      	   echo '<div class="little-box green-bg" style="padding: 4px 20px;">
				      Free
				    </div>';
			      }

			   }




/*if($gsc_fetch['cost']>0) {	  
				    echo '<div class="little-box gold-bg">
				      '.$gsc_fetch['cost'].' <span>fxStars</span>
				    </div>';
			    } else {
			      	   echo '<div class="little-box green-bg" style="padding: 4px 20px;">
				      Free
				    </div>';
			    }*/

			    echo '<div class="little-box gray-bg"><span>'.date("M jS, Y", strtotime($gsc_fetch['start_date'])).'</span></div>';

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

</body>
</html>
