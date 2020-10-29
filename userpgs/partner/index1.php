<?php
// Requiring https
/*if($_SERVER['HTTPS'] != "on") {
    $url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    header("Location: $url");
    exit;
}*/

session_start();
require('../../register/connect.php');

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
	header("Location: /register/logout.php");
    exit();
}

require('../../php/get_user.php');
$id = $get_user_id;

require('../php/notif.php');

require('../../php/get_plans.php');

require('../../php/get_rel.php');

require('../../php/get_partner.php');

require('../../wallet/php/get_fxcoin_count.php');
?>

<!DOCTYPE HTML>
<html>
<head><meta name="viewport" content="width=device-width"/>
<title>Partner Dashboard</title>
<!-- STYLES & JQUERY 
================================================== -->
<link rel="stylesheet" type="text/css" href="/userpgs/css/style.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/icons.css"/>
<link rel="stylesheet" type="text/css" href="/userpgs/css/skinblue.css"/><!-- change skin color here -->
<link rel="stylesheet" type="text/css" href="/css/dropdown.css"/>
<link rel="stylesheet" type="text/css" href="/css/list/rotated_nav.css"/>
<link rel="stylesheet" type="text/css" href="/css/toptobottom.css"/>
<link rel="stylesheet" type="text/css" href="/css/odometer.css"/>
<link rel="stylesheet" type="text/css" href="/css/box.css"/>
<link rel="stylesheet" type="text/css" href="/css/roundcorner.css"/>
<link rel="stylesheet" type="text/css" href="/css/partner.css"/>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">

<script src="/js/jquery-1.9.0.min.js"></script><!-- the rest of the scripts at the bottom of the document -->
<script src="/js/function.js"></script>
<script src="http://cdnks.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
<!-- UPPER BAR -->
<section class="nav-bar">
  <div class="nav-container">
    <div class="brand">
      <div class="logoimg toplogo"></div>
    </div>
    <nav>
      <div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
      <ul class="nav-list">
        <li>
          <a href="/" id="ubHome"><img id="ubiHome" src="/images/upperbar/home_a.png" alt="Home"></a>
        </li>
        <li>
          <a href="/search" id="ubSearch"><img id="ubiSearch" src="/images/upperbar/search_a.png" alt="Search"></a>
        </li>
	<li>
          <a href="/userpgs/notif" id="notif_a"><img id="ubiNotif" src="/images/upperbar/notification_a.png" style="height: 19px; width: 15.77px;" alt="Notifs"></a>
        </li>
        <li>
          <a href="/msg/inbox.php" id="msg_bar"><img id="ubiMsg" src="/images/upperbar/message_a.png" style="height: 15.77px; width: 19px;" alt="Messages"></a>
	    <!--
	    <ul class="nav-dropdown">
            <li>
              <a href="#">test1</a>
            </li>
            <li>
              <a href="#">test2</a>
            </li>
            <li>
              <a href="#">test3</a>
            </li>
          </ul>
	  -->
        </li>
        <li>
          <a href="/register/logout.php" id="ubLogout"><img id="ubiLogout" src="/images/upperbar/logout_a.png" style="height: 15.77px; width: 19px;" alt="Logout" ></a>
        </li>
      </ul>
    </nav>
  </div>
</section>



<div class="boxedtheme">
<!-- TOP LOGO & MENU
================================================== -->
<div class="grid">
  <div class="row space-bot">
  </div>
</div>

<!-- LEFT PANEL
================================================== -->


<div class="grid">
                <div class="shadowundertop">
                </div>
                <div class="row">

                        <!-- LEFT SIDE -->
                        <div class="c9">
<?php
    $path="../avatars/";
    if(file_exists($path.$get_user_id.'.jpg')) {
        echo('<div class="userpic lsb-sub" style="background-image: url(\'/userpgs/avatars/'.$get_user_id.'.jpg\');"></div>');
    } elseif(file_exists($path.$get_user_id.'.jpeg')) {
        echo('<div class="userpic lsb-sub" style="background-image: url(\'/userpgs/avatars/'.$get_user_id.'.jpeg\');"></div>');
    } elseif(file_exists($path.$get_user_id.'.png')) {
        echo('<div class="userpic lsb-sub" style="background-image: url(\'/userpgs/avatars/'.$get_user_id.'.png\');"></div>');
    } elseif(file_exists($path.$get_user_id.'.gif')) {
        echo('<div class="userpic lsb-sub" style="background-image: url(\'/userpgs/avatars/'.$get_user_id.'.gif\');"></div>');
    } else {
        echo('<button class="userpic avatarr lsb-sub" id="showUpButt"></button>');
    }
?>

    <h2 style="text-align: center; font-size: 1rem; margin-top: 1px; margin-bottom: 0;" class="lsb-sub"><?php echo '<a href="/user/'.$username.'" style="color: black">'.$get_user_fname.' '.$get_user_lname.' <span style="font-size: 0.9rem">@'.$username.'</span></a>'; ?></h2>
				<!--<?php echo "$bio" ?>-->

          <p id="rcorners1" style="font-size: 1rem; font-weight: bold; margin-bottom: 0;" class="lsb-sub"><span style="float: left"><img src="/images/leftsidebar/fxcoin.png" style="height: 15px; width: 11.25px"></span><span style="float:right; font-family: courier;"><?php echo $get_fxcoin_count ?></span></p>


			    <table style="margin-top: 10px; line-height: 0;" class="lsb-screensize">
                  <tr>
				    <td style="width: 33.3%; text-align: left;"><a href="/userpgs/rel?act=friends" style="color: black"><strong><?php echo $get_rel_friends_count ?></strong></a></td>
				    <td style="width: 33.3%; text-align: center;"><a href="/userpgs/rel?act=following" style="color: black"><strong><?php echo $get_rel_following_count ?></strong></a></td>
				    <td style="width: 33.3%; text-align: right;"><a href="/userpgs/rel?act=followers" style="color: black"><strong><?php echo $get_rel_followers_count ?></strong></a></td>
				  </tr>
				  <tr>
				    <td style="width: 33.3%; text-align: left;"><a href="/userpgs/rel?act=friends" style="color: black">Friends</a></td>
				    <td style="width: 33.3%; text-align: center;"><a href="/userpgs/rel?act=following" style="color: black">Following</a></td>
				    <td style="width: 33.3%; text-align: right;"><a href="/userpgs/rel?act=followers" style="color: black">Followers</a></td>
				  </tr>
				</table>
          
          
          <a href="/"><button class="taste taste-lsb-ss" id="homeBtn"><span class="lsblogoimg lsblogo" id="homeSpan"></span><span class="lsb-screensize">HOME</span></button></a>
          <a href="/wallet"><button class="taste taste-lsb-ss" id="walletBtn"><span class="smallicon smallicon_wallet_a" id="walletSpan"></span><span class="lsb-screensize">WALLET</span></button></a>
          <a href="/userpgs/trader"><button class="taste taste-lsb-ss" id="traderBtn"><span class="smallicon smallicon_trader_a" id="traderSpan"></span><span class="lsb-screensize">TRADER</span></button></a>
          <a href="<?php 
					if($plans_msg) {
					  if($get_plans_fxuniversityins) {
					      echo '/userpgs/instructor'; 
					    } elseif($get_plans_fxuniversityins_req) {
					      echo '/register/instructor_wait.php';
					    } else {
					      echo '/register/instructor_reg.php';
					    }
					  } else {
					    echo '/register/instructor_reg.php';
					  } ?>"><button class="taste taste-lsb-ss" id="instructorBtn"><span class="smallicon smallicon_instructor_a" id="instructorSpan"></span><span class="lsb-screensize">INSTRUCTOR</span></button></a>
          <a href="<?php
					if($plans_msg) {
					  if($get_plans_fxuniversitystu) {
					    echo '/userpgs/student';
					  } elseif($get_plans_fxuniversitystu_req) {
					    echo '/register/student_wait.php';
					  } else {
					    echo '/register/student_reg.php';
					  }
					} else {
					  echo '/register/student_reg.php';
					} ?>"><button class="taste taste-lsb-ss" id="studentBtn"><span class="smallicon smallicon_student_a" id="studentSpan"></span><span class="lsb-screensize">STUDENT</span></button></a>
          <a href="/userpgs/partner"><button class="taste taste-lsb-ss" id="partnerBtn"><span class="smallicon smallicon_partner_a" id="partnerSpan"></span><span class="lsb-screensize">PARTNER</span></button></a>
          
          <hr class="hrtitle" style="border-color: #25252533">
          
			</div>

			<!-- MAIN CONTENT -->
			<div class="c3">
			     <div class="rightsidebar">
			     	  <h2 class="title stresstitle">Partner</h2>
                      <hr class="hrtitle" >
          <h2 style="margin-top: 52px; margin-bottom: 2px;">Your Income</h2>
          <p>The following users have accepted your invitation.</p>
          <p>Your profit from each user is presented under the income column and is regularly updated by the actions they take on fxUnivers.</p>

<?php if($get_partner_count>0) { ?>
                    <table style="border: 1px solid #e8e8e8; color: black; margin-top: 15px;">
                                 <tr style="border-bottom: 1px solid #e8e8e8; font-weight: bold;">
                                 <td style="text-align: center">Username</td>
                                 <td style="text-align: center">Added on</td>
                                 <td style="text-align: center">Days Remaining</td>
                                 <td style="text-align: center">Income</td>
                                 </tr>
<?php while($row=$get_partner_result->fetch_assoc()) {
                        $pun_query="SELECT * FROM user WHERE id=".$row['user'];
                        $pun_result=mysqli_query($connection,$pun_query) or die(mysqli_error($connection));
                        $pun_fetch=mysqli_fetch_array($pun_result);
                        $pun_username=$pun_fetch['username'];

// expire date
$add_date=date($row['dt']);
$exp_date_s=strtotime('+90 day',strtotime($add_date));
$exp_date=date('Y-m-j',$exp_date_s);
//$date_diff=$today->diff($exp_date);

                        

$date1 = new DateTime("today");
$date2 = new DateTime($exp_date);
$interval = $date1->diff($date2);
?>
                        <tr style="border-bottom: 1px solid #e8e8e8" class="hoverable">
                        <td style="text-align: center"><a href="/user/<?php echo $pun_username ?>">@<?php echo $pun_username ?></a></td>
                        <td style="text-align: center"><?php echo $add_date?></td>
    <td style="text-align: center"><?php echo $interval->days; ?></td>
                        <td style="text-align: center"><?php echo $row['income']?></td>
                            
                        </tr>
<?php } ?>
                                 </table>
<?php } else {
                    echo 'No partnership record found.';
                }
?>
                             <hr class="hrtitle" style="border-color: #25252533">    
          
                      <h2 style="margin-bottom: 2px">Open Positions</h2>
                      <p>The following are the partnership positions open to business as of now.</p>

          <hr class="hrtitle">


          
          <button id="fxuniversityBtn" class="btn">fxUniversity</button>
          <div id="fxuniversityDiv" style="display: none" class="partnerDesc">
          <p>We need technical university partners to bring university professional staff to do business with us together for income/profit. </p>
                      <p>Send the following link to invite those who may join in as an instructor or a student here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
                      <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink1" readonly>
                      <button onclick="copyToCB(this)" style="color: black" id="partnerButt1">Copy to Clipboard</button>
		              <p style="color: gray; display: none;" id="copied1">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">
          

          <button id="fxteacherBtn" class="btn">fxTeacher</button>
          <div id="fxteacherDiv" style="display: none" class="partnerDesc">
            <p>We need teaching partners to teach, create teaching materials, and bring more professional teachers to do business with us together for income/profit. </p>
            <p>Send the following link to invite those who may join in as a teacher here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink2" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt2">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">


          <button id="fxpartnerBtn" class="btn">fxPartner</button>
          <div id="fxpartnerDiv" style="display: none" class="partnerDesc">
            <p>We need partners to bring in professional staff to do business with us together for income/profit.  Partners help with talent acquisition and guidance to new users in order to succeed and generate revenue for profit sharing.</p>
            <p>Send the following link to invite those who may join in as a partner here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink3" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt3">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">


          <button id="fxinstructorBtn" class="btn">fxInstructor</button>
          <div id="fxinstructorDiv" style="display: none" class="partnerDesc">
            <p>We need instructors to work with our students and do business with us together for income/profit. Instructors teach our students any topic of expertise.</p>
            <p>Send the following link to invite those who may join in as an instructor here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink4" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt4">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">


          <button id="fxtrainerBtn" class="btn">fxTrainer</button>
          <div id="fxtrainerDiv" style="display: none" class="partnerDesc">
            <p>We need trainers to train our trainees within any expertise and do business with us together for income/profit.</p>
            <p>Send the following link to invite those who may join in as a trainer here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink5" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt5">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">


          <button id="fxexecutiveBtn" class="btn">fxExecutive</button>
          <div id="fxexecutiveDiv" style="display: none" class="partnerDesc">
            <p>We need executives to recruit and manage specialty partners while monitor and grow generated revenue within any expertise to do business with us together for income/profit.</p>
            <p>Send the following link to invite those who may join in as an executive here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink6" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt6">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">


          <button id="fxanalystBtn" class="btn">fxAnalyst</button>
          <div id="fxanalystDiv" style="display: none" class="partnerDesc">
            <p>We need Analysts to analyze the current markets and maximize generated revenue within any expertise to do business with us together for income/profit.</p>
            <p>Send the following link to invite those who may join in as an analyst here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink7" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt7">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">


          <button id="fxsalesmanBtn" class="btn">fxSalesman</button>
          <div id="fxsalesmanDiv" style="display: none" class="partnerDesc">
            <p>We need Sales professionals to sell our products that are highly demanded from teaching materials, courses, services, to financial platforms, manage contracts within any markets and maintain business with us together for income/profit.</p>
            <p>Send the following link to invite those who may join in as a salesman here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink8" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt8">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">



          <button id="fxmarketerBtn" class="btn">fxMarketer</button>
          <div id="fxmarketerDiv" style="display: none" class="partnerDesc">
            <p>We need Marketing professionals to analyze the current markets and promote and do marketing of our products and services that are highly demanded from teaching materials, courses, services, to financial platforms, manage contracts within any markets and maintain business with us together for income/profit.</p>
            <p>Send the following link to invite those who may join in as a marketer here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink9" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt9">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">


          <button id="fxhrBtn" class="btn">fxHR</button>
          <div id="fxhrDiv" style="display: none" class="partnerDesc">
            <p>We need Human Resources professionals to analyze the current hiring markets and recruit workforce for our many services to be offered.  Talent acquisition is one of our top priority areas of investment as our main assets are talents absorbed to maintain business with us together for income/profit.</p>
            <p>Send the following link to invite those who may join in as an HR here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink10" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt10">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">


          <button id="fxdoctorBtn" class="btn">fxDoctor</button>
          <div id="fxdoctorDiv" style="display: none" class="partnerDesc">
            <p>We need Doctors of all specialties to:</p>
          <ol style="color: black"><li>Teach/train students</li><li>Create/Provide informative solutions and materials for general public seeking doctor’s advise/sessions.</li></ol>
<p>fxDoctors shall generate revenue within any given expertise and manage business with us together for income/profit.</p>
            <p>Send the following link to invite those who may join in as a doctor here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink11" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt11">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">


          <button id="fxnurseBtn" class="btn">fxNurse</button>
          <div id="fxnurseDiv" style="display: none" class="partnerDesc">
          <p>We need Nurses of all specialties to:</p>
          <ol style="color: black"><li>Teach/train other nurses</li><li>Create/Provide informative solutions and materials for general public seeking nurse’s advise/sessions.</li></ol>
          <p>fxNurse shall generate revenue within any given expertise and manage business with us together for income/profit.</p>
            <p>Send the following link to invite those who may join in as a nurse here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink12" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt12">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">


          <button id="fxspecialistBtn" class="btn">fxSpecialist</button>
          <div id="fxspecialistDiv" style="display: none" class="partnerDesc">
            <p>We need Specialists of all specialties to:</p>
            <ol style="color: black"><li>1) Teach/train other specialists</li><li>Create/Provide informative solutions and materials for general public seeking specialist’s advise/sessions.</li></ol>
<p>fxSpecialist shall generate revenue within his/her given expertise and manage business with us together for income/profit.</p>
            <p>Send the following link to invite those who may join in as a specialist here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p> 
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink13" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt13">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">


          <button id="fxprofessorBtn" class="btn">fxProfessor</button>
          <div id="fxprofessorDiv" style="display: none" class="partnerDesc">
            <p>We need Professors of all specialties to:</p>
            <ol style="color: black"><li>Teach/train other professors</li><li>Teach/train students</li><li>Create/Provide informative solutions and sessions for general public seeking professor’s private sessions.</li></ol>
            <p>fxProfessor shall generate revenue within his/her given expertise and manage business with us together for income/profit.</p>
            <p>Send the following link to invite those who may join in as a professor here at fxUnivers. Upon their registration, you will receive 50% of the profit from the potential user for 90 days.</p>
          
             <input type="text" value="https://fxunivers.com/?partner=<?php echo $username?>#signup-section" id="partnerLink14" readonly>
             <button onclick="copyToCB(this)" style="color: black" id="partnerButt14">Copy to Clipboard</button>
		     <p style="color: gray; display: none;" id="copied">Copied!</p>
          </div>
          <hr class="hrtitle" style="margin-bottom: 25px">
          
			     </div>        
          
			</div>
            <!-- RIGHT SIDEBAR -->
            <div class="c33">
              
          
            </div>
              
	</div>
		
</div>

<!--
          <h2>Contact Us</h2>
            			  <p>Contact us considering your partnership request below. First, select your partnership field of interest.</p>
          
				  <form id="pMsgForm">
				      <select name="interest" style="width: 200px">
				        <option value="0">(Field of Interest)</option>
					<option value="1">Student</option>
					<option value="2">Instructor</option>
					<option value="3">Signal Provider</option>
					<option value="4">Trader</option>
					<option value="5">Contracting</option>
				      </select>
            			    <input type="text" name="subject" class="form-control" placeholder="Subject">
           			    <textarea name="body" id="" cols="30" rows="10" placeholder="Your message goes here."></textarea>
				    <input type="hidden" name="user_id" value="<?php echo $get_user_id ?>">
				    <input type="submit" class="btn btn-primary py-3 px-5 btn-block btn-pill" value="Send Message">
                		  </form>
          -->

          
<!-- FOOTER
================================================== -->
<div id="wrapfooter">
        <div class="grid">
                <div class="row" id="footer">
                        <!-- to top button  -->
                        <!--<p class="back-top floatright">
                                <a href="#top"><span></span></a>
                        </p>-->
                        <!-- 1st column -->
			<div class="c4">
                          <div class="logoimgbig biglogo" style="margin-left: 0"></div>
                        </div>
                        <!-- 2nd column -->
                        <div class="c4">
                                <h2 class="title">Contact</h2>
                                <hr class="footerstress">
                                <dl>
                                        <dt>New Horizon Building, Ground Floor,
                                                <br />3 1/2 Miles Philip S.W. Goldson Highway,
                                                <br />Belize City, Belize,
                                                <br />Central America</dt>
                                        <dd>E-mail: <a href="#">contact@fxunivers.com</a></dd>
                                </dl>
                                <ul class="social-links" style="margin-top:15px;">
                                        <li class="facebook-link smallrightmargin">
                                        <a href="https://www.facebook.com/fxunivers" class="facebook has-tip" target="_blank" title="Join us on Facebook">Facebook</a>
                                        </li>
                                        <li class="linkedin-link smallrightmargin">
                                        <a href="https://www.linkedin.com/company/fxunivers/" class="linkedin has-tip" title="Linkedin" target="_blank">Linkedin</a>
                                        </li>
                                        <li class="twitter-link smallrightmargin">
                                        <a href="https://twitter.com/fxunivers" class="twitter has-tip" target="_blank" title="Follow Us on Twitter">Twitter</a>
                                        </li>
                                </ul>
                        </div>
                        <!-- 3rd column -->
                        <div class="c4">
                                <h2 class="title">Policy</h2>
                                <hr class="footerstress">
                                <a href="/policy">Policy and Agreements</a>
                        </div>
                </div>
        </div>
</div>

<!-- copyright area -->
<div class="copyright">
        <div class="grid">
		<div class="row">
                        <div class="c6">
                                With all due Reserves,
                        </div>
                </div>
                <div class="row">
                        <div class="c6">
                                 fxUnivers &copy; 2017-2020. All Rights Reserved.
                        </div>
                        <div class="c6">
                                <span class="right">
                                <!-- by Milad, milad@fxunivers.com --> </span>
                        </div>
                </div>
        </div>
</div>

<!-- JAVASCRIPTS
================================================== -->
<!-- all -->
<script src="js/modernizr-latest.js"></script>

<!-- menu & scroll to top -->
<script src="js/common.js"></script>

<!-- slider -->
<script src="js/jquery.cslider.js"></script>

<!-- cycle -->
<script src="js/jquery.cycle.js"></script>

<!-- carousel items -->
<script src="js/jquery.carouFredSel-6.0.3-packed.js"></script>

<!-- twitter -->
<script src="js/jquery.tweet.js"></script>

<!-- Call opacity on hover images from carousel-->
<script type="text/javascript">
$(document).ready(function(){
    $("img.imgOpa").hover(function() {
      $(this).stop().animate({opacity: "0.6"}, 'slow');
    },
    function() {
      $(this).stop().animate({opacity: "1.0"}, 'slow');
    });
  });
</script>

<script type="text/javascript">
  $(function() {
      $('#pMsgForm').on('submit', function(e) {
        e.preventDefault();
	$.ajax({
	  type: 'post',
	  url: '/php/partner_msg.php',
	  data: $('#pMsgForm').serialize(),
	  success: function() {
	    alert('Message recieved, thanks for contacting us. We will respond to your partnership request as soon as possible.');
	  }
	});
      });
    });
</script>

<script>
function copyToCB(x) {
    if(x.id=="partnerButt1") {
        var copyText=document.getElementById("partnerLink1");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt2") {
        var copyText=document.getElementById("partnerLink2");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt3") {
        var copyText=document.getElementById("partnerLink3");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt4") {
        var copyText=document.getElementById("partnerLink4");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt5") {
        var copyText=document.getElementById("partnerLink5");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt6") {
        var copyText=document.getElementById("partnerLink6");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt7") {
        var copyText=document.getElementById("partnerLink7");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt8") {
        var copyText=document.getElementById("partnerLink8");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt9") {
        var copyText=document.getElementById("partnerLink9");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt10") {
        var copyText=document.getElementById("partnerLink10");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt11") {
        var copyText=document.getElementById("partnerLink11");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt12") {
        var copyText=document.getElementById("partnerLink12");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt13") {
        var copyText=document.getElementById("partnerLink13");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
    if(x.id=="partnerButt14") {
        var copyText=document.getElementById("partnerLink14");
        copyText.select();
        copyText.setSelectionRange(0,99999);
        document.execCommand("copy");
        x.innerHTML='Copied';
    }
}
</script>

<!-- BUTTONS -->
<script>
$(document).ready(function() {
    $('#traderBtn').hover(function() {
        var imgUrl='../../images/leftsidebar/trader_b.png';
        $('#traderSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/leftsidebar/trader_a.png';
        $('#traderSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#walletBtn').hover(function() {
        var imgUrl='../../images/leftsidebar/wallet_b.png';
        $('#walletSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/leftsidebar/wallet_a.png';
        $('#walletSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#instructorBtn').hover(function() {
        var imgUrl='../../images/leftsidebar/instructor_b.png';
        $('#instructorSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/leftsidebar/instructor_a.png';
        $('#instructorSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#partnerBtn').hover(function() {
        var imgUrl='../../images/leftsidebar/partner_b.png';
        $('#partnerSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/leftsidebar/partner_a.png';
        $('#partnerSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#studentBtn').hover(function() {
        var imgUrl='../../images/leftsidebar/student_b.png';
        $('#studentSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/leftsidebar/student_a.png';
        $('#studentSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#homeBtn').hover(function() {
        var imgUrl='../../images/logos/fxlogo_a.png';
        $('#homeSpan').css("background-image", "url(" + imgUrl + ")");
    }, function() {
        var imgUrl0='../../images/logos/fxlogo_b.png';
        $('#homeSpan').css("background-image", "url(" + imgUrl0 + ")");
    });
});
</script>

<script>
$(document).ready(function() {
    $('#notif_a').hover(function() {
        var imgUrl='../../images/upperbar/notification_b.png';
        $('#ubiNotif').attr("src", imgUrl);
    }, function() {
        var imgUrl0='../../images/upperbar/notification_a.png';
        $('#ubiNotif').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubHome').hover(function() {
        var imgUrl='../../images/upperbar/home_b.png';
        $('#ubiHome').attr("src", imgUrl);
    }, function() {
        var imgUrl0='../../images/upperbar/home_a.png';
        $('#ubiHome').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubLogout').hover(function() {
        var imgUrl='../../images/upperbar/logout_b.png';
        $('#ubiLogout').attr("src", imgUrl);
    }, function() {
        var imgUrl0='../../images/upperbar/logout_a.png';
        $('#ubiLogout').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#msg_bar').hover(function() {
        var imgUrl='../../images/upperbar/message_b.png';
        $('#ubiMsg').attr("src", imgUrl);
    }, function() {
        var imgUrl0='../../images/upperbar/message_a.png';
        $('#ubiMsg').attr("src",imgUrl0);
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ubSearch').hover(function() {
        var imgUrl='../../images/upperbar/search_b.png';
        $('#ubiSearch').attr("src", imgUrl);
    }, function() {
        var imgUrl0='../../images/upperbar/search_a.png';
        $('#ubiSearch').attr("src",imgUrl0);
    });
});
</script>


<script>
$(document).ready(function() {
    $('#ads1').hover(function() {
        $('#ads1').css({opacity:1});
    }, function() {
        $('#ads1').css({opacity:0.8});
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ads2').hover(function() {
        $('#ads2').css({opacity:1});
    }, function() {
        $('#ads2').css({opacity:0.8});
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ads3').hover(function() {
        $('#ads3').css({opacity:1});
    }, function() {
        $('#ads3').css({opacity:0.8});
    });
});
</script>

<script>
$(document).ready(function() {
    $('#ads4').hover(function() {
        $('#ads4').css({opacity:1});
    }, function() {
        $('#ads4').css({opacity:0.8});
    });
});
</script>
<!-- EO BUTTONS -->

<!-- NOTIFS -->
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
                $('#notif_a').css('background-color', '#3282b8');
            }

            jQuery.ajax({
              type: 'POST',
              url: '/php/msg_icon.php',
              data: {msg_userId: notifUserId},
              success: function(result) {
                    if(result>0) {
                        $('#msg_bar').css('background-color', '#3282b8');
                    }
              }
            });
      }
    });
  }, 2000);
});
</script>
<!-- EO NOTIFS -->

<script>
$("#fxuniversityBtn").click(function() {
    $("#fxuniversityDiv").toggle();
    if($("#fxuniversityDiv").css("display")=="block") {
        $("#fxuniversityBtn").css("background-color","#008bc6");
        $("#fxuniversityBtn").css("color","#fff");
    } else {
        $("#fxuniversityBtn").css("background-color","#f4f4f4");
        $("#fxuniversityBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxteacherBtn").click(function() {
    $("#fxteacherDiv").toggle();
    if($("#fxteacherDiv").css("display")=="block") {
        $("#fxteacherBtn").css("background-color","#008bc6");
        $("#fxteacherBtn").css("color","#fff");
    } else {
        $("#fxteacherBtn").css("background-color","#f4f4f4");
        $("#fxteacherBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxpartnerBtn").click(function() {
    $("#fxpartnerDiv").toggle();
    if($("#fxpartnerDiv").css("display")=="block") {
        $("#fxpartnerBtn").css("background-color","#008bc6");
        $("#fxpartnerBtn").css("color","#fff");
    } else {
        $("#fxpartnerBtn").css("background-color","#f4f4f4");
        $("#fxpartnerBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxinstructorBtn").click(function() {
    $("#fxinstructorDiv").toggle();
    if($("#fxinstructorDiv").css("display")=="block") {
        $("#fxinstructorBtn").css("background-color","#008bc6");
        $("#fxinstructorBtn").css("color","#fff");
    } else {
        $("#fxinstructorBtn").css("background-color","#f4f4f4");
        $("#fxinstructorBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxtrainerBtn").click(function() {
    $("#fxtrainerDiv").toggle();
    if($("#fxtrainerDiv").css("display")=="block") {
        $("#fxtrainerBtn").css("background-color","#008bc6");
        $("#fxtrainerBtn").css("color","#fff");
    } else {
        $("#fxtrainerBtn").css("background-color","#f4f4f4");
        $("#fxtrainerBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxexecutiveBtn").click(function() {
    $("#fxexecutiveDiv").toggle();
    if($("#fxexecutiveDiv").css("display")=="block") {
        $("#fxexecutiveBtn").css("background-color","#008bc6");
        $("#fxexecutiveBtn").css("color","#fff");
    } else {
        $("#fxexecutiveBtn").css("background-color","#f4f4f4");
        $("#fxexecutiveBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxanalystBtn").click(function() {
    $("#fxanalystDiv").toggle();
    if($("#fxanalystDiv").css("display")=="block") {
        $("#fxanalystBtn").css("background-color","#008bc6");
        $("#fxanalystBtn").css("color","#fff");
    } else {
        $("#fxanalystBtn").css("background-color","#f4f4f4");
        $("#fxanalystBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxsalesmanBtn").click(function() {
    $("#fxsalesmanDiv").toggle();
    if($("#fxsalesmanDiv").css("display")=="block") {
        $("#fxsalesmanBtn").css("background-color","#008bc6");
        $("#fxsalesmanBtn").css("color","#fff");
    } else {
        $("#fxsalesmanBtn").css("background-color","#f4f4f4");
        $("#fxsalesmanBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxmarketerBtn").click(function() {
    $("#fxmarketerDiv").toggle();
    if($("#fxmarketerDiv").css("display")=="block") {
        $("#fxmarketerBtn").css("background-color","#008bc6");
        $("#fxmarketerBtn").css("color","#fff");
    } else {
        $("#fxmarketerBtn").css("background-color","#f4f4f4");
        $("#fxmarketerBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxhrBtn").click(function() {
    $("#fxhrDiv").toggle();
    if($("#fxhrDiv").css("display")=="block") {
        $("#fxhrBtn").css("background-color","#008bc6");
        $("#fxhrBtn").css("color","#fff");
    } else {
        $("#fxhrBtn").css("background-color","#f4f4f4");
        $("#fxhrBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxdoctorBtn").click(function() {
    $("#fxdoctorDiv").toggle();
    if($("#fxdoctorDiv").css("display")=="block") {
        $("#fxdoctorBtn").css("background-color","#008bc6");
        $("#fxdoctorBtn").css("color","#fff");
    } else {
        $("#fxdoctorBtn").css("background-color","#f4f4f4");
        $("#fxdoctorBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxnurseBtn").click(function() {
    $("#fxnurseDiv").toggle();
    if($("#fxnurseDiv").css("display")=="block") {
        $("#fxnurseBtn").css("background-color","#008bc6");
        $("#fxnurseBtn").css("color","#fff");
    } else {
        $("#fxnurseBtn").css("background-color","#f4f4f4");
        $("#fxnurseBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxspecialistBtn").click(function() {
    $("#fxspecialistDiv").toggle();
    if($("#fxspecialistDiv").css("display")=="block") {
        $("#fxspecialistBtn").css("background-color","#008bc6");
        $("#fxspecialistBtn").css("color","#fff");
    } else {
        $("#fxspecialistBtn").css("background-color","#f4f4f4");
        $("#fxspecialistBtn").css("color","#008bc6");
    }
});
</script>

<script>
$("#fxprofessorBtn").click(function() {
    $("#fxprofessorDiv").toggle();
    if($("#fxprofessorDiv").css("display")=="block") {
        $("#fxprofessorBtn").css("background-color","#008bc6");
        $("#fxprofessorBtn").css("color","#fff");
    } else {
        $("#fxprofessorBtn").css("background-color","#f4f4f4");
        $("#fxprofessorBtn").css("color","#008bc6");
    }
});
</script>



    
</body>
</html>