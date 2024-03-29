<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/
session_start();
require('../register/connect.php');

if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $session_id_q="SELECT id FROM user WHERE username='$username'";
        $session_id_r=mysqli_query($connection,$session_id_q) or die(mysqli_error($connection));
        $session_id_fetch=mysqli_fetch_array($session_id_r);
        $session_id=$session_id_fetch['id'];
} else {
    header("Location: /register/logout.php");
}

if(isset($_GET['tar'])) {
  $tarname = rtrim($_GET['tar'], "/");
}

//$tarname = substr(getcwd(), 19);
//$tarname = 'neo';
require('../php/get_tar_user.php');

$user_query = "SELECT * FROM user WHERE username='$tarname'";
$user_result = mysqli_query($connection, $user_query) or die(mysqli_error($connection));
// [CODE] if user does not exist, throw error!
$user_fetch = mysqli_fetch_array($user_result);
$fname = $user_fetch['fname'];
$lname = $user_fetch['lname'];
$id = $user_fetch['id'];
$bio = $user_fetch['bio'];


// fetch the sonet records
//require('../userpgs/sonet/following.php');

// Get the notification!
require('../userpgs/php/notif.php');

// Get the plans!
$get_user_id=$id;
require('../php/get_plans.php');

require('../wallet/php/get_fxcoin_count.php');

require('../php/get_sonet.php');

require('../php/get_tar_rel.php');

require('../php/get_tar_plans.php');

if($get_tar_plans_fxuniversityins) require('../php/get_tar_courses.php');
if($get_tar_plans_fxuniversitystu) require('../php/get_tar_stu.php');

require('../php/get_fxinstructor_profile.php');

require('../php/get_follow_fnd.php');

require('../php/get_partner_profile.php');

require('../php/get_visibility.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>fxUnivers</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/avatar.css">
    <link rel="stylesheet" href="/css/icons.css">
    <link rel="stylesheet" href="/css/logo.css">
    <link rel="stylesheet" href="/css/colors.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
    </head>

<body>

<div class="upperbar"></div>
<script id="upperbar-script" src="/js/upperbar.js" sess_avatar="<?php echo $session_avatar?>" sess_un="<?php echo $username?>"></script>


<div class="col-33 left-col">
                <div class="col-1">

                <!-- AVATAR -->
<?php
                $path="../userpgs/avatars/";
                if(file_exists($path.$get_user_id.'.jpg')) {
                    echo('<div class="avatar" style="margin:auto;background-image: url(\'../userpgs/avatars/'.$get_user_id.'.jpg\'); color: black; font-weight: bold;"></div>');
                } elseif(file_exists($path.$get_user_id.'.jpeg')) {
                    echo('<div class="avatar" style="margin:auto;background-image: url(\'../userpgs/avatars/'.$get_user_id.'.jpeg\'); color: black; font-weight: bold;"></div>');
                } elseif(file_exists($path.$get_user_id.'.png')) {
                    echo('<div class="avatar" style="margin:auto;background-image: url(\'../userpgs/avatars/'.$get_user_id.'.png\'); color: black; font-weight: bold;"></div>');
                } elseif(file_exists($path.$get_user_id.'.gif')) {
                    echo('<div class="avatar" style="margin:auto;background-image: url(\'../userpgs/avatars/'.$get_user_id.'.gif\'); color: black; font-weight: bold;"></div>');
                } else {
                    echo('<div class="avatar" style="margin:auto;"></div>');
                }

                if($username==$tarname) {
                    echo '<input type="submit" value="change avatar" id="showUpButt">';
                }
?>
                
                <div id="upButt" style="display: none; margin-bottom: 20px;">
                <form method="POST" action="/php/upload_avatar.php" enctype="multipart/form-data">
                <input type="file" name="avatar_img" id="avatarFile">
                <input type="hidden" name="username" value="<?php echo $username ?>">
                <br>
                <input type="submit" id="avatarBtn" value="upload">
                </form>

                
                <form method="POST" action="/php/remove_avatar.php">
                <input type="hidden" name="userId" value="<?php echo $get_user_id ?>"/>
                
                <input type="submit" value="remove">
                </form>
                
                
                </div>
                



                
                  <h3><?php echo '@'.$tarname ?></h3>
                  <p><b><?php echo $tar_fname.' '.$tar_lname ?></b></p>
                  <p><?php echo $tar_bio ?></p>

<?php
                if($username==$tarname) {
?>              
                  <input type="submit" id="edit" value="Edit bio">

<div class="col-1" style="display:none" id="editcol">
                <form method="POST" action="/php/set_bio.php">
                    <input type="hidden" name="username" value="<?php echo $username?>">
                    <input type="text" name="fname" placeholder="first name" value="<?php echo $fname?>" required><br>
                    <input type="text" name="lname" placeholder="last name" value="<?php echo $lname?>" required><br>
                    <input type="text" name="bio" placeholder="bio" value="<?php echo $bio?>"><br>
                    <input type="hidden" name="user_id" value="<?php echo $get_user_id?>">
                    <input type="submit" value="Update">
                </form>
                <input type="submit" id="canceledit" value="Cancel">
</div>
<?php
                }
?>

                
                </div>


                <div class="col-1 pointer" onclick="location.href='/userpgs/rel?tar=<?php echo $tarname?>';">
                <h3>fxFriends</h3>
                <p><?php echo $get_rel_friends_count ?> friends</p>
                </div>
<!--
                <div class="col-1 pointer" onclick="location.href='/search';">
                <h3>Search</h3>
                <p>Click to search for fxUsers</p>
                </div>
-->
</div>









<div class="col-33 mid-col">
<?php
                if($username==$tarname || $vis['fxstar']) {
?>
                <div class="col-1 pointer" style="cursor:not-allowed">
<div class="main fxstar-color"></div>
    <div class="icon col-icon fxstar-bg"></div>
                <h3>fxStar</h3>
                <p><b><?php echo $get_fxcoin_count?></b> fxStars</p>
                </div>
<?php
                }
?>


                
<?php
                if($username==$tarname || $vis['fxinstructor']) {
?>
                <div class="col-1 pointer" onclick="location.href='/userpgs/instructor/profile/?tar=<?php echo $tarname?>';">
                    <div class="main fxuniversity-color"></div>
                      <div class="icon col-icon fxuniversity-bg"></div>
                <h3>fxUniversity instructor</h3>
<?php
                /*if($get_fxins_prof_info!='') {
                    echo '<p>'.$get_fxins_prof_info.'</p>';
                    }*/
                echo '<p><b>'.$get_tar_courses_count.' courses published</b></p>';
?>
                <p>Click to see the courses</p>
                </div>
<?php
                }
?>

                
<?php
                if($username==$tarname || $vis['fxstudent']) {
?>
                <div class="col-1 pointer" onclick="location.href='/userpgs/student/profile?tar=<?php echo $tarname?>';">
                    <div class="main fxuniversity-color"></div>
                      <div class="icon col-icon fxuniversity-bg"></div>
                <h3>fxUniversity student</h3>
                <p><b><?php echo $gts_count ?> courses taken</b></p>
                <p>Click to see the courses</p>
                </div>
<?php
                }
?>

<?php
                if($username==$tarname || $vis['fxpartner']) {
                    $pTotal=0;
                    while($row=$get_partner_result->fetch_assoc()) {
                        $pTotal+=$row['income'];
                    }
?>

                <div class="col-1 pointer" style="cursor:not-allowed">
                    <div class="main fxpartner-color"></div>
                    <div class="icon col-icon fxpartner-bg"></div>
                <h3>fxPartner</h3>
                <p><b><?php echo $pTotal?> fxStars earned</b></p>
                </div>
<?php
                }
?>
<?php
                if(!$vis['fxstar'] && !$vis['fxinstructor'] && !$vis['fxstudent'] && !$vis['fxpartner']) {
                    echo '<div class="col-1">';
                    echo '<p>No cards are shared</p>';
                    echo '</div>';
                }
?>
</div>

                

<div class="col-33 right-col">

<?php
                if($username==$tarname) {
                    if($vis['fxstar']) {
                        $fxstarval='Hide fxStars';
                        $fxstarcolor='#F4D86660';
                    } else {
                        $fxstarval='Show fxStars';
                        $fxstarcolor='#d9d8d8';
                    }

                    if($vis['fxinstructor']) {
                        $fxinstructorval='Hide fxUniversity Instructor';
                        $fxinstructorcolor='#D4B1FC60';
                    } else {
                        $fxinstructorval='Show fxUniversity Instructor';
                        $fxinstructorcolor='#d9d8d8';
                    }

                    if($vis['fxstudent']) {
                        $fxstudentval='Hide fxUniversity Student';
                        $fxstudentcolor='#A7A0FF60';
                    } else {
                        $fxstudentval='Show fxUniversity Student';
                        $fxstudentcolor='#d9d8d8';
                    }

                    if($vis['fxpartner']) {
                        $fxpartnerval='Hide fxPartner';
                        $fxpartnercolor='#B1FBB360';
                    } else {
                        $fxpartnerval='Show fxPartner';
                        $fxpartnercolor='#d9d8d8';
                    }
                
?>

                    <div class="col-1 pointer" onclick="location.href='/register/logout.php';">
                    <h3>Logout</h3>
                    </div>
<div class="col-1">
<h3>Visibility</h3>
<p>Choose to show/hide your cards to others</p>
<!--<input type="submit" id="fxstar" value="<?php echo $fxstarval ?>" style="background:<?php echo $fxstarcolor?>"><br>-->
<input type="submit" id="fxinstructor" value="<?php echo $fxinstructorval ?>" style="background:<?php echo $fxinstructorcolor?>">
<input type="submit" id="fxstudent" value="<?php echo $fxstudentval ?>" style="background:<?php echo $fxstudentcolor?>">
<input type="submit" id="fxpartner" value="<?php echo $fxpartnerval ?>" style="background:<?php echo $fxpartnercolor?>">
</div>
<?php
                }
?>
                    

                
                
<?php
                if($tarname!=$username) {
                    echo '<div class="col-1 pointer" onclick="setFriend()" id="friendSet">';
                    echo '<h3>fxFriendship</h3>';
                    echo '<p id="friendship">';
                    
                    if($get_fnd_count==0) {
                        echo 'Click to send Friend Request';
                    } else {
                        if($get_fnd==1) {
                            echo 'Click to Unfriend';
                        } else {
                            echo 'Click to cancel Friend Request';
                        }
                    }
                    echo '</p>';
                    echo '</div>';


                    if($get_fnd==1) {
                        $msgUrl='location.href=\'/msg/'.$tarname.'\';';
                    } else {
                        $msgUrl='fndOnly()';
                    }

                    echo '<div class="col-1 pointer" onclick="'.$msgUrl.'">
                         <h3>Send Message</h3>
                         <p>Click to send messages</p>
                         <p>(friends-only)</p>
                         </div>';
                }
                



                
?>                
</div>


<div class="footer"></div>
<script src="/js/footer.js"></script>
<div class="footbar"></div>
<script src="/js/footbar.js"></script><script src="/js/notif_msg.js" id="notmsg" nmuid="<?php echo $get_user_id?>"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>





<script>
$(document).ready(function() {
    $('#showUpButt').click(function() {
        $('#upButt').toggle();
    });
});
</script>


<script>
function setFriend() {
    var requesterId=<?php echo $session_id ?>;
    var requesteeId=<?php echo $tar_id ?>;
    var requesterUn='<?php echo $username ?>';
    $.ajax({
      type: 'POST',
      url: '/php/set_friend.php',
            data: {requester: requesterId, requestee: requesteeId, requesterU: requesterUn},
      success: function(result) {
            //var results=jQuery.parseJSON(result);
            if(result==0) {
                document.getElementById('friendship').innerHTML='Click to cancel Friend Request';
            } else if(result==1) {
                document.getElementById('friendship').innerHTML='Click to send Friend Request';
            }
      }
    });
}
</script>

<script>
                function fndOnly() {
                    alert("Messaging is for friends-only");
                }
</script>



<!-- VISIBILITY -->
<script>
                $(document).ready(function() {
                    $('#fxstar').click(function(e) {
                        e.preventDefault();
                        jQuery.ajax({
                          type:'POST',
                                url:'/php/set_visibility.php',
                                data: {userId:<?php echo $get_user_id?>,card:"fxstar"},
                                success: function(response) {
                                if($('#fxstar').val()=='Hide fxStars') {
                                    $('#fxstar').css('background-color', '#d9d8d8');
                                    $('#fxstar').val('Show fxStars');
                                } else {
                                    $('#fxstar').css('background-color', '#F4D86660');
                                    $('#fxstar').val('Hide fxStars');
                                }
                            }
                        });
                    });
                });
                            
</script>
<script>
                $(document).ready(function() {
                    $('#fxinstructor').click(function(e) {
                        e.preventDefault();
                        jQuery.ajax({
                          type:'POST',
                                url:'/php/set_visibility.php',
                                data: {userId:<?php echo $get_user_id?>,card:"fxinstructor"},
                                success: function(response) {
                                if($('#fxinstructor').val()=='Hide fxUniversity Instructor') {
                                    $('#fxinstructor').css('background-color', '#d9d8d8');
                                    $('#fxinstructor').val('Show fxUniversity Instructor');
                                } else {
                                    $('#fxinstructor').css('background-color', '#D4B1FC60');
                                    $('#fxinstructor').val('Hide fxUniversity Instructor');
                                }
                            }
                        });
                    });
                });
                            
</script>
                <script>
                $(document).ready(function() {
                    $('#fxstudent').click(function(e) {
                        e.preventDefault();
                        jQuery.ajax({
                          type:'POST',
                                url:'/php/set_visibility.php',
                                data: {userId:<?php echo $get_user_id?>,card:"fxstudent"},
                                success: function(response) {
                                if($('#fxstudent').val()=='Hide fxUniversity Student') {
                                    $('#fxstudent').css('background-color', '#d9d8d8');
                                    $('#fxstudent').val('Show fxUniversity Student');
                                } else {
                                    $('#fxstudent').css('background-color', '#A7A0FF60');
                                    $('#fxstudent').val('Hide fxUniversity Student');
                                }
                            }
                        });
                    });
                });
                            
</script>
<script>
                $(document).ready(function() {
                    $('#fxpartner').click(function(e) {
                        e.preventDefault();
                        jQuery.ajax({
                          type:'POST',
                                url:'/php/set_visibility.php',
                                data: {userId:<?php echo $get_user_id?>,card:"fxpartner"},
                                success: function(response) {
                                if($('#fxpartner').val()=='Hide fxPartner') {
                                    $('#fxpartner').css('background-color', '#d9d8d8');
                                    $('#fxpartner').val('Show fxPartner');
                                } else {
                                    $('#fxpartner').css('background-color', '#B1FBB360');
                                    $('#fxpartner').val('Hide fxPartner');
                                }
                            }
                        });
                    });
                });
</script>

<?php
                if($username==$tarname) {
?>
                    <script type="text/javascript">
function setUsername() {
    if($('#username').val()!='<?php echo $username?>') {
        var enteredUN = document.getElementById('username').value;
        var UNlen = enteredUN.length;
        jQuery.ajax({
          type:'POST',
                url:'/php/dup_username.php',
                data:$('#username').serialize(),
                success: function(data) {
                if(data=='dup' && UNlen!=0) {
                    $('#dupUN').show();
                    $('#nonDupUN').hide();
                    $('#fewCh').hide();
                    $('#username').val('');
                    $('#username').focus();
                } else {
                    $('#dupUN').hide();
                    if(UNlen>0 && UNlen<3) {
                        $('#fewCh').show();
                        $('#nonDupUN').hide();
                        $('#username').focus();
                    } else {
                        if(UNlen==0) {
                            $('#nonDupUN').hide();
                        } else {
                            $('#nonDupUN').show();
                        }
                        //$('#nonDupUN').hide();
                        $('#fewCh').hide();
                    }
                }
            }
        });
    }
}
</script>
<?php
                }
?>





                <script>
                $(document).ready(function() {
                    $('#edit').click(function(e) {
                        e.preventDefault();
                        $('#editcol').toggle();
                    });
                });
                </script>

                <script>
                $(document).ready(function() {
                    $('#canceledit').click(function(e) {
                        e.preventDefault();
                        $('#editcol').hide();
                    });
                });
                </script>
</body>
</html>