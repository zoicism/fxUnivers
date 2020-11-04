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
?>

<!DOCTYPE html>
<html>
<head>
	<title>fxStar</title>
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

    <div class="sidebar">
		<div class="logo-sidebar logo-25"></div>
		<div>
            <?php
                    $path="../../userpgs/avatars/";
                    if(file_exists($path.$get_user_id.'.jpg')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../../userpgs/avatars/'.$get_user_id.'.jpg\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.jpeg')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../../userpgs/avatars/'.$get_user_id.'.jpeg\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.png')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../../userpgs/avatars/'.$get_user_id.'.png\');"></a>');
                    } elseif(file_exists($path.$get_user_id.'.gif')) {
                        echo('<a class="link avatar-sidebar" style="background-image: url(\'../../userpgs/avatars/'.$get_user_id.'.gif\');"></a>');
                    } else {
                        echo('<a class="link avatar-sidebar"></a>');
                    }
                ?>
			<a class="id-sidebar" href="#">@Neo</a>
		</div>
		<div class="elements">
		    <a href="/wallet" class="sidebar-icon fxstar-sidebar" id="sidebar-active">fxStar</a>
		    <a href="#" class="sidebar-icon fxuniversity-sidebar">fxUniversity</a>
		    <a href="#" class="sidebar-icon fxpartner-sidebar">fxPartner</a>
		    <a href="#" class="sidebar-icon fxuniverse-sidebar">fxUniverse</a>
		    <a href="#" class="sidebar-icon fxsonet-sidebar">fxSonet</a>
		    
	    </div>
	    <div class="socialmedia">
			<a href="#" class="sm facebook"></a>
			<a href="#" class="sm instagram"></a>
			<a href="#" class="sm twitter"></a>
			<a href="#" class="policy">Policy</a>

                          <div class="copyright">
                          With all due Reserves, © fxUnivers 
                          </div>
                          <div class="copyright">
                          2017-2020 All rights reserved.
                          </div>
  		</div>

                          
	</div>

<div class="main-content">

              <ul class="main-flex-container">
                  <li class="main-items">
                      <a href="/wallet/buy" class="link-main">
                          <div class="head">Buy fxStars</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/wallet/cashout" class="link-main">
                          <div class="head">Cash-out fxStars</div>
                      </a> 
                  </li>
                  <li class="main-items">
                      <a href="/wallet/txn" class="link-main">
                          <div class="head">Transactions</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/wallet/send" class="link-main" id="active-main">
                          <div class="head">Send fxStars</div>
                      </a>
                  </li>
                  <li class="main-items">
                      <a href="/wallet/req" class="link-main">
                          <div class="head">Request fxStars</div>
                      </a>
                  </li>
              </ul>

    </div>
                          



                          <div class="relative-main-content">

  <div class="content-box">

<h2>Send fxStars</h3>


<form id="sendToFndForm">
                          <p>Select a friend:</p>
<?php
                          if($get_rel_friends_count>0) {
                              echo '<select name="sendTo" id="sendToId" class="select-input">';
                              echo '<option value="" disabled selected>Select</option>';
                              
                              while($row=$get_rel_friends_result2->fetch_assoc()) {
                                  if($row['user1']==$get_user_id) {
                                      $fnd_user_id=$row['user2'];
                                  } else {
                                      $fnd_user_id=$row['user1'];
                                  }
                                  $fnd_user_query = "SELECT * FROM user WHERE id=$fnd_user_id";
                                  $fnd_user_result = mysqli_query($connection, $fnd_user_query) or die(mysqli_error($connection));
                                  $fnd_user_fetch = mysqli_fetch_array($fnd_user_result);
                                  
                                  echo '<option value="'.$fnd_user_fetch['username'].'">@'.$fnd_user_fetch['username'].'</option>';
                              }
                              echo '</select>';
                          } else {
                              echo '<p style="color:gray">You need to have at least oen friend.</p>';
                          }
				 ?>
<!--
				   <span class="toggleSendFinal pointer" style="cursor:pointer;border:1px solid #000;padding-left:5px;padding-right:5px;margin-top:10px;border-radius:3px;"><?php echo '@'.$fnd_user_fetch['username']?></span><span> &#8226; </span>
                          -->
				

                          <!--
                          <p>Send to:</p>
                          <input type="text" name="sendTo" id="sendToId" readonly/>-->

                          <p>Amount:</p>
                          <input type="number" class="num-into num-input" name="sendAmnt" id="sendToAmnt" min="1" max="1000000" value="1" required/>
                          <p>Total cost: <strong><span id="totalSendCost">2</span> fxStars</strong></p>



                          <input type="submit" class="submit-btn" class="pointer" value="Send">
</form>




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
$('.toggleSendFinal').click(function() {
  document.getElementById('sendToId').value = $(this).text();
});
</script>

<script>
$(function() {
  $('#sendToFndForm').on('submit', function(e) {
      e.preventDefault();
   var recepientUname = document.getElementById('sendToId').value;
   var recepientAmnt = document.getElementById('sendToAmnt').value;
   if(confirm('confirm sending '+recepientAmnt+' fxStars to '+recepientUname+'.')) {

    
    jQuery.ajax({
      type: 'POST',
      url: '/wallet/php/fxCoinFnd.php',
      data: $('#sendToFndForm').serialize(),
      success: function(result) {
            if(result=='success') {
                alert(recepientAmnt+' fxStars is sent to '+recepientUname+'.');
                location.reload();
            } else if(result=='failed') {
                alert('insufficient fxStars!');
            }
        }
    });
   } else {
       return false;
   }
  });
});
</script>

<script>
$('#sendToAmnt').each(function() {
    var elem3=$(this);
    elem3.data('oldVal', elem3.val());
    elem3.bind('propertychange change click keyup input paste', function(event) {
        if(elem3.data('oldVal')!=elem3.val()) {
            elem3.data('oldVal', elem3.val());
            $('#totalSendCost').html(Math.ceil(elem3.val()*0.1)+parseInt(elem3.val()));
        }
    });
});
</script>                





<script>
                          $('#page-header').html('fxStar');
$('#page-header').attr('href','/wallet');
</script>
</body>
</html>