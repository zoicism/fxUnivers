<?php
session_start();
require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	$id_query = "SELECT * FROM user WHERE username='$username'";
	$id_result = mysqli_query($connection, $id_query) or die(mysqli_error($connection));
	$id_fetch = mysqli_fetch_array($id_result);
	$id = $id_fetch['id'];
}

// if the values of the post is set, post it
if(isset($_POST['header'])) {
    $header = $_POST['header'];
    $header=mysqli_real_escape_string($connection,$header);
}
if(isset($_POST['description'])) {
    $description = nl2br($_POST['description']);
    $description=mysqli_real_escape_string($connection,$description);
}
if(isset($_POST['course_id'])) $course_id = $_POST['course_id'];


$query = "INSERT INTO `class` (teacher_id, course_id, title, body) VALUES ($id, $course_id, '$header', '$description')";
//echo '>>'.$query;
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

$classId_query="SELECT * FROM class WHERE teacher_id=$id ORDER BY id DESC LIMIT 1";
$classId_result=mysqli_query($connection,$classId_query) or die(mysqli_error($connection));
$classId_fetch=mysqli_fetch_array($classId_result);
$classId=$classId_fetch['id'];
//echo classIdMin1.'444';

if($result) {    
    if(isset($_FILES['uploaded_file'])) {
        $uploadOK=1;
        $path1 = "uploads/";
        $path = $path1 . basename( $_FILES['uploaded_file']['name']);
        $file_type=strtolower(pathinfo($path,PATHINFO_EXTENSION));

        // rename if file already exists
        if(file_exists($path)) {
            //$temp=explode(".",$_FILES['uploaded_file']['name']);
            //$path=round(microtime(true)) . '.' . end($temp);
            $add2temp=round(microtime(true));
            $path=$path1 . $add2temp . basename($_FILES['uploaded_file']['name']);
            $file_name=$add2temp . basename($_FILES['uploaded_file']['name']);
        } else {
            $file_name=basename( $_FILES['uploaded_file']['name']);
        }

        // limit file size
        if($_FILES['uploaded_file']['size'] > 5000000) {
            $uploadOK=0;
        }
        
        // limit file type
        if($file_type!='jpg' && $file_type!='jpeg' && $file_type!='png' && $file_type!='gif' && $file_type!='ppt' && $file_type!='pptx' && $file_type!='docx' && $file_type!='doc' && $file_type!='pdf' && $file_type!='txt' && $file_type!='xps' && $file_type!='csv' && $file_type!='xls' && $file_type!='xlsx' && $file_type!='zip') $uploadOK=0;
        

        if($uploadOK) {
            if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
                //echo "The file ".  basename( $_FILES['uploaded_file']['name'])." has been uploaded";
                require('../../../php/conn/fxinstructor.php');
            
                $file_db_query="INSERT INTO class_files(instId,classId,fileName) VALUES($id,$classId,'$file_name')";
                $file_db_result=mysqli_query($fxinstructor_connection,$file_db_query) or die(mysqli_error($fxinstructor_connection));
            } else {
                //echo "There was an error uploading the file, please try again!";
            }
        } else {
            //echo "The file doesn't meet the criteria to be uploaded.";
        }
    }
    //echo "successful";
	header("Location: /userpgs/instructor/class?course_id=$course_id&class_id=$classId");
} else {
    //echo "failed";
}

?>