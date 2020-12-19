<?php
session_start();
require('../register/connect.php');
header("Cache-Control: no cache");

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: /');
}

if(isset($_GET['q'])) {

        $kw = $_GET['q'];
	

	if(isset($_GET['type']) && !empty($_GET['type'])) {
	  $type = $_GET['type'];
}


	      $course_q = 'SELECT * FROM teacher WHERE (header LIKE "%'.$kw.'%") OR (description LIKE "%'.$kw.'%") ORDER BY id DESC';
    	      $course_result = mysqli_query($connection, $course_q);
    	      $course_count = mysqli_num_rows($course_result);



  	  $user_q = "SELECT id,username,fname,lname FROM user WHERE (username LIKE '%$kw%') OR (fname LIKE '%$kw%') OR (lname LIKE '%$kw%') ORDER BY id DESC";
	  $user_r = mysqli_query($connection,$user_q) or die(mysqli_error($connection));
	  $user_count = mysqli_num_rows($user_r);



	
// SELECT * FROM teacher WHERE (header LIKE '%$kw%') OR (description LIKE '%$kw%')
}


require('../php/get_user.php');

// fetch the sonet records
require('../userpgs/sonet/following.php');

$id=$get_user_id;
require('../userpgs/php/notif.php');

require('../php/get_plans.php');

require('../php/get_rel.php');

require('../wallet/php/get_fxcoin_count.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>fxSearch</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/styles.css">
  <link rel="stylesheet" href="/css/icons.css">
  <link rel="stylesheet" href="/css/logo.css">
  <script src="/js/jquery-3.4.1.min.js"></script>
</head>

<body>
	<div class="header-sidebar"></div>
  <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>

  <div class="blur mobile-main">

   <div class="sidebar"></div>
<?php require('../php/sidebar.php'); ?>


<?php if(isset($_GET['q'])) { ?>

<div class="main-content">

              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="<?php echo '/search?q='.$kw; ?>" class="link-main" <?php if(isset($_GET['q']) && !empty($_GET['q']) && !isset($_GET['type'])) echo 'id="active-main"'; ?>>
                          <div class="head">Users <?php if(isset($_GET['q']) && !empty($_GET['q'])) echo '('.$user_count.')'; ?></div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="<?php echo '/search?q='.$kw.'&type=course'; ?>" class="link-main" <?php if(isset($_GET['type']) && !empty($_GET['type'])) echo 'id="active-main"'; ?>>
                          <div class="head">Courses <?php if(isset($_GET['q']) && !empty($_GET['q'])) echo '('.$course_count.')';?></div>
                      </a>
                  </li>
                  
              </ul>

    </div>
<?php } ?>






  <div class="relative-main-content">
    

<form method="GET" action="/search">
      <input type="text" name="q" autofocus class="txt-input" placeholder="Search fxUnivers" <?php if(isset($_GET['q']) && !empty($_GET['q'])) echo 'value="'.$_GET['q'].'"';?> required>
      <?php if(isset($_GET['type']) && !empty($_GET['type']))
      echo '<input type="hidden" name="type" value="'.$_GET['type'].'">';
      ?>
      <input type="submit" value="Search" class="submit-btn">
      
</form>




<?php
if($type=='course') {

    require('../php/limit_str.php');

    

		 if($course_count>0) {

		   echo '<div class="obj-box">';

		 	while($row3=$course_result->fetch_assoc()) {
                            $coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$row3['id'];
                            $coursecounter_r=mysqli_query($connection,$coursecounter_q);
                            $coursecounts=mysqli_num_rows($coursecounter_r);
			    
			    echo '<div class="object" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$row3['id'].'\';">';

			    echo '<div class="preview">
				  <img src="/images/background/course.svg">
				</div>
				<div class="details">';

			    $ctitle=preg_replace("/<br\W*?\/>/"," ",$row3['header']);
			    
			    echo '<p><strong>';
			    echo limited($ctitle,40).'</strong></p>';
			    
			    $descrip=preg_replace("/<br\W*?\/>/"," ",$row3['description']);
			    echo '<p>';
			    echo limited($descrip,85).'</p>';

			    
			    echo '<div class="detail-bottom">
				    <div class="little-box blue-bg">
				      '.$coursecounts.' <span>students</span>
				    </div>';
				    
			   /*if($row3['cost']>0) {	  
				    echo '<div class="little-box gold-bg">
				      '.$row3['cost'].' <span>fxStars</span>
				    </div>';
			    } else {
			      	   echo '<div class="little-box green-bg" style="padding: 4px 20px;">
				      Free
				    </div>';
			    }*/



			    if($row3['biddable']) {
			     require_once('../wallet/php/wallet_connect.php');
			     $locked_q = 'SELECT * FROM locked WHERE course_id='.$row3['id'];
			     $locked_r = mysqli_query($wallet_connection,$locked_q);
			     $locked_count = mysqli_num_rows($locked_r);
			     
			     

			     if($locked_count>0) {
			       $locked=mysqli_fetch_array($locked_r);
			       if($locked['finalized']) {
			         echo '<div class="little-box gold-bg">
				      <span>Sold</span> '.$locked['raw_amount'].' <span>fxStars</span>
				    </div>';
		               } else {
			         echo '<div class="little-box chocolate-bg">
				      <span>High </span> '.$locked['raw_amount'].' <span>fxStars</span>
				    </div>';
		               }
			     } else {
			       echo '<div class="little-box chocolate-bg">
				      <span>Base </span> '.$row3['cost'].' <span>fxStars</span>
				    </div>';
		             }
		           } else {

			      if($row3['cost']>0) {	  
				    echo '<div class="little-box gold-bg">
				      '.$row3['cost'].' <span>fxStars</span>
				    </div>';
			      } else {
			      	   echo '<div class="little-box green-bg" style="padding: 4px 20px;">
				      Free
				    </div>';
			      }

			   }




			    echo '<div class="little-box gray-bg"><span>'.date("M jS, Y", strtotime($row3['start_date'])).'</span></div>';

			    echo ' </div>
				  </div>
				  </div>';
			}
		  	    
		 echo '</div>';	      

		 } else {
		   echo '<p class="gray">No courses found</p>';
		   }

} else {
                echo '<div class="col-33 mid-col">';
                if($user_r->num_rows > 0) {
		  require('../wallet/php/wallet_connect.php');
		  require('../php/limit_str.php');
		  
		  echo '<div class="obj-box">';

		    while($row = $user_r->fetch_assoc()) {


		      $fxstar_q = 'SELECT * FROM link WHERE userId='.$row['id'];
		      $fxstar_r = mysqli_query($wallet_connection, $fxstar_q) or die(mysqli_error($wallet_connection));
		      $fxstars = mysqli_num_rows($fxstar_r);
		      


                        echo '<div class="object" onclick="location.href=\'/user/'.$row['username'].'\';">';

                        echo '<div class="preview">
			       <img src="/images/background/avatar.png">
			     </div>

			     <div class="details">';

			echo '<p><strong>'.$row['fname'].' '.$row['lname'].' @'.$row['username'].'</strong></p>';
			echo '<p>'.$row['fname'].' '.$row['lname'].'</p>';
			echo '<p>'.$row['bio'].'</p>';

			echo '<div class="detail-bottom">';

			if($fxstars>0) {
			  echo '<div class="little-box gold-bg"><span>'.$fxstars.' fxStars</span></div>';
			} else {
			  echo '<div class="little-box gray-bg"><span>0 fxStars</span></div>';
			}
			echo '</div>';
			
                        echo '</div></div>';

                    }
                    $user_r->free();

		    echo '</div>';
                } else {
		  echo '<p class="gray">No users found</p>';
		  }
                echo '</div>';
}
?>





  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>




  <script>
    $('#page-header').html('Notifications');
    $('#page-header').attr('href','/userpgs/notif');
  </script>

  <div class="footbar"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>



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
                $('#notif_a').addClass('blink');
            }

            jQuery.ajax({
              type: 'POST',
              url: '/php/msg_icon.php',
              data: {msg_userId: notifUserId},
              success: function(result) {
                    if(result>0) {
                        $('#msg_bar').addClass('blink');
                    }
              }
            });
      }
    });
  }, 2000);
});
</script>
</body>
</html>
