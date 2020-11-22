<?php
require('connect.php');

$match = 0;
$activated = 0;

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
  $hash = $_GET['hash'];
  $email = $_GET['email'];

  $email_query = "SELECT * FROM user WHERE email='$email'";
  $email_result = mysqli_query($connection, $email_query) or die(mysqli_error($connection));
  $email_fetch = mysqli_fetch_array($email_result);
  $db_hash = $email_fetch['hash'];
  $newUserId=$email_fetch['id'];
  if(strcmp($hash, $db_hash)==0) {
    $match = 1;
    $msg = "The hashes match!";
  } else {
    $msg = "failed";
  }
}

if(isset($_GET['partner'])) {
    $partnerUN=$_GET['partner'];
    $partner_q="SELECT id FROM user WHERE username='$partnerUN'";
    $partner_r=mysqli_query($connection,$partner_q) or die(mysqli_error($connection));
    $partner_fetch=mysqli_fetch_array($partner_r);
    $partner_id=$partner_fetch['id'];
}

if($match) {
  $active_query = "UPDATE `user` SET active=1 WHERE email='$email'";
  $active_result = mysqli_query($connection, $active_query) or die(mysqli_error($connection));

  if($active_result) {
    $activated = 1;

    require('../php/conn/sonet.php');
    $vis_get_q="SELECT * FROM visibility WHERE userid=$newUserId";
    $vis_get_r=mysqli_query($sonet_connection,$vis_get_q) or die(mysqli_error($sonet_connection));
    $vis_count=mysqli_num_rows($vis_get_r);
    if($vis_count==0) {
        $vis_set_q="INSERT INTO visibility(userid) VALUES($newUserId)";
        $vis_set_r=mysqli_query($sonet_connection,$vis_set_q) or die(mysqli_error($sonet_connection));
    }
  } else {
    $msg = "failed";
  }

  if(isset($_GET['partner'])) {
      require('../php/conn/fxpartner.php');
      $get_partner_q="SELECT * FROM on_user WHERE (partner=$partner_id AND user=$newUserId)";
      $get_partner_r=mysqli_query($fxpartner_connection,$get_partner_q) or die(mysqli_error($fxpartner_connection));
      $get_partner_count=mysqli_num_rows($get_partner_r);
      if($get_partner_count==0) {
          $set_partner_q="INSERT INTO on_user(partner,user,dt) VALUES($partner_id,$newUserId,CURRENT_DATE())";
          $set_partner_r=mysqli_query($fxpartner_connection,$set_partner_q) or die(mysqli_error($fxpartner_connection));
      }
  }
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>fxUnivers</title>
  <link rel="stylesheet" type="text/css" href="/css/styles.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="/js/jquery-3.4.1.min.js"></script>
</head>
<body>
  <div class="solo-container">

    <div class="solo">

      <?php
        if($match) {
      ?>
          <h3>Email verified</h3>
	  <p>Your email is verified. Now choose yourself a username.</p>

	  <form action="/php/signup2.php" autocomplete="off" method="POST">
	    <input type="text" name="firstname" id="inputfn" placeholder="First name (required)" class="txt-input" required>
	    <input type="text" name="lastname" id="inputln" placeholder="Last name (required)" class="txt-input" required>


	    <input type="text" name="username" placeholder="Username (required)" id="username" class="txt-input" required>
	    <p id="fewCh" class="tooltip red">More than 3 characters</p>
    	    <p class="tooltip red" id="dupUN">That username is taken</p>


	    <input type="phone" name="phonenumber" placeholder="Phone number (optional)" class="txt-input">
	    
	    <input type="hidden" name="email" value="<?php echo $email ?>">
	    <input type="hidden" name="hash" value="<?php echo $hash ?>">
	    
	    <input type="submit" value="continue" id="submitButt" class="submit-btn" disabled>
	  </form>
	  
	    <?php
	      } else {
                echo '<p>error :/</p>';
    	      }
	    ?>
    </div>
    
  </div>

<!-- SCRIPTS -->
<script>
$('#username').each(function() {
    var elem=$(this);
    elem.data('oldVal', elem.val());
    elem.bind("propertychange change click keyup input paste", function(event) {
        if(elem.data('oldVal')!=elem.val()) {
            elem.data('oldVal', elem.val());

            if(elem.val().length > 2) {
                $('#fewCh').hide();
                

                jQuery.ajax({
                    type:'POST',
                    url:'/php/dup_username.php',
                    data:$('#username').serialize(),
                    success: function(data) {
                        if(data=='dup') {
                            $('#dupUN').show();
			    $('#submitButt').fadeTo('fast',0.5);
			    $('#submitButt').prop('disabled',true);
                        } else {
                            $('#dupUN').hide();
                            $('#submitButt').removeAttr('disabled');
			    $('#submitButt').fadeTo('fast',1);
                        }
                    }
                });
            } else {
                $('#fewCh').show();
                $('#dupUN').hide();
		$('#submitButt').fadeTo('fast',0.5);
		$('#submitButt').prop('disabled',true);
            }
        }
    });
});        
</script>

</body>
</html>