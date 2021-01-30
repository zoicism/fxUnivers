<?php
require_once('conn/fxinstructor.php');

$response=0;

if(isset($_POST['courseId'])) {


  $course_id = $_POST['courseId'];
  $user_id = $_POST['userId'];

  // CHECK LIKE
  $like_stat_q = "SELECT * FROM courseLikes WHERE courseId=$course_id AND userId=$user_id";
  $like_stat_r = mysqli_query($fxinstructor_connection,$like_stat_q);

  // CHECK DISLIKE
  $dislike_stat_q = "SELECT * FROM courseDislikes WHERE courseId=$course_id AND userId=$user_id";
  $dislike_stat_r = mysqli_query($fxinstructor_connection,$dislike_stat_q);

  if($like_stat_r->num_rows > 0) {
    // ALREADY LIKED; UNLIKE
    $unlike_q = "DELETE FROM courseLikes WHERE courseId=$course_id AND userId=$user_id";
    $unlike_r = mysqli_query($fxinstructor_connection,$unlike_q);

    $response='unliked';


  } elseif($dislike_stat_r->num_rows > 0) {


    // ALREADY DISLIKED; UNDISLIKE & LIKE
    
    $undislike_q = "DELETE FROM courseDislikes WHERE courseId=$course_id AND userId=$user_id";
    $undislike_r = mysqli_query($fxinstructor_connection,$undislike_q);

    $like_q = "INSERT INTO courseLikes(userId,courseId) VALUES($user_id,$course_id)";
    $like_r = mysqli_query($fxinstructor_connection,$like_q);

    $response='undisliked and liked';

  } else {

    // JUST LIKE
    $like_q = "INSERT INTO courseLikes(userId,courseId) VALUES($user_id,$course_id)";
    $like_r = mysqli_query($fxinstructor_connection,$like_q);

    $response='liked';
  }

}

echo $response;

?>
  