<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/

session_start();
require('../../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
	header("Location: /register/logout.php");
    exit();
}

require('../../../php/get_user.php');
$id = $get_user_id;

require('../../php/notif.php');

require('../../../php/get_plans.php');

require('../../../php/get_rel.php');

require('../../../php/get_partner.php');

require('../../../wallet/php/get_fxcoin_count.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>fxPartner</title>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
</head>

<body>
	<div class="header-sidebar"></div>
    <script src="/js/upperbar.js"></script>
    <div class="blur mobile-main">



<div class="sidebar"></div>
	<?php require('../../../php/sidebar.php'); ?>



  <div class="main-content">

              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/userpgs/partner/positions" class="link-main">
                          <div class="head">fxHR</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/userpgs/partner/income" class="link-main" id="active-main">
                          <div class="head">Earnings History</div>
                      </a>
                  </li>
              </ul>

    </div>





  <div class="relative-main-content">
  <div class="content-box" >
                          <h2>Earnings</h2>
                          

                       
              <div class="row">
                          
                          <div class="col">





<?php
                require('../../../php/get_partner.php');
                if($get_partner_count>0) {
                    while($row=$get_partner_result->fetch_assoc()) {
                        $pun_query="SELECT * FROM user WHERE id=".$row['user'];
                        $pun_result=mysqli_query($connection,$pun_query) or die(mysqli_error($connection));
                        $pun_fetch=mysqli_fetch_array($pun_result);
                        $pun_username=$pun_fetch['username'];


                        // expire date
                        $add_date=date($row['dt']);
                        $exp_date_s=strtotime('+90 day',strtotime($add_date));
                        $exp_date=date('Y-m-j',$exp_date_s);


                        $date1 = new DateTime("today");
                        $date2 = new DateTime($exp_date);
                        $interval = $date1->diff($date2);

                        
                        echo '<div style="border-bottom:1px solid gray">';
                        echo '<p>Amount: <strong>'.$row['income'].' fxStars</strong>';
                        echo '<p>From: <strong>@'.$pun_username.'</strong>';
                        echo '<p>Date & Time: <strong>'.$add_date.'</strong>';
                        echo '<p>Remaining: <strong>'.$interval->days.'</strong>';
                        echo '</div>';
                  }
                } else {
                    echo '<p class="gray">No records yet</p>';
                }
?>


                          </div>




                          
                         
              </div>



  </div>
  </div>
</div>

<div class="footbar blur"></div>
<script src="/js/footbar.js"></script>


                          <!-- SCRIPTS -->
<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>
<script src="/js/notif_msg.js"></script>

<script>
$('#page-header').html('fxPartner');
$('#page-header').attr('href','/userpgs/partner');
</script>


<!-- fxPartner sidebar active -->
<script>
$('.fxpartner-sidebar').attr('id','sidebar-active');
</script>
</body>
</html>