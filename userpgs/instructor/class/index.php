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
            <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">   

    <title>fxUnivers</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <link rel="stylesheet" href="/css/colors.css">
    <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet">
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
    </head>

<body>

    <div class="upperbar"></div>
<script src="/js/upperbar.js"></script>

<div class="col-66 left-col">
    
    <div class="main fxuniversity-color"></div>
    <div class="icon col-icon fxuniversity-bg" onclick="location.href='/userpgs/fxuniversity';"></div>
<?php
    $path='live/uploads/';
$file_ex=glob($path.$class_id.'.*');
if(count($file_ex)>0) {
    $vid_arr=explode('.', $file_ex[0]);
    $vid_ext=end($vid_arr);
?>

    <video width="560" height="315" controls>
    <source src="<?php echo 'live/uploads/'.$class_id.'.'.$vid_ext ?>" type="video/<?php echo $vid_ext?>">
    </video>

    <?php
}
                echo '<h2>'.$header.'</h2>';

    

                echo '<p style="text-align:left">'.$description.'</p>';
                echo '<p style="margin-top:20px">By: <strong><a href="/user/'.$tar_user_fetch['fname'].'">'.$tar_user_fetch['fname'].' '.$tar_user_fetch['lname'].' @'.$tar_user_fetch['username'].'</a></strong></p>';
                echo '<p>Course: <strong><a href="/userpgs/instructor/course_management/course.php?course_id='.$course_id.'">'.$get_course_fetch["header"].'</a></strong></p>';
  ?>


<div class="col-1">
    <h3>Files</h3>
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
        echo '<p style="color:gray">No files yet</p>';
    }
?>
  </div>
  </div>

    

<div class="col-33 right-col">
  <?php if($user_type=='instructor') { ?>
    <div class="col-1 pointer fxuniversity-color" onclick="location.href='/userpgs/instructor/class/edit_class.php?course_id=<?php echo $course_id?>&class_id=<?php echo $class_id?>';">
    <h3>Edit class</h3>
    <p>Click to edit class.</p>
    </div>
<?php } ?>
  <div class="col-1 pointer fxuniversity-color">
           <h3>Live class</h3>
           <p>Click to enter the live class.</p>
              <?php echo '<form action="/userpgs/instructor/class/live/#'.$class_id.'" method="POST"><input type="hidden" name="course_id" value="'.$course_id.'"><input type="hidden" name="class_id" value="'.$class_id.'"><input type="submit" value="Enter"></form>';?>    
           
  </div>


<h3 style="text-align:center;">Classes</h3>
<?php
                require('../../../php/limit_str.php');
                if($class_result->num_rows>0) {
                    while($row=$class_result->fetch_assoc()) {
                        if($user_type=='instructor' || $user_type=='student') {
                            $onclickurl="location.href='/userpgs/instructor/class?course_id=".$course_id."&class_id=".$row['id']."'";
                        } else {
                            $onclickurl="notPurchased()";
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
   var timepicker = new TimePicker('time', {
     lang: 'en',
     theme: 'dark'
   });
                                       
   timepicker.on('change', function(evt) {
     var value = (evt.hour || '00') + ':' + (evt.minute || '00');
     evt.element.value = value;
   });
</script>


</body>
</html>