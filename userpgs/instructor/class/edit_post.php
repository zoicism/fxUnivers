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

    

    // if the checkbox is ticked, remove all files from db
    if(isset($_POST['remove_file']) && $_POST['remove_file']=='Yes') {
        require('../../../php/conn/fxinstructor.php');
        $remove_file_db_query="DELETE FROM class_files WHERE classId=$class_id";
        $remove_file_db_result=mysqli_query($fxinstructor_connection,$remove_file_db_query) or die(mysqli_error($fxinstructor_connection));
    }

    
    // if a file is loaded, it needs to be replaced
    if(isset($_FILES['uploaded_file'])) {

        // check db for a file for this class
        require('../../../php/get_class.php');
        // if no file already exists for this class in the db
        if($get_class_file_count==0) {
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
            if($_FILES['uploaded_file']['size'] > 50000) {
                //$uploadOK=0;
            }
            
            // limit file type
            if($file_type!='jpg' && $file_type!='jpeg' && $file_type!='png' && $file_type!='gif' && $file_type!='ppt' && $file_type!='pptx' && $file_type!='docx' && $file_type!='doc' && $file_type!='pdf' && $file_type!='txt' && $file_type!='xps' && $file_type!='csv' && $file_type!='xls' && $file_type!='xlsx' && $file_type!='zip') $uploadOK=0;
        

            if($uploadOK) {
                if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
                    //echo "The file ".  basename( $_FILES['uploaded_file']['name'])." has been uploaded";
                    require('../../../php/conn/fxinstructor.php');
                    //echo $id.' '.$classId.' '.$file_name.'<br>';
                    $file_db_query="INSERT INTO class_files(instId,classId,fileName) VALUES($id,$class_id,'$file_name')";
                    $file_db_result=mysqli_query($fxinstructor_connection,$file_db_query) or die(mysqli_error($fxinstructor_connection));
                } else {
                    //echo "There was an error uploading the file, please try again!";
                }
            } else {
                //echo "The file doesn't meet the criteria to be uploaded.";
            }
        } else { // if a file exists for this class in db already
            
            // upload the new file
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
            if($_FILES['uploaded_file']['size'] > 50000) {
                //$uploadOK=0;
            }
            
            // limit file type
            if($file_type!='jpg' && $file_type!='jpeg' && $file_type!='png' && $file_type!='gif' && $file_type!='ppt' && $file_type!='pptx' && $file_type!='docx' && $file_type!='doc' && $file_type!='pdf' && $file_type!='txt' && $file_type!='xps' && $file_type!='csv' && $file_type!='xls' && $file_type!='xlsx' && $file_type!='zip') $uploadOK=0;
            
            
            if($uploadOK) {
                if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
                    require('../../../php/conn/fxinstructor.php');
                    $file_db_query="UPDATE class_files SET fileName='$file_name' WHERE classId=$class_id";
                    $file_db_result=mysqli_query($fxinstructor_connection,$file_db_query) or die(mysqli_error($fxinstructor_connection));
                } else {
                    //echo "There was an error uploading the file, please try again!";
                }
            } else {
                //echo "The file doesn't meet the criteria to be uploaded.";
            }
        }
    }
    //echo "successful";
} else {
    //echo "failed";
}

header('Location: /userpgs/instructor/class?course_id='.$course_id.'&class_id='.$class_id);

?>