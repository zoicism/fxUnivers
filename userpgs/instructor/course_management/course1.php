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
  $test_date = $course_fetch['test_date'];

  


  require('../../../php/get_user.php');
  $id = $get_user_id;
require('../php/classes.php');
  require('../../php/notif.php');

  require('../../../php/get_user_type.php');

  require('../../../php/get_exam.php');
$get_exam_fetch=mysqli_fetch_array($get_exam_result);

require('../../../php/get_stucourse.php');

  require('../../../wallet/php/get_fxcoin_count.php');

$tar_id=$get_course_teacher_id;
require('../../../php/get_tar_id.php');


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


<div class="col-66 left-col">
    <div class="main fxuniversity-color"></div>
    <div class="icon col-icon fxuniversity-bg" onclick="location.href='/userpgs/fxuniversity';"></div>

  <?php
    $path='videos/';
    $file_ex=glob($path.$course_id.'.*');
    if(count($file_ex)>0) {
       $vid_arr=explode('.', $file_ex[0]);
       $vid_ext=end($vid_arr);
  ?>
<div style="text-align:center">
       <video width="560" height="315" controls>
         <source src="<?php echo 'videos/'.$course_id.'.'.$vid_ext ?>" type="video/<?php echo $vid_ext?>"> 
       </video>
   </div>
  <?php
    } 
    echo '<h2>'.$header.'</h2>';
    echo '<p>'.$description.'</p>';
    echo '<p style="margin-top:20px">by <strong><a href="/user/'.$tar_user_fetch['fname'].'">'.$tar_user_fetch['fname'].' '.$tar_user_fetch['lname'].' @'.$tar_user_fetch['username'].'</a></strong></p>';
    echo '<p><strong>'.$class_num.'</strong> classes</p>';
    echo '<p><strong>'.$cost.'</strong> fxStars</p>';
  ?>
</div>



<div class="col-33 right-col">

<?php
        if($user_type=='instructor') {
?>
<div class="col-1 pointer fxuniversity-color" onclick="location.href='/userpgs/instructor/course_management/edit_course.php?course_id=<?php echo $course_id?>';">
                                     <h3>Edit course</h3>
                                     <p>Click to edit course, upload video, and manage exam.</p>
     </div>
  <div class="col-1 pointer fxuniversity-color" onclick="location.href='/userpgs/instructor/class/new_class.php?course_id=<?php echo $course_id?>';">
                <h3>Add class</h3>
                <p>Click to add a new class.</p>
  </div>

<?php
           } else {
             if($user_type=='neither') {
?>
                 <div class="col-1 pointer fxuniversity-color" onclick="location.href='/wallet/purchase?item=course&no=<?php echo $course_id?>';">
                 <h3>Purchase</h3>
                 <p><?php echo $cost ?> fxStars</p>
                 </div>
<?php
             }
?>

             <div class="col-1 pointer fxuniversity-color" id="examId">
             <h3>Exam</h3>
             <p>Click to take the exam and earn a certificate.</p>
             </div>
<?php
        }
?>


<?php
                require('../../../php/limit_str.php');
echo '<h3 style="text-align:center">Classes</h3>';
                if($class_result->num_rows>0) {
                    while($row=$class_result->fetch_assoc()) {
                        if($user_type=='instructor' || $user_type=='student') {
                            $onclickurl="location.href='/userpgs/instructor/class?course_id=".$course_id."&class_id=".$row['id']."'";
                        } else {
                            // not purchased
                            $onclickurl="unpurchased()";
                        }
                        echo '<div class="col-1 pointer" onclick="'.$onclickurl.'">';
                        echo '<h3>'.$row['title'].'</h3>';
                        if($row['body']=='') {
                            $descrip='<span style="color:gray">(No description)</span>';
                        } else {
                            $descrip=preg_replace("/<br\W*?\/>/", " ", $row['body']);
                        }
                        echo '<p>'.limited($descrip,70).'</p>';
                        echo '</div>';
                    }
                    $class_result->free();
                } else {
                    echo '<p style="color:gray;text-align:center;">No classes yet.</p>';
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

                





<script>
$(document).ready(function() {
    $('#examId').click(function(e) {
        if('<?php echo $user_type?>'=='student') {
            if(<?php echo $get_exam_count?> > 0) {
                window.location.href="/userpgs/instructor/exam/take_exam.php?q_id=<?php echo $get_exam_fetch['id']?>&course_id=<?php echo $course_id?>";
            } else {
                alert('No exam added by the instructor yet.');
            }
        } else if('<?php echo $user_type?>'=='neither') {
            alert('You need to purchase the course first.');
        }
    });
});
</script>

<script>
function unpurchased() {
  alert("You need to purchase the course first. ");
}
</script>
</body>
</html>