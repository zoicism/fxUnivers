<?php
session_start();
require('../register/connect.php');

if(isset($_POST['stu_id']) && isset($_POST['course_id'])) {
  $stu_id = $_POST['stu_id'];
  $course_id = $_POST['course_id'];
}

require('get_course.php');
$cost = $get_course_fetch['cost'];
$instructor_id = $get_course_fetch['user_id'];

require('../wallet/php/wallet_connect.php');
$get_user_id=$stu_id;
require('../wallet/php/get_fxcoin_count.php');

// current dt
date_default_timezone_set('America/New_York');
$trans_dt=date('Y-m-d H:i:s');

// calculate interest
$interest=ceil(0.1*$cost);

if($get_fxcoin_count>=$cost+$interest) {
    // send instructor $cost fxcoins
    $send_fxcoins_query = "UPDATE link SET userId=$instructor_id WHERE userId=$stu_id LIMIT $cost";
    $send_fxcoins_result = mysqli_query($wallet_connection, $send_fxcoins_query) or die(mysqli_error($wallet_connection));
    // add transfer receipt
    //require('../wallet/php/transfer.php');
    $trans_from=$stu_id;
    $trans_to=$instructor_id;
    $trans_amnt=$cost;
    require('set_trans.php');

    // check if user is introduced by an fxPartner
    require('conn/fxpartner.php');
    $check_partner_q="SELECT * FROM on_user WHERE user=$get_user_id";
    $check_partner_r=mysqli_query($fxpartner_connection,$check_partner_q) or die(mysqli_error($fxpartner_connection));
    $check_partner=mysqli_fetch_array($check_partner_r);
    $check_partner_count=mysqli_num_rows($check_partner_r);

    // check if partner time is expired
    $time_remains=0;
    if($check_partner_count!=0) {
        $today=new DateTime("today");

        $add_date=date($check_partner['dt']);
        $exp_date_s=strtotime('+90 day',strtotime($add_date));
        $exp_date=date('Y-m-j',$exp_date_s);

        $exp=new DateTime($exp_date);

        if($exp>$today) $time_remains=1;
    }

    // if there is no partner or the timing of the partner is expired
    if($check_partner_count==0 || $time_remains==0) {
        // send fxunivers $interest fxcoins
        $purchase_interest_query="UPDATE link SET userId=1 WHERE userId=$stu_id LIMIT $interest";
        $purchase_interest_result=mysqli_query($wallet_connection,$purchase_interest_query) or die(mysqli_error($wallet_connection));
        
        // transaction data
        $trans_from=$stu_id;
        $trans_to=1;
        $trans_amnt=$interest;
        require('set_trans.php');
        
    } else { // if there is a partner
        $fxunivers_interest=ceil(0.5*$interest);
        $fxpartner_interest=floor(0.5*$interest); //$interest-$fxunivers_interest;
        
        $fxpartner_id=$check_partner['partner'];
        // split shares
        if($fxpartner_interest>0) {
            // send partner's shares
            $partner_share_q="UPDATE link SET userId=$fxpartner_id WHERE userId=$stu_id LIMIT $fxpartner_interest";
            $partner_share_r=mysqli_query($wallet_connection,$partner_share_q) or die(mysqli_error($wallet_connection));

            // transaction data
            $trans_from=$stu_id;
            $trans_to=$fxpartner_id;
            $trans_amnt=$fxpartner_interest;
            require('set_trans.php');

            // add the amount to his income in fxpartner db
            $partner_income_q="UPDATE on_user SET income=income+$fxpartner_interest WHERE partner=$fxpartner_id";
            $partner_income_r=mysqli_query($fxpartner_connection,$partner_income_q) or die(mysqli_error($fxpartner_connection));
        }
        if($fxunivers_interest>0) {
            $fxu_share_q="UPDATE link SET userId=1 WHERE userId=$stu_id LIMIT $fxunivers_interest";
            $fxu_share_r=mysqli_query($wallet_connection,$fxu_share_q) or die(mysqli_error($wallet_connection));
            
            // transaction data
            $trans_from=$stu_id;
            $trans_to=1;
            $trans_amnt=$fxunivers_interest;
            require('set_trans.php');

        }
    }
        
} else {
    exit();
}

if($send_fxcoins_result) {
  $purchase_course_query = "INSERT INTO stucourse(stu_id, course_id) VALUES($stu_id, $course_id)";
  $purchase_course_result = mysqli_query($connection, $purchase_course_query) or die(mysqli_error($connection));
}

if($purchase_course_result) {  
  $redirect_to = "Location: /userpgs/instructor/course_management/course.php?course_id=".$course_id;
  header($redirect_to);
} else {
  echo "error!";
}

?>