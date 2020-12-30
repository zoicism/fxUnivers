<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/
session_start();
require('../../../../register/connect.php');

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
	    <div class="question">
	      <p>Question #<span class="q_num">1</span></p>
	      <textarea name="q1" placeholder="Question"></textarea>

	      <p>Options</p>
	      <textarea name="q1o1" placeholder="Option A"></textarea>
	      <textarea name="q1o2" placeholder="Option B"></textarea>
	      <textarea name="q1o3" placeholder="Option C"></textarea>
	      <textarea name="q1o4" placeholder="Option D"></textarea>

	      <p>Correct Option</p>
	      <select name="corr1" class="select-input">
	        <option value="a">A</option>
		<option value="b">B</option>
		<option value="c">C</option>
		<option value="d">D</option>
	      </select>
	    </div>


	    
	</div>
<button class="submit-btn" id="add-q-btn">Add Another Question</button>
	    <input type="submit" class="submit-btn" value="Apply Questions">
		
		
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
    url:'/php/add_question.php',
    type:'POST',
    data:$(this).serialize() + "&qCount=" + questionCount,
    success: function(response) {
      if(response==1) {
        alert("New questions are added.");
	window.location.replace('/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id?>');
      }	
    }
  });
});
</script>

<script>
$('#add-q-btn').click(function(e) {
  e.preventDefault();
  var oldNum = $('.question').length;
  var newNum = oldNum+1;
  
  $('.questions').append(`<div class="question" id="qNum`+newNum+`">
	      <p>Question #<span id="qnum">`+newNum+`</span></p>
	      <textarea name="q`+newNum+`" placeholder="Question" id="question-num"></textarea>

	      <p>Options</p>
	      <textarea name="q`+newNum+`o1" placeholder="Option A" id="option-a"></textarea>
	      <textarea name="q`+newNum+`o2" placeholder="Option B" id="option-b"></textarea>
	      <textarea name="q`+newNum+`o3" placeholder="Option C" id="option-c"></textarea>
	      <textarea name="q`+newNum+`o4" placeholder="Option D" id="option-d"></textarea>

	      <p>Correct Option</p>
	      <select name="corr`+newNum+`" class="select-input" id="select-num">
	        <option value="a">A</option>
		<option value="b">B</option>
		<option value="c">C</option>
		<option value="d">D</option>
	      </select>

<button id="del-question" onclick="delQuestion(this,`+newNum+`)" class="submit-btn">Delete this Question</button>
	    </div>`);
});
</script>

<script>
function delQuestion(element, num) {

  //element.preventDefault();

  var numQuestions = $('.question').length;

  for(var i=num+1; i<=numQuestions; i++) {
    var newCount = i-1;
    console.log(newCount);
    $('#qNum'+i+' #qnum').text(newCount);
    $('#qNum'+i+' #question-num').attr('name','q'+newCount);
    $('#qNum'+i+' #option-a').attr('name','q'+newCount+'o1');
    $('#qNum'+i+' #option-b').attr('name','q'+newCount+'o2');
    $('#qNum'+i+' #option-c').attr('name','q'+newCount+'o3');
    $('#qNum'+i+' #option-d').attr('name','q'+newCount+'o4');
    $('#qNum'+i+' #select-num').attr('name','corr'+newCount);
    $('#qNum'+i+' #del-question').attr('onclick','delQuestion(this, '+newCount+')');
    $('#qNum'+i).attr('id','qNum'+newCount);
  }
  
  
  element.closest('.question').remove();
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