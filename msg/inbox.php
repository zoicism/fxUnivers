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


if(isset($_GET['plan'])) {
	$plan = $_GET['plan'];
}


require('../userpgs/php/notif.php');

$get_user_id = $id;
require('../php/get_plans.php');

require('../php/get_rel.php');

require('../wallet/php/get_fxcoin_count.php');

require('../php/get_msg.php');

// set readd=1 in messenger DB
require('../contact/message_connect.php');
$readd_query="UPDATE messenger SET readd=1 WHERE (user2id=$get_user_id AND readd=0)";
$readd_result=mysqli_query($msg_connection,$readd_query) or die(mysqli_error($msg_connection));


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

	    echo '<li class="discussion" tabindex="1" onclick="location.href=\'/msg/messenger.php?guest='.$get_guest["username"].'\';">';
	        echo '<div class="photo"></div>';
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

        <section class="chat" >

	<p class="gray">Choose a friend and continue messaging.</p>
              
        </section>
      </div>
  </div>
  </div>


  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script>



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
    $('#page-header').html('Messages');
    $('#page-header').attr('href','/msg');
  </script>

<script>
$('.chat').hide();
</script>
</body>
</html>
