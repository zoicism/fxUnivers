<?php
if(isset($_POST['user_id'])) $get_user_id=$_POST['user_id'];
require('get_msg.php');
          if($get_msg_count>0) {
            while($row = $get_msg_result->fetch_assoc()) {



		  
                        if($row['user1id']==$get_user_id) {
                            $sidebar_guest_id = $row['user2id'];
                        } else {
                            $sidebar_guest_id = $row['user1id'];
                        }
                        require('../php/get_guest.php');

	    echo '<li class="discussion" tabindex="1" onclick="location.href=\'/msg/messenger.php?guest='.$get_guest["username"].'\';">';
	        echo '<div class="photo" style="background-image: url(http://www.boutique-uns.com/uns/185-home_01grid/polo-femme.jpg);"></div>';
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