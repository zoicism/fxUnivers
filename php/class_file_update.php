<?php 
require('conn/fxinstructor.php');
if(isset($_POST['class_id'])) $class_id=$_POST['class_id'];
if(isset($_POST['user_type'])) $user_type=$_POST['user_type'];
$select_files_q="SELECT * FROM live_files WHERE classId=$class_id";
$select_file_r=mysqli_query($fxinstructor_connection,$select_files_q);
$select_file_count=mysqli_num_rows($select_file_r);
echo '<div id="getFilesNum" style="display:none">'.$select_file_count.'</div>';
if($select_file_count>0) {
    while($lifi_row=$select_file_r->fetch_assoc()) {
        echo '<div class="file"><a class="blue" href="dl_file.php?file=' . urlencode($lifi_row['fileName']) . '"><img src="/images/background/files.svg"></a>';
        echo '<div class="file-name"><a class="blue" href="dl_file.php?file=' . urlencode($lifi_row['fileName']) . '">' . substr($lifi_row['fileName'],11) . '</a></div>';
        if($user_type=='instructor') {
            echo '<div class="del"><a target="hidden-del" href="/php/del_live_file.php?file_name='.$lifi_row['fileName'].'" class="red">DELETE</a><br></div>';
        }
	echo '</div>';
    }

    
} else {
    echo '<p class="gray">No files yet</p>';
}
?>
