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
<html lang="en">
  <head>
  <title>fxUnivers</title>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
  </head>




<body>
   

    <div class="center">
                
                <?php if($match) { ?>
                                   <h3>Email verified</h3>
  <p>Now tell us your name to get started.</p>
  <form action="/php/signup2.php" autocomplete="off" method="POST">
    <input type="text" name="firstname" id="inputfn" placeholder="First name (required)" required>
	<input type="text" name="lastname" id="inputln" placeholder="Last name (required)" required>

                                        
    <span id="fewCh" class="tooltip" style="margin-left:10%;">More than 3 characters</span>
    <span class="tooltip" id="dupUN" style="margin-left:10%;">That username is taken</span>
	<input type="text" name="username" placeholder="Username (required)" id="username" required>
    
    
    <input type="phone" name="phonenumber" placeholder="Phone number (optional)">
	<input type="hidden" name="email" value="<?php echo $email ?>">
	<input type="hidden" name="hash" value="<?php echo $hash ?>">
    <input type="checkbox" name="policyCB" value="one" style="display:inline" required>
                <label for="policyCB">I agree to the <a href="/policy" target="_blank">terms & conditions</a>.</label><br>
	<input type="submit" value="continue" id="submitButt" style="opacity:0.5" disabled>
  </form>
<?php } else {
        echo '<p>error :/</p>';
    }
?>
</div>


<div class="footer" style="bottom:0;position:fixed;"></div>
<script src="/js/footer.js"></script>

<script type="text/javascript">
/*    $(function() {
      $('#suForm').on('submit', function(e) {
        e.preventDefault();
        if($('#dupUN').is(':visible')) {
        } else {
            jQuery.ajax({
              type: 'post',
              url: '/php/signup2.php',
              data: $('#suForm').serialize(),
              success: function(data) {
                    window.location.replace("/userpgs");
              },
              error: function(jqxhr) {
                    if(jqxhr.responseText==='uname_dup') {
                        $('#dup_err').show();
                    }
              }
            });
        }
      });
      });*/
</script>

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

<script type="text/javascript">/*
function setUsername() {
  var enteredUN = document.getElementById('username').value;
  var UNlen = enteredUN.length;
  jQuery.ajax({
    type:'POST',
    url:'/php/dup_username.php',
    data:$('#username').serialize(),
    success: function(data) {
      if(data=='dup' && UNlen!=0) {
        $('#dupUN').show();
	$('#nonDupUN').hide();
	$('#fewCh').hide();
	$('#username').val('');
	$('#username').focus();
      } else {
        $('#dupUN').hide();
	if(UNlen>0 && UNlen<3) {
	  $('#fewCh').show();
	  $('#nonDupUN').hide();
	  $('#username').focus();
	} else {
	  if(UNlen==0) {
	    $('#nonDupUN').hide();
	  } else {
	    $('#nonDupUN').show();
	  }
	  //$('#nonDupUN').hide();
	  $('#fewCh').hide();
	}
      }
    }
  });
  }*/
</script>


</body>
</html>