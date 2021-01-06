<?php
if(isset($_REQUEST["filename"])) {
    $file=urldecode($_REQUEST["filename"]); // decode url-encoded string

    // check for illegal characters
    if(preg_match('/^[^.][-a-z0-9_.]+[a-z]$/i',$file)) {
        $filepath="../msg/files/".$file;

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
    } else {
        die("invalid file name");
    }
}
?>