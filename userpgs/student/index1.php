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
} else {
	header("Location: /register/logout.php");
}

require('../../php/get_user.php');
$id = $get_user_id;

require('../php/notif.php');

require('../../php/get_plans.php');

require('../../php/get_rel.php');

require('../../php/get_stu_stucourse.php');

require('../../php/get_my_accepted_courses.php');

require('../../wallet/php/get_fxcoin_count.php');
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
                <h3>Student</h3>
<?php
                echo '<p><strong>'.$gss_count.'</strong> taken courses</p>';
                echo '<p><b>'.$gmac_count.'</b> accepted courses</p>';
?>
                </div>
</div>

<div class="col-33 mid-col">

    <div class="col-1 pointer fxuniversity-color" onclick="location.href='/userpgs/student/courses';">
                <h3>Add</h3>
                <p>Click to select and add a new course.</p>
    </div>
                    
<?php
                if($gss_count>0) {
                    while($taken_row=$gss_result->fetch_assoc()) {
                        $taken_course_id=$taken_row['course_id'];
                        $get_stus_course_query="SELECT * FROM teacher WHERE id=$taken_course_id";
                        $get_stus_course_result=mysqli_query($connection,$get_stus_course_query) or die(mysqli_error($connection));
                        $gsc_fetch=mysqli_fetch_array($get_stus_course_result);
                        $course_link="/userpgs/instructor/course_management/course.php?course_id=".$gsc_fetch['id'];
                        echo '<div class="col-1 pointer" onclick="location.href=\''.$course_link.'\';">';
                        echo '<h3>'.$gsc_fetch['header'].'</h3>';
                        echo '<p>'.$gsc_fetch['description'].'</p>';
                        echo '</div>';
                    }
                    $gss_result->free();
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