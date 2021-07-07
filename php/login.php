<?php

session_start();
require('../register/connect.php');

if(isset($_POST['username']) and isset($_POST['password'])) {
    $username = strtolower(mysqli_real_escape_string($connection, $_POST['username']));
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $login_query = "SELECT * FROM user WHERE ((username='$username' AND password='$password') OR (email='$username' AND password='$password'))";
    $login_result = mysqli_query($connection, $login_query);
	$login_f = mysqli_fetch_array($login_result);
	$email_ver = $login_f['active'];
    $login_count = mysqli_num_rows($login_result);
    if($login_count==1 && $email_ver==1) {
	
	if(strpos($username, '@') !== false) {
	    $uname_query = "SELECT * FROM user WHERE email='$username'";
	    $uname_result = mysqli_query($connection, $uname_query) or die(mysqli_error($connection));
	    $uname_fetch = mysqli_fetch_array($uname_result);
	    $username = $uname_fetch['username'];
	}

	$_SESSION['username'] = $username;

	if(isset($_POST['rememberme']) && $_POST['rememberme']=='remember') {
            setcookie('username',$_POST['username'],time()+60*60*24*30,'/');
            setcookie('password',$_POST['password'],time()+60*60*24*30,'/');
	} else {
            setcookie("username","");
            setcookie("password","");
	}
	
	header('Location: /userpgs');
	//exit;
	
    } elseif($login_count==1 && $email_ver==0) {
	header('Location: /?err=ver&un='.$username);
    } else {
	header('Location: /?err=wup&un='.$username);
    }
} else {
    header('Location: /?err=nup');
}

?>
