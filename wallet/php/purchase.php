<?php
session_start();
if(isset($_SESSION['username'])) {
    $username=$_SESSION['username'];
} else {
    header('Location: /');
}

require('../../register/connect.php');
require('wallet_connect.php');

if(isset($_POST['item'])) {
    if($_POST['item']=='course') {
        $course_id=$_POST['course_id'];
        $stu_id=$_POST['stu_id'];
        $get_user_id=$stu_id;
        $course_q="SELECT * FROM teacher WHERE id=$course_id";
        $course_r=mysqli_query($connection,$course_q) or die(mysqli_error($connection));

        $course_fetch=mysqli_fetch_array($course_r);
        $cost=$course_fetch['cost'];
        $instructor_id=$course_fetch['user_id'];
    }
} else {
    header('Location: /');
}

require('get_fxcoin_count.php');

date_default_timezone_set('America/New_York');
$trans_dt=date('Y-m-d H:i:s');

$interest=ceil(0.1*$cost);

if($get_fxcoin_count>=$cost+$interest) {
    // send instructor $cost fxcoins
    $send_fxcoins_query = "UPDATE link SET userId=$instructor_id WHERE userId=$stu_id LIMIT $cost";
    //echo 'send fxcoins: '.$send_fxcoins_query.'<br>';
    $send_fxcoins_result = mysqli_query($wallet_connection, $send_fxcoins_query) or die(mysqli_error($wallet_connection));
    
    // add transfer receipt
    //require('../wallet/php/transfer.php');
    $trans_from=$stu_id;
    $trans_to=$instructor_id;
    $trans_amnt=$cost;
    $trans_query="INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($trans_from, $trans_to, $trans_amnt, '$trans_dt')";
    //echo $trans_query.'<br><br>';
    $trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));
    //require('../../php/set_trans.php');
    ////echo 'hi';
    // check if user is introduced by an fxPartner
    require('../../php/conn/fxpartner.php');
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
        //echo 'fxUnivers share: '.$purchase_interest_query.'<br>';
        $purchase_interest_result=mysqli_query($wallet_connection,$purchase_interest_query) or die(mysqli_error($wallet_connection));
        
        // transaction data
        $trans_from=$stu_id;
        $trans_to=1;
        $trans_amnt=$interest;
        //require('../../php/set_trans.php');
        $trans_query="INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($trans_from, $trans_to, $trans_amnt, '$trans_dt')";
        //echo $trans_query.'<br><br>';
        $trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));
        
    } else { // if there is a partner
        $fxunivers_interest=ceil(0.5*$interest);
        $fxpartner_interest=floor(0.5*$interest); //$interest-$fxunivers_interest;
        ////echo $fxunivers_interest;
        $fxpartner_id=$check_partner['partner'];
        // split shares
        if($fxpartner_interest>0) {
            // send partner's shares
            $partner_share_q="UPDATE link SET userId=$fxpartner_id WHERE userId=$stu_id LIMIT $fxpartner_interest";
            //echo 'partner share: '.$partner_share_q.'<br>';
            $partner_share_r=mysqli_query($wallet_connection,$partner_share_q) or die(mysqli_error($wallet_connection));

            // transaction data
            $trans_from=$stu_id;
            $trans_to=$fxpartner_id;
            $trans_amnt=$fxpartner_interest;
            //require('../../php/set_trans.php');
            $trans_query="INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($trans_from, $trans_to, $trans_amnt, '$trans_dt')";
            //echo $trans_query.'<br><br>';
            $trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));

            // add the amount to his income in fxpartner db
            $partner_income_q="UPDATE on_user SET income=income+$fxpartner_interest WHERE (partner=$fxpartner_id AND user=$stu_id)";
            //echo $partner_income_q.'<br>';
            $partner_income_r=mysqli_query($fxpartner_connection,$partner_income_q) or die(mysqli_error($fxpartner_connection));
        }
        if($fxunivers_interest>0) {
            $fxu_share_q="UPDATE link SET userId=1 WHERE userId=$stu_id LIMIT $fxunivers_interest";
            //echo $fxu_share_q.'<br>';
            $fxu_share_r=mysqli_query($wallet_connection,$fxu_share_q) or die(mysqli_error($wallet_connection));
            
            // transaction data
            $trans_from=$stu_id;
            $trans_to=1;
            $trans_amnt=$fxunivers_interest;
            //require('../../php/set_trans.php');
            $trans_query="INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($trans_from, $trans_to, $trans_amnt, '$trans_dt')";
            //echo $trans_query.'<br><br>';
            $trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));

        }
    }
} else {
    echo 'insuff';
    exit();
}
////echo $send_fxcoins_result;
if($send_fxcoins_result) {
    $purchase_course_query = "INSERT INTO stucourse(stu_id, course_id) VALUES($stu_id, $course_id)";
    //echo $purchase_course_query.'<br>';
    $purchase_course_result = mysqli_query($connection, $purchase_course_query) or die(mysqli_error($connection));
}

if($purchase_course_result) {  
    //$redirect_to = "Location: /userpgs/instructor/course_management/course.php?course_id=".$course_id;
    //header($redirect_to);
    echo 'success';
} else {
    echo "error";
}
?>