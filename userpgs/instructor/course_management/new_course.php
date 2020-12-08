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

require('../../php/notif.php');

require('../../../php/get_plans.php');

require('../../../php/get_rel.php');
require('../../../wallet/php/get_fxcoin_count.php');

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
    <script src="/js/upperbar.js"></script>

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
			      <h2 id="titleId">Add Course</h2>

			      <form method="POST" action="new_post.php" autocomplete="off">
<?php if($get_user_verified) { ?>
			      <p>Make this course biddable:</p>
				<label class="switch">
  				<input type="checkbox" name="biddable" id="checkedId">
 				 <span class="slider round"></span>
				 </label>
<?php } ?>

				<input type="text" class="txt-input" name="header" placeholder="Course title" required>
				<textarea name="description" rows="10" placeholder="Description" required></textarea>
				<input type="number" class="num-input" name="course_fxstar" placeholder="Cost (fxStars)" id="costIn" min="0" required>

				

				<input type="submit" class="submit-btn" value="Publish">
				
			      </form>

			      

			      
                            </div>






    </div>



    


</div>


<div class="footbar blur"></div>
                          <script src="/js/footbar.js"></script>



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
