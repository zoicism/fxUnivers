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
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

require('../../../php/get_user.php');
$id = $get_user_id;

require('../../php/notif.php');

require('../../../php/get_plans.php');

require('../../../php/get_rel.php');
require('../../../wallet/php/get_fxcoin_count.php');

$get_courses_q = "SELECT * FROM stucourse WHERE stu_id = $get_user_id";
$get_courses_r = mysqli_query($connection, $get_courses_q);
?>

<!DOCTYPE html>
<html>
<head>
	<title>fxUniversity</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
</head>
    
<body>
	<div class="header-sidebar"></div>
    <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>

<div class="blur mobile-main">
    
	<div class="sidebar"></div>
	<?php require('../../../php/sidebar.php'); ?>







                          
    <div class="main-content">

              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/userpgs/instructor" class="link-main" id="active-main">
                          <div class="head">Teach</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/userpgs/student" class="link-main">
                          <div class="head">Learn</div>
                      </a>
                  </li>
                  
              </ul>

    </div>





  <div class="relative-main-content">
                            <div class="content-box">
			      <h2 id="titleId">Add fxCourse</h2>

			      <form method="POST" action="new_post.php" autocomplete="off">
				  

				<input type="text" class="txt-input" name="header" placeholder="Course title" required>
				<textarea name="description" rows="10" placeholder="Description" required></textarea>
				<input type="number" class="num-input" name="course_fxstar" placeholder="Cost (fxStars)" id="costIn" min="0" required>

				<p>Can students with certificate from this fxCourse create fxSubCourses?</p>
				 <label class="switch" >
				     <input type="checkbox"  name="subbable" id="subbableId" >
				     <span class="slider round" ></span>
				 </label>

				 <p>Is this an fxSubCourse?</p>
				 <select name="subOf" id="subOfId" class="select-input" style="margin-left:0; width:260px;" >
				     <option value="" disabled selected>Select a Certified Course</option>
				     <?php
				     while($course = $get_courses_r -> fetch_assoc()) {
					 $c_id = $course['course_id'];
					 $cert = $course['exam_accepted'];
					 $get_sub_q = "SELECT * FROM teacher WHERE id = $c_id";
					 $get_sub_r = mysqli_query($connection, $get_sub_q);
					 $get_sub_f = mysqli_fetch_array($get_sub_r);
					 $subbable = $get_sub_f['subbable'];

					 if($cert && $subbable) {
					     if(isset($_GET['sub']) && !empty($_GET['sub'])) {
						 if($c_id == $_GET['sub']) {
						     echo '<option value="'.$c_id.'" selected="selected">'.$get_sub_f['header'].'</option>';
						 } else {
						     echo '<option value="'.$c_id.'">'.$get_sub_f['header'].'</option>';
						 }
					     } else {
						 echo '<option value="'.$c_id.'">'.$get_sub_f['header'].'</option>';
					     }
					 }
				     }
				     ?>
				 </select>
				 
				 <p>Can underprivileged students ask for lower price for this fxCourse?</p>
				 <label class="switch">
  				     <input type="checkbox" name="biddable" id="checkedId">
 				     <span class="slider round"></span>
				 </label>

				<input type="submit" class="submit-btn" value="Publish">
				
			      </form>

			      

			      
                            </div>






    </div>



    


</div>


<div class="footbar blur"></div>
                          <script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>



<!-- SCRIPTS -->
<script>
                          $('#page-header').html('fxUniversity');
$('#page-header').attr('href','/userpgs/fxuniversity');
</script>


<!-- fxUniversity sidebar active -->
<script>
$('.fxuniversity-sidebar').attr('id','sidebar-active');
</script>


<script>
$('#checkedId').click(function() {
  if($('#checkedId').is(':checked')) {
    $('#costIn').attr('placeholder', 'Reserve (fxStars)');
    $('#titleId').text('Add Biddable Course');
  } else {
    $('#costIn').attr('placeholder', 'Cost (fxStars)');
    $('#titleId').text('Add Course');
  }
});
</script>


</body>
</html>
