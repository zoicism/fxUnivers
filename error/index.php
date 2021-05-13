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
	<link rel="stylesheet" href="/css/styles.css">
	<script src="/js/jquery-3.4.1.min.js"></script>
	<style>html {background-color:#fff}</style>
    </head>

    <body>

	<div style="display:flex;align-items:center;justify-content:center;flex-flow:column nowrap;height:100%;width:100%;">
	    <div class="fxunivers-logo" ><img src="/images/logos/fxunivers-logo.svg"><p class="red">:/</p></div>
	    
	    <?php
	    if(isset($_GET['no'])) {
		echo '<p>error number '.$no.' :(</p>';
	    } else {
		echo '<p>The page you are trying to reach may have been removed.</p><p>Use buttons below to get where you want or <a href="/about">click here to learn more</a>.</p>';
	    }
	    ?>

	    <div style="display:flex; flex-flow:row nowrap;">
	    <a href="/"><button class="submit-btn" >Home</button></a>
	    <a href="/wallet"><button class="submit-btn" >fxStar</button></a>
	    <a href="/userpgs/fxuniversity"><button class="submit-btn" >fxUniversity</button></a>
	    <a href="/userpgs/partner"><button class="submit-btn" >fxPartner</button></a>
	</div>



        <div class="footer" style="bottom:0;position:fixed;"></div>
	<script src="/js/footer.js"></script> 
    </body>
</html>
