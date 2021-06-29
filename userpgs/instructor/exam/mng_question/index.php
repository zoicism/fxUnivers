<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
   $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   header("Location: $url");
   exit;
   }*/
session_start();
require_once('../../../../register/connect.php');
require_once('../../../../php/conn/fxinstructor.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

if(isset($_GET['courseId'])) $course_id = $_GET['courseId'];

require('../../../../php/get_user.php');
$id = $get_user_id;
require('../../php/courses.php');
require('../../../php/notif.php');

require('../../../../php/get_plans.php');

require('../../../../php/get_rel.php');

$get_course_q = "SELECT * FROM teacher WHERE id=$course_id";
$get_course_r = mysqli_query($connection,$get_course_q);
$get_course = mysqli_fetch_array($get_course_r);

$get_question_q = "SELECT * FROM question WHERE course_id=$course_id";
$get_question_r = mysqli_query($fxinstructor_connection,$get_question_q);
$get_question_c = mysqli_num_rows($get_question_r);
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
	     $('.header-sidebar').prepend('<div class="bar-cnt"><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/instructor/" class="link-main" id="active-main"><div class="head">Teach</div></a></div><div class="bar-items fxuniversity-bar-items"><a href="/userpgs/student/" class="link-main"><div class="head">Learn</div></a></div></div>');
	 });
     }
    </script>
<div class="blur mobile-main">
    
	<div class="sidebar"></div>
	<?php require('../../../../php/sidebar.php'); ?>


    <div class="relative-main-content">

		

	<div class="simple-bg">
	  <h2>Edit Quiz</h2>


	  <p>A course may have at least 1 question. Once a learner is taking the quiz, a number of these questions, specified by you below, will be randomly chosen and asked the learner.</p>



	  <form id="testForm">
<?php if($get_course['test_duration']==null) { ?>
	    <div class="txt-input-cnt">
		<div>How many questions to ask a learner</div>
	    	<input type="number" id="num-to-ask" name="ask_num" class="num-input" placeholder="Choose a number" min="1" required>
	    </div>
	    <div class="txt-input-cnt">
		<div>Quiz duration in minutes</div>
	    	<input type="number" name="duration" class="num-input" placeholder="Choose a number" min="5" required>
	    </div>
<?php } else {?>
<input type="number" id="num-to-ask" name="ask_num" value="<?php echo $get_course['test_num'] ?>" class="num-input" placeholder="How many questions to ask a learner?" min="1" required>
	    <input type="number" name="duration"  value="<?php echo $get_course['test_duration'] ?>" class="num-input" placeholder="Quiz duration in minutes" min="5" required>
	    <input type="hidden" name="course_id" value="<?php echo $course_id?>">
	<?php } ?>
	    <input type="hidden" name="course_id" value="<?php echo $course_id?>">
		  
	    <h3>Questions</h3>
	 <div class="questions">
<?php
if($get_question_c>0) {
$i=1;
  while($row = $get_question_r -> fetch_assoc()) {
  $selected_option = $row['correct'];
  
    
    echo '	    
	    <div class="question">
	      <p class="question-num">Question #<span class="q_num">'.$i.'</span></p>
	      <textarea name="q'.$i.'" placeholder="Write a question">'.$row['question'].'</textarea>

	      <div class="option-cnt">
		      <p class="question-num">Options</p>
		      <div class="opt-num-txtarea-cnt">
		          <div class="opt-num">A.</div>
		          <textarea class="opt-txtarea" name="q'.$i.'o1" placeholder="Option A">'.$row['a'].'</textarea>
		      </div>
		      <div class="opt-num-txtarea-cnt">
    			  <div class="opt-num">B.</div>
		          <textarea class="opt-txtarea" name="q'.$i.'o2" placeholder="Option B">'.$row['b'].'</textarea>
		      </div>
		      <div class="opt-num-txtarea-cnt">
    			  <div class="opt-num">C.</div>
		          <textarea class="opt-txtarea" name="q'.$i.'o3" placeholder="Option C">'.$row['c'].'</textarea>
		      </div>
		      <div class="opt-num-txtarea-cnt">
    			  <div class="opt-num">D.</div>
		          <textarea class="opt-txtarea" name="q'.$i.'o4" placeholder="Option D">'.$row['d'].'</textarea>
		      </div>

		      <div class="correct-opt-cnt">
		          <p>Correct Option</p>
		          <select name="corr'.$i.'" class="select-input">';

			    if($selected_option=='a') {
			      echo '<option value="a" selected="selected">A</option>';
			    } else {
			      echo '<option value="a">A</option>';
			    }

			    if($selected_option=='b') {
			      echo '<option value="b" selected="selected">B</option>';
			    } else {
			      echo '<option value="b">B</option>';
			    }

			    if($selected_option=='c') {
			      echo '<option value="c" selected="selected">C</option>';
			    } else {
			      echo '<option value="c">C</option>';
			    }

			    if($selected_option=='d') {
			      echo '<option value="d" selected="selected">D</option>';
			    } else {
			      echo '<option value="d">D</option>';
			    }

				echo '
				    <input type="hidden" name="question_id'.$i.'" value="'.$row['id'].'">
			</select>
	   	    </div>
		</div>

<a id="del-question" questionId="'.$row['id'].'">
	<button  class="submit-btn">
		<svg viewBox="0 0 32 32"><path d="M16,0A16,16,0,1,0,32,16,16,16,0,0,0,16,0Zm0,31A15,15,0,1,1,31,16,15,15,0,0,1,16,31Z"></path><rect x="6.1" y="15.5" width="19.9" height="1"></rect></svg>
		<div class="delete-q-test">Delete this Question</div>
	</button>
</a>
	    </div>
	';

	$i++;
  }
}
?>

	    
	</div>
            <button class="submit-btn" id="add-q-btn">
		    <svg viewBox="0 0 32 32">
			<path d="M16,0A16,16,0,1,0,32,16,16,16,0,0,0,16,0Zm0,31A15,15,0,1,1,31,16,15,15,0,0,1,16,31Z"></path><polygon points="25.9 15.5 25.9 16.5 16.5 16.5 16.5 25.9 15.5 25.9 15.5 16.5 6.1 16.5 6.1 15.5 15.5 15.5 15.5 6.1 16.5 6.1 16.5 15.5 25.9 15.5"></polygon>
		    </svg>
		    <div class="add-q-test">Add Question</div>
	    </button>
	    <input type="submit" class="submit-btn apply-q" value="Apply Changes">
		
		
	  </form>


<form id="del-test-form">
<input type="hidden" name="courseId" value="<?php echo $course_id?>">
<input type="hidden" name="userType" value="<?php echo $user_type?>">
<input type="submit" class="submit-btn" value="Remove Quiz">
</form>
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
$('#testForm').submit(function(event) {
  event.preventDefault();

  var questionCount = $('.question').length;
var numToAsk = $('#num-to-ask').val();

 if(numToAsk <= questionCount) {
  jQuery.ajax({
    url:'/php/edit_question.php',
    type:'POST',
    data:$(this).serialize() + "&qCount=" + questionCount,
    success: function(response) {
      //console.log(response);
    
      if(response==1) {
        alert("Changes are applied.");
	window.location.replace('/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id?>');
      }
      
    }
  });
 } else {
   alert('There must be at least as many questions as you want to ask the learner. Either add more questions or change the number of questions to be asked.');
 }
});
</script>

<script>
$('#add-q-btn').click(function(e) {
  e.preventDefault();
  var questionCount = $('.question').length;
  window.location.replace('/userpgs/instructor/exam/new_question?courseId=<?php echo $course_id?>&qNum='+questionCount); 
});
</script>

<script>
$('#del-question').click(function(event) {
  event.preventDefault();

  var q_id = $('#del-question').attr('questionId');

  jQuery.ajax({
    url:'/php/del_one_question.php',
    type:'POST',
    data:{questionId:q_id},
    success: function(response) {
      if(response==1) {
        alert('Question is deleted.');
        window.location.reload();
      } else {
        alert('Failed to delete the question. Please try again.');
      }
    }
   });
});

</script>

<script>
$('#del-test-form').submit(function(event) {
  event.preventDefault();

  if(confirm("Are you sure you want to delete this test?")) {
    jQuery.ajax({
      url:'/php/remove_test.php',
      type:'POST',
      data:$(this).serialize(),
      success: function(response) {
        console.log(response);
      
        if(response==1) {
	  alert('Test for this course is deleted.');
	  window.location.replace('/userpgs/instructor/course_management/course.php?course_id='+'<?php echo $course_id?>');
	} else {
	  alert('Failed to delete the test. Please try again.');
	}
      }
    });
  }
});
</script>
</body>
</html>
