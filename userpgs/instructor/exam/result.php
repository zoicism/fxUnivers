<?php

  session_start();
  require('../../../register/connect.php');

  if(isset($_SESSION['username'])) {
    $username=$_SESSION['username'];
  }

  require('../../../php/get_user.php');
  $id = $get_user_id;

  require('../../php/notif.php');

  if(isset($_GET['course_id'])) {
    $course_id=$_GET['course_id'];
  }
  require('../../../php/get_course.php');

  //require('../../../php/get_user_type.php');

  require('../../../php/get_stucourse.php');

  require('../../../php/get_exam.php');

  require('../../../php/get_exam_acceptance.php');

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
<h3>Exam result</h3>
      </div>
</div>



      <div class="col-33 mid-col">
<div class="col-1">
      <?php
                if($get_exam_acc_fetch['exam_accepted']==1) {
                    echo '<p style="font-size:1.2rem"><b>'.$get_user_fname.' '.$get_user_lname.' @'.$username.'</b> has successfully <h3 style="color:green;font-size:1.9rem;">PASSED</h3> the <b>'.$get_course_fetch['header'].'</b> course by answering <b>'.$stucourse_fetch['score'].'</b> out of '.$get_exam_count.' questions correctly.</p><p>congrats!</p>';
                } else {
                    echo '<p style="font-size:1.2rem"><b>'.$get_user_fname.' '.$get_user_lname.' @'.$username.'</b> <h3 style="color:red;font-size:1.9rem;">FAILED</h3> to pass the <b>'.$get_course_fetch['header'].'</b> course by answering <b>'.$stucourse_fetch['score'].' out of '.$get_exam_count.' questions</b> correctly.</p>';
                }
?>
      </div>
  </div>

<div class="col-33 right-col">
      <div class="col-1 pointer" onclick="location.href='/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id?>';">
      <h3>Course</h3>
      <p>Click to go back to the course</p>
      </div>
  </div>
      


<div class="footer"></div>
<script src="/js/footer.js"></script>

<div class="footbar"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>



</body>
</html>