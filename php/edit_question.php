<?php
require_once('../register/connect.php');
require_once('conn/fxinstructor.php');

if(isset($_POST['qCount'])) {
    $askNum = $_POST['ask_num'];
    $duration = $_POST['duration'];
    $qCount = $_POST['qCount'];
    $courseId = $_POST['course_id'];


    for($i=1;$i<=$qCount;$i++) {
      $q_id = $_POST['question_id'.$i];
      $q_body = mysqli_real_escape_string($fxinstructor_connection,$_POST['q'.$i]);
      $corr = $_POST['corr'.$i];

      $option = array();
      for($j=1;$j<=4;$j++) {
        $option[$j] = mysqli_real_escape_string($fxinstructor_connection,$_POST['q'.$i.'o'.$j]);
      }

      $question_q = 'UPDATE question SET question="'.$q_body.'", a="'.$option[1].'", b="'.$option[2].'", c="'.$option[3].'", d="'.$option[4].'", correct="'.$corr.'" WHERE id='.$q_id;
      $question_r = mysqli_query($fxinstructor_connection,$question_q);

      if($question_r) {
        $ok = 1;
      } else {
        $ok = 0;
      }
    }

    if($ok) {
      $teacher_q = "UPDATE teacher SET test_duration=$duration, test_num=$askNum WHERE id=$courseId";
      $teacher_r = mysqli_query($connection,$teacher_q);
    }

    if($teacher_r) {
      $ok=1;
    } else {
      $ok=0;
    }

    echo $ok;
}

?>