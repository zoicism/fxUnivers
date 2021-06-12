<?php
function formatSize($bytes) {
	if($bytes >= 1048576) {
		$bytes = number_format($bytes/1048576, 2). ' GB';
	} elseif($bytes >= 1024) {
		$bytes = number_foormat($bytes / 1024, 2). ' MB';
	} elseif($bytes > 1) {
		$bytes = $bytes . ' KB';
	} elseif($bytes == 1) {
		$bytes = $bytes . ' KB';
	} else {
		$bytes = '0 bytes';
	}

	return $bytes;
}
?>
