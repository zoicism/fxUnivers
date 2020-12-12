<?php

session_start();
require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
	header("Location: /register/logout.php");
}

if(isset($_GET['course_id'])) $course_id = $_GET['course_id'];



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

  if(isset($_GET['q_id'])) {
    $q_id = $_GET['q_id'];
  }

  require('../../../php/get_current_q.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

      <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 
    <title>fxUnivers</title>
    <link rel="stylesheet" href="/css/style.css">  

    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <link rel="stylesheet" href="/css/colors.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
    </head>

<body>

                <div class="upperbar"></div>
                <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
                
<div class="col-33 left-col">

        <div class="col-1">
    <div class="main fxuniversity-color"></div>
    <div class="icon col-icon fxuniversity-bg" onclick="location.href='/userpgs/fxuniversity';"></div>
                <h3>Exam</h3>
      </div>
</div>

<div class="col-33 mid-col">

  <div class="col-1">
                <h3>Question</h3>
<?php
                echo '<p>'.$g_c_fetch['question'].'</p>'
?>
  </div>


<div class="col-1">
                <h3>Choices</h3>

                <form action="/php/submit_answer.php" method="POST" style="text-align:left">
      <label>
                <div class="col-1 pointer" style="text-align:left">
                <input type="radio" name="radio" style="float:left;margin-right:5px;margin-left:10px;" value="a"> <b>a</b>
                <p><?php echo $g_c_fetch['option_a']?></p>
  			    <span class="checkmark"></span>
                </div>
      </label>
      <label>
                <div class="col-1 pointer" style="text-align:left">
                <input type="radio" name="radio" style="float:left;margin-right:5px;margin-left:10px;" value="b"> <b>b</b>
                <p><?php echo $g_c_fetch['option_b']?></p>
  			    <span class="checkmark"></span>
                </div>
      </label>
      <label>
                <div class="col-1 pointer" style="text-align:left">
                <input type="radio" name="radio" style="float:left;margin-right:5px;margin-left:10px;" value="c"> <b>c</b>
                <p><?php echo $g_c_fetch['option_c']?></p>
  			    <span class="checkmark"></span>
                </div>
      </label>
      <label>
                <div class="col-1 pointer" style="text-align:left">
                <input type="radio" name="radio" style="float:left;margin-right:5px;margin-left:10px;" value="d"> <b>d</b>
                <p><?php echo $g_c_fetch['option_d']?></p>
  			    <span class="checkmark"></span>
			  </div>
      </label>
			    <input type="hidden" name="course_id" value="<?php echo $course_id ?>">
			    <input type="hidden" name="q_id" value="<?php echo $q_id ?>">
			    <input type="hidden" name="student_id" value="<?php echo $get_user_id ?>">
			    <input type="hidden" name="question_id" value="<?php echo $g_c_fetch['question_id']?>">
                
                <input type="submit" value="Submit > Next question">
			
                </form>
                
  </div>
                

  
</div>


<div class="col-33 right-col">
      <h3 style="text-align:center">Questions</h3>
  <div class="col-1">
<?php
      if($get_exam_result->num_rows > 0) {
          $rowNum=1;
          while($row = $get_exam_result->fetch_assoc()) {
              echo '<div class="col-1 pointer">';
              echo '<p>'.$rowNum.'. '.$row['question'].'</p>';
              echo '</div>';
              $rowNum++;
          }
          $get_exam_result->free();
      }
?>
  </div>
</div>



<div class="footer"></div>
<script src="/js/footer.js"></script>

<div class="footbar"></div>
<script src="/js/footbar.js"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>

<script src="/js/notif_msg.js"></script>




</body>
</html>