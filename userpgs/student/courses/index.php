<?php
session_start();
require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: /');
}

if(isset($_GET['tar'])) {
    $tar = $_GET['tar'];
    $tar_q="SELECT * FROM teacher WHERE header LIKE '%$tar%' ORDER BY id DESC";
} else {
    $tar_q="SELECT * FROM teacher ORDER BY id DESC";
}

$tar_r=mysqli_query($connection,$tar_q) or die(mysqli_error($connection));

require('../../../php/get_user.php');
// fetch the sonet records
require('../../../userpgs/sonet/following.php');
$id=$get_user_id;
require('../../../userpgs/php/notif.php');
require('../../../php/get_plans.php');
require('../../../php/get_rel.php');
require('../../../wallet/php/get_fxcoin_count.php');
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
    
                <h3>Courses</h3>
<?php
                if(isset($_GET['tar'])) {
                    echo '<p>searched <strong>'.$tar.'</strong></p>';
                    echo '<p><strong>'.$tar_r->num_rows.'</strong> courses found.</p>';
                } else {
                    echo '<p><strong>'.$tar_r->num_rows.'</strong> courses</p>';
                }
?>

                <form action="/userpgs/student/courses" method="GET">
                  <input type="text" name="tar" placeholder="Course search" required>
                  <input type="submit" value="Search">
                </form>
        </div>
</div>

<div class="col-33 mid-col">
<?php
                if($tar_r->num_rows > 0) {                      
                    while($row = $tar_r->fetch_assoc()) {
                        $u_id = $row['user_id'];
					    $tutor_query = "SELECT username, fname, lname FROM user WHERE id=$u_id";
					    $tutor_result = mysqli_query($connection, $tutor_query) or die(mysqli_error($connection));
					    $tutor_fetch = mysqli_fetch_array($tutor_result);
					    $tutor_username = $tutor_fetch['username'];
					    $tutor_fname = $tutor_fetch['fname'];
					    $tutor_lname = $tutor_fetch['lname'];
                        $course_link = "/userpgs/instructor/course_management/course.php?course_id=".$row['id'];

                        echo '<div class="col-1 pointer" onclick="location.href=\''.$course_link.'\';">';
                        echo '<h3>'.$row['header'].'</h3>';
                        echo '<p>by <strong>'.$tutor_fname.' '.$tutor_lname.'</strong> @'.$tutor_username.'</p>';
                        echo '<p>'.$row['description'].'</p>';
                        echo '</div>';
                    }
                    $tar_r->free();
                } else {
                    echo '<p>no courses yet.</p>';
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