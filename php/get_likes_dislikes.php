<?php

require('conn/sonet.php');

// get likes count of the post
$get_likes_query="SELECT * FROM likes WHERE postId=$sonet_postId";
$get_likes_result=mysqli_query($sonet_connection,$get_likes_query) or die(mysqli_error($sonet_connection));
$get_likes=mysqli_num_rows($get_likes_result);

// get dislikes count of the post
$get_dislikes_query="SELECT * FROM dislikes WHERE postId=$sonet_postId";
$get_dislikes_result=mysqli_query($sonet_connection,$get_dislikes_query) or die(mysqli_error($sonet_connection));
$get_dislikes=mysqli_num_rows($get_dislikes_result);




// does session user like this or not
$get_i_like_query="SELECT * FROM likes WHERE userId=$get_user_id AND postId=$sonet_postId";
$get_i_like_result=mysqli_query($sonet_connection,$get_i_like_query) or die(mysqli_error($sonet_connection));
$get_i_like_count=mysqli_num_rows($get_i_like_result);
if($get_i_like_count==0) {
    $get_i_like=0;
} else {
    $get_i_like=1;
}

// does session user dislike this or not
$get_i_dislike_query="SELECT * FROM dislikes WHERE userId=$get_user_id AND postId=$sonet_postId";
$get_i_dislike_result=mysqli_query($sonet_connection,$get_i_dislike_query) or die(mysqli_error($sonet_connection));
$get_i_dislike_count=mysqli_num_rows($get_i_dislike_result);
if($get_i_dislike_count==0) {
    $get_i_dislike=0;
} else {
    $get_i_dislike=1;
}
?>