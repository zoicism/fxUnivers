<?php
require_once('conn/fxinstructor.php');

if(isset($_POST['questionId'])) {
  $q_id = $_POST['questionId'];
  
  $del_q_q = "DELETE FROM question WHERE id=$q_id";
  $del_q_r = myqli_query($fxinstructor_connection, $del_q_q);

  if($del_q_r) {
    echo 1;
  } else {
    echo 0;
  }
}
?>