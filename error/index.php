<?php
if(isset($_GET['no'])) $no=$_GET['no'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>error</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
    <style>html {background-color:#fff}</style>
</head>

<body>

    <div class="upperbar" style="text-align:center">
    fxUnivers
</div>             
    <div class="center">
<?php
    if(isset($_GET['no'])) {
        echo '<p>error number '.$no.' :(</p>';
    } else {
        echo '<p>error :/</p>';
    }
?>

     <p><a href="/">home</a></p>
     </div>



                 <div class="footer" style="bottom:0;position:fixed;"></div>
<script src="/js/footer.js"></script> 
</body>
</html>
