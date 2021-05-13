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
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
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
    <script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>
    <script>
     if(screen.width >= 629) {
	 $(document).ready(function() {
	     $('.header-sidebar').prepend('<div style="width:100%; display:flex; flex-flow:row nowrap; justify-content:left;"><a href="/wallet/buy" class="link-main"><div class="head">Buy fxStars</div></a><a href="/wallet/send" class="link-main"><div class="head">Transfer</div></a><a href="/wallet/req" class="link-main" id="active-main"><div class="head">Request</div></a><a href="/wallet/txn" class="link-main"><div class="head">Transactions</div></a><a href="/wallet/cashout" class="link-main"><div class="head">Cash-out</div></a></div>');
	 });
     }
    </script>
    <div class="blur mobile-main">


<div class="sidebar"></div>
<?php require('../../php/sidebar.php'); ?>


<div class="relative-main-content">

  <div class="content-box">

                          <h2>Request fxStars</h3>

                          <form id="reqToFndForm">
                          <p>Select a friend:</p>
<?php
                          if($get_rel_friends_count>0) {
                              echo '<select name="reqFrom" id="reqToId" class="select-input" style="margin-left:0">';
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
                              echo '<p style="color:gray">You need to have at least one friend.</p>';
                          }
?>

<p>Amount:</p>
<input type="number" name="reqAmnt" class="num-input" id="reqToAmnt" min="1" max="1000000" value="1" required/>
<p>Total cost: <strong><span id="totalReqCost">2</span> fxStars</strong></p>
                          <input type="submit" class="submit-btn"  value="Request">
                          </form>

  </div>
</div>
</div>

 
                          <div class="footbar blur"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>





                          <!-- SCRIPTS -->
<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>



<script>
$('.toggleReqFinal').click(function() {
    //document.getElementById('req-fxcoins-final').style.display="block";
  document.getElementById('reqToId').value=$(this).text();
});
</script>

<script>
$(function() {
  $('#reqToFndForm').on('submit', function(e) {
   e.preventDefault();
   var reqUname = document.getElementById('reqToId').value;
   var reqAmnt = document.getElementById('reqToAmnt').value;
   if(confirm('Confirm requesting '+reqAmnt+' fxStars from '+reqUname+'.')) {
    
    jQuery.ajax({
      type: 'POST',
      url: '/wallet/php/reqfxCoinFnd.php',
      data: $(this).serialize(),
      success: function(response) {
        if(response=='success') {
            alert(reqAmnt+' fxStars is requested from '+reqUname+'.');
            location.reload();
	} else {
	  alert('Failed to complete the request. Please select a friend and try again.');
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
                   $('#reqToAmnt').each(function() {
                       var elem2=$(this);
                       elem2.data('oldVal', elem2.val());
                       elem2.bind("propertychange change click keyup input paste", function(event) {
                           if(elem2.data('oldVal')!=elem2.val()) {
                               elem2.data('oldVal', elem2.val());
                               $('#totalReqCost').html(Math.ceil(elem2.val()*0.1)+parseInt(elem2.val()));
                           }
                       });
                   });
</script>

<script>
if(screen.width>480) {
    var h11=$('#oneone').height();
    var h12=$('#onetwo').height();
    var h13=$('#onethree').height();
    var row1=0;
    if(h11>row1) row1=h11;
    if(h12>row1) row1=h12;
    if(h13>row1) row1=h13;
    $('#oneone').height(row1);
    $('#onetwo').height(row1);
    $('#onethree').height(row1);
}
</script>

<script>
                   $('#reqToId').each(function() {
                       var elem=$(this);
                       elem.data('oldVal', elem.val());
                       elem.bind("propertychange change click keyup input paste", function(event) {
                           if(elem.data('oldVal')!=elem.val()) {
                               elem.data('oldVal', elem.val());
                               if(elem.val().length > 0) {
                                   $('#reqBtn').prop('disabled', false);
                                   $('#reqBtn').hide();
                               } else {
                                   $('#reqBtn').prop('disabled', true);
                                   $('#reqBtn').show();
                               }
                           }
                       });
                   });
      
</script>


<script>
                          $('#page-header').html('fxStar');
$('#page-header').attr('href','/wallet');
</script>



<!-- fxStar sidebar active -->
<script>
$('.fxstar-sidebar').attr('id','sidebar-active');
</script>

</body>
</html>
