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
        echo '<div class="file">
		<div class="file-icon-con" href="dl_file.php?file=' . urlencode($lifi_row['fileName']) . '">
			<svg viewBox="0 0 32 32">
				<path d="M26,8.6,19.4,2l-2-2H8A4,4,0,0,0,4,4V28a4,4,0,0,0,4,4H24a4,4,0,0,0,4-4V10.6ZM18,3.4,24.6,10H20a2,2,0,0,1-2-2ZM26,28a2,2,0,0,1-2,2H8a2,2,0,0,1-2-2V4A2,2,0,0,1,8,2h8V8a4,4,0,0,0,4,4h6Z"></path>
			</svg>
		</div>';
        echo '<div class="file-name"><div class="file-name-txt" href="dl_file.php?file=' . urlencode($lifi_row['fileName']) . '">' . substr($lifi_row['fileName'],11) . '</a></div>';
        if($user_type=='instructor') {
	echo '<div class="download-delete-con">';
	    echo '<div class="download-file">
	    		<a target="hidden-del" href="/php/del_live_file.php?file_name='.$lifi_row['fileName'].'">
				<svg viewBox="0 0 32 32"><rect y="30" width="32" height="2" rx="1"/><path d="M24.2,15.9l-6.6,7.8a2,2,0,0,1-1.6.7h0a2,2,0,0,1-1.6-.7L7.8,15.9a1.1,1.1,0,0,1,.1-1.5h0a1,1,0,0,1,1.4.2L15,21.3V1a.9.9,0,0,1,1-1h0a.9.9,0,0,1,1,1V21.3l5.7-6.7a1,1,0,0,1,1.4-.2h0A1.1,1.1,0,0,1,24.2,15.9Z"/></svg>
			</a><br>
		</div>';
            echo '<div class="del">
	    		<a target="hidden-del" href="/php/del_live_file.php?file_name='.$lifi_row['fileName'].'">
				<svg viewBox="0 0 32 32"><path d="M31,5.1H22.1V4a4,4,0,0,0-4-4H13.9a4,4,0,0,0-4,4V5.1H1a1,1,0,0,0-1,1,.9.9,0,0,0,1,1H3.3L5.7,28.5a3.9,3.9,0,0,0,4,3.5H22.3a3.9,3.9,0,0,0,4-3.5L28.7,7.1H31a.9.9,0,0,0,1-1A1,1,0,0,0,31,5.1ZM11.9,4a2,2,0,0,1,2-2h4.2a2,2,0,0,1,2,2V5.1H11.9ZM24.3,28.2a2,2,0,0,1-2,1.8H9.7a2,2,0,0,1-2-1.8L5.3,7.1H26.7Z"></path><path d="M18.8,12.2V24.9a1,1,0,0,0,1,1h0a1.1,1.1,0,0,0,1-1V12.2a1.1,1.1,0,0,0-1-1h0A1,1,0,0,0,18.8,12.2ZM12.2,25.9h0a1,1,0,0,0,1-1V12.2a1,1,0,0,0-1-1h0a1.1,1.1,0,0,0-1,1V24.9A1.1,1.1,0,0,0,12.2,25.9Z"></path></svg>
			</a><br>
		</div>';
	echo '</div>';
        } else if($user_type=='student') {
		echo '<div class="download-delete-con">';
	    echo '<div class="download-file">
	    		<a target="hidden-del" href="/php/del_live_file.php?file_name='.$lifi_row['fileName'].'">
				<svg viewBox="0 0 32 32"><rect y="30" width="32" height="2" rx="1"/><path d="M24.2,15.9l-6.6,7.8a2,2,0,0,1-1.6.7h0a2,2,0,0,1-1.6-.7L7.8,15.9a1.1,1.1,0,0,1,.1-1.5h0a1,1,0,0,1,1.4.2L15,21.3V1a.9.9,0,0,1,1-1h0a.9.9,0,0,1,1,1V21.3l5.7-6.7a1,1,0,0,1,1.4-.2h0A1.1,1.1,0,0,1,24.2,15.9Z"/></svg>
			</a><br>
		</div>';
		echo '</div>';
	}
	echo '</div>';
    }

    
} else {
    echo '<p class="gray">No files yet</p>';
}
?>
