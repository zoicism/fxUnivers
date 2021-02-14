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
require('php/courses.php');
require('../php/notif.php');

require('../../php/get_plans.php');

require('../../php/get_rel.php');

require('../../wallet/php/get_fxcoin_count.php');

require('../../php/get_stu_stucourse.php');
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
                      <a href="/userpgs/instructor" class="link-main" id="active-main">
                          <div class="head">Teach (<?php echo $course_count ?>)</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/userpgs/student" class="link-main">
                          <div class="head">Learn (<?php echo $gss_count ?>)</div>
                      </a>
                  </li>
                  
              </ul>

    </div>





    <div class="relative-main-content">

		<div class="add-box">
		    Add New Course
		    <span>
		        <img src="/images/background/add.svg" onclick="location.href='/userpgs/instructor/course_management/new_course.php';">
		    </span>
		</div>


		<div class="obj-box">
			      

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
				  <img src="/images/background/course.svg" style="height:50%;width:50%;">
				</div>';
			    }



				echo '<div class="details">';

			    $ctitle=preg_replace("/<br\W*?\/>/"," ",$row3['header']);
			    
			    echo '<p><strong>';
			    echo limited($ctitle,40).'</strong></p>';
			    
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
