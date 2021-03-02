<?php
require('../register/connect.php');
if(isset($_POST['class_id'])) $class_id=$_POST['class_id'];
if(isset($_POST['username'])) $username=$_POST['username'];
if(isset($_POST['user_id']))  $user_id=$_POST['user_id'];
if(isset($_POST['course_id'])) $course_id=$_POST['course_id'];
if(isset($_POST['teacherId'])) $teacher_id = $_POST['teacherId'];

$dt=date('Y-m-d H:i:s');

$add_online_q='UPDATE user SET lsPage="live/#'.$class_id.'" , lastseen="'.$dt.'" WHERE id='.$user_id;
$add_online_r=mysqli_query($connection,$add_online_q);


$online_num=0;
  $offline_num=0;


  // CHECK INSTRUCTOR'S PRESENCE
  $instructor_q = 'SELECT * FROM user WHERE id='.$teacher_id;
  $instructor_r = mysqli_query($connection,$instructor_q);
  $instructor_count = mysqli_num_rows($instructor_r);
  $instructor = mysqli_fetch_array($instructor_r);


if($instructor['avatar']!=NULL) {
      $avatar_url='/userpgs/avatars/'.$instructor['avatar'];
} else {
      $avatar_url='/images/background/avatar.png';
}


if($instructor_count>0) {

  

    if((time()-strtotime($instructor['lastseen']) < 30) && ($instructor['lsPage']=="live/#$class_id")) {
     $teacher_stat = '
      <div class="user" onclick="window.location.replace(\'/user/'.$instructor['username'].'\');">
          <div class="user-img avatar" style="background-image:url(\''.$avatar_url.'\');"></div>
    	  <div class="user-name">
	    <p class="fullname">'.$instructor['username'].' <span style="font-size:0.6rem">(INSTRUCTOR)</span> <span class="online"></span></p>
      	    <p>'.$instructor['fname'].' '.$instructor['lname'].' </p>
      	    
          </div>
       </div>
       ';
       $online_num++;
     } else {
      $teacher_stat = '
       <div class="user" onclick="window.location.replace(\'/user/'.$instructor['username'].'\');">
          <div class="user-img avatar" style="background-image:url(\''.$avatar_url.'\');"></div>
    	  <div class="user-name">
	    <p class="fullname">'.$instructor['username'].' <span style="font-size:0.6rem">(INSTRUCTOR)</span> <span class="offline"></span></p>
      	    <p>'.$instructor['fname'].' '.$instructor['lname'].' </p>
      	    
          </div>
       </div>
       ';
       $offline_num++;
    }
} 



$stucourse_query = "SELECT * FROM stucourse WHERE course_id=$course_id";
$stucourse_result = mysqli_query($connection, $stucourse_query) or die(mysqli_error($connection));
$stucourse_count=mysqli_num_rows($stucourse_result);

if($stucourse_count>0) {

  
  
  while($stu_row=$stucourse_result->fetch_assoc()) {
       $slct_q='SELECT * FROM user WHERE id='.$stu_row['stu_id'].' AND lsPage="live/#'.$class_id.'"'; 
    $slct_r=mysqli_query($connection,$slct_q) or die(mysqli_error($connection));
    $slct=mysqli_fetch_array($slct_r);
    $slct_count=mysqli_num_rows($slct_r);// echo time()strtotime($slct['lastseen']); exit();
   if($slct_count>0) {


   if($slct['avatar']!=NULL) {
      $avatar_url='/userpgs/avatars/'.$slct['avatar'];
} else {
      $avatar_url='/images/background/avatar.png';
}



     if(time()-strtotime($slct['lastseen'])<30) {
      $on_users .= '
        <div class="user" onclick="window.location.replace(\'/user/'.$slct['username'].'\');">
          <div class="user-img avatar" style="background-image:url(\''.$avatar_url.'\');"></div>
    	  <div class="user-name">
	    <p class="fullname">'.$slct['username'].' <span class="online"></span></p>
      	    <p>'.$slct['fname'].' '.$slct['lname'].' </p>
      	    
          </div>
       </div>
       ';
       $online_num++;
     } /* else {
      $off_users .= '
       <div class="user" onclick="window.location.replace(\'/user/'.$slct['username'].'\');">
          <div class="user-img avatar" style="background-image:url(\''.$avatar_url.'\');"></div>
    	  <div class="user-name">
	    <p class="fullname">'.$slct['username'].' <span class="offline"></span></p>
      	    <p>'.$slct['fname'].' '.$slct['lname'].' </p>
      	    
          </div>
       </div>
       ';
       $offline_num++;
      }*/
    }
  }



  
    

  echo $teacher_stat.$on_users.'<div style="display:none" id="get-online-num">'.$online_num.'</div>';
  
} else {
  echo '<p class="gray">This course has no students yet</p>';
}

?>
