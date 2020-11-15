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
	header("/register/logout.php");
}

require('../../../php/get_user.php');
$id = $get_user_id;

require('../../php/notif.php');

if(isset($_GET['course_id'])) {
  $course_id = $_GET['course_id'];
}

require('../../../php/get_course.php');

require('../../../php/get_plans.php');

require('../../../php/get_rel.php');
require('../../../wallet/php/get_fxcoin_count.php');

require('../../../php/get_user_type.php');
if($user_type!='instructor') {
    header('Location: /');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
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
    <h3>Edit course</h3>
    </div>
</div>

<div class="col-33 mid-col">
    <div class="col-1">
    <form method="POST" action="edit_post.php">
                <input type="text" name="header" placeholder="topic" value="<?php echo $get_course_fetch['header']?>" style="width:90%;margin-left:0;" required>
                <textarea name="description" style="width:90%;margin-left:0;" rows="10" placeholder="description"><?php echo preg_replace('/\<br(\s*)?\/?\>/i', "",$get_course_fetch['description']) ?></textarea>
    <p style="text-align:left">Cost (fxStars):</p>
                <input type="number" name="course_fxstar" placeholder="Cost (fxStars)" value="<?php echo $get_course_fetch['cost'] ?>" id="newCost" min="0" style="margin-left:0" required>
                <input type="hidden" name="course_id" value="<?php echo $course_id ?>">

                
                <input type="submit" value="Update" style="margin-right:0"><br>
                </form>

                <form><input onclick="delFunction()" type="submit" value="delete" style="margin-right:0;margin-top:0;"></form>
    </div>
</div>

<div class="col-33 right-col">
    <div class="col-1 pointer" onclick="location.href='/userpgs/instructor/exam?course_id=<?php echo $course_id?>';" >
                     <h3>Manage exam</h3>
                     <p>Click to manage the course exam.</p>
     </div>

    <div class="col-1">
                 <h3>Video upload</h3>
                 <p>Select and upload course video.</p>
    
                    <form method="POST"  action="file_uploader.php" enctype="multipart/form-data">
                      <input name="video_up" type="file">
                      <input name="course_id" type="hidden" value="<?php echo $course_id?>"><br>
                      <input type="submit" value="Upload">
                    </form>
    
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

    
<script type="text/javascript">
var inputNum = document.getElementById('newCost');
inputNum.onkeydown = function(e) {
  if(!((e.keyCode>95 && e.keyCode<106) || (e.keyCode > 47 && e.keyCode < 58) || e.keyCode == 8)) {
    return false;
  }
}
</script>

<script>
function delFunction() {
  if(confirm("Are you sure you want to delete this course?")) {
    window.location.href='/php/del_course.php?course_id=<?php echo $course_id?>';
  } else {
  }
}
</script>
</body>
</html>                