<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
   $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   header("Location: $url");
   exit;
   }*/
session_start();
require_once('../../../register/connect.php');
require_once('../../../php/conn/fxinstructor.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

if(isset($_GET['courseId'])) $course_id = $_GET['courseId'];

require('../../../php/get_user.php');
$id = $get_user_id;
//require('../php/courses.php');
require('../../php/notif.php');

require('../../../php/get_plans.php');

require('../../../php/get_rel.php');

$get_course_q = "SELECT * FROM teacher WHERE id=$course_id";
$get_course_r = mysqli_query($connection,$get_course_q);
$get_course = mysqli_fetch_array($get_course_r);
$wanted_num = $get_course['test_num'];
$total_time = $get_course['test_duration'];

$get_question_q = "SELECT * FROM question WHERE course_id=$course_id ORDER BY RAND() LIMIT $wanted_num";
$get_question_r = mysqli_query($fxinstructor_connection,$get_question_q);
$get_question_c = mysqli_num_rows($get_question_r);

$check_last_date_q = "SELECT last_exam FROM stucourse WHERE stu_id=$get_user_id AND course_id=$course_id";
$check_last_date_r = mysqli_query($connection,$check_last_date_q);
$check_last_date_f = mysqli_fetch_array($check_last_date_r);
$past_date = $check_last_date_f['last_exam'];
$now_date=date('Y-m-d');
$date1 = new DateTime($past_date);
$date2 = new DateTime($now_date);
$interval = $date1->diff($date2);

if($past_date!=null && $interval->days < 7) {
    header('Location: /userpgs/instructor/course_management/course.php?course_id='.$course_id);
}
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
	     $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/instructor/" class="link-main" ><div class="head">Teach</div></a></div><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/student/" id="active-main" class="link-main"><div class="head">Learn</div></a></div></div>');
	 });
     }
    </script>
    <div class="blur mobile-main">
    
	<div class="sidebar"></div>
	<?php require('../../../php/sidebar.php'); ?>


    <div class="relative-main-content">		

	<div class="simple-bg">
	    <h2><?php echo $get_course['header'] ?>: <span class="gray" >Certificate Exam</span> </h2>

	  <p style="color:red" id="remaining-time" >Remaining Time: <span style="font-weight:bold" id="rem-time"></span></p>
<p>Note that by leaving the page or reloading it, the exam will be submitted and scored, restricting you from taking the test again for a week.</p>



	  <form id="testForm">
	
	    <input type="hidden" name="course_id" value="<?php echo $course_id?>">
	    <input type="hidden" name="stu_id" value="<?php echo $get_user_id?>">
<h3>Questions</h3>
	 <div class="questions">
<?php
if($get_question_c>0) {
$i=1;
  while($row = $get_question_r -> fetch_assoc()) {
  $selected_option = $row['correct'];
  
    
    echo '	    
	    <div class="question" id="question'.$i.'">
	      <p>Question #<span class="q_num">'.$i.'</span></p>
	      <p style="font-weight:bold">'.$row['question'].'</p>

	      <p>Options</p>
	      <p>A) '.$row['a'].'</p>
	      <p>B) '.$row['b'].'</p>
	      <p>C) '.$row['c'].'</p>
	      <p>D) '.$row['d'].'</p>

	      <p>Your Choice:</p>
	      <select name="corr'.$i.'" class="select-input">';

	      echo '<option value="none">Select</option>';
      echo '<option value="a">A</option>';
      echo '<option value="b">B</option>';
      echo '<option value="c">C</option>';
      echo '<option value="d">D</option>';

	echo '
	    <input type="hidden" name="question_id'.$i.'" value="'.$row['id'].'">
	      </select>
	    </div>
	';

	$i++;
  }
}
?>

	    
	</div>
	    <input type="submit" class="submit-btn" value="Done" id="done-btn">
		
		
	  </form>

	  <button id="goto-course" class="submit-btn">Go Back to Course</button>

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




<script>
 $('#goto-course').click(function(e) {
     e.preventDefault();
     window.location.replace('/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id?>');
 });
</script>

<script>
 var testInterval = null;
 var totalSeconds = <?php echo $total_time?>;
 totalSeconds *= 60;
 
 $(document).ready(function() {
     setInterval(testIntervalUpdate, 1000);
 });

 function testIntervalUpdate() {
     var minutes = Math.floor(totalSeconds / 60);
     console.log(minutes);
     var seconds = totalSeconds - minutes * 60;
     console.log(seconds);
     $('#rem-time').html(minutes.toString() + ':' + seconds.toString());
     totalSeconds--;
     if(totalSeconds <= 0) {
	 $('#testForm').submit();
	 $('#rem-time').html("Time's Up");
     }
 }
</script>


<script>
 $('#testForm').submit(function(event) {
     event.preventDefault();

     var questionCount = $('.question').length;

     jQuery.ajax({
	 url:'/php/correct_exam.php',
	 type:'POST',
	 data:$(this).serialize() + "&qCount=" + questionCount,
	 dataType:'json',
	 success: function(response) {
	     console.log(response);

	     $('#done-btn').hide();

	     var correct_answers=0;
	     for(var i=1; i<=questionCount; i++) {
		 if(response[i]==1) {
  		     $('#question'+i).css('background-color','#00b9484f');
		     correct_answers++;
		 } else {
		     $('#question'+i).css('background-color','#ff000026');
 		 }
	     }
	     
	     var mark = correct_answers/questionCount;
	     if(mark>=0.5) {
		 alert('You are passed by answering '+correct_answers+' questions correctly.');
	     } else {
		 alert('You failed by answering '+correct_answers+' questions correctly.');
	     }

	     $('#testForm :input').prop('disabled', true);
	     $('#goto-course').show();
	     $('#remaining-time').hide();
	     window.removeEventListener('beforeunload', beforeUnload);

	 }
     });
 });
</script>


<script>
 function beforeUnload(e) {
     var confirmationMessage = "The test will be submitted and scored if you leave the page. Want to leave the page?";
     (e || window.event).returnValue = confirmationMessage; //Gecko + IE
     return confirmationMessage;
 }
 window.addEventListener('beforeunload', beforeUnload);
 
 window.onunload = function() {
     $('#testForm').submit();
 }
</script>


<script>
 $(window).on('load',function() {
     jQuery.ajax({
	 url: '/php/exam_date.php',
	 type: 'POST',
	 data: {last_date: '<?php echo $past_date?>'},
	 success: function(response) {
	     console.log(response);
	     if(response<7) {
		 window.location.replace("/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id?>");
	     }
	 }
     });
 });
</script>
</body>
</html>
