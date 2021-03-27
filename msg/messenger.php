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
  <script src="/js/jquery.form.js"></script>

  <!-- scripts used for peers connection -->
        <script src="/js/webrtc/adapter-latest.js"></script>
        <script src="/js/webrtc/socket.io.js"> </script>
        <script src="/js/webrtc/IceServersHandler.js"></script>
        <script src="/js/webrtc/socket.io/PeerConnection.js"> </script>


</head>

<body style="overflow:hidden">
	<div class="header-sidebar"></div>
  <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>

  <div class="blur mobile-main" style="margin-bottom:0;">

   <div class="sidebar"></div>
<?php require('../php/sidebar.php'); ?>

  <div class="relative-main-content">
      <div class="row-chat">
        <div class="discussions">
          <ul>
            <li class="discussion search-chat">
              <input type="text" placeholder="Search friends" id="search-friends" name="fnd-srch-q">
            </li>

<div id="disc-container">

<div id="friend-search" style="display:none"></div>

<div id="old-discs">
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
</div>
          </ul>
        </div>

        <section class="chat" style="/*height:calc(100 * var(--vh));*/">
          <div class="header-chat">
	  <a id="back-butt" class="blur" onclick="goBack()" style="width: 16px;height: 16px;margin-left: 20px;display:none;"><svg id="backIcon" viewBox="0 0 32 32" style="width: 100%;height: 100%;"><defs><style>.back-icon{fill:#212121;}</style></defs><path class="back-icon" d="M24.2,32a1.2,1.2,0,0,1-.9-.3l-2.7-2.4-2.8-2.5L7.8,18l-.7-.6a1.9,1.9,0,0,1,0-2.8l.5-.4L12.3,10l5.5-4.8,2.8-2.5L23.3.3a1.2,1.2,0,0,1,.9-.3,1.3,1.3,0,0,1,.9,2.3l-.4.4L20.9,6,9.6,16,20.9,26l3.8,3.3.4.4A1.3,1.3,0,0,1,24.2,32Z"/></svg></a>
                <a href="/user/<?php echo $guest?>" class="name" style="text-decoration:none;font-weight:bold;"><?php echo $guest?></a>
		<div class="msg-icon-cnt" id="video-call-btn">
		<svg viewBox="0 0 32 32"><defs><style>.videocall-icon{fill:#212121;}</style></defs><path class="videocall-icon" d="M30,5.8a1.9,1.9,0,0,0-1,.3l-7.2,4.2v-2a4,4,0,0,0-4-4H4a4,4,0,0,0-4,4V23.7a4,4,0,0,0,4,4H17.8a4,4,0,0,0,4-4V21.6L29,25.9a1.9,1.9,0,0,0,1,.3,2,2,0,0,0,2-2V7.8A2,2,0,0,0,30,5.8ZM19.8,23.7a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V8.3a2,2,0,0,1,2-2H17.8a2,2,0,0,1,2,2Zm10.2.5-8.2-4.9V12.7L30,7.8Z"/></svg>
		</div>
              </div>


              <div class="message-chat" id="newMsgs">


	        <?php
                while($row = $get_messenger_result->fetch_assoc()) {

		    $sent_time = new DateTime($row['sent_dt']);
		    $msg_type = $row['msg_type'];

                    if($row['user2id']==$get_user_id) {
		        if($msg_type=='file') {
			  echo '
			    <div class="messages message-recieved upload-container" onclick="window.location.href=\'dl_msg_file.php?filename='.urlencode($row['file_enc']).'\';">
                  	      <div class="upload-recieved">
                    	        <img src="/images/background/file-recieved.svg">
                  	      </div>
                  	      <div class="file-name">'.$row['text'].'<div>'.$row['file_size'].' MB</div></div>
                  	      <span class="time">'.$sent_time->format('H:i').'</span>
                	    </div>
			  ';
			} else {
			    echo '<div class="messages message-recieved">';
			    echo '<p>'.$row['text'].'</p>';
			    echo '<span class="time">'.$sent_time->format('H:i').'</span>';
                            echo '</div>';
			}
                    } else {
		        if($msg_type=='file') {
			  echo '
			    <div class="messages message-sent upload-container" onclick="window.location.href=\'dl_msg_file.php?filename='.urlencode($row['file_enc']).'\';">
                  	      <div class="upload-sent">
                    	        <img src="/images/background/file-sent.svg">
                              </div>
                  	      <div class="file-name">'.$row['text'].'<div>'.$row['file_size'].' MB</div></div>
                  	      <span class="time">'.$sent_time->format('H:i').'</span>
                	    </div>
			  ';
			} else {
                          echo '<div class="messages message-sent">';
                          echo '<p>'.$row['text'].'</p>';
			  echo '<span class="time">'.$sent_time->format('H:i').'</span>';
                          echo '</div>';
			}
                    }
                }
  ?>
              </div>


              <div class="footer-chat">

                <div class="image-upload">
                  <label for="file-input">
                    <img src="/images/background/plus.svg" class="chat-icon" id="file-btn">
                  </label>
                  <!--<input id="file-input" type="file" multiple>-->
		  
<form method="POST" style="display:none" id="file-form" enctype="multipart/form-data" action="/php/messenger_file_send.php">
  <input type="hidden" name="senderId" value="<?php echo $get_user_id?>">
  <input type="hidden" name="recId" value="<?php echo $guest_id?>">
  <input type="file" name="theFile" id="file-input">
  <input type="submit">
</form>


		  
                </div>

<form id="sendMsg" autocomplete="off" style="width:100%">
  <input type="hidden" name="clientId" value="<?php echo $get_user_id?>">
                  <input type="hidden" name="guestId" value="<?php echo $guest_id?>">
		  
                <input type="text" name="msgBody" id="inputMsgTxt" placeholder="Type your message here" autofocus required >
		<input type="submit" style="display:none">
		</form>
		
                
		<div class="msg-icon-cnt" id="send-btn"><svg id="SendIcon" viewBox="0 0 32 32"><defs><style>.send-icon{fill:#212121;}</style></defs><path class="send-icon" d="M30.9,14.5,2.9.5,2,.3A1.9,1.9,0,0,0,.1,2.8L3.2,16.4.1,29.2A2,2,0,0,0,2,31.7l.9-.2,28-13.4A2,2,0,0,0,30.9,14.5ZM2,29.7,5.1,17.4H15.8a1,1,0,0,0,1-1h0a.9.9,0,0,0-1-1H5.1L2,2.3l28,14Z"/></svg></div>
		
              </div>
        </section>
      </div>
  </div>
  </div>












<div class="frame-container" style="display:none" id="video-chat-overlay">
<div class="frame-videocall">


<table style="display:none" id="rooms-list" style="width: 100%;"></table>
<input style="display:none" type="text" id="your-name" placeholder="your-name" value="<?php echo $username?>">
<button id="start-broadcasting" style="display:none" class="setup">Start Transmitting Yourself!</button>

<div id="videos-container"></div>

      <div class="top-videocall">
        <div class="guest-pi">
          <div class="guest-photo">
	    <?php
	      if($get_guest_by_username['avatar']!=null) {
	        echo '<img src="/userpgs/avatars/'.$get_guest_by_username['avatar'].'">';
	      } else { 
	        echo '<img src="/images/background/avatar.png">';
              }
	    ?>
          </div>
          <div class="guest-id"><?php echo $guest?></div>
        </div>

        <div class="by-fx">
          <div class="by-word">by</div>
          <div class="fx-logo">
            <svg viewBox="0 0 20 20"><defs><style>.by-logo{fill:#008bc6;}</style></defs><path class="by-logo" d="M10,0A10.1,10.1,0,0,0,6.1.8,9.9,9.9,0,0,0,2.9,2.9,10,10,0,0,0,0,10,9.9,9.9,0,0,0,10,20a10.1,10.1,0,0,0,3.9-.8,9.9,9.9,0,0,0,3.2-2.1A10,10,0,0,0,20,10,9.9,9.9,0,0,0,10,0Zm9.3,10a8.6,8.6,0,0,1-.7,3.6,12.1,12.1,0,0,1-2,3,12.1,12.1,0,0,1-3,2,8.6,8.6,0,0,1-3.6.7,8.6,8.6,0,0,1-3.6-.7,12.1,12.1,0,0,1-3-2,12.1,12.1,0,0,1-2-3A8.6,8.6,0,0,1,.7,10a8.6,8.6,0,0,1,.7-3.6,12.1,12.1,0,0,1,2-3,12.1,12.1,0,0,1,3-2A8.6,8.6,0,0,1,10,.7a8.6,8.6,0,0,1,3.6.7,12.1,12.1,0,0,1,3,2,12.1,12.1,0,0,1,2,3A8.6,8.6,0,0,1,19.3,10Z"/><path class="by-logo" d="M8.3,8.8,10,10.5l1.8-1.7a2.2,2.2,0,0,1,3.4,0l-3.5,3.5L13.5,14l.7.7-1.7,1.8L4.8,8.8,10,3.5l1.8,1.8Z"/><path class="by-logo" d="M7,13.5l1.7,1.8-.5.5a2.6,2.6,0,0,1-1.7.7,2.6,2.6,0,0,1-1.7-.7Z"/></g></svg>
          </div>
        </div>
      </div>

      <div class="bottom-videocall">
<p class="calling-text" id="calling-txt">Calling ...</p>
        <div class="call-btn">
          <a class="btn decline" id="host-stop">
            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><style>.decline-red{fill:#ff3b30;}.phone-wh{fill:#efefef;}</style></defs><circle class="decline-red" cx="50" cy="50" r="50"/><path class="phone-wh" d="M39.9,54.7v-6a.6.6,0,0,1,.5-.6,39,39,0,0,1,19.2,0,.6.6,0,0,1,.5.6v6a1.1,1.1,0,0,0,.8,1.1,32.7,32.7,0,0,1,11.5,7,1.4,1.4,0,0,0,1.7,0L84.5,52.4a1.2,1.2,0,0,0-.1-1.8A49.8,49.8,0,0,0,60.1,37.9a49.1,49.1,0,0,0-20.2,0A49.8,49.8,0,0,0,15.6,50.6a1.2,1.2,0,0,0-.1,1.8L25.9,62.8a1.4,1.4,0,0,0,1.7,0,32.7,32.7,0,0,1,11.5-7A1.1,1.1,0,0,0,39.9,54.7Z"/></svg>
          </a>
        </div>
      </div>
    </div>
</div>

<!--
  <div class="frame-call">
  <div class="calling-content">
        <div class="photo">
          <img src="/images/background/avatar.png">
        </div>
        <div class="id-friend">
          <div class="txt"><?php echo $guest?></div>
        </div>

	<table style="display:none" id="rooms-list" style="width: 100%;"></table>


        <div class="calling">
          <div class="txt">is calling ...</div>
        </div>

        <div class="call-btn">
          <a class="btn decline" id="guest-ignore">
            <svg viewBox="0 0 100 100">
              <path class="red-circle" d="M50,0a50,50,0,1,0,50,50A50,50,0,0,0,50,0ZM84.5,52.4,74.1,62.8a1.4,1.4,0,0,1-1.7,0,32.7,32.7,0,0,0-11.5-7,1.1,1.1,0,0,1-.8-1.1v-6a.6.6,0,0,0-.5-.6,39,39,0,0,0-19.2,0,.6.6,0,0,0-.5.6v6a1.1,1.1,0,0,1-.8,1.1,32.7,32.7,0,0,0-11.5,7,1.4,1.4,0,0,1-1.7,0L15.5,52.4a1.2,1.2,0,0,1,.1-1.8A49.8,49.8,0,0,1,39.9,37.9a49.1,49.1,0,0,1,20.2,0A49.8,49.8,0,0,1,84.4,50.6,1.2,1.2,0,0,1,84.5,52.4Z"/>
            </svg>
          </a>
          <a class="btn accept" id="accept-call">
            <svg viewBox="0 0 100 100">
              <path class="green-circle" d="M50,0a50,50,0,1,0,50,50A50,50,0,0,0,50,0ZM75,73.8A1.2,1.2,0,0,1,73.7,75a48.9,48.9,0,0,1-26.2-8.2A51.2,51.2,0,0,1,33.2,52.5,48.9,48.9,0,0,1,25,26.3,1.3,1.3,0,0,1,26.3,25H40.9a1.2,1.2,0,0,1,1.2,1.2,32.8,32.8,0,0,0,3.2,13,1.2,1.2,0,0,1-.2,1.5l-4.3,4.2a.6.6,0,0,0,0,.8A40.8,40.8,0,0,0,54.3,59.3a.6.6,0,0,0,.8-.2l4.2-4.2a1.2,1.2,0,0,1,1.5-.2,32.8,32.8,0,0,0,13,3.2A1.2,1.2,0,0,1,75,59.1Z"/>
            </svg>
          </a>
        </div>
      </div>
    </div>

     <input style="display:none" type="text" id="your-name" placeholder="your-name" value="<?php echo $username?>">
                    <button id="start-broadcasting" style="display:none" class="setup">Start Transmitting Yourself!</button>


                <!--<table id="rooms-list" style="width: 100%;"></table>



<div id="stop">Stop</div>

<div id="videos-container"></div>



   </div>
</div>-->















<!---------- video call starts ---------->

  <div class="frame-container" style="display:none" id="video-income-overlay">
    <div class="frame-call" id="frame-calling-overlay">
      <div class="calling-content">
        <div class="photo">
          <img src="/images/background/avatar.png">
        </div>
        <div class="id-friend">
          <div class="txt" id="caller-username"></div>
        </div>

<!--<div id="receiving-videos-container"></div>-->
<table style="display:none" id="rooms-list" style="width: 100%;"></table>


        <div class="calling">
          <div class="txt">is calling ...</div>
        </div>

        <div class="call-btn">
          <a class="btn decline" id="guest-ignore">
            <svg viewBox="0 0 100 100">
              <path class="red-circle" d="M50,0a50,50,0,1,0,50,50A50,50,0,0,0,50,0ZM84.5,52.4,74.1,62.8a1.4,1.4,0,0,1-1.7,0,32.7,32.7,0,0,0-11.5-7,1.1,1.1,0,0,1-.8-1.1v-6a.6.6,0,0,0-.5-.6,39,39,0,0,0-19.2,0,.6.6,0,0,0-.5.6v6a1.1,1.1,0,0,1-.8,1.1,32.7,32.7,0,0,0-11.5,7,1.4,1.4,0,0,1-1.7,0L15.5,52.4a1.2,1.2,0,0,1,.1-1.8A49.8,49.8,0,0,1,39.9,37.9a49.1,49.1,0,0,1,20.2,0A49.8,49.8,0,0,1,84.4,50.6,1.2,1.2,0,0,1,84.5,52.4Z"/>
            </svg>
          </a>
          <a class="btn accept" id="accept-call">
            <svg viewBox="0 0 100 100">
              <path class="green-circle" d="M50,0a50,50,0,1,0,50,50A50,50,0,0,0,50,0ZM75,73.8A1.2,1.2,0,0,1,73.7,75a48.9,48.9,0,0,1-26.2-8.2A51.2,51.2,0,0,1,33.2,52.5,48.9,48.9,0,0,1,25,26.3,1.3,1.3,0,0,1,26.3,25H40.9a1.2,1.2,0,0,1,1.2,1.2,32.8,32.8,0,0,0,3.2,13,1.2,1.2,0,0,1-.2,1.5l-4.3,4.2a.6.6,0,0,0,0,.8A40.8,40.8,0,0,0,54.3,59.3a.6.6,0,0,0,.8-.2l4.2-4.2a1.2,1.2,0,0,1,1.5-.2,32.8,32.8,0,0,0,13,3.2A1.2,1.2,0,0,1,75,59.1Z"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
    <div class="frame-videocall" style="display:none" id="frame-video-overlay">

<div id="receiving-videos-container"></div>

      <div class="top-videocall">
        <div class="guest-pi">
          <div class="guest-photo">
            <img src="/images/background/avatar.png">
          </div>
          <div class="guest-id"></div>
        </div>

        <div class="by-fx">
          <div class="by-word">by</div>
          <div class="fx-logo">
            <svg viewBox="0 0 20 20"><defs><style>.by-logo{fill:#008bc6;}</style></defs><path class="by-logo" d="M10,0A10.1,10.1,0,0,0,6.1.8,9.9,9.9,0,0,0,2.9,2.9,10,10,0,0,0,0,10,9.9,9.9,0,0,0,10,20a10.1,10.1,0,0,0,3.9-.8,9.9,9.9,0,0,0,3.2-2.1A10,10,0,0,0,20,10,9.9,9.9,0,0,0,10,0Zm9.3,10a8.6,8.6,0,0,1-.7,3.6,12.1,12.1,0,0,1-2,3,12.1,12.1,0,0,1-3,2,8.6,8.6,0,0,1-3.6.7,8.6,8.6,0,0,1-3.6-.7,12.1,12.1,0,0,1-3-2,12.1,12.1,0,0,1-2-3A8.6,8.6,0,0,1,.7,10a8.6,8.6,0,0,1,.7-3.6,12.1,12.1,0,0,1,2-3,12.1,12.1,0,0,1,3-2A8.6,8.6,0,0,1,10,.7a8.6,8.6,0,0,1,3.6.7,12.1,12.1,0,0,1,3,2,12.1,12.1,0,0,1,2,3A8.6,8.6,0,0,1,19.3,10Z"/><path class="by-logo" d="M8.3,8.8,10,10.5l1.8-1.7a2.2,2.2,0,0,1,3.4,0l-3.5,3.5L13.5,14l.7.7-1.7,1.8L4.8,8.8,10,3.5l1.8,1.8Z"/><path class="by-logo" d="M7,13.5l1.7,1.8-.5.5a2.6,2.6,0,0,1-1.7.7,2.6,2.6,0,0,1-1.7-.7Z"/></g></svg>
          </div>
        </div>
      </div>

      <div class="bottom-videocall">

        <div class="call-btn">
          <a class="btn decline" id="guest-stop">
            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><style>.decline-red{fill:#ff3b30;}.phone-wh{fill:#efefef;}</style></defs><circle class="decline-red" cx="50" cy="50" r="50"/><path class="phone-wh" d="M39.9,54.7v-6a.6.6,0,0,1,.5-.6,39,39,0,0,1,19.2,0,.6.6,0,0,1,.5.6v6a1.1,1.1,0,0,0,.8,1.1,32.7,32.7,0,0,1,11.5,7,1.4,1.4,0,0,0,1.7,0L84.5,52.4a1.2,1.2,0,0,0-.1-1.8A49.8,49.8,0,0,0,60.1,37.9a49.1,49.1,0,0,0-20.2,0A49.8,49.8,0,0,0,15.6,50.6a1.2,1.2,0,0,0-.1,1.8L25.9,62.8a1.4,1.4,0,0,0,1.7,0,32.7,32.7,0,0,1,11.5-7A1.1,1.1,0,0,0,39.9,54.7Z"/></svg>
          </a>
        </div>
      </div>
    </div>
  </div>



<!--
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
-->
<!---------- video call ends ---------->





  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script>
  <!--<script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>-->



  <!-- SCRIPTS -->

  <script>
   $('#lower50').remove();
  </script>


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
        $('#old-discs').load(window.location.href+' #old-discs');
      }
    });
  }, 2000);
});
</script>

  <script>
    if(screen.width<629) {
      $('#page-header').html('<?php echo $guest?>');
      $('#page-header').attr('href','/user/<?php echo $guest?>');
      $('.footbar').hide();
      $('.discussions').hide();
      $('.header-sidebar').css('display','none');
      $('#back-butt').show();

      $('.chat').css('height', window.innerHeight);

      window.addEventListener('resize', () => {
        $('.chat').css('height', window.innerHeight);
      });
    } else {
      $('#page-header').html('Messages');
      $('#page-header').attr('href','/msg/inbox.php');
    }
  </script>

<script>/*
if(screen.width<629) {
  //$('#header-menu').html('<div class="msg-icon-cnt" id="video-call-btn"><svg style="width:100%" viewBox="0 0 32 32"><defs><style>.videocall-icon{fill:#212121;}</style></defs><path class="videocall-icon" d="M30,5.8a1.9,1.9,0,0,0-1,.3l-7.2,4.2v-2a4,4,0,0,0-4-4H4a4,4,0,0,0-4,4V23.7a4,4,0,0,0,4,4H17.8a4,4,0,0,0,4-4V21.6L29,25.9a1.9,1.9,0,0,0,1,.3,2,2,0,0,0,2-2V7.8A2,2,0,0,0,30,5.8ZM19.8,23.7a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V8.3a2,2,0,0,1,2-2H17.8a2,2,0,0,1,2,2Zm10.2.5-8.2-4.9V12.7L30,7.8Z"/></svg></div>');
  //$('#header-menu').css('visibility','hidden');
  
}*/
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

		var sendingVidQueue = 0;
                peer.onStreamAdded = function(e) {
                    var video = e.mediaElement;

		    if(sendingVidQueue==0) {
		      video.setAttribute('class', 'guest-video');
		      video.setAttribute('id', 'guest-video');
		      video.controls=false;
		      video.muted=true;

		      jQuery.ajax({
			url:'/php/set_msg.php',
			type:'POST',
			data: {clientId: <?php echo $get_user_id?>, guestId: <?php echo $guest_id?>, msgBody: 'Video call ...', msgType: 'video call'},
			success: function(response) {
			  console.log(response);
			}
		      });
		     
		    } else {
		      $('#calling-txt').hide();
		      $('#guest-video').removeClass('guest-video').addClass('host-video');
		      video.setAttribute('class', 'guest-video');
		      video.controls=false;
		    }
		    sendingVidQueue++;

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


jQuery.ajax({
  url:'/php/get_caller.php',
  type:'POST',
  data: {caller_username: userid},
  success: function(response) {
    console.log(response);
    
    if(response!='') {
      var caller_avatar_path = '/userpgs/avatars/'+response;
      $('.calling-content .photo img').prop('src', caller_avatar_path);
      $('.guest-photo img').prop('src', caller_avatar_path);
    }
  }
});

$('#video-income-overlay').show();
$('#caller-username').html(userid);
$('.guest-id').html(userid);
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
		    $('#guest-ignore').click(function() {
		      $('#video-income-overlay').hide();
		    });

		    
                };

		var videoQueue = 0;
                peer.onStreamAdded = function(e) {
                    var video = e.mediaElement;
                    video.setAttribute('width', 600);

		    if(videoQueue==0) {
 		      video.setAttribute('id', 'host-video');
		      video.setAttribute('class', 'host-video');
		      video.controls = false;
		      video.muted=true;
		    } else {
		      video.setAttribute('id', 'guest-video');
		      video.setAttribute('class', 'guest-video');
		      video.controls = false;
		    }
		    videoQueue++;
		    
                    videosContainer.insertBefore(video, videosContainer.firstChild);

		    // heeeeeeee

                    video.play();
                    rotateVideo(video);
                    scaleVideos();

		    $('#frame-calling-overlay').hide();
		    $('#frame-video-overlay').show();
		    
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

$('#host-stop').click(function() {
var streamingVid = document.querySelector('video');

const stream = streamingVid.srcObject;
const tracks = stream.getTracks();

tracks.forEach(function(track) {
track.stop();
});

console.log('video stream stopped');

$('#video-overlay').hide();

window.location.reload();
});
</script> 


<script>
$('#send-btn').click(function(event) {
  event.stopPropagation();
  if($('#inputMsgTxt').val()=='') {
    
  } else {
    $('#sendMsg').submit();
  }
});
</script>

<script>
$('#search-friends').each(function() {
  var elem = $(this);

  elem.data('oldVal', elem.val());

  elem.bind("propertychange change click keyup input paste", function(event) {
    if(elem.data('oldVal')!=elem.val()) {
      elem.data('oldVal', elem.val());

      if(elem.val()=='') {
          $('#friend-search').hide();
    	  $('#old-discs').show();
      } else {
          $('#friend-search').show();
    	  $('#old-discs').hide()
      }

      jQuery.ajax({
        type:'POST',
	url:'/php/search_friends.php',
	data: $(this).serialize() + '&hostUserId=<?php echo $get_user_id?>',
	success: function(response) {
	  console.log(response)
	  if(response==0) {
	    $('#friend-search').html('<p class="gray" style="text-align:center">No friends found</p>');
	  } else {
	    $('#friend-search').html(response);
	  }
	  
	}
      });
    }
  });
});
</script>

<script>
$('#file-btn').click( function() {
  $('#file-input').click();
});

$('#file-input').change(function() {
  $('#file-form').submit();
});
</script>

<!-- FILE UPLOAD -->
<script>
$(function() {
  $('#file-form').ajaxForm(function(response) {
    
    if(response==0) {
      alert('Failed to send the file. Please try again.');
    } else {
      $('#file-input').val('');
      $('#inputMsgTxt').val('');
      $('#inputMsgTxt').focus();
      $('.message-chat').append(response);
      $('.message-chat').scrollTop($('.message-chat')[0].scrollHeight);
    }
  });
});
</script>


</body>
</html>
