if(screen.width<628) {
    var loc = window.location.pathname;
    var footbar = `
<div class="footbar-icon home" style="margin-left:30px;cursor:pointer;" onclick="location.href='/';"></div>
<div class="footbar-icon search" style="cursor:pointer" onclick="location.href='/search';"></div>
<div class="footbar-icon notif" style="cursor:pointer" onclick="location.href='/userpgs/notif';">
  <div class="newnum" id="notif-bar"></div>
</div>
<div class="footbar-icon msg" style="margin-right:30px;cursor:pointer" onclick="location.href='/msg/inbox.php';">
  <div class="newnum" id="msg-bar" style="margin-right:-9px"></div>
</div>
`;
    
    $('.footbar').html(footbar);
    
    if(loc=='/userpgs/') {
	$('.home').attr('id','active');
    } else if(loc=='/userpgs/notif/') {
	$('.notif').attr('id','active');
    } else if(loc=='/search/') {
	$('.search').attr('id','active');
    } else if(loc=='/msg/inbox.php') {
	$('.msg').attr('id','active');
    }
}
	
