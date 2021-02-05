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
    
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="../DetectRTC/DetectRTC.js"></script>
    <script src="../js/socket.io.js"> </script>
    <script src="../js/adapter-latest.js"></script>
    <script src="/js/webrtc/IceServersHandler.js"></script>
    <script src="../js/CodecsHandler.js"></script>
    <script src="../RTCPeerConnection/RTCPeerConnection-v1.5.js"> </script>
    <script src="../webrtc-broadcasting/broadcast.js"> </script>
    <script src="../RecordRTC/RecordRTC.js"></script>
    <script src="../js/gif-recorder.js"></script>
    <script src="../getScreenId.js/getScreenId.js"></script>
    <script src="../Chrome-Extensions/Screen-Capturing.js/Screen-Capturing.js"></script>

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
	  <!-- VIDEO -->
	  <?php if($user_type=='instructor') { ?>
	  <div class="video-holder" id="live-session">
	   <div id="videos-container"></div>
	   <div class="ctrl">
	                  <div class="ctrl-row" id="before-stream-start"><strong>Start Broadcast: </strong>
			       <select id="broadcasting-option" class="select-input">
			         <option>Audio + Video</option>
				 <option>Only Audio</option>
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


	   </div>
	  </div>

<div class="video-holder" id="live-session">
	   
	      <div class="recordrtc">

<div class="videos-container">
<video controls playsinline autoplay muted=false volume=1 id="recordVid" style="display:none"></video>
</div>
<div class="ctrl">
<div class="ctrl-row">
	      <strong id="start-record-stop">Start Record: </strong>

	      


        <select class="recording-media select-input" id="record-inputs">
         <option value="record-screen">Screen</option>
         <option value="record-video">Video</option>
         <option value="record-audio">Audio</option>
        </select>

    <select class="media-container-format" style="display:none">
      <option>WebM</option>
      <option>Mp4</option>
      <option>WAV</option>
      <option>Ogg</option>
      <option>Gif</option>
    </select><br>
    <img src="/images/background/record.png" style="opacity:1" id="recordImg">
    <button class="btn" id="recordBtn" style="display:none">Start Recording</button>

    <div style="text-align: center; display: none;">
      <button id="save-to-disk" class="submit-btn">Download</button>
      <button id="open-new-tab" class="submit-btn">Open in New Tab</button>
      <button id="upload-to-server" class="submit-btn">Upload to Session</button>
    </div>


</div>
<p id="chrome-record-warning" style="display:none;text-align:center;">Since you are using Chrome, you need to install and use <a href="https://chrome.google.com/webstore/detail/screen-recorder/hniebljpgcogalllopnjokppmgbhaden" target="_blank">This Extension</a> for recording, or switch to another browser.</p>

	      </div>

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


<?php } ?>


    





	

<?php
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

			     

			     echo '<div class="add-box" id="live-whiteboard-box">Live Whiteboard </div>';


			     

			     echo '</div>';
} else {
echo '<!-- list of all available broadcasting rooms -->
          <table style="display:none" id="rooms-list"></table>';

			     echo '<div class="options session-learn-options">';

			     

			     echo '<div class="add-box" id="live-whiteboard-box">Live Whiteboard</div>';


			     

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

			$('#join-img').css({'opacity':'1', 'cursor':'pointer'});
			$('#join-p').html('<b>We are live! Watch now:</b>');
			

			
                    },
                    onNewParticipant: function(numberOfViewers) {
                        document.title = 'Viewers: ' + numberOfViewers;
                    },
                    onReady: function() {
                        console.log('now you can open or join rooms');
                    }
                };

                function setupNewBroadcastButtonClickHandler() {
                    document.getElementById('broadcast-name').disabled = true;
                    document.getElementById('setup-new-broadcast').disabled = true;

		    $('#before-stream-start').toggle();
$('#after-stream-start').toggle();

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


<script>
$('#pause').click(function() {
var streamingVid = document.querySelector('video');
if(streamingVid.paused==false) {
  streamingVid.pause();
} else {
  streamingVid.play();
}
});
</script>

<script>
$('#stop').click(function() {
var streamingVid = document.querySelector('video');

const stream = streamingVid.srcObject;
const tracks = stream.getTracks();

tracks.forEach(function(track) {
track.stop();
});

console.log('video stream stopped');
});
</script>

                    <!-- EO WebRTC Broadcasting -->





<!-- RECORD RTC -->

<script>
            (function() {
                var params = {},
                    r = /([^&=]+)=?([^&]*)/g;

                function d(s) {
                    return decodeURIComponent(s.replace(/\+/g, ' '));
                }

                var match, search = window.location.search;
                while (match = r.exec(search.substring(1))) {
                    params[d(match[1])] = d(match[2]);

                    if(d(match[2]) === 'true' || d(match[2]) === 'false') {
                        params[d(match[1])] = d(match[2]) === 'true' ? true : false;
                    }
                }

                window.params = params;
            })();
        </script>

        <script>
            var recordingDIV = document.querySelector('.recordrtc');
            var recordingMedia = recordingDIV.querySelector('.recording-media');
            var recordingPlayer = recordingDIV.querySelector('video');
            var mediaContainerFormat = recordingDIV.querySelector('.media-container-format');

            recordingDIV.querySelector('button').onclick = function() {

	    						 

                var button = this;

                if(button.innerHTML === 'Stop Recording') {
                    button.disabled = true;
                    button.disableStateWaiting = true;
                    setTimeout(function() {
                        button.disabled = false;
                        button.disableStateWaiting = false;
                    }, 2 * 1000);

                    button.innerHTML = 'Start Recording';

                    function stopStream() {
                        if(button.stream && button.stream.stop) {
                            button.stream.stop();
                            button.stream = null;
                        }
                    }

                    if(button.recordRTC) {
                        if(button.recordRTC.length) {
                            button.recordRTC[0].stopRecording(function(url) {
                                if(!button.recordRTC[1]) {
                                    button.recordingEndedCallback(url);
                                    stopStream();

                                    saveToDiskOrOpenNewTab(button.recordRTC[0]);
                                    return;
                                }

                                button.recordRTC[1].stopRecording(function(url) {
                                    button.recordingEndedCallback(url);
                                    stopStream();
                                });
                            });
                        }
                        else {
                            button.recordRTC.stopRecording(function(url) {
                                button.recordingEndedCallback(url);
                                stopStream();

                                saveToDiskOrOpenNewTab(button.recordRTC);
                            });
                        }
                    }

                    return;
                }

                button.disabled = true;

                var commonConfig = {
                    onMediaCaptured: function(stream) {
                        button.stream = stream;
                        if(button.mediaCapturedCallback) {
                            button.mediaCapturedCallback();
                        }

                        button.innerHTML = 'Stop Recording';
                        button.disabled = false;
                    },
                    onMediaStopped: function() {
                        button.innerHTML = 'Start Recording';

                        if(!button.disableStateWaiting) {
                            button.disabled = false;
                        }
                    },
                    onMediaCapturingFailed: function(error) {
                        if(error.name === 'PermissionDeniedError' && !!navigator.mozGetUserMedia) {
                            InstallTrigger.install({
                                'Foo': {
                                    // https://addons.mozilla.org/firefox/downloads/latest/655146/addon-655146-latest.xpi?src=dp-btn-primary
                                    URL: 'https://addons.mozilla.org/en-US/firefox/addon/enable-screen-capturing/',
                                    toString: function () {
                                        return this.URL;
                                    }
                                }
                            });
                        }

                        commonConfig.onMediaStopped();
                    }
                };

                if(recordingMedia.value === 'record-video') {
                    captureVideo(commonConfig);

                    button.mediaCapturedCallback = function() {
                        button.recordRTC = RecordRTC(button.stream, {
                            type: mediaContainerFormat.value === 'Gif' ? 'gif' : 'video',
                            disableLogs: params.disableLogs || false,
                            canvas: {
                                width: params.canvas_width || 320,
                                height: params.canvas_height || 240
                            },
                            frameInterval: typeof params.frameInterval !== 'undefined' ? parseInt(params.frameInterval) : 20 // minimum time between pushing frames to Whammy (in milliseconds)
                        });

                        button.recordingEndedCallback = function(url) {
                            recordingPlayer.src = null;
                            recordingPlayer.srcObject = null;

                            if(mediaContainerFormat.value === 'Gif') {
                                recordingPlayer.pause();
                                recordingPlayer.poster = url;

                                recordingPlayer.onended = function() {
                                    recordingPlayer.pause();
                                    recordingPlayer.poster = URL.createObjectURL(button.recordRTC.blob);
                                };
                                return;
                            }

                            recordingPlayer.src = url;

                            recordingPlayer.onended = function() {
                                recordingPlayer.pause();
                                recordingPlayer.src = URL.createObjectURL(button.recordRTC.blob);
                            };
                        };

                        button.recordRTC.startRecording();
                    };
                }

                if(recordingMedia.value === 'record-audio') {
                    captureAudio(commonConfig);

                    button.mediaCapturedCallback = function() {
                        button.recordRTC = RecordRTC(button.stream, {
                            type: 'audio',
                            bufferSize: typeof params.bufferSize == 'undefined' ? 0 : parseInt(params.bufferSize),
                            sampleRate: typeof params.sampleRate == 'undefined' ? 44100 : parseInt(params.sampleRate),
                            leftChannel: params.leftChannel || false,
                            disableLogs: params.disableLogs || false,
                            recorderType: DetectRTC.browser.name === 'Edge' ? StereoAudioRecorder : null
                        });

                        button.recordingEndedCallback = function(url) {
                            var audio = new Audio();
                            audio.src = url;
                            audio.controls = true;
                            recordingPlayer.parentNode.appendChild(document.createElement('hr'));
                            recordingPlayer.parentNode.appendChild(audio);

                            if(audio.paused) audio.play();

                            audio.onended = function() {
                                audio.pause();
                                audio.src = URL.createObjectURL(button.recordRTC.blob);
                            };
                        };

                        button.recordRTC.startRecording();
                    };
                }

                if(recordingMedia.value === 'record-audio-plus-video') {
                    captureAudioPlusVideo(commonConfig);

                    button.mediaCapturedCallback = function() {

                        if(DetectRTC.browser.name !== 'Firefox') { // opera or chrome etc.
                            button.recordRTC = [];

                            if(!params.bufferSize) {
                                // it fixes audio issues whilst recording 720p
                                params.bufferSize = 16384;
                            }

                            var audioRecorder = RecordRTC(button.stream, {
                                type: 'audio',
                                bufferSize: typeof params.bufferSize == 'undefined' ? 0 : parseInt(params.bufferSize),
                                sampleRate: typeof params.sampleRate == 'undefined' ? 44100 : parseInt(params.sampleRate),
                                leftChannel: params.leftChannel || false,
                                disableLogs: params.disableLogs || false,
                                recorderType: DetectRTC.browser.name === 'Edge' ? StereoAudioRecorder : null
                            });

                            var videoRecorder = RecordRTC(button.stream, {
                                type: 'video',
                                disableLogs: params.disableLogs || false,
                                canvas: {
                                    width: params.canvas_width || 320,
                                    height: params.canvas_height || 240
                                },
                                frameInterval: typeof params.frameInterval !== 'undefined' ? parseInt(params.frameInterval) : 20 // minimum time between pushing frames to Whammy (in milliseconds)
                            });

                            // to sync audio/video playbacks in browser!
                            videoRecorder.initRecorder(function() {
                                audioRecorder.initRecorder(function() {
                                    audioRecorder.startRecording();
                                    videoRecorder.startRecording();
                                });
                            });

                            button.recordRTC.push(audioRecorder, videoRecorder);

                            button.recordingEndedCallback = function() {
                                var audio = new Audio();
                                audio.src = audioRecorder.toURL();
                                audio.controls = true;
                                audio.autoplay = true;

                                audio.onloadedmetadata = function() {
                                    recordingPlayer.src = videoRecorder.toURL();
                                };

                                recordingPlayer.parentNode.appendChild(document.createElement('hr'));
                                recordingPlayer.parentNode.appendChild(audio);

                                if(audio.paused) audio.play();
                            };
                            return;
                        }

                        button.recordRTC = RecordRTC(button.stream, {
                            type: 'video',
                            disableLogs: params.disableLogs || false,
                            // we can't pass bitrates or framerates here
                            // Firefox MediaRecorder API lakes these features
                        });

                        button.recordingEndedCallback = function(url) {
                            recordingPlayer.srcObject = null;
                            recordingPlayer.muted = false;
                            recordingPlayer.src = url;

                            recordingPlayer.onended = function() {
                                recordingPlayer.pause();
                                recordingPlayer.src = URL.createObjectURL(button.recordRTC.blob);
                            };
                        };

                        button.recordRTC.startRecording();
                    };
                }

                if(recordingMedia.value === 'record-screen') {
                    captureScreen(commonConfig);

                    button.mediaCapturedCallback = function() {
                        button.recordRTC = RecordRTC(button.stream, {
                            type: mediaContainerFormat.value === 'Gif' ? 'gif' : 'video',
                            disableLogs: params.disableLogs || false,
                            canvas: {
                                width: params.canvas_width || 320,
                                height: params.canvas_height || 240
                            }
                        });

                        button.recordingEndedCallback = function(url) {
                            recordingPlayer.src = null;
                            recordingPlayer.srcObject = null;

                            if(mediaContainerFormat.value === 'Gif') {
                                recordingPlayer.pause();
                                recordingPlayer.poster = url;
                                recordingPlayer.onended = function() {
                                    recordingPlayer.pause();
                                    recordingPlayer.poster = URL.createObjectURL(button.recordRTC.blob);
                                };
                                return;
                            }

                            recordingPlayer.src = url;
                        };

                        button.recordRTC.startRecording();
                    };
                }

                if(recordingMedia.value === 'record-audio-plus-screen') {
                    captureAudioPlusScreen(commonConfig);

                    button.mediaCapturedCallback = function() {
                        button.recordRTC = RecordRTC(button.stream, {
                            type: 'video',
                            disableLogs: params.disableLogs || false,
                            // we can't pass bitrates or framerates here
                            // Firefox MediaRecorder API lakes these features
                        });

                        button.recordingEndedCallback = function(url) {
                            recordingPlayer.srcObject = null;
                            recordingPlayer.muted = false;
                            recordingPlayer.src = url;

                            recordingPlayer.onended = function() {
                                recordingPlayer.pause();
                                recordingPlayer.src = URL.createObjectURL(button.recordRTC.blob);
                            };
                        };

                        button.recordRTC.startRecording();
                    };
                }
            };

            function captureVideo(config) {
                captureUserMedia({video: true}, function(videoStream) {
                    recordingPlayer.srcObject = videoStream;

                    config.onMediaCaptured(videoStream);

                    videoStream.onended = function() {
                        config.onMediaStopped();
                    };
                }, function(error) {
                    config.onMediaCapturingFailed(error);
                });
            }

            function captureAudio(config) {
                captureUserMedia({audio: true}, function(audioStream) {
                    recordingPlayer.srcObject = audioStream;

                    config.onMediaCaptured(audioStream);

                    audioStream.onended = function() {
                        config.onMediaStopped();
                    };
                }, function(error) {
                    config.onMediaCapturingFailed(error);
                });
            }

            function captureAudioPlusVideo(config) {
                captureUserMedia({video: true, audio: true}, function(audioVideoStream) {
                    recordingPlayer.srcObject = audioVideoStream;

                    config.onMediaCaptured(audioVideoStream);

                    audioVideoStream.onended = function() {
                        config.onMediaStopped();
                    };
                }, function(error) {
                    config.onMediaCapturingFailed(error);
                });
            }

            function captureScreen(config) {
                getScreenId(function(error, sourceId, screenConstraints) {
		    console.log(error);
		    
                    if (error === 'not-installed') {
		    
		    
			if(confirm('You need to install an extension to be able to record on this browser. Go to the extension page?')) {
			  window.open('https://chrome.google.com/webstore/detail/recordrtc/ndcljioonkecdnaaihodjgiliohngojp?hl=en');
			}
                    }

                    if (error === 'permission-denied') {
                        alert('Screen capturing permission is denied.');
                    }

                    if (error === 'installed-disabled') {
                        alert('Please enable chrome screen capturing extension.');
                    }

                    if(error) {
                        config.onMediaCapturingFailed(error);
                        return;
                    }
		    
                    captureUserMedia(screenConstraints, function(screenStream) {
                        recordingPlayer.srcObject = screenStream;

                        config.onMediaCaptured(screenStream);

                        screenStream.onended = function() {
                            config.onMediaStopped();
                        };
                    }, function(error) {
                        config.onMediaCapturingFailed(error);
                    });
                });
            }

            function captureAudioPlusScreen(config) {
                getScreenId(function(error, sourceId, screenConstraints) {
                    if (error === 'not-installed') {
                        document.write('<h1><a target="_blank" href="https://chrome.google.com/webstore/detail/screen-capturing/ajhifddimkapgcifgcodmmfdlknahffk">Please install this chrome extension then reload the page.</a></h1>');
                    }

                    if (error === 'permission-denied') {
                        alert('Screen capturing permission is denied.');
                    }

                    if (error === 'installed-disabled') {
                        alert('Please enable chrome screen capturing extension.');
                    }

                    if(error) {
                        config.onMediaCapturingFailed(error);
                        return;
                    }

                    screenConstraints.audio = true;

                    captureUserMedia(screenConstraints, function(screenStream) {
                        recordingPlayer.srcObject = screenStream;

                        config.onMediaCaptured(screenStream);

                        screenStream.onended = function() {
                            config.onMediaStopped();
                        };
                    }, function(error) {
                        config.onMediaCapturingFailed(error);
                    });
                });
            }

            function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
                navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
            }

            function setMediaContainerFormat(arrayOfOptionsSupported) {
                var options = Array.prototype.slice.call(
                    mediaContainerFormat.querySelectorAll('option')
                );

                var selectedItem;
                options.forEach(function(option) {
                    option.disabled = true;

                    if(arrayOfOptionsSupported.indexOf(option.value) !== -1) {
                        option.disabled = false;

                        if(!selectedItem) {
                            option.selected = true;
                            selectedItem = option;
                        }
                    }
                });
            }

            recordingMedia.onchange = function() {
                if(this.value === 'record-audio') {
                    setMediaContainerFormat(['WAV', 'Ogg']);
                    return;
                }
                setMediaContainerFormat(['WebM', /*'Mp4',*/ 'Gif']);
            };

            if(DetectRTC.browser.name === 'Edge') {
                // webp isn't supported in Microsoft Edge
                // neither MediaRecorder API
                // so lets disable both video/screen recording options

                console.warn('Neither MediaRecorder API nor webp is supported in Microsoft Edge. You cam merely record audio.');

                recordingMedia.innerHTML = '<option value="record-audio">Audio</option>';
                setMediaContainerFormat(['WAV']);
            }

            if(DetectRTC.browser.name === 'Firefox') {
                // Firefox implemented both MediaRecorder API as well as WebAudio API
                // Their MediaRecorder implementation supports both audio/video recording in single container format
                // Remember, we can't currently pass bit-rates or frame-rates values over MediaRecorder API (their implementation lakes these features)

                recordingMedia.innerHTML = '<option value="record-audio-plus-video">Audio+Video</option>'
                                            + '<option value="record-audio-plus-screen">Audio+Screen</option>'
                                            + recordingMedia.innerHTML;
            }

            // disabling this option because currently this demo
            // doesn't supports publishing two blobs.
            // todo: add support of uploading both WAV/WebM to server.
            if(false && DetectRTC.browser.name === 'Chrome') {
                recordingMedia.innerHTML = '<option value="record-audio-plus-video">Audio+Video</option>'
                                            + recordingMedia.innerHTML;
                console.info('This RecordRTC demo merely tries to playback recorded audio/video sync inside the browser. It still generates two separate files (WAV/WebM).');
            }

            var MY_DOMAIN = 'fxunivers.com';

            function isMyOwnDomain() {
                return document.domain.indexOf(MY_DOMAIN) !== -1;
            }

            function saveToDiskOrOpenNewTab(recordRTC) {
	        $('#recordImg').hide();
		$('#start-record-stop').hide();
                recordingDIV.querySelector('#save-to-disk').parentNode.style.display = 'block';
                recordingDIV.querySelector('#save-to-disk').onclick = function() {
                    if(!recordRTC) return alert('No recording found.');

                    recordRTC.save();
                };

                recordingDIV.querySelector('#open-new-tab').onclick = function() {
                    if(!recordRTC) return alert('No recording found.');

                    window.open(recordRTC.toURL());
                };

                if(isMyOwnDomain()) {
                    recordingDIV.querySelector('#upload-to-server').disabled = true;
                    recordingDIV.querySelector('#upload-to-server').style.display = 'none';
                }
                else {
                    recordingDIV.querySelector('#upload-to-server').disabled = false;
                }
                
                recordingDIV.querySelector('#upload-to-server').onclick = function() {
                    if(isMyOwnDomain()) {
                        alert('PHP Upload is not available on this domain.');
                        return;
                    }

                    if(!recordRTC) return alert('No recording found.');
                    this.disabled = true;

                    var button = this;
                    uploadToServer(recordRTC, function(progress, fileURL) {
                        if(progress === 'ended') {
                            button.disabled = false;
                            button.innerHTML = 'Download from fxUniversity';
                            button.onclick = function() {
                                window.open(fileURL);
                            };
                            return;
                        }
                        button.innerHTML = progress;
                    });
                };
            }

            var listOfFilesUploaded = [];

            function uploadToServer(recordRTC, callback) {
                var blob = recordRTC instanceof Blob ? recordRTC : recordRTC.blob;
                var fileType = blob.type.split('/')[0] || 'audio';
                var fileName = '<?php echo $class_id ?>'.replace('.', ''); //(Math.random() * 1000).toString()

                if (fileType === 'audio') {
                    fileName += '.' + (!!navigator.mozGetUserMedia ? 'ogg' : 'wav');
                } else {
                    fileName += '.webm';
                }

                // create FormData
                var formData = new FormData();
                formData.append(fileType + '-filename', fileName);
                formData.append(fileType + '-blob', blob);

                callback('Uploading ' + fileType + ' recording to server.');

                // var upload_url = 'https://your-domain.com/files-uploader/';
                var upload_url = 'save.php';

                // var upload_directory = upload_url;
                var upload_directory = '../videos/';

                makeXMLHttpRequest(upload_url, formData, function(progress) {
                    if (progress !== 'upload-ended') {
                        callback(progress);
                        return;
                    }

                    callback('ended', upload_directory + fileName);

                    // to make sure we can delete as soon as visitor leaves
                    listOfFilesUploaded.push(upload_directory + fileName);
                });
            }

            function makeXMLHttpRequest(url, data, callback) {
                var request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState == 4 && request.status == 200) {
                        callback('upload-ended');
                    }
                };

                request.upload.onloadstart = function() {
                    callback('Upload started...');
                };

                request.upload.onprogress = function(event) {
                    callback('Upload Progress ' + Math.round(event.loaded / event.total * 100) + "%");
                };

                request.upload.onload = function() {
                    callback('progress-about-to-end');
                };

                request.upload.onload = function() {
                    callback('progress-ended');
                };

                request.upload.onerror = function(error) {
                    callback('Failed to upload to server');
                    console.error('XMLHttpRequest failed', error);
                };

                request.upload.onabort = function(error) {
                    callback('Upload aborted.');
                    console.error('XMLHttpRequest aborted', error);
                };

                request.open('POST', url);
                request.send(data);
            }

            window.onbeforeunload = function() {
                recordingDIV.querySelector('button').disabled = false;
                recordingMedia.disabled = false;
                mediaContainerFormat.disabled = false;

                if(!listOfFilesUploaded.length) return;

                var delete_url = 'https://webrtcweb.com/f/delete.php';
                // var delete_url = 'RecordRTC-to-PHP/delete.php';

                listOfFilesUploaded.forEach(function(fileURL) {
                    var request = new XMLHttpRequest();
                    request.onreadystatechange = function() {
                        if (request.readyState == 4 && request.status == 200) {
                            if(this.responseText === ' problem deleting files.') {
                                alert('Failed to delete ' + fileURL + ' from the server.');
                                return;
                            }

                            listOfFilesUploaded = [];
                            alert('You can leave now. Your files are removed from the server.');
                        }
                    };
                    request.open('POST', delete_url);

                    var formData = new FormData();
                    formData.append('delete-file', fileURL.split('/').pop());
                    request.send(formData);
                });

                return 'Please wait few seconds before your recordings are deleted from the server.';
            };
            
        </script>

<script src="https://code.jquery.com/jquery-migrate-1.3.0.js"></script>
<script>
$('#recordImg').click(function() {
  if($.browser.chrome) {
    console.log('chrome');
    $('#chrome-record-warning').show();
  } else {
    $('#recordBtn').click();
    $('#recordImg').attr('src','/images/background/stop.svg');
    $('#recordVid').show();
    $('#record-inputs').hide();
    $('#start-record-stop').text('Stop Record: ');
  }
});
</script>
            <!-- EO RTC RECORD --> 


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

</body>
</html>