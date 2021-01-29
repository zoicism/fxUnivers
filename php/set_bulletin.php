<?php
require_once('conn/fxinstructor.php');
require_once('../register/connect.php');


if(isset($_POST['bulletin-body'])) {
  $body = mysqli_real_escape_string($fxinstructor_connection,$_POST['bulletin-body']);
  $course_id = $_POST['course-id'];
  $get_user_id = $_POST['teacher-id'];
  $course_header = mysqli_real_escape_string($fxinstructor_connection,$_POST['course-header']);
  $the_date = date("Y-m-d");
  $bulletin_q = "INSERT INTO bulletin(courseId,body,theDate) VALUES($course_id, '$body', '$the_date')";
  $bulletin_r = mysqli_query($fxinstructor_connection,$bulletin_q) or die(mysqli_error($fxinstructor_connection));

  if($bulletin_r) {

    $stu_q="SELECT * FROM stucourse WHERE course_id=$course_id";
    $stu_r=mysqli_query($connection,$stu_q);

    while($stu_row=$stu_r->fetch_assoc()) {
        $stu_id=$stu_row['stu_id'];

        $student_q="SELECT * FROM user WHERE id=$stu_id";
        $student_r=mysqli_query($connection,$student_q) or die(mysqli_error($connection));

        $student=mysqli_fetch_array($student_r);

        $student_email=$student['email'];
        $student_un=$student['username'];


	$utc_timestamp = date('Y-m-d H:i:s');

	$notif_body = "New bulletin in course <a href=\"/userpgs/instructor/course_management/course.php?course_id=$course_id\">$course_header</a>: <b>$body</b>";
        $student_notif_q="INSERT INTO notif(user_id,body,from_id, sent_dt,reason) VALUES($stu_id,'$notif_body',$get_user_id, '$utc_timestamp','bulletin')";
        $student_notif_r=mysqli_query($connection,$student_notif_q);










	///////////// Reminder Email /////////////
	$to = $student_email;
        $subject = 'fxUniversity Reminder';
        
        $message = '
  <html>
  <head>
    <title>fxUniversity Bulletin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
      html,body {
        font-family: "Roboto", sans-serif;
        background-color:#fafafa;
        color:darkslategray;
        margin:10px;
        padding:0;
      }
      p {
        font-size:1rem;
      }
    </style>
  </head>
  <body>
    <p>Dear fxUser '.$student_un.',</p>
    <p>The following bulletin is added to your <a href="https://fxunivers.com/userpgs/instructor/course_management/course.php?course_id='.$course_id.'"><b>'.$course_header.'</b></a>.</p>

    <p style="width:40px;text-align:center;">'.$body.'</p>

    
    
    <p style="font-size:1rem">We wish you the best of time learning.</p>



    
    <table style="font-size:0.9rem;margin-top:70px;background:#ececec;border-radius:12px;padding-left:20px;padding-right:20px;">
      <tr>
	<td style="vertical-align:top;"><a href="https://fxunivers.com"><img src="https://fxunivers.com/images/logo/fxunivers-logo.svg" style="width:100px;height:100px;margin-top:15px;"></a></td>
	<td style="padding-left:20px;">
	  <p style="font-style:italic;font-weight:bold;font-size:1rem;">fxUnivers Team,</p>
	  <p><span style="color:#0085b0">Address:</span><br>
	    New Horizon Building, Ground Floor,
            <br>3 1/2 Miles Philip S.W. Goldson Highway,
            <br>Belize City, Belize,
            <br>Central America
	  </p>
	  <p><span style="color:#0085b0">Email:</span> 
	    <a href="mailto: contact@fxunivers.com" style="color:darkslategray">contact@fxunivers.com</a>
	  </p>
	  <p><span style="color:#0085b0">Follow Us:</span> 
	    <a href="https://facebook.com/fxunivers"><img src="https://fxunivers.com/images/socialpack/dark/facebook.png" style="width: 15px;height: 15px;opacity: 0.6;"></a>
	    <span style="margin-left:3px;margin-right:3px;"></span>
	    <a href="https://twitter.com/fxunivers"><img src="https://fxunivers.com/images/socialpack/dark/twitter.png" style="width: 15px;height: 15px;opacity: 0.6;"></a>
	    <span style="margin-left:3px;margin-right:3px;"></span>
	    <a href="https://instagram.com/fxunivers"><img src="https://fxunivers.com/images/socialpack/dark/instagram.png" style="width: 15px;height: 15px;opacity: 0.6;"></a>
	  </p>
	</td>
      </tr>
    </table>
    
    
  </body>
  </html>
                   ';

        // Headers
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        
        // Additional headers
        $headers[] = 'From: fxUnivers <no-reply@fxunivers.com>';
        
        // Mail it!
        mail($to, $subject, $message, implode("\r\n", $headers));
        
        ////////////////////////////////////////////



    }

    if($bulletin_r) {
      echo 1;
    } else {
      echo 0;
    }
  } else {
    echo 0;
  }
}
?>