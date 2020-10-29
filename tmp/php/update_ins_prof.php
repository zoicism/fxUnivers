<?php
require('conn/fxinstructor.php');

if(isset($_POST['info'])) $info = $_POST['info'];
if(isset($_POST['edu'])) $edu = $_POST['edu'];
if(isset($_POST['emp'])) $employment = $_POST['emp'];
if(isset($_POST['tarId'])) $tarId = $_POST['tarId'];
if(isset($_POST['tarName'])) $tarname = $_POST['tarName'];
if(isset($_POST['ref'])) {if($_POST['ref']=='Yes') $refer=1;} else $refer=0;

$update_ins_prof_query = "UPDATE profile SET info='$info', edu='$edu', employment='$employment', ref=$refer WHERE userId=$tarId";
$update_ins_prof_result = mysqli_query($fxinstructor_connection, $update_ins_prof_query) or die(mysqli_error($fxinstructor_connection));

if($update_ins_prof_result) {
  header("Location: /user/".$tarname."?profUp=ok");
} else {
  header("Location: /user/".$tarname."?profUp=failed");
}

?>