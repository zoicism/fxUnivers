<?php
session_start();
require_once('../register/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
require_once('../wallet/php/wallet_connect.php');
header("Cache-Control: no cache");

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}

if(isset($_GET['q'])) {

    $kw = mysqli_real_escape_string($connection,$_GET['q']);
    

    if(isset($_GET['type']) && !empty($_GET['type'])) {
	$type = $_GET['type'];
    }


    $course_q = "SELECT * FROM teacher WHERE ((UPPER(header) LIKE UPPER('%$kw%')) OR (UPPER(description) LIKE UPPER('%$kw%'))) AND alive=1 AND private=0 ORDER BY id DESC";
    $course_result = mysqli_query($connection, $course_q);
    $course_count = mysqli_num_rows($course_result);

    $user_q = "SELECT id,username,fname,lname,avatar FROM user WHERE (UPPER(username) LIKE UPPER('%$kw%')) OR (UPPER(fname) LIKE UPPER('%$kw%')) OR (UPPER(lname) LIKE UPPER('%$kw%')) ORDER BY id DESC";
    $user_r = mysqli_query($connection,$user_q) or die(mysqli_error($connection));
    $user_count = mysqli_num_rows($user_r);

}


require('../php/get_user.php');

// fetch the sonet records
require('../userpgs/sonet/following.php');

$id=$get_user_id;
require('../userpgs/php/notif.php');

require('../php/get_plans.php');

require('../php/get_rel.php');

require('../wallet/php/get_fxcoin_count.php');

?>

<!DOCTYPE html>
<html>
    <head>
	<title>fxSearch</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/icons.css">
	<link rel="stylesheet" href="/css/logo.css">
	<script src="/js/jquery-3.4.1.min.js"></script>
    </head>

    <body>
	<div class="header-sidebar"></div>
	<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>

	<div class="blur mobile-main">

	    <div class="sidebar"></div>
	    <?php require('../php/sidebar.php'); ?>


	    <?php if(isset($_GET['q'])) { ?>

		<div class="main-content" style="display:block !important;">

		    <ul class="main-flex-container" style="flex-flow:row nowrap;">
			<li class="main-items">
			    <a href="<?php echo '/search?q='.$kw; ?>" class="link-main" <?php if(isset($_GET['q']) && !empty($_GET['q']) && !isset($_GET['type'])) echo 'id="active-main"'; ?>>
				<div class="head">Users <?php if(isset($_GET['q']) && !empty($_GET['q'])) echo '('.$user_count.')'; ?></div>
			    </a>
			</li>
			<li class="main-items">
			    <a href="<?php echo '/search?q='.$kw.'&type=course'; ?>" class="link-main" <?php if(isset($_GET['type']) && !empty($_GET['type'])) echo 'id="active-main"'; ?>>
				<div class="head">Courses <?php if(isset($_GET['q']) && !empty($_GET['q'])) echo '('.$course_count.')';?></div>
			    </a>
			</li>
			
		    </ul>

		</div>
	    <?php } ?>






	    <div class="relative-main-content">
		

		<form method="GET" action="/search" class="search-form">
		    <div class="search-input-icon-con">
			<input type="text" name="q" autofocus class="txt-input" placeholder="Search fxUnivers" <?php if(isset($_GET['q']) && !empty($_GET['q'])) echo 'value="'.$_GET['q'].'"';?> required>
			<?php if(isset($_GET['type']) && !empty($_GET['type']))
			    echo '<input type="hidden" name="type" value="'.$_GET['type'].'">';
			?>
			<a class="search-button" id="search-btn">
			    <svg aria-label="search" viewBox="0 0 32 32" style="width:100%;height:100%;">
				<path class="stroked" d="M24.3,22.8a13.8,13.8,0,0,0,3.2-10.3A13.9,13.9,0,0,0,14.7,0,13.9,13.9,0,0,0,0,14.8,14,14,0,0,0,12.5,27.6a14.1,14.1,0,0,0,10.3-3.3l7.5,7.4a1,1,0,0,0,1.4,0h0a1,1,0,0,0,0-1.4ZM13.8,25.6A11.8,11.8,0,1,1,25.6,13.8a11.3,11.3,0,0,1-2.8,7.6l-1.4,1.4A11.3,11.3,0,0,1,13.8,25.6Z" style="display: none;"></path>
				<path class="filled" d="M31.4,28.6l-6.5-6.5a14,14,0,0,0,2.7-8.3A13.8,13.8,0,1,0,13.8,27.6a14,14,0,0,0,8.3-2.7l6.5,6.5a1.9,1.9,0,0,0,2.8,0A1.9,1.9,0,0,0,31.4,28.6Zm-17.6-5a9.8,9.8,0,1,1,9.8-9.8A10.1,10.1,0,0,1,22,19.2,9.3,9.3,0,0,1,19.2,22,10.1,10.1,0,0,1,13.8,23.6Z" style="display: inline;"></path>
			    </svg>
			</a>
			<input type="submit" style="display:none" value="Search" class="submit-btn">
		    </div>    
		</form>




<?php
if($type=='course') {

    require('../php/limit_str.php');

    function get_string_between($string, $start, $end){
    	$string = ' ' . $string;
    	$ini = strpos($string, $start);
    	if ($ini == 0) return '';
    	$ini += strlen($start);
    	$len = strpos($string, $end, $ini) - $ini;
    	return substr($string, $ini, $len);
    }

    if($course_count>0) {
	$course_arr = array();
	$course_id_arr = array();
	$course_user_id_arr = array();
	$course_j = 0;

	echo '<div class="obj-box">';

	while($row3=$course_result->fetch_assoc()) {
            $coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$row3['id'];
            $coursecounter_r=mysqli_query($connection,$coursecounter_q);
            $coursecounts=mysqli_num_rows($coursecounter_r);


	    $teacher_un_q = 'SELECT username,verified FROM user WHERE id='.$row3['user_id'];
	    $teacher_un_r = mysqli_query($connection,$teacher_un_q);
	    $teacher_un_f = mysqli_fetch_array($teacher_un_r);
	    $teacher_un = $teacher_un_f['username'];
	    $teacher_verified = $teacher_un_f['verified'];
	    
	    $course_id_arr[$course_j] = $row3['id'];
	    $course_user_id_arr[$course_j] = $row3['user_id'];

	    $obj_div[$course_j] = '<div class="object" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$row3['id'].'\';">';


            if($row3['video_url']!=null) {
		$link_text = $row3['video_url'];
		if(strpos($link_text,'youtube.com') !== false) {			    
		    $video_id = get_string_between($link_text,'embed/','" frameborder');
		    $obj_div[$course_j] .= '<div class="preview"> <img src="https://img.youtube.com/vi/'.$video_id.'/0.jpg">	</div>';
		} elseif(strpos($link_text,'vimeo.com') !== false) {
		    $video_id = get_string_between($link_text,'video/','" frameborder');
		    $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
		    
		    $obj_div[$course_j] .= '<div class="preview"> <img src="'.$hash[0]['thumbnail_medium'].'"> </div>';
		}
		
	    } else {
		$obj_div[$course_j] .= '<div class="preview">
				  <svg viewBox="0 0 70 50.8">
				  	<path class="cls-1" d="M659.7,889.3l-1.8-1.1v1.4l-25.4,16a.6.6,0,0,1-.9-.4V895a1.6,1.6,0,0,1,.8-1.4l26.8-16.3a1.1,1.1,0,0,0,.6-1.1h0a1.2,1.2,0,0,0-.7-1l-37.2-18a5.4,5.4,0,0,0-4.8.1l-25.8,13.6a2.2,2.2,0,0,0-1.2,2v12.9a1.1,1.1,0,0,0,.6,1.1L628.5,907a4.5,4.5,0,0,0,4.6-.2l26.6-16.3a.7.7,0,0,0,.4-.6h0A.9.9,0,0,0,659.7,889.3Zm-31,4.8-36.4-19.7a.7.7,0,0,1-.3-1h0a.8.8,0,0,1,1-.3l36.4,19.8a.6.6,0,0,1,.3.9h0A.6.6,0,0,1,628.7,894.1Z" transform="translate(-590.1 -856.7)"/>
				  </svg>
				</div>';
	    }

	    $obj_div[$course_j] .= '<div class="details">';


	    $ctitle=preg_replace("/<br\W*?\/>/"," ",$row3['header']);
	    $obj_div[$course_j] .= '<p><strong>'.$ctitle.'</strong></p>';
	    


	    if($teacher_verified) {
		$obj_div[$course_j] .= '<div class="little-box teacher-id">'.$teacher_un.' <img src="/images/background/verified.png" style="width:1rem; height:1rem;"></div>';
	    } else {
		$obj_div[$course_j] .= '<div class="little-box teacher-id">'.$teacher_un.'</div>';
	    }


	    
	    $obj_div[$course_j] .= '<div class="detail-bottom">
			    	   <div class="detail-row">
				    <div class="little-box blue-bg">
	    '.$coursecounts.' <span>students</span>
				    </div>
				    <div class="little-box"><span>'.date("M jS, Y", strtotime($row3['start_date'])).'</span></div>
				    </div>';
	    

	    if($row3['cost'] > 0) {
		if($row3['negotiable']) {
		    $obj_div[$course_j] .= '<div style="display:flex; flex-flow:row nowrap;"><div class="price gold-bg" style="width:50%;"><div class="fxstar-white"></div>'.$row3['cost'].'</div><div style="width:50%;" class="price medseagreen-bg">Negotiable</div></div>';
		} else {
		    $obj_div[$course_j] .= '<div class="price gold-bg"><div class="fxstar-white"></div>'.$row3['cost'].'</div>';
		}
	    } else {
		$obj_div[$course_j] .= '<div class="price green-bg" style="padding: 4px 20px;">Free</div>';
	    }
	    
	    

	    

	    $obj_div[$course_j] .= ' </div>
				  </div>
				  </div>';

	    $course_j++;
	}
	$course_result->free();


	$course_votes = array(array());
	for($course_i = 0; $course_i < count($obj_div); $course_i++) {
	    //echo $obj_div[$course_i];
	    $course_vote_id = $course_id_arr[$course_i];
	    $course_user_id = $course_user_id_arr[$course_i];

	    $upvotes_q = "SELECT * FROM courseLikes WHERE courseId = $course_vote_id";
	    $upvotes_r = mysqli_query($fxinstructor_connection, $upvotes_q);
	    $upvotes = mysqli_num_rows($upvotes_r);

	    $downvotes_q = "SELECT * FROM courseDislikes WHERE courseId = $course_vote_id";
	    $downvotes_r = mysqli_query($fxinstructor_connection, $downvotes_q);
	    $downvotes = mysqli_num_rows($downvotes_r);

	    $course_votes[$course_i][0] = $upvotes - $downvotes;
	    $course_votes[$course_i][1] = $course_i;

	    if($course_user_id == 3) {
	      $course_votes[$course_i][0] = 1000000;
	    }
	}

	usort($course_votes, function($a, $b) {
	    return $a[0] <=> $b[0];
	});
	
	for($sort_i = count($course_votes)-1; $sort_i >= 0; $sort_i--) {
	    echo $obj_div[$course_votes[$sort_i][1]];
	}

	
	
	echo '</div>';   

    } else {
	echo '<p class="gray">No courses found</p>';
    }

} else {
    
    if($user_r->num_rows > 0) {
	require('../php/limit_str.php');
	
	echo '<div class="obj-box">';

	$user_div = array();
	$user_i = 0;
	while($row = $user_r->fetch_assoc()) {

	    $fxstars_q = 'SELECT * FROM fxstars WHERE user_id ='. $row['id'];
	    $fxstars_r = mysqli_query($wallet_connection, $fxstars_q);
	    $fxstars_f = mysqli_fetch_array($fxstars_r);
	    $fxstars = $fxstars_f['balance'];

	    


            $user_div[$user_i] = '<div class="object-user" onclick="location.href=\'/user/'.$row['username'].'\';">';

	    if($row['avatar']==NULL) {
                $user_div[$user_i] .= '<div class="preview-user">
			       <img src="/images/background/avatar.png">
			     </div>';
	    } else {
		$user_div[$user_i] .= '<div class="preview-user">
			          <img src="/userpgs/avatars/'.$row['avatar'].'">
				</div>';
	    }

	    $user_div[$user_i] .= '<div class="details-user">';

	    $user_div[$user_i] .= '<p><strong>'.$row['username'].'</strong></p>';
	    $user_div[$user_i] .= '<p>'.$row['fname'].' '.$row['lname'].'</p>';

	    $user_div[$user_i] .= '<div class="detail-bottom">';

	    if($fxstars>0) {
		$user_div[$user_i] .= '<div class="little-box"><span>'.$fxstars.' fxStars</span></div>';
	    } else {
		$user_div[$user_i] .= '<div class="little-box"><span>0 fxStars</span></div>';
	    }
	    $user_div[$user_i] .= '</div>';
	    
            $user_div[$user_i] .= '</div></div>';


	    $user_sort[$user_i][0] = $user_i;
	    $user_sort[$user_i][1] = $fxstars;

	    

	    $user_i++;
        }
        $user_r->free();

	usort($user_sort, function($c, $d) {
	    return $c[1] <=> $d[1];
	});

	for($user_counter = count($user_div)-1; $user_counter >= 0; $user_counter--) {
	    echo $user_div[$user_sort[$user_counter][0]];
	}

	


	

	echo '</div>';
    } else {
	if(isset($_GET['q']) && !empty($_GET['q'])) {
	    echo '<p class="gray">No results found</p>';
	}
    }
}

if(!isset($_GET['q'])) {
    /*
       $top_fxstars_q = "SELECT * FROM fxstars ORDER BY balance DESC LIMIT 5";
       $top_fxstars_r = mysqli_query($wallet_connection, $top_fxstars_q) or die(mysqli_error($wallet_connection));

       if($top_fxstars_r->num_rows > 0) {
       echo '<hr class="hr-tct" style="width:100%">';
       echo '<h3 style="text-align:left;width:100%;margin-bottom:0;">Top fxUsers</h3>';
       require('../php/limit_str.php');
       
       echo '<div class="obj-box">';

       while($top_row = $top_fxstars_r->fetch_assoc()) {

       $top_user_q = 'SELECT * FROM user WHERE id = '.$top_row['user_id'];
       $top_user_r = mysqli_query($connection, $top_user_q);
       $top_user = mysqli_fetch_array($top_user_r);
       
       echo '<div class="object-user" onclick="location.href=\'/user/'.$top_user['username'].'\';">';

       if($top_user['avatar']==NULL) {
       echo '<div class="preview-user">
       <img src="/images/background/avatar.png">
       </div>';
       } else {
       echo '<div class="preview-user">
       <img src="/userpgs/avatars/'.$top_user['avatar'].'">
       </div>';
       }

       echo '<div class="details-user">';

       echo '<p><strong>'.$top_user['username'].'</strong></p>';
       echo '<p>'.$top_user['fname'].' '.$top_user['lname'].'</p>';

       echo '<div class="detail-bottom">';

       if($top_row['balance']>0) {
       echo '<div class="little-box"><span>'.$top_row['balance'].' fxStars</span></div>';
       } else {
       echo '<div class="little-box"><span>0 fxStars</span></div>';
       }
       echo '</div>';
       
       echo '</div></div>';

       
       }
       $top_fxstars_r->free();
       echo '</div>';
       }*/



    
    $courses_q = "SELECT * FROM teacher WHERE alive=1 AND private=0";
    $courses_r = mysqli_query($connection, $courses_q);
    $courses_count = mysqli_num_rows($courses_r);

    $top_votes = array(0,0,0,0,0);
    $top_courses = array(0,0,0,0,0);

    $top_course_user_id = array(); $top_course_video_url = array(); $top_course_header = array();
    $top_course_start_date = array(); $top_course_negotiable = array(); $top_course_cost = array();
    if($courses_count > 0) {
	echo '<hr class="hr-tct" style="width:100%">';
	echo '<h3 style="text-align:left;width:100%;margin-bottom:0;">Top fxCourses</h3>';
	echo '<div class="obj-box">';
	

	//require('../php/limit_str.php');

	function get_string_between($string, $start, $end){
    	    $string = ' ' . $string;
    	    $ini = strpos($string, $start);
    	    if ($ini == 0) return '';
    	    $ini += strlen($start);
    	    $len = strpos($string, $end, $ini) - $ini;
    	    return substr($string, $ini, $len);
	}


	
	while($course = $courses_r -> fetch_assoc()) {
	    
	    $upvotes_q = "SELECT * FROM courseLikes WHERE courseId = ".$course['id'];
	    $upvotes_r = mysqli_query($fxinstructor_connection, $upvotes_q);
	    $upvotes = mysqli_num_rows($upvotes_r);

	    $downvotes_q = "SELECT * FROM courseDislikes WHERE courseId = ".$course['id'];
	    $downvotes_r = mysqli_query($fxinstructor_connection, $downvotes_q);
	    $downvotes = mysqli_num_rows($downvotes_r);

	    $total_votes = $upvotes - $downvotes;
	    
	    for($i = 0; $i < 5; $i++) {
		if($total_votes > $top_votes[$i]) {
		    
		    for($j = 3; $j >= $i; $j--) {
			$top_votes[$j+1] = $top_votes[$j];
			$top_courses[$j+1] = $top_courses[$j];
			
			$top_course_user_id[$j+1] = $top_course_user_id[$j];
			$top_course_video_url[$j+1] = $top_course_video_url[$j];
			$top_course_header[$j+1] = $top_course_header[$j];
			$top_course_start_date[$j+1] = $top_course_start_date[$j];
			$top_course_negotiable[$j+1] = $top_course_negotiable[$j];
			$top_course_cost[$j+1] = $top_course_cost[$j];
		    }

		    $top_votes[$i] = $total_votes;
		    $top_courses[$i] = $course['id'];
		    
		    $top_course_user_id[$i] = $course['user_id'];
		    $top_course_video_url[$i] = $course['video_url'];
		    $top_course_header[$i] = $course['header'];
		    $top_course_start_date[$i] = $course['start_date'];
		    $top_course_negotiable[$i] = $course['negotiable'];
		    $top_course_cost[$i] = $course['cost'];
		    
		    break;
		}
	    }
	}


	for($i = 0; $i < 5; $i++) {

	    if($top_courses[$i]==0) continue;
	    
	    $coursecounter_q="SELECT * FROM stucourse WHERE course_id=".$top_courses[$i];
            $coursecounter_r=mysqli_query($connection,$coursecounter_q);
            $coursecounts=mysqli_num_rows($coursecounter_r);


	    $teacher_un_q = 'SELECT username,verified FROM user WHERE id='.$top_course_user_id[$i];
	    $teacher_un_r = mysqli_query($connection,$teacher_un_q);
	    $teacher_un_f = mysqli_fetch_array($teacher_un_r);
	    $teacher_un = $teacher_un_f['username'];
	    $teacher_verified = $teacher_un_f['verified'];
	    
	    echo '<div class="object" onclick="location.href=\'/userpgs/instructor/course_management/course.php?course_id='.$top_courses[$i].'\';">';


            if($top_course_video_url[$i]!=null) {
		$link_text = $top_course_video_url[$i];
		if(strpos($link_text,'youtube.com') !== false) {			    
		    $video_id = get_string_between($link_text,'embed/','" frameborder');
		    echo '<div class="preview"> <img src="https://img.youtube.com/vi/'.$video_id.'/0.jpg">	</div>';
		} elseif(strpos($link_text,'vimeo.com') !== false) {
		    $video_id = get_string_between($link_text,'video/','" frameborder');
		    $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
		    
		    echo '<div class="preview"> <img src="'.$hash[0]['thumbnail_medium'].'"> </div>';
		}
		
	    } else {
		echo '<div class="preview">
				  <svg viewBox="0 0 70 50.8">
				  	<path class="cls-1" d="M659.7,889.3l-1.8-1.1v1.4l-25.4,16a.6.6,0,0,1-.9-.4V895a1.6,1.6,0,0,1,.8-1.4l26.8-16.3a1.1,1.1,0,0,0,.6-1.1h0a1.2,1.2,0,0,0-.7-1l-37.2-18a5.4,5.4,0,0,0-4.8.1l-25.8,13.6a2.2,2.2,0,0,0-1.2,2v12.9a1.1,1.1,0,0,0,.6,1.1L628.5,907a4.5,4.5,0,0,0,4.6-.2l26.6-16.3a.7.7,0,0,0,.4-.6h0A.9.9,0,0,0,659.7,889.3Zm-31,4.8-36.4-19.7a.7.7,0,0,1-.3-1h0a.8.8,0,0,1,1-.3l36.4,19.8a.6.6,0,0,1,.3.9h0A.6.6,0,0,1,628.7,894.1Z" transform="translate(-590.1 -856.7)"/>
				  </svg>
				</div>';
	    }

	    echo '<div class="details">';


	    $ctitle=preg_replace("/<br\W*?\/>/"," ",$top_course_header[$i]);
	    echo '<p><strong>'.$ctitle.'</strong></p>';
	    


	    if($teacher_verified) {
		echo '<div class="little-box teacher-id">'.$teacher_un.' <img src="/images/background/verified.png" style="width:1rem; height:1rem;"></div>';
	    } else {
		echo '<div class="little-box teacher-id">'.$teacher_un.'</div>';
	    }


	    
	    echo '<div class="detail-bottom">
			    	   <div class="detail-row">
				    <div class="little-box blue-bg">
	    '.$coursecounts.' <span>students</span>
				    </div>
				    <div class="little-box"><span>'.date("M jS, Y", strtotime($top_course_start_date[$i])).'</span></div>
				    </div>';
	    

	    if($top_course_cost[$i] > 0) {
		if($top_course_negotiable[$i]) {
		    echo '<div style="display:flex; flex-flow:row nowrap;"><div class="price gold-bg" style="width:50%;"><div class="fxstar-white"></div>'.$top_course_cost[$i].'</div><div style="width:50%;" class="price medseagreen-bg">Negotiable</div></div>';
		} else {
		    echo '<div class="price gold-bg"><div class="fxstar-white"></div>'.$top_course_cost[$i].'</div>';
		}
	    } else {
		echo '<div class="price green-bg" style="padding: 4px 20px;">Free</div>';
	    }			    
	    
	    echo '</div></div></div>';  
	}
	echo '</div></div>';
    }   
}
?>





		<div class="footbar blur"></div>
		<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

		<script>
		 if(screen.width<629) {
		     $('.main-content').css('margin','0').css('padding','0');
		 }
		</script>


		<script>
		 $('#page-header').html('Search');
		 $('#page-header').attr('href','/search');
		</script>

		<div class="footbar"></div>
		<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

		<script>
		 var notifUserId=<?php echo $get_user_id ?>;
		</script>



		<script>
		 $(document).ready(function() {
		     var notifUserId=<?php echo $get_user_id ?>;
		     setInterval(function() {
			 jQuery.ajax({
			     type: 'POST',
			     url: '/php/notif_icon.php',
			     data: {notif_userId: notifUserId},
			     success: function(response) {
				 //var json=$.parseJSON(response);
				 //alert(json.last_notif);
				 //alert(response);
				 if(response==='1') {
				     //alert('its 1');
				     $('#notif_a').addClass('blink');
				 }

				 jQuery.ajax({
				     type: 'POST',
				     url: '/php/msg_icon.php',
				     data: {msg_userId: notifUserId},
				     success: function(result) {
					 if(result>0) {
					     $('#msg_bar').addClass('blink');
					 }
				     }
				 });
			     }
			 });
		     }, 2000);
		 });
		</script>

		<script>
		 $('#nav-search .filled').show();
		 $('#nav-search .stroked').hide();
		</script>

		<script>
		 $('#search-btn').click(function() {
		     $('.search-form').submit();
		 });
		</script>
    </body>
</html>
