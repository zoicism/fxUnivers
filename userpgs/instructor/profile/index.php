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



require('../../../php/get_user.php');
$id = $get_user_id;

if(isset($_GET['tar'])) {
    $tarname=$_GET['tar'];
    $tarid_q="SELECT * FROM user WHERE username='$tarname'";
    $tarid_r=mysqli_query($connection,$tarid_q) or die(mysqli_error($connection));
    $tarid_fetch=mysqli_fetch_array($tarid_r);
    $tarid=$tarid_fetch['id'];
    $tarfname=$tarid_fetch['fname'];
    $tarlname=$tarid_fetch['lname'];
}
require('../php/tar_courses.php'); // needs to be changed
require('../../php/notif.php');

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
<script src="/js/upperbar.js"></script>

    
    
<?php
                $stu1_q="SELECT id FROM teacher WHERE user_id=$tarid";
                $stu1_r=mysqli_query($connection,$stu1_q) or die(mysqli_error($connection));

                $stu_count=0;
                while($row=$stu1_r->fetch_assoc()) {
                    $course_id=$row['id'];
                    $stu2_q="SELECT id FROM stucourse WHERE course_id=$course_id";
                    $stu2_r=mysqli_query($connection,$stu2_q) or die(mysqli_error($connection));
                    $stu_count+=mysqli_num_rows($stu2_r);
                }

                $acc_count=0;
                $stu1_r=mysqli_query($connection,$stu1_q) or die(mysqli_error($connection));
                while($row2=$stu1_r->fetch_assoc()) {
                    $course_id=$row2['id'];
                    $acc_q="SELECT id FROM stucourse WHERE course_id=$course_id AND exam_accepted=1";
                    $acc_r=mysqli_query($connection,$acc_q) or die(mysqli_error($connection));
                    $acc_count+=mysqli_num_rows($acc_r);
                }
?>
</div>

<div class="col-33 left-col">
                    <div class="col-1">
    <div class="main fxuniversity-color"></div>
    <div class="icon col-icon fxuniversity-bg"></div>
  
                <h3><?php echo $tarfname.' '.$tarlname.'<br>@'.$tarname ?></h3>
                <p><b>Instructor</b></p>
                <p><strong><?php echo $course_count ?></strong> courses</p>
                <p><strong><?php echo $stu_count ?></strong> students</p>
                <p><strong><?php echo $acc_count ?></strong> accepted students</p>
  </div>
</div>




<div class="col-33 mid-col">
<?php
                require('../../../php/limit_str.php');
                
                if($course_count>0) {
                    while($row3=$course_result->fetch_assoc()) {
                        $coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$row3['id'];
                        $coursecounter_r=mysqli_query($connection,$coursecounter_q);
                        $coursecounts=mysqli_num_rows($coursecounter_r);
                        echo '<div class="col-1 pointer" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$row3['id'].'\';">';
                        echo '<h3>'.$row3['header'].'</h3>';
                        $descrip=preg_replace("/<br\W*?\/>/"," ",$row3['description']);
                        //$descrip=str_replace(array("\r\n","\r")," ",$row3['description']);
                        echo '<p><strong>'.$coursecounts.'</strong> students</p>';
                        echo '<p>'.limited($descrip,70).'</p>';
                        echo '</div>';
                    }
                    $course_result->free();
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