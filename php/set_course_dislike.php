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

  if($dislike_stat_r->num_rows > 0) {
    // ALREADY DISLIKED; UNDISLIKE
    $undislike_q = "DELETE FROM courseDislikes WHERE courseId=$course_id AND userId=$user_id";
    $undislike_r = mysqli_query($fxinstructor_connection,$undislike_q);

    $response='undisliked';


  } elseif($like_stat_r->num_rows > 0) {


    // ALREADY LIKED; UNLIKE & DISLIKE
    
    $unlike_q = "DELETE FROM courseLikes WHERE courseId=$course_id AND userId=$user_id";
    $unlike_r = mysqli_query($fxinstructor_connection,$unlike_q);

    $dislike_q = "INSERT INTO courseDislikes(userId,courseId) VALUES($user_id,$course_id)";
    $dislike_r = mysqli_query($fxinstructor_connection,$dislike_q);

    $response='unliked and disliked';

  } else {

    // JUST DISLIKE
    $dislike_q = "INSERT INTO courseDislikes(userId,courseId) VALUES($user_id,$course_id)";
    $dislike_r = mysqli_query($fxinstructor_connection,$dislike_q);

    $response='disliked';
  }

}

echo $response;

?>
  