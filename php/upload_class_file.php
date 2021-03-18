<?php
require('conn/fxinstructor.php');

if(isset($_POST['classId'])) $classId=$_POST['classId'];
if(isset($_POST['instId'])) $instId = $_POST['instId'];

//echo $classId;
if(isset($_FILES['class_file'])) {
    $uploadok=1;
    $path=$_SERVER['DOCUMENT_ROOT'].'/userpgs/instructor/class/uploads/';

    $microt=round(microtime(true));
    $upfile=$path . $microt . ' ' . basename($_FILES['class_file']['name']);
    $file_type=strtolower(pathinfo($upfile, PATHINFO_EXTENSION));
    $file_name=$microt . ' ' . basename($_FILES['class_file']['name']);
    
    // check for size
    // check for extension

    if($uploadok) {
        if(move_uploaded_file($_FILES['class_file']['tmp_name'],$upfile)) {
            $success=1;
            
            $file_name=mysqli_real_escape_string($fxinstructor_connection,$file_name);
            
            $upload_live_q="INSERT INTO class_files(instId, classId, fileName) VALUES($instId, $classId, '$file_name')";
            //echo $upload_live_q.'<br>';
            $upload_live_r=mysqli_query($fxinstructor_connection,$upload_live_q) or die(mysqli_error($fxinstructor_connection));
        } else {
            $success=0;
        }
    }
    
}
          
        
?>
