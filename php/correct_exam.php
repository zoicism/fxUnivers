<?php
require_once('conn/fxinstructor.php');
require_once('../register/connect.php');

if(isset($_POST['qCount'])) {
  $q_num = $_POST['qCount'];
  $course_id = $_POST['course_id'];
  $stu_id = $_POST['stu_id'];

  $num_of_corrs=0;
  $results = array();

  for($i=1;$i<=$q_num;$i++) {
    $q_id = $_POST['question_id'.$i];
    $stu_corr = $_POST['corr'.$i];

    $act_corr_q = "SELECT * FROM question WHERE id=$q_id";
    $act_corr_r = mysqli_query($fxinstructor_connection,$act_corr_q);
    $act_corr_f = mysqli_fetch_array($act_corr_r);

    $act_corr = $act_corr_f['correct'];

    if($act_corr==$stu_corr) {
      $num_of_corrs++;
      $results[$i]=1;
    } else {
      $results[$i]=0;
    }
  }


  $date = date('Y-m-d');
  $score = $num_of_corrs / $q_num;
  if($score >= 0.5) {
    $acceptance=1;
  } else {
    $acceptance=0;
  }
  
  
  // ADD TO `stucourse`
  $stucourse_q = "UPDATE stucourse SET score=$score, exam_accepted=$acceptance, last_exam='$date' WHERE course_id=$course_id AND stu_id=$stu_id";
  $stucourse_r = mysqli_query($connection,$stucourse_q) or die(mysqli_error($connection));
   
  
  if($stucourse_r) {
    echo json_encode($results);
  }
}

?>