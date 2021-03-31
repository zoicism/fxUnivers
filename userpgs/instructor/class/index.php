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
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

if(isset($_GET['course_id']))
    $course_id=$_GET['course_id'];


require('../../../php/get_user.php');
$id = $get_user_id;

require('../../php/notif.php');

if(isset($_GET['class_id']))
    $class_id = $_GET['class_id'];

$class_query = "SELECT * FROM `class` WHERE id=$class_id AND alive=1";
$class_result = mysqli_query($connection, $class_query) or die(mysqli_error($connection));
$class_fetch = mysqli_fetch_array($class_result);

$class_count = mysqli_num_rows($class_result);
if($class_count!=1) {
    header('Location: /error');
}

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

$mustRedirect=0;

if((time()-strtotime($class_fetch['dt'].' '.$class_fetch['theTime']) < 0)) {
    $mustRedirect=1;
}


require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
$dual_live_q = "SELECT * FROM ins_live WHERE class_id=$class_id";
$dual_live_r = mysqli_query($fxinstructor_connection, $dual_live_q);
$dual_live = mysqli_num_rows($dual_live_r);


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
  <div class="header-sidebar" style="margin-bottom:0"></div>
  <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
  
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

	<div class="fxuniversity-nav" style="margin-right:auto;opacity:0.6;">
	    <p><?php echo '<a style="font-weight:bold" href="/userpgs/instructor/course_management/course.php?course_id='.$get_course_fetch['id'].'">'.$get_course_fetch['header'].'</a> / <span style="font-weight:bold">'.$header.'</span>' ?></p>
	</div>

	
      <div class="course-content">
	<div class="left-content">
	  <!-- VIDEO -->
	  <?php
	   $path='live/uploads/';
	   $file_ex=glob($path.$class_id.'.*');
	   if(count($file_ex)>0) {
	      $vid_arr=explode('.', $file_ex[0]);
	      $vid_ext=end($vid_arr);
	  ?>



	  <div class="video-holder">
	  <!--
	  <video controls>
            <source src="<?php echo 'live/uploads/'.$class_id.'.'.$vid_ext ?>" type="video/<?php echo $vid_ext?>"> 
	  </video>
	  -->

<video controls>
            <source src="<?php echo 'live/uploads/'.$class_id.'.mp4'?>" type="video/mp4">
   <source src="<?php echo 'live/uploads/'.$class_id.'.ogv'?>" type="video/ogg">
<source src="<?php echo 'live/uploads/'.$class_id.'.webm'?>" type="video/webm">
          </video>
	  </div>




	  
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

<!-- Title, description, and info -->
<?php

	   }


if($tar_user_fetch['avatar']!=NULL) {
      $avatar_url='/userpgs/avatars/'.$tar_user_fetch['avatar'];
} else {
      $avatar_url='/images/background/avatar.png';
}
echo '<div class="course-des-con">';
 echo '<div class="pub-avatar" style="cursor:auto">';
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
	     echo '</div>';


	     echo '<h2>'.$header.'</h2>';
             echo '<p>'.$description.'</p>';
?>
	  
<div class="detail-bottom">




	  <?php

echo '<div class="little-box"><span>'.date("M jS, Y", strtotime($dt)).'</span></div>';

			    ?>
 </div>
</div>




	  
	</div>
	<div class="right-content">
	    <?php
            require('../../../php/limit_str.php');

	    if($user_type=='instructor') {

		echo '<div class="options session-options">';

		echo '<div class="add-box" id="live-add-box">Go Live in This Session </div>';

		echo '<div class="add-box-con">';
		echo '<div class="add-box" onclick="location.href=\'/userpgs/instructor/class/edit_class.php?course_id='.$course_id.'&class_id='.$class_id.'\';"><svg viewBox="0 0 32 32">
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
			              </svg>Manage Session</div>';
		echo '</div>';
		
		//echo '<form action="/userpgs/instructor/class/live/#'.$class_id.'" method="POST" id="LiveForm"><input type="hidden" name="course_id" value="'.$course_id.'"><input type="hidden" name="class_id" value="'.$class_id.'"></form>';

		//echo '<form action="/userpgs/instructor/class/live" method="GET" id="LiveForm"><input type="hidden" name="course_id" value="'.$course_id.'"><input type="hidden" name="class_id" value="'.$class_id.'"><input type="hidden" name="hash" value="#'.$class_id.'"></form>';


		echo '</div>';
	    } else {
		//echo '<div class="options session-learn-options">';
		//echo '<div class="add-box" id="live-add-box">Open Live Classroom</div>';
		//echo '</div>';

		//echo '<form action="/userpgs/instructor/class/live/#'.$class_id.'" method="POST" id="LiveForm"><input type="hidden" name="course_id" value="'.$course_id.'"><input type="hidden" name="class_id" value="'.$class_id.'"></form>';

	//	echo '<form action="/userpgs/instructor/class/live" method="GET" id="LiveForm"><input type="hidden" name="course_id" value="'.$course_id.'"><input type="hidden" name="class_id" value="'.$class_id.'"><input type="hidden" name="hash" value="#'.$class_id.'"></form>';

		// Go directly to live if this is a live session as of now
		

	    }

	    echo '<div class="sessions">';
	    ?>

<div class="tabs">
<div class="tab-student active-tab" id="sessions-tab"><div>Sessions</div></div>
<div class="tab-student" id="file-tab"><div>Files(<?php echo $gcf_count?>)</div></div>
</div>

<?php
//echo '<div class="sess-title"><h3>Sessions</h3></div>';
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



			      if((time()-strtotime($instructor['lastseen']) < 15) && ($instructor['lsPage']=='live/#'.$row['id'])) {
				  echo '<p><strong><span class="gray-bg" style="color:white;padding:2px 5px;">'.$session_counter.'</span> '.$row['title'].'</strong> <img src="/images/background/live6.png" style="width:32px" class="blink_me"></p>';
				  if(($user_type!='instructor') && ($class_id==$row['id'])) $mustRedirect=1;
			      } else {
				  echo '<p><strong><span class="gray-bg" style="color:white;padding:2px 5px;">'.$session_counter.'</span> '.$row['title'].'</strong></p>';
			      }
			      
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
 <div class="file-list" style="display:none">
   <?php
    if($gcf_count>0) {
       echo '<div class="uploaded-files" style="padding-top:0">';
        while($class_fs=$gcf_result->fetch_assoc()) {

	    echo '<div class="file">
		<div class="file-icon-con" href="dl_file.php?file=' . urlencode($class_fs['fileName']) . '">
			<svg viewBox="0 0 32 32">
				<path d="M26,8.6,19.4,2l-2-2H8A4,4,0,0,0,4,4V28a4,4,0,0,0,4,4H24a4,4,0,0,0,4-4V10.6ZM18,3.4,24.6,10H20a2,2,0,0,1-2-2ZM26,28a2,2,0,0,1-2,2H8a2,2,0,0,1-2-2V4A2,2,0,0,1,8,2h8V8a4,4,0,0,0,4,4h6Z"></path>
			</svg>
		</div>';
	echo '<div class="file-name"><div class="file-name-txt" href="dl_file.php?file=' . urlencode($class_fs['fileName']) . '">' . substr($class_fs['fileName'],11) . '</div></div>';
            if($user_type=='instructor') {
                //echo '<p><a href="dl_file.php?file=' . urlencode($class_fs['fileName']) . '">' . substr($class_fs['fileName'],11) . '</a> <a href="del_file.php?file_name='.$class_fs['fileName'].'&course_id='.$course_id.'&class_id='.$class_id.'" style="color:red">[delete]</a></p>';
		echo '<div class="download-delete-con">';
	    echo '<div class="download-file">
	    		<a target="hidden-del" href="dl_file.php?file=' . urlencode($class_fs['fileName']) . '">
				<svg viewBox="0 0 32 32"><rect y="30" width="32" height="2" rx="1"/><path d="M24.2,15.9l-6.6,7.8a2,2,0,0,1-1.6.7h0a2,2,0,0,1-1.6-.7L7.8,15.9a1.1,1.1,0,0,1,.1-1.5h0a1,1,0,0,1,1.4.2L15,21.3V1a.9.9,0,0,1,1-1h0a.9.9,0,0,1,1,1V21.3l5.7-6.7a1,1,0,0,1,1.4-.2h0A1.1,1.1,0,0,1,24.2,15.9Z"/></svg>
			</a><br>
		</div>';
            echo '<div class="del">
	    		<a target="hidden-del" href="del_file.php?file_name='.$class_fs['fileName'].'&course_id='.$course_id.'&class_id='.$class_id.'">
				<svg viewBox="0 0 32 32"><path d="M31,5.1H22.1V4a4,4,0,0,0-4-4H13.9a4,4,0,0,0-4,4V5.1H1a1,1,0,0,0-1,1,.9.9,0,0,0,1,1H3.3L5.7,28.5a3.9,3.9,0,0,0,4,3.5H22.3a3.9,3.9,0,0,0,4-3.5L28.7,7.1H31a.9.9,0,0,0,1-1A1,1,0,0,0,31,5.1ZM11.9,4a2,2,0,0,1,2-2h4.2a2,2,0,0,1,2,2V5.1H11.9ZM24.3,28.2a2,2,0,0,1-2,1.8H9.7a2,2,0,0,1-2-1.8L5.3,7.1H26.7Z"></path><path d="M18.8,12.2V24.9a1,1,0,0,0,1,1h0a1.1,1.1,0,0,0,1-1V12.2a1.1,1.1,0,0,0-1-1h0A1,1,0,0,0,18.8,12.2ZM12.2,25.9h0a1,1,0,0,0,1-1V12.2a1,1,0,0,0-1-1h0a1.1,1.1,0,0,0-1,1V24.9A1.1,1.1,0,0,0,12.2,25.9Z"></path></svg>
			</a><br>
		</div></div>';
            } else {
                //echo '<p><a href="dl_file.php?file=' . urlencode($class_fs['fileName']) . '">' . substr($class_fs['fileName'],11) . '</a></p>';
		echo '<div class="download-delete-con">';
	    echo '<div class="download-file">
	    		<a target="hidden-del" href="dl_file.php?file=' . urlencode($class_fs['fileName']) . '">
				<svg viewBox="0 0 32 32"><rect y="30" width="32" height="2" rx="1"/><path d="M24.2,15.9l-6.6,7.8a2,2,0,0,1-1.6.7h0a2,2,0,0,1-1.6-.7L7.8,15.9a1.1,1.1,0,0,1,.1-1.5h0a1,1,0,0,1,1.4.2L15,21.3V1a.9.9,0,0,1,1-1h0a.9.9,0,0,1,1,1V21.3l5.7-6.7a1,1,0,0,1,1.4-.2h0A1.1,1.1,0,0,1,24.2,15.9Z"/></svg>
			</a><br>
		</div>';
	    echo '</div>';
            }
	    echo '</div>';
        }
    } else {
        echo '<p style="color:gray;text-align:center;">No files yet</p>';
    }
   echo '</div>';
?>
 </div>
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
   var mustRedir = <?php echo $mustRedirect ?>;
   if(mustRedir) {
       window.location.replace('/userpgs/instructor/class/live/?course_id=<?php echo $course_id ?>&class_id=<?php echo $class_id ?>');
   }
  </script>

<script>
var vhWidth = $('.video-holder').width();
$('.video-holder').height(vhWidth/1.78);
</script>




  <!-- fxUniversity sidebar active -->
  <script>
    $('.fxuniversity-sidebar').attr('id','sidebar-active');
  </script>


<!-- LIVE CLASS -->
<script>
/*$("#live-add-box").on("click",function() {
  
  jQuery.ajax({
    url:'add_live.php',
    type:'POST',
    data:{classId:"<?php echo $class_id?>"},
    success:function(response) {
      if(response==1) {
        $("#LiveForm").submit();
      } else {
        console.log('Error');
      }
    }
  });
  
 });*/
 
$('#live-add-box').click(function() {
     var dual_live = <?php echo $dual_live ?>;
     
     
     if(dual_live > 0) {
	 window.location.href = '/userpgs/instructor/class/live/dual.php?course_id=<?php echo $course_id ?>&class_id=<?php echo $class_id ?>';
     } else {
	 window.location.href = '/userpgs/instructor/class/live/?course_id=<?php echo $course_id ?>&class_id=<?php echo $class_id ?>';
     }
});
</script>

<script>
$('#file-tab').click(function() {
  $('#file-tab').addClass('active-tab');
  $('#sessions-tab').removeClass('active-tab');

  $('.file-list').show();
  $('.sess-list').hide();
});
$('#sessions-tab').click(function() {
  $('#file-tab').removeClass('active-tab');
  $('#sessions-tab').addClass('active-tab');

  $('.sess-list').show();
  $('.file-list').hide();
});
</script>
</body>
</html>
