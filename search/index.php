<?php
session_start();
require('../register/connect.php');
header("Cache-Control: no cache");

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header('Location: /');
}

if(isset($_POST['search'])) {
	$uname = $_POST['search'];
    $query = "SELECT * FROM user WHERE (username LIKE '%$uname%') OR (fname LIKE '%$uname%') OR (lname LIKE '%$uname%')";
	$search_result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    $search_count=mysqli_num_rows($search_result);
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
<script src="/js/upperbar.js"></script>

<div class="col-33 left-col">
                <div class="col-1">
                <h3>Search</h3>
    <p>Search for fxUsers</p>
                <form method="POST" action="#">
                <input type="text" name="search" autofocus placeholder="Keyword" required>
                <input type="submit" value="Search">
<?php
                if($search_count!='') {
                    echo '<p><b>'.$search_count.'</b> results</p>';
                } elseif($search_count===0) {
                    echo '<p><b>'.$search_count.'</b> results</p>';
                }
?>
                </form>
                </div>
</div>


<?php
                echo '<div class="col-33 mid-col">';
                if($search_result->num_rows > 0) {
                    while($row = $search_result->fetch_assoc()) {
                        echo '<div class="col-1 pointer" onclick="location.href=\'/user/'.$row['username'].'\';">';

                        $path="../userpgs/avatars/";
                        if(file_exists($path.$row['id'].'.jpg')) {
                            echo('<div class="avatar float-left" style="background-image: url(\'../userpgs/avatars/'.$row['id'].'.jpg\');"></div>');
                        } elseif(file_exists($path.$row['id'].'.jpeg')) {
                            echo('<div class="avatar float-left" style="background-image: url(\'../userpgs/avatars/'.$row['id'].'.jpeg\');"></div>');
                        } elseif(file_exists($path.$row['id'].'.png')) {
                            echo('<div class="avatar float-left" style="background-image: url(\'../userpgs/avatars/'.$row['id'].'.png\');"></div>');
                        } elseif(file_exists($path.$row['id'].'.gif')) {
                            echo('<div class="avatar float-left" style="background-image: url(\'../userpgs/avatars/'.$row['id'].'.gif\');"></div>');
                        } else {
                            echo('<div class="avatar float-left"></div>');
                        }
                        
                        echo '<h3>@'.$row['username'].'</h3>';
                        echo '<p><b>'.$row['fname'].' '.$row['lname'].'</b></p>';
                        echo '</div>';
                    }
                    $search_result->free();
                }
                echo '</div>';
?>

<div class="footer"></div>
<script src="/js/footer.js"></script>

<div class="footbar"></div>
<script src="/js/footbar.js"></script>

<script>
    var notifUserId=<?php echo $get_user_id ?>;
</script>
<script src="/js/notif_msg.js"></script>
</body>
</html>