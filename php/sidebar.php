<?php

echo <<<EOL
<script>
if(screen.width>628) {
    $('.sidebar').html(`


<div class="logo-sidebar logo-25"></div>
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
		    <a href="/wallet" class="sidebar-icon fxstar-sidebar">fxStar</a>
		    <a href="/userpgs/fxuniversity" class="sidebar-icon fxuniversity-sidebar">fxUniversity</a>
		    <a href="/userpgs/partner" class="sidebar-icon fxpartner-sidebar">fxPartner</a>
		    <a onclick="coming()" class="sidebar-icon fxuniverse-sidebar">fxUniverse</a>
		    <a onclick="coming()" class="sidebar-icon fxsonet-sidebar">fxSonet</a>
		    
	    </div>
                          <div class="policy">
                          With all due Reserves, © fxUnivers 2017-2020 All rights reserved. <a href="/policy">Policy</a>
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
