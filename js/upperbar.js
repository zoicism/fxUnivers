if(screen.width>628) {

    $('.header').html(`

        <a class="logo logo-25" href="/">
        </a>
        <nav>
            <ul class="nav__links">
                <li><a href="/"><img src="/images/icons/toolbar/home.png" width="22px" height="22px"></a></li>
                <li><a href="/msg/inbox.php"><img src="/images/icons/toolbar/msg.png" width="22px" height="22px"></a></li>
                <li><a href="/userpgs/notif"><img src="/images/icons/toolbar/notif.png" width="22px" height="22px"></a></li>
                <li><a href="/search"><img src="/images/icons/toolbar/search.png" width="22px" height="22px"></a></li>
            </ul>
        </nav>

                     `);

    $('.header-sidebar').html(`
<nav>
            <ul class="nav__links">
                <li><a href="/"><img src="/images/icons/toolbar/home.png" width="22px" height="22px"></a></li>
                <li><a href="/msg/inbox.php"><img src="/images/icons/toolbar/msg.png" width="22px" height="22px"></a></li>
                <li><a href="/userpgs/notif"><img src="/images/icons/toolbar/notif.png" width="22px" height="22px"></a></li>
                <li><a href="/search"><img src="/images/icons/toolbar/search.png" width="22px" height="22px"></a></li>
            </ul>
        </nav>
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
<a href="/" style="margin-right:auto"><img src="/images/icons/toolbar/back.png" width="22px" height="22px"></a>
       
        <nav>
            <ul class="nav__links">
                
                <li><a href="/search"><img src="/images/icons/toolbar/search.png" width="22px" height="22px"></a></li>
            </ul>
        </nav>

                     `);



    $('.header-sidebar').html(`
<a href="/" style="margin-right:auto"><img src="/images/icons/toolbar/back.png" width="22px" height="22px"></a>
       
        <nav>
            <ul class="nav__links">
                
                <li><a href="/search"><img src="/images/icons/toolbar/search.png" width="22px" height="22px"></a></li>
            </ul>
        </nav>

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

function goBack() {
    window.history.back();
}
