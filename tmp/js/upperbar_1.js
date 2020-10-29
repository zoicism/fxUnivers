if(screen.width>480) {
    $('.upperbar').html(`
      <span style="float:left">
        <div class="logo logo-25" onclick="location.href='/';" style="margin-left:30px;margin-top:10px;cursor:pointer;"></div>
      </span>

      <span style="float:right;margin-right:30px;">
        <div class="toolbar-icon home" onclick="location.href='/';"></div>
        <div class="toolbar-icon search" onclick="location.href='/search';"></div>
        <div class="toolbar-icon notif" onclick="location.href='/userpgs/notif';">
          <div class="newnum" id="notif-bar"></div>
        </div>
        <div class="toolbar-icon msg" onclick="location.href='/msg/inbox.php';">
          <div class="newnum" id="msg-bar" style="margin-right:-9px"></div>
        </div>
      </span>`
      /*
    $('.upperbar').html(`
        <header>
            <a class="logo" href="/">
            	<img src="../images/logo/logo-100.png" alt="logo">
            </a>
            <nav>
                <ul class="nav__links">
                    <li><a href="#"><img src="home.png" width="22px" height="22px"></a></li>
                    <li><a href="#"><img src="msg.png" width="22px" height="22px"></a></li>
                    <li><a href="#"><img src="notif.png" width="22px" height="22px"></a></li>
                    <li><a href="#"><img src="search.png" width="22px" height="22px"></a></li>
                </ul>
            </nav>
        </header>`*/
    );
}

