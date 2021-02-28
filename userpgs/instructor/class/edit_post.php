<?php
session_start();
require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $id_query = "SELECT * FROM user WHERE username='$username'";
    $id_result = mysqli_query($connection, $id_query) or die(mysqli_error($connection));
    $id_fetch = mysqli_fetch_array($id_result);
    $id = $id_fetch['id'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}


// if the values of the post is set, post it
if(isset($_POST['header']))	{
    $header = $_POST['header'];
    $header=mysqli_real_escape_string($connection,$header);
}
if(isset($_POST['description'])) {
    $description = nl2br($_POST['description']);
    $description=mysqli_real_escape_string($connection,$description);
}


if(isset($_POST['course_id'])) $course_id = $_POST['course_id'];
if(isset($_POST['class_id'])) $class_id=$_POST['class_id'];
//echo $course_id.'<br>'.$class_id.'<br>'.$header.'<br>';

$query="UPDATE class SET title='$header', body='$description' WHERE id=$class_id";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));


//echo classIdMin1.'444';

if($result) {
    echo 1;
} else {
    echo 0;
}

//header('Location: /userpgs/instructor/class?course_id='.$course_id.'&class_id='.$class_id);

?>
