<?php
require('../register/connect.php');

if(isset($_POST['username'])) $username=$_POST['username'];
if(isset($_POST['fname'])) $fname=$_POST['fname'];
$fname=mysqli_escape_string($connection,$fname);
if(isset($_POST['lname'])) $lname=$_POST['lname'];
$lname=mysqli_escape_string($connection,$lname);
if(isset($_POST['bio'])) $bio=$_POST['bio'];
$bio=mysqli_escape_string($connection,$bio);
if(isset($_POST['user_id'])) $userid=$_POST['user_id'];

$setbio_q="UPDATE user SET fname='$fname', lname='$lname', bio='$bio' WHERE id=$userid";
$setbio_r=mysqli_query($connection,$setbio_q) or die(mysqli_error($connection));

header('Location: /user/?tar='.$username);

?>