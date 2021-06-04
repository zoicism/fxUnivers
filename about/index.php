<?php
// Requiring https
if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>About fxUnivers</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display\
		=swap" rel="stylesheet">
    <script src="/js/jquery-3.4.1.min.js"></script>
  </head>
  <body>
    <div class="solo-container">
      <div class="solo about">
	      <div class="about-top">
		<div class="fxunivers-logo">
		  <img src="/images/logo/fxunivers-logo.svg" onclick="window.location.replace('/')">
		  <p class="fxunivers-word">fxUnivers</p>
		  <p class="slogan">Universe of Possibilities</p>
		</div>

		<div class="about-box-cnt">
			<div class="fxstar-box about-box">
    				<div class="about-box-txt">fxStar</div>
    				<div class="about-box-des">
    <p>Buy products &amp; services</p>
<p>Send / Request fxStars</p>
				</div>
				<a href="#fxstar">Learn more</a>
				<button class="enter-fxstar enter-box">Enter fxStar</button>
			</div>
			<div class="fxuniversity-box about-box">
    				<div class="about-box-txt">fxUniversity</div>
    				<div class="about-box-des">
    					<p>Create a course &amp; Earn fxStars</p>
				</div>
				<a href="#fxuniversity">Learn more</a>
				<button class="enter-fxuniversity enter-box">Enter fxUniversity</button>
			</div>

		
			<div class="fxpartner-box about-box">
    				<div class="about-box-txt">fxPartner</div>
    				<div class="about-box-des about/index.php">
				    <p>Invite instructors and students</p>
				    <p>Get half the interest of invitees</p>
                                    <p>Each for 90 days straight</p>
				</div>
				<a href="#fxpartner">Learn more</a>
				<button class="enter-fxpartner enter-box">Enter fxPartner</button>
			</div>
<div class="fxuniverse-box about-box">
    				<div class="about-box-txt">fxUniverse</div>
    				<div class="about-box-des about/index.php">
				    <p>Universe of Forex Trading</p>
				</div>
				<button class="enter-fxuniverse enter-box">Coming soon</button>
			</div>
								 
		    <!--<p><b>fxUniversity.</b> Create a course & Earn fxStars. <a href="#fxuniversity">Learn more</a></p>
		    <p><b>fxPartner.</b> Partner us & make easy fxStars. <a href="#fxpartner">Learn more</a></p>
		    <p><b>fxStar.</b> Buy and gift products and services: send, receive, or donate them. <a href="#fxstar">Learn more</a></p>
		   <p><b>fxUniverse.</b> Universe of trading (Coming soon for public).</p>-->
		</div>
	      </div>


	     <div class="fxuniversity-about" id="fxuniversity">
		     <div class="university-background">
			<svg viewBox="0 0 273.7 116.5"><defs><style>.cls-1{fill:#efefef;}</style></defs><title>fxuniversity1</title><path class="cls-1" d="M85.6,90.4v.7h6.9v-.7Z"/><path class="cls-1" d="M170.3,95.2v.7h26.2v4.4h.7V95.2Zm0,0v.7h26.2v4.4h.7V95.2Zm0,0v.7h26.2v4.4h.7V95.2Zm0,0v.7h26.2v4.4h.7V95.2Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7ZM77,95.2V101H197.2V95.2Zm.7,5.1V95.9H196.5v4.4Zm92.6-5.1v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h7.6v-.7Zm0,0v.7h26.2v4.4h.7V95.2Zm0,0v.7h26.2v4.4h.7V95.2Zm0,0v.7h26.2v4.4h.7V95.2Z"/><path class="cls-1" d="M72.4,100.3v6.4H201.8v-6.4Zm.7,5.7v-5h128v5Z"/><path class="cls-1" d="M68.4,106v5H205.9v-5Zm136.8,4.3H69.1v-3.6H205.2Z"/><path class="cls-1" d="M82.4,90.4v5.5H95.8V90.4Zm.6,4.8V91.1H95.1v4.1Z"/><path class="cls-1" d="M103.3,90.4v5.5h13.4V90.4Zm.7,4.8V91.1h12.1v4.1Z"/><path class="cls-1" d="M156.9,90.4v5.5h13.4V90.4Zm.7,4.8V91.1h12.1v4.1Z"/><path class="cls-1" d="M177.9,90.4v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v5.5h13.4V90.4Zm.7,4.8V91.1h12v4.1Zm-.7-4.8v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Zm0,0v4.8h.7V91.1h2.5v-.7Z"/><path class="cls-1" d="M93.8,44.8a1.6,1.6,0,0,0-1.5,1.6v.2a1.4,1.4,0,0,0,.2.7,1.7,1.7,0,0,0,1.3.7,1.6,1.6,0,1,0,0-3.2Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,93.8,47.3Z"/><path class="cls-1" d="M84.3,44.8a1.6,1.6,0,1,0,0,3.2,1.7,1.7,0,0,0,1.3-.7,1.4,1.4,0,0,0,.2-.7c.1,0,.1-.1.1-.2A1.6,1.6,0,0,0,84.3,44.8Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,84.3,47.3Z"/><rect class="cls-1" x="90.1" y="52.9" width="0.7" height="30.15"/><path class="cls-1" d="M106.5,90.4v.7h7v-.7Z"/><path class="cls-1" d="M105.3,44.8a1.6,1.6,0,1,0,0,3.2,1.5,1.5,0,0,0,1.2-.7.9.9,0,0,0,.3-.7v-.2A1.6,1.6,0,0,0,105.3,44.8Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,105.3,47.3Z"/><rect class="cls-1" x="111.1" y="52.9" width="0.7" height="30.15"/><path class="cls-1" d="M114.8,44.8a1.6,1.6,0,0,0-1.6,1.6c0,.1,0,.2.1.2a1.4,1.4,0,0,0,.2.7,1.7,1.7,0,0,0,1.3.7,1.6,1.6,0,1,0,0-3.2Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,114.8,47.3Z"/><path class="cls-1" d="M122.1,64.7V95.9h15V64.7Zm14.3,30.5H122.8V65.3h13.6Z"/><rect class="cls-1" x="133.3" y="77.5" width="0.7" height="3.82"/><path class="cls-1" d="M136.8,8.9,91.2,33.2h91.3ZM93.9,32.6,136.8,9.7l43,22.9Z"/><path class="cls-1" d="M122.1,50.1V62.2h15V50.1Zm14.3,11.4H122.8V50.8h13.6Z"/><path class="cls-1" d="M181.1,90.4v.7h7v-.7Z"/><path class="cls-1" d="M179.8,44.8a1.6,1.6,0,1,0,1.3,2.5c.2-.2.2-.4.3-.7v-.2A1.6,1.6,0,0,0,179.8,44.8Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,179.8,47.3Z"/><path class="cls-1" d="M189.4,44.8a1.6,1.6,0,0,0-1.6,1.6v.2l.3.7a1.7,1.7,0,0,0,1.3.7,1.6,1.6,0,0,0,0-3.2Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,189.4,47.3Z"/><rect class="cls-1" x="185.7" y="52.9" width="0.7" height="30.16"/><path class="cls-1" d="M160.1,90.4v.7h7v-.7Z"/><path class="cls-1" d="M158.8,44.8a1.6,1.6,0,0,0,0,3.2,1.4,1.4,0,0,0,1.3-.7.9.9,0,0,0,.3-.7v-.2A1.6,1.6,0,0,0,158.8,44.8Zm0,2.5a.9.9,0,0,1,0-1.8.9.9,0,1,1,0,1.8Z"/><rect class="cls-1" x="164.7" y="52.9" width="0.7" height="30.15"/><path class="cls-1" d="M267.1,21.1H166.2L136.9,5.5h-.2L107.4,21.1H6.6L0,28.1H4.3V111H67.8v-.7H5V30.8H89.2l-8,4.3H74.6l4.3,3.3v6h3.2a2.8,2.8,0,0,0-.8,2,2.9,2.9,0,0,0,3,3,3.1,3.1,0,0,0,1.3-.3V90.4h.6V48.7a2.6,2.6,0,0,0,.9-1.4H91a3,3,0,0,0,.9,1.3V90.4h.6V49.1a3.1,3.1,0,0,0,1.3.3,2.9,2.9,0,0,0,3-3,2.8,2.8,0,0,0-.8-2h7.1a2.8,2.8,0,0,0-.8,2,2.9,2.9,0,0,0,3,3,2.7,2.7,0,0,0,1.2-.3V90.4h.7V48.7a3.4,3.4,0,0,0,.9-1.4H112a2.2,2.2,0,0,0,.8,1.3V90.4h.7V49.1a2.8,2.8,0,0,0,1.3.3,2.9,2.9,0,0,0,3-3,2.8,2.8,0,0,0-.8-2h39.7a2.8,2.8,0,0,0-.8,2,2.9,2.9,0,0,0,2.9,3,2.8,2.8,0,0,0,1.3-.3V90.4h.7V48.6a3,3,0,0,0,.9-1.3h3.9a2.2,2.2,0,0,0,.9,1.4V90.4h.6V49.1a2.8,2.8,0,0,0,1.3.3,3,3,0,0,0,3-3,2.8,2.8,0,0,0-.8-2h7a3.2,3.2,0,0,0-.7,2,2.9,2.9,0,0,0,2.9,3,2.8,2.8,0,0,0,1.3-.3V90.4h.7V48.7a4.2,4.2,0,0,0,.9-1.4h3.8a3.4,3.4,0,0,0,.9,1.4V90.4h.7V49.1a2.8,2.8,0,0,0,1.3.3,3,3,0,0,0,3-3,2.9,2.9,0,0,0-.9-2h3.3v-6l4.3-3.3h-6.7l-8-4.3h84.3v79.5H205.9v.7h63.5V28.1h4.3ZM1.6,27.5l5.3-5.7h99.3L95.5,27.5ZM5,30.2V28.1H94.3l-3.8,2.1ZM96.1,46.4a2.3,2.3,0,0,1-2.3,2.3,2.2,2.2,0,0,1-1.3-.4c-.2-.2-.5-.4-.6-.7l-.2-.3a6.4,6.4,0,0,1-.2-.7H86.6a1.4,1.4,0,0,1-.2.7.8.8,0,0,1-.2.4,1.7,1.7,0,0,1-.6.6,2,2,0,0,1-1.3.4,2.3,2.3,0,0,1-1.1-4.3H94.9A2.3,2.3,0,0,1,96.1,46.4Zm21,0a2.3,2.3,0,0,1-2.3,2.3,2,2,0,0,1-1.3-.4,2.3,2.3,0,0,1-.7-.7c0-.1-.1-.2-.1-.3a1.4,1.4,0,0,1-.2-.7h-4.9a6.4,6.4,0,0,1-.2.7c-.1.1-.1.3-.2.4s-.4.5-.7.6a1.7,1.7,0,0,1-1.2.4,2.3,2.3,0,0,1-1.1-4.3h11.7A2.3,2.3,0,0,1,117.1,46.4Zm53.6,0a2.3,2.3,0,0,1-2.3,2.3,2,2,0,0,1-1.3-.4,1.7,1.7,0,0,1-.6-.6.8.8,0,0,1-.2-.4,1.4,1.4,0,0,1-.2-.7h-5a1.5,1.5,0,0,1-.1.7l-.2.3a2.3,2.3,0,0,1-.7.7,1.8,1.8,0,0,1-1.3.4,2.2,2.2,0,0,1-2.2-2.3,2.1,2.1,0,0,1,1.2-2h11.7A2.3,2.3,0,0,1,170.7,46.4Zm21,0a2.3,2.3,0,0,1-2.3,2.3,2,2,0,0,1-1.3-.4c-.3-.1-.5-.4-.7-.6s-.1-.3-.1-.4a1.4,1.4,0,0,1-.2-.7h-5a1.4,1.4,0,0,1-.2.7.4.4,0,0,1-.1.3,2.3,2.3,0,0,1-.7.7,2,2,0,0,1-1.3.4,2.3,2.3,0,0,1-2.3-2.3,2.3,2.3,0,0,1,1.2-2h11.8A2.3,2.3,0,0,1,191.7,46.4Zm2.4-2.7H79.5v-5H194.1Zm3-7.9L194.2,38H79.4l-2.8-2.2Zm-6.1-.7H82.7l7.9-4.3.9-.4,4.2-2.3.4-.2,11.5-6.1.6-.3L136.8,6.2l28.6,15.3.6.3,11.6,6.1.3.2,4.3,2.3.8.4Zm77.7-4.9H183.2l-3.8-2.1h89.3Zm-90.6-2.7-10.6-5.7h99.3l5.3,5.7Z"/><path class="cls-1" d="M168.4,44.8a1.6,1.6,0,0,0-1.6,1.6v.2l.3.7a1.7,1.7,0,0,0,1.3.7,1.6,1.6,0,0,0,0-3.2Zm0,2.5a.9.9,0,1,1,.9-.9A.9.9,0,0,1,168.4,47.3Z"/><path class="cls-1" d="M136.4,64.7V95.9h15.2V64.7Zm14.5,30.5H137.1V65.3h13.8Z"/><rect class="cls-1" x="139.7" y="77.5" width="0.7" height="3.82"/><path class="cls-1" d="M136.4,50.1V62.2h15.2V50.1Zm14.5,11.4H137.1V50.8h13.8Z"/><path class="cls-1" d="M137,12.7a5.8,5.8,0,0,0-5.9,5.9,5.9,5.9,0,0,0,5.9,6,6,6,0,0,0,6-6A5.9,5.9,0,0,0,137,12.7Zm0,11.2a5.3,5.3,0,1,1,5.3-5.3A5.2,5.2,0,0,1,137,23.9Z"/><path class="cls-1" d="M138.9,21.2l-.3-.2-1.9-2.3V14.8a.3.3,0,0,1,.3-.3c.2,0,.4.1.4.3v3.7l1.7,2.1a.4.4,0,0,1,0,.5Z"/><path class="cls-1" d="M116.7,25.8v3.9a1.7,1.7,0,0,1-.5,1.2,1.7,1.7,0,0,1-2.2,0,1.7,1.7,0,0,1-.5-1.2V25.8H113v4a2,2,0,0,0,.6,1.4,2.5,2.5,0,0,0,1.5.5l1.1-.2.7-.7a3.8,3.8,0,0,0,.3-1v-4Z"/><path class="cls-1" d="M122.8,25.8v5l-3.3-5H119v5.8h.5v-5l3.3,5h.5V25.8Z"/><path class="cls-1" d="M125.3,25.8v5.8h.5V25.8Z"/><path class="cls-1" d="M131.5,25.8l-1.8,5.1h-.1l-1.8-5.1h-.5l2.1,5.8h.5l2.2-5.8Z"/><path class="cls-1" d="M133.9,31.2V28.8h2.7v-.4h-2.7V26.2H137v-.4h-3.6v5.8H137v-.4Z"/><path class="cls-1" d="M141.2,29.1a1.6,1.6,0,0,0,.8-.6,1.3,1.3,0,0,0,.4-1,1.5,1.5,0,0,0-.6-1.3,2,2,0,0,0-1.4-.4h-1.9v5.8h.5V29.2h1.7l1.4,2.4h.5Zm-.7-.3H139V26.2h1.4a2,2,0,0,1,1.1.3,1.8,1.8,0,0,1,.4,1,1.3,1.3,0,0,1-.4.9A1.8,1.8,0,0,1,140.5,28.8Z"/><path class="cls-1" d="M147.7,29.4a1,1,0,0,0-.6-.5,3.5,3.5,0,0,0-1.2-.5,2.3,2.3,0,0,1-1.1-.5,1,1,0,0,1-.4-.7,1.2,1.2,0,0,1,.4-.8,2,2,0,0,1,1.1-.3,1.4,1.4,0,0,1,1.1.4,1,1,0,0,1,.4.9h.5a2.9,2.9,0,0,0-.2-.9l-.7-.6-1.1-.2a2.1,2.1,0,0,0-1.4.4,1.3,1.3,0,0,0-.5,1.1,1.2,1.2,0,0,0,.5,1.1l1.4.6a2.3,2.3,0,0,1,1.2.5,1,1,0,0,1,.4.8,1,1,0,0,1-.5.8,2.1,2.1,0,0,1-2.3-.1,1.1,1.1,0,0,1-.4-1h-.5a3,3,0,0,0,.2,1l.8.6,1.1.2a2.4,2.4,0,0,0,1.5-.4,1.4,1.4,0,0,0,.6-1.1A1.1,1.1,0,0,0,147.7,29.4Z"/><path class="cls-1" d="M149.6,25.8v5.8h.5V25.8Z"/><path class="cls-1" d="M151.4,25.8v.4h2v5.4h.5V26.2h2v-.4Z"/><path class="cls-1" d="M160.9,25.8,159.1,29l-1.8-3.2h-.6l2.1,3.6v2.2h.5V29.4l2.1-3.6Z"/><path class="cls-1" d="M200.3,37.7V48.3H216V37.7Zm7.8,9.9H201V38.3h7.1Zm7.2,0h-6.6V41.8h6.6Zm0-6.5h-6.6V38.3h6.6Z"/><path class="cls-1" d="M224.4,37.7V48.3h15.7V37.7Zm7.8,9.9h-7.1V38.3h7.1Zm7.3,0h-6.6V41.8h6.6Zm0-6.5h-6.6V38.3h6.6Z"/><path class="cls-1" d="M248.1,37.7V48.3h15.7V37.7Zm7.7,9.9h-7.1V38.3h7.1Zm7.3,0h-6.6V41.8h6.6Zm0-6.5h-6.6V38.3h6.6Z"/><path class="cls-1" d="M200.3,56.8V67.5H216V56.8Zm7.8,10H201V57.5h7.1Zm7.2,0h-6.6V60.9h6.6Zm0-6.5h-6.6V57.5h6.6Z"/><path class="cls-1" d="M224.4,56.8V67.5h15.7V56.8Zm7.8,10h-7.1V57.5h7.1Zm7.3,0h-6.6V60.9h6.6Zm0-6.5h-6.6V57.5h6.6Z"/><path class="cls-1" d="M248.1,56.8V67.5h15.7V56.8Zm7.7,10h-7.1V57.5h7.1Zm7.3,0h-6.6V60.9h6.6Zm0-6.5h-6.6V57.5h6.6Z"/><path class="cls-1" d="M200.3,76V86.7H216V76Zm7.8,10H201V76.7h7.1Zm7.2,0h-6.6V80.1h6.6Zm0-6.6h-6.6V76.7h6.6Z"/><path class="cls-1" d="M224.4,76V86.7h15.7V76Zm7.8,10h-7.1V76.7h7.1Zm7.3,0h-6.6V80.1h6.6Zm0-6.6h-6.6V76.7h6.6Z"/><path class="cls-1" d="M248.1,76V86.7h15.7V76Zm7.7,10h-7.1V76.7h7.1Zm7.3,0h-6.6V80.1h6.6Zm0-6.6h-6.6V76.7h6.6Z"/><path class="cls-1" d="M57.6,37.7V48.3H73.4V37.7Zm8,.6h7.1v9.3H65.6Zm-7.3,3.5h6.6v5.8H58.3Zm0-3.5h6.6v2.8H58.3Z"/><path class="cls-1" d="M33.5,37.7V48.3H49.3V37.7Zm8,.6h7.1v9.3H41.5Zm-7.3,3.5h6.6v5.8H34.2Zm0-3.5h6.6v2.8H34.2Z"/><path class="cls-1" d="M9.9,37.7V48.3H25.6V37.7Zm7.9.6h7.1v9.3H17.8Zm-7.3,3.5h6.6v5.8H10.5Zm0-3.5h6.6v2.8H10.5Z"/><path class="cls-1" d="M57.6,56.8V67.5H73.4V56.8Zm8,.7h7.1v9.3H65.6Zm-7.3,3.4h6.6v5.9H58.3Zm0-3.4h6.6v2.8H58.3Z"/><path class="cls-1" d="M33.5,56.8V67.5H49.3V56.8Zm8,.7h7.1v9.3H41.5Zm-7.3,3.4h6.6v5.9H34.2Zm0-3.4h6.6v2.8H34.2Z"/><path class="cls-1" d="M9.9,56.8V67.5H25.6V56.8Zm7.9.7h7.1v9.3H17.8Zm-7.3,3.4h6.6v5.9H10.5Zm0-3.4h6.6v2.8H10.5Z"/><path class="cls-1" d="M57.6,76V86.7H73.4V76Zm8,.7h7.1V86H65.6Zm-7.3,3.4h6.6V86H58.3Zm0-3.4h6.6v2.7H58.3Z"/><path class="cls-1" d="M33.5,76V86.7H49.3V76Zm8,.7h7.1V86H41.5Zm-7.3,3.4h6.6V86H34.2Zm0-3.4h6.6v2.7H34.2Z"/><path class="cls-1" d="M9.9,76V86.7H25.6V76Zm7.9.7h7.1V86H17.8Zm-7.3,3.4h6.6V86H10.5Zm0-3.4h6.6v2.7H10.5Z"/></svg>
			<svg viewBox="0 0 273.7 116.5"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M28.9,1l3.2.3V5.8H30.9c-4.3,0-5,2.8-5,4.5v3.1h5.5v4.1H25.9V39.7H19.1V17.5H15V13.4h4.1V10.2c0-3,.8-5.2,2.5-6.8S25.8,1,28.9,1m0-1c-3.4,0-6.1.9-8,2.7s-2.8,4.2-2.8,7.5v2.2H14v6.1h4.1V40.7h8.8V18.5h5.5V12.4H26.9V10.3c0-2.3,1.3-3.5,4-3.5l2.2.2V.5A21.8,21.8,0,0,0,28.9,0Z"></path><path class="cls-1" d="M58.6,13.4,51.9,25.7l-.2.5.2.5,7.1,13H52l-4.1-7.8L47,30.2l-.9,1.7L42,39.7H35l7.1-13,.2-.5-.2-.5L35.4,13.4h7l3.7,7.3.9,1.7.9-1.7,3.8-7.3h6.9m1.7-1H51.1L47,20.2l-4-7.8H33.8l7.4,13.8L33.3,40.7h9.3L47,32.4l4.4,8.3h9.2L52.8,26.2l7.5-13.8Z"></path><path class="cls-1" d="M79.3,21.9v4.8H65.6V21.9H79.3m1-1H64.6v6.8H80.3V20.9Z"></path><path class="cls-1" d="M45.4,67.9v24a13.4,13.4,0,0,1-1.7,6.8A10.9,10.9,0,0,1,39,103a17.8,17.8,0,0,1-7.6,1.5c-4.3,0-7.8-1.1-10.3-3.3A11.8,11.8,0,0,1,17.4,92V67.9h7.2V92.3c.2,5.9,3.8,7.2,6.8,7.2a6.9,6.9,0,0,0,5.1-1.9c1.2-1.3,1.7-3.2,1.7-5.8V67.9h7.2m1-1H37.2V91.8c0,2.4-.5,4.1-1.4,5.1a5.7,5.7,0,0,1-4.4,1.6c-3.7,0-5.7-2.1-5.8-6.3V66.9H16.4V92a12.6,12.6,0,0,0,4.1,9.9c2.6,2.4,6.3,3.6,10.9,3.6a17.8,17.8,0,0,0,8-1.6,11.3,11.3,0,0,0,5.2-4.7,14.4,14.4,0,0,0,1.8-7.3v-25Z"></path><path class="cls-1" d="M68.2,77.2c2.6,0,4.6.7,5.8,2.3s2,4,2.1,7.3V104H69.2V87.2a5.7,5.7,0,0,0-1.1-3.9c-.8-.9-2-1.3-3.9-1.3a5.4,5.4,0,0,0-4.7,2.5V104H52.6V77.7h6.3l.2,2.4.2,2.6,1.6-2.1a8.7,8.7,0,0,1,7.3-3.4m0-1A9.9,9.9,0,0,0,60.1,80l-.3-3.3H51.6V105h8.8V85a4.2,4.2,0,0,1,3.8-2,4.1,4.1,0,0,1,3.2,1,5.4,5.4,0,0,1,.8,3.2V105h8.9V86.8c-.1-3.6-.8-6.2-2.3-8a8.4,8.4,0,0,0-6.6-2.6Z"></path><path class="cls-1" d="M86.8,66.1a3.7,3.7,0,0,1,2.8,1,3,3,0,0,1,1.1,2.3,3.2,3.2,0,0,1-1.1,2.4,4.1,4.1,0,0,1-2.8.9,4.4,4.4,0,0,1-2.9-.9,3.1,3.1,0,0,1-1-2.4,2.9,2.9,0,0,1,1-2.3,3.9,3.9,0,0,1,2.9-1m3.4,11.6V104H83.4V77.7h6.8M86.8,65.1a5.2,5.2,0,0,0-3.6,1.2,4,4,0,0,0-1.3,3.1,3.9,3.9,0,0,0,1.3,3.1,5.2,5.2,0,0,0,3.6,1.2,5.1,5.1,0,0,0,3.5-1.2,4,4,0,0,0,1.4-3.1,4.1,4.1,0,0,0-1.4-3.1,5.1,5.1,0,0,0-3.5-1.2Zm4.4,11.6H82.4V105h8.8V76.7Z"></path><path class="cls-1" d="M120.3,77.7,111.8,104h-7.6L95.6,77.7h7.2L107,94.8l.9,3.9,1-3.9,4.3-17.1h7.1m1.4-1h-9.3L108,94.5l-4.4-17.8H94.2l9.3,28.3h9l9.2-28.3Z"></path><path class="cls-1" d="M136.8,77.2c3.7,0,6.5,1.1,8.6,3.4s3.2,5.5,3.2,9.6v2.4H130.9l.2,1.2a7.6,7.6,0,0,0,2.4,4.3,7.1,7.1,0,0,0,4.8,1.6,9.2,9.2,0,0,0,6.5-2.4l2.8,3.3a10.9,10.9,0,0,1-3.8,2.7,15.4,15.4,0,0,1-6.1,1.2,13.7,13.7,0,0,1-9.9-3.6,12.4,12.4,0,0,1-3.7-9.4v-.7a16.6,16.6,0,0,1,1.5-7.2,11.5,11.5,0,0,1,4.3-4.7,13.6,13.6,0,0,1,6.9-1.7m-5.9,11.9H142V87.5a5.2,5.2,0,0,0-1.4-4,5,5,0,0,0-3.9-1.5c-2.2,0-4.9,1-5.6,6l-.2,1.1m5.9-12.9a14.5,14.5,0,0,0-7.4,1.8,12.2,12.2,0,0,0-4.7,5.1,18.9,18.9,0,0,0-1.6,7.7v.7a13.6,13.6,0,0,0,4.1,10.2,14.7,14.7,0,0,0,10.5,3.8,15.7,15.7,0,0,0,6.5-1.3,11.6,11.6,0,0,0,4.7-3.6l-4.1-4.8a7.6,7.6,0,0,1-6.5,2.9,5.9,5.9,0,0,1-4.1-1.3,6.2,6.2,0,0,1-2.1-3.8h17.5V90.2c0-4.4-1.1-7.8-3.4-10.3s-5.5-3.7-9.4-3.7Zm-4.7,11.9c.5-3.4,2-5.1,4.6-5.1a4.1,4.1,0,0,1,3.2,1.2,4,4,0,0,1,1.1,3.2v.7Z"></path><path class="cls-1" d="M168,77.2h1.4v6.3h-1.9c-3.2,0-5.3,1.1-6.3,3.2V104h-6.9V77.7h6.4l.2,2.7.3,3.4,1.6-3c1.3-2.4,3-3.6,5.3-3.6m0-1c-2.7,0-4.7,1.4-6.2,4.2l-.3-3.7h-8.3V105h8.9V87.1c.7-1.7,2.5-2.6,5.3-2.6l2.9.2V76.5a8.8,8.8,0,0,0-2.4-.3Z"></path><path class="cls-1" d="M184.4,77.2a14,14,0,0,1,8.4,2.3,7,7,0,0,1,3,4.9h-6.9c-.3-2.2-1.9-3.4-4.5-3.4a4.3,4.3,0,0,0-2.9,1,3.3,3.3,0,0,0-1.4,2.7,3,3,0,0,0,1.7,2.7,11.4,11.4,0,0,0,4,1.4,33.4,33.4,0,0,1,4.3,1.1q5.7,1.9,5.7,6.9a6.4,6.4,0,0,1-3,5.5c-2.1,1.5-4.9,2.2-8.4,2.2a14.3,14.3,0,0,1-6-1.2,10.3,10.3,0,0,1-4.1-3.2,8,8,0,0,1-1.3-3.2h6.3a3.8,3.8,0,0,0,1.6,2.7,6.6,6.6,0,0,0,3.8,1.1,5.4,5.4,0,0,0,3.3-.9,3.7,3.7,0,0,0,1.3-2.7,3,3,0,0,0-1.7-2.7,18.4,18.4,0,0,0-4.7-1.5,22.3,22.3,0,0,1-5.2-1.8,8.3,8.3,0,0,1-2.9-2.6,5.7,5.7,0,0,1-1-3.4,6.7,6.7,0,0,1,2.8-5.6,12.7,12.7,0,0,1,7.8-2.3m0-1a13.3,13.3,0,0,0-8.4,2.5,7.9,7.9,0,0,0-3.2,6.4,7.1,7.1,0,0,0,1.1,3.9,9.4,9.4,0,0,0,3.3,2.9,17,17,0,0,0,5.4,1.9,16.3,16.3,0,0,1,4.5,1.5,1.9,1.9,0,0,1,1.2,1.8,2.3,2.3,0,0,1-.9,1.9,4.1,4.1,0,0,1-2.7.7,5.3,5.3,0,0,1-3.2-.9,3.2,3.2,0,0,1-1.3-2.9h-8.3a7.9,7.9,0,0,0,1.6,4.8,10.6,10.6,0,0,0,4.5,3.5,14.7,14.7,0,0,0,6.4,1.3c3.7,0,6.7-.8,8.9-2.4a7.4,7.4,0,0,0,3.5-6.3c0-3.8-2.1-6.4-6.4-7.9a35.2,35.2,0,0,0-4.4-1.1,10.6,10.6,0,0,1-3.7-1.2,2.2,2.2,0,0,1-1.2-1.9,2.4,2.4,0,0,1,1-1.9,3.6,3.6,0,0,1,2.3-.8c2.4,0,3.6,1.1,3.6,3.4h8.8a7.9,7.9,0,0,0-3.4-6.7c-2.2-1.7-5.2-2.5-9-2.5Z"></path><path class="cls-1" d="M205.7,66.1a3.9,3.9,0,0,1,2.9,1,2.9,2.9,0,0,1,1,2.3,3.1,3.1,0,0,1-1,2.4,4.4,4.4,0,0,1-2.9.9,4.1,4.1,0,0,1-2.8-.9,3.2,3.2,0,0,1-1.1-2.4,3,3,0,0,1,1.1-2.3,3.7,3.7,0,0,1,2.8-1m3.5,11.6V104h-6.8V77.7h6.8m-3.5-12.6a5.1,5.1,0,0,0-3.5,1.2,4.1,4.1,0,0,0-1.4,3.1,4,4,0,0,0,1.4,3.1,5.1,5.1,0,0,0,3.5,1.2,5.2,5.2,0,0,0,3.6-1.2,3.9,3.9,0,0,0,1.3-3.1,4,4,0,0,0-1.3-3.1,5.2,5.2,0,0,0-3.6-1.2Zm4.5,11.6h-8.8V105h8.8V76.7Z"></path><path class="cls-1" d="M224.9,70.7v7h4.7v4.1h-4.7v14a4.6,4.6,0,0,0,.8,2.9,4.3,4.3,0,0,0,3.1.9H230V104a13.7,13.7,0,0,1-4,.5q-4.2,0-6-1.8c-1.3-1.2-1.9-3.2-1.9-5.8V81.8h-3.6V77.7h3.6v-7h6.8m1-1h-8.8v7h-3.6v6.1h3.6V96.9c0,2.9.7,5.1,2.2,6.5s3.6,2.1,6.7,2.1a16.8,16.8,0,0,0,5-.7V98.5h-2.2a3.2,3.2,0,0,1-2.3-.6,3.2,3.2,0,0,1-.6-2.2v-13h4.7V76.7h-4.7v-7Z"></path><path class="cls-1" d="M258.1,77.7,247,109.4l-.5,1.1a7.7,7.7,0,0,1-7.7,5,13.6,13.6,0,0,1-2.7-.4v-4.5h.2a7.5,7.5,0,0,0,3.3-.6,4.1,4.1,0,0,0,1.9-2.5l.7-1.8V105l-9.3-27.3h7.2l4.3,15.2.9,3.4,1-3.3,4.5-15.3h7.3m1.4-1H250l-4.7,16-4.4-16h-9.4l9.8,28.6-.7,1.9a3,3,0,0,1-1.5,1.9,5.4,5.4,0,0,1-2.8.5h-1.2v6.3a12.4,12.4,0,0,0,3.7.6,9,9,0,0,0,8.7-5.5l.5-1.2,11.5-33.1Z"></path></svg>
		     </div>
		<div class="solo-sub">
		  <p>At fxUniversity you can teach your favorite subjects as an fxInstructor using many top-notch tools and unlimited volume of cloud storage free of charge, and earn fxStars. You can also learn from other fxInstructors, build up your knowledge, and start your own courses by becoming fxSubInstructors.</p>
	    <!--<p>Create a course, teach your subject, or just join a course using fxUniversity and earn fxStars. Our FX tool is a cloud-based educational hub and learning experience. Earn fxStars and trade -->

		  <h3>fxInstructors and fxSubInstructors</h3>
	    <p>Become an <b>fxInstructor</b> -- the primary course creator; create a course with recorded/live sessions, presentation, certificate, etc.</p>
									  <p>Become an <b>fxSubInstructor</b> -- choose from our available courses (fxCourse & fxSubCourse) and teach your audience.</p>


		  <h4>fxInstructor Steps</h4>
		  <ol>
		    <li>
			<div class="fxuniversity-circle">
			    <div class="about-num">1</div>
			</div>
		        <p><b>Course Creation.</b> You can create <em>Recorded</em>, <em>Live 1-on-1</em>, or <em>Live Classrooms</em> with up to 250 fxStudents simultaneously present in one live session.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <div class="about-num">2</div>
			</div>
			<p><b>Student Enrollment.</b> Students can enroll to a course by simply <em>purchasing</em> it, i.e. paying you the fixed number of fxStars prescribed by you, or, in case you allow it, by <em>bargaining</em> over a suitable number of fxStars for both you and the student.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <div class="about-num">3</div>
			</div>
			<p><b>Examination.</b> Test the students by your own set of questions.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <div class="about-num">4</div>
			</div>
			<p><b>Certification.</b> Give a certificate to the students who succeed in a course examination.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <div class="about-num">5</div>
			</div>
			<p><b>Course Subs.</b> Allow certified students to generate more revenue for your on auto-pilot.</p>
		    </li>
		  </ol>

		  <h4>fxSubInstructor Steps</h4>
		  <ol>
		    <li>
			<div class="fxuniversity-circle">
			    <div class="about-num">1</div>
			</div>
			<p><b>Certification.</b> Get certified on a top.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <div class="about-num">2</div>
			</div>
			<p><b>Course Sub.</b> Become an instructor of the topic you have a certificate from.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <div class="about-num">3</div>
			</div>
			<p><b>Student Enrollment.</b> Teach the topic to new fxStudents.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <div class="about-num">4</div>
			</div>
			<p><b>Examination.</b> Test your own students.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <div class="about-num">5</div>
			</div>
			<p><b>Certification and Course Subs.</b> Allow certified students to generate more revenue on auto-pilot.</p>
		    </li>
		  </ol>


		  <h4>Revenue Stream for fxInstructor and fxSubInstructors</h4>
		  <p>fxInstructor can allow an fxCourse's certified students to create fxCourses for their own students as fxSubCourses and hence become fxSubInstructors.</p>

		  <h4>fxInstructor Revenue</h4>
		  <p>The following conditions apply to an fxInstructor's revenue concerning an fxCrouse.</p>
		  <ul>
		    <li>
			<div class="fxuniversity-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>90% of fxCourse fxStars</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>10% of direct fxSubCourses</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>5% of all indirect fxSubCourses</p>
		    </li>
		  </ul>
		  <p>As an fxInstructor:</p>
		  <ul>
		    <li>
			<div class="fxuniversity-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Always get the credit as the founder and creator of the course content.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Utilize the most efficient method to spread and educate many students and audiences for your topics/courses.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Expose your course material to many audiences in the World Wide Web.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Set up private courses among your own students or audiences; fxUniversity will administrate the operation.</p>
		    </li>
		  </ul>

		  <h4>fxSubInstructor Revenue</h4>
		  <p>The following conditions apply to an fxSubInstructor's revenue concerning an fxSubCrouse.</p>
		  <ul>
		    <li>
			<div class="fxuniversity-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>80% of fxSubCourse fxStars</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>A share of 5% resulting from further fxSubCourses from this fxSubCourse</p>
		    </li>
		  </ul>
		  <p>As an fxSubInstructor:</p>
		  <ul>
		    <li>
			<div class="fxuniversity-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Utilize the fastest way to monetize and earn revenue from courses taken and certified.</p>
		    </li>
		    <li>
			<div class="fxuniversity-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Find topics of interest to teach and earn income online on the World Wide Web with outreach to many students a click away.</p>
		    </li>
		  </ul>
		</div>
	      </div>
	      
	      
	      
	      <div class="fxpartner-about" id="fxpartner">
		<div class="partner-background">
		    <svg viewBox="0 0 273.7 116"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M156.9,96.8,139.3,81.6l17.5,15.1Z"></path><path class="cls-1" d="M225,54.5l-17.5-50a4.5,4.5,0,0,0-5.8-2.8L183.9,7.9a4.7,4.7,0,0,0-2.9,5.9l.5,1.2-6.6,2.8a6.9,6.9,0,0,1-4,.5l-3.1-.7q-10.2-2-20.4-3.3l-8.1-1.1a10.8,10.8,0,0,0-6.6,1.3,10.9,10.9,0,0,0-1.7,1.3l-6.9,6H107.2l-9-5.4.3-.5a4.6,4.6,0,0,0-1.8-6.2L80.1.6A4.7,4.7,0,0,0,76.6.3a4.5,4.5,0,0,0-2.7,2.2L48.6,49a4.1,4.1,0,0,0-.4,3.4,4.4,4.4,0,0,0,2.2,2.8l16.6,9a4.3,4.3,0,0,0,2.2.6l1.3-.2a4.9,4.9,0,0,0,2.7-2.2l1.2-2.2,3.7,2.7a11.6,11.6,0,0,1,2.6,2.8l4.4,6.9-.7.9a7.2,7.2,0,0,0-1.6,4.4,7,7,0,0,0,2.6,5.4,6.8,6.8,0,0,0,4.4,1.6,6.9,6.9,0,0,0,2.5-.4,7.4,7.4,0,0,0-.8,3.9,7,7,0,0,0,2.6,4.8,6.9,6.9,0,0,0,4.4,1.5,8,8,0,0,0,3.3-.8,6.3,6.3,0,0,0-.3,2.7,7.1,7.1,0,0,0,2.5,4.7,6.9,6.9,0,0,0,7.8.7,7.6,7.6,0,0,0-.3,2.1,7.1,7.1,0,0,0,2.5,5.4,7.3,7.3,0,0,0,4.4,1.5,7,7,0,0,0,5.5-2.5l1-1.3,8.2,7a7.3,7.3,0,0,0,5,1.9,7.6,7.6,0,0,0,5.8-2.7,7.3,7.3,0,0,0,1.4-7.3l2,1.6a7.4,7.4,0,0,0,5.1,1.9h.6a7.6,7.6,0,0,0,5.3-2.7,7.8,7.8,0,0,0,1.5-7.6l.5.5a8.6,8.6,0,0,0,5.4,2,8.3,8.3,0,0,0,6.3-2.9,8.1,8.1,0,0,0,2-6,8.7,8.7,0,0,0-.5-2.2l.4.3a7.4,7.4,0,0,0,5.1,2h.6a7.5,7.5,0,0,0,5.4-2.7,7.8,7.8,0,0,0-.8-11.1l-3.8-3.4a46.2,46.2,0,0,0,12.3-10,10,10,0,0,1,4.3-2.9l1.1-.3.4,1.2a4.5,4.5,0,0,0,4.3,3.1,4,4,0,0,0,1.5-.3l17.9-6.2A4.6,4.6,0,0,0,225,54.5ZM73.5,59.6l-1.2,2.3a3.4,3.4,0,0,1-2.1,1.6,3.6,3.6,0,0,1-2.7-.2L50.9,54.2a3.6,3.6,0,0,1-1.7-2.1,3.9,3.9,0,0,1,.3-2.6L74.8,3a3.9,3.9,0,0,1,2.1-1.7h1a3.3,3.3,0,0,1,1.7.4l16.6,9a3.6,3.6,0,0,1,1.4,4.8l-.3.5ZM86.1,82.5a5.8,5.8,0,0,1-2.2-4.6,5.7,5.7,0,0,1,1.4-3.7l5.3-6.5a5.8,5.8,0,0,1,4.6-2.2,5.8,5.8,0,0,1,3.7,1.3,6,6,0,0,1,2.2,4.6,6.4,6.4,0,0,1-1.3,3.7l-5.5,6.6v.2A5.9,5.9,0,0,1,86.1,82.5Zm8.6,9.8a6.1,6.1,0,0,1-2.1-4A5.7,5.7,0,0,1,93.9,84L95,82.6h.1v-.2l5.4-6.6,4-4.9a5.7,5.7,0,0,1,4-2.1h.6a5.9,5.9,0,0,1,3.7,1.4,5.9,5.9,0,0,1,.8,8.3L112,80.5l-9,11A5.9,5.9,0,0,1,94.7,92.3Zm10,8.2a5.9,5.9,0,0,1-.8-8.3l8.9-10.9a5.8,5.8,0,0,1,4.5-2.2,6.2,6.2,0,0,1,3.8,1.4,5.9,5.9,0,0,1,.8,8.3L113,99.6A5.9,5.9,0,0,1,104.7,100.5Zm18.3,7.3a5.9,5.9,0,0,1-8.3.8,5.8,5.8,0,0,1-2.2-4.5,5.9,5.9,0,0,1,1.4-3.8l3.7-4.5a5.8,5.8,0,0,1,4.5-2.2,5.9,5.9,0,0,1,3.8,1.4,5.9,5.9,0,0,1,.8,8.3Zm60.5-27.9a6.7,6.7,0,0,1,.7,9.6,6.7,6.7,0,0,1-9.6.7l-3.4-2.9L152.7,71.2l-4-3.4-.7.8,4,3.5,18.4,16a6.7,6.7,0,0,1,2.5,4.9,7,7,0,0,1-1.7,5.2A7.3,7.3,0,0,1,161,99l-3.5-3.1L140,80.8l-1.9-1.7-.7.8,1.9,1.7,17.5,15.1h.1a6.8,6.8,0,0,1,.6,9.4,6.4,6.4,0,0,1-4.6,2.3,6.2,6.2,0,0,1-4.9-1.6l-4.9-4.2-.9-.8-12.7-11-.7.8,12.7,11.1,1,.8h0a6.6,6.6,0,0,1-8.7,9.8l-8.2-7.1,2-2.3a7.1,7.1,0,0,0-1.1-9.9,6.9,6.9,0,0,0-6.6-1.2l2.8-3.4a6.8,6.8,0,0,0,1.6-4.4,7,7,0,0,0-9.3-6.7,6.2,6.2,0,0,0,1.1-4.4,7,7,0,0,0-12.4-3.8l-1.6,2.1v-.9A6.9,6.9,0,0,0,99.6,66a7.1,7.1,0,0,0-9.9,1l-3.8,4.8-4.3-6.7A12.2,12.2,0,0,0,78.7,62l-3.8-2.8L97.7,17.4l9.3,5.5h15.9l-10.2,8.9a5.3,5.3,0,0,0-1.8,3.9v23h.2a7,7,0,0,0,5.5,2.1c2.8-.2,5.5-2.3,8-6a23.6,23.6,0,0,0,3.3-8.2l.4-2.2a10.1,10.1,0,0,1,4.9-7.1l.7-.4h.2l27,23.4,18.3,15.9Zm13.2-18.1a10.8,10.8,0,0,0-4.9,3.2,43.1,43.1,0,0,1-12.3,10l-.2-.3L161.8,59.6l-27-23.4a1.3,1.3,0,0,0-1.3-.2l-.8.4a11.5,11.5,0,0,0-5.5,7.9l-.4,2.2a20.3,20.3,0,0,1-3.1,7.8c-2.3,3.4-4.7,5.3-7.2,5.5a6,6,0,0,1-4.5-1.6V35.7a3.7,3.7,0,0,1,1.4-3l12.4-10.9,5.9-5.2a9.5,9.5,0,0,1,1.6-1.2,9,9,0,0,1,5.8-1.1l8.1,1c6.8.9,13.6,2,20.3,3.4l3.2.6a7.2,7.2,0,0,0,4.6-.5l6.5-2.8,15.9,45.5Zm25.1-2.5L204,65.5a3.4,3.4,0,0,1-4.5-2.1l-.4-1.2L182.5,14.6l-.4-1.2a3.5,3.5,0,0,1,2.1-4.5L202,2.7l1.2-.2a3.5,3.5,0,0,1,3.3,2.4L224,54.8A3.6,3.6,0,0,1,221.8,59.3Z"></path><polygon class="cls-1" points="179.3 74.7 161.8 59.6 161.8 59.6 179.3 74.7"></polygon><polygon class="cls-1" points="161.8 59.6 161.8 59.6 134.8 36.2 161.8 59.6"></polygon></svg>
		    <svg viewBox="0 0 272.6 116"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M52.8,1.1a15,15,0,0,1,3.5.4V6.4H55c-4.8,0-5.5,3-5.5,4.9v3.4h6.1v4.6H49.5V43.7H42V19.3H37.5V14.7H42V11.2c0-3.3.9-5.7,2.8-7.5s4.5-2.6,8-2.6m0-1.1C49,0,46.1,1,44,2.9s-3.1,4.7-3.1,8.3v2.5H36.4v6.7h4.5V44.8h9.7V20.4h6.1V13.7H50.6V11.3c0-2.6,1.5-3.8,4.4-3.8l2.4.2V.6A20,20,0,0,0,52.8,0Z"></path><path class="cls-1" d="M85.4,14.7,78.1,28.3l-.3.5.3.5,7.7,14.4H78.2l-4.6-8.6-1-1.9-.9,1.9-4.5,8.6H59.5l7.8-14.4.2-.5-.2-.5L60,14.7h7.6l4.1,8,1,1.9.9-1.9,4.3-8h7.5m1.9-1H77.2l-4.5,8.5-4.4-8.5H58.1l8.2,15.1-8.6,16H67.9l4.8-9.2,4.8,9.2H87.7l-8.6-16,8.2-15.1Z"></path><path class="cls-1" d="M108.2,24.1v5.3H93.1V24.1h15.1m1.1-1.1H92v7.4h17.3V23Z"></path><path class="cls-1" d="M55.9,74.7a18.4,18.4,0,0,1,8,1.6,12.6,12.6,0,0,1,5.3,4.6A13.1,13.1,0,0,1,71,87.8a11.1,11.1,0,0,1-3.9,8.9c-2.8,2.3-6.6,3.4-11.4,3.4H48.2v14.2H40.3V74.7H55.9M48.2,94.5h7.7a7.6,7.6,0,0,0,5.2-1.7,6.5,6.5,0,0,0,1.9-5,7.6,7.6,0,0,0-1.9-5.4A6.4,6.4,0,0,0,56,80.3H48.2V94.5m7.7-20.9H39.2v41.8H49.3V101.2h6.4c5.1,0,9.1-1.2,12.1-3.6a12.3,12.3,0,0,0,4.3-9.8,13,13,0,0,0-2-7.4,12.9,12.9,0,0,0-5.7-5.1,20.8,20.8,0,0,0-8.5-1.7ZM49.3,93.4v-12H56a5.6,5.6,0,0,1,4.3,1.7,6.7,6.7,0,0,1,1.6,4.7A5.7,5.7,0,0,1,60.4,92a6.9,6.9,0,0,1-4.5,1.4Z"></path><path class="cls-1" d="M89.7,84.8q5.5,0,8.7,2.7a9,9,0,0,1,3.2,7.1v13.8a16.3,16.3,0,0,0,.9,5.9H95a14.5,14.5,0,0,1-.6-1.9l-.5-2.2L92.5,112a8.1,8.1,0,0,1-6.6,2.9,10.1,10.1,0,0,1-6.8-2.4,7.4,7.4,0,0,1-2.7-5.8,7.6,7.6,0,0,1,3.3-6.8q3.5-2.4,10.2-2.4H94V94.8c0-4.7-3-5.4-4.8-5.4s-4.1,1.2-4.4,3.4H77.2a7.8,7.8,0,0,1,3.4-5.4,15.1,15.1,0,0,1,9.1-2.6m-1.5,25.4a6.1,6.1,0,0,0,3.6-1,5.3,5.3,0,0,0,2.1-2.1v-6.6H90.1c-4,0-6.1,2-6.1,5.6a4.1,4.1,0,0,0,1.2,3,4.4,4.4,0,0,0,3,1.1m1.5-26.5a16.1,16.1,0,0,0-9.8,2.9,8.7,8.7,0,0,0-3.8,7.3h9.7c0-2.3,1.1-3.4,3.4-3.4s3.7,1.4,3.7,4.3v1.6h-3c-4.7,0-8.3.9-10.8,2.6a8.8,8.8,0,0,0-3.8,7.7,8.5,8.5,0,0,0,3.1,6.6,11,11,0,0,0,7.5,2.7,9,9,0,0,0,7.5-3.4,7,7,0,0,0,.9,2.8H104v-.5c-.9-1.5-1.3-3.7-1.4-6.5V94.6a10,10,0,0,0-3.5-8c-2.3-1.9-5.4-2.9-9.4-2.9Zm-1.5,25.4a3.6,3.6,0,0,1-2.3-.8,2.9,2.9,0,0,1-.9-2.2q0-4.5,5.1-4.5h2.8v5a4.6,4.6,0,0,1-1.7,1.7,5.6,5.6,0,0,1-3,.8Z"></path><path class="cls-1" d="M124.3,84.8h1.6v7h-2.2c-3.5,0-5.8,1.1-6.8,3.5v19h-7.5V85.4h7l.2,3,.3,3.7,1.7-3.3c1.5-2.7,3.4-4,5.9-4m0-1.1c-2.9,0-5.2,1.6-6.8,4.6l-.3-4h-9.1v31.1h9.7V95.7c.8-1.9,2.8-2.8,5.8-2.8l3.2.2.2-9a11,11,0,0,0-2.7-.4Z"></path><path class="cls-1" d="M141.9,77.7v7.7h5.2V90h-5.2v15.3a4.4,4.4,0,0,0,1,3.2c.6.7,1.7,1,3.3,1h1.3v4.8a16.1,16.1,0,0,1-4.4.6c-3,0-5.2-.7-6.6-2s-2.1-3.5-2.1-6.4V90h-3.9V85.4h3.9V77.7h7.5m1.1-1.1h-9.7v7.7h-3.9V91h3.9v15.5c0,3.2.8,5.6,2.4,7.1s4.1,2.4,7.4,2.4a20.3,20.3,0,0,0,5.5-.8v-7a9,9,0,0,1-2.4.2c-1.3,0-2.1-.2-2.5-.7a3.1,3.1,0,0,1-.7-2.4V91h5.2V84.3H143V76.6Z"></path><path class="cls-1" d="M170.1,84.8a8.1,8.1,0,0,1,6.4,2.5c1.4,1.8,2.2,4.5,2.2,8.1v18.9h-7.5V95.8a6.4,6.4,0,0,0-1.2-4.2,5.5,5.5,0,0,0-4.3-1.5,5.9,5.9,0,0,0-5.2,2.8v21.4h-7.5V85.4h7l.2,2.7.2,2.8,1.7-2.3a9.7,9.7,0,0,1,8.1-3.8m0-1.1a10.3,10.3,0,0,0-8.9,4.3l-.3-3.7h-9.1v31.1h9.7V93.5a4.6,4.6,0,0,1,4.2-2.3c1.7,0,2.8.4,3.4,1.1a5,5,0,0,1,1,3.5v19.6h9.7v-20c0-3.9-.9-6.8-2.5-8.8s-4-2.9-7.2-2.9Z"></path><path class="cls-1" d="M199.2,84.8c4.1,0,7.2,1.2,9.5,3.8s3.5,6,3.5,10.6v2.6H192.7l.3,1.3a8.7,8.7,0,0,0,2.6,4.8,8.4,8.4,0,0,0,5.3,1.7A10,10,0,0,0,208,107l3.1,3.6a11.7,11.7,0,0,1-4.2,2.9,16.4,16.4,0,0,1-6.7,1.4c-4.4,0-8.1-1.3-10.8-4s-4.1-6-4.1-10.3v-.8a17.7,17.7,0,0,1,1.7-7.9,10.8,10.8,0,0,1,4.7-5.2,14.9,14.9,0,0,1,7.5-1.9m-6.4,13.1h12.1V96.1a5.9,5.9,0,0,0-1.4-4.4,6.2,6.2,0,0,0-4.4-1.6c-2.3,0-5.3,1.2-6.1,6.6l-.2,1.2m6.4-14.2a16.2,16.2,0,0,0-8.1,2,14.1,14.1,0,0,0-5.1,5.7,18.6,18.6,0,0,0-1.8,8.4v.8a14.8,14.8,0,0,0,4.4,11.1,16,16,0,0,0,11.6,4.3,17.2,17.2,0,0,0,7.2-1.5,12.2,12.2,0,0,0,5.1-4l-4.4-5.2a8.6,8.6,0,0,1-7.2,3.2,6.4,6.4,0,0,1-6.8-5.6h19.2V99.2c0-4.9-1.2-8.7-3.8-11.4s-5.9-4.1-10.3-4.1Zm-5.1,13.2c.5-3.8,2.2-5.7,5-5.7a4.7,4.7,0,0,1,3.6,1.3,4.6,4.6,0,0,1,1.1,3.6v.8Z"></path><path class="cls-1" d="M233.5,84.8h1.6v7h-2.1c-3.5,0-5.9,1.1-6.9,3.5v19h-7.5V85.4h7l.2,3,.3,3.7,1.8-3.3c1.4-2.7,3.3-4,5.8-4m0-1.1c-2.9,0-5.2,1.6-6.8,4.6l-.3-4h-9.1v31.1H227V95.7c.9-1.9,2.8-2.8,5.9-2.8l3.1.2.2-9a9.6,9.6,0,0,0-2.7-.4Z"></path></svg>
		</div>
		<div class="solo-sub">

		  <p>Generate revenue as our partner by:</p>
		  <ul>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Recruiting fxStudents</p>
		    </li>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Recruiting fxInstructors</p>
		    </li>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Recruiting fxSubInstructors</p>
		    </li>
		  </ul>
			
		  <p>As an fxPartner you will benefit from:</p>
		  <ul>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Revenue Sharing</p>
		    </li>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Solid Online Job</p>
		    </li>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Possibility of Secure Cash-out, Anytime</p>
		    </li>
		  </ul>
			
		  <p>Additional Skills to be Rewarded for as an fxPartner:</p>
		  <ul>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Marketing</p>
		    </li>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Advertising</p>
		    </li>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Human Resources</p>
		    </li>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Talent Acquisition</p>
		    </li>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Teaching</p>
		    </li>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Selling</p>
		    </li>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Public Relations</p>
		    </li>
		    <li>
			<div class="fxpartner-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>etc.</p>
		    </li>
		  </ul>
			
		  <p><b>We are open to any form of revenue-generating partnership.</b></p>

		  <h3>fxPartner Roadmap</h3>
		  <ol>
			  <li>
			      <div class="fxpartner-circle">
			          <div class="about-num">1</div>
			      </div>
			      <p><b>Invitation.</b> Use your fxPartner link to invite users and begin earning fxStars.</p>
			  </li>
			  <li>
			      <div class="fxpartner-circle">
			          <div class="about-num">2</div>
			      </div>
			      <p><b>Coordination.</b> Depending on your invitee, coordinate them to be fxInstructors or potential fxSubInstructors as students.</p>
			  </li>
			  <li>
			      <div class="fxpartner-circle">
			          <div class="about-num">3</div>
			      </div>
			      <p><b>Share of Revenue.</b> We will share 50% of our interest from this fxUser with you for 90 days.</p>
			  </li>
			  <li>
			      <div class="fxpartner-circle">
			          <div class="about-num">4</div>
			      </div>
			      <p><b>Network Expansion.</b> The more people you bring in, the more you will earn, and help your network of fxUsers expand.</p>
			  </li>
		  </ol>
		</div>
	      </div>
	      
	      <div class="fxstar-about" id="fxstar">
		<div class="star-background">
		    <svg viewBox="0 0 273.7 116"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M136.8,1.1a5.2,5.2,0,0,1,4.8,3L156.9,35l.2.5h.6l34.1,4.9a5.2,5.2,0,0,1,4.3,3.7,5,5,0,0,1-1.4,5.4L170.1,73.7l-.4.4v.5l5.8,34a5.3,5.3,0,0,1-1.1,4.4,5.6,5.6,0,0,1-6.7,1.3l-30.5-16-.5-.3-.5.3-30.4,16a6.2,6.2,0,0,1-2.6.6,5.3,5.3,0,0,1-4.1-1.9,5.7,5.7,0,0,1-1.2-4.4l5.9-34v-.5l-.4-.4L78.9,49.6a5.2,5.2,0,0,1-1.4-5.4,5.4,5.4,0,0,1,4.4-3.7L116,35.6h.6l.2-.5L132,4.1a5.4,5.4,0,0,1,4.8-3m0-1.1a6.2,6.2,0,0,0-5.7,3.6L115.8,34.5,81.7,39.4a6.4,6.4,0,0,0-3.5,11l24.6,24.1L97,108.4a6.4,6.4,0,0,0,6.3,7.6,6,6,0,0,0,3.1-.8l30.4-16,30.5,16a5.6,5.6,0,0,0,3,.8,6.5,6.5,0,0,0,6.4-7.6l-5.8-33.9,24.6-24.1a6.4,6.4,0,0,0-3.6-11l-34.1-4.9L142.6,3.6A6.4,6.4,0,0,0,136.8,0Z"></path><path class="cls-1" d="M139.2,37.3a17,17,0,0,1,10.9,4.1l-3,3a12.2,12.2,0,0,0-7.9-2.9,12.4,12.4,0,0,0-12.4,12.3v6.8H144v4.1H126.8v7.6h11.3v4.1H126.8V87.9h-4.1V76.4h-5.9V72.3h5.9V64.7h-5.9V60.6h5.9V53.8a16.5,16.5,0,0,1,16.5-16.5m0-1.1a17.6,17.6,0,0,0-17.6,17.6v5.7h-5.9v6.3h5.9v5.4h-5.9v6.3h5.9V89h6.3V77.5h11.3V71.2H127.9V65.8h17.2V59.5H127.9V53.8a11.2,11.2,0,0,1,11.3-11.2,10.8,10.8,0,0,1,7.9,3.3h.1l4.4-4.6a17.9,17.9,0,0,0-12.4-5.1Z"></path></svg>
		    <svg viewBox="0 0 273.7 116"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M98.4,1.1a15,15,0,0,1,3.5.4V6.4h-1.3c-4.8,0-5.5,3-5.5,4.9v3.4h6.1v4.6H95.1V43.7H87.6V19.3H83.1V14.7h4.5V11.2c0-3.3.9-5.7,2.8-7.5s4.6-2.6,8-2.6m0-1.1c-3.7,0-6.7,1-8.8,2.9s-3.1,4.7-3.1,8.3v2.5H82v6.7h4.5V44.8h9.7V20.4h6.1V13.7H96.2V11.3c0-2.6,1.5-3.8,4.4-3.8l2.4.2V.6A20,20,0,0,0,98.4,0Z"></path><path class="cls-1" d="M131,14.7l-7.3,13.6-.3.5.3.5,7.8,14.4h-7.7l-4.6-8.6-.9-1.9-1,1.9-4.5,8.6h-7.7l7.8-14.4.3-.5-.3-.5-7.3-13.6h7.7l4,8,1,1.9,1-1.9,4.2-8H131m1.9-1H122.8l-4.5,8.5-4.4-8.5H103.7l8.2,15.1-8.6,16h10.2l4.8-9.2,4.9,9.2h10.1l-8.6-16,8.2-15.1Z"></path><path class="cls-1" d="M153.8,24.1v5.3H138.7V24.1h15.1m1.1-1.1H137.6v7.4h17.3V23Z"></path><path class="cls-1" d="M100.8,74.1a18.6,18.6,0,0,1,7.7,1.5,11.8,11.8,0,0,1,5.1,4.2,10,10,0,0,1,1.7,5.1h-7.9a5.9,5.9,0,0,0-1.8-3.7,7.4,7.4,0,0,0-5-1.7,8.1,8.1,0,0,0-4.9,1.4,4.9,4.9,0,0,0-2,3.9,4.7,4.7,0,0,0,2.1,3.8,23,23,0,0,0,6.4,2.9,40.1,40.1,0,0,1,7,2.9c4.2,2.4,6.2,5.6,6.2,9.8a9.1,9.1,0,0,1-3.7,7.8c-2.6,1.9-6.2,2.9-10.7,2.9a22.6,22.6,0,0,1-8.8-1.7,12.7,12.7,0,0,1-5.7-4.6,12.5,12.5,0,0,1-1.9-5.7h8a6.4,6.4,0,0,0,2,4.7c1.4,1.3,3.5,1.9,6.4,1.9a7.4,7.4,0,0,0,4.6-1.3,4.8,4.8,0,0,0,1.9-3.9,5.2,5.2,0,0,0-2-4.3,21.1,21.1,0,0,0-5.8-2.7,54.9,54.9,0,0,1-6.3-2.5c-5.1-2.5-7.6-5.8-7.6-10.1a8.8,8.8,0,0,1,1.8-5.4,12.5,12.5,0,0,1,5.3-3.8,21.8,21.8,0,0,1,7.9-1.4m0-1.1a22.3,22.3,0,0,0-8.3,1.5,12.4,12.4,0,0,0-5.7,4.1,9.6,9.6,0,0,0-2.1,6.1c0,4.7,2.8,8.4,8.2,11a41.9,41.9,0,0,0,6.4,2.6,20.7,20.7,0,0,1,5.5,2.5,4.2,4.2,0,0,1,1.6,3.5,3.4,3.4,0,0,1-1.5,3,5.7,5.7,0,0,1-3.9,1.1c-2.6,0-4.5-.5-5.7-1.6a6.5,6.5,0,0,1-1.7-4.9H83.5a13,13,0,0,0,2.1,7.3,13.7,13.7,0,0,0,6.2,5A22.5,22.5,0,0,0,101,116c4.8,0,8.6-1,11.3-3.1a10.3,10.3,0,0,0,4.2-8.7c0-4.5-2.3-8.1-6.8-10.7a34.4,34.4,0,0,0-7.1-3,28.5,28.5,0,0,1-6.1-2.7,3.9,3.9,0,0,1-1.7-3,3.7,3.7,0,0,1,1.5-3,7.1,7.1,0,0,1,4.3-1.2,6.5,6.5,0,0,1,4.3,1.4,5.4,5.4,0,0,1,1.5,4h10.1a12.1,12.1,0,0,0-2-6.8,12.8,12.8,0,0,0-5.6-4.6,18.6,18.6,0,0,0-8.1-1.6Z"></path><path class="cls-1" d="M131.4,77.7v7.7h5.1V90h-5.1v15.3a4.9,4.9,0,0,0,.9,3.2,4.5,4.5,0,0,0,3.3,1H137v4.8a16.1,16.1,0,0,1-4.4.6c-3,0-5.3-.7-6.6-2s-2.1-3.5-2.1-6.4V90h-4V85.4h4V77.7h7.5m1.1-1.1h-9.7v7.7h-4V91h4v15.5c0,3.2.8,5.6,2.4,7.1s4.1,2.4,7.4,2.4a19.1,19.1,0,0,0,5.4-.8v-7a8.2,8.2,0,0,1-2.4.2,3.4,3.4,0,0,1-2.5-.7,3.7,3.7,0,0,1-.6-2.4V91h5.1V84.3h-5.1V76.6Z"></path><path class="cls-1" d="M154.4,84.8q5.5,0,8.7,2.7a8.9,8.9,0,0,1,3.1,7.1v13.8a18.5,18.5,0,0,0,1,5.9h-7.6c-.1-.5-.3-1.1-.5-1.9l-.5-2.2-1.4,1.8a8.2,8.2,0,0,1-6.6,2.9,10.1,10.1,0,0,1-6.8-2.4,7.4,7.4,0,0,1-2.7-5.8,7.6,7.6,0,0,1,3.3-6.8q3.4-2.4,10.2-2.4h4.1V94.8c0-4.7-3-5.4-4.8-5.4s-4.1,1.2-4.5,3.4h-7.5a8,8,0,0,1,3.3-5.4,15.6,15.6,0,0,1,9.2-2.6m-1.5,25.4a6.1,6.1,0,0,0,3.6-1,7,7,0,0,0,2.1-2.1v-6.6h-3.9c-4,0-6.2,2-6.2,5.6a3.8,3.8,0,0,0,1.3,3,4.4,4.4,0,0,0,3,1.1m1.5-26.5a15.8,15.8,0,0,0-9.8,2.9,8.4,8.4,0,0,0-3.8,7.3h9.6c0-2.3,1.2-3.4,3.5-3.4s3.7,1.4,3.7,4.3v1.6h-3c-4.7,0-8.4.9-10.9,2.6s-3.7,4.3-3.7,7.7a8.2,8.2,0,0,0,3.1,6.6,10.8,10.8,0,0,0,7.5,2.7,8.8,8.8,0,0,0,7.4-3.4,8.8,8.8,0,0,0,1,2.8h9.6v-.5a15.5,15.5,0,0,1-1.3-6.5V94.6a10,10,0,0,0-3.5-8c-2.3-1.9-5.5-2.9-9.4-2.9Zm-1.5,25.4a3.6,3.6,0,0,1-2.3-.8,2.9,2.9,0,0,1-.9-2.2q0-4.5,5.1-4.5h2.8v5a4.6,4.6,0,0,1-1.7,1.7,5.6,5.6,0,0,1-3,.8Z"></path><path class="cls-1" d="M189,84.8h1.6l-.2,7h-2.1c-3.5,0-5.8,1.1-6.9,3.5v19h-7.6V85.4h7l.3,3,.3,3.7,1.7-3.3c1.5-2.7,3.4-4,5.9-4m0-1.1c-2.9,0-5.2,1.6-6.8,4.6l-.4-4h-9v31.1h9.6V95.7c.9-1.9,2.9-2.8,5.9-2.8l3.2.2.2-9a11,11,0,0,0-2.7-.4Z"></path></svg>
		</div>
		      
		<div class="solo-sub">
		  <p>Purchase fxStars and benefit from the following products and services.</p>
		  <ul>
		    <li>
			<div class="fxstar-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>fxUnivers approved digital currency</p>
		    </li>
		    <li>
			<div class="fxstar-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Up to 5,000 USD per transaction</p>
		    </li>
		    <li>
			<div class="fxstar-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Unlimited fxStar transaction quantities</p>
		    </li>
		    <li>
			<div class="fxstar-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Purchase Courses</p>
		    </li>
		    <li>
			<div class="circle-text">
			    <div class="fxstar-circle">
			        <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			    </div>
			    <div class="details-con">
			        <p>Cash-out (100 fxStars minimum):</p>
			        <ul>
			            <li><p>Major Cryptocurrencies</p></li>
			            <li><p>SWIFT / Wire</p></li>
			            <li><p>PayPal</p></li>
			        </ul>
			    </div>
			</div>
		    </li>
		    <li>
			<div class="fxstar-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Buy</p>
		    </li>
		    <li>
			<div class="fxstar-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p>Send / Receive / Request</p>
		    </li>
		    <li>
		        <div class="circle-text">
				<div class="fxstar-circle">
				    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
				</div>
				<div class="details-con">
					<p>Earn as:</p>
				        <ul>
					    <li><p>fxPartner</p></li>
					    <li><p>fxInstructor</p></li>
					    <li><p>fxSubInstructor</p></li>
				        </ul>
				 </div>
			</div>
		    </li>
		    <li>
			<div class="fxstar-circle">
			    <svg viewBox="0 0 12 10"><defs><style>.cls-1{fill:#efefef;}</style></defs><path class="cls-1" d="M4.5,10a1.1,1.1,0,0,1-.7-.3L.3,6.2a1,1,0,0,1,0-1.4,1,1,0,0,1,1.4,0L4.4,7.6,10.3.4A.9.9,0,0,1,11.6.2a1,1,0,0,1,.2,1.4l-6.5,8a.8.8,0,0,1-.7.4Z"></path></svg>
			</div>
			<p><em>More programs to come...</em></p>
		    </li>
		  </ul>
		</div>
	      </div>
      </div>
  </body>
</html>
