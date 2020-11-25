<?php 
require('conn/fxinstructor.php');
if(isset($_POST['class_id'])) $class_id=$_POST['class_id'];
if(isset($_POST['user_type'])) $user_type=$_POST['user_type'];
$select_files_q="SELECT * FROM live_files WHERE classId=$class_id";
$select_file_r=mysqli_query($fxinstructor_connection,$select_files_q);
$select_file_count=mysqli_num_rows($select_file_r);
echo $select_file_count;
/*if($select_file_count>0) {
    while($lifi_row=$select_file_r->fetch_assoc()) {
        echo '<a href="dl_file.php?file=' . urlencode($lifi_row['fileName']) . '">' . $lifi_row['fileName'] . '</a>';
        if($user_type=='instructor') {
            echo ' <a target="delete-iframe" href="/php/del_live_file.php?file_name='.$lifi_row['fileName'].'" style="color:red">[DELETE]</a><br>';            
        }
    }
} else {
    echo '<p style="color:#6f6f6f">No file yet</p>';
}*/
?>