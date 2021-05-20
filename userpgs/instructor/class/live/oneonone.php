<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');
require($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    require($_SERVER['DOCUMENT_ROOT'].'/php/get_user.php');
    
    if(isset($_GET['oooid'])) $oooid = $_GET['oooid'];

    $oneonone_enrolled_q = "SELECT * FROM stu_oneonone WHERE id = $oooid";
    $oneonone_enrolled_r = mysqli_query($fxinstructor_connection, $oneonone_enrolled_q);
    $oneonone_enrolled = mysqli_num_rows($oneonone_enrolled_r);
    if($oneonone_enrolled) {
	$oneonone_enrolled_f = mysqli_fetch_array($oneonone_enrolled_r);
	$instructor_id = $oneonone_enrolled_f['instructor_id'];
	$student_id = $oneonone_enrolled_f['student_id'];

	if($get_user_id == $instructor_id) $user_type = 'instructor';
	elseif($get_user_id == $student_id) $user_type = 'student';
	else $user_type = 'other';
    }
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}


/*
   if(isset($_GET['course_id']))
   $course_id=$_GET['course_id'];
 */


$id = $get_user_id;

require($_SERVER['DOCUMENT_ROOT'].'/userpgs/php/notif.php');
/*
   if(isset($_GET['class_id']))
   $class_id = $_GET['class_id'];

   $class_query = "SELECT * FROM `class` WHERE id=$class_id";
   $class_result = mysqli_query($connection, $class_query) or die(mysqli_error($connection));
   $class_fetch = mysqli_fetch_array($class_result);


   $header = $class_fetch['title'];
   $description = $class_fetch['body'];
   $video = $class_fetch['video'];
   $theDate = $class_fetch['dt'];
   if($class_fetch['theTime']!=null) {
   $theTime = $class_fetch['theTime'];

   $actualTime = $theDate.' '.$theTime;
   $epochTime = strtotime($actualTime);
   $epochDiff = $epochTime - time();
   }

   $tar_id=$class_fetch['teacher_id'];
 */
$get_tar_q = "SELECT * FROM user WHERE id=$instructor_id";
$tar_user_result = mysqli_query($connection, $get_tar_q) or die(mysqli_error($connection));
$tar_user_fetch = mysqli_fetch_array($tar_user_result);


/*
   if($user_type == 'neither') {
   $go_home = "Location: /";
   header($go_home);
   }
 */
/*
   function randHash($len) {
   return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
   }

   require('../../../../contact/message_connect.php');
   if($user_type=='instructor') {
   
   $liveClassId = randHash(32);
   require('../../../../php/create_live_class.php');
   } elseif($user_type=='student') {
   require('../../../../php/join_live_class.php');
   $liveClassId = $join_live_class_roomid;
   } else {
   header('Location: /userpgs/instructor/course_management/course.php?course_id='.$course_id);
   }
 */
//require('../php/notify_students.php');

//require('../../../../php/get_class_chat.php');
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
	<script src="/js/jquery.form.js"></script>

	<!--
	     <script src="../DetectRTC/DetectRTC.js" id="detectrtc" ></script>
	     <script src="../js/socket.io.js" id="socketio"> </script>
	     <script src="../js/adapter-latest.js" id="adapter" ></script>
	     <script src="/js/webrtc/IceServersHandler.js" id="iceServersHandler"></script>
	     <script src="../js/CodecsHandler.js" id="codecsHandlers"></script>
	     <script src="../RTCPeerConnection/RTCPeerConnection-v1.5.js" id="RtcPeerConnection"></script>
	     <script src="../webrtc-broadcasting/broadcast.js" id="broadcast"> </script>
	-->
	<script src="../js/adapter-latest.js" id="adapter" ></script>
	<!--<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>-->
	<!--<script src="https://www.webrtc-experiment.com/socket.io.js"> </script>-->
	<script src="../js/socket.io.js" id="socketio"> </script>
	<script src="/js/webrtc/IceServersHandler.js" id="iceServersHandler"></script>
	<!--<script src="https://www.webrtc-experiment.com/IceServersHandler.js"></script>-->
	<script src="../socket.io/PeerConnection.js"> </script>

	
	<!--
             <script src="https://www.webrtc-experiment.com/DetectRTC.js"></script>

             <script src="https://www.webrtc-experiment.com/socket.io.js"> </script>
             <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
             <script src="https://www.webrtc-experiment.com/IceServersHandler.js"></script>
             <script src="https://www.webrtc-experiment.com/CodecsHandler.js"></script>
             <script src="https://www.webrtc-experiment.com/RTCPeerConnection-v1.5.js"> </script>
             <script src="https://www.webrtc-experiment.com/webrtc-broadcasting/broadcast.js"> </script>
	-->
	
    </head>
    
    <body>
	<!--
	     <div style="height:100%;width:100%;display:flex;align-items:center;justify-content:center;position:fixed;background-color:black;opacity:0.3;cursor:auto;z-index:2;" id="loading"><img src="/images/background/loading.gif" style="z-index:3"></div>
	-->
	
	<div class="header-sidebar"></div>
	<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php //echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
	<script>
	 if(screen.width >= 629) {
	     $(document).ready(function() {
		 $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/instructor/" class="link-main" <?php if($user_type=='instructor') echo 'id="active-main"'; ?>><div class="head">Teach</div></a></div><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/student/" class="link-main" <?php if($user_type!='instructor') echo 'id="active-main"'; ?>><div class="head">Learn</div></a></div></div>');

	     });
	 }
	</script>	
	<div class="blur mobile-main">
	    
	    <div class="sidebar"></div>
	    <?php require('../../../../php/sidebar.php'); ?>
	    

	    <div class="relative-main-content">


		<div class="fxuniversity-nav" style="margin-right:auto;opacity:0.6;">
		    <p><?php //echo '<a style="font-weight:bold" href="/userpgs/instructor/course_management/course.php?course_id='.$get_course_fetch['id'].'">'.$get_course_fetch['header'].'</a> / <span style="font-weight:bold">'.$header.'</span>' ?></p>
		</div>
		

		<div class="course-content">
		    <div class="left-content">



			
			<section class="experiment" style="display:none">
			    <section>
				<select id="broadcasting-option">
				    <option id="audio-video-b">Audio + Video</option>
				    <option id="audio-b">Only Audio</option>
				    <option>Screen</option>
				</select>
				<input type="text" id="your-name">
				<button id="start-broadcasting" class="setup">Setup New Broadcast</button>
			    </section>

			    <!-- list of all available broadcasting rooms -->
			    <table style="width: 100%;" id="rooms-list"></table>

			    <!-- local/remote videos container -->
			    <!--<div id="videos-container"></div>-->
			</section>





			



			<!-- VIDEO -->
			<?php if($user_type=='instructor') { ?>
			    <div class="video-holder" id="live-session" style="display: flex;width: 90%;margin-bottom: 20px;justify-content: center;align-content: center;">
				<div id="videos-container" style="display:flex; flex-flow: column nowrap; justify-content:space-between; align-items:center; width:60%;"></div>
				
			    </div>


			<?php } else { ?>


			    <div class="video-holder" id="live-session" style="display: flex;width: 90%;margin-bottom: 20px;justify-content: center;align-content: center;">
				<div id="videos-container" style="display:flex; flex-flow: column nowrap; justify-content:center; align-items:center; width:60%;"></div>
				<div class="ctrl">
				    <div class="ctrl-row" id="before-stream-start">
					<p id="join-p">Live video hasn't started yet.</p>			       
					<img src="/images/background/live.svg" style="padding:5px;opacity:0.5;cursor:not-allowed;" disabled id="join-img">
					<!-- <div style="display:none" id="setup-new-broadcast"></div>
					     <input type="hidden" id="broadcast-name">-->
				    </div>
				</div>
			    </div>


			<?php }

			/*
			   if($tar_user_fetch['avatar']!=NULL) {
			   $avatar_url='/userpgs/avatars/'.$tar_user_fetch['avatar'];
			   } else {
			   $avatar_url='/images/background/avatar.png';
			   }

			   echo '<div class="pub-avatar" style="cursor:auto">';
	     		   echo '<div class="pub-img avatar" style="cursor:pointer;background-image:url(\''.$avatar_url.'\');" onclick="location.href=\'/user/'.$tar_user_fetch['username'].'\'">';
			   echo '</div>';
			   echo '<div class="pub-name" style="cursor:pointer;" onclick="location.href=\'/user/'.$tar_user_fetch['username'].'\'">';
			   echo '<p class="fullname">'.$tar_user_fetch['fname'].' '.$tar_user_fetch['lname'].'</p>';
			   echo '<p>@'.$tar_user_fetch['username'].'</p>';
			   echo '</div>';
			   echo '</div>';


			   echo '<h2>'.$header.'</h2>';
			   echo '<p>'.$description.'</p>';
			 */
			?>
			
			<div class="detail-bottom"></div>

			<div  style="display:none">

			    <button id="enableAudio" >Enable Audio</button>
			    <button id="disableAudio" >Disable Audio</button>
			    <button id="btnStart">START RECORDING</button> 
			    <button id="btnStop">STOP RECORDING</button>
			    <button id="save">Save</button>

			    <!--for record--> 
			    <audio controls muted id="studentAudio"></audio> 
			    
			    <!--for play the audio--> 

			    
			    <!-- from server -->
			    <!--<audio controls src="audio/test.wav"></audio>-->
			</div>
			
		    </div>
		    <div class="right-content">
			<?php
			require('../../../../php/limit_str.php');
			?>

			<form id="wbForm" target="_blank" action="/userpgs/instructor/class/live/whiteboard/oooWhiteboard.php#<?php echo $oooid ?>" method="POST" style="display:none">
			    
			    <input type="hidden" name="classId" value="<?php echo $oooid ?>">
			    <input type="submit" value="Open whiteboard">
			</form>

			<?php

			if($user_type=='instructor') {

			    echo '<div class="options session-options" style="">';
			    echo '<div class="video-audio-bc-con">';
			    echo '<div class="video-audio-bc">';
			    echo '<div id="video-audio-b-div" class="add-box" style="margin-top:0;"><input type="checkbox" class="toggle-btn" id="video-audio-b-toggle">Video & Audio Broadcast</div>';
			    //echo '<div id="audio-b-div" class="add-box" style="margin-top:0;"><input type="checkbox" class="toggle-btn" id="audio-b-toggle">Audio-only Broadcast</div>';
			    echo '</div>';
			    echo '</div>';
			    echo '<div class="add-box-con">';
			    echo '<div class="add-box" id="screen-b">
				   <svg viewBox="0 0 32 32" style="height: 20px;width: 20px;margin-right: 12px;">
					<path d="M28,0H4A4,4,0,0,0,0,4V18.8a4,4,0,0,0,4,4H15V30H6.6a1.1,1.1,0,0,0-1,1,1,1,0,0,0,1,1H25.4a1,1,0,0,0,1-1,1.1,1.1,0,0,0-1-1H17V22.8H28a4,4,0,0,0,4-4V4A4,4,0,0,0,28,0Zm2,18.8a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V4A2,2,0,0,1,4,2H28a2,2,0,0,1,2,2Z"></path>
				   </svg>
				   Screen Broadcast
			      </div>';
			    echo '<div class="add-box" id="live-whiteboard-box">
				   <svg viewBox="0 0 32 32" style="height: 20px;width: 20px;margin-right: 12px;">
					<path d="M28,0H4A4,4,0,0,0,0,4V18.8a4,4,0,0,0,4,4H9.6L5.7,30.5a1.2,1.2,0,0,0,.4,1.4,1.2,1.2,0,0,0,1.4-.4l4.3-8.7h8.4l4.3,8.7a1.1,1.1,0,0,0,.9.5h.4a1.1,1.1,0,0,0,.5-1.4l-3.9-7.7H28a3.9,3.9,0,0,0,2.8-1.1,4.2,4.2,0,0,0,1-1.7,4.3,4.3,0,0,0,.2-1.2V4A4,4,0,0,0,28,0Zm2,18.8a1.7,1.7,0,0,1-.6,1.4l-.3.3h0l-.3.2H3.4a1.4,1.4,0,0,1-.8-.5A1.7,1.7,0,0,1,2,18.8V4c0-.2,0-.3.1-.4A1.9,1.9,0,0,1,4,2H28a2,2,0,0,1,2,1.6V18.8Z"></path>
				   </svg>
				   Whiteboard Broadcast
			      </div>';
			    echo '<div class="add-box" id="record-btn">
				   <svg viewBox="0 0 32 32" style="height: 20px;width: 20px;margin-right: 12px;">
					<path d="M16,2A14,14,0,1,1,2,16,14,14,0,0,1,16,2m0-2A16,16,0,1,0,32,16,16,16,0,0,0,16,0Z"></path><path d="M16,11.9A4.1,4.1,0,1,1,11.9,16,4.1,4.1,0,0,1,16,11.9m0-2A6.1,6.1,0,1,0,22.1,16,6.1,6.1,0,0,0,16,9.9Z"></path>
				   </svg>
				   Record
			      </div>';

			    echo '<div class="add-box" id="notifystu-btn">
				<svg viewBox="0 0 32 32" style="height: 20px;width: 20px;margin-right: 12px;">
					<path d="M32,16a1.1,1.1,0,0,1-1,1H22.2a1,1,0,0,1,0-2H31A1.1,1.1,0,0,1,32,16Z"></path><path d="M30.2,7.6,22.6,12h-.5a.9.9,0,0,1-.9-.5.9.9,0,0,1,.4-1.3l7.6-4.4.5-.2a1.2,1.2,0,0,1,.9.5A1.1,1.1,0,0,1,30.2,7.6Z"></path><path d="M30.7,25.3a4.3,4.3,0,0,0-.1.5,1.2,1.2,0,0,1-.9.5l-.5-.2-7.6-4.4a.9.9,0,0,1-.4-1.3.9.9,0,0,1,.9-.5h.5l7.6,4.4A1.1,1.1,0,0,1,30.7,25.3Z"></path><path d="M15.5,2.9a2,2,0,0,0-1.4.6L9,8.6a.8.8,0,0,1-.7.3H4a4,4,0,0,0-4,4v6.2a4,4,0,0,0,4,4H8.3a.8.8,0,0,1,.7.3l5.1,5.1a2,2,0,0,0,1.4.6,2,2,0,0,0,2-2V4.9A2,2,0,0,0,15.5,2.9Zm0,24.2-5-5.1a3.1,3.1,0,0,0-2.2-.9H4a2,2,0,0,1-2-2V12.9a2,2,0,0,1,2-2H8.3a3.1,3.1,0,0,0,2.2-.9l5-5.1Z"></path>
				</svg>
				Notify Student
			</div>';

			    
			    
			    echo '<div class="remove-save-con">';
			    //echo '<div class="add-box" id="save-classroom">
		            //Adjourn
			    //</div>';
			    echo '<div class="add-box" id="reject-classroom">
		            Adjourn
		      </div>';
			    echo '</div>';

			    echo '</div>';
			    echo '</div>';
			} else {
			    echo '<!-- list of all available broadcasting rooms -->
          <table style="display:none" id="rooms-list"></table>';

			    echo '<div class="options session-options">';

			    

			    echo '<div class="add-box-con">
<div class="add-box student-whiteboard" id="live-whiteboard-box" style="justify-content:center;">
			           <svg viewBox="0 0 32 32" style="height: 20px;width: 20px;margin-right: 12px;">
					<path d="M28,0H4A4,4,0,0,0,0,4V18.8a4,4,0,0,0,4,4H9.6L5.7,30.5a1.2,1.2,0,0,0,.4,1.4,1.2,1.2,0,0,0,1.4-.4l4.3-8.7h8.4l4.3,8.7a1.1,1.1,0,0,0,.9.5h.4a1.1,1.1,0,0,0,.5-1.4l-3.9-7.7H28a3.9,3.9,0,0,0,2.8-1.1,4.2,4.2,0,0,0,1-1.7,4.3,4.3,0,0,0,.2-1.2V4A4,4,0,0,0,28,0Zm2,18.8a1.7,1.7,0,0,1-.6,1.4l-.3.3h0l-.3.2H3.4a1.4,1.4,0,0,1-.8-.5A1.7,1.7,0,0,1,2,18.8V4c0-.2,0-.3.1-.4A1.9,1.9,0,0,1,4,2H28a2,2,0,0,1,2,1.6V18.8Z"></path>
				   </svg>
				   Live Whiteboard
		      </div>';
			    echo '<div class="add-box" id="student-screen" style="justify-content:center;">
		 		   <svg viewBox="0 0 32 32" style="height: 20px;width: 20px;margin-right: 12px;">
					<path d="M28,0H4A4,4,0,0,0,0,4V18.8a4,4,0,0,0,4,4H15V30H6.6a1.1,1.1,0,0,0-1,1,1,1,0,0,0,1,1H25.4a1,1,0,0,0,1-1,1.1,1.1,0,0,0-1-1H17V22.8H28a4,4,0,0,0,4-4V4A4,4,0,0,0,28,0Zm2,18.8a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V4A2,2,0,0,1,4,2H28a2,2,0,0,1,2,2Z"></path>
				   </svg>
				   Live Screen
		      </div>
		</div>';
			    


			    

			    echo '</div>';
			}

			echo '<div class="sessions">';
			?>


			<div class="tabs">
			    <div class="tab active-tab" id="users-tab"><div>Online(<span id="online-num"></span>)</div></div>
			    <div class="tab" id="chat-tab"><div>Chat</div></div>
			    <div class="tab" id="file-tab"><div>Files(<span id="filesNum"></span>)</div></div>
			    <!--<div class="tab" style="border-radius:0 20px 0 0;" id="sessions-tab"><h3>Sessions</h3></div>-->

			</div>




			<?php
			/*
			echo '<div class="sess-list" style="display:none">';
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

			    echo '</div>';
			    */
			    ?>
			    <!-- sess-list -->


			    <!-- CHAT -->
			    <div class="chat-list" style="display:none">
				<div class="live-chat-con">

				    <div class="msg-icon-cnt" id="voice-btn" recording="false" style="margin: 0">
					<svg viewBox="0 0 32 32" id="voice-start-stop"><path d="M25.7,10.8a.9.9,0,0,1,1,1v3A10.8,10.8,0,0,1,17,25.5V30h4.7a.9.9,0,0,1,1,1h0a.9.9,0,0,1-1,1H10.3a.9.9,0,0,1-1-1h0a.9.9,0,0,1,1-1H15V25.5a11,11,0,0,1-6.6-3.1,10.9,10.9,0,0,1-3.1-7.6v-3a.9.9,0,0,1,1-1h0a.9.9,0,0,1,1,1v3A9.1,9.1,0,0,0,9.8,21a8.9,8.9,0,0,0,6.1,2.5c4.8.1,8.8-4.2,8.8-9V11.8a.9.9,0,0,1,1-1Z"/><path d="M20.7,2A6.6,6.6,0,0,0,9.3,6.7v8.1a6.2,6.2,0,0,0,2,4.7,6.2,6.2,0,0,0,4.7,2,6.7,6.7,0,0,0,6.7-6.7V6.7A6.7,6.7,0,0,0,20.7,2Zm0,12.8a4.7,4.7,0,0,1-9.4,0V6.7A4.7,4.7,0,0,1,16,2a4.4,4.4,0,0,1,3.3,1.4,4.4,4.4,0,0,1,1.4,3.3Z"/></svg>
				    </div>

				    <div class="msg-icon-cnt" id="trash-voice-btn" style="margin:0;display:none;">
					<svg viewBox="0 0 32 32"><path d="M31,5.1H22.1V4a4,4,0,0,0-4-4H13.9a4,4,0,0,0-4,4V5.1H1a1,1,0,0,0-1,1,.9.9,0,0,0,1,1H3.3L5.7,28.5a3.9,3.9,0,0,0,4,3.5H22.3a3.9,3.9,0,0,0,4-3.5L28.7,7.1H31a.9.9,0,0,0,1-1A1,1,0,0,0,31,5.1ZM11.9,4a2,2,0,0,1,2-2h4.2a2,2,0,0,1,2,2V5.1H11.9ZM24.3,28.2a2,2,0,0,1-2,1.8H9.7a2,2,0,0,1-2-1.8L5.3,7.1H26.7Z"/><path d="M18.8,12.2V24.9a1,1,0,0,0,1,1h0a1.1,1.1,0,0,0,1-1V12.2a1.1,1.1,0,0,0-1-1h0A1,1,0,0,0,18.8,12.2ZM12.2,25.9h0a1,1,0,0,0,1-1V12.2a1,1,0,0,0-1-1h0a1.1,1.1,0,0,0-1,1V24.9A1.1,1.1,0,0,0,12.2,25.9Z"/></svg>
				    </div>


				    <audio id="adioPlay" controls style="display:none"></audio>
				    <input name="msgBody" type="text" id="chatInput" class="txt-input" placeholder="Type here">
				    <div class="msg-icon-cnt" id="send-btn" isAudio="false" style="margin:0">
					<svg id="SendIcon" viewBox="0 0 32 32""><defs><style>.send-icon{fill:#212121;}</style></defs>
					    <path class="send-icon" d="M30.9,14.5,2.9.5,2,.3A1.9,1.9,0,0,0,.1,2.8L3.2,16.4.1,29.2A2,2,0,0,0,2,31.7l.9-.2,28-13.4A2,2,0,0,0,30.9,14.5ZM2,29.7,5.1,17.4H15.8a1,1,0,0,0,1-1h0a.9.9,0,0,0-1-1H5.1L2,2.3l28,14Z"></path>
					</svg>
				    </div>
				</div>
				<div class="msgs" id="newMsgs"></div>
			    </div>

			    <!-- ONLINE LIST -->
			    <div class="online-list"></div>


			    <!-- FILES -->
			    <div class="file-list" style="display:none">
				<?php if($user_type=='instructor') { ?>
				    <form method="POST" id="fileForm" enctype="multipart/form-data" action="/php/upload_class_file_ooo.php">
					
					<input name="classId" type="hidden" value="<?php echo $oooid?>">
					<input name="instId" type="hidden" value="<?php echo $instructor_id ?>">
					
					<input type="file" name="class_file" id="fileToUpload" style="display:none">
					<div class="uploadfile-con">
					    <div class="image-upload">
    						<label for="file-input" id="fileToUpload">
						    <img src="/images/background/plus.svg" class="chat-icon" id="file-btn">
						</label>
					    </div>
					    <div class="filename-b4-upload-con">
						<div id="filename-b4-upload">Choose File</div>
					    </div>
					</div>
					<input type="submit" value="Upload file" class="submit-btn">
				    </form>

				    <iframe name="hidden-del" style="display:none"></iframe>
				<?php } ?>
				<div class="uploaded-files" id="newFiles"></div>

			    </div>
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
	</script>
	
	
	<!-- fxUniversity sidebar active -->
	<script>
	 $('.fxuniversity-sidebar').attr('id','sidebar-active');
	</script>

	<!-- WHITEBOARD -->
	<?php if($user_type=='instructor') { ?>
	    <script>
	     $('#live-whiteboard-box').click( function() {
		 $('#wbForm').submit();
	     });
	    </script>
	<?php } else { ?>
	    <script>
	     $('#live-whiteboard-box').click( function() {
		 $('#wbForm').submit();
	     });
	    </script>

	<?php } ?>


	<!-- ONLINE USERS -->
	<script>
	 $(document).ready(function() {
	     jQuery.ajax({
		 url:'/php/live_online_users_ooo.php',
		 type:'POST',
		 data: {class_id:"<?php echo $class_id?>", username:"<?php echo $username?>", user_id:"<?php echo $get_user_id?>", teacherId:"<?php echo $tar_id?>", student_id: '<?php echo $student_id ?>'},
		 success: function(response) {
		     $('.online-list').html(response);
		     $('#online-num').html($('#get-online-num').text());
		     //console.log(response);
		 }
	     });
	     setInterval(function() {
		 //console.log("<?php echo $tar_id?>");
		 jQuery.ajax({
		     url:'/php/live_online_users_ooo.php',
		     type:'POST',
		     data: {class_id:"<?php echo $oooid?>", username:"<?php echo $username?>", user_id:"<?php echo $get_user_id?>", teacherId:"<?php echo $instructor_id?>", student_id: '<?php echo $student_id ?>'},
		     success: function(response) {
			 $('.online-list').html(response);
			 $('#online-num').html($('#get-online-num').text());
			 //console.log(response);
		     }
		 });
	     }, 10000);
	 });
	</script>


	<!-- TABS -->
	<script>
	 /*
	    $('#sessions-tab').click(function() {
	    $('#sessions-tab').addClass('active-tab');
	    $('#chat-tab').removeClass('active-tab');
	    $('#users-tab').removeClass('active-tab');
	    $('#file-tab').removeClass('active-tab');
	    $('.file-list').hide();
	    //$('.sess-list').show();
	    $('.chat-list').hide();
	    $('.online-list').hide();
	    });*/
	 $('#chat-tab').click(function() {
	     $('#sessions-tab').removeClass('active-tab');
	     $('#chat-tab').addClass('active-tab');
	     $('#users-tab').removeClass('active-tab');
	     $('#file-tab').removeClass('active-tab');
	     $('.file-list').hide();
	     //$('.sess-list').hide();
	     $('.chat-list').show();
	     $('.online-list').hide();
	 });
	 $('#users-tab').click(function() {
	     $('#sessions-tab').removeClass('active-tab');
	     $('#chat-tab').removeClass('active-tab');
	     $('#users-tab').addClass('active-tab');
	     $('#file-tab').removeClass('active-tab');
	     $('.file-list').hide();
	     //$('.sess-list').hide();
	     $('.chat-list').hide();
	     $('.online-list').show();
	 });
	 $('#file-tab').click(function() {
	     $('#sessions-tab').removeClass('active-tab');
	     $('#chat-tab').removeClass('active-tab');
	     $('#users-tab').removeClass('active-tab');
	     $('#file-tab').addClass('active-tab');
	     $('.file-list').show();
	     //$('.sess-list').hide();
	     $('.chat-list').hide();
	     $('.online-list').hide();
	 });
	</script>

	<!-- AUDIO MSG -->
	<script>
	 var audioData = [];
	 function startAudio() {
	     

	     //$('#enableAudio').click(function() {
	     let audioIN = { audio: true }; 
	     // audio is true, for recording 

	     // Access the permission for use 
	     // the microphone 
	     navigator.mediaDevices.getUserMedia(audioIN) 

	     // 'then()' method returns a Promise 
		      .then(function (mediaStreamObj) { 

			  // Connect the media stream to the 
			  // first audio element 
			  //let audio = document.querySelector('audio'); 
			  let audio = document.getElementById('studentAudio');
			  //returns the recorded audio via 'audio' tag 

			  // 'srcObject' is a property which 
			  // takes the media object 
			  // This is supported in the newer browsers 
			  if ("srcObject" in audio) { 
			      audio.srcObject = mediaStreamObj; 
			  } 
			  else { // Old version 
			      audio.src = window.URL 
						.createObjectURL(mediaStreamObj); 
			  } 

			  // It will play the audio 
			  audio.onloadedmetadata = function (ev) { 

			      // Play the audio in the 2nd audio 
			      // element what is being recorded 
			      audio.play(); 
			  }; 

			  // Start record 
			  //let start = document.getElementById('btnStart'); 

			  // Stop record 
			  //let stop = document.getElementById('btnStop'); 

			  // 2nd audio tag for play the audio 
			  let playAudio = document.getElementById('adioPlay'); 

			  // This is the main thing to recorde 
			  // the audio 'MediaRecorder' API 
			  let mediaRecorder = new MediaRecorder(mediaStreamObj); 
			  // Pass the audio stream 

			  // Start event 
			  document.getElementById('btnStart').addEventListener('click', function (ev) { 
			      mediaRecorder.start(); 
			      // console.log(mediaRecorder.state);
			      //console.log('started');

			      $('#chatInput').val('Recording...').prop('disabled', true);
			      //$('#voice-btn').attr('id','voice-btn-stop');
			      $('#voice-btn').attr('recording', 'true');

			      $('#voice-start-stop').html('<path d="M21.9,8.1a2,2,0,0,1,2,2V21.9a2,2,0,0,1-2,2H10.1a2,2,0,0,1-2-2V10.1a2,2,0,0,1,2-2H21.9m0-2H10.1a4,4,0,0,0-4,4V21.9a4,4,0,0,0,4,4H21.9a4,4,0,0,0,4-4V10.1a4,4,0,0,0-4-4Z"/>');
			      
			  });

			  // Stop event 
			  document.getElementById('btnStop').addEventListener('click', function (ev) { 
			      mediaRecorder.stop(); 
			      // console.log(mediaRecorder.state);
			      //console.log('stopped');
			  }); 

			  // If audio data available then push 
			  // it to the chunk array 
			  mediaRecorder.ondataavailable = function (ev) { 
			      dataArray.push(ev.data); 
			  } 

			  // Chunk array to store the audio data 
			  let dataArray = []; 

			  // Convert the audio data in to blob 
			  // after stopping the recording 
			  mediaRecorder.onstop = function (ev) { 
			      audioData = [];
			      // blob of type mp3 
			      audioData = new Blob(dataArray, 
						   { 'type': 'audio/mp3;' }); 

			      console.log(audioData);
			      
			      // After fill up the chunk 
			      // array make it empty 
			      dataArray = []; 

			      // Creating audio url with reference 
			      // of created blob named 'audioData' 
			      let audioSrc = window.URL 
						   .createObjectURL(audioData); 

			      console.log(audioSrc);

			      // Pass the audio url to the 2nd video tag 
			      playAudio.src = audioSrc;

			      disableAudioTracks();
			      
			      
			  }
			  $('#btnStart').click();

			  
		      }) 
		      .catch(function (err) {  // If any error occurs then handles the error 
			  console.log(err.name, err.message); 
		      });

	 }

	 

	</script>

	<script>
	 $('#save').click(function() {
	     uploadBlob(audioData);
	     //audioData=[];
	 });
	</script>


	<script>
	 function uploadBlob(audioD) {
	     var xhr = new XMLHttpRequest();
	     
	     
	     
	     var fd = new FormData();
	     fd.append('audio_data', audioD, 'fxuniversityaudio.mp3');
	     fd.append('msgUserId', '<?php echo $get_user_id?>');
	     fd.append('msgClassId', '<?php echo $class_id ?>');
	     xhr.open('POST', 'upload_audio.php', true);
	     xhr.send(fd);

	 }
	</script>



	<script>
	 var directVoiceSend=false;
	 /*
	    function uploadBlob(audioD) {
	    // create a blob here for testing
	    //var blob = new Blob(["i am a blob"]);
	    var blob = audioD;
	    //var blob = yourAudioBlobCapturedFromWebAudioAPI;// for example   
	    var reader = new FileReader();
	    // this function is triggered once a call to readAsDataURL returns
	    reader.onload = function(event) {
	    var fd = new FormData();
	    //fd.append('audioname', '.wav');
	    //fd.append('msgUserId', '<?php echo $get_user_id?>');
	    //fd.append('msgClassId', '<?php echo $class_id ?>');
	    fd.append('data', event.target.result);
	    $.ajax({
	    type: 'POST',
	    url: 'audio_upload.php',
	    data: fd,
	    processData: false,
	    contentType: false
	    }).done(function(data) {
	    // print the output from the upload.php script
	    console.log(data);
	    
	    });
	    };      
	    // trigger the read from the reader...
	    reader.readAsDataURL(blob);	 
	    }*/
	</script>
	<script>
	 $('#voice-btn').click(function() {
	     var recordingStu = $('#voice-btn').attr('recording');
	     //console.log(recordingStu);
	     if(recordingStu=='false') {

		 startAudio();
		 $('#chatInput').show();
		 $('#adioPlay').hide();
		 $('#send-btn').attr('isAudio','false');
		 $('#trash-voice-btn').hide();

	     } else if(recordingStu=='true') {

		 $('#btnStop').click();
		 $('#voice-btn').attr('recording', 'false');
		 $('#chatInput').hide();
		 $('#adioPlay').show();
		 $('#send-btn').attr('isAudio','true');
		 $('#trash-voice-btn').show();
		 $(this).hide();

		 console.log(directVoiceSend);

		 if(directVoiceSend==true) {
		     directVoiceSend=false;
		     $('#adioPlay').hide();
		     $('#chatInput').show();
		     $('#trash-voice-btn').hide();
		     $('#voice-btn').show();
		     setTimeout(function() {
			 $('#send-btn').click();
		     }, 1000);
		 }
		 
	     }
	 });

	 $('#trash-voice-btn').click(function() {
	     $('#send-btn').attr('isAudio','false');
	     $('#chatInput').show().prop('disabled',false).val('');
	     $('#adioPlay').hide();
	     $('#trash-voice-btn').hide();
	     $('#voice-btn').show();
	     $('#voice-start-stop').html('<path d="M25.7,10.8a.9.9,0,0,1,1,1v3A10.8,10.8,0,0,1,17,25.5V30h4.7a.9.9,0,0,1,1,1h0a.9.9,0,0,1-1,1H10.3a.9.9,0,0,1-1-1h0a.9.9,0,0,1,1-1H15V25.5a11,11,0,0,1-6.6-3.1,10.9,10.9,0,0,1-3.1-7.6v-3a.9.9,0,0,1,1-1h0a.9.9,0,0,1,1,1v3A9.1,9.1,0,0,0,9.8,21a8.9,8.9,0,0,0,6.1,2.5c4.8.1,8.8-4.2,8.8-9V11.8a.9.9,0,0,1,1-1Z"/><path d="M20.7,2A6.6,6.6,0,0,0,9.3,6.7v8.1a6.2,6.2,0,0,0,2,4.7,6.2,6.2,0,0,0,4.7,2,6.7,6.7,0,0,0,6.7-6.7V6.7A6.7,6.7,0,0,0,20.7,2Zm0,12.8a4.7,4.7,0,0,1-9.4,0V6.7A4.7,4.7,0,0,1,16,2a4.4,4.4,0,0,1,3.3,1.4,4.4,4.4,0,0,1,1.4,3.3Z"/>');
	 });
	</script>

	<script>
	 function disableAudioTracks() {
	     //var studentAudio = document.querySelector('audio');
	     var studentAudio = document.getElementById('studentAudio');
	     const studentStream = studentAudio.srcObject;
	     const tracks = studentStream.getTracks();
	     
	     tracks.forEach(function(track) {
		 track.stop();
	     });
	     
	 }
	</script>
	<!-- CHATS -->
	<script>
	 $('#chatInput').keypress(function(event) {
	     var keycode=(event.keyCode ? event.keyCode : event.which);
	     if(keycode == '13') {
		 var msgbody = $('#chatInput').val();
		 var msguserid = <?php echo $get_user_id ?>;
		 var msgclassid = <?php echo $oooid ?>;
		 jQuery.ajax({
		     type: 'POST',
		     url: '/php/set_class_chat_ooo.php',
		     data: {msgBody: msgbody, msgUserId: msguserid, msgClassId: msgclassid},
		     success: function(response) {
			 //alert(response);
			 $('#chatInput').val('');
			 $('#chatInput').focus();
		     }
		 });
	     }
	 });
	 $('#send-btn').click(function() {
	     var isAudio = $('#send-btn').attr('isAudio');

	     if(isAudio=='false') {

		 if($('#chatInput').val()=='Recording...') {
		     directVoiceSend = true;
		     $('#voice-btn').click();
		 } else {

		     var msgbody = $('#chatInput').val();

		     if(msgbody!='') {
			 var msguserid = <?php echo $get_user_id ?>;
			 var msgclassid = <?php echo $oooid ?>;
			 jQuery.ajax({
			     type: 'POST',
			     url: '/php/set_class_chat_ooo.php',
			     data: {msgBody: msgbody, msgUserId: msguserid, msgClassId: msgclassid},
			     success: function(response) {
				 //alert(response);
				 $('#chatInput').val('');
				 $('#chatInput').focus();
			     }
			 });
		     } else {
			 alert('Type something or record audio to send.');
		     }
		 }
	     } else if(isAudio=='true') {
		 $('#save').click();
		 $('#send-btn').attr('isAudio','false');
		 $('#chatInput').show().prop('disabled',false).val('');
		 $('#adioPlay').hide();
		 $('#trash-voice-btn').hide();
		 $('#voice-btn').show();

		 $('#voice-start-stop').html('<path d="M25.7,10.8a.9.9,0,0,1,1,1v3A10.8,10.8,0,0,1,17,25.5V30h4.7a.9.9,0,0,1,1,1h0a.9.9,0,0,1-1,1H10.3a.9.9,0,0,1-1-1h0a.9.9,0,0,1,1-1H15V25.5a11,11,0,0,1-6.6-3.1,10.9,10.9,0,0,1-3.1-7.6v-3a.9.9,0,0,1,1-1h0a.9.9,0,0,1,1,1v3A9.1,9.1,0,0,0,9.8,21a8.9,8.9,0,0,0,6.1,2.5c4.8.1,8.8-4.2,8.8-9V11.8a.9.9,0,0,1,1-1Z"/><path d="M20.7,2A6.6,6.6,0,0,0,9.3,6.7v8.1a6.2,6.2,0,0,0,2,4.7,6.2,6.2,0,0,0,4.7,2,6.7,6.7,0,0,0,6.7-6.7V6.7A6.7,6.7,0,0,0,20.7,2Zm0,12.8a4.7,4.7,0,0,1-9.4,0V6.7A4.7,4.7,0,0,1,16,2a4.4,4.4,0,0,1,3.3,1.4,4.4,4.4,0,0,1,1.4,3.3Z"/>');
	     }
	 });
	 
	</script>
	<script>
	 $(document).ready(function() {
	     // here
	     setInterval(function() {
		 var numberOfMsgs = $('.one-msg').length;
		 //console.log(numberOfMsgs);

		 jQuery.ajax({
		     type: "POST",
		     url: "/php/class_chat_update_ooo.php",
		     data: {class_id: <?php echo $oooid ?>, numOfMsgs: numberOfMsgs},
		     success: function(response) {
			 //console.log(response);

			 if(response!='') {
			     if(response=='empty') {
				 $('.msgs').html('<p style="color:gray;text-align:center;">Empty</p>');
			     } else {
				 
				 $('.msgs').prepend(response);
				 $('#chat-tab').addClass('bg-blink-in');
				 setTimeout( function() {
				     $('#chat-tab').addClass('bg-blink-out');
				 }, 2000);
				 setTimeout(function() {
				     $('#chat-tab').removeClass('bg-blink-in');
				     $('#chat-tab').removeClass('bg-blink-out');
				 }, 4000);
			     } 
			 }
			 //alert(response);
			 //$("#newMsgs").load('/php/class_chat_update.php', {class_id: <?php echo $class_id ?>});
		     }
		 });
             }, 2000);
	 });
	</script>
	<!-- EO CHAT -->

	<!-- FILES -->
	<script>
	 $(document).ready(function() {     
	     setInterval(function() {
		 $('#newFiles').load('/php/class_file_update_ooo.php', {class_id: <?php echo $oooid ?>, user_type: '<?php echo $user_type ?>'});
		 $('#filesNum').html($('#getFilesNum').text());
	     }, 2000);
	 });

	</script>


	<!-- FILE UPLOAD -->
	<script>
	 $(function() {
	     $('#fileForm').ajaxForm(function(response) {
		 //console.log('file is uploaded');
		 $('#fileToUpload').val('');
		 $('#filename-b4-upload').html('Choose File');
	     });
	 });
	</script>

	<script>
	 $('#video-audio-b-toggle').change(function() {
	     if(this.checked) {
		 console.log('clicked');
		 //$('#broadcasting-option #audio-video-b').attr('selected','selected');
		 $('#start-broadcasting').click();
		 //$('#audio-b-toggle').prop('disabled',true);
		 //$('#audio-b-toggle').css('opacity','0.6');
	     } else if(!this.checked) {
		 var streamingVid = document.querySelector('video');
		 const stream = streamingVid.srcObject;
		 const tracks = stream.getTracks();
		 
		 tracks.forEach(function(track) {
		     track.stop();
		 });

		 console.log('video stream stopped');
		 $('.ins-vid-cnt #video-broadcast').remove();


		 $('body').prepend('<div style="height:100%;width:100%;display:flex;align-items:center;justify-content:center;position:fixed;background-color:black;opacity:0.3;cursor:auto;z-index:2;" id="loading"><img src="/images/background/loading.gif" style="z-index:3"></div>');

		 var oooId = '<?php echo $oooid ?>';
		 jQuery.ajax({
		     url: '/php/set_1on1_activity.php',
		     type: 'POST',
		     data: {oooid: oooId, activity: '0'},
		     success: function(response) {
			 console.log(response);
			 window.location.reload();
		     }
		 });
	     }
	     

	 });

	 $('#screen-b').click(function() {
	     //$('#live-screen').submit();
	     window.open('screen/oooScreen.php?oooid=<?php echo $oooid?>');
	 });
	 
	 $('#record-btn').click(function() {
	     var left = ($(window).width()/2)-(900/2);
	     var top = ($(window).width()/2)-(600/2);
	     window.open("/userpgs/instructor/class/RecordRTC/oooRecord.php?oooid="+<?php echo $oooid?>, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=900,height=600"); 
	 });

	 $('#reject-classroom').click(function() {
		 jQuery.ajax({
		     url: '/php/reject_1on1.php',
		     data: {classId: "<?php echo $oooid ?>"},
		     type: 'POST',
		     success: function(response) {
			 //console.log(response);
			 if(response=='1') {
			     window.location.href = '/userpgs/instructor';
			 } else {
			     alert('Failed to reject the session. Please try again.');
			 }
			 
		     }
		 });
	    
	 });

	 $('#save-classroom').click(function() {
	     window.location.href = '/userpgs/instructor/';
	 });

	 $('#notifystu-btn').click(function() {
	     $.ajax({
		 url:'../php/notify_students.php',
		 data: {userType: '<?php echo $user_type ?>',
			courseId: '<?php echo $course_id ?>',
			header: '<?php echo $header ?>',
			classId: '<?php echo $class_id ?>',
			getUserId: '<?php echo $get_user_id ?>'},
		 type: 'POST',
		 success: function(response) {
		     if(response==1) {
			 alert('Students are informed by email and notification.');
		     } else {
			 alert('Failed to notify students. Please try again.');
		     }
		 }
	     });
	 });


	</script>



	<!-- STUDENT ADD BOXES -->
	<script>
	 $('#student-screen').click(function() {
	     if($('#student-screen').css('opacity')==1) {
		 //$('#live-screen').submit();
		 window.open('screen/oooScreen.php?roomid=<?php echo $oooid?>');
	     } else {
		 alert("Screen is not shared.");
	     }
	 });
	</script>

	<script>
	 $('#file-btn').click(function() {
	     $('#fileToUpload').click();
	     
	     //$('#filename-b4-upload').html('');
	 });
	 $('#fileToUpload').change(function() {
	     var fileFullPath = $('#fileToUpload').val();
	     //console.log(fileFullPath);
	     if(fileFullPath) {
		 var startIndex = (fileFullPath.indexOf('\\') >= 0 ? fileFullPath.lastIndexOf('\\') : fileFullPath.lastIndexOf('/'));
		 var filename = fileFullPath.substring(startIndex);
		 if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
		     filename = filename.substring(1);
		 }
		 //console.log(filename);
		 $('#filename-b4-upload').html(filename);
	     } else {
		 $('#filename-b4-upload').html('File is ready to upload');
		 //console.log('File is ready to upload');
	     }
	 });
	</script>

	<?php if($user_type=='instructor') { ?>
	    <script>
	     setTimeout( function() {
		 $.ajax({
		     url: '/php/set_ins_live_on.php',
		     type: 'POST',
		     data: {classId: '<?php echo $class_id ?>'},
		     success: function(response) {
			 //console.log(response);
		     }
		 });
	     }, 5000);     
	    </script>

	    <script>
	     //window.addEventListener('beforeunload', function(event) {
	     window.addEventListener('unload', function(event) {
		 jQuery.ajax({
		     url: '/php/set_ins_live_off.php',
		     type: 'POST',
		     data: {classId: '<?php echo $class_id ?>'},
		     success: function(response) {
		     }
		 });
	     });
	    </script>

	    <script>
	     window.addEventListener('beforeunload', function(event) {
		 jQuery.ajax({
		     url: '/php/set_ins_live_off.php',
		     type: 'POST',
		     data: {classId: '<?php echo $class_id ?>'},
		     success: function(response) {
		     }
		 });
	     });
	    </script>
	<?php } ?>

	<script>
	 //var channel = location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
	 var channel = 'oneonone'+'<?php echo $oooid?>';
	 var sender = Math.round(Math.random() * 999999999) + 999999999;

	 var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';
	 io.connect(SIGNALING_SERVER).emit('new-channel', {
	     channel: channel,
	     sender: sender
	 });

	 var socket = io.connect(SIGNALING_SERVER + channel);
	 socket.on('connect', function () {
	     // setup peer connection & pass socket object over the constructor!
	 });

	 socket.send = function (message) {
	     socket.emit('message', {
		 sender: sender,
		 data: message
	     });
	 };

	 // var peer = new PeerConnection('http://socketio-signaling.jit.su:80');
	 var peer = new PeerConnection(socket);
	 peer.onUserFound = function(userid) {
	     if (document.getElementById(userid)) return;
	     var tr = document.createElement('tr');

	     var td1 = document.createElement('td');
	     var td2 = document.createElement('td');

	     td1.innerHTML = userid + ' has camera. Are you interested in video chat?';

	     $('#join-img').prop('disabled', false).css('opacity','1').css('cursor','pointer');
	     $('#join-p').html('Instructor is sharing Video and Audio. Click to Join:');
	     
	     var button = document.createElement('button');
	     button.innerHTML = 'Join';
	     button.id = userid;
	     button.style.float = 'right';
	     button.onclick = function() {
		 button = this;
		 getUserMedia(function(stream) {
		     peer.addStream(stream);
		     peer.sendParticipationRequest(button.id);
		 });
		 button.disabled = true;
	     };
	     td2.appendChild(button);

	     tr.appendChild(td1);
	     tr.appendChild(td2);
	     roomsList.appendChild(tr);

	     $('#join-img').click(function() { button.click(); });
	 };

	 peer.onStreamAdded = function(e) {
	     var video = e.mediaElement;
	     //video.setAttribute('width', 600);
	     //video.css('border-radius', '10px');
	     videosContainer.insertBefore(video, videosContainer.firstChild);

	     video.play();
	     rotateVideo(video);
	     scaleVideos();

	     $('.ctrl').hide();
	     
	 };

	 peer.onStreamEnded = function(e) {
	     var video = e.mediaElement;
	     if (video) {
		 video.style.opacity = 0;
		 rotateVideo(video);
		 setTimeout(function() {
		     video.parentNode.removeChild(video);
		     scaleVideos();
		 }, 1000);
	     }
	 };

	 document.querySelector('#start-broadcasting').onclick = function() {
	     this.disabled = true;
	     getUserMedia(function(stream) {
		 peer.addStream(stream);
		 peer.startBroadcasting();
	     });
	 };

	 document.querySelector('#your-name').onchange = function() {
	     peer.userid = this.value;
	 };

	 var videosContainer = document.getElementById('videos-container') || document.body;
	 var btnSetupNewRoom = document.getElementById('setup-new-room');
	 var roomsList = document.getElementById('rooms-list');

	 if (btnSetupNewRoom) btnSetupNewRoom.onclick = setupNewRoomButtonClickHandler;

	 function rotateVideo(video) {
	     video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
	     setTimeout(function() {
		 video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
	     }, 1000);
	 }

	 function scaleVideos() {
	     var videos = document.querySelectorAll('video'),
		 length = videos.length, video;

	     var minus = 130;
	     var windowHeight = 700;
	     var windowWidth = 600;
	     var windowAspectRatio = windowWidth / windowHeight;
	     var videoAspectRatio = 4 / 3;
	     var blockAspectRatio;
	     var tempVideoWidth = 0;
	     var maxVideoWidth = 0;

	     for (var i = length; i > 0; i--) {
		 blockAspectRatio = i * videoAspectRatio / Math.ceil(length / i);
		 if (blockAspectRatio <= windowAspectRatio) {
		     tempVideoWidth = videoAspectRatio * windowHeight / Math.ceil(length / i);
		 } else {
		     tempVideoWidth = windowWidth / i;
		 }
		 if (tempVideoWidth > maxVideoWidth)
		     maxVideoWidth = tempVideoWidth;
	     }
	     for (var i = 0; i < length; i++) {
		 video = videos[i];
		 if (video)
		     video.width = maxVideoWidth - minus;
	     }
	 }

	 window.onresize = scaleVideos;

	 // you need to capture getUserMedia yourself!
	 function getUserMedia(callback) {
	     var hints = {audio:true,video:{
		 optional: [],
		 mandatory: {}
	     }};
	     navigator.getUserMedia(hints,function(stream) {
		 var video = document.createElement('video');
		 video.srcObject = stream;
		 video.controls = true;
		 video.muted = true;

		 peer.onStreamAdded({
		     mediaElement: video,
		     userid: 'self',
		     stream: stream
		 });

		 callback(stream);
	     });
	 }

	 (function() {
	     var uniqueToken = document.getElementById('unique-token');
	     if (uniqueToken)
		 if (location.hash.length > 2) uniqueToken.parentNode.parentNode.parentNode.innerHTML = '<h2 style="text-align:center;"><a href="' + location.href + '" target="_blank">Share this link</a></h2>';
	     else uniqueToken.innerHTML = uniqueToken.parentNode.parentNode.href = '#' + (Math.random() * new Date().getTime()).toString(36).toUpperCase().replace( /\./g , '-');
	 })();

	</script>

	<?php if($user_type == 'student') { ?>
	    <script>
	     $(document).ready(function() {     
		 var oooId = '<?php echo $oooid ?>';
		 setInterval(function() {
		     $.ajax({
			 url: '/php/get_1on1_activity.php',
			 type: 'POST',
			 data: {oooid: oooId},
			 dataType: 'json',
			 success: function(response) {
			     //console.log(response);

			     var alive = response[0];
			     var active = response[1];

			     if(active == 0) {
				 alert('Broadcast ended.');
				 window.location.reload();
			     } 
			 }
		     });
		 }, 2000);
	     });
	    </script>
	<?php } else if($user_type == 'instructor') { ?>
	    <script>
setTimeout( function() {
	     $(document).ready(function() {     
		 var oooId = '<?php echo $oooid ?>';
		 $.ajax({
		     url: '/php/set_1on1_activity.php',
		     type: 'POST',
		     data: {oooid: oooId, activity: '1'},
		     success: function(response) {
			 //console.log(response);
		     }
		 });
	     });
}, 5000);
	    </script>

	    <script>
	     window.addEventListener('unload', function(event) {
		 var oooId = '<?php echo $oooid ?>';
		 jQuery.ajax({
		     url: '/php/set_1on1_activity.php',
		     type: 'POST',
		     data: {oooid: oooId, activity: '0'},
		     success: function(response) {
			 //console.log(response);
		     }
		 });
	     });
	    </script>

	    <script>
	     window.addEventListener('beforeunload', function(event) {
		 var oooId = '<?php echo $oooid ?>';
		 jQuery.ajax({
		     url: '/php/set_1on1_activity.php',
		     type: 'POST',
		     data: {oooid: oooId, activity: '0'},
		     success: function(response) {
			 //console.log(response);
		     }
		 });
	     });
	    </script>
	<?php } ?>
	
    </body>
</html>
