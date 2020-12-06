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
</head>

<body>
	<div class="header-sidebar"></div>
  <script src="/js/upperbar.js"></script>

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
	        echo '<div class="photo" style=""></div>';
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


  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script>



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
console.log('scrolled');
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
	console.log('ok');
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

</body>
</html>
