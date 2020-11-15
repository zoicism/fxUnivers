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
    // logout
      header("Location: /register/logout.php");
  }

  if(isset($_GET['course_id']))
    $course_id=$_GET['course_id'];


  require('../../../php/get_user.php');
  $id = $get_user_id;

  require('../../php/notif.php');

  if(isset($_GET['class_id']))
   $class_id = $_GET['class_id'];

  $class_query = "SELECT * FROM `class` WHERE id=$class_id";
  $class_result = mysqli_query($connection, $class_query) or die(mysqli_error($connection));
  $class_fetch = mysqli_fetch_array($class_result);

  /*$user_id = $class_fetch['teacher_id'];*/
  $header = $class_fetch['title'];
  $description = $class_fetch['body'];
  $video = $class_fetch['video'];
  $dt = $class_fetch['dt'];

  require('../php/classes.php');

  require('../../../php/get_course.php');
// includes $get_course_teacher_id

  require('../../../php/get_user_type.php');

  if($user_type == 'neither') {
    $go_home = "Location: /userpgs/instructor/course_management/course.php?course_id=".$course_id."&class_id=".$class_id;
    header($go_home);
  }
  

  require('../../../contact/message_connect.php');
  require('../../../php/check_live_class.php');
  require('../../../php/get_class_files.php');


$tar_id=$class_fetch['teacher_id'];
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
	   $file_ex=glob($path.$class_id.'.*');
	   if(count($file_ex)>0) {
	      $vid_arr=explode('.', $file_ex[0]);
	      $vid_ext=end($vid_arr);
	  ?>



	  <div class="video-holder">
	  <video width="560" height="315" controls>
            <source src="<?php echo 'videos/'.$class_id.'.'.$vid_ext ?>" type="video/<?php echo $vid_ext?>"> 
	  </video>
	  </div>




	  <!-- Title, description, and info -->
	  <?php
	   } else {

	   ?>

	   
	   <div class="video-placeholder">
         	   <img src="/images/background/novid.svg">

		   	   <p>No video</p>	
	   </div>


<?php

	   }
 
	     echo '<h2>'.$header.'</h2>';
             echo '<p>'.$description.'</p>';
?>
	  
<div class="detail-bottom">

	  <div class="little-box gray">
	    <?php
	    echo '<a href="/user/'.$tar_user_fetch['username'].'">'.$tar_user_fetch['fname'].' '.$tar_user_fetch['lname'].' @'.$tar_user_fetch['username'].'</a>';
	    ?>
	  </div>





	  <?php

echo '<div class="little-box gray"><span>'.date("M jS, Y", strtotime($dt)).'</span></div>';

			    ?>
 </div>





	  
	</div>
	<div class="right-content">
	  <?php
                require('../../../php/limit_str.php');

if($user_type=='instructor') {

			     echo '<div class="options">';

			     echo '<div class="add-box">Manage Session <img src="/images/background/settings.png" onclick="location.href=\'/userpgs/instructor/class/edit_class.php?course_id='.$course_id.'&class_id='.$class_id.'\';"></div>';

			     echo '<div class="add-box">Go Live <img src="/images/background/live.png" onclick=""></div>';

			     echo '</div>';
}

echo '<div class="sessions">';
echo '<h3>Sessions</h3>';

                if($class_result->num_rows>0) {
		
                    while($row=$class_result->fetch_assoc()) {
                        if($user_type=='instructor' || $user_type=='student') {
                            $onclickurl="location.href='/userpgs/instructor/class?course_id=".$course_id."&class_id=".$row['id']."'";
                        } else {
                            // not purchased
                            $onclickurl="unpurchased()";
                        }
			if($class_id==$row['id']) {
			  echo '<div class="session" id="active" onclick="'.$onclickurl.'">';
			  } else {
			  echo '<div class="session" onclick="'.$onclickurl.'">';
			  }
			?>

			  <div class="session-prev">
			   <img src="/images/background/course.svg">
			  </div>
			  <div class="session-desc">

			<?php
                        
                        echo '<p><strong>'.$row['title'].'</strong></p>';
                        if($row['body']=='') {
                            $descrip='<span style="color:gray">(No description)</span>';
                        } else {
                            $descrip=preg_replace("/<br\W*?\/>/", " ", $row['body']);
                        }
                        echo '<p>';
			echo limited($descrip,70).'</p>';
                        echo '</div></div>';
                    }
                    $class_result->free();
                } else {
                    echo '<p style="color:gray;text-align:center;">No sessions yet.</p>';
                }
 ?>
	</div>
      </div>
      
            
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
