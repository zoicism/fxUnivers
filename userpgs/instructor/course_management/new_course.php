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
    <script>
     if(screen.width >= 629) {
	 $(document).ready(function() {
	     $('.header-sidebar').prepend('<div style="width:100%; display:flex; flex-flow:row nowrap; justify-content:left;"><a href="/userpgs/instructor/" class="link-main" id="active-main"><div class="head">Teach</div></a><a href="/userpgs/student/" class="link-main"><div class="head">Learn</div></a></div>');
	 });
     }
    </script>
<div class="blur mobile-main">
    
	<div class="sidebar"></div>
	<?php require('../../../php/sidebar.php'); ?>


  <div class="relative-main-content">
                            <div class="content-box" style="max-width:700px;">
			      <h2 id="titleId">Add fxCourse</h2>

			      <form method="POST" action="new_post.php" autocomplete="off">
				  

				<input type="text" class="txt-input" name="header" placeholder="Course title" required>
				<textarea name="description" rows="10" placeholder="Description" required></textarea>
				<input type="number" class="num-input" name="course_fxstar" placeholder="Cost (fxStars)" id="costIn" min="0" required>
				<hr class="hr-tct" >
				<p>Make this fxCourse private:</p>
				<label class="switch" >
				    <input type="checkbox" name="private" id="privateId" >
				    <span class="slider round" ></span>
				</label>
				<p>By making a course private, you will be able to invite users to become students of this course after the course is published. You can change this setting in Course Management later.</p>
				<hr class="hr-tct" >
				<p>Can students with certificate from this fxCourse create fxSubCourses?</p>
				 <label class="switch" >
				     <input type="checkbox"  name="subbable" id="subbableId" >
				     <span class="slider round" ></span>
				 </label>
				 <p>If you allow students of this fxCourse to create fxSubCourses, they will be able to do so after they successfully pass this course's Certificate Exam. By doing so, these sub-courses will be shown in your fxCourse page as fxSubCourses and in return you will get a share of their income. You <u>cannot</u> change this setting later. </p>
				 <hr class="hr-tct" >
				 <p>Is this an fxSubCourse?</p>
				 <label class="switch" >
				     <input type="checkbox" id="isfxSub" >
				     <span class="slider round" ></span>
				 </label>
				 <select name="subOf" id="subOfId" class="select-input" style="margin-left:0; width:260px; display:none;" >
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
				 <p>If you want to publish this course as an fxSubCourse, you can choose from the list of the courses you have earned a certificate from, and get advertised in their fxCourse page in return for 10% of your income. You <u>cannot</u> change this setting later.</p>
				 <hr class="hr-tct" >
				 <p>Can students negotiate for lower price for this fxCourse?</p>
				 <label class="switch">
  				     <input type="checkbox" name="negotiable" id="checkedId">
 				     <span class="slider round"></span>
				 </label>
				 <p>By doing so you help students lacking high privileges gain knowledge and at the same time increase your income. You can change this setting in Course Management later.</p>
				     <input type="submit" class="submit-btn" value="Publish" style="margin-top:35px;">
				
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
 /*
$('#checkedId').click(function() {
  if($('#checkedId').is(':checked')) {
    $('#costIn').attr('placeholder', 'Reserve (fxStars)');
    $('#titleId').text('Add Biddable Course');
  } else {
    $('#costIn').attr('placeholder', 'Cost (fxStars)');
    $('#titleId').text('Add Course');
  }
});*/
</script>

<script>
 $('#isfxSub').click(function() {
     if($(this).prop('checked') == true) {
	 $('#subOfId').show();
     } else {
	 $('#subOfId').hide();
     }
 });
    
</script>
</body>
</html>
