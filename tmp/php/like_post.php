<?php
require('conn/sonet.php');

if(isset($_POST['userId'])) $userId=$_POST['userId'];
if(isset($_POST['postId'])) $postId=$_POST['postId'];

// check if it's disliked by the user
/*
$check_disliked_query="SELECT * FROM dislikes WHERE userId=$userId AND postId=$postId";
$check_disliked_result=mysqli_query($sonet_connection,$check_disliked_query) or die(mysqli_error($sonet_connection));
$check_disliked_count=mysqli_num_rows($check_disliked_result);

if($check_disliked_count>0) {
    $undislike_post_query="DELETE FROM dislikes WHERE userId=$userId AND postId=$postId";
    $undislike_post_result=mysqli_query($sonet_connection,$undislike_post_query) or die(mysqli_error($sonet_connection));
}
*/

// check whether a like exists already by this user
$check_liked_query="SELECT * FROM likes WHERE userId=$userId AND postId=$postId";
$check_liked_result=mysqli_query($sonet_connection,$check_liked_query) or die(mysqli_error($sonet_connection));
$check_liked_count=mysqli_num_rows($check_liked_result);


// get count of likes
$get_likes_count_q="SELECT * FROM likes WHERE postId=$postId";
$get_likes_count_r=mysqli_query($sonet_connection,$get_likes_count_q) or die(mysqli_error($sonet_connection));
$get_likes_count=mysqli_num_rows($get_likes_count_r);


// add like if one doesn't exists by the user already
if($check_liked_count==0) {
    $like_post_query="INSERT INTO likes(userId,postId) VALUES($userId,$postId)";
    $like_post_result=mysqli_query($sonet_connection,$like_post_query) or die(mysqli_error($sonet_connection));
    $arr = array('like'=>'liked', 'count'=>$get_likes_count);
    echo json_encode($arr);
} else {
    $unlike_post_query="DELETE FROM likes WHERE userId=$userId AND postId=$postId";
    $unlike_post_result=mysqli_query($sonet_connection,$unlike_post_query) or die(mysqli_error($sonet_connection));
    $arr = array('like'=>'unliked', 'count'=>$get_likes_count);
    echo json_encode($arr);
}
?>