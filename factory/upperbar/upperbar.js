if(screen.width>628) {

    $('.header').html(`

        <a class="logo logo-25" href="/">
        </a>
        <nav>
            <ul class="nav__links">
                <li><a href="/"><img src="/images/icons/toolbar/home.png"></a></li>
                <li><a href="/msg/inbox.php"><img src="/images/icons/toolbar/msg.png" ></a></li>
                <li><a href="/userpgs/notif"><img src="/images/icons/toolbar/notif.png"></a></li>
                <li><a href="/search"><img src="/images/icons/toolbar/search.png"></a></li>
<li><a href="#" class="openbtn" onclick="openNav()">☰</a></li>


            </ul>
        </nav>


<div id="mySidepanel" class="sidepanel">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                  <a href="#">About</a>
                  <a href="#">Contact</a>
                  <a href="#">Log out</a>
                    <div class="socialmedia">
                      <a href="#" class="facebook"></a>
                      <a href="#" class="instagram"></a>
                      <a href="#" class="twitter"></a>
                    </div>
                </div>


                     `);

    $('.header-sidebar').html(`
<nav>
            <ul class="nav__links">
                <li tabIndex="1">
                  <a href="/">
                    <svg aria-label="home" viewBox="0 0 32 32">
                     
                        <path class="stroked" d="M16,2a2,2,0,0,1,1.4.6L30,15.2V30H22.1V22.6A6.1,6.1,0,0,0,16,16.5H14.8a6.2,6.2,0,0,0-4.9,6.2V30H2V15.2L14.6,2.6A2,2,0,0,1,16,2m0-2a3.9,3.9,0,0,0-2.8,1.2L0,14.3V32H11.9V22.8a4.2,4.2,0,0,1,3.3-4.2H16a4.1,4.1,0,0,1,4.1,4.1V32H32V14.3L18.8,1.2A3.9,3.9,0,0,0,16,0Z"/>
                        <path class="filled" d="M16,0a3.9,3.9,0,0,0-2.8,1.2L0,14.3V32H11.9V22.8a4.2,4.2,0,0,1,3.3-4.2H16a4.1,4.1,0,0,1,4.1,4.1V32H32V14.3L18.8,1.2A3.9,3.9,0,0,0,16,0Z"/>
                     
                    </svg>
                  </a>
                </li>
                <li tabIndex="1">
                  <a href="/msg/inbox.php">
                    <svg aria-label="message" viewBox="0 0 32 32">
                      <path class="stroked" d="M28,1.4H4a4,4,0,0,0-4,4V26.6a4,4,0,0,0,4,4H28a4,4,0,0,0,4-4V5.4A4,4,0,0,0,28,1.4Zm2,25.2a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V9.6l14,9,14-9ZM30,7.2l-14,9L2,7.3V5.4a2,2,0,0,1,2-2H28a2,2,0,0,1,2,2Z"/>
                      <path class="filled" d="M31.9,4.7A4,4,0,0,0,28,1.4H4A4,4,0,0,0,.1,4.8a1.3,1.3,0,0,0-.1.6V26.6a4,4,0,0,0,4,4H28a4,4,0,0,0,4-4V5.4A2,2,0,0,0,31.9,4.7ZM30,10.8l-14,9-14-9V6l14,9L30,6Z"/>
                    </svg>
                  </a>
                </li>
                <li tabIndex="1" class="ontifbtn">
                  <a href="/userpgs/notif">
                    <svg aria-label="notification" viewBox="0 0 32 32">
                      <path class="stroked" d="M27.6,16.9V11.6a11.6,11.6,0,0,0-23.2,0v5.3L0,24.5H8.4A7.6,7.6,0,0,0,16,32a7.5,7.5,0,0,0,7.5-7.5H32ZM16,30a5.6,5.6,0,0,1-5.6-5.5H21.5A5.5,5.5,0,0,1,16,30ZM3.5,22.5l2.6-4.6.3-.5V11.6a9.6,9.6,0,1,1,19.2,0v5.8l.3.5,2.6,4.6Z"/>
                      <path class="filled" d="M27.6,16.9V11.6a11.6,11.6,0,0,0-23.2,0v5.3L0,24.4H8.4A7.6,7.6,0,0,0,16,32a7.5,7.5,0,0,0,7.5-7.6H32ZM16,28a3.6,3.6,0,0,1-3.6-3.6h7.1A3.5,3.5,0,0,1,16,28Z"/>
                    </svg>
                  </a>
                </li>
                <li tabIndex="1">
                  <a href="/search">
                    <svg aria-label="search" viewBox="0 0 32 32">
                      <path class="stroked" d="M24.3,22.8a13.8,13.8,0,0,0,3.2-10.3A13.9,13.9,0,0,0,14.7,0,13.9,13.9,0,0,0,0,14.8,14,14,0,0,0,12.5,27.6a14.1,14.1,0,0,0,10.3-3.3l7.5,7.4a1,1,0,0,0,1.4,0h0a1,1,0,0,0,0-1.4ZM13.8,25.6A11.8,11.8,0,1,1,25.6,13.8a11.3,11.3,0,0,1-2.8,7.6l-1.4,1.4A11.3,11.3,0,0,1,13.8,25.6Z"/>
                      <path class="filled" d="M31.4,28.6l-6.5-6.5a14,14,0,0,0,2.7-8.3A13.8,13.8,0,1,0,13.8,27.6a14,14,0,0,0,8.3-2.7l6.5,6.5a1.9,1.9,0,0,0,2.8,0A1.9,1.9,0,0,0,31.4,28.6Zm-17.6-5a9.8,9.8,0,1,1,9.8-9.8A10.1,10.1,0,0,1,22,19.2,9.3,9.3,0,0,1,19.2,22,10.1,10.1,0,0,1,13.8,23.6Z"/>
                    </svg>
                  </a>
                </li>
                <li tabIndex="1">
                  <a href="#" class="openbtn" onclick="openNav()">
                    <svg aria-label="menu" viewBox="0 0 32 32">
                      <rect class="cls-1" x="3" y="3" width="26" height="2" rx="1"/><rect class="cls-1" x="3" y="15" width="26" height="2" rx="1"/><rect class="cls-1" x="3" y="27" width="26" height="2" rx="1"/>
                    </svg>
                  </a>
                </li>
                
            </ul>

        </nav>

        <div id="mySidepanel" class="sidepanel">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                  <a href="#">About</a>
                  <a href="#">Contact</a>
                  <a href="#">Log out</a>
                    <div class="socialmedia">
                      <a href="#" class="facebook"></a>
                      <a href="#" class="instagram"></a>
                      <a href="#" class="twitter"></a>
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
                            <a href="#" class="avatar-m"></a>
                        </div>
                    </div>
                    <a class="id-sidebar-m menu-info" href="#">@Neo</a>
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
                        <a href="#" class="policy-m">Policy</a>
                        <a href="#">About</a>
                        <a href="#">Contact</a>
                        <a href="#">Log out</a>
                    </div>
                    <div class="socialmedia socialmedia-m">
                      <a href="#" class="facebook"></a>
                      <a href="#" class="instagram"></a>
                      <a href="#" class="twitter"></a>
                    </div>
                </div>

                     `);




    $('.header-sidebar').html(`

       
        <nav>
            <ul class="nav__links">
                <li><a  class="blur" onclick="goBack()"><img src="/images/icons/toolbar/back.png"></a></li>
<li><a href="" id="page-header"></a></li>
                <li><a href="#" class="openbtn" onclick="openNav()">☰</a></li>
            </ul>
        </nav>

<div id="mySidepanel" class="sidepanel">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                    <div class="sidebar-m">
                        <div>
                            <a href="#" class="avatar-m"></a>
                        </div>
                    </div>
                    <a class="id-sidebar-m menu-info" href="#">@Neo</a>
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
                        <a href="#" class="policy-m">Policy</a>
                        <a href="#">About</a>
                        <a href="#">Contact</a>
                        <a href="#">Log out</a>
                    </div>
                    <div class="socialmedia socialmedia-m">
                      <a href="#" class="facebook"></a>
                      <a href="#" class="instagram"></a>
                      <a href="#" class="twitter"></a>
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
    } else if(loc=='/msg/inbox.php') {
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
