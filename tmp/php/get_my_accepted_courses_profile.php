<?php

$gmac_query="SELECT * FROM stucourse WHERE stu_id=$tarid AND exam_accepted=1";
$gmac_result=mysqli_query($connection,$gmac_query) or die(mysqli_error($connection));
$gmac_count=mysqli_num_rows($gmac_result);

?>