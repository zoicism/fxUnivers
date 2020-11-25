<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/
  session_start();
  require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
	header("Location: /register/logout.php");
}

  if(isset($_GET['course_id'])) $course_id = $_GET['course_id'];

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
  $test_date = $course_fetch['test_date'];

  


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
  <script src="/js/upperbar.js"></script>
  
  <div class="blur mobile-main">
    
    <div class="sidebar"></div>
    <?php require('../../../php/sidebar.php'); ?>
    
    <div class="main-content">
      
      <ul class="main-flex-container">
        <li class="main-items">
                      <a href="/userpgs/instructor" class="link-main" <?php if($user_type=='instructor') echo 'id="active-main"'; ?>>
                        <div class="head">Teach</div>
                      </a>
        </li>
        <li class="main-items">
          <a href="/userpgs/student" class="link-main" <?php if($user_type!='instructor') echo 'id="active-main"'; ?>>
            <div class="head">Learn</div>
          </a>
        </li>
        
      </ul>
      
    </div>
          

    <div class="relative-main-content">

      <div class="course-content">
      
	<div class="left-content">
	  <!-- VIDEO -->
	  <?php
	   $path='videos/';
	   $file_ex=glob($path.$course_id.'.*');
	   if(count($file_ex)>0) {
	      $vid_arr=explode('.', $file_ex[0]);
	      $vid_ext=end($vid_arr);
	  ?>

	  <video width="560" height="315" controls>
            <source src="<?php echo 'videos/'.$course_id.'.'.$vid_ext ?>" type="video/<?php echo $vid_ext?>"> 
	  </video>

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
 	     echo '<div class="pub-avatar" onclick="location.href=\'/user/'.$tar_user_fetch['username'].'\'">';
	     	  echo '<div class="pub-img avatar">';
		  echo '</div>';
		  echo '<div class="pub-name">';
		  echo '<p class="fullname">'.$tar_user_fetch['fname'].' '.$tar_user_fetch['lname'].'</p>';
		  echo '<p>@'.$tar_user_fetch['username'].'</p>';
		  echo '</div>';
	     echo '</div>';
	     echo '<h2>'.$header.'</h2>';
             echo '<p>'.$description.'</p>';
?>
	  
<div class="detail-bottom">

<?php
$coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$course_id;
                            $coursecounter_r=mysqli_query($connection,$coursecounter_q);
                            $coursecounts=mysqli_num_rows($coursecounter_r);
?>



	  <div class="little-box gray-bg">
	    <?php echo $class_num.' <span>sessions</span>'; ?>
	  </div>

	<div class="little-box blue-bg">
	  <?php echo $coursecounts.' <span>students</span>'; ?>
	</div>


	  <?php
	  if($cost>0) {	  
				    echo '<div class="little-box gold-bg">
				      '.$cost.' <span>fxStars</span>
				    </div>';
			    } else {
			      	   echo '<div class="little-box green-bg" style="padding: 4px 20px;">
				      Free
				    </div>';
			    }

echo '<div class="little-box gray-bg"><span>'.date("M jS, Y", strtotime($s_date)).'</span></div>';

			    ?>
 </div>





	  
	</div>
	<div class="right-content">
	  <?php
                require('../../../php/limit_str.php');



if($user_type=='instructor') {
			     echo '<div class="options">';	
			     echo '<div class="add-box">Manage Course <img src="/images/background/settings.png" onclick="location.href=\'/userpgs/instructor/course_management/edit_course.php?course_id='.$course_id.'\';"></div>';

			     echo '<div class="add-box">Add Session <img src="/images/background/add.svg" onclick="location.href=\'/userpgs/instructor/class/new_class.php?course_id='.$course_id.'\';"></div>';

			     
			     echo '<div class="add-box">Manage Test <img src="/images/background/checkbox.svg"></div>';

			     echo '</div>';
} elseif($user_type=='student') {
echo '<div class="options">';
echo '<div class="add-box">Take the Test <img src="/images/background/checkbox.svg"></div>';
echo '</div>';
} else {
echo '<div class="options">';
echo '<div class="add-box">Purchase Course <img src="/images/background/checkbox.svg" onclick="location.href=\'/wallet/purchase?item=course&no='.$course_id.'\';"></div>';
echo '</div>';
}



echo '<div class="sessions">';
echo '<div class="sess-title"><h3>Sessions</h3></div>';
echo '<div class="sess-list">';

                if($class_result->num_rows>0) {
		
                    while($row=$class_result->fetch_assoc()) {
                        if($user_type=='instructor' || $user_type=='student') {
                            $onclickurl="location.href='/userpgs/instructor/class?course_id=".$course_id."&class_id=".$row['id']."'";
                        } else {
                            // not purchased
                            $onclickurl="unpurchased()";
                        }
			echo '<div class="session" onclick="'.$onclickurl.'">';
			?>

			  <div class="session-prev">
			   <img src="/images/background/course.svg">
			  </div>
			  <div class="session-desc">

			<?php
                        
                        echo '<p><strong>'.$row['title'].'</strong></p>';
                        if($row['body']=='') {
                            $descrip='<span class="gray">(No description)</span>';
                        } else {
                            $descrip=preg_replace("/<br\W*?\/>/", " ", $row['body']);
                        }
                        echo '<p>';
			echo limited($descrip,70).'</p>';
                        echo '</div></div>';
                    }
                    $class_result->free();
                } else {
                    echo '<p class="gray" style="text-align:center;">No sessions yet.</p>';
                }
 ?>
	</div>
      </div>
</div>     </div> 
            
    </div>


  </div>
  

  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script>



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
