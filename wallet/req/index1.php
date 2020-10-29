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
    
    <h3>Request fxStars</h3>
    <p>Balance: <?php echo $get_fxcoin_count?> fxStars</p>
</div>
</div>

<div class="col-33 mid-col">
  <!-- STEP 1 -->
  <div class="col-1">
    <p><b>Select friend</b></p>
                <?php while($row=$get_rel_friends_result2->fetch_assoc()) {
				   if($row['user1']==$get_user_id) {
				     $fnd_user_id=$row['user2'];
				   } else {
				     $fnd_user_id=$row['user1'];
				   }
				   $fnd_user_query = "SELECT * FROM user WHERE id=$fnd_user_id";
				   $fnd_user_result = mysqli_query($connection, $fnd_user_query) or die(mysqli_error($connection));
				   $fnd_user_fetch = mysqli_fetch_array($fnd_user_result);
				 ?>
				   <span class="toggleReqFinal" style="cursor:pointer;border:1px solid #000;padding-left:5px;padding-right:5px;margin-top:10px;border-radius:3px;"><?php echo '@'.$fnd_user_fetch['username']; ?></span><span> &#8226; </span>
				 <?php } ?>
<form id="reqToFndForm">
                <br><input type="text" name="reqFrom" id="reqToId" readonly required/>
  </div>
   

      
<!-- STEP 2 -->
<div class="col-1">
    <p><b>Requested amount</b></p>
    <p>(in fxStars)</p>
                    <input type="number" name="reqAmnt" id="reqToAmnt" min="1" max="1000000" value="1" required/>
          <p>Total cost for your friend (fxStars): <span id="totalReqCost">2</span></p>
</div>

<!-- STEP 3 -->
<div class="col-1">
    <p><b>Submit request</b></p>
                    <input type="submit" class="pointer" id="reqBtn" value="Request">
				 </form>
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
$('.toggleReqFinal').click(function() {
    //document.getElementById('req-fxcoins-final').style.display="block";
  document.getElementById('reqToId').value=$(this).text();
});
</script>

<script>
$(function() {
  $('#reqToFndForm').on('submit', function(e) {
   var reqUname = document.getElementById('reqToId').value;
   var reqAmnt = document.getElementById('reqToAmnt').value;
   if(confirm('confirm requesting '+reqAmnt+' fxStars from '+reqUname+'.')) {
    e.preventDefault();
    jQuery.ajax({
      type: 'POST',
      url: '/wallet/php/reqfxCoinFnd.php',
      data: $('#reqToFndForm').serialize(),
      success: function() {
            alert(reqAmnt+' is requested from '+reqUname+'.');
            location.reload();
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
                
</body>
</html>