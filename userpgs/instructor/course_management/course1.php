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
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">   
    <title>fxUnivers</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>html{background:<?php if($user_type=='instructor') echo '#D4B1FC'; else echo '#A7A0FF'; ?>}</style>
    <script src="/js/jquery-3.4.1.min.js"></script>
    </head>

<body>
<div class="upperbar">
    <span class="float-left">
      <a href="/">fxUnivers</a> &#8250; <a href="/userpgs/fxuniversity">fxUniversity</a> &#8250; <a href="/userpgs/<?php if($user_type=='instructor') echo 'instructor'; else echo 'student';?>"><?php if($user_type=='instructor') echo 'instructor'; else echo 'student';?></a> &#8250; course
    </span>
    <span class="float-right">
      <a id="msg_bar" href="/msg/inbox.php">msg</a> &#8226; <a id="notif_a" href="/userpgs/notif">notif</a>
    </span>
</div>

<div class="col-33 left-col">
  <div class="col-1" id="oneone">
<?php
                echo '<h3>'.$header.'</h3>';
                echo '<p>'.$description.'</p>';
                echo '<p>by <strong>'.$tar_user_fetch['fname'].' '.$tar_user_fetch['lname'].' @'.$tar_user_fetch['username'].'</strong></p>';
                echo '<p><strong>'.$class_num.'</strong> classes</p>';
                echo '<p><strong>'.$cost.'</strong> fxStars</p>';
?>
  </div>

  <div class="col-1" id="onetwo">
                <h3>video</h3>
<?php
                $path='videos/';
                $file_ex=glob($path.$course_id.'.mp4');
                if(count($file_ex)>0) {
                    $vid_arr=explode('.', $file_ex[0]);
                    $vid_ext=end($vid_arr);
?>
    
      <video width="560" height="315" controls>
        <source src="<?php echo 'videos/'.$course_id.'.'.$vid_ext ?>" type="video/<?php echo $vid_ext?>"> 
      </video>
<?php } else { ?>
      <p>no video uploaded yet.</p>
<?php } ?>
                
  </div>
</div>



<div class="col-33 mid-col">
<?php
           if($user_type=='instructor') {
?>
  <div class="col-1 pointer" style="background:#6A29FF;color:#fff;" id="twotwo" onclick="location.href='/userpgs/instructor/class/new_class.php?course_id=<?php echo $course_id?>';">
                <h3>add class</h3>
                <p>click to add a new class.</p>
  </div>
<?php
           } else {
               echo '<div class="col-1">';
               echo '<h3>classes</h3>';
               echo '<p>click on a class to join.</p>';
               echo '</div>';
           }
?>


<?php
                require('../../../php/limit_str.php');
                if($class_result->num_rows>0) {
                    $classcount=0;
                    while($row=$class_result->fetch_assoc()) {
                        if($user_type=='instructor' || $user_type=='student') {
                            $onclickurl="location.href='/userpgs/instructor/class?course_id=".$course_id."&class_id=".$row['id']."'";
                        } else {
                            // not purchased
                            $onclickurl="unpurchased()";
                        }
                        if($classcount%2==0) {
                            $class_color='#6A29FF50';
                        } else {
                            $class_color='#6A29FF25';
                        }
                        echo '<div class="col-1 pointer" style="background:'.$class_color.'" onclick="'.$onclickurl.'">';
                        echo '<h3>'.$row['title'].'</h3>';
                        if($row['body']=='') {
                            $descrip='<span style="color:#0000007C">(no description)</span>';
                        } else {
                            $descrip=preg_replace("/<br\W*?\/>/", " ", $row['body']);
                        }
                        echo '<p>'.limited($descrip,70).'</p>';
                        echo '</div>';
                        $classcount++;
                    }
                    $class_result->free();
                } else {
                    echo '<p style="color:#353535;text-align:center;">no classes yet.</p>';
                }
 ?>
</div>

<div class="col-33 right-col">                
  
<?php
                    if($user_type=='instructor') {
?>
     <div class="col-1 pointer" id="threeone" onclick="location.href='/userpgs/instructor/course_management/edit_course.php?course_id=<?php echo $course_id?>';">
                                     <h3>edit course</h3>
                                     <p>click to edit course</p>
     </div>

                
     <div class="col-1 pointer" id="threeone" onclick="location.href='/userpgs/instructor/exam?course_id=<?php echo $course_id?>';" >
                     <h3>manage exam</h3>
                                     <p>click to manage exam.</p>
                                     
                 
     </div>

                                     <div class="col-1" id="threethree" style="background:#E5CFFF">
                                     <h3>exam date</h3>
                                     <p>set the next exam date.</p>
                                     <form action="/php/submit_exam_date.php" method="POST">
                                     <input type="date" name="exam_date" style="width: 200px" <?php if(!empty($test_date)) echo 'value="'.$test_date.'"';?>>
                                     <input type="hidden" name="course_id" value="<?php echo $course_id?>"><br>
                                     <input type="submit" value="submit date">
                                     </form>
                                     </div>

             <div class="col-1"  id="threefour" style="background:#E5CFFF">
                                     <h3>video upload</h3>
                <p>select and upload course video.</p>
                    <form method="POST"  action="file_uploader.php" enctype="multipart/form-data">
                    <input name="video_up" type="file">
                    <input name="course_id" type="hidden" value="<?php echo $course_id?>"><br>
                    <input type="submit" value="upload">
                    </form>
             </div>
<?php
                    } else {
?>
<?php
                        if($user_type=='neither') {
?>
                            <div class="col-1 pointer" onclick="location.href='/wallet/purchase?item=course&no=<?php echo $course_id?>';">
                            <h3>purchase</h3>
                            <p><?php echo $cost ?> fxStars</p>
                            </div>
<?php
                        }
?>

                        <div class="col-1 pointer" id="examId">
                          <h3>exam</h3>
                          <p>click to take the exam and earn a certificate.</p>
                        </div>
<?php
                    }
?>
</div>







                


<div class="footer">With all due Reserves, &copy; fxUnivers 2017-2020 All rights reserved.</div>

<script>
$(document).ready(function() {
<?php $get_exam_fetch=mysqli_fetch_array($get_exam_result); ?>
    $('#examId').click(function(e) {
        if('<?php echo $user_type?>'=='student') {
            window.location.replace("/userpgs/instructor/exam/take_exam.php?q_id=<?php echo $get_exam_fetch['id']?>&course_id=<?php echo $course_id?>");
        } else if('<?php echo $user_type?>'=='neither') {
            alert('you need to purchase the course first.');
        }
    });
});
</script>

<script>/*
                if(screen.width>480) {
                    var h11=$('#oneone').height();
                    var h12=$('#onetwo').height();
                    var row1=0;
                    if(h11>row1) row1=h11;
                    if(h12>row1) row1=h12;
                    $('#oneone').height(row1);
                    $('#onetwo').height(row1);


                    var h21=$('#twoone').height();
                    var h22=$('#twotwo').height();
                    var row2=0;
                    if(h21>row2) row2=h21;
                    if(h22>row2) row2=h22;
                    $('#twoone').height(row2);
                    $('#twotwo').height(row2);
                    }*/
</script>
<script>
function unpurchased() {
  alert("you need to purchase the course first. ");
}
</script>
</body>
</html>