<?php

// does A follow B?
$get_follow_q="SELECT * FROM following WHERE id1=$session_id AND id2=$tar_id";
$get_follow_r=mysqli_query($connection,$get_follow_q) or die(mysqli_error($connection));
$get_follow=mysqli_num_rows($get_follow_r);

// are A and B friends?
$get_fnd_q="SELECT * FROM friend WHERE ( (user1='$session_id' AND user2='$tar_id') OR (user1='$tar_id' AND user2='$session_id') )";
$get_fnd_r=mysqli_query($connection,$get_fnd_q) or die(mysqli_error($connection));
$get_fnd_count=mysqli_num_rows($get_fnd_r);
$get_fnd_fetch=mysqli_fetch_array($get_fnd_r);
$get_fnd=$get_fnd_fetch['fnd'];

?>