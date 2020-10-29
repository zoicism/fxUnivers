<?php
if(isset($_GET['err'])) $err=$_GET['err'];
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
                <h3>Password recovery</h3>
                <p style="margin-bottom:10px">Enter your email address below. We will email you a password recovery link.</p>

		  <form action="/register/forgot_password/forgotpass.php" method="POST" class="form-box" autocomplete="off">
		      <input type="text" style="margin-left:10px" name="email" id="emailbox" class="form-control" placeholder="Email Address" autofocus required>
<?php if(isset($_GET['err']) && strcmp($err,'no_res')==0) { ?>
    <p style="color:red;font-size:0.9rem;">No account found with this email address!</p>
<?php } elseif(isset($_GET['err']) && strcmp($err,'exp')==0) { ?>
    <p style="color:red;font-size:0.9rem;">Your recovery link is expired. Try again!</p>
<?php } ?>
		    <p style="color: #000; font-size: 0.80rem;"></p>
		      <input type="submit" style="margin-left:10px" id="submitbtn" class="btn btn-primary btn-pill" value="Submit" disabled>
		  </form>
</div>




<div class="footer" style="bottom:0;position:fixed;"></div>
<script src="/js/footer.js"></script>




         

<script>
  $("#emailbox").each(function() {
    var elem=$(this);
    //current value
    elem.data('oldVal', elem.val());

    // look for changes
    elem.bind("propertychange change click keyup input paste", function(event) {
    if(elem.data('oldVal')!=elem.val()) {
      elem.data('oldVal', elem.val());

  if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(elem.val())) {
    $("#submitbtn").prop('disabled', false);
  } else {
    $("#submitbtn").prop('disabled', true);
  }
    }
  });
});
</script>



</body>
</html>
