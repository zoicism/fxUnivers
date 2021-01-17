<?php
require_once('../../../register/connect.php');

if(isset($_REQUEST["file"])) {
    $file=urldecode($_REQUEST["file"]); // decode url-encoded string
    $file=mysqli_real_escape_string($connection,$file);
    
        $filepath="uploads/".$file;

        // download process
        if(file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: '.filesize($filepath));
            flush(); // flush system output buffer
            readfile($filepath);
            die();
        } else {
            http_response_code(404);
	        die();
        }
}

?>