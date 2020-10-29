<?php
function limited($str,$length) {
    if(strlen($str)<=$length) {
        echo $str;
    } else {
        $limput=substr($str,0,$length).'...';
        echo $limput;
    }
}
?>