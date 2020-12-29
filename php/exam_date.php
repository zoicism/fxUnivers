<?php
if(isset($_POST['last_date'])) {
  $past_date=$_POST['last_date'];
  $now_date=date('Y-m-d');


  $date1 = new DateTime($past_date);
  $date2 = new DateTime($now_date);
  $interval = $date1->diff($date2);

  echo $interval->days;
}
?>
