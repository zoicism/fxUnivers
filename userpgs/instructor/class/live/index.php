<?php

  session_start();
  require('../../../../register/connect.php');

  if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
  } else {
      header("Location: /");
  }

  if(isset($_POST['course_id']))
    $course_id=$_POST['course_id'];


  require('../../../../php/get_user.php');
  $id = $get_user_id;

  require('../../../php/notif.php');

  if(isset($_POST['class_id']))
   $class_id = $_POST['class_id'];

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

    <script src="../RTCPeerConnection/RTCPeerConnection-v1.5.js"></script>
    <script src="../webrtc-broadcasting/broadcast.js"> </script>
    <script src="../getScreenId.js/getScreenId.js"></script>
    
    <script src="../DetectRTC/DetectRTC.js"></script>
    <script src="../js/socket.io.js"> </script>
    <script src="../js/adapter-latest.js"></script>
    <script src="/js/webrtc/IceServersHandler.js"></script>
<!--
    <script src="../Pluginfree-Screen-Sharing/conference.js"></script>
    <script src="../js/CodecsHandler.js"></script>
    <script src="/js/webrtc/BandwidthHandler.js"></script>
-->
    <script src="/js/jquery-3.4.1.min.js"></script>

    <script src="/js/jquery.form.js"></script>
    
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

      <div class="course-content">
	<div class="left-content">

<?php echo '<form action="/userpgs/instructor/class/live/screen/#'.$class_id.'" method="POST" id="live-screen" target="_blank" style="display:none"><input type="hidden" name="course_id" value="'.$course_id.'"><input type="hidden" name="class_id" value="'.$class_id.'"><input type="submit" value="sub"></form>'; ?>


	  <!-- VIDEO -->
	  <?php if($user_type=='instructor') { ?>
	  <div class="video-holder" id="live-session">
	   <div id="videos-container" class="ins-vid-cnt"></div>
	   <div class="ctrl">
	                  <div class="ctrl-row" id="before-stream-start" style="display:none"><strong>Start Broadcast: </strong>
			       <select id="broadcasting-option" class="select-input">
			         <option id="audio-video-b">Audio + Video</option>
				 <option id="audio-b">Only Audio</option>
				 <option id="broadcasting-screen">Screen</option>
			       </select>
			       <img src="/images/background/live.svg" style="padding:5px;opacity:1;" id="setup-new-broadcast">
			       <input type="hidden" id="broadcast-name">
			     </div>

<!--
			     <div class="ctrl-row" id="after-stream-start" style="display:none">
			     <strong>Broadcasting: </strong>
	   <img src="/images/background/pause.svg" id="pause">
	   <img src="/images/background/stop.svg" id="stop">
	   </div>
-->

	   </div>
	  </div>


<?php } else { ?>


<div class="video-holder" id="live-session">
	   <div id="videos-container"></div>
	   <div class="ctrl">
	                     <div class="ctrl-row" id="before-stream-start">
			       <p id="join-p">Live video hasn't started yet.</p>			       
			       <img src="/images/background/live.svg" style="padding:5px;opacity:0.5;cursor:not-allowed;" disabled id="join-img">
			       <div style="display:none" id="setup-new-broadcast"></div>
			       <input type="hidden" id="broadcast-name">
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
	  
<div class="detail-bottom">




	  <?php

//echo '<div class="little-box gray-bg"><span>'.date("M jS, Y", strtotime($dt)).'</span></div>';

			    ?>
 </div>





	  
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

			     echo '<div class="options session-options">';

			     //echo '<h3 style="text-align:center">Broadcast</h3>';

			     //echo '<div class="add-box" id="live-whiteboard-box">Live Whiteboard </div>';

echo '<div class="add-box" style="margin-top:0"><input type="checkbox" class="toggle-btn" id="video-audio-b-toggle">Video & Audio Broadcast</div>';
echo '<div class="add-box" style="margin-top:0"><input type="checkbox" class="toggle-btn" id="screen-b-toggle">Screen Broadcast</div>';
echo '<div class="add-box" style="margin-top:0"><input type="checkbox" class="toggle-btn" id="audio-b-toggle">Audio Broadcast</div>';
echo '<div class="add-box" style="margin-top:0"><input type="checkbox" class="toggle-btn" id="live-whiteboard-box">Whiteboard Broadcast</div>';


//echo '<button id="share-screen" class="setup" style="display:none">Share Your Screen</button>';

//echo '<hr class="hr-tct">';



//echo '<h3 style="text-align:center">Record</h3>';

//echo '<div class="add-box" style="margin-top:0"><input type="checkbox" class="toggle-btn" id="video-audio-r-toggle">Video & Audio Record</div>';
//echo '<div class="add-box" style="margin-top:0"><input type="checkbox" class="toggle-btn">Screen & Audio Record</div>';

echo '<div class="add-box" id="record-btn"><svg viewBox="0 0 32 32">
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
			              </svg> Record</div>';

			     echo '</div>';
} else {
echo '<!-- list of all available broadcasting rooms -->
          <table style="display:none" id="rooms-list"></table>';

			     echo '<div class="options session-options">';

			     

			     echo '<div class="add-box" id="live-whiteboard-box" style="justify-content:center"><img src="/images/background/whiteboard-sharing.svg" style="height:28px;width:28px;margin-right:8px;"> Live Whiteboard</div>';
			     echo '<div class="add-box" id="student-screen" style="justify-content:center"><img src="/images/background/screen-sharing.svg" style="height:28px;width:28px;margin-right:8px;"> Live Screen</div>';
			     


			     

			     echo '</div>';
}

echo '<div class="sessions">';
?>


<div class="tabs">
  <div class="tab active-tab" style="border-radius:20px 0 0 0;" id="users-tab"><h3>Online(<span id="online-num"></span>)</h3></div>
  <div class="tab" style="border-radius:0 0 0 0;" id="chat-tab"><h3>Chat</h3></div>
  <div class="tab" style="border-radius:0 0 0 0;" id="file-tab"><h3>Files(<span id="filesNum"></span>)</h3></div>
  <div class="tab" style="border-radius:0 20px 0 0;" id="sessions-tab"><h3>Sessions</h3></div>

</div>




<?php
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
 ?>
</div> <!-- sess-list -->


<!-- CHAT -->
<div class="chat-list" style="display:none">
  <input name="msgBody" type="text" id="chatInput" class="txt-input" placeholder="Type here">
  <div class="msgs" id="newMsgs"></div>
</div>

<!-- ONLINE LIST -->
<div class="online-list"></div>


<!-- FILES -->
<div class="file-list" style="display:none">
<?php if($user_type=='instructor') { ?>
    <form method="POST" id="fileForm" enctype="multipart/form-data" action="/php/upload_class_file.php">
    
    <input name="classId" type="hidden" value="<?php echo $class_id?>">
    
    <input type="file" name="class_file" id="fileToUpload">
    <p id="uploadMsg" style="display:none">Uploaded. You can upload another now.</p>
    <input type="submit" value="Upload file" class="submit-btn">
    </form>

<iframe name="hidden-del" style="display:none"></iframe>
    <?php } ?>
<div id="newFiles"></div>

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
document.getElementById('setup-new-broadcast').onclick = function() {

                var config = {
                    openSocket: function(config) {
                        var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';

                        config.channel = config.channel || location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
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
                        tr.innerHTML = '<td><strong>' + room.roomName + '</strong> is live now!</td>' +
                            '<td><button class="join btn" id="join-btn">Join</button></td>';
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

			$('#join-img').hide();
			$('#join-p').hide();
			$('#join-img').click();
			

			
                    },
                    onNewParticipant: function(numberOfViewers) {
                        document.title = 'fxUniversity Viewers:' + numberOfViewers;
                    },
                    onReady: function() {
                        console.log('now you can open or join rooms');
                    }
                };

                function setupNewBroadcastButtonClickHandler() {
                    document.getElementById('broadcast-name').disabled = true;
                    document.getElementById('setup-new-broadcast').disabled = true;

		     // $('#before-stream-start').toggle();
 // $('#after-stream-start').toggle();

                    document.getElementById('broadcast-name').value='<?php echo $header ?>';
                    DetectRTC.load(function() {
                        captureUserMedia(function() {
                            var shared = 'video';
                            if (window.option == 'Only Audio') {
                                shared = 'audio';
                            }
                            if (window.option == 'Screen') {
                                shared = 'screen';
                            }

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


		    getUserMedia(function(video_stream) {
                    updateFakeVideo(video_stream);

                    if(!!navigator.getDisplayMedia) {
                        navigator.getDisplayMedia({
                            video: true
                        }).then(screen_stream => {
                            updateFakeVideo(screen_stream);
                            offererPeer(video_stream, screen_stream);

                            addStreamStopListener(screen_stream, function() {
                                onScreenEnded(video_stream, screen_stream);
                            });
                        }, error => {
                            console.error(error);
                            offererPeer(video_stream);
                        });

                        return;
                    }

                    getScreenStream(function(screen_stream) {
                        updateFakeVideo(screen_stream);
                        offererPeer(video_stream, screen_stream);

                        addStreamStopListener(screen_stream, function() {
                            onScreenEnded(video_stream, screen_stream);
                        });
                    }, function(error) {
                        console.error(error);
                        offererPeer(video_stream);
                    });
                });



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
                        htmlElement.setAttributeNode(document.createAttribute('controls'));
			htmlElement.setAttribute('id', 'video-broadcast');
                    } catch (e) {
                        htmlElement.setAttribute('autoplay', true);
                        htmlElement.setAttribute('playsinline', true);
                        htmlElement.setAttribute('controls', true);
			
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
                var videosContainer = document.getElementById("videos-container") || document.body;
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
                    video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
                    setTimeout(function() {
                        video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
                    }, 1000);
                }





}
            </script>
                <script>
		jQuery(function() {
		jQuery('#setup-new-broadcast').click();
		});
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
  }, 2000);
});
    
</script>

<!-- FILES -->
<script>
/*$(document).ready(function() {
    setInterval(function() {         
        $('#filesNum').load('/php/class_file_update.php', {class_id: <?php echo $class_id ?>, user_type: '<?php echo $user_type ?>'});
    }, 1000);
});*/
</script>

<!-- TABS -->
<script>
$('#sessions-tab').click(function() {
  $('#sessions-tab').addClass('active-tab');
  $('#chat-tab').removeClass('active-tab');
  $('#users-tab').removeClass('active-tab');
  $('#file-tab').removeClass('active-tab');
  $('.file-list').hide();
  $('.sess-list').show();
  $('.chat-list').hide();
  $('.online-list').hide();
});
$('#chat-tab').click(function() {
  $('#sessions-tab').removeClass('active-tab');
  $('#chat-tab').addClass('active-tab');
  $('#users-tab').removeClass('active-tab');
  $('#file-tab').removeClass('active-tab');
  $('.file-list').hide();
  $('.sess-list').hide();
  $('.chat-list').show();
  $('.online-list').hide();
});
$('#users-tab').click(function() {
  $('#sessions-tab').removeClass('active-tab');
  $('#chat-tab').removeClass('active-tab');
  $('#users-tab').addClass('active-tab');
  $('#file-tab').removeClass('active-tab');
  $('.file-list').hide();
  $('.sess-list').hide();
  $('.chat-list').hide();
  $('.online-list').show();
});
$('#file-tab').click(function() {
  $('#sessions-tab').removeClass('active-tab');
  $('#chat-tab').removeClass('active-tab');
  $('#users-tab').removeClass('active-tab');
  $('#file-tab').addClass('active-tab');
  $('.file-list').show();
  $('.sess-list').hide();
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
</script>
<script>
$(document).ready(function() {
    
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

<script>
$('#join-img').click(function() {
  $('#join-btn').click();


  $('#join-img').css({'opacity':'0.6', 'cursor':'not-allowed'});
  $('#join-p').html('You are watching live session.');
});
</script>


<!-- FILES -->
<script>
$(document).ready(function() {
    setInterval(function() {
        $('#newFiles').load('/php/class_file_update.php', {class_id: <?php echo $class_id ?>, user_type: '<?php echo $user_type ?>'});
	$('#filesNum').html($('#getFilesNum').text());
    }, 1000);
});
</script>
<!-- FILE UPLOAD -->
<script>
$(function() {
$('#fileForm').ajaxForm(function(response) {
  //console.log('file is uploaded');
  $('#fileToUpload').val('');
  $('#uploadMsg').show();
  setTimeout(function() {
    $('#uploadMsg').hide();
  }, 5000);
});
});
</script>

<script>
$('#video-audio-b-toggle').change(function() {
  if(this.checked) {
    $('#broadcasting-option #audio-video-b').attr('selected','selected');
    $('#setup-new-broadcast').click();
  } else if(!this.checked) {
      var streamingVid = document.getElementById('video-broadcast');

      
      const stream = streamingVid.srcObject;
      const tracks = stream.getTracks();

      tracks.forEach(function(track) {
       track.stop();
      });
  
 
    console.log('video stream stopped');
    $('.ins-vid-cnt #video-broadcast').remove();
  }
});

$('#audio-b-toggle').change(function() {
  if(this.checked) {
    $('#broadcasting-option #audio-b').attr('selected','selected');
    $('#setup-new-broadcast').click();
  } else if(!this.checked) {
    var streamingAudio = document.getElementById('live-session').querySelector('audio');
    const stream = streamingAudio.srcObject;
    const tracks = stream.getTracks();

    tracks.forEach(function(track) {
      track.stop();
    });
    $('.ins-vid-cnt #video-broadcast').remove();
  }
});

$('#screen-b-toggle').change(function() {
  if(this.checked) {
    //$('#share-screen').click();
    $('#live-screen').submit();
  } else if(!this.checked) {
      var streamingScr = document.getElementById('screen-broadcast');

      const stream = streamingScr.srcObject;
      const tracks = stream.getTracks();

      tracks.forEach(function(track) {
       track.stop();
      });

    $('.ins-vid-cnt #screen-broadcast').remove();
  }
});

$('#record-btn').click(function() {
  var left = ($(window).width()/2)-(900/2);
  var top = ($(window).width()/2)-(600/2);
  window.open("/userpgs/instructor/class/RecordRTC/?classId="+<?php echo $class_id?>, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top="+top+",left="+left+",width=900,height=600"); 
});
</script>



<!-- STUDENT ADD BOXES -->
<script>
$('#student-screen').click(function() {
  $('#live-screen').submit();
});
</script>

</body>
</html>