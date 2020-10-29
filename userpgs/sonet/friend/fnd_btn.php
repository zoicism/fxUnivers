<?php
session_start();

if(isset($_GET['friendship'])) {
  $clicked=1;
}

if($friendship==1 && $fnd==0) {
  // The request has already been sent and now you can
  // Cancel Request!
  $btn_label="Cancel Friend Request!";
  if($clicked) {
    $unfnd_query = "DELETE FROM friend WHERE ( (user1='$user1id' AND user2='$user2id') OR (user1='$user2id' AND user2='user1id') )";
    $unfnd_result = mysqli_query($connection, $unfnd_query) or die(mysqli_error($connection));

    $del_request_query = "DELETE FROM notif WHERE body='>> $username has sent you a friend request.'";
    $del_request_result = mysqli_query($connection, $del_request_query) or die(mysqli_error($connection));
    $btn_label="Friend!";
  }

} else if($friendship==1 && $fnd==1) {
  // Already friends and now you can
  // Unfriend!
  $btn_label="Unfriend!";
  if($clicked) {
    $unfnd_query = "DELETE FROM friend WHERE ( (user1='$user1id' AND user2='$user2id') OR (user1='$user2id' AND user2='user1id') )";
    $unfnd_result = mysqli_query($connection, $unfnd_query) or die(mysqli_error($connection));
    $btn_label="Friend!";
  }

} else if($friendship==0 && $fnd==0) {
  // Not friends and you can
  // Friend!
  $btn_label="Friend!";
  if($clicked) {
    $fnd_query = "INSERT INTO friend(user1, user2, fnd) VALUES($user1id, $user2id, 0)";
    $fnd_result = mysqli_query($connection, $fnd_query) or die(mysqli_error($connection));

    $request_query = "INSERT INTO notif(user_id, body, from_id) VALUES($user2id, '>> $username has sent you a friend request.', $user1id)";
    $request_result = mysqli_query($connection, $request_query) or die(mysqli_error($connection));

    $btn_label="Cancel Friend Request!";
  }

} else {
  // There must be an error cause we're dealing with an
  // impossible situation here, s.t. friendship==0 and
  // fnd==1, which cannot be true.
}

?>