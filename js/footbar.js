if(screen.width<628) {

    


    var loc = window.location.pathname;
    var footbar = `
<div class="footbar-icon home" style="margin-left:30px;cursor:pointer;" onclick="location.href='/';">
  <svg aria-label="home" viewBox="0 0 32 32">
                     
                        <path class="stroked" d="M16,2a2,2,0,0,1,1.4.6L30,15.2V30H22.1V22.6A6.1,6.1,0,0,0,16,16.5H14.8a6.2,6.2,0,0,0-4.9,6.2V30H2V15.2L14.6,2.6A2,2,0,0,1,16,2m0-2a3.9,3.9,0,0,0-2.8,1.2L0,14.3V32H11.9V22.8a4.2,4.2,0,0,1,3.3-4.2H16a4.1,4.1,0,0,1,4.1,4.1V32H32V14.3L18.8,1.2A3.9,3.9,0,0,0,16,0Z"/>
                        <path class="filled" d="M16,0a3.9,3.9,0,0,0-2.8,1.2L0,14.3V32H11.9V22.8a4.2,4.2,0,0,1,3.3-4.2H16a4.1,4.1,0,0,1,4.1,4.1V32H32V14.3L18.8,1.2A3.9,3.9,0,0,0,16,0Z"/>
                    </svg>
</div>


<div class="footbar-icon search" style="cursor:pointer" onclick="location.href='/search';">
<svg aria-label="search" viewBox="0 0 32 32">
                      <path class="stroked" d="M24.3,22.8a13.8,13.8,0,0,0,3.2-10.3A13.9,13.9,0,0,0,14.7,0,13.9,13.9,0,0,0,0,14.8,14,14,0,0,0,12.5,27.6a14.1,14.1,0,0,0,10.3-3.3l7.5,7.4a1,1,0,0,0,1.4,0h0a1,1,0,0,0,0-1.4ZM13.8,25.6A11.8,11.8,0,1,1,25.6,13.8a11.3,11.3,0,0,1-2.8,7.6l-1.4,1.4A11.3,11.3,0,0,1,13.8,25.6Z"/>
                      <path class="filled" d="M31.4,28.6l-6.5-6.5a14,14,0,0,0,2.7-8.3A13.8,13.8,0,1,0,13.8,27.6a14,14,0,0,0,8.3-2.7l6.5,6.5a1.9,1.9,0,0,0,2.8,0A1.9,1.9,0,0,0,31.4,28.6Zm-17.6-5a9.8,9.8,0,1,1,9.8-9.8A10.1,10.1,0,0,1,22,19.2,9.3,9.3,0,0,1,19.2,22,10.1,10.1,0,0,1,13.8,23.6Z"/>
                    </svg>
</div>


<div class="footbar-icon notif" style="cursor:pointer" onclick="location.href='/userpgs/notif';">
<svg aria-label="notification" viewBox="0 0 32 32">
                      <path class="stroked" d="M27.6,16.9V11.6a11.6,11.6,0,0,0-23.2,0v5.3L0,24.5H8.4A7.6,7.6,0,0,0,16,32a7.5,7.5,0,0,0,7.5-7.5H32ZM16,30a5.6,5.6,0,0,1-5.6-5.5H21.5A5.5,5.5,0,0,1,16,30ZM3.5,22.5l2.6-4.6.3-.5V11.6a9.6,9.6,0,1,1,19.2,0v5.8l.3.5,2.6,4.6Z"/>
                      <path class="filled" d="M27.6,16.9V11.6a11.6,11.6,0,0,0-23.2,0v5.3L0,24.4H8.4A7.6,7.6,0,0,0,16,32a7.5,7.5,0,0,0,7.5-7.6H32ZM16,28a3.6,3.6,0,0,1-3.6-3.6h7.1A3.5,3.5,0,0,1,16,28Z"/>
                    </svg>
  <div class="newnum" id="notif-bar"></div>
</div>


<div class="footbar-icon msg" style="margin-right:30px;cursor:pointer" onclick="location.href='/msg/inbox.php';">
<svg aria-label="message" viewBox="0 0 32 32">
                      <path class="stroked" d="M28,1.4H4a4,4,0,0,0-4,4V26.6a4,4,0,0,0,4,4H28a4,4,0,0,0,4-4V5.4A4,4,0,0,0,28,1.4Zm2,25.2a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V9.6l14,9,14-9ZM30,7.2l-14,9L2,7.3V5.4a2,2,0,0,1,2-2H28a2,2,0,0,1,2,2Z"/>
                      <path class="filled" d="M31.9,4.7A4,4,0,0,0,28,1.4H4A4,4,0,0,0,.1,4.8a1.3,1.3,0,0,0-.1.6V26.6a4,4,0,0,0,4,4H28a4,4,0,0,0,4-4V5.4A2,2,0,0,0,31.9,4.7ZM30,10.8l-14,9-14-9V6l14,9L30,6Z"/>
                    </svg>
  <div class="newnum" id="msg-bar" style="margin-right:-9px"></div>
</div>
`;
    
    $('.footbar').html(footbar);
    
    if(loc=='/userpgs/') {
	$('.footbar .home .stroked').hide();
	$('.footbar .home .filled').show();
    } else if(loc=='/userpgs/notif/') {
	$('.footbar .notif .stroked').hide();
	$('.footbar .notif .filled').show();
    } else if(loc=='/search/') {
	$('.footbar .search .stroked').hide();
	$('.footbar .search .filled').show();
    } else if(loc=='/msg/inbox.php') {
	$('.footbar .msg .stroked').hide();
	$('.footbar .msg .filled').show();
    }

    $('<div style="width:100%;display:block;background:transparent;height:50px;" id="lower50"></div>').insertAfter('.footbar');
}
	
