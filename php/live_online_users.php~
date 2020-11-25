<?php
require('../register/connect.php');
if(isset($_POST['class_id'])) $class_id=$_POST['class_id'];
if(isset($_POST['username'])) $username=$_POST['username'];
if(isset($_POST['user_id']))  $user_id=$_POST['user_id'];
if(isset($_POST['course_id'])) $course_id=$_POST['course_id'];

$add_online_q='UPDATE user SET lsPage="live/#'.$class_id.'" , lastseen=NOW() WHERE id='.$user_id;
$add_online_r=mysqli_query($connection,$add_online_q);


$stucourse_query = "SELECT * FROM stucourse WHERE course_id=$course_id";
$stucourse_result = mysqli_query($connection, $stucourse_query) or die(mysqli_error($connection));
$stucourse_count=mysqli_num_rows($stucourse_result);

if($stucourse_count>0) {

  $online_num=0;
  $offline_num=0;
  
  while($stu_row=$stucourse_result->fetch_assoc()) {
    $slct_q='SELECT * FROM user WHERE id='.$stu_row['stu_id'];
    $slct_r=mysqli_query($connection,$slct_q) or die(mysqli_error($connection));
    $slct=mysqli_fetch_array($slct_r);
    $slct_count=mysqli_num_rows($slct_r);
    if($slct_count>0) {
     if(time()-strtotime($slct['lastseen'])+12600<60) {
      $on_users .= '
        <div class="user">
          <div class="user-img avatar"></div>
    	  <div class="user-name">
      	    <p class="fullname">'.$slct['fname'].' '.$slct['lname'].' <span class="online"></span></p>
      	    <p>@'.$slct['username'].'</p>
          </div>
       </div>
       ';
       $online_num++;
     } else {
      $on_users .= '
       <div class="user">
          <div class="user-img avatar"></div>
    	  <div class="user-name">
      	    <p class="fullname">'.$slct['fname'].' '.$slct['lname'].' <span class="offline"></span></p>
      	    <p>@'.$slct['username'].'</p>
          </div>
       </div>
       ';
       $offline_num++;
      }
    }
  }


  echo $on_users.'<div style="display:none" id="get-online-num">'.$online_num.'</div>';
  
}

?>
