<?php
require_once('../register/connect.php');

if(isset($_POST['caller_username'])) {
  $caller_un = $_POST['caller_username'];

  $caller_q = "SELECT avatar FROM user WHERE username='$caller_un'";
  $caller_r = mysqli_query($connection, $caller_q);
  $caller = mysqli_fetch_array($caller_r);

  $caller_avatar = $caller['avatar'];

  echo $caller_avatar;
}
?>