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

  require('../../../php/get_user_type.php');



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
                      <a href="/userpgs/instructor" class="link-main" <?php if($user_type=='instructor') echo 'id="active-main"'; ?>>
                        <div class="head">Teach</div>
                      </a>
        </li>
        <li class="main-items">
          <a href="/userpgs/student" class="link-main" <?php if($user_type!='instructor') echo 'id="active-main"'; ?>>
            <div class="head">Learn</div>
          </a>
        </li>
        
      </ul>
      
    </div>
          

    <div class="relative-main-content">

      foobar 
            
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
  
</body>
</html>