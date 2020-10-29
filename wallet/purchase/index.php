<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/

session_start();
require('../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: /register/logout.php');
    exit();
}

require('../../php/get_user.php');
$id = $get_user_id;
require('../../userpgs/php/notif.php');
require('../../php/get_plans.php');
require('../../php/get_rel.php');
require('../php/get_fxcoin_count.php');

//require('../php/get_trans.php');

if(isset($_GET['item'])) {
    $item=$_GET['item'];
    $course_id=$_GET['no'];

    $course_q="SELECT * FROM teacher WHERE id=$course_id";
    $course_r=mysqli_query($connection,$course_q);
    $course=mysqli_fetch_array($course_r);
    $cost=$course['cost'];
} else {
    header('Location: /');
}

if($get_fxcoin_count>=$cost+ceil(0.1*$cost)) {
    $suff=1;
  
} else {
    $suff=0;
  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">   

    <title>fxUnivers</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <link rel="stylesheet" href="/css/colors.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
</head>
<body>

    <div class="upperbar"></div>
<script src="/js/upperbar.js"></script>

<div class="col-33 left-col">
  <div class="col-1">
    <div class="main fxstar-color"></div>
    <div class="icon col-icon fxstar-bg" onclick="location.href='/wallet';"></div>
    <h3>Balance</h3>
    <p><strong><?php echo $get_fxcoin_count?></strong> fxStars</p>
  </div>
  
</div>

<div class="col-33 mid-col">  
    <?php
                if($item=='course') {
                    echo '<div class="col-1 pointer" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$course_id.'\';">';
                    echo '<h3>Item to buy</h3>';
                    echo '<p><strong>'.$course['header'].'</strong></p>';
                    echo '<p>'.$course['description'].'</p>';
                    echo '</div>';
                }
    ?>

    
    <?php
                echo '<div class="col-1 pointer fxstar-color" id="purchbutt">';
                echo '<h3>Purchase</h3>';
                echo '<p><strong>'.$cost.'</strong> fxStars</p>';
                if($suff==0) {
                    echo '<p style="color:red">Insufficient fxStars.</p>';
                } else {
                    echo '<p>Click to pay and purchase</p>';
                }
                echo '</div>';
    ?>
</div>

<div class="col-33 right-col">
                    <div class="col-1 pointer" onclick="location.href='/wallet/buy';">
    <h3>Buy fxStar</h3>
    <p>Click to increase your fxStars</p>
  </div>
                    </div>



<div class="footer"></div>
<script src="/js/footer.js"></script>

<div class="footbar"></div>
<script src="/js/footbar.js"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>

<script src="/js/notif_msg.js"></script>



<script>
                $(document).ready(function() {
                    var courseId=<?php echo $course_id?>;
                    var stuId=<?php echo $get_user_id?>;
                    $('#purchbutt').click(function(e) {
                        
                        jQuery.ajax({
                          type:'POST',
                          url:'/wallet/php/purchase.php',
                          data: {item:'course', course_id:courseId, stu_id:stuId},
                          success: function(response) {
                                if(response=='success') {
                                    alert('Course purchased successfully.');
                                    window.location.replace('/userpgs/instructor/course_management/course.php?course_id='+courseId);
                                }
                          }
                        });
                        
                    });
                });
</script>

</body>
</html>