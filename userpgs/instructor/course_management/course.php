<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/
  session_start();
  require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
	header("Location: /register/logout.php");
}

  if(isset($_GET['course_id'])) $course_id = $_GET['course_id'];

  $course_query = "SELECT * FROM `teacher` WHERE id=$course_id AND alive=1";
  $course_result = mysqli_query($connection, $course_query) or die(mysqli_error($connection));
  $course_fetch = mysqli_fetch_array($course_result);

  $course_count=mysqli_num_rows($course_result);
  if($course_count!=1) {
    header('Location: /error');
  }

  $user_id = $course_fetch['user_id'];
  $get_course_teacher_id = $user_id;
  $header = $course_fetch['header'];
  $description = $course_fetch['description'];
  $video = $course_fetch['video_url'];
  $s_date = $course_fetch['start_date'];
  $e_date = $course_fetch['exam_date'];
  $cost = $course_fetch['cost'];
  $test_date = $course_fetch['test_date'];
  $course_biddable=$course_fetch['biddable'];

  


  require('../../../php/get_user.php');
  $id = $get_user_id;
require('../php/classes.php');
  require('../../php/notif.php');

  require('../../../php/get_user_type.php');

  require('../../../php/get_exam.php');
$get_exam_fetch=mysqli_fetch_array($get_exam_result);

require('../../../php/get_stucourse.php');

  require('../../../wallet/php/get_fxcoin_count.php');

$tar_id=$get_course_teacher_id;
require('../../../php/get_tar_id.php');


?>

<!DOCTYPE html>
<html>
<head>
	<title>fxUniversity</title>
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
    <?php require('../../../php/sidebar.php'); ?>
    
    <div class="main-content">
      
      <ul class="main-flex-container">
        <li class="main-items">
                      <a href="/userpgs/instructor" class="link-main" <?php if($user_type=='instructor') echo 'id="active-main"'; ?>>
                        <div class="head">Teach</div>
                      </a>
        </li>
        <li class="main-items">
          <a href="/userpgs/student" class="link-main" <?php if($user_type!='instructor') echo 'id="active-main"'; ?>>
            <div class="head">Learn</div>
          </a>
        </li>
        
      </ul>
      
    </div>
          

    <div class="relative-main-content">

      <div class="course-content">
      
	<div class="left-content">
	  <!-- VIDEO -->
	  <?php
	   $path='videos/';
	   $file_ex=glob($path.$course_id.'.*');
	   if(count($file_ex)>0) {
	      $vid_arr=explode('.', $file_ex[0]);
	      $vid_ext=end($vid_arr);
	  ?>

	  <video width="560" height="315" controls>
            <source src="<?php echo 'videos/'.$course_id.'.'.$vid_ext ?>" type="video/<?php echo $vid_ext?>"> 
	  </video>

	  <!-- Title, description, and info -->
	  <?php
	   } elseif($video!='') {
	     echo '<div class="video-holder">';
         	   echo $video;
	     echo '</div>';
	   } else {

	   ?>

	   <div class="video-placeholder">
         	   <img src="/images/background/novid.svg">
		   	   <p>No video</p>	
	   </div>






<?php

	   }



if($tar_user_fetch['avatar']!=NULL) {
      $avatar_url='/userpgs/avatars/'.$tar_user_fetch['avatar'];
} else {
      $avatar_url='/images/background/avatar.png';
}



 	     echo '<div class="pub-avatar"  onclick="location.href=\'/user/'.$tar_user_fetch['username'].'\'">';
	     	  echo '<div class="pub-img avatar" style="background-image:url(\''.$avatar_url.'\');">';
		  echo '</div>';
		  echo '<div class="pub-name">';
		  echo '<p class="fullname">'.$tar_user_fetch['fname'].' '.$tar_user_fetch['lname'].'</p>';
		  if($tar_user_fetch['verified']) {
		    echo '<p>@'.$tar_user_fetch['username'].' <img src="/images/background/verified.png" style="width:1rem; height:1rem;"></p>';
		  } else {
		    echo '<p>@'.$tar_user_fetch['username'].'</p>';
		  }
		  echo '</div>';
	     echo '</div>';
	     echo '<h2>'.$header.'</h2>';
             echo '<p>'.$description.'</p>';
?>
	  
<div class="detail-bottom">

<?php
$coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$course_id;
                            $coursecounter_r=mysqli_query($connection,$coursecounter_q);
                            $coursecounts=mysqli_num_rows($coursecounter_r);
?>



	  <div class="little-box gray-bg">
	    <?php echo $class_num.' <span>sessions</span>'; ?>
	  </div>

	<div class="little-box blue-bg">
	  <?php echo $coursecounts.' <span>students</span>'; ?>
	</div>


	  <?php
	  if($course_biddable) {
	  } else {
	    if($cost>0) {	  
				    echo '<div class="little-box gold-bg">
				      '.$cost.' <span>fxStars</span>
				    </div>';
			    } else {
			      	   echo '<div class="little-box green-bg" style="padding: 4px 20px;">
				      Free
		    </div>';
	    }
	  }

echo '<div class="little-box gray-bg"><span>'.date("M jS, Y", strtotime($s_date)).'</span></div>';

			    ?>
 </div>





	  
	</div>
	<div class="right-content">
	  <?php
                require('../../../php/limit_str.php');



if($user_type=='instructor') {
			     echo '<div class="options">';



    if($course_biddable) {

      require_once('../../../wallet/php/wallet_connect.php');
      
      $bidding_q="SELECT * FROM locked WHERE course_id=$course_id";
      $bidding_r=mysqli_query($wallet_connection,$bidding_q) or die(mysqli_error($wallet_connection))
;

      $bidding_finalized=0;
      if($bidding_r->num_rows > 0) {
	$bidding=mysqli_fetch_array($bidding_r);
	if($bidding['finalized']) $bidding_finalized=1;

	$sold2user_q = 'SELECT * FROM user WHERE id='.$bidding['from_id'];
	$sold2user_r=mysqli_query($connection,$sold2user_q) or die(mysqli_error($connection));
	if($sold2user_r) $sold2user=mysqli_fetch_array($sold2user_r);
      }


      if($bidding_finalized) {
        echo '<div class="add-box">
	  <p>Sold to <a href="/user/'.$sold2user['username'].'">@'.$sold2user['username'].'</a> for '.$bidding['raw_amount'].' fxStars</p>
	  </div>';
      } else {
        echo '<div class="add-box">
               Accept Bid (<span id="highest-ins"></span>) <img src="/images/background/checkbox.svg" id="acceptBid">
	    </div>';
      }
    }





			     echo '<div class="add-box">Manage Course <img src="/images/background/manage.svg" onclick="location.href=\'/userpgs/instructor/course_management/edit_course.php?course_id='.$course_id.'\';"></div>';

			     echo '<div class="add-box">Add Session <img src="/images/background/add.svg" onclick="location.href=\'/userpgs/instructor/class/new_class.php?course_id='.$course_id.'\';"></div>';

			     
			     echo '<div class="add-box">Manage Test <img src="/images/background/exam.svg" id="manageTestId"></div>';
			     

			     echo '</div>';
} elseif($user_type=='student') {
echo '<div class="options">';
echo '<div class="add-box">Take the Test <img src="/images/background/exam.svg" id="examId"></div>';
echo '<form action="/userpgs/instructor/exam/take_exam.php" id="goToExam" method="POST" style="display:none"><input type="hidden" name="course_id" value="'.$course_id.'"></form>';
echo '</div>';
} else {
  
    echo '<div class="options">';

    if($course_biddable) {


    require_once('../../../wallet/php/wallet_connect.php');
      
      $bidding_q="SELECT * FROM locked WHERE course_id=$course_id";
      $bidding_r=mysqli_query($wallet_connection,$bidding_q);

      
      
      $bidding_finalized=0;
      if($bidding_r->num_rows > 0) {
	$bidding=mysqli_fetch_array($bidding_r);
	if($bidding['finalized']) $bidding_finalized=1;

	$sold2user_q = 'SELECT * FROM user WHERE id='.$bidding['from_id'];
	$sold2user_r=mysqli_query($connection,$sold2user_q) or die(mysqli_error($connection));
	if($sold2user_r) $sold2user=mysqli_fetch_array($sold2user_r);
      }

      if($bidding_finalized) {
        echo '<div class="add-box">
	  <p>Sold to <a href="/user/'.$sold2user['username'].'">@'.$sold2user['username'].'</a> for '.$bidding['raw_amount'].' fxStars</p>
	  </div>';
      } else {


        echo '<div>Make an offer: <p>Highest offer: <span id="highest">'.$cost.'</span> fxStars</p>
	       <form id="bidForm">
	         <input type="number" name="amount" class="num-input" id="offer-input" placeholder="Your offer" min="1" required>
		 <p>Total cost: <span id="totalOfferCost">0</span> fxStars</p>
		 <input type="hidden" name="from_id" value="'.$get_user_id.'">
		 <input type="hidden" name="course_id" value="'.$course_id.'">
		 <input type="hidden" name="to_id" value="'.$get_course_teacher_id.'">
		 <input type="hidden" name="initial_bid" value="'.$cost.'">
		 
		 
	         <input type="submit" class="submit-btn" value="Make Offer">
	       </form>
              </div>';
      }
    } else {
    
        echo '<div class="add-box">Purchase Course <img src="/images/background/checkbox.svg" id="purchbutt"></div>';
	
    }
    echo '</div>';
  
}



echo '<div class="sessions">';
echo '<div class="sess-title"><h3>Sessions</h3></div>';
echo '<div class="sess-list">';

                if($class_result->num_rows>0) {
		
                    while($row=$class_result->fetch_assoc()) {
                        if($user_type=='instructor' || $user_type=='student') {
                            $onclickurl="location.href='/userpgs/instructor/class?course_id=".$course_id."&class_id=".$row['id']."'";
                        } else {
                            // not purchased
                            $onclickurl="unpurchased()";
                        }
			echo '<div class="session" onclick="'.$onclickurl.'">';
			?>

			  <div class="session-prev">
			   <img src="/images/background/course.svg">
			  </div>
			  <div class="session-desc">

			<?php
                        
                        echo '<p><strong>'.$row['title'].'</strong></p>';
                        if($row['body']=='') {
                            $descrip='<span class="gray">(No description)</span>';
                        } else {
                            $descrip=preg_replace("/<br\W*?\/>/", " ", $row['body']);
                        }
                        echo '<p>';
			echo limited($descrip,70).'</p>';
                        echo '</div></div>';
                    }
                    $class_result->free();
                } else {
                    echo '<p class="gray" style="text-align:center;">No sessions yet.</p>';
                }
 ?>
	</div>
      </div>
</div>     </div> 
            
    </div>


  </div>
  

  <div class="footbar blur"></div>
  <script src="/js/footbar.js"></script>



  <!-- SCRIPTS -->
  <script>
    $('#page-header').html('fxUniversity');
    $('#page-header').attr('href','/userpgs/fxuniversity');
  </script>
  
  
  <!-- fxUniversity sidebar active -->
  <script>
    $('.fxuniversity-sidebar').attr('id','sidebar-active');
  </script>

<script>
$('#bidForm').submit(function(event) {
    event.preventDefault();

    jQuery.ajax({
      url:'/php/course_bid.php',
      type:'POST',
      data:$(this).serialize(),
      success: function(response) {
        console.log(response);
	if(response=='low') {
	  alert('Your offer must be higher than the highest bid.');
	} else if(response=='initlow') {
	  alert('Your offer must be higher than the reserve declared by the instructor.');
	} else if(response=='insuff') {
	  alert('You have insufficient fxStars.');
	} else if(response=='assigned') {
	  alert('Your offer is assigned.');
	} else if(response=='initassigned') {
	  alert('Your offer is assigned as the first bid.');
	}
      }
    });
});
</script>

<script>
$(document).ready(function() {
  setInterval(function() {
    jQuery.ajax({
      type:'POST',
      url:'/php/get_hi_bid.php',
      data:{courseId:<?php echo $course_id?>},
      success:function(response) {
	if(response=='no_offer') {
	  $('#highest').text('<?php echo $cost?>');
	} else {
	  $('#highest').text(response);
	}
      }
    });
  }, 2000);
});
</script>

<script>
$(document).ready(function() {
  setInterval(function() {
    jQuery.ajax({
      type:'POST',
      url:'/php/get_hi_bid.php',
      data:{courseId:<?php echo $course_id?>},
      success:function(response) {
        
	if(response=='no_offer') {
	  $('#highest-ins').text('None');
	} else {
	  $('#highest-ins').text(response+' fxStars');
	}
      }
    });
  }, 2000);
});
</script>

<script>
$('#offer-input').each(function() {

  var elem=$(this);
  elem.data('oldVal', elem.val());
  elem.bind('propertychange change click keyup input paste', function(event) {
    if(elem.data('oldVal')!=elem.val()) {
      elem.data('oldVal', elem.val());
      
      $('#totalOfferCost').html(Math.ceil(elem.val()*0.1)+parseInt(elem.val()));

    }
  });
});
$('#offer-input').keydown(function (e) {
	if (e.shiftKey || e.ctrlKey || e.altKey) {
		e.preventDefault();
	} else {
	var key = e.keyCode;
		if (!((key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57)      || (key >= 96 && key <= 105))) {
			e.preventDefault();
		}
	}
});
</script>

<script>
$('#acceptBid').click(function() {
  if(confirm("Confirm accepting the highest bid.")) {
  
  jQuery.ajax({
    url:'/php/accept_bid.php',
    type:'POST',
    data:{course_id:<?php echo $course_id?>},
    success:function(response) {
      if(response=='transferred') {
        alert('Course is sold.');
	window.location.reload();
      } else if(response=='nooffer') {
        alert('No offer has been made yet.');
      } else {
        alert('Failed to finalize the deal. Please try again.');
      }
    }
  });

  }
  
});
</script>


<script>
$(document).ready(function() {
    $('#examId').click(function(e) {
        if('<?php echo $user_type?>'=='student') {
            if(<?php echo $get_exam_count?> > 0) {
                /*window.location.href="/userpgs/instructor/exam/take_exam.php?q_id=<?php echo $get_exam_fetch['id']?>&course_id=<?php echo $course_id?>";*/
		/*$('#goToExam').submit();		*/
		alert('No test added by the instructor yet.');
            } else {
                alert('No test added by the instructor yet.');
            }
        } else if('<?php echo $user_type?>'=='neither') {
            alert('You need to purchase the course first.');
        }
    });
});
$('#manageTestId').click(function() {
  alert('Test Taking, coming soon.');
});
</script>



<!-- COURSE PURCHASE -->
<script>
                $(document).ready(function() {
                    var courseId=<?php echo $course_id?>;
                    var stuId=<?php echo $get_user_id?>;
                    $('#purchbutt').click(function(e) {
                        
                        jQuery.ajax({
                          type:'POST',
                          url:'/wallet/php/purchase.php',
                          data: {item:'course', course_id:courseId, stu_id:stuId},
                          success: function(response) {
                                if(response=='success') {
                                    alert('Course purchased successfully.');
                                    window.location.reload();
                                } else if(response=='insuff') {
				  alert('Insufficient fxStars to purchase this course.');
				} else {
				  alert('Failed to purchase the course. Please try again.');
				}
                          }
                        });
                        
                    });
                });
</script>
</body>
</html>
