<?php
// Requiring https
if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}
	
session_start();
require('register/connect.php');

if(isset($_SESSION['username'])) {
	$registered=true;
	header("Location: /userpgs");
	exit();
}

if(isset($_GET['err'])) {
  $error=$_GET['err'];
}

if(isset($_GET['msg'])) {
  $msg=$_GET['msg'];
}

if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $username=$_COOKIE['username'];
    $password=$_COOKIE['password'];


    $login_query = "SELECT * FROM user WHERE ((username='$username' and password='$password') or (email='$username' and password='$password'))";
    $login_result = mysqli_query($connection, $login_query);

    $login_count = mysqli_num_rows($login_result);

    if($login_count == 1) {
	
	if(strpos($username, '@') !== false) {
	    $uname_query = "SELECT * FROM user WHERE email='$username'";
	    $uname_result = mysqli_query($connection, $uname_query) or die(mysqli_error($connection));
	    $uname_fetch = mysqli_fetch_array($uname_result);
	    $username = $uname_fetch['username'];
	}

	$_SESSION['username'] = $username;

	if(1) {
            setcookie('username',$username,time()+60*60*24*30,'/');
            setcookie('password',$password,time()+60*60*24*30,'/');
	} else {
            setcookie("username","");
            setcookie("password","");
	}
	
	header('Location: /userpgs');
	//exit;
	
    } else {
	header('Location: /?err=wup&un='.$username);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>fxUnivers</title>
  <link rel="stylesheet" type="text/css" href="/css/styles.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="/js/jquery-3.4.1.min.js"></script>
</head>
<body>
  <div class="login-container">
    <div class="login-form">
      <div class="fxunivers-logo">
        <img src="/images/logos/fxunivers-logo.svg">
        <svg viewBox="0 0 1004.44287 228.02734">
	  <g>
	    <path d="M169.87939,440.29a17.98355,17.98355,0,0,1,5.3711-13.123,17.25885,17.25885,0,0,1,12.69531-5.43164,12.45463,12.45463,0,0,1,8.728,3.17383,10.85018,10.85018,0,0,1,3.479,8.42285q0,11.22949-10.98633,16.23535,5.49316,2.19728,7.69043,2.19727,7.69044,0,11.71875-13.36719,4.02833-13.3667,13.06153-62.92676l12.10791-65.18554H212.3999l-.24609.24414h-.73633q-6.99243,0-6.99219-5.354,0-6.85181,7.45752-6.853h23.84033l.24415.00976q5.73339-38.21191,14.15039-50.05664a35.56364,35.56364,0,0,1,13.66064-11.23047,39.19214,39.19214,0,0,1,17.07813-4.03027q12.05933,0,20.18164,5.85937,8.12256,5.85938,8.12353,14.89258,0,8.5459-5.53906,13.54981a18.06684,18.06684,0,0,1-12.42822,5.00488,12.56024,12.56024,0,0,1-8.79834-3.19873,10.94216,10.94216,0,0,1-3.50782-8.49317q0-10.82884,10.83008-16.123a18.47365,18.47365,0,0,0-7.75342-2.21436q-6.30028,0-9.63427,6.64307-.98951,2.0061-3.36231,14.34912-2.37523,12.34571-4.52637,23.55225-2.15112,11.206-2.0332,11.48584h27.08985q6.9873,0,6.98681,5.10986,0,7.0979-7.50537,7.09717c-.16406,0-.24609-.04-.24609-.12207,0-.08008-.082-.12207-.2461-.12207H259.93848q-13.57545,78.22045-19.19922,99.93945a140.47836,140.47836,0,0,1-8.99512,24.9209,53.01138,53.01138,0,0,1-14.46533,17.834q-9.96753,8.0625-20.42188,8.0625a33.72612,33.72612,0,0,1-18.61572-5.37109A17.22735,17.22735,0,0,1,169.87939,440.29Z" transform="translate(-169.87939 -233.01465)"></path>
	    <path d="M287.79932,393.90332q0-7.22607,4.49218-11.2793a14.53339,14.53339,0,0,1,9.96094-4.05273,10.17943,10.17943,0,0,1,6.88477,2.49023,8.39876,8.39876,0,0,1,2.88086,6.68946q0,9.57129-10.15625,13.3789a12.35623,12.35623,0,0,0,8.10547,3.22266q7.42016,0,12.01171-9.17969,2.83155-4.98047,8.93555-30.0293,6.1018-25.04881,6.10352-29.63867,0-5.17529-2.97852-7.4707a11.12181,11.12181,0,0,0-6.98242-2.29492q-7.42236,0-14.55078,6.20117a36.27655,36.27655,0,0,0-10.44922,15.57617q-1.17187,3.61377-2.09961,4.49219-.92944.87891-3.75977,1.07422h-.97656q-5.17749,0-5.17578-3.125,0-2.4397,2.39258-7.32422a60.79139,60.79139,0,0,1,6.78711-10.498,37.03475,37.03475,0,0,1,12.207-9.71679,35.59627,35.59627,0,0,1,16.79687-4.10157q16.40625,0,24.60938,10.83985,10.34985-10.83986,20.60547-10.83985a25.18765,25.18765,0,0,1,15.18554,4.78516,15.39976,15.39976,0,0,1,6.5918,13.18359q0,7.22827-4.49219,11.32813a14.44222,14.44222,0,0,1-9.96093,4.10156,9.85494,9.85494,0,0,1-6.98243-2.58789,8.83314,8.83314,0,0,1-2.7832-6.78711q0-9.56982,10.25391-13.37891a12.47227,12.47227,0,0,0-8.20313-3.22265,11.7113,11.7113,0,0,0-5.22461,1.17187,11.29175,11.29175,0,0,0-4.39453,4.39453q-2.00244,3.22266-3.418,6.10352a58.17425,58.17425,0,0,0-3.125,8.69141q-1.70947,5.811-2.68554,9.81445-.97706,4.00562-2.88086,12.01172-1.90429,8.00831-3.07617,12.59765-2.44189,9.57129-2.44141,13.96485,0,5.17676,3.125,7.51953a11.56747,11.56747,0,0,0,7.12891,2.34375q7.42016,0,14.502-6.20117a37.45514,37.45514,0,0,0,10.498-15.38086,6.04873,6.04873,0,0,0,.39062-1.22071,3.81721,3.81721,0,0,1,.39063-1.123,3.89225,3.89225,0,0,0,.39062-.87891,7.13766,7.13766,0,0,1,.293-.78125,6.71392,6.71392,0,0,1,.39062-.63476,1.18341,1.18341,0,0,1,.6836-.53711,3.71826,3.71826,0,0,0,.78125-.293,2.05262,2.05262,0,0,1,.92773-.19531h2.49024q5.17528,0,5.17578,3.02734,0,7.42236-10.98633,19.53125-10.98633,12.10986-27.00195,12.10937-17.38331,0-25-10.83984h-.19532q-8.78906,10.83984-20.41015,10.83984a25.04854,25.04854,0,0,1-14.99024-4.73632A15.27221,15.27221,0,0,1,287.79932,393.90332Z" transform="translate(-169.87939 -233.01465)"></path>
	    <path d="M429.69385,375.58984q0-5.57592,2.88232-17.22265l13.37891-53.8086,5.61377-22.084q-3.80859-.38671-11.81641-.3877h-3.418q-5.17749,0-5.17578-4.28613a7.03821,7.03821,0,0,1,.293-1.99267,5.30907,5.30907,0,0,1,1.709-2.2417,5.48552,5.48552,0,0,1,3.75977-1.24512c.39063,0,.96.03369,1.709.09766.74756.06543,1.31836.09765,1.709.09765q13.96436.39845,23.4375.39844h2.53906q8.0061,0,14.99024-.09961,6.9807-.09814,10.98632-.19824,4.00342-.10035,4.88282-.10059,4.78344,0,4.78515,3.8877,0,5.68359-6.25,5.68261H485.40674a11.93609,11.93609,0,0,0-2.39258.18946q-.87891.1875-1.66016.3291a3.38147,3.38147,0,0,0-1.2207.42578,7.703,7.703,0,0,1-.83008.47168,1.22453,1.22453,0,0,0-.58593.75537c-.13135.37842-.229.66065-.293.8501-.06543.189-.16309.58105-.293,1.1792a13.60146,13.60146,0,0,1-.39063,1.46338l-15.13818,62.79736q-.45777,1.89771-1.9668,8.15771-1.511,6.26221-2.44629,9.52588-.93824,3.26587-1.875,7.77881a38.90624,38.90624,0,0,0-.937,7.73633q0,11.231,6.78711,15.918,6.78661,4.6875,16.55274,4.6875a52.5543,52.5543,0,0,0,17.08984-2.832q8.29906-2.83155,16.89453-11.03516a53.22853,53.22853,0,0,0,13.18359-21.1914q1.75782-4.98048,3.02735-10.15625l18.83252-75.19825q-4.98048-1.7622-14.25782-1.85254-5.76342,0-5.76171-4.08789,0-5.67627,5.5664-5.67773.58594,0,3.71094.19971,3.12378.19922,8.49609.29931,5.37159.10035,11.627.09912,7.61718,0,14.11279-.19824,6.49365-.19921,7.666-.20019,4.58936,0,4.58984,3.88671,0,5.68066-5.76172,5.6792-4.00488,0-7.03125.1875a21.5984,21.5984,0,0,0-4.98047.79834q-1.9541.61085-3.07617.89258a3.55222,3.55222,0,0,0-1.9043,1.21924,7.59227,7.59227,0,0,0-.97656,1.36084,12.54959,12.54959,0,0,0-.53857,1.79736q-.34352,1.374-.43457,1.752l-17.502,70.01367q-6.64014,26.37158-23.334,40.043-16.59814,13.77246-40.811,13.77148-20.60156,0-34.02539-9.65625Q429.6919,394.61035,429.69385,375.58984Z" transform="translate(-169.87939 -233.01465)"></path>
	    <path d="M578.13135,349.7627a25.35135,25.35135,0,0,1,.68359-3.51563,64.42593,64.42593,0,0,1,2.49024-7.71484,54.38532,54.38532,0,0,1,4.49218-9.17969,25.61519,25.61519,0,0,1,7.27539-7.61719,17.1281,17.1281,0,0,1,10.0586-3.22265,28.95885,28.95885,0,0,1,12.74414,3.22265A18.01225,18.01225,0,0,1,625.104,332.5752q13.72413-14.15846,30.46436-14.25782,12.74853,0,20.24365,5.51758,7.49342,5.51806,7.49512,17.334,0,9.96093-8.20313,32.86132-8.20312,22.90137-8.20312,26.51368,0,3.80859,3.15527,3.80859,4.77979,0,9.36621-5.66406a38.60879,38.60879,0,0,0,6.5835-12.54883q2.39063-7.37256,3.36621-8.252a8.97613,8.97613,0,0,1,4.68164-.97657q4.97607,0,5.07324,3.418,0,3.02784-3.16894,10.00977-3.16992,6.98291-10.72656,14.209-7.55787,7.22754-16.81983,7.22656a23.0709,23.0709,0,0,1-14.4668-4.834A15.78685,15.78685,0,0,1,647.6626,393.708q0-3.61232,7.71484-24.707,7.71314-21.09375,7.71485-32.03125,0-11.22876-9.17969-11.23047-14.937,0-26.18848,16.63379a33.97622,33.97622,0,0,0-4.65576,11.05615Q613.02027,392.76978,611.5376,398.583q-1.48536,5.81543-3.03516,7.75586a12.13075,12.13075,0,0,1-10.15625,5.43554,9.456,9.456,0,0,1-6.34765-2.34375,7.60355,7.60355,0,0,1-2.73438-6.05468,33.24545,33.24545,0,0,1,1.07422-5.85938l12.56885-50.39844q2.8308-11.61548,2.73437-15.228,0-5.95533-3.79492-5.95557-3.79469,0-6.57666,5.71289a68.99006,68.99006,0,0,0-4.58984,12.5,59.78245,59.78245,0,0,1-2.19727,7.373q-1.17187,1.563-5.37109,1.5625h-.293Q578.13135,353.083,578.13135,349.7627Z" transform="translate(-169.87939 -233.01465)"></path>
	    <path d="M708.11133,349.7627q0-3.00734,3.07617-9.94727,3.07617-6.93971,10.69336-14.12061,7.61718-7.18212,16.79687-7.18212A22.247,22.247,0,0,1,753.375,323.585a16.044,16.044,0,0,1,6.10352,12.89649q0,4.78564-10.69336,31.93359Q738.0918,395.56446,738.0918,400.544q0,3.80859,3.22265,3.80859,4.06349,0,7.78028-3.90625a28.51787,28.51787,0,0,0,5.64941-8.39844q1.93214-4.49121,3.56836-8.88672a44.21921,44.21921,0,0,1,1.833-4.58984q1.18506-1.36669,4.24609-1.46484h1.18457q4.83838,0,5.03516,3.22265a17.60018,17.60018,0,0,1-1.18653,4.78516,49.359,49.359,0,0,1-3.80859,8.00781,58.168,58.168,0,0,1-6.083,8.69141,31.0472,31.0472,0,0,1-8.70312,7.03125,22.5544,22.5544,0,0,1-11.17578,2.92968,23.1669,23.1669,0,0,1-14.502-4.834,15.77233,15.77233,0,0,1-6.29882-13.23242q0-4.78419,10.69336-31.88477,10.69335-27.0996,10.69335-32.08008,0-3.80859-3.32031-3.80859-4.98047,0-10.2539,7.08154a39.18338,39.18338,0,0,0-4.6875,8.45948,39.92733,39.92733,0,0,0-2.09961,6.5415,8.54313,8.54313,0,0,1-1.61133,3.78564q-1.17187,1.47657-4.00391,1.47559h-1.26953Q708.11035,353.27832,708.11133,349.7627ZM742.877,284.52832a12.64954,12.64954,0,0,1,4.36719-9.47266,13.9936,13.9936,0,0,1,9.82715-4.10156,9.87987,9.87987,0,0,1,7.14551,2.7832,9.08347,9.08347,0,0,1,2.8789,6.78711q0,4.98048-4.26757,9.27735a13.675,13.675,0,0,1-10.0254,4.29687,9.8949,9.8949,0,0,1-7.09668-2.68554A9.07369,9.07369,0,0,1,742.877,284.52832Z" transform="translate(-169.87939 -233.01465)"></path>
	    <path d="M779.20508,349.627q0-1.94311,1.9043-6.75683a66.31415,66.31415,0,0,1,5.37109-10.40479,32.52508,32.52508,0,0,1,9.668-9.772,23.5569,23.5569,0,0,1,13.42773-4.18066,22.90179,22.90179,0,0,1,14.59961,4.88574A15.63061,15.63061,0,0,1,830.377,336.312q0,3.62329-7.1289,23.00733-7.1294,19.38428-7.12891,30.34765,0,14.68506,12.68457,14.68555,7.4253,0,13.77442-7.34277a52.87106,52.87106,0,0,0,9.76855-16.83789q3.419-9.49659,5.32324-16.7417,1.90429-7.24439,1.90625-9.20264,0-6.16626-5.81054-11.79688-5.811-5.62792-5.81055-9.83886,0-5.11084,4.39453-9.69239a13.58081,13.58081,0,0,1,10.05859-4.582q4.78419,0,8.69141,4.15821,3.90528,4.15869,3.90625,13.05371a78.0783,78.0783,0,0,1-1.5332,13.01709,139.39511,139.39511,0,0,1-5.29395,19.478,136.56337,136.56337,0,0,1-8.90137,20.65137,53.29369,53.29369,0,0,1-13.4541,16.34473,28.09855,28.09855,0,0,1-18.10156,6.7539,50.93344,50.93344,0,0,1-11.43359-1.22265,37.56679,37.56679,0,0,1-10.07032-3.91406,18.96661,18.96661,0,0,1-7.541-8.02149,27.79708,27.79708,0,0,1-2.77246-12.96191q0-10.66992,7.61718-31.47412,7.61719-20.80518,7.61719-24.62305,0-3.81811-3.125-3.81787-4.00488,0-8.83789,5.11474-4.834,5.11524-8.64258,17.60547-.78222,3.05127-1.85547,3.83789a6.068,6.068,0,0,1-3.51562.78565H783.4043Q779.20459,353.083,779.20508,349.627Z" transform="translate(-169.87939 -233.01465)"></path>
	    <path d="M891.60742,376.66113a57.30035,57.30035,0,0,1,16.56641-41.07373q16.56591-17.269,42.10058-17.27,11.064,0,17.94727,5.39991a17.14177,17.14177,0,0,1,6.88184,14.15722q0,11.45582-10.03418,18.99414-11.94727,9.00879-44.24707,9.105H916.418q-3.22851,13.89551-3.22852,20.01465,0,8.93994,4.54981,13.65235,4.55127,4.7124,12.47558,4.71191a48.505,48.505,0,0,0,34.15821-13.50586q.7749-.77637,1.6455-1.7002a15.065,15.065,0,0,1,1.35645-1.31054,6.361,6.361,0,0,0,.92773-.92285,1.7745,1.7745,0,0,1,.79493-.63184,3.40069,3.40069,0,0,1,.88379-.09766q1.5996,0,3.55664,2.18653,1.9541,2.18555,1.95605,3.83789a6.854,6.854,0,0,1-1.57031,3.3916,25.88625,25.88625,0,0,1-5.28125,5.06445,48.95466,48.95466,0,0,1-8.75488,5.25977,60.11712,60.11712,0,0,1-13.03711,4.13086,81.89526,81.89526,0,0,1-17.22266,1.71972q-17.69678,0-27.85938-9.24218Q891.60547,393.28906,891.60742,376.66113Zm26.86621-18.10937q44.61768,0,44.61817-20.7749a11.3334,11.3334,0,0,0-3.57227-8.73731,13.08223,13.08223,0,0,0-9.24512-3.30029,28.96315,28.96315,0,0,0-5.13769.48535,27.82536,27.82536,0,0,0-6.80078,2.47656,29.9089,29.9089,0,0,0-7.584,5.29,38.5417,38.5417,0,0,0-6.89648,9.65869A59.26971,59.26971,0,0,0,918.47363,358.55176Z" transform="translate(-169.87939 -233.01465)"></path>
	    <path d="M991.80273,349.7627q.19484-1.17187.6836-3.32032.48779-2.14673,2.39258-7.51953a47.388,47.388,0,0,1,4.49218-9.47265,28.32549,28.32549,0,0,1,7.17774-7.51954,16.75436,16.75436,0,0,1,10.2539-3.418q13.96435,0,20.80079,11.03515,11.81543-11.22876,25.78125-11.23047a32.49042,32.49042,0,0,1,17.38281,4.6875,15.6157,15.6157,0,0,1,3.32031,24.16992,13.53234,13.53234,0,0,1-10.15625,4.541,9.49376,9.49376,0,0,1-7.17773-2.68555,9.25693,9.25693,0,0,1-2.58789-6.68945q0-8.78906,9.57031-12.98828a19.14622,19.14622,0,0,0-10.74219-3.61328,20.855,20.855,0,0,0-9.52148,2.29492,24.01209,24.01209,0,0,0-7.42188,5.61523,67.0047,67.0047,0,0,0-4.58984,5.81055,25.04841,25.04841,0,0,0-2.29492,3.85742,25.40506,25.40506,0,0,0-1.5625,6.05469l-12.59766,50q-2.833,12.40284-12.98828,12.40234a9.35574,9.35574,0,0,1-6.44531-2.34375,7.72649,7.72649,0,0,1-2.63672-6.05468,21.63639,21.63639,0,0,1,.8789-5.07813l13.37891-52.92969q2.24561-9.76391,2.14844-13.28125,0-6.15234-3.8086-6.15234-3.61377,0-6.49414,5.71289a60.40188,60.40188,0,0,0-4.58984,12.5q-1.70947,6.78882-2.09961,7.17774-1.17187,1.75781-4.19922,1.75781h-1.66016Q991.80273,353.083,991.80273,349.7627Z" transform="translate(-169.87939 -233.01465)"></path>
	    <path d="M1093.56055,391.55957a15.93852,15.93852,0,0,1,4.19922-11.32812,13.39913,13.39913,0,0,1,10.15625-4.49219,9.98605,9.98605,0,0,1,7.1289,2.57129,8.59333,8.59333,0,0,1,2.73438,6.5459,14.75648,14.75648,0,0,1-2.39258,7.5664,13.43362,13.43362,0,0,1-7.666,5.72266q6.835,6.10986,18.65235,6.207,15.23438,0,21.5332-6.53711,6.29883-6.53613,6.29883-12.92871a8.99907,8.99907,0,0,0-3.42578-7.21436,18.20875,18.20875,0,0,0-7.46582-3.82666q-4.04151-.97046-9.91211-2.17285a49.08183,49.08183,0,0,1-8.2002-2.18359,25.9453,25.9453,0,0,1-10.498-6.95508q-4.73732-4.99365-4.73633-12.83105a26.44224,26.44224,0,0,1,1.51367-8.188,46.82924,46.82924,0,0,1,5.07812-10.18506q3.564-5.603,11.47461-9.30762,7.91016-3.70386,18.94532-3.70508,12.4746,0,19.9082,5.0293,7.43408,5.031,7.43555,13.13477,0,6.64233-4.124,10.2539a12.99674,12.99674,0,0,1-8.65039,3.61328,8.70784,8.70784,0,0,1-6.35547-2.39258,7.80883,7.80883,0,0,1-2.45215-5.81054q0-7.42017,8.00293-11.23047a20.86387,20.86387,0,0,0-14.35058-5.17578q-11.62207,0-16.3086,5.10547-4.6875,5.10424-4.6875,9.93066a7.0199,7.0199,0,0,0,2.11622,5.29,12.81863,12.81863,0,0,0,6.04687,3.17236q3.61524.8518,9.09473,1.91358a65.41967,65.41967,0,0,1,9.26367,2.40771,31.72948,31.72948,0,0,1,12.167,8.0874q5.54883,5.73048,5.54981,14.94288a29.57261,29.57261,0,0,1-1.918,9.94873,45.72889,45.72889,0,0,1-6.3418,11.36914q-4.42383,6.02782-13.66406,9.94726-9.24171,3.91846-21.92383,3.91992-14.84472,0-23.53516-5.51757Q1093.55957,400.74023,1093.56055,391.55957Z" transform="translate(-169.87939 -233.01465)"></path>
	  </g>
	</svg>
        <p>Universe of Possibilities</p>
      </div>
      <h2>Log in to fxUnivers</h2>
      <form action="/php/login.php" method="POST">
	<input class="login-input" type="text" placeholder="Username or Email" name="username" <?php if(isset($_GET['un'])) echo 'value="'.$_GET['un'].'"'; ?> required>
	<input class="login-input" type="password" name="password" placeholder="Password" required>

	<label class="checkbox remember-me">Remember me
        <input type="checkbox" name="rememberme" value="remember">
        <span class="checkmark"></span></label>


	
	<?php 
	 if(isset($_GET['err']) && $_GET['err']=='wup') {
	 echo '<p class="red">Wrong username or password.</p>';
}
?>
	<a class="login-forgot" id="open-forgot-overlay">Forgot your password?</a>
	<input type="submit" class="login-button" value="Log in" id="desktop-login-btn">
      </form>
      
      <a class="login-button" id="goto-login">Login</a>
      <a class="signup-button" id="goto-signup">Sign up</a>
    </div>
      
    <div class="login-description">
      <div class="login-text">
        <div class="fx-icon fxstar-icon"><span>fxStar</span><p>Purchase products/services, or send/recieve as gift</p></div>
        <div class="fx-icon fxuniversity-icon"><span>fxUniversity</span><p>Create courses as instructor & make fxStars, or browse to take them as student</p></div>
        <div class="fx-icon fxpartner-icon"><span>fxPartner</span><p>Partner us & make easy fxStars</p></div>
        <div class="fx-icon fxuniverse-icon"><span>fxUniverse</span><p>Universe of trading (Coming soon for public)</p></div>
        <div class="fx-icon fxsonet-icon"><span>fxSonet</span><p>Next level of worldwide connection (Coming soon for public)</p></div>
      </div>
    </div>
  </div>


<!------ LOGIN OVERLAY ------->
<div class="overlay-container" style="display:none" id="login-overlay">
<div class="overlay">
<div class="close-btn" id="login-close-btn">×</div>
  <h1>Login</h1>
  <form action="/php/login.php" method="POST">
    <input class="txt-input" type="text" placeholder="Username or Email" name="username" <?php if(isset($_GET['un'])) echo 'value="'.$_GET['un'].'"'; ?> required>
    <input class="txt-input" type="password" name="password" placeholder="Password" required>

    <label class="checkbox">Remember me
        <input type="checkbox" name="rememberme" value="remember">
        <span class="checkmark"></span></label>
    
    <?php 
	 if(isset($_GET['err']) && $_GET['err']=='wup') {
	 echo '<p class="red">Wrong username or password.</p>';
	 }
    ?>
    <a class="mob-login-forgot" id="open-forgot-overlay-mob">Forgot your password?</a>
    <input type="submit" class="login-button" value="Log in">
  </form>

  

</div>
</div>

<!---------------- Signup Overlay ---------------->
  <div class="overlay-container" style="display:none" id="signup-overlay">
  
    <div class="overlay">
    <div class="close-btn" id="signup-close-btn">×</div>
      <h1 id="overlay-title">Create Account</h1>
      <form autocomplete="off" id="regForm">

        <input class="signup-input" type="text" name="email" placeholder="Email" id="deskEmail">
	<p class="tooltip red" id="dupEmail">This email is already used.</p>
        <p class="tooltip red"  id="badEmail">Invalid email address</p>


        <input class="signup-input" type="password" name="password" placeholder="Password" id="pass">
        <p class="tooltip red" class="tooltip" id="badPass">Weak password</p>


        <input class="signup-input" type="password" name="password2" placeholder="Repeat Password" id="confpass">
	<p class="tooltip red" class="tooltip" id="noMatch">Passwords do not match</p>
	
        <label class="checkbox">I agree to <a href="/policy" target="_blank">terms and conditions</a>
        <input type="checkbox" name="policycb" required>
        <span class="checkmark"></span>
        </label>
	

	<?php 
         if(isset($_GET['partner'])) {
             $partner=$_GET['partner'];
             echo '<input type="hidden" name="partner" value="'.$partner.'">';
         }
        ?>

        <input type="submit" value="Sign up" class="signup-button" id="sup-btn">
      </form>
      <p id="overlay-text" style="display:none">Check your email inbox or spam folder for an activation link we just sent you. It may take a few minutes for you to get the email.</p>
    </div>
  </div>


<!---------------- Forgot Password Overlay starts ---------------->
  <div class="overlay-container" id="forgot-overlay" style="display:none">
    <div class="overlay-forgot">
      <div class="forgot-header">
        <h1>Forgot Your Password?</h1>
        <a id="close-forgot-overlay" class="closebtn" onclick="closeNav()">×</a>
      </div>

      <form id="forgot-form">
        <div class="forgot-content">
          <p>Enter your email address below.</p>
          <input class="forgot-input" type="text" placeholder="Email" name="email" spellcheck="false" required>
        </div>
          <input type="submit" class="forgot-button" value="Send Email">
      </form>
    </div>
  </div>
<!---------------- Forgot Password Overlay ends ---------------->



<!-- SCRIPTS -->
<script>
$('#goto-signup').click(function() {
$('#signup-overlay').show();
});
</script>

<script>
$('#goto-login').click(function() {
$('#login-overlay').show();
});
</script>

<!-- Email Validation -->
<script type="text/javascript">
$('#deskEmail').each(function() {
  var elem=$(this);

  // current val
  elem.data('oldVal', elem.val());

  //look for changes
  elem.bind("propertychange change click keyup input paste", function(event) {
    if(elem.data('oldVal')!=elem.val()) {
      elem.data('oldVal', elem.val());

      if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(elem.val())) {
          $('#badEmail').hide();
          jQuery.ajax({
            type: 'POST',
            url: '/php/dup_email.php',
            data: $('#deskEmail').serialize(),
            success: function(data) {
              if(data=='dup') {
                  $('#dupEmail').show();
              } else {
                  $('#dupEmail').hide();
              }
            }
          });
      } else {
          $('#badEmail').show();
      }
    }
  });
});
</script>



<!-- Bad Password -->
<script type="text/javascript">
$('#pass').each(function() {
  var elem1=$(this);
  elem1.data('oldVal', elem1.val());
  elem1.bind("propertychange change click keyup input paste", function(event) {
    if(elem1.data('oldVal')!=elem1.val()) {
      elem1.data('oldVal', elem1.val());
      if(elem1.val().length > 8) {
        $('#badPass').hide();
      } else {
        $('#badPass').show();
      }
    }
  });
});
</script>




<!-- Password Confirmation -->
<script type="text/javascript">
    $('#confpass').each(function() {
        var elem2=$(this);
        elem2.data('oldVal', elem2.val());
        elem2.bind("propertychange change click keyup input paste", function(event) {
            if(elem2.data('oldVal')!=elem2.val()) {
                elem2.data('oldVal', elem2.val());
                if(elem2.val()!=$('#pass').val()) {
                    $('#noMatch').show();
                } else {
                    $('#noMatch').hide();
                }
            }
        });
    });
</script>


<!-- SIGNUP FORM SUBMIT -->
<script>
$('#regForm').submit(function(event) {
    event.preventDefault();

    if(($('#pass').val().length <= 8) || ($('#confpass').val()!=$('#pass').val()) || !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#deskEmail').val()))) {
      alert('Enter valid data!');
    } else {
      $('#sup-btn').css('opacity','0.85');
      $('#sup-btn').prop('disabled',true);
      $('#sup-btn').val('Signing up...');
      jQuery.ajax({
	type:'POST',
	    url: '/register/reg.php',
	    data: $(this).serialize(),
	    success: function(response) {
	    console.log(response);
	     
	    if(response==1) {
	      $('#overlay-title').html('Confirm Your Email Address');
	      $('#overlay-text').show();
	      $('#regForm').hide();
	    } else {
	      $('#overlay-title').html('Error!');
	      $('#overlay-text').show();
	      $('#overlay-text').html('Something went wrong! :/ Try again.');
	      $('#regForm').hide();
	    }
	  }
	});
    }
  });
</script>

<!-- CLOSE OVERLAY -->
<script>
$('#login-close-btn').click(function() {
  $('#login-overlay').hide();
});

$('#signup-close-btn').click(function() {
  $('#signup-overlay').hide();
});
  
</script>


<script>
$('#close-forgot-overlay').click(function() {
  $('#forgot-overlay').hide();
});
$('#open-forgot-overlay').click(function() {
  $('#forgot-overlay').show();
});
$('#open-forgot-overlay-mob').click(function() {
  $('#login-overlay').hide();
  $('#forgot-overlay').show();
});
</script>

<script>
$('#forgot-form').submit(function(event) {
  event.preventDefault();
  jQuery.ajax({
    type:'POST',
    url:'/register/forgot_password/forgotpass.php',
    data:$(this).serialize(),
    success: function(response) {
      if(response=='no_res') {
        alert('No account found with this email address');
      } else if(response==1) {
        alert('We sent you an email with the instructions to reset your password.');
	window.location.reload();
      } else {
        alert('Failed to send the email. Please try again.');
      }
    }
  });
});
</script>

</body>
</html>
