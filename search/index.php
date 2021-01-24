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

        $kw = mysqli_real_escape_string($connection,$_GET['q']);
	

	if(isset($_GET['type']) && !empty($_GET['type'])) {
	  $type = $_GET['type'];
}


	      $course_q = "SELECT * FROM teacher WHERE ((UPPER(header) LIKE UPPER('%$kw%')) OR (UPPER(description) LIKE UPPER('%$kw%'))) AND alive=1 ORDER BY id DESC";
    	      $course_result = mysqli_query($connection, $course_q);
    	      $course_count = mysqli_num_rows($course_result);



  	  $user_q = "SELECT id,username,fname,lname,avatar FROM user WHERE (UPPER(username) LIKE UPPER('%$kw%')) OR (UPPER(fname) LIKE UPPER('%$kw%')) OR (UPPER(lname) LIKE UPPER('%$kw%')) ORDER BY id DESC";
	  $user_r = mysqli_query($connection,$user_q) or die(mysqli_error($connection));
	  $user_count = mysqli_num_rows($user_r);

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

<div class="main-content" style="display:block !important;">

              <ul class="main-flex-container" style="flex-flow:row nowrap;">
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
    

<form method="GET" action="/search" class="search-form">
<div class="search-form" style="display:flex;flex-flow:row nowrap;margin-top:20px;">
      <input type="text" name="q" style="margin:0;margin-right:20px;" autofocus class="txt-input" placeholder="Search fxUnivers" <?php if(isset($_GET['q']) && !empty($_GET['q'])) echo 'value="'.$_GET['q'].'"';?> required>
      <?php if(isset($_GET['type']) && !empty($_GET['type']))
      echo '<input type="hidden" name="type" value="'.$_GET['type'].'">';
      ?>
      <a class="search-button" id="search-btn" style="min-width:38px;height:38px;box-shadow: -6px -6px 14px rgba(255, 255, 255, .7), -6px -6px 10px rgba(255, 255, 255, .5), 6px 6px 8px rgba(255, 255, 255, .075), 6px 6px 10px rgba(0, 0, 0, .15);border-radius:50px;padding:9px;"><svg aria-label="search" viewBox="0 0 32 32" style="width:100%;height:100%;">
                      <path class="stroked" d="M24.3,22.8a13.8,13.8,0,0,0,3.2-10.3A13.9,13.9,0,0,0,14.7,0,13.9,13.9,0,0,0,0,14.8,14,14,0,0,0,12.5,27.6a14.1,14.1,0,0,0,10.3-3.3l7.5,7.4a1,1,0,0,0,1.4,0h0a1,1,0,0,0,0-1.4ZM13.8,25.6A11.8,11.8,0,1,1,25.6,13.8a11.3,11.3,0,0,1-2.8,7.6l-1.4,1.4A11.3,11.3,0,0,1,13.8,25.6Z" style="display: none;"></path>
                      <path class="filled" d="M31.4,28.6l-6.5-6.5a14,14,0,0,0,2.7-8.3A13.8,13.8,0,1,0,13.8,27.6a14,14,0,0,0,8.3-2.7l6.5,6.5a1.9,1.9,0,0,0,2.8,0A1.9,1.9,0,0,0,31.4,28.6Zm-17.6-5a9.8,9.8,0,1,1,9.8-9.8A10.1,10.1,0,0,1,22,19.2,9.3,9.3,0,0,1,19.2,22,10.1,10.1,0,0,1,13.8,23.6Z" style="display: inline;"></path>
                    </svg></a>
      <input type="submit" style="display:none" value="Search" class="submit-btn">
  </div>    
</form>




<?php
if($type=='course') {

    require('../php/limit_str.php');

    function get_string_between($string, $start, $end){
    		      $string = ' ' . $string;
    		      $ini = strpos($string, $start);
    		      if ($ini == 0) return '';
    		      $ini += strlen($start);
    		      $len = strpos($string, $end, $ini) - $ini;
    		      return substr($string, $ini, $len);
		    }

		 if($course_count>0) {
		 

		   echo '<div class="obj-box">';

		 	while($row3=$course_result->fetch_assoc()) {
                            $coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$row3['id'];
                            $coursecounter_r=mysqli_query($connection,$coursecounter_q);
                            $coursecounts=mysqli_num_rows($coursecounter_r);


			    $teacher_un_q = 'SELECT username,verified FROM user WHERE id='.$row3['user_id'];
			    $teacher_un_r = mysqli_query($connection,$teacher_un_q);
			    $teacher_un_f = mysqli_fetch_array($teacher_un_r);
			    $teacher_un = $teacher_un_f['username'];
			    $teacher_verified = $teacher_un_f['verified'];
			    
			    
			    echo '<div class="object" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$row3['id'].'\';">';


if($row3['video_url']!=null) {
			    $video_id = get_string_between($row3['video_url'],'embed/','" frameborder');
			        echo '<div class="preview">
				  <img src="https://img.youtube.com/vi/'.$video_id.'/0.jpg">
				</div>';
			    } else {
			        echo '<div class="preview">
				  <img src="/images/background/course.svg" style="height:100px;width:100px;">
				</div>';
			    }

echo '<div class="details">';


			    $ctitle=preg_replace("/<br\W*?\/>/"," ",$row3['header']);
			    
			    echo '<p><strong>';
			    echo limited($ctitle,40).'</strong></p>';
			    
			    /*
			    $descrip=preg_replace("/<br\W*?\/>/"," ",$row3['description']);
			    echo '<p>';
			    echo limited($descrip,85).'</p>';
			    */


			    if($teacher_verified) {
			      echo '<div class="little-box teacher-id">'.$teacher_un.' <img src="/images/background/verified.png" style="width:1rem; height:1rem;"></div>';
			    } else {
			      echo '<div class="little-box teacher-id">'.$teacher_un.'</div>';
			    }


			    
			    echo '<div class="detail-bottom">
			    	   <div class="detail-row">
				    <div class="little-box blue-bg">
				      '.$coursecounts.' <span>students</span>
				    </div>
				    <div class="little-box"><span>'.date("M jS, Y", strtotime($row3['start_date'])).'</span></div>
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
			         echo '<div class="price gray-bg">
				      <span>Sold</span> '.$locked['raw_amount'].' <span>fxStars</span>
				    </div>';
		               } else {
			         echo '<div class="price purple-bg">
				      <span>High </span> '.$locked['raw_amount'].' <span>fxStars</span>
				    </div>';
		               }
			     } else {
			       echo '<div class="price purple-bg">
				      <span>Base </span> '.$row3['cost'].' <span>fxStars</span>
				    </div>';
		             }
		           } else {

			      if($row3['cost']>0) {	  
				    echo '<div class="price gold-bg">
				      '.$row3['cost'].' <span>fxStars</span>
				    </div>';
			      } else {
			      	   echo '<div class="price green-bg" style="padding: 4px 20px;">
				      Free
				    </div>';
			      }

			   }




			    

			    echo ' </div>
				  </div>
				  </div>';
			}
		  	 $course_result->free();   
		 echo '</div>';	      

		 } else {
		   echo '<p class="gray">No courses found</p>';
		   }

} else {
                //echo '<div class="col-33 mid-col">';
                if($user_r->num_rows > 0) {
		  require('../wallet/php/wallet_connect.php');
		  require('../php/limit_str.php');
		  
		  echo '<div class="obj-box">';

		    while($row = $user_r->fetch_assoc()) {


		      $fxstar_q = 'SELECT * FROM link WHERE userId='.$row['id'];
		      $fxstar_r = mysqli_query($wallet_connection, $fxstar_q) or die(mysqli_error($wallet_connection));
		      $fxstars = mysqli_num_rows($fxstar_r);
		      


                        echo '<div class="object-user" onclick="location.href=\'/user/'.$row['username'].'\';">';

			if($row['avatar']==NULL) {
                          echo '<div class="preview-user">
			       <img src="/images/background/avatar.png">
			     </div>';
			} else {
			  echo '<div class="preview-user">
			          <img src="/userpgs/avatars/'.$row['avatar'].'">
				</div>';
		        }

			     echo '<div class="details-user">';

			echo '<p><strong>'.$row['username'].'</strong></p>';
			echo '<p>'.$row['fname'].' '.$row['lname'].'</p>';
			//echo '<p>'.$row['bio'].'</p>';

			echo '<div class="detail-bottom">';

			if($fxstars>0) {
			  echo '<div class="little-box"><span>'.$fxstars.' fxStars</span></div>';
			} else {
			  echo '<div class="little-box"><span>0 fxStars</span></div>';
			}
			echo '</div>';
			
                        echo '</div></div>';

                    }
                    $user_r->free();

		    echo '</div>';
                } else {
		  if(isset($_GET['q']) && !empty($_GET['q'])) {
		    echo '<p class="gray">No results found</p>';
		  }
		}
               // echo '</div>';
}
?>





  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

<script>
if(screen.width<629) {
  $('.main-content').css('margin','0').css('padding','0');
}
</script>


  <script>
    $('#page-header').html('Search');
    $('#page-header').attr('href','/search');
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

<script>
  $('#nav-search .filled').show();
  $('#nav-search .stroked').hide();
</script>

<script>
  $('#search-btn').click(function() {
    $('.search-form').submit();
  });
</script>
</body>
</html>
