<?php
session_start();
require('../register/connect.php');

if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
	$smsg = "Successfully logged in!";
} else {
	echo "could not get the username!";
}

require('../php/get_user.php');

$id = $get_user_id;


if(isset($_GET['guest'])) {
	$guest = $_GET['guest'];
	require('../php/get_guest_by_username.php');
	$guest_id = $get_guest_by_username['id'];
}

require('../userpgs/php/notif.php');

$get_user_id = $id;
require('../php/get_plans.php');

require('../php/get_rel.php');

require('../wallet/php/get_fxcoin_count.php');

require('../php/get_msg.php');

require('../php/get_messenger.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>fxMsg</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/icons.css">
  <link rel="stylesheet" href="/css/logo.css">
  <script src="/js/jquery-3.4.1.min.js"></script>

  <!-- scripts used for peers connection -->
        <script src="/js/webrtc/adapter-latest.js"></script>
        <script src="/js/webrtc/socket.io.js"> </script>
        <script src="/js/webrtc/IceServersHandler.js"></script>
        <script src="/js/webrtc/socket.io/PeerConnection.js"> </script>


</head>

<body>
	<div class="header-sidebar"></div>
  <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>

  <div class="blur mobile-main">

   <div class="sidebar"></div>
<?php require('../php/sidebar.php'); ?>

  <div class="relative-main-content">
      <div class="row-chat">
        <div class="discussions">
          <ul>
            <li class="discussion search-chat">
              <input type="text" placeholder="Search..."></input>
            </li>

<div id="disc-container">
	    <?php
          if($get_msg_count>0) {
            while($row = $get_msg_result->fetch_assoc()) {
              
		  
                        if($row['user1id']==$get_user_id) {
                            $sidebar_guest_id = $row['user2id'];
                        } else {
                            $sidebar_guest_id = $row['user1id'];
                        }
                        require('../php/get_guest.php');

if($_GET['guest']==$get_guest['username']) {
    echo '<li class="discussion" id="active-discussion" tabindex="1" onclick="location.href=\'/msg/messenger.php?guest='.$get_guest["username"].'\';">';
} else {
	    echo '<li class="discussion" tabindex="1" onclick="location.href=\'/msg/messenger.php?guest='.$get_guest["username"].'\';">';

}




if($get_guest['avatar']!=NULL) {
      $avatar_url='/userpgs/avatars/'.$get_guest['avatar'];
} else {
      $avatar_url='/images/background/avatar.png';
}




	        echo '<div class="photo" style="background-image:url(\''.$avatar_url.'\');"></div>';
	        echo '<div class="desc-contact">';
if($get_unread_count>0) {
	         echo '<p class="name">'.$get_guest['username'].' ('.$get_unread_count.')</p>';
		 } else {
		 echo '<p class="name">'.$get_guest['username'].'</p>';
		 }
		 
                                   
                        echo '<p class="message">'.$row['text'].'</p>';
                        
	      echo '</div></li>';
            }
          } else {
                    echo '<p style="color:gray">No conversations started yet</p>';
                }
  ?>

</div>
          </ul>
        </div>

        <section class="chat">
          <div class="header-chat">
                <p class="name"><?php echo $guest?></p>
		<p><a id="video-call-btn">Video Call</a></p>
              </div>


              <div class="message-chat" id="newMsgs">


	        <?php
                while($row = $get_messenger_result->fetch_assoc()) {

		    $sent_time = new DateTime($row['sent_dt']);

                    if($row['user2id']==$get_user_id) {
                        echo '<div class="messages message-recieved">';
                        echo '<p>'.$row['text'].'</p>';
			echo '<span class="time">'.$sent_time->format('H:i').'</span>';
                        echo '</div>';
                    } else {
                        echo '<div class="messages message-sent">';
                        echo '<p>'.$row['text'].'</p>';
			echo '<span class="time">'.$sent_time->format('H:i').'</span>';
                        echo '</div>';
                    }
                }
  ?>
              </div>


              <div class="footer-chat">

                <div class="image-upload">
                  <label for="file-input">
                    <img src="/images/background/plus.svg" class="chat-icon">
                  </label>
                  <input id="file-input" type="file" multiple>
                </div>

<form id="sendMsg" autocomplete="off" style="width:100%">
  <input type="hidden" name="clientId" value="<?php echo $get_user_id?>">
                  <input type="hidden" name="guestId" value="<?php echo $guest_id?>">
		  
                <input type="text" name="msgBody" id="inputMsgTxt" placeholder="Type your message here" autofocus required >
		<input type="submit" style="display:none">
		</form>
		
                <a id="sendImg"><img src="/images/background/send.svg" class="chat-icon"></a>
              </div>
        </section>
      </div>
  </div>
  </div>

<div class="frame-container" style="display:none" id="video-chat-overlay">
  <div class="frame">
     <div class="frame-header">
       <div class="friends-word"><?php echo $guest?></div>
     </div>

     <input style="display:none" type="text" id="your-name" placeholder="your-name" value="<?php echo $username?>">
                    <button id="start-broadcasting" style="display:none" class="setup">Start Transmitting Yourself!</button>


                <!--<table id="rooms-list" style="width: 100%;"></table>-->



<div id="stop">Stop</div>

<div id="videos-container"></div>



   </div>
</div>


<div class="frame-container" style="display:none" id="video-income-overlay">
  <div class="frame">
     <div class="frame-header">
       <div class="friends-word" id="caller-username"></div>
     </div>

<div id="accept-call">Accept Call</div>
<div id="guest-ignore">Ignore Call</div>
<div id="guest-stop">Stop</div>
<div id="receiving-videos-container"></div>
     
<table style="display:none" id="rooms-list" style="width: 100%;"></table>

</div>
</div>


  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>



<!-- SCRIPTS -->


<!-- SEND MSG -->
<script>
                $(document).ready(function() {
                    $('#sendMsg').submit(function(e) {
                        
                        e.preventDefault();
                        jQuery.ajax({
                          type:"POST",
                          url:'/php/set_msg.php',
                          data:$(this).serialize(),
                          success:function(response) {
                                $('#inputMsgTxt').val('');
                                $('#inputMsgTxt').focus();
				$('.message-chat').append(response);
				$('.message-chat').scrollTop($('.message-chat')[0].scrollHeight);
                          }
                        });
                    });
                });
</script>


<!-- SYNC MSGS -->
<script>
$('.message-chat').scrollTop($('.message-chat')[0].scrollHeight);
                $(document).ready(function() {
                    setInterval(function() {
                        jQuery.ajax({
                          type:"POST",
                          url:'/php/sync_msgs.php',
                          data: {user_id: <?php echo $get_user_id?>, guest_id: <?php echo $guest_id?>},
                          success: function(response) {
			      if(response!='') {
			        $('.message-chat').append(response);
			        $('.message-chat').scrollTop($('.message-chat')[0].scrollHeight);
			      }
                          }
                        });

			
                    },1000);
                });                      
</script>


<!-- SYNC CONVS -->
<script>
$(document).ready(function() {
  setInterval(function() {
    jQuery.ajax({
      type:"POST",
      url:'/php/disq_container.php',
      data: { user_id: <?php echo $get_user_id?> },
      success: function(response) {
        $('#disc-container').load(window.location.href+' #disc-container');
      }
    });
  }, 2000);
});
</script>

  <script>
    if(screen.width<629) {
      $('#page-header').html('<?php echo $guest?>');
      $('#page-header').attr('href','/user/<?php echo $guest?>');
    } else {
      $('#page-header').html('Messages');
      $('#page-header').attr('href','/msg/inbox.php');
    }
  </script>

<script>
if(screen.width<629) {
  $('.footbar').hide();
  $('.discussions').hide();
  $('#header-menu').css('visibility','hidden');
}
</script>


<script>
  $('#nav-msg .filled').show();
  $('#nav-msg .stroked').hide();
</script>


<script>
$('#video-call-btn').click( function() {
  $('#video-chat-overlay').show();
  

  //var channel = location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
		var channel = 'httplocalhostmsgmessengerphp'+'<?php echo $guest_id?>';
		console.log(channel);
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

		var message = '<?php echo $username?>';

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
                };

                peer.onStreamAdded = function(e) {
                    var video = e.mediaElement;
                    video.setAttribute('width', 600);
                    videosContainer.insertBefore(video, videosContainer.firstChild);

                    video.play();
                    rotateVideo(video);
                    scaleVideos();
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

		peer.userid = "<?php echo $username?>";

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
                        video.controls = false;
                        video.muted = false;

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



$('#start-broadcasting').click();

});


</script>






<script>

                //var channel = location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
		var channel = 'httplocalhostmsgmessengerphp'+'<?php echo $get_user_id?>';
		console.log(channel);
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

                    //td1.innerHTML = userid + ' has camera. Are you interested in video chat?';


$('#video-income-overlay').show();
$('#caller-username').html(userid);
$('#caller-accept').html(userid + ' is calling you.');



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

		    $('#accept-call').click(function() {
		      button.click();
		    });

		    
                };

                peer.onStreamAdded = function(e) {
                    var video = e.mediaElement;
                    video.setAttribute('width', 600);
                    videosContainer.insertBefore(video, videosContainer.firstChild);

                    video.play();
                    rotateVideo(video);
                    scaleVideos();
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

		peer.userid = "<?php echo $username?>";

                var videosContainer = document.getElementById('receiving-videos-container') || document.body;
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
                        video.controls = false;
                        video.muted = false;

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


<script>
$('#stop').click(function() {
var streamingVid = document.querySelector('video');

const stream = streamingVid.srcObject;
const tracks = stream.getTracks();

tracks.forEach(function(track) {
track.stop();
});

console.log('video stream stopped');

$('#video-call-overlay').hide();

window.location.reload();
});



$('#guest-stop').click(function() {
var streamingVid = document.querySelector('video');

const stream = streamingVid.srcObject;
const tracks = stream.getTracks();

tracks.forEach(function(track) {
track.stop();
});

console.log('video stream stopped');

$('#video-income-overlay').hide();

window.location.reload();
});
</script> 


</body>
</html>