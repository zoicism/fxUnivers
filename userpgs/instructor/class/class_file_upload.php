<?php
//require('conn/fxinstructor.php');

if(isset($_POST['inst_id'])) $instid=$_POST['inst_id'];
if(isset($_POST['class_id'])) $classid=$_POST['class_id'];
if(isset($_POST['course_id'])) $courseid=$_POST['course_id'];

if(isset($_FILES['uploaded_file'])) {
    $uploadOK=1;
    $path1 = "uploads/";
    $microt=round(microtime(true));
    $path = $path1 . $microt . ' ' . basename( $_FILES['uploaded_file']['name']);
    $file_type=strtolower(pathinfo($path,PATHINFO_EXTENSION));
    $file_name = $microt . ' ' . basename( $_FILES['uploaded_file']['name']);
    
    // rename if file already exists
    /*if(file_exists($path)) {
        //$temp=explode(".",$_FILES['uploaded_file']['name']);
        //$path=round(microtime(true)) . '.' . end($temp);
        $add2temp=round(microtime(true));
        $path=$path1 . $add2temp . basename($_FILES['uploaded_file']['name']);
        $file_name=$add2temp . basename($_FILES['uploaded_file']['name']);
    } else {
        $file_name=basename( $_FILES['uploaded_file']['name']);
    }*/
    
    // limit file sized
    //if($_FILES['uploaded_file']['size'] > 5000000) {
    //    $uploadOK=0;
    //}
    
    // limit file type
    if($file_type!='jpg' && $file_type!='jpeg' && $file_type!='png' && $file_type!='gif' && $file_type!='ppt' && $file_type!='pptx' && $file_type!='docx' && $file_type!='doc' && $file_type!='pdf' && $file_type!='txt' && $file_type!='xps' && $file_type!='csv' && $file_type!='xls' && $file_type!='xlsx' && $file_type!='zip') $uploadOK=0;
    
    $uploadOK;
    if($uploadOK) {
        $path;
        if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
            //echo "The file ".  basename( $_FILES['uploaded_file']['name'])." has been uploaded";
            require('../../../php/conn/fxinstructor.php');
            $file_db_query="INSERT INTO class_files(instId,classId,fileName) VALUES($instid,$classid,'$file_name')";
            //echo $file_db_query.'<br>';
            $file_db_result=mysqli_query($fxinstructor_connection,$file_db_query) or die(mysqli_error($fxinstructor_connection));
	    $uploadOK=1;
        } else {
            //echo "There was an error uploading the file, please try again!";
	    $uploadOK=0;
        }
    } else {
        //echo "The file doesn't meet the criteria to be uploaded.";
	$uploadOK=0;
    }
}
//echo "successful";
echo $uploadOK;
//header("Location: /userpgs/instructor/class?course_id=$courseid&class_id=$classid");

?>
