<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

if(isset($_POST['inviteeUsername']) && isset($_POST['courseId'])) {
    $inviteeUn = $_POST['inviteeUsername'];
    $course_id = $_POST['courseId'];
    $course_header = mysqli_real_escape_string($connection, $_POST['courseHeader']);
    $course_instructor_id = $_POST['instructorId'];
    $instructor_un = $_POST['instructorUn'];

    $invitee_q = "SELECT * FROM user WHERE username='$inviteeUn'";
    $invitee_r = mysqli_query($connection, $invitee_q);
    
    if($invitee_r -> num_rows == 0) {
	echo 'not_found';
	exit();
    } else {
	$invitee = mysqli_fetch_array($invitee_r);
	$student_id = $invitee['id'];

	$get_invitee_q = "SELECT * FROM private WHERE course_id = $course_id AND student_id = $student_id";
	$get_invitee_r = mysqli_query($fxinstructor_connection, $get_invitee_q);
	$get_invitee = mysqli_num_rows($get_invitee_r);
	if($get_invitee > 0) {
	    echo 'dup';
	    exit();
	} else {
	    
	    $add_invitee_q = "INSERT INTO private(course_id, student_id) VALUES($course_id, $student_id)";
	    $add_invitee_r = mysqli_query($fxinstructor_connection, $add_invitee_q);
	}
    }
} else {
    echo 0;
    exit();
}

if($add_invitee_r) {
    $invitation_notif_body = 'You are invited to a private fxCourse: '.$course_header.'. Please visit by clicking the button below. <a href="/userpgs/instructor/course_management/course.php?course_id='.$course_id.'"><button class="submit-btn">Visit fxCourse</button></a>';
    $invitation_notif_body = mysqli_real_escape_string($connection, $invitation_notif_body);

    $dt = date('Y-m-d H:i:s');

    $notify_q = "INSERT INTO notif(user_id, body, from_id, sent_dt, reason) VALUES($student_id, '$invitation_notif_body', $course_instructor_id, '$dt', 'private_course')";
    $notify_r = mysqli_query($connection, $notify_q);


    /*
       if($notify_r) {
       ///////////// Reminder Email /////////////

       $to = $student_email;
       $subject = 'fxUniversity Reminder';
       
       $message = '
       <html>
       <head>
       <title>fxCourse Invitation</title>
       <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
       <style>
       html,body {
       font-family: "Roboto", sans-serif;
       background-color:#fafafa;
       color:darkslategray;
       margin:10px;
       padding:0;
       }
       </style>
       </head>
       <body>
       <p style="font-size:1rem">Dear fxUser '.$inviteeUn.',</p>
       <p style="font-size:1rem">fxInstructor <a href="https://fxunivers.com/user/'.$instructorUn.'">@'.$instructorUn.'</a> has invited you to join a private fxCourse: <b>'.$course_header.'</b></p>
       <p style="font-size:1rem">Click the following link to visit the course.</p>
       
       <a href="https://fxunivers.com/userpgs/instructor/course_management/course.php?course_id='.$course_id.'">https://fxunivers.com/userpgs/instructor/course_management/course.php?course_id='.$course_id.'</a>
       
       <p style="font-size:1rem">We wish you the best of time learning.</p>



       
       <table style="font-size:0.9rem;margin-top:70px;background:#ececec;border-radius:12px;padding-left:20px;padding-right:20px;">
       <tr>
       <td style="vertical-align:top;"><a href="https://fxunivers.com"><img src="https://fxunivers.com/images/logos/fxunivers-logo.svg" style="width:100px;height:100px;margin-top:15px;"></a></td>
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
       }*/
    echo 1;
} else {
    echo 0;
}
?>
