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
    // logout
      header("Location: /register/logout.php");
  }

  if(isset($_GET['course_id']))
    $course_id=$_GET['course_id'];


  require('../../../php/get_user.php');
  $id = $get_user_id;

  require('../../php/notif.php');

  if(isset($_GET['class_id']))
   $class_id = $_GET['class_id'];

  $class_query = "SELECT * FROM `class` WHERE id=$class_id";
  $class_result = mysqli_query($connection, $class_query) or die(mysqli_error($connection));
  $class_fetch = mysqli_fetch_array($class_result);

  /*$user_id = $class_fetch['teacher_id'];*/
  $header = $class_fetch['title'];
  $description = $class_fetch['body'];
  $video = $class_fetch['video'];

  require('../php/classes.php');

  require('../../../php/get_course.php');
// includes $get_course_teacher_id

  require('../../../php/get_user_type.php');

  if($user_type == 'neither') {
    $go_home = "Location: /userpgs/instructor/course_management/course.php?course_id=".$course_id."&class_id=".$class_id;
    header($go_home);
  }
  

  require('../../../contact/message_connect.php');
  require('../../../php/check_live_class.php');

require('../../../php/get_class_files.php');


$tar_id=$class_fetch['teacher_id'];
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
    <style>html{background:<?php if($user_type=='instructor') echo '#D4B1FC'; else echo '#A7A0FF'; ?></style>
    <script src="/js/jquery-3.4.1.min.js"></script>
    </head>

<body>
<div class="upperbar">
    <span class="float-left">
      <a href="/" style="color:white">fxUnivers</a> &#8250; <a href="/userpgs/fxuniversity">fxUniversity</a> &#8250; <a href="/userpgs/instructor"><?php echo $user_type?></a> &#8250; <a href="/userpgs/instructor/course_management/course.php?course_id=<?php echo $course_id?>">course</a> &#8250; class
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
                echo 'course: <strong><a style="color:black" href="/userpgs/instructor/course_management/course.php?course_id='.$course_id.'">'.$get_course_fetch["header"].'</a></strong>';
  ?>
  </div>


  <div class="col-1" id="onetwo">
                <p>video</p>
  <?php
                $path='live/uploads/';
                $file_ex=glob($path.$class_id.'.webm');
                if(count($file_ex)>0) {
                    $vid_arr=explode('.', $file_ex[0]);
                    $vid_ext=end($vid_arr);
  ?>
    
      <video width="560" height="315" controls>
        <source src="<?php echo 'live/uploads/'.$class_id.'.webm' ?>" type="video/webm">
        <source src="<?php echo 'live/uploads/'.$class_id.'.mp4' ?>" type="video/mp4"> 
      </video>
  <?php } else { ?>
      <p style="color:#25252588">no video uploaded yet.</p>
  <?php } ?>
  </div>

  <div class="col-1">
    <p>files</p>
<?php
    if($gcf_count>0) {
        while($class_fs=$gcf_result->fetch_assoc()) {
            if($user_type=='instructor') {
                echo '<p><a href="dl_file.php?file=' . urlencode($class_fs['fileName']) . '">' . $class_fs['fileName'] . '</a> <a href="del_file.php?file_name='.$class_fs['fileName'].'&course_id='.$course_id.'&class_id='.$class_id.'" style="color:red">[delete]</a></p>';
            } else {
                echo '<p><a href="dl_file.php?file=' . urlencode($class_fs['fileName']) . '">' . $class_fs['fileName'] . '</a></p>';
            }
        }
    } else {
        echo '<p style="color:#25252588">no files uploaded yet.</p>';
    }
?>
  </div>
</div>



<div class="col-33 mid-col">
<?php if($user_type=='instructor') { ?>
  <div class="col-1 pointer" onclick="location.href='/userpgs/instructor/class/edit_class.php?course_id=<?php echo $course_id?>&class_id=<?php echo $class_id?>';">
    <h3>edit class</h3>
    <p>click to edit class.</p>
  </div>
<?php } ?>
  <div class="col-1 pointer">
           <h3>live class</h3>
           <p>click to enter the live class.</p>
           <?php echo '<form action="/userpgs/instructor/class/live/" method="POST"><input type="hidden" name="course_id" value="'.$course_id.'"><input type="hidden" name="class_id" value="'.$class_id.'"><input type="submit" value="enter"></form>';?>
  </div>
<?php
                if($user_type=='instructor') {
?>
  

  <div class="col-1" style="background:#E5CFFF">
  <h3>video upload</h3>
  <form method="POST"  action="file_uploader.php" enctype="multipart/form-data" >
    <input name="video_up" type="file" accept=".avchd, .avi, .flv, .mkv, .mov, .mp4, .webm, .wmv">
    <input name="course_id" type="hidden" value="<?php echo $course_id?>">
    <input name="class_id" type="hidden" value="<?php echo $class_id?>"><br>
    <input type="submit" value="upload">
  </form>
  </div>

  <div class="col-1" style="background:#E5CFFF">
    <h3>file upload</h3>
    <form method="POST" action="class_file_upload.php" enctype="multipart/form-data">
    <input type="hidden" name="inst_id" value="<?php echo $get_user_id?>">
    <input name="class_id" type="hidden" value="<?php echo $class_id?>">
    <input name="course_id" type="hidden" value="<?php echo $course_id?>">
    <input type="file" name="uploaded_file" id="fileToUpload"><br>
    <input type="submit" value="upload">
    </form>
  </div>
<?php } ?> 
</div>


<div class="col-33 right-col">
  <?php
                require('../../../php/limit_str.php');
                if($class_result->num_rows>0) {
                    while($row=$class_result->fetch_assoc()) {
                        if($user_type=='instructor' || $user_type=='student') {
                            $onclickurl="location.href='/userpgs/instructor/class?course_id=".$course_id."&class_id=".$row['id']."'";
                        } else {
                            $onclickurl="notPurchased()";
                        }
                        if($class_id==$row['id']) $class_color='style="background:#6A29FF50"';
                        else $class_color='';
                        echo '<div class="col-1 pointer" '.$class_color.'" onclick="'.$onclickurl.'">';
                        echo '<h3>'.$row['title'].'</h3>';
                        if($row['body']=='') {
                            $descrip='<span style="color:#0000007C">(no description)</span>';
                        } else {
                            $descrip=preg_replace("/<br\W*?\/>/", " ", $row['body']);
                        }
                        echo '<p>'.limited($descrip,70).'</p>';
                        echo '</div>';
                    }
                    $class_result->free();
                }
 ?>
</div>
                
                



<div class="footer">With all due Reserves, &copy; fxUnivers 2017-2020 All rights reserved.</div>


<script>
 if(screen.width>480) {/*
     var h11=$('#oneone').height();
     var h12=$('#onetwo').height();
     var row1=0;
     if(h11>row1) row1=h11;
     if(h12>row1) row1=h12;
     $('#oneone').height(row1);
     $('#onetwo').height(row1);

     var h21=$('#twoone').height();
     var h22=$('#twotwo').height();
     var h23=$('#twothree').height();
     var row2=0;
     if(h21>row2) row2=h21;
     if(h22>row2) row2=h22;
     if(h23>row2) row2=h23;
     $('#twoone').height(row2);
     $('#twotwo').height(row2);
     $('#twothree').height(row2);*/
 }
</script>
</body>
</html>