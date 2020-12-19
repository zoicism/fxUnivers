if(screen.width>628) {

    $('.header').html(`

        <a class="logo logo-25" href="/">
        </a>
        <nav>
            <ul class="nav__links">
                <li><a href="/"><img src="/images/icons/toolbar/home.png"></a></li>
                <li><a href="/msg/inbox.php"><img src="/images/icons/toolbar/msg.png" ></a><div class="newnum" id="msg-bar"></div></li>
                <li><a href="/userpgs/notif"><img src="/images/icons/toolbar/notif.png"><div class="newnum" id="notif-bar"></div></a></li>
                <li><a href="/search"><img src="/images/icons/toolbar/search.png"></a></li>
<li><a href="#" class="openbtn" onclick="openNav()">☰</a></li>


            </ul>
        </nav>


<div id="mySidepanel" class="sidepanel">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                  <a href="#">About</a>
                  <a href="/contact/msgus">Contact</a>
                  <a href="/register/logout.php">Log out</a>
                    <div class="socialmedia">
                      <a href="https://facebook.com/fxunivers" class="facebook" target="_blank"></a>
                      <a href="https://instagram.com/fxunivers" class="instagram" target="_blank"></a>
                      <a href="https://twitter.com/fxunivers" class="twitter" target="_blank"></a>
                    </div>
                </div>


                     `);

    $('.header-sidebar').html(`
<nav>
            <ul class="nav__links">
                <li><a href="/"><img src="/images/icons/toolbar/home.png"></a></li>
                <li><a href="/msg/inbox.php"><img src="/images/icons/toolbar/msg.png"></a></li>
                <li><a href="/userpgs/notif"><img src="/images/icons/toolbar/notif.png"></a></li>
                <li><a href="/search"><img src="/images/icons/toolbar/search.png"></a></li>
                <li><a href="#" class="openbtn" onclick="openNav()">☰</a></li>
                
            </ul>

        </nav>

        <div id="mySidepanel" class="sidepanel">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                  <a href="#">About</a>
                  <a href="/contact/msgus">Contact</a>
                  <a href="/register/logout.php">Log out</a>
                    <div class="socialmedia">
<a href="https://facebook.com/fxunivers" class="facebook" target="_blank"></a>
                      <a href="https://instagram.com/fxunivers" class="instagram" target="_blank"></a>
                      <a href="https://twitter.com/fxunivers" class="twitter" target="_blank"></a>
                    </div>
                </div>
`);


    
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
    );
} else {
    var loc=window.location.pathname;
    var upperbar = `
<div class="upperbar-icon back" style="margin-left:30px;float:left;" onclick="goBack()"></div>
<div id="current" style="margin-right:30px;margin-top:3%;float:right;"></div>
<div class="logo logo-25" style="margin:0 auto;margin-top:8px;cursor:pointer;" onclick="location.href='/';"></div>
`;
    
    $('.upperbar').html(upperbar);

    var sess_avatar=$('#upperbar-script').attr('sess_avatar');
    var sess_un=$('#upperbar-script').attr('sess_un');

    if(sess_avatar!=null) {
	var avatar_div = `<a href="/user/`+sess_un+`" class="avatar-m" style="background-image:url('/userpgs/avatars/`+sess_avatar+`');"></a>`;
    } else {
	var avatar_div = `<a href="/user/`+sess_un+`" class="avatar-m" style="background-image:url('/images/background/avatar.png');"></a>`;
    }

$('.header').html(`
       
        <nav>
            <ul class="nav__links">
                <li><a  class="blur" style="visibility:hidden" onclick="goBack()"><img src="/images/icons/toolbar/back.png"></a></li>
<li><a href="" class="blur" id="page-header"></a></li>
                <li><a href="#" class="openbtn" onclick="openNav()">☰</a></li>
            </ul>
        </nav>

<div id="mySidepanel" class="sidepanel">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                    <div class="sidebar-m">
                        <div>
                            `+avatar_div+`
                        </div>
                    </div>
                    <a class="id-sidebar-m menu-info" href="/user/`+sess_un+`">@`+sess_un+`</a>
                    <div class="sidebar-m">
                        <div class="elements">
                            <a href="#" class="fxstar-sidebar">fxStar</a>
                            <a href="#" class="fxuniversity-sidebar">fxUniversity</a>
                            <a href="#" class="fxpartner-sidebar">fxPartner</a>
                            <a href="#" class="fxuniverse-sidebar">fxUniverse</a>
                            <a href="#" class="fxsonet-sidebar">fxSonet</a>
                        </div>
                    </div>
                    <div class="menu-info">
                        <a href="/policy" class="policy-m">Policy</a>
                        <a href="#">About</a>
                        <a href="/contact/msgus">Contact</a>
                        <a href="/register/logout.php">Log out</a>
                    </div>
                    <div class="socialmedia socialmedia-m">
<a href="https://facebook.com/fxunivers" class="facebook" target="_blank"></a>
                      <a href="https://instagram.com/fxunivers" class="instagram" target="_blank"></a>
                      <a href="https://twitter.com/fxunivers" class="twitter" target="_blank"></a>
                    </div>
                </div>

                     `);




    $('.header-sidebar').html(`

       
        <nav>
            <ul class="nav__links">
                <li><a  class="blur" onclick="goBack()"><img src="/images/icons/toolbar/back.png"></a></li>
<li><a href="" id="page-header"></a></li>
                <li id="header-menu"><a href="#" class="openbtn" onclick="openNav()">☰</a></li>
            </ul>
        </nav>

<div id="mySidepanel" class="sidepanel">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                    <div class="sidebar-m">
                        <div>
                            `+avatar_div+`
                        </div>
                    </div>
                    <a class="id-sidebar-m menu-info" href="/user/`+sess_un+`">@`+sess_un+`</a>
                    <div class="sidebar-m">
                        <div class="elements">
                            <a href="/wallet" class="sidebar-icon fxstar-sidebar">fxStar</a>
                            <a href="/userpgs/fxuniversity" class="sidebar-icon fxuniversity-sidebar">fxUniversity</a>
                            <a href="/userpgs/partner" class="sidebar-icon fxpartner-sidebar" target="_blank">fxPartner</a>
                            <a href="/" class="sidebar-icon fxuniverse-sidebar" target="_blank">fxUniverse</a>
                            <a href="/" class="sidebar-icon fxsonet-sidebar" target="_blank">fxSonet</a>
                        </div>
                    </div>
                    <div class="menu-info">
                        <a href="/policy" class="policy-m">Policy</a>
                        <a href="#">About</a>
                        <a href="/contact/msgus">Contact</a>
                        <a href="/register/logout.php">Log out</a>
                    </div>
                    <div class="socialmedia socialmedia-m">
<a href="https://facebook.com/fxunivers" class="facebook" target="_blank"></a>
                      <a href="https://instagram.com/fxunivers" class="instagram" target="_blank"></a>
                      <a href="https://twitter.com/fxunivers" class="twitter" target="_blank"></a>
                    </div>
                </div>

                     `);




    

    if(loc=='/userpgs/') {
	$('#current').html('Home');
	$('.back').hide();
    } else if(loc=='/wallet/' || loc=='/wallet/buy/' || loc=='/wallet/txn/' || loc=='/wallet/req/' || loc=='/wallet/send/' || loc=='/wallet/purchase/' || loc=='/wallet/cashout/') {
	$('#current').html('fxStar');
    } else if(loc=='/userpgs/fxuniversity/' || loc=='/userpgs/instructor/' || loc=='/userpgs/instructor/course_management/new_course.php' || loc=='/userpgs/instructor/course_management/edit_course.php' || loc=='/userpgs/instructor/exam/' || loc=='/userpgs/instructor/exam/edit_exam.php' || loc=='/userpgs/instructor/class/new_class.php' || loc=='/userpgs/instructor/class/' || loc=='/userpgs/instructor/course_management/course.php' || loc=='/userpgs/instructor/class/edit_class.php' || loc=='/userpgs/instructor/class/live/' || loc=='/userpgs/student/' || loc=='/userpgs/student/courses/' || loc=='/userpgs/instructor/exam/result.php' || loc=='/userpgs/instructor/exam/take_exam.php' || loc=='/userpgs/instructor/profile/' || loc=='/userpgs/student/profile/') {
	$('#current').html('fxUniversity');
    } else if(loc=='/userpgs/partner/' || loc=='/userpgs/partner/income/' || loc=='/userpgs/partner/positions/') {
	$('#current').html('fxPartner');
    } else if(loc=='/search/') {
	$('#current').html('fxSearch');
    } else if(loc=='/userpgs/rel/') {
	$('#current').html('fxFriends');
    } else if(loc=='/userpgs/notif/') {
	$('#current').html('fxNotifs');
    } else if(loc=='/msg') {
	$('#current').html('fxMsg');
    }
}



function openNav() {
            if(screen.width<629) {
              document.getElementById("mySidepanel").style.width = "70%";
              $('.blur').css('filter','blur(5px)');
            } else {
              document.getElementById("mySidepanel").style.width = "20%";
            }
          }

          function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
            if (screen.width<629) {
              $('.blur').css('filter','blur(0)');
            }
            
          }


function goBack() {
    window.history.back();
}
