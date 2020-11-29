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


	    <?php
          if($get_msg_count>0) {
            while($row = $get_msg_result->fetch_assoc()) {
              
		  
                        if($row['user1id']==$get_user_id) {
                            $guest_id = $row['user2id'];
                        } else {
                            $guest_id = $row['user1id'];
                        }
                        require('../php/get_guest.php');


	    echo '<li class="discussion" tabindex="1" onclick="location.href=\'/msg/'.$get_guest["username"].'\';">';
	        echo '<div class="photo" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>';
	        echo '<div class="desc-contact">';

	         echo '<p class="name">'.$get_guest['username'].'</p>';
                                   
                        echo '<p class="message">'.$row['text'].'</p>';
                        
	      echo '</div></li>';
            }
          } else {
                    echo '<p style="color:gray">No conversations started yet</p>';
                }
  ?>

	    
	    
            <li class="discussion" tabindex="1">
              <div class="photo" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>
                  <div class="desc-contact">
                    <p class="name">Elsie Amador</p>
                    <p class="message">Lorem ipsum dolor sit amet</p>
                  </div>
            </li>
            <li class="discussion" tabindex="1">
              <div class="photo" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>
                  <div class="desc-contact">
                    <p class="name">Elsie Amador</p>
                    <p class="message">Lorem ipsum dolor sit amet</p>
                  </div>
            </li>
            <li class="discussion" tabindex="1">
              <div class="photo" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>
                  <div class="desc-contact">
                    <p class="name">Elsie Amador</p>
                    <p class="message">Lorem ipsum dolor sit amet</p>
                  </div>
            </li>
            <li class="discussion" tabindex="1">
              <div class="photo" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>
                  <div class="desc-contact">
                    <p class="name">Elsie Amador</p>
                    <p class="message">Lorem ipsum dolor sit amet</p>
                  </div>
            </li>
            <li class="discussion" tabindex="1">
              <div class="photo" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>
                  <div class="desc-contact">
                    <p class="name">Elsie Amador</p>
                    <p class="message">Lorem ipsum dolor sit amet</p>
                  </div>
            </li>
            <li class="discussion" tabindex="1">
              <div class="photo" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>
                  <div class="desc-contact">
                    <p class="name">Elsie Amador</p>
                    <p class="message">Lorem ipsum dolor sit amet</p>
                  </div>
            </li>
            <li class="discussion" tabindex="1">
              <div class="photo" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>
                  <div class="desc-contact">
                    <p class="name">Elsie Amador</p>
                    <p class="message">Lorem ipsum dolor sit amet</p>
                  </div>
            </li>
            <li class="discussion" tabindex="1">
              <div class="photo" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>
                  <div class="desc-contact">
                    <p class="name">Elsie Amador</p>
                    <p class="message">Lorem ipsum dolor sit amet</p>
                  </div>
            </li>
            <li class="discussion" tabindex="1">
              <div class="photo" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>
                  <div class="desc-contact">
                    <p class="name">Elsie Amador</p>
                    <p class="message">Lorem ipsum dolor sit amet</p>
                  </div>
            </li>
          </ul>
        </div>

        <section class="chat">
          <div class="header-chat">
                <p class="name">Elsie Amador</p>
              </div>


              <div class="message-chat">
                <div class="messages message-recieved">
                  <p>Hello! Whatsup?</p>
                  <span class="time">6:35 AM</span>
                </div>
                <div class="messages message-recieved">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                  <span class="time">6:35 AM</span>
                </div>
                <div class="messages message-sent">
                  <p>Hey Elsie! Fine</p>
                  <span class="time">6:35 AM</span>
                </div>
                <!-- uploaded file starts -->
                <div class="messages message-sent upload-container">
                  <div class="upload-sent">
                    <img src="/images/background/file-sent.svg">
                  </div>
                  <div class="file-name">image.png<div>2.5 MB</div></div>
                  <span class="time">6:35 AM</span>
                </div>
                <!-- uploaded file ends -->
                <div class="messages message-recieved upload-container">
                  <div class="upload-recieved">
                    <img src="/images/background/file-recieved.svg">
                  </div>
                  <div class="file-name">image.png<div>2.5 MB</div></div>
                  <span class="time">6:35 AM</span>
                </div>

                <div class="messages message-sent">
                  <p>Noway!!! Hell yeah i'm coming! I'll meet you guys at the bar at night. Alright?</p>
                  <span class="time">6:35 AM</span>
                </div>
                <div class="messages message-recieved">
                  <p>I knew it... Owkey then. See ya</p>
                  <span class="time">6:35 AM</span>
                </div>
                <div class="messages message-sent">
                  <p>Noway!!! Hell yealoremh i'm coming! I'll meet you guys at the bar at night. Alright? Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullaaborum.</p>
                  <span class="time">6:35 AM</span>
                </div>
                <div class="messages message-recieved">
                  <p>I knew it... Owkey then. See ya</p>
                  <span class="time">6:35 AM</span>
                </div>
              </div>


              <div class="footer-chat">

                <div class="image-upload">
                  <label for="file-input">
                    <img src="/images/background/plus.svg" class="chat-icon">
                  </label>
                  <input id="file-input" type="file" multiple>
                </div>

                <input type="text" placeholder="Type your message here"></input>
                <a href="#"><img src="/images/background/send.svg" class="chat-icon"></a>
              </div>
        </section>
      </div>
  </div>
  </div>


  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script>




  <script>
    $('#page-header').html('Messages');
    $('#page-header').attr('href','/msg');
  </script>
</body>
</html>
