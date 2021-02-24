<?php

if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $username=$_COOKIE['username'];
    $password=$_COOKIE['password'];


    $login_query = "SELECT * FROM user WHERE ((username='$username' and password='$password') or (email='$username' and password='$password'))";
    $login_result = mysqli_query($connection, $login_query);

    $login_count = mysqli_num_rows($login_result);

    if($login_count == 1) {
	
	if(strpos($username, '@') !== false) {
	    $uname_query = "SELECT * FROM user WHERE email='$username'";
	    $uname_result = mysqli_query($connection, $uname_query) or die(mysqli_error($connection));
	    $uname_fetch = mysqli_fetch_array($uname_result);
	    $username = $uname_fetch['username'];
	}

	$_SESSION['username'] = $username;

	if(1) {
            setcookie('username',$username,time()+60*60*24*30,'/');
            setcookie('password',$password,time()+60*60*24*30,'/');
	} else {
            setcookie("username","");
            setcookie("password","");
	}
	
    }
    
} else {
    
    //header('Location: /register/logout.php');
    session_start();
    session_destroy();

    if(isset($_COOKIE['password'])) {
	setcookie('username','',time()-7000000,'/');
	setcookie('password','',time()-7000000,'/');
    }

    header('Location: /');
    
}

?>
