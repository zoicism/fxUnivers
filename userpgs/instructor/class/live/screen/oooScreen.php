<?php
session_start();                                                                                      
require_once($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');                                 
if(isset($_SESSION['username'])) {                                                                  
  $username = $_SESSION['username'];                                                                
} else {                                                                                             
  require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');                             
}

require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_user.php');
$id = $get_user_id;

if(isset($_GET['oooid'])) {
  $class_id=$_GET['oooid'];
}

if(isset($_GET['roomid'])) {
  $class_id=$_GET['roomid'];
}

$oneonone_enrolled_q = "SELECT * FROM stu_oneonone WHERE id = $class_id";
$oneonone_enrolled_r = mysqli_query($fxinstructor_connection, $oneonone_enrolled_q);
$oneonone_enrolled = mysqli_num_rows($oneonone_enrolled_r);
if($oneonone_enrolled) {
    $oneonone = mysqli_fetch_array($oneonone_enrolled_r);
    $student_id = $oneonone['student_id'];
    $instructor_id = $oneonone['instructor_id'];

    if($get_user_id == $instructor_id) {
	$user_type = 'instructor';
    } elseif($get_user_id == $student_id) {
	$user_type = 'student';
    } else {
	$user_type = 'other';
	exit();
    }
} else {
    exit();
}

/*
$class_query = "SELECT * FROM `class` WHERE id=$class_id";                                          
$class_result = mysqli_query($connection, $class_query) or die(mysqli_error($connection));           
$class_fetch = mysqli_fetch_array($class_result);                                               
$header = $class_fetch['title'];
$course_id = $class_fetch['course_id'];
$get_course_teacher_id=$class_fetch['teacher_id'];
*/



  /*
session_start();
require('../../../../../register/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

if(isset($_POST['course_id']))
    $course_id=$_POST['course_id'];


require('../../../../../php/get_user.php');
$id = $get_user_id;

require('../../../../php/notif.php');

if(isset($_POST['class_id']))
    $class_id = $_POST['class_id'];

$class_query = "SELECT * FROM `class` WHERE id=$class_id";
$class_result = mysqli_query($connection, $class_query) or die(mysqli_error($connection));
$class_fetch = mysqli_fetch_array($class_result);

$header = $class_fetch['title'];
$description = $class_fetch['body'];
$video = $class_fetch['video'];

$tar_id=$class_fetch['teacher_id'];
require('../../../../../php/get_tar_id.php');


require('../../../php/classes.php');

require('../../../../../php/get_course.php');

require('../../../../../php/get_user_type.php');


function randHash($len) {
    return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
}

require('../../../../../contact/message_connect.php');
if($user_type=='instructor') {
    
    $liveClassId = randHash(32);
    //require('../../../../../php/create_live_class.php');
} elseif($user_type=='student') {
    require('../../../../../php/join_live_class.php');
    $liveClassId = $join_live_class_roomid;
} else {
    header('Location: /userpgs/instructor/course_management/course.php?course_id='.$course_id);
}

//require('../../php/notify_students.php');

//require('../../../../../php/get_class_chat.php');
*/

?>

<!DOCTYPE html>
<html>
    <head>
	<title>1-on-1 Screen fxUniversity</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/icons.css">
	<link rel="stylesheet" href="/css/logo.css">

	<script src="/js/jquery-3.4.1.min.js"></script>

	<script src="RTCMultiConnection.js"></script>
	<script src="adapter.js"></script>
	<script src="https://rtcmulticonnection.herokuapp.com/socket.io/socket.io.js"></script>

<link rel="stylesheet" href="getHTMLMediaElement.css">
<script src="getHTMLMediaElement.js"></script>

    </head>
    <body>
	
	<article style="padding:20px;background:white;border: 1px solid black;margin:20px;">

	    <section class="experiment" style="flex-flow:column">
<div style="display:none">
		<input type="text" id="room-id" value="<?php echo $oooid?>">
		<button id="open-room">Open Room</button>
		<button id="join-room">Join Room</button>
		<button id="open-or-join-room">Auto Open Or Join Room</button>
</div>
      <h3 style="text-align:center">fxUniversity 1-on-1 Live Screen Sharing</h3>
<section class="hide-after-join" style="text-align: center;">
  <?php if($user_type=='instructor') echo '<button id="share-screen" style="background-color:transparent" class="submit-btn">Start Screen Sharing</button>'; else echo '<p id="share-screen-p">Instructor\'s screen will appear here.</p>';?>
</section>
		
		<div class="video-holder" style="width:100%;display: flex;align-content: center;justify-content: center;"><div id="videos-container" style="width:60%;"></div></div>
		
		<div id="room-urls" style="text-align: center;display: none;background: #F1EDED;margin: 15px -10px; display:none; border: 1px solid rgb(189, 189, 189);border-left: 0;border-right: 0;"></div>
	    </section>
	    
	</article>



	<script>
	 //document.getElementById('room-id').value = <?php echo $class_id?>;
	 //$('#room-id').val('<?php echo $class_id?>');
	 // ......................................................
	 // .......................UI Code........................
	 // ......................................................
	 document.getElementById('open-room').onclick = function() {
	     disableInputButtons();
	     
	     connection.open(document.getElementById('room-id').value, function() {
		 showRoomURL(connection.sessionid);
	     });
	 };

	 document.getElementById('join-room').onclick = function() {
	     disableInputButtons();

	     connection.sdpConstraints.mandatory = {
		 OfferToReceiveAudio: false,
		 OfferToReceiveVideo: true
	     };
	     connection.join(document.getElementById('room-id').value);
	 };

	 document.getElementById('open-or-join-room').onclick = function() {
	     disableInputButtons();
	     connection.openOrJoin(document.getElementById('room-id').value, function(isRoomExist, roomid) {
		 if (isRoomExist === false && connection.isInitiator === true) {
		     // if room doesn't exist, it means that current user will create the room
		     showRoomURL(roomid);
		 }

		 if(isRoomExist) {
		     connection.sdpConstraints.mandatory = {
			 OfferToReceiveAudio: false,
			 OfferToReceiveVideo: true
		     };
		 }
	     });
	 };

	 // ......................................................
	 // ..................RTCMultiConnection Code.............
	 // ......................................................

	 var connection = new RTCMultiConnection();

	 // for future when we move to pro plan
	 //connection.socketURL = '/';

	 // for present that we're in business plan
	 connection.socketURL = 'https://rtcmulticonnection.herokuapp.com:443/';
	 

	 connection.socketMessageEvent = 'screen-sharing-demo';

	 connection.session = {
	     screen: true,
	     oneway: true
	 };

	 connection.sdpConstraints.mandatory = {
	     OfferToReceiveAudio: false,
	     OfferToReceiveVideo: false
	 };

	 
	 connection.iceServers = [{
	     urls: [ "stun:bn-turn1.xirsys.com" ]
	 }, {
	     username: "AjuWvVG9wbM-MiqNz1yQgYNCw7jBV3hTB04NFwvA5kbGXIlfbyeftBKwFF-7uXhAAAAAAGBPn75uZW9hYnJhbXNvbg==",
	     credential: "bc17da7c-85b7-11eb-8270-0242ac140004",
	     urls: [
		 "turn:bn-turn1.xirsys.com:80?transport=udp",
		 "turn:bn-turn1.xirsys.com:3478?transport=udp",
		 "turn:bn-turn1.xirsys.com:80?transport=tcp",
		 "turn:bn-turn1.xirsys.com:3478?transport=tcp",
		 "turns:bn-turn1.xirsys.com:443?transport=tcp",
		 "turns:bn-turn1.xirsys.com:5349?transport=tcp"
	     ]
	 }];
	 /* {
	    urls: [ "stun:us-turn7.xirsys.com" ]
	    }, {
	    username: "ZiJmpu-hb2bdcYNCYsHWWsMz8fbwz1WURpyTZkeJbfHTEygu9mT1jm_PFyJGd3p7AAAAAF__NwtuZW9hYnJhbXNvbg==",
	    credential: "4c22cbfe-55ca-11eb-8e94-0242ac140004",
	    urls: [
	    "turn:us-turn7.xirsys.com:80?transport=udp",
	    "turn:us-turn7.xirsys.com:3478?transport=udp",
	    "turn:us-turn7.xirsys.com:80?transport=tcp",
	    "turn:us-turn7.xirsys.com:3478?transport=tcp",
	    "turns:us-turn7.xirsys.com:443?transport=tcp",
	    "turns:us-turn7.xirsys.com:5349?transport=tcp"
	    ]
	    }];
	  */

	 /*{
	    'urls': [
            'stun:stun.l.google.com:19302',
            'stun:stun1.l.google.com:19302',
            'stun:stun2.l.google.com:19302',
            'stun:stun.l.google.com:19302?transport=udp',
	    ]
	    }];*/

	 connection.videosContainer = document.getElementById('videos-container');
	 connection.onstream = function(event) {
	     var existing = document.getElementById(event.streamid);
	     if(existing && existing.parentNode) {
		 existing.parentNode.removeChild(existing);
	     }

	     event.mediaElement.removeAttribute('src');
	     event.mediaElement.removeAttribute('srcObject');
	     event.mediaElement.muted = true;
	     event.mediaElement.volume = 0;

	     var video = document.createElement('video');

	     try {
		 video.setAttributeNode(document.createAttribute('autoplay'));
		 video.setAttributeNode(document.createAttribute('playsinline'));
	     } catch (e) {
		 video.setAttribute('autoplay', true);
		 video.setAttribute('playsinline', true);
	     }

	     if(event.type === 'local') {
		 video.volume = 0;
		 try {
		     video.setAttributeNode(document.createAttribute('muted'));
		 } catch (e) {
		     video.setAttribute('muted', true);
		 }
	     }
	     video.srcObject = event.stream;

	     var width = innerWidth - 80;
	     var mediaElement = getHTMLMediaElement(video, {
		 //title: event.userid,
		 //buttons: ['full-screen'],
		 width: width,
		 showOnMouseEnter: false
	     });

	     connection.videosContainer.appendChild(video);

	     setTimeout(function() {
		 mediaElement.media.play();
	     }, 5000);

	     mediaElement.id = event.streamid;
	 };

	 connection.onstreamended = function(event) {
	     var mediaElement = document.getElementById(event.streamid);
	     if (mediaElement) {
		 mediaElement.parentNode.removeChild(mediaElement);

		 if(event.userid === connection.sessionid && !connection.isInitiator) {
		     alert('Broadcast is ended. We will reload this page to clear the cache.');
		     location.reload();
		 }
	     }
	 };

	 connection.onMediaError = function(e) {
	     if (e.message === 'Concurrent mic process limit.') {
		 if (DetectRTC.audioInputDevices.length <= 1) {
		     alert('Please select external microphone. Check github issue number 483.');
		     return;
		 }

		 var secondaryMic = DetectRTC.audioInputDevices[1].deviceId;
		 connection.mediaConstraints.audio = {
		     deviceId: secondaryMic
		 };

		 connection.join(connection.sessionid);
	     }
	 };

	 // ..................................
	 // ALL below scripts are redundant!!!
	 // ..................................

	 function disableInputButtons() {
	     document.getElementById('room-id').onkeyup();

	     document.getElementById('open-or-join-room').disabled = true;
	     document.getElementById('open-room').disabled = true;
	     document.getElementById('join-room').disabled = true;
	     document.getElementById('room-id').disabled = true;
	 }

	 // ......................................................
	 // ......................Handling Room-ID................
	 // ......................................................

	 function showRoomURL(roomid) {
	     var roomHashURL = '#' + roomid;
	     var roomQueryStringURL = '?roomid=' + roomid;

	     var html = '<h2>Unique URL for your room:</h2><br>';

	     //html += 'Hash URL: <a href="' + roomHashURL + '" target="_blank">' + roomHashURL + '</a>';
	     //html += '<br>';
	     //html += 'QueryString URL: <a href="' + roomQueryStringURL + '" target="_blank">' + roomQueryStringURL + '</a>';

	     var roomURLsDiv = document.getElementById('room-urls');
	     //roomURLsDiv.innerHTML = html;

	     //roomURLsDiv.style.display = 'block';
	 }

	 (function() {
	     var params = {},
		 r = /([^&=]+)=?([^&]*)/g;

	     function d(s) {
		 return decodeURIComponent(s.replace(/\+/g, ' '));
	     }
	     var match, search = window.location.search;
	     while (match = r.exec(search.substring(1)))
		 params[d(match[1])] = d(match[2]);
	     window.params = params;
	 })();

	 var roomid = '';
	 if (localStorage.getItem(connection.socketMessageEvent)) {
	     roomid = localStorage.getItem(connection.socketMessageEvent);
	 } else {
	     roomid = connection.token();
	 }
	 document.getElementById('room-id').value = roomid;
	 document.getElementById('room-id').onkeyup = function() {
	     localStorage.setItem(connection.socketMessageEvent, document.getElementById('room-id').value);
	 };

	 var hashString = location.hash.replace('#', '');
	 if (hashString.length && hashString.indexOf('comment-') == 0) {
	     hashString = '';
	 }

	 var roomid = params.roomid;
	 if (!roomid && hashString.length) {
	     roomid = hashString;
	 }

	 if (roomid && roomid.length) {
	     document.getElementById('room-id').value = roomid;
	     localStorage.setItem(connection.socketMessageEvent, roomid);

	     // auto-join-room
	     (function reCheckRoomPresence() {
		 connection.checkPresence(roomid, function(isRoomExist) {
		     if (isRoomExist) {
			 connection.join(roomid);
			 return;
		     }

		     setTimeout(reCheckRoomPresence, 5000);
		 });
	     })();

	     disableInputButtons();
	 }

	 // detect 2G
	 if(navigator.connection &&
	    navigator.connection.type === 'cellular' &&
	    navigator.connection.downlinkMax <= 0.115) {
	     alert('2G is not supported. Please use a better internet service.');
	 }
	</script>

	<script>
	$('#share-screen').click(function() {
	    if($('#share-screen').text()==='Start Screen Sharing') {
	      $('#room-id').val('<?php echo $class_id?>');
	      $('#open-room').click();
	      $('#share-screen').text('Stop Screen Sharing');
	    } else {
		window.top.close();
	    }

	  });
</script>    
    </body>
</html>
