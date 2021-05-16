<?php

echo <<<EOL
<script>
if(screen.width>628) {
    $('.sidebar').html(`

<div class="sidebar-logo-con">
  <div class="logo-sidebar logo-25" onclick="window.location.href='/'" style="cursor:pointer">
      <svg viewBox="0 0 50 50"><defs><style>.cls-1{fill:#00a1e0;}</style></defs><g id="three"><path d="M25,1.7a22.2,22.2,0,0,1,9.1,1.9,23.9,23.9,0,0,1,7.4,4.9,23.9,23.9,0,0,1,4.9,7.4,22.7,22.7,0,0,1,0,18.2,23.9,23.9,0,0,1-4.9,7.4,23.9,23.9,0,0,1-7.4,4.9,22.7,22.7,0,0,1-18.2,0,23.9,23.9,0,0,1-7.4-4.9,23.9,23.9,0,0,1-4.9-7.4,22.7,22.7,0,0,1,0-18.2A23.9,23.9,0,0,1,8.5,8.5a23.9,23.9,0,0,1,7.4-4.9A22.2,22.2,0,0,1,25,1.7M25,0h0A25,25,0,0,0,0,25H0A25,25,0,0,0,25,50h0A25,25,0,0,0,50,25h0A25,25,0,0,0,25,0Z"></path><path d="M33.7,35l1.9,1.8-4.4,4.4-1.8-1.8L25,35l-4.4-4.4-4.3-4.3-4.4-4.4,4.4-4.3L25,8.8l4.4,4.4-8.8,8.7L25,26.3l4.4-4.4a6.2,6.2,0,0,1,8.7,0l-8.7,8.7Z"></path><path d="M21.8,38.2l-1.2,1.2a6.2,6.2,0,0,1-8.7,0l5.6-5.6Z"></path></g></svg>
  </div>
   <div class="fxunivers-txt" onclick="window.location.href='/'" style="cursor:pointer">
       fxUnivers
   </div>    
</div>
		<div>
EOL;

$avatar_path=$_SERVER['DOCUMENT_ROOT'];
$avatar_path.='/userpgs/avatars/';
$avatar_ex = glob($avatar_path.$get_user_id.'.*');
if(count($avatar_ex) > 0) {
    $avatar_arr = explode('.', $avatar_ex[0]);
    $avatar_extension = end($avatar_arr);

    echo '<a href="/user/'.$username.'" class="link avatar-sidebar" style="background-image:url(\'/userpgs/avatars/'.$get_user_id.'.'.$avatar_extension.'\');"></a>';
} else {
    echo '<a href="/user/'.$username.'" class="link avatar-sidebar"></a>';
}

echo <<<EOL
			<a class="id-sidebar" href="/user/$username">@$username</a>
		</div>
		<div class="elements">
<a href="/userpgs/fxuniversity" class="sidebar-icon fxuniversity-sidebar">fxUniversity</a>

		    <a href="/userpgs/partner" class="sidebar-icon fxpartner-sidebar">fxPartner</a>
		    <a href="/wallet" class="sidebar-icon fxstar-sidebar">fxStar</a>
		    
		    <a onclick="coming()" class="sidebar-icon fxuniverse-sidebar">fxUniverse</a>
		    <a onclick="coming()" class="sidebar-icon fxsonet-sidebar">fxSonet</a>
		    
	    </div>
                          <div class="policy">
                          <p>With all due Reserves,</p><p>© fxUnivers 2017-2021</p><p>All rights reserved.</p><p><a href="/policy">Policy</a></p>
                          </div>


    `);


}
</script>

<script>
function coming() {
alert("Coming soon...");
}
</script>
EOL;
?>
