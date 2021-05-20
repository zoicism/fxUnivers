<?php
session_start();
require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

if(isset($_POST['course_id'])) $course_id = $_POST['course_id'];



$course_query = "SELECT * FROM `teacher` WHERE id=$course_id";
$course_result = mysqli_query($connection, $course_query) or die(mysqli_error($connection));
$course_fetch = mysqli_fetch_array($course_result);

$user_id = $course_fetch['user_id'];
$get_course_teacher_id = $user_id;
$header = $course_fetch['header'];
$description = $course_fetch['description'];
$video = $course_fetch['video_url'];
$s_date = $course_fetch['start_date'];
$e_date = $course_fetch['exam_date'];
$cost = $course_fetch['cost'];

require('../php/classes.php');

require('../../../php/get_user.php');
$id = $get_user_id;

// check if the user has taken the exam already
require('../../../php/get_stucourse.php');
if(isset($stucourse_fetch['exam_accepted'])) {
    header('Location: /userpgs/instructor/exam/result.php?course_id='.$course_id);
}

require('../../php/notif.php');

require('../../../php/get_user_type.php');

require('../../../php/get_exam.php');


//require('../../../php/get_current_q.php');
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
	<script>
	 if(screen.width >= 629) {
	     $(document).ready(function() {
		 $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/instructor/" class="link-main" <?php if($user_type=='instructor') echo 'id="active-main"'; ?>><div class="head">Teach</div></a></div><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/student/" class="link-main" <?php if($user_type!='instructor') echo 'id="active-main"'; ?>><div class="head">Learn</div></a></div></div>');
	     });
	 }
	</script>
	<div class="blur mobile-main">
    
	<div class="sidebar"></div>
	<?php require('../../../php/sidebar.php'); ?>



  <div class="relative-main-content">
        <div class="content-box">
			    	 <h2>Exam</h2>
                              	 <p><strong><?php echo $header ?></strong></p>
				 <p>Whenever you are ready, click to start taking the exam.</p>
				 <button class="submit-btn" id="start-btn">Start Exam</button>

<?php
if($get_exam_result->num_rows > 0) {
  $q_number=1;
  echo '<form>';
  while($row=$get_exam_result->fetch_assoc()) {
    echo '<p><strong>Question '.$q_number.'</strong></p>';
    echo '<p>'.$row['question'].'</p>';

    echo '<input type="radio">'.$row['option_a'];
    echo '<input type="radio">'.$row['option_b'];
    echo '<input type="radio">'.$row['option_c'];
    echo '<input type="radio">'.$row['option_d'];

    echo '<hr style="opacity:0.3">';
    $q_number++;
  }
  echo '<input value="Submit Answers and See Result" type="submit" class="submit-btn">';
  echo '</form>';
  $get_exam_result->free();
}
?>



        </div>




    </div>



    


</div>


<div class="footbar blur"></div>
                          <script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>



<!-- SCRIPTS -->
<script>
                          $('#page-header').html('fxUniversity');
$('#page-header').attr('href','/userpgs/fxuniversity');
</script>


<!-- fxUniversity sidebar active -->
<script>
$('.fxuniversity-sidebar').attr('id','sidebar-active');
</script>

</body>
</html>
