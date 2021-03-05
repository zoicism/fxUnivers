<?php

session_start();
require('../../../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}



if(isset($_GET['course_id']))
    $course_id=$_GET['course_id'];


require('../../../../php/get_user.php');
$id = $get_user_id;

require('../../../php/notif.php');

if(isset($_GET['class_id']))
    $class_id = $_GET['class_id'];

$class_query = "SELECT * FROM `class` WHERE id=$class_id";
$class_result = mysqli_query($connection, $class_query) or die(mysqli_error($connection));
$class_fetch = mysqli_fetch_array($class_result);

/*$user_id = $class_fetch['teacher_id'];*/
$header = $class_fetch['title'];
$description = $class_fetch['body'];
$video = $class_fetch['video'];

$tar_id=$class_fetch['teacher_id'];
require('../../../../php/get_tar_id.php');


require('../../php/classes.php');

require('../../../../php/get_course.php');

require('../../../../php/get_user_type.php');

/*
   if($user_type == 'neither') {
   $go_home = "Location: /";
   header($go_home);
   }
 */

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

require('../php/notify_students.php');

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

    <script src="../DetectRTC/DetectRTC.js"></script>
    <script src="../js/socket.io.js"> </script>
    <script src="../js/adapter-latest.js"></script>
    <script src="/js/webrtc/IceServersHandler.js"></script>
    <script src="../js/CodecsHandler.js"></script>
    <script src="../RTCPeerConnection/RTCPeerConnection-v1.5.js"></script>
    <script src="../webrtc-broadcasting/broadcast.js"> </script>

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
  <div class="header-sidebar"></div>
  <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
  
  <div class="blur mobile-main">
    
    <div class="sidebar"></div>
    <?php require('../../../../php/sidebar.php'); ?>
    
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



	      
<section class="experiment" style="display:none">
                <section>
                    <select id="broadcasting-option">
                        <option id="audio-video-b">Audio + Video</option>
                        <option id="audio-b">Only Audio</option>
                        <option>Screen</option>
                    </select>
                    <input type="text" id="broadcast-name">
                    <button id="setup-new-broadcast" class="setup">Setup New Broadcast</button>
                </section>

                <!-- list of all available broadcasting rooms -->
                <table style="width: 100%;" id="rooms-list"></table>

                <!-- local/remote videos container -->
                <!--<div id="videos-container"></div>-->
            </section>





	      

<?php echo '<form action="/userpgs/instructor/class/live/screen/#'.$class_id.'" method="POST" id="live-screen" target="_blank" style="display:none"><input type="hidden" name="course_id" value="'.$course_id.'"><input type="hidden" name="class_id" value="'.$class_id.'"><input type="submit" value="sub"></form>'; ?>


	  <!-- VIDEO -->
	  <?php if($user_type=='instructor') { ?>
	      <div class="video-holder" id="live-session" style="display: flex;width: 100%;margin-bottom: 20px;justify-content: center;align-content: center;">
		  <div id="videos-container" class="ins-vid-cnt" style="width:60%"></div>
		  <!-- <div class="ctrl">
	               hereee
	               <div class="ctrl-row" id="before-stream-start" style=""><strong>Start Broadcast: </strong>
		       <select id="broadcasting-option" class="select-input">
		       <option id="audio-video-b">Audio + Video</option>
		       <option id="audio-b">Only Audio</option>
		       <option id="broadcasting-screen">Screen</option>
		       </select>
		       <img src="/images/background/live.svg" style="padding:5px;opacity:1;" id="setup-new-broadcast">
		       <input type="hidden" id="broadcast-name">
		       </div>


		       <div class="ctrl-row" id="after-stream-start" style="display:none">
		       <strong>Broadcasting: </strong>
		       <img src="/images/background/pause.svg" id="pause">
		       <img src="/images/background/stop.svg" id="stop">
		       </div>


		       </div>-->
	      </div>


	  <?php } else { ?>


	      <div class="video-holder" id="live-session" style="display: flex;width: 100%;margin-bottom: 20px;justify-content: center;align-content: center;">
	   <div id="videos-container" id="stu-vid-cnt" style="width:60%"></div>
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


if($tar_user_fetch['avatar']!=NULL) {
      $avatar_url='/userpgs/avatars/'.$tar_user_fetch['avatar'];
} else {
      $avatar_url='/images/background/avatar.png';
}

 echo '<div class="pub-avatar" onclick="location.href=\'/user/'.$tar_user_fetch['username'].'\'">';
	     	  echo '<div class="pub-img avatar" style="background-image:url(\''.$avatar_url.'\');">';
		  echo '</div>';
		  echo '<div class="pub-name">';
		  echo '<p class="fullname">'.$tar_user_fetch['fname'].' '.$tar_user_fetch['lname'].'</p>';
		  echo '<p>@'.$tar_user_fetch['username'].'</p>';
		  echo '</div>';
	     echo '</div>';


	     echo '<h2>'.$header.'</h2>';
             echo '<p>'.$description.'</p>';
?>
	  
<div class="detail-bottom"></div>





	  
	</div>
	<div class="right-content">
	    <?php
            require('../../../../php/limit_str.php');
	    ?>

	    <form id="wbForm" target="_blank" action="/userpgs/instructor/class/live/whiteboard/#<?php echo $class_id ?>" method="POST" style="display:none">
		<input type="hidden" name="courseId" value="<?php echo $course_id ?>">
		<input type="hidden" name="classId" value="<?php echo $class_id ?>">
		<input type="submit" value="Open whiteboard">
            </form>

	    <?php

	    if($user_type=='instructor') {

		echo '<div class="options session-options" style="">';
		
		echo '<div id="video-audio-b-div" class="add-box" style="margin-top:0;"><input type="checkbox" class="toggle-btn" id="video-audio-b-toggle">Video & Audio Broadcast</div>';
		echo '<div id="audio-b-div" class="add-box" style="margin-top:0;"><input type="checkbox" class="toggle-btn" id="audio-b-toggle">Audio-only Broadcast</div>';

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

			echo '<div class="add-box" id="reject-classroom">
				   <svg viewBox="0 0 32 32" style="height: 20px;width: 20px;margin-right: 12px;">
					<path d="M31,5.1H22.1V4a4,4,0,0,0-4-4H13.9a4,4,0,0,0-4,4V5.1H1a1,1,0,0,0-1,1,.9.9,0,0,0,1,1H3.3L5.7,28.5a3.9,3.9,0,0,0,4,3.5H22.3a3.9,3.9,0,0,0,4-3.5L28.7,7.1H31a.9.9,0,0,0,1-1A1,1,0,0,0,31,5.1ZM11.9,4a2,2,0,0,1,2-2h4.2a2,2,0,0,1,2,2V5.1H11.9ZM24.3,28.2a2,2,0,0,1-2,1.8H9.7a2,2,0,0,1-2-1.8L5.3,7.1H26.7Z"></path><path d="M18.8,12.2V24.9a1,1,0,0,0,1,1h0a1.1,1.1,0,0,0,1-1V12.2a1.1,1.1,0,0,0-1-1h0A1,1,0,0,0,18.8,12.2ZM12.2,25.9h0a1,1,0,0,0,1-1V12.2a1,1,0,0,0-1-1h0a1.1,1.1,0,0,0-1,1V24.9A1.1,1.1,0,0,0,12.2,25.9Z"></path>
				   </svg>
				   Remove Classroom
			      </div>';

			echo '</div>';
		echo '</div>';
	    } else {
		echo '<!-- list of all available broadcasting rooms -->
          <table style="display:none" id="rooms-list"></table>';

		echo '<div class="options session-options">';

		

		echo '<div class="add-box" id="live-whiteboard-box" style="justify-content:center">
			           <svg viewBox="0 0 32 32" style="height: 20px;width: 20px;margin-right: 12px;">
					<path d="M28,0H4A4,4,0,0,0,0,4V18.8a4,4,0,0,0,4,4H9.6L5.7,30.5a1.2,1.2,0,0,0,.4,1.4,1.2,1.2,0,0,0,1.4-.4l4.3-8.7h8.4l4.3,8.7a1.1,1.1,0,0,0,.9.5h.4a1.1,1.1,0,0,0,.5-1.4l-3.9-7.7H28a3.9,3.9,0,0,0,2.8-1.1,4.2,4.2,0,0,0,1-1.7,4.3,4.3,0,0,0,.2-1.2V4A4,4,0,0,0,28,0Zm2,18.8a1.7,1.7,0,0,1-.6,1.4l-.3.3h0l-.3.2H3.4a1.4,1.4,0,0,1-.8-.5A1.7,1.7,0,0,1,2,18.8V4c0-.2,0-.3.1-.4A1.9,1.9,0,0,1,4,2H28a2,2,0,0,1,2,1.6V18.8Z"></path>
				   </svg>
				   Live Whiteboard
		      </div>';
		echo '<div class="add-box" id="student-screen" style="justify-content:center">
		 		   <svg viewBox="0 0 32 32" style="height: 20px;width: 20px;margin-right: 12px;">
					<path d="M28,0H4A4,4,0,0,0,0,4V18.8a4,4,0,0,0,4,4H15V30H6.6a1.1,1.1,0,0,0-1,1,1,1,0,0,0,1,1H25.4a1,1,0,0,0,1-1,1.1,1.1,0,0,0-1-1H17V22.8H28a4,4,0,0,0,4-4V4A4,4,0,0,0,28,0Zm2,18.8a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V4A2,2,0,0,1,4,2H28a2,2,0,0,1,2,2Z"></path>
				   </svg>
				   Live Screen
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
        <input name="msgBody" type="text" id="chatInput" class="txt-input" placeholder="Type here">
	<div class="msg-icon-cnt" id="send-btn">
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
    <form method="POST" id="fileForm" enctype="multipart/form-data" action="/php/upload_class_file.php">
    
    <input name="classId" type="hidden" value="<?php echo $class_id?>">
    
    <input type="file" name="class_file" id="fileToUpload" style="display:none">
    <div class="uploadfile-con">
        <div class="image-upload">
    	    <label for="file-input" id="fileToUpload">
                <img src="/images/background/plus.svg" class="chat-icon" id="file-btn">
            </label>
        </div>
        <div id="filename-b4-upload">Choose File</div>
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
  
<!-- WebRTC Broadcasting -->
  <script>
   var config = {
       openSocket: function(config) {
           var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';

	   
           //config.channel = config.channel || location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
	   config.channel = config.channel || 'fxuniversity<?php echo $class_id ?>';
	   console.log(config.channel);
           var sender = Math.round(Math.random() * 999999999) + 999999999;

           io.connect(SIGNALING_SERVER).emit('new-channel', {
               channel: config.channel,
               sender: sender
           });

           var socket = io.connect(SIGNALING_SERVER + config.channel);
           socket.channel = config.channel;
           socket.on('connect', function () {
               if (config.callback) config.callback(socket);
           });

           socket.send = function (message) {
               socket.emit('message', {
                   sender: sender,
                   data: message
               });
           };

           socket.on('message', config.onmessage);
       },
       onRemoteStream: function(htmlElement) {
           videosContainer.appendChild(htmlElement);
           rotateInCircle(htmlElement);
       },
       onRoomFound: function(room) {
           var alreadyExist = document.querySelector('button[data-broadcaster="' + room.broadcaster + '"]');
           if (alreadyExist) return;

           if (typeof roomsList === 'undefined') roomsList = document.body;

           var tr = document.createElement('tr');
           tr.innerHTML = '<td><strong>' + room.roomName + '</strong> is broadcasting his media!</td>' +
                          '<td><button class="join">Join</button></td>';
           roomsList.appendChild(tr);

           var joinRoomButton = tr.querySelector('.join');
           joinRoomButton.setAttribute('data-broadcaster', room.broadcaster);
           joinRoomButton.setAttribute('data-roomToken', room.broadcaster);
           joinRoomButton.onclick = function() {
               this.disabled = true;

               var broadcaster = this.getAttribute('data-broadcaster');
               var roomToken = this.getAttribute('data-roomToken');
               broadcastUI.joinRoom({
                   roomToken: roomToken,
                   joinUser: broadcaster
               });
               hideUnnecessaryStuff();
           };

	   $('.join').click();
	   $('.ctrl').hide();
       },
       onNewParticipant: function(numberOfViewers) {
           document.title = 'fxUniversity - Viewers: ' + numberOfViewers;
       },
       onReady: function() {
           console.log('ready to make connections');
       }
   };

   function setupNewBroadcastButtonClickHandler() {
       document.getElementById('broadcast-name').disabled = true;
       document.getElementById('setup-new-broadcast').disabled = true;

       DetectRTC.load(function() {
           captureUserMedia(function() {
               var shared = 'video';
               if (window.option == 'Only Audio') {
                   shared = 'audio';
               }
               if (window.option == 'Screen') {
                   shared = 'screen';
               }

	       document.getElementById('broadcast-name').value = '<?php echo $class_id ?>';
	       
               broadcastUI.createRoom({
                   roomName: (document.getElementById('broadcast-name') || { }).value || 'Anonymous',
                   isAudio: shared === 'audio'
               });
           });
           hideUnnecessaryStuff();
       });
   }

   function captureUserMedia(callback) {
       var constraints = null;
       window.option = broadcastingOption ? broadcastingOption.value : '';
       if (option === 'Only Audio') {
           constraints = {
               audio: true,
               video: false
           };

           if(DetectRTC.hasMicrophone !== true) {
               alert('DetectRTC library is unable to find microphone; maybe you denied microphone access once and it is still denied or maybe microphone device is not attached to your system or another app is using same microphone.');
           }
       }
       if (option === 'Screen') {
           var video_constraints = {
               mandatory: {
                   chromeMediaSource: 'screen'
               },
               optional: []
           };
           constraints = {
               audio: false,
               video: video_constraints
           };

           if(DetectRTC.isScreenCapturingSupported !== true) {
               alert('DetectRTC library is unable to find screen capturing support. You MUST run chrome with command line flag "chrome --enable-usermedia-screen-capturing"');
           }
       }

       if (option != 'Only Audio' && option != 'Screen' && DetectRTC.hasWebcam !== true) {
           alert('DetectRTC library is unable to find webcam; maybe you denied webcam access once and it is still denied or maybe webcam device is not attached to your system or another app is using same webcam.');
       }

       var htmlElement = document.createElement(option === 'Only Audio' ? 'audio' : 'video');

       htmlElement.muted = true;
       htmlElement.volume = 0;

       try {
           htmlElement.setAttributeNode(document.createAttribute('autoplay'));
           htmlElement.setAttributeNode(document.createAttribute('playsinline'));
           if(option==='Only Audio') htmlElement.setAttributeNode(document.createAttribute('controls'));
	   htmlElement.setAttributeNode(document.createAttribute('id'));
	   htmlElement.setAttribute('id','video-broadcast');
       } catch (e) {
           htmlElement.setAttribute('autoplay', true);
           htmlElement.setAttribute('playsinline', true);
           if(option==='Only Audio') htmlElement.setAttribute('controls', true);
	   
       }

       var mediaConfig = {
           video: htmlElement,
           onsuccess: function(stream) {
               config.attachStream = stream;
               
               videosContainer.appendChild(htmlElement);
               rotateInCircle(htmlElement);
               
               callback && callback();
           },
           onerror: function() {
               if (option === 'Only Audio') alert('unable to get access to your microphone');
               else if (option === 'Screen') {
                   if (location.protocol === 'http:') alert('Please test this WebRTC experiment on HTTPS.');
                   else alert('Screen capturing is either denied or not supported. Are you enabled flag: "Enable screen capture support in getUserMedia"?');
               } else alert('unable to get access to your webcam');
           }
       };
       if (constraints) mediaConfig.constraints = constraints;
       getUserMedia(mediaConfig);
   }

   var broadcastUI = broadcast(config);

   /* UI specific */
   var videosContainer = document.getElementById('videos-container') || document.body;
   var setupNewBroadcast = document.getElementById('setup-new-broadcast');
   var roomsList = document.getElementById('rooms-list');

   var broadcastingOption = document.getElementById('broadcasting-option');

   if (setupNewBroadcast) setupNewBroadcast.onclick = setupNewBroadcastButtonClickHandler;

   function hideUnnecessaryStuff() {
       var visibleElements = document.getElementsByClassName('visible'),
           length = visibleElements.length;
       for (var i = 0; i < length; i++) {
           visibleElements[i].style.display = 'none';
       }
   }

   function rotateInCircle(video) {
       /*video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
       setTimeout(function() {
           video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
       }, 1000);*/
     if(option!=='Only Audio') {
       video.style='-moz-transform: scale(-1, 1); -webkit-transform: scale(-1, 1); -o-transform: scale(-1, 1); transform: scale(-1, 1); filter: FlipH;';
     }
   }

  </script>
<script>
// jQuery(function() {
  //   jQuery('#setup-new-broadcast').click();
// });
</script>
<!-- EO WebRTC Broadcasting -->

<!-- WHITEBOARD -->
<script>
 $('#live-whiteboard-box').click( function() {
     $('#wbForm').submit();
 });
</script>

<!-- ONLINE USERS -->
<script>
 $(document).ready(function() {
     jQuery.ajax({
	     url:'/php/live_online_users.php',
	     type:'POST',
	     data: {class_id:"<?php echo $class_id?>", username:"<?php echo $username?>", user_id:"<?php echo $get_user_id?>",course_id:"<?php echo $course_id?>", teacherId:"<?php echo $tar_id?>"},
	     success: function(response) {
		 $('.online-list').html(response);
		 $('#online-num').html($('#get-online-num').text());
		 //console.log(response);
	     }
     });
     setInterval(function() {
	 //console.log("<?php echo $tar_id?>");
	 jQuery.ajax({
	     url:'/php/live_online_users.php',
	     type:'POST',
	     data: {class_id:"<?php echo $class_id?>", username:"<?php echo $username?>", user_id:"<?php echo $get_user_id?>",course_id:"<?php echo $course_id?>", teacherId:"<?php echo $tar_id?>"},
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


<!-- CHATS -->
<script>
 $('#chatInput').keypress(function(event) {
     var keycode=(event.keyCode ? event.keyCode : event.which);
     if(keycode == '13') {
         var msgbody = $('#chatInput').val();
         var msguserid = <?php echo $get_user_id ?>;
         var msgclassid = <?php echo $class_id ?>;
         jQuery.ajax({
             type: 'POST',
             url: '/php/set_class_chat.php',
             data: {msgBody: msgbody, msgUserId: msguserid, msgClassId: msgclassid},
             success: function(response) {
                 //alert(response);
                 $('#chatInput').val('');
                 $('#chatInput').focus();
             }
         });
     }
 });
 $('#SendIcon').click(function() {
     var msgbody = $('#chatInput').val();
     var msguserid = <?php echo $get_user_id ?>;
     var msgclassid = <?php echo $class_id ?>;
     jQuery.ajax({
         type: 'POST',
         url: '/php/set_class_chat.php',
         data: {msgBody: msgbody, msgUserId: msguserid, msgClassId: msgclassid},
         success: function(response) {
             //alert(response);
             $('#chatInput').val('');
             $('#chatInput').focus();
         }
     });
 });
</script>
<script>
$(document).ready(function() {
    // here
      setInterval(function() {
        jQuery.ajax({
          type: "POST",
          url: "/php/get_class_chat.php",
          data: {class_id: <?php echo $class_id ?>},
          success: function(response) {
                //alert(response);
                $("#newMsgs").load('/php/class_chat_update.php', {class_id: <?php echo $class_id ?>});
          }
        });
         }, 1000);
});
</script>
<!-- EO CHAT -->
<!-- 
<script>
$('#join-img').click(function() {
  $('#join-btn').click();


  $('#join-img').css({'opacity':'0.6', 'cursor':'not-allowed'});
  $('#join-p').html('You are watching live session.');
});
</script>
-->

<!-- FILES -->
<script>
    // here
$(document).ready(function() {
   setInterval(function() {
        $('#newFiles').load('/php/class_file_update.php', {class_id: <?php echo $class_id ?>, user_type: '<?php echo $user_type ?>'});
	$('#filesNum').html($('#getFilesNum').text());
	  }, 5000);
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
	 $('#broadcasting-option #audio-video-b').attr('selected','selected');
	 $('#setup-new-broadcast').click();
	 $('#audio-b-toggle').prop('disabled',true);
	 $('#audio-b-toggle').css('opacity','0.6');
     } else if(!this.checked) {
	 var streamingVid = document.getElementById('video-broadcast');
	 const stream = streamingVid.srcObject;
	 const tracks = stream.getTracks();
	 
	 tracks.forEach(function(track) {
	     track.stop();
	 });

	 console.log('video stream stopped');
	 $('.ins-vid-cnt #video-broadcast').remove();

	 window.location.reload();
	 
	 /*
	    $('#audio-b-toggle').prop('disabled',false);
	    $('#audio-b-toggle').css('opacity','1');
	  */
     }
 });

 $('#audio-b-toggle').change(function() {
     if(this.checked) {
	 $('#broadcasting-option #audio-b').attr('selected','selected');
	 $('#setup-new-broadcast').click();

	 $('#video-audio-b-toggle').prop('disabled',true);
	 $('#video-audio-b-toggle').css('opacity','0.6');
     } else if(!this.checked) {
	 var streamingAudio = document.getElementById('live-session').querySelector('audio');
	 const stream = streamingAudio.srcObject;
	 const tracks = stream.getTracks();

	 tracks.forEach(function(track) {
	     track.stop();
	 });

	 $('.ins-vid-cnt #video-broadcast').remove();

	 window.location.reload();
	 
	 /*
	    $('#video-audio-b-toggle').prop('disabled',false);
	    $('#video-audio-b-toggle').css('opacity','1');
	  */
     }
 });

 $('#screen-b').click(function() {
     $('#live-screen').submit();
 });
 
 $('#record-btn').click(function() {
     var left = ($(window).width()/2)-(900/2);
     var top = ($(window).width()/2)-(600/2);
     window.open("/userpgs/instructor/class/RecordRTC/?classId="+<?php echo $class_id?>, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=900,height=600"); 
 });

 $('#reject-classroom').click(function() {
     if(confirm('By rejecting the classroom it will be deleted and not added as a session to your course. Continue?')) {
	 
	 jQuery.ajax({
	     url: '/php/reject_classroom.php',
	     data: {classId: "<?php echo $class_id ?>"},
	     type: 'POST',
	     success: function(response) {
		 //console.log(response);
		 if(response=='1') {
		     window.location.replace('/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id ?>');
		 } else {
		     alert('Failed to reject the session. Please try again.');
		 }
		 
	     }
	 });
     }
 });
</script>



<!-- STUDENT ADD BOXES -->
<script>
 $('#student-screen').click(function() {
     $('#live-screen').submit();
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

</body>
</html>
