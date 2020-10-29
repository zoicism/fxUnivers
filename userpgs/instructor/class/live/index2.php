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
    // error logout
  }

//require('../../../../php/get_class_chat.php');
?>


<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Class</title>
      <script>
    if(!location.hash.replace('#', '').length) {
                location.href = location.href.split('#')[0] + '#' + (<?php echo $class_id ?>).toString().replace('.', '');
                location.reload();
            }
    
/*
if(!location.hash.replace('#', '').length) {
                location.href = location.href.split('#')[0] + '#' + (Math.random() * 100).toString().replace('.', '');
                location.reload();
            }
*/
        </script>

<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/css/slider.css"/>
<link rel="stylesheet" type="text/css" href="/css/skinblue.css"/><!-- Change skin color here -->
<link rel="stylesheet" type="text/css" href="/css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="/css/toptobottom.css"/>
<link rel="stylesheet" type="text/css" href="/css/modal.css"/>
<link rel="stylesheet" type="text/css" href="/css/responsive.css"/>
<link rel="stylesheet" type="text/css" href="/css/lessons.css"/>
<link rel="stylesheet" type="text/css" href="/css/tabs.css"/>
<link rel="stylesheet" type="text/css" href="/css/buttons/liveClass.css"/>
<link rel="stylesheet" type="text/css" href="/css/liveClass.css">
<link rel="stylesheet" type="text/css" href="/css/roundcorner.css"/>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

<script src="/js/jquery-3.4.1.min.js"></script><!-- scripts at the bottom of the document -->
        <script src="https://www.webrtc-experiment.com/DetectRTC.js"></script>
        <script src="https://www.webrtc-experiment.com/socket.io.js"> </script>
        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
        <script src="https://www.webrtc-experiment.com/IceServersHandler.js"></script>
        <script src="https://www.webrtc-experiment.com/CodecsHandler.js"></script>
        <script src="https://www.webrtc-experiment.com/RTCPeerConnection-v1.5.js"> </script>
        <script src="https://www.webrtc-experiment.com/webrtc-broadcasting/broadcast.js"> </script>
        <script src="https://www.webrtc-experiment.com/RecordRTC.js"></script>
        <script src="https://www.webrtc-experiment.com/gif-recorder.js"></script>
        <!--<script src="https://www.webrtc-experiment.com/getScreenId.js"></script>-->
    <script src="../getScreenId.js/getScreenId.js"></script>
    <script src="../Chrome-Extensions/Screen-Capturing.js/Screen-Capturing.js"></script>
      

</head>
<body>
<!-- UPPER BAR -->
<section class="nav-bar">
  <div class="nav-container">
    <div class="brand">
      <div class="logoimg toplogo"></div>
    </div>
    <nav>
      <div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
      <ul class="nav-list">
        <li>
          <a href="/" id="ubHome"><img id="ubiHome" src="/images/upperbar/home_a.png" alt="Home"></a>
        </li>
        <li>
          <a href="/search" id="ubSearch"><img id="ubiSearch" src="/images/upperbar/search_a.png" alt="Search"></a>
        </li>
	<li>
          <a href="/userpgs/notif" id="notif_a"><img id="ubiNotif" src="/images/upperbar/notification_a.png" style="height: 19px; width: 15.77px;" alt="Notifs"></a>
        </li>
        <li>
          <a href="/msg/inbox.php" id="msg_bar"><img id="ubiMsg" src="/images/upperbar/message_a.png" style="height: 15.77px; width: 19px;" alt="Messages"></a>
	    <!--
	    <ul class="nav-dropdown">
            <li>
              <a href="#">test1</a>
            </li>
            <li>
              <a href="#">test2</a>
            </li>
            <li>
              <a href="#">test3</a>
            </li>
          </ul>
	  -->
        </li>
        <li>
          <a href="/register/logout.php" id="ubLogout"><img id="ubiLogout" src="/images/upperbar/logout_a.png" style="height: 15.77px; width: 19px;" alt="Logout" ></a>
        </li>
      </ul>
    </nav>
  </div>
</section>

<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
        <div class="row space-bot">

        </div>
</div>


<!-- CONTENT
================================================== -->
<div class="grid">
		<div class="shadowundertop">
		</div>
		<div class="row">
          <div class="c12">
				  <h2 style="text-align:center"><?php echo $header ?></h2>
		    
		    

			<hr class="hrtitle" style="border-color: #25252533; margin-top:20px;">

            <section class="experiment">
                
                <!-- local/remote videos container -->
                <div id="videos-container"></div>
            </section>

          </div>
      
      
      <div class="c3">
<?php
      if($user_type=='instructor') {
          echo '<h3>Instructor Toolbox</h3>';
      } else {
          echo '<h3>Instructor Actions</h3>';
      }
?>

<?php
if($user_type=='instructor') {
    echo '<h6>File Sharing</h6>';

    echo '<form method="POST" target="hidden-iframe" action="/php/upload_class_file.php" enctype="multipart/form-data">
        <input type="file" name="class_file" id="classFile">
        <input type="hidden" name="classId" value="'.$class_id.'">
        <button type="submit" class="btn" style="display:block" id="classFileBtn">Upload File</button>
      </form>';
} else {
    echo '<h6>Uploaded Files</h6>';
}
//---
?>
<div id="newFiles"></div>
<iframe name="delete-iframe" style="display:none"></iframe>
<iframe name="hidden-iframe" style="display:none"></iframe>
<hr class="hrtitle" style="border-color: #ccc">


      <h6>Class Live Broadcast</h6>
<?php
      if($user_type=='instructor') {
?>
        <section>
          <select id="broadcasting-option" style="width:200px;display:block;">
            <option>Audio + Video</option>
            <option>Only Audio</option>
            <option id="broadcasting-screen">Screen</option>
          </select>

      <div id="chrome-screen-broadcast" style="display:none">You need to use FireFox for screen broadcasting.</div>
          <input type="hidden" id="broadcast-name">
          <button id="setup-new-broadcast" class="setup btn">Start Broadcasting</button>
<?php
      } else {
          echo '<p>Live sessions will appear below. Click on <b>Join</b> to watch!</p>';
          
?>
          <!-- list of all available broadcasting rooms -->
          <table style="width: 100%;" id="rooms-list"></table>
<?php
      }
?>
        </section>

<?php
if($user_type=='instructor') {
?>
    <section class="experiment recordrtc">
    <hr class="hrtitle" style="border-color: #ccc">
    <h6>Class Record</h6>

<div id="class-record">    
    <span style="font-size: 1rem">Record</span>
    <select class="recording-media" style="width:150px;vertical-align:baseline;">
      <option value="record-screen">Screen</option>
      <option value="record-video">Video</option>
      <option value="record-audio">Audio</option>
    </select>
    <span style="font-size:1rem">with</span>
    <select class="media-container-format" style="width:100px;vertical-align:baseline;">
      <option>WebM</option>
      <option>Mp4</option>
      <option>WAV</option>
      <option>Ogg</option>
      <option>Gif</option>
    </select>
    <span style="font-size:1rem">format:</span>
    <button class="btn" style="display:block" onclick="recordingFunc()">Start Recording</button>

    <div style="text-align: center; display: none;">
      <button id="save-to-disk">Save To Disk</button>
      <button id="open-new-tab">Open New Tab</button>
      <button id="upload-to-server">Upload To Server</button>
    </div>

    <br>
    <video controls playsinline autoplay muted=false volume=1 style="border: 1px solid #ccc;background: aliceblue;"></video>
    </div>
    </section>

    
<?php } ?>

<hr class="hrtitle" style="border-color: #ccc">
<?php
    if($user_type=='instructor') {
?>
    
    <h6>Whiteboard Broadcast</h6>
        <p>Click on the button below to create a whiteboard which you can share with your students.</p>
<form target="_blank" action="/userpgs/instructor/class/live/whiteboard/#<?php echo $class_id ?>" method="POST">
<input type="hidden" name="courseId" value="<?php echo $course_id ?>">
<input type="hidden" name="classId" value="<?php echo $class_id ?>">
<button type="submit" class="btn">Create Whiteboard</button>
</form>


<?php } else {?>
        <h6>Live Whiteboard</h6>
<p>Click below to go to the class whiteboard. This will open a new tab!</p>
<!--<a href="/userpgs/instructor/class/live/whiteboard/#<?php echo $class_id ?>" target="_blank"><button class="btn">Open Whiteboard</button></a>-->
<form target="_blank" action="/userpgs/instructor/class/live/whiteboard/#<?php echo $class_id ?>" method="POST">
<input type="hidden" name="courseId" value="<?php echo $course_id ?>">
<input type="hidden" name="classId" value="<?php echo $class_id ?>">
<button type="submit" class="btn">Open Whiteboard</button>
</form>
<?php } ?>
    
      </div>


<div class="c3" style="border: 5px solid #8bcae5;border-radius: 25px;background-color:beige;">

    
      <h3>Chatbox</h3>

      <input name="msgBody" type="text" id="chatInput" placeholder="Write your message here and hit enter to send!"/>
    
    
<div id="newMsgs" style="height:623px;overflow:scroll;"></div>


    			    
      </div>
   </div>




</div>


<!-- FOOTER
================================================== -->
<div id="wrapfooter">
        <div class="grid">
                <div class="row" id="footer">
                        <!-- to top button  -->
                        <!--<p class="back-top floatright">
                                <a href="#top"><span></span></a>
                        </p>-->
                        <!-- 1st column -->
			<div class="c4">
                          <div class="logoimgbig biglogo" style="margin-left: 0"></div>
                        </div>
                        <!-- 2nd column -->
                        <div class="c4">
                                <h2 class="title">Contact</h2>
                                <hr class="footerstress">
                                <dl>
                                        <dt>New Horizon Building, Ground Floor,
                                                <br />3 1/2 Miles Philip S.W. Goldson Highway,
                                                <br />Belize City, Belize,
                                                <br />Central America</dt>
                                        <dd>E-mail: <a href="#">contact@fxunivers.com</a></dd>
                                </dl>
                                <ul class="social-links" style="margin-top:15px;">
                                        <li class="facebook-link smallrightmargin">
                                        <a href="https://www.facebook.com/fxunivers" class="facebook has-tip" target="_blank" title="Join us on Facebook">Facebook</a>
                                        </li>
                                        <li class="linkedin-link smallrightmargin">
                                        <a href="https://www.linkedin.com/company/fxunivers/" class="linkedin has-tip" title="Linkedin" target="_blank">Linkedin</a>
                                        </li>
                                        <li class="twitter-link smallrightmargin">
                                        <a href="https://twitter.com/fxunivers" class="twitter has-tip" target="_blank" title="Follow Us on Twitter">Twitter</a>
                                        </li>
                                </ul>
                        </div>
                        <!-- 3rd column -->
                        <div class="c4">
                                <h2 class="title">Policy</h2>
                                <hr class="footerstress">
                                <a href="/policy">Policy and Agreements</a>
                        </div>
                </div>
        </div>
</div>

<!-- copyright area -->
<div class="copyright">
        <div class="grid">
		<div class="row">
                        <div class="c6">
                                With all due Reserves,
                        </div>
                </div>
                <div class="row">
                        <div class="c6">
                                 fxUnivers &copy; 2017-2020. All Rights Reserved.
                        </div>
                        <div class="c6">
                                <span class="right">
                                <!-- by Milad, milad@fxunivers.com --> </span>
                        </div>
                </div>
        </div>
</div>


<!-- JAVASCRIPTS
================================================== -->
<!-- all -->
<script src="/js/modernizr-latest.js"></script>

    

<script src="/js/modal.js"></script>

<!-- menu & scroll to top -->
<script src="/js/common.js"></script>

<!-- slider -->
<script src="js/jquery.cslider.js"></script>

<!-- twitter -->
<script src="/js/jquery.tweet.js"></script>

<!-- cycle -->
<script src="/js/jquery.cycle.js"></script>

<!-- flexslider -->
<script src="/js/jquery.flexslider-min.js"></script>

<!-- CALL flexslder -->
<script>
// Can also be used with $(document).ready()
$(window).load(function() {
$('.flexslider').flexslider({
animation: "slide"
});
});
</script>

<script src="/js/tabs.js"></script>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>

<script>
sessionStorage.setItem("liveClassId", "<?php echo $liveClassId ?>"); //<?php echo $liveClassId ?>
</script>
<script>
sessionStorage.setItem("userType", "<?php if($user_type=='instructor') { echo 'instructor'; } elseif($user_type=='student') { echo 'student'; } else { echo 'neither'; } ?>");
</script>

<!--<script src="/js/liveClass.js"></script>-->

<!-- CHECK BROWSER -->
<script>
var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);
if(isChrome) {
    $('#class-record').html('Chrome users need to install <a target="_blank" href="https://chrome.google.com/webstore/detail/recordrtc/ndcljioonkecdnaaihodjgiliohngojp?hl=en">this extension</a> and use it for recording the class, or switch to FireFox.');
    $('#broadcasting-option option[id="broadcasting-screen"]').remove();
    $('#chrome-screen-broadcast').show();
}
</script>



                                                      <!-- BUTTONS -->
<script>
$(document).ready(function() {
    $('#homeBtn').hover(function() {
        var imgUrl='/images/logos/fxlogo_a.png';
        $('#homeSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='/images/logos/fxlogo_b.png';
        $('#homeSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#notif_a').hover(function() {
        var imgUrl='/images/upperbar/notification_b.png';
        $('#ubiNotif').attr("src", imgUrl);
    }, function() {
        var imgUrl0='/images/upperbar/notification_a.png';
        $('#ubiNotif').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubHome').hover(function() {
        var imgUrl='/images/upperbar/home_b.png';
        $('#ubiHome').attr("src", imgUrl);
    }, function() {
        var imgUrl0='/images/upperbar/home_a.png';
        $('#ubiHome').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#msg_bar').hover(function() {
        var imgUrl='/images/upperbar/message_b.png';
        $('#ubiMsg').attr("src", imgUrl);
    }, function() {
        var imgUrl0='/images/upperbar/message_a.png';
        $('#ubiMsg').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubSearch').hover(function() {
        var imgUrl='/images/upperbar/search_b.png';
        $('#ubiSearch').attr("src", imgUrl);
    }, function() {
        var imgUrl0='/images/upperbar/search_a.png';
        $('#ubiSearch').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubLogout').hover(function() {
        var imgUrl='/images/upperbar/logout_b.png';
        $('#ubiLogout').attr("src", imgUrl);
    }, function() {
        var imgUrl0='/images/upperbar/logout_a.png';
        $('#ubiLogout').attr("src",imgUrl0);
    });
});
</script>

<!-- NOTIFS -->
<script>
$(document).ready(function() {
  var notifUserId=<?php echo $get_user_id ?>;
  setInterval(function() {
    jQuery.ajax({
      type: 'POST',
      url: '/php/notif_icon.php',
      data: {notif_userId: notifUserId},
      success: function(response) {
            //var json=$.parseJSON(response);
            //alert(json.last_notif);
            //alert(response);
            if(response==='1') {
                //alert('its 1');
                $('#notif_a').css('background-color', '#3282b8');
            }

            jQuery.ajax({
              type: 'POST',
              url: '/php/msg_icon.php',
              data: {msg_userId: notifUserId},
              success: function(result) {
                    if(result>0) {
                        $('#msg_bar').css('background-color', '#3282b8');
                    }
              }
            });
      }
    });
  }, 2000);
});
</script>
<!-- EO NOTIFS -->

    <!-- DELETE FILE -->
<script>
/*$('#deleteFile').submit(function(e) {
    e.preventDefault();
    jQuery.ajax({
      type:'POST',
      url:'/php/del_live_file.php',
      data:$(this).serialize(),
      success: function(response) {
            alert('ok');
      }
    });
    });*/
</script>

<!-- WHITEBOARD -->


<!-- CHAT -->
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
$(document).ready(function() {
    setInterval(function() {
        /*jQuery.ajax({
          type:'POST',
                data: {class_id: <?php echo $class_id ?>},
                success: function(response) {*/
        
        $('#newFiles').load('/php/class_file_update.php', {class_id: <?php echo $class_id ?>, user_type: '<?php echo $user_type ?>'});
    }, 1000);
});
</script>





<?php if($user_type=='instructor') { ?>
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
                            '<td><button class="join btn">Join</button></td>';
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
                    if (error === 'not-installed') {
                        document.write('<h1><a target="_blank" href="https://chrome.google.com/webstore/detail/recordrtc/ndcljioonkecdnaaihodjgiliohngojp?hl=en">Please install this chrome extension then reload the page.</a></h1>');
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

            var MY_DOMAIN = 'webrtc-experiment.com';

            function isMyOwnDomain() {
                // replace "webrtc-experiment.com" with your own domain name
                return document.domain.indexOf(MY_DOMAIN) !== -1;
            }

            function saveToDiskOrOpenNewTab(recordRTC) {
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
                            button.innerHTML = 'Click to download from server';
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
                var upload_directory = 'uploads/';

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
            <!-- EO RTC RECORD -->
<?php } else { ?>
    <script>
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
                            '<td><button class="join btn">Join</button></td>';
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
                    </script>
<?php } ?>
                


</body>
</html>
