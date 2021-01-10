<?php
require_once('../register/connect.php');

if(isset($_POST['fnd-srch-q'])) {
  $search_key = mysqli_real_escape_string($connection,$_POST['fnd-srch-q']);
  $hostId = $_POST['hostUserId'];
  
  $search_q = "SELECT id,username,fname,lname,avatar,bio FROM user WHERE (username LIKE '%$search_key%') OR (fname LIKE '%$search_key%') OR (lname LIKE '%$search_key%') ORDER BY id DESC";
  $search_r = mysqli_query($connection,$search_q);
  $search_count = mysqli_num_rows($search_r);

  $user_div = '';
  if($search_count>0) {
    while($row = $search_r -> fetch_assoc()) {
      $fnd_slct_q = 'SELECT * FROM friend WHERE (user1='.$hostId.' AND user2='.$row['id'].') OR (user2='.$hostId.' AND user1='.$row['id'].')';
      $fnd_slct_r = mysqli_query($connection,$fnd_slct_q);
      $fnd_slct_count = mysqli_num_rows($fnd_slct_r);

      if($fnd_slct_count>0) {
      
        if($row['avatar']!=NULL) {
      	  $avatar_url='/userpgs/avatars/'.$row['avatar'];
  	} else {
          $avatar_url='/images/background/avatar.png';
	}


        $user_div .= '

		<li class="discussion" tabindex="1" onclick="location.href=\'/msg/'.$row['username'].'\';">
    		  <div class="photo" style="background-image:url(\''.$avatar_url.'\');"></div>
    		  <div class="desc-contact">
      		    <p class="name">'.$row['fname'].' '.$row['lname'].' @'.$row['username'].'</p>
      		    <p class="message">'.$row['bio'].'</p>
    		    </div>
  		  </div>
		</li>

		    ';

      } 
            
    }

    if($user_div=='') {
      echo 0;
    } else {
      echo $user_div;
    }
  } else {
    echo 0;
  }
    
}
?>