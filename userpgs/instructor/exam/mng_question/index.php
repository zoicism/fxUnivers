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
	header("Location: /register/logout.php");
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

<div class="blur mobile-main">
    
	<div class="sidebar"></div>
	<?php require('../../../../php/sidebar.php'); ?>







                          
    <div class="main-content">

              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/userpgs/instructor" class="link-main" id="active-main">
                          <div class="head">Teach</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/userpgs/student" class="link-main">
                          <div class="head">Learn</div>
                      </a>
                  </li>
                  
              </ul>

    </div>





    <div class="relative-main-content">

		

	<div class="simple-bg">
	  <h2>Course Test</h2>


	  <p>A course may have at least 3 questions. Once a learner is taking the test a number of these questions will be provided to be answered.</p>



	  <form id="testForm">
<?php if($get_course['test_duration']==null) { ?>
	    <input type="number" name="ask_num" class="num-input" placeholder="How many questions to ask a learner?" min="3" required>
	    <input type="number" name="duration" class="num-input" placeholder="Test duration in minutes" min="5" required>
<?php } else {?>
<input type="number" name="ask_num" value="<?php echo $get_course['test_num'] ?>" class="num-input" placeholder="How many questions to ask a learner?" min="3" required>
	    <input type="number" name="duration"  value="<?php echo $get_course['test_duration'] ?>" class="num-input" placeholder="Test duration in minutes" min="5" required>
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
	      <p>Question #<span class="q_num">'.$i.'</span></p>
	      <textarea name="q'.$i.'" placeholder="Question">'.$row['question'].'</textarea>

	      <p>Options</p>
	      <textarea name="q'.$i.'o1" placeholder="Option A">'.$row['a'].'</textarea>
	      <textarea name="q'.$i.'o2" placeholder="Option B">'.$row['b'].'</textarea>
	      <textarea name="q'.$i.'o3" placeholder="Option C">'.$row['c'].'</textarea>
	      <textarea name="q'.$i.'o4" placeholder="Option D">'.$row['d'].'</textarea>

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

<button id="del-question" onclick="delQuestion('.$row['id'].')" class="submit-btn">Delete this Question</button>
	    </div>
	';

	$i++;
  }
}
?>

	    
	</div>
            <button class="submit-btn" id="add-q-btn">Add Another Question</button>
	    <input type="submit" class="submit-btn" value="Apply Changes">
		
		
	  </form>


<form id="del-test-form">
<input type="hidden" name="courseId" value="<?php echo $course_id?>">
<input type="hidden" name="userType" value="<?php echo $user_type?>">
<input type="submit" class="submit-btn" value="Remove Test">
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
});
</script>

<script>
$('#add-q-btn').click(function(e) {
  e.preventDefault();
  window.location.replace('/userpgs/instructor/exam/new_question?courseId=<?php echo $course_id?>'); 
});
</script>

<script>
function delQuestion(q_id) {

  console.log(q_id);

/*
  jQuery.ajax({
    url:'/php/del_one_question.php',
    type:'POST',
    data:{questionId:q_id},
    success: function(response) {
      console.log(response);
    }
   });  */
}
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
