<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/

session_start();
require('../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: /register/logout.php');
    exit();
}

require('../php/get_user.php');
$id = $get_user_id;

require('../userpgs/php/notif.php');

require('../php/get_plans.php');

require('../php/get_rel.php');

require('php/get_fxcoin_count.php');

//require('../php/get_trans.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>fxUnivers</title>
    <meta charset="utf-8">
	<link rel="stylesheet" href="sidebarstyle.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
</head>
    
<body>
	<div class="header-sidebar"></div>
    <script src="/js/upperbar.js"></script>

	<div class="sidebar">
		<div class="logo-sidebar logo-25"></div>
		<div>
            <?php
                    $path="../avatars/";
                    if(file_exists($path.$get_user_id.'.jpg')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../avatars/'.$get_user_id.'.jpg\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.jpeg')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../avatars/'.$get_user_id.'.jpeg\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.png')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../avatars/'.$get_user_id.'.png\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.gif')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../avatars/'.$get_user_id.'.gif\');"></a>');
                    } else {
                        echo('<a class="link avatar-sidebar"></a>');
                    }
                ?>
			<a class="id-sidebar" href="#">@Neo</a>
		</div>
		<div class="elements">
		    <a href="#" class="sidebar-icon fxstar-sidebar" id="sidebar-active">fxStar</a>
		    <a href="#" class="sidebar-icon fxuniversity-sidebar">fxUniversity</a>
		    <a href="#" class="sidebar-icon fxpartner-sidebar">fxPartner</a>
		    <a href="#" class="sidebar-icon fxuniverse-sidebar">fxUniverse</a>
		    <a href="#" class="sidebar-icon fxsonet-sidebar">fxSonet</a>
		    
	    </div>
	    <div class="socialmedia">
			<a href="#" class="sm facebook"></a>
			<a href="#" class="sm instagram"></a>
			<a href="#" class="sm twitter"></a>
			<a href="#" class="policy">Policy</a>
  		</div>
	</div>
</body>
</html>
