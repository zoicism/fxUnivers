<?php
require('conn/sonet.php');

if(isset($_POST['userId'])) $userId=$_POST['userId'];
if(isset($_POST['postId'])) $postId=$_POST['postId'];

// check whether a dislike exists already by this user
$check_disliked_query="SELECT * FROM dislikes WHERE userId=$userId AND postId=$postId";
$check_disliked_result=mysqli_query($sonet_connection,$check_disliked_query) or die(mysqli_error($sonet_connection));
$check_disliked_count=mysqli_num_rows($check_disliked_result);

// get count of dislikes
$get_dislikes_count_q="SELECT * FROM dislikes WHERE postId=$postId";
$get_dislikes_count_r=mysqli_query($sonet_connection,$get_dislikes_count_q) or die(mysqli_error($sonet_connection));
$get_dislikes_count=mysqli_num_rows($get_dislikes_count_r);

// add like if one doesn't exists by the user already
if($check_disliked_count==0) {
    $dislike_post_query="INSERT INTO dislikes(userId,postId) VALUES($userId,$postId)";
    $dislike_post_result=mysqli_query($sonet_connection,$dislike_post_query) or die(mysqli_error($sonet_connection));
    $arr=array('dislike'=>'disliked', 'count'=>$get_dislikes_count);
    echo json_encode($arr);
} else {
    $undislike_post_query="DELETE FROM dislikes WHERE userId=$userId AND postId=$postId";
    $undislike_post_result=mysqli_query($sonet_connection,$undislike_post_query) or die(mysqli_error($sonet_connection));
    $arr=array('dislike'=>'undisliked', 'count'=>$get_dislikes_count);
    echo json_encode($arr);
}
?>