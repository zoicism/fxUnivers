<?php
session_start();
require('../../../register/connect.php');

if(isset($_GET['course_id'])) $course_id = $_GET['course_id'];

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
	header("Location: /register/logout.php");
}

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

require('../../php/notif.php');

require('../../../php/get_user_type.php');

require('../../../php/get_exam.php');

require('../../../php/get_last_question_id.php');

require('../../../php/get_course.php');
require('../../../php/get_user_type.php');
if($user_type!='instructor') {
    header("Location: /");
    exit();
}
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
<script src="/js/upperbar.js"></script>



<div class="col-33 left-col">
    <div class="col-1">
    <div class="main fxuniversity-color"></div>
    <div class="icon col-icon fxuniversity-bg" onclick="location.href='/userpgs/fxuniversity';"></div>
    
    <h3>Manage exam</h3>
</div>
</div>

<div class="col-33 mid-col">
  <div class="col-1">
                <h3>New question</h3>
   <form action="/userpgs/instructor/exam/submit_question.php" method="POST" id="qaddid" autocomplete="off">
                <p>question #<?php echo $get_exam_count+1 ?></p>
                <input type="hidden" name="question_id" value="<?php echo $last_question_id+1 ?>" >
                <textarea name="question"  rows="10" style="width:80%" placeholder="Question" required></textarea>
  </div>
  <div class="col-1">
                <p>choices</p>
                <p style="text-align:left">(a)</p>
                <input type="text" name="answer_a" style="width:80%;margin-bottom:15px;">

                <p style="text-align:left">(b)</p>
                <input type="text" name="answer_b" style="width:80%;margin-bottom:15px;">

                <p style="text-align:left">(c)</p>
                <input type="text" name="answer_c" style="width:80%;margin-bottom:15px;">

                <p style="text-align:left">(d)</p>
                <input type="text" name="answer_d" style="width:80%;margin-bottom:15px;">
  </div>
  <div class="col-1">
                <p>correct answer<p>
                <select name="cor_ans" style="width: 90px; display: inline; margin-top: 20px;">
                <option value="a">a</option>
                <option value="b">b</option>
                <option value="c">c</option>
                <option value="d">d</option>
                </select>

    <input type="hidden" name="course_id" value="<?php echo $course_id ?>">
  </div>
			    
                
</div>






                

<div class="col-33 right-col">
  <div class="col-1 pointer fxuniversity-color" id="qaddbutt">
                <h3>Add</h3>
                <p>Click to add this question and go for the next one.</p>
                <input type="submit" value="Add > Next">
                </form>
  </div>
  <div class="col-1 pointer fxuniversity-color" onclick="location.href='/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id?>';">
                <h3>Done</h3>
                <p>Click when finished adding questions to go back to the course.</p>
  </div>
               
  <div class="col-1">
                <h3>Questions</h3>
                <p>Click on the questions below to edit them.</p>
  </div>
<?php
                if($get_exam_result->num_rows > 0) {
                    $rowNum=1;
                    while($row = $get_exam_result->fetch_assoc()) {
                        
                        echo '<div class="col-1 pointer" onclick="location.href=\'/userpgs/instructor/exam/edit_exam.php?q_id='.$row['id'].'&course_id='.$row['course_id'].'\';">';
                        echo '<p>'.$rowNum.'. '.$row['question'].'</p>';
                        echo '</div>';

                        $rowNum++;
                    }
                    $get_exam_result->free();
                } else {
                    echo '<div class="col-1">';
                    echo '<p style="color:gray">No questions yet</p>';
                    echo '</div>';
                }
                     
?>

                
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