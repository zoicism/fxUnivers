<?php

session_start();
require('../../../../../register/connect.php');

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

/*$user_id = $class_fetch['teacher_id'];*/
$header = $class_fetch['title'];
$description = $class_fetch['body'];
$video = $class_fetch['video'];

$tar_id=$class_fetch['teacher_id'];
require('../../../../../php/get_tar_id.php');


require('../../../php/classes.php');

require('../../../../../php/get_course.php');

require('../../../../../php/get_user_type.php');

/*
   if($user_type == 'neither') {
   $go_home = "Location: /";
   header($go_home);
   }
 */

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
?>

<!DOCTYPE html>
<html>
<head>
<title>Live Screen fxUniversity</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">

    <script src="../../js/socket.io.js"> </script>
    <script src="../../DetectRTC/DetectRTC.js"></script>
    <script src="../../js/adapter-latest.js"></script>
    <script src="../../js/CodecsHandler.js"></script>
    <script src="/js/webrtc/BandwidthHandler.js"></script>
    <script src="/js/webrtc/IceServersHandler.js"></script>
    <script src="../../Pluginfree-Screen-Sharing/conference.js"></script>

    <!--
    <script src="https://www.webrtc-experiment.com/socket.io.js"> </script>
        <script src="https://www.webrtc-experiment.com/DetectRTC.js"></script>
        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
        <script src="https://www.webrtc-experiment.com/CodecsHandler.js"></script>
        <script src="https://www.webrtc-experiment.com/BandwidthHandler.js"></script>
        <script src="https://www.webrtc-experiment.com/IceServersHandler.js"></script>
        <script src="https://www.webrtc-experiment.com/Pluginfree-Screen-Sharing/conference.js"> </script>
	-->
	

    <script src="/js/jquery-3.4.1.min.js"></script>
</head>
<body>

<article style="padding:20px;background:white;border: 1px solid black;margin:20px;">

<h2 style="text-align:center"><?php echo $header?></h2>
<h3 style="text-align:center">fxUniversity Live Screen Sharing</h3>

<section class="experiment" style="flex-flow:column">
                <section class="hide-after-join" style="text-align: center;">                    
                    <input type="text" id="room-name" placeholder="Enter " style="width: 80%; text-align: center; display: none;">
                    <?php if($user_type=='instructor') echo '<button id="share-screen" style="background-color:transparent" class="submit-btn">Start Screen Sharing</button>'; else echo '<p id="share-screen-p">Instructor\'s screen will appear here.</p>';
		    //echo '<button id="share-screen" style="background-color:transparent" class="submit-btn">Start Screen Sharing</button>';?>
                </section>

<!--<p>Watching: <span id="online-num">0</span></p>-->


                <!-- local/remote videos container -->
                <div class="video-holder"><div id="videos-container"></div></div>

                <section id="unique-token" style="display: none; text-align: center; padding: 20px;"></section>
            </section>

</article>



<script>
                var config = {
                    openSocket: function(config) {
                        var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';

                        //config.channel = config.channel || location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');

			config.channel = config.channel || 'fxuniversityscreen<?php echo $class_id?>';

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
                    onRemoteStream: function(media) {
                        if(isbroadcaster) return;

                        var video = media.video;
                        videosContainer.insertBefore(video, videosContainer.firstChild);
                        rotateVideo(video);

                        document.querySelector('.hide-after-join').style.display = 'none';
                    },
                    onRoomFound: function(room) {
                        if(isbroadcaster) return;

                        conferenceUI.joinRoom({
                            roomToken: room.roomToken,
                            joinUser: room.broadcaster
                        });

                        
                    },
                    onNewParticipant: function(numberOfParticipants) {
                        var text = numberOfParticipants + ' users are viewing your screen!';
                        
                        if(numberOfParticipants <= 0) {
                            text = 'No one is viewing your screen YET.';
                        }
                        else if(numberOfParticipants == 1) {
                            text = 'Only one user is viewing your screen!';
                        }

                        document.title = text;
                        showErrorMessage(document.title, 'green');
                    },
                    oniceconnectionstatechange: function(state) {
                        var text = '';

                        if(state == 'closed' || state == 'disconnected') {
                            text = 'One of the participants just left.';
                            document.title = text;
                            showErrorMessage(document.title);
                        }

                        if(state == 'failed') {
                            text = 'Failed to bypass Firewall rules. It seems that target user did not receive your screen. Please ask him reload the page and try again.';
                            document.title = text;
                            showErrorMessage(document.title);
                        }

                        if(state == 'connected' || state == 'completed') {
                            text = 'A user successfully received your screen.';
                            //document.title = text;
                            //showErrorMessage(document.title, 'green');
			    //$('#online-num').text(text);
                        }

                        if(state == 'new' || state == 'checking') {
                            text = 'Someone is trying to join you.';
                            //document.title = text;
                            //showErrorMessage(document.title, 'green');
                        }
                    }
                };

                function showErrorMessage(error, color) {
                    var errorMessage = document.querySelector('#logs-message');
                    errorMessage.style.color = color || 'red';
                    errorMessage.innerHTML = error;
                    errorMessage.style.display = 'block';
                }

                function getDisplayMediaError(error) {
                    if (location.protocol === 'http:') {
                        showErrorMessage('Please test this WebRTC experiment on HTTPS.');
                    } else {
                        showErrorMessage(error.toString());
                    }
                }

                function captureUserMedia(callback) {
                    var video = document.createElement('video');
                    video.muted = true;
                    video.volume = 0;
                    try {
                        video.setAttributeNode(document.createAttribute('autoplay'));
                        video.setAttributeNode(document.createAttribute('playsinline'));
                        video.setAttributeNode(document.createAttribute('controls'));
                    } catch (e) {
                        video.setAttribute('autoplay', true);
                        video.setAttribute('playsinline', true);
                        video.setAttribute('controls', true);
                    }

                    if(navigator.getDisplayMedia || navigator.mediaDevices.getDisplayMedia) {
                        function onGettingSteam(stream) {
                            video.srcObject = stream;
                            videosContainer.insertBefore(video, videosContainer.firstChild);

                            addStreamStopListener(stream, function() {
                                location.reload();
                            });

                            config.attachStream = stream;
                            callback && callback();
                            rotateVideo(video);

                            addStreamStopListener(stream, function() {
                                location.reload();
                            });

                            showPrivateLink();

                            document.querySelector('.hide-after-join').style.display = 'none';
                        }

                        if(navigator.mediaDevices.getDisplayMedia) {
                            navigator.mediaDevices.getDisplayMedia({video: true}).then(stream => {
                                onGettingSteam(stream);
                            }, getDisplayMediaError).catch(getDisplayMediaError);
                        }
                        else if(navigator.getDisplayMedia) {
                            navigator.getDisplayMedia({video: true}).then(stream => {
                                onGettingSteam(stream);
                            }, getDisplayMediaError).catch(getDisplayMediaError);
                        }
                    }
                    else {
                        if (DetectRTC.browser.name === 'Chrome') {
                            if (DetectRTC.browser.version == 71) {
                                showErrorMessage('Please enable "Experimental WebPlatform" flag via chrome://flags.');
                            } else if (DetectRTC.browser.version < 71) {
                                showErrorMessage('Please upgrade your Chrome browser.');
                            } else {
                                showErrorMessage('Please make sure that you are not using Chrome on iOS.');
                            }
                        }

                        if (DetectRTC.browser.name === 'Firefox') {
                            showErrorMessage('Please upgrade your Firefox browser.');
                        }

                        if (DetectRTC.browser.name === 'Edge') {
                            showErrorMessage('Please upgrade your Edge browser.');
                        }

                        if (DetectRTC.browser.name === 'Safari') {
                            showErrorMessage('Safari does NOT supports getDisplayMedia API yet.');
                        }
                    }
                }

                /* on page load: get public rooms */
                var conferenceUI = conference(config);

                /* UI specific */
                var videosContainer = document.getElementById("videos-container") || document.body;

                document.getElementById('share-screen').onclick = function() {
                    var roomName = document.getElementById('room-name') || { };
                    roomName.disabled = true;
                    captureUserMedia(function() {
                        conferenceUI.createRoom({
                            roomName: (roomName.value || 'Anonymous') + ' shared his screen with you'
                        });
                    });
                    this.disabled = true;
                };

                function rotateVideo(video) {
                    video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
                    setTimeout(function() {
                        video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
                    }, 1000);
                }

                function showPrivateLink() {
                    var uniqueToken = document.getElementById('unique-token');
                    uniqueToken.innerHTML = '<a href="' + location.href + '" target="_blank">Copy & Share This Private Room Link</a>';
                    uniqueToken.style.display = 'block';
                }

            </script>


</body>
</html>
