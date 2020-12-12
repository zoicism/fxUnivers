<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/
session_start();
require('../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    require('../../php/get_user.php');
} else {
	header("Location: /register/logout.php");
}

require('../instructor/php/courses.php');
require('../../php/get_stu_stucourse.php');

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

    <!-- LEFT COL -->
<div class="col-33 left-col">
<div class="col-1">
    <div class="main fxuniversity-color"></div>
    <div class="icon col-icon fxuniversity-bg"></div>
    
    <h3>fxUniversity</h3>
    <p style="text-align:left">Click on Instructor to teach using various tools including live classes.</p>
                <p style="text-align:left">Click on Student to learn your favorite topics with cool tools.</p>
</div>
</div>
                
<div class="col-33 mid-col">
  <div class="col-1 pointer" onclick="location.href='/userpgs/instructor';">
                <h3>Instructor</h3>
                <p><?php echo '<strong>'.$course_count.'</strong> courses' ?></p>
  </div>

  <div class="col-1 pointer" onclick="location.href='/userpgs/student';">
                <h3>Student</h3>
                <p><?php echo '<strong>'.$gss_count.'</strong> courses' ?></p>
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