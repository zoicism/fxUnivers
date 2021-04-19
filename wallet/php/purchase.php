<?php
session_start();
if(isset($_SESSION['username'])) {
    $username=$_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
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

	$buyer_id = $get_user_id;
	$seller_id = $instructor_id;
    }
} else {
    header('Location: /');
}

require('get_fxcoin_count.php');

$fxunivers_id = 1;
$trans_dt=date('Y-m-d H:i:s');
$interest=ceil(0.1*$cost);

if($get_fxcoin_count>=$cost+$interest) {
    
    
    $buyer_old_balance = $get_fxcoin_count;
    $buyer_new_balance = $get_fxcoin_count - $cost - $interest;

    $seller_ob_q = "SELECT * FROM fxstars WHERE user_id = $seller_id";
    $seller_ob_r = mysqli_query($wallet_connection, $seller_ob_q);
    $seller_ob_f = mysqli_fetch_array($seller_ob_r);
    
    $seller_old_balance = $seller_ob_f['balance'];
    $seller_new_balance = $seller_old_balance + $cost;

    // 1. Update buyer's balance.
    // 2. Update seller's balance.
    // 3. Add a transaction(buyer->seller). 
    $purchase_q = "UPDATE fxstars SET balance = $buyer_new_balance WHERE user_id = $buyer_id; UPDATE fxstars SET balance = $seller_new_balance WHERE user_id = $seller_id; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($cost, $buyer_id, $seller_id, '$trans_dt');";
    $purchase_r = mysqli_multi_query($wallet_connection, $purchase_q);
    while($wallet_connection->next_result()) {;} // Flushing multi_queries
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
    
    /*
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
     */
    //require('../../php/set_trans.php');
    ////echo 'hi';
    // check if user is introduced by an fxPartner
    
    
    //echo $check_partner_count. ' ' .$time_remains;
    
    // if there is no partner or the timing of the partner is expired
    if($check_partner_count==0 || $time_remains==0) {

	// Interest goes to fxUnivers
	// 1. Add interest as transaction to fxUnivers
	$fxunivers_share_q = "INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($interest, $buyer_id, $fxunivers_id, '$trans_dt')";
	$fxunivers_share_r = mysqli_query($wallet_connection, $fxunivers_share_q) or die(mysqli_error($wallet_connection));
	
	/*
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
         */
    } else { 
	// If there is a partner

	$fxunivers_share = $interest * 0.5;
	$fxpartner_share = $interest - $fxunivers_share;
	
	$fxpartner_id = $check_partner['partner'];

	$partner_ob_q = "SELECT * FROM fxstars WHERE user_id = $fxpartner_id";
	$partner_ob_r = mysqli_query($wallet_connection, $partner_ob_q);
	$partner_ob_f = mysqli_fetch_array($partner_ob_r);
	$partner_old_balance = $partner_ob_f['balance'];
	$partner_new_balance = $partner_old_balance + $fxpartner_share;

	// 1. Insert fxUnivers txn
	// 2. Update fxPartner balance
	// 3. Insert fxPartner txn
	echo $partner_share_q = "INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($fxunivers_share, $buyer_id, $fxunivers_id, '$trans_dt'); UPDATE fxstars SET balance = $partner_new_balance WHERE user_id = $fxpartner_id; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($fxpartner_share, $buyer_id, $fxpartner_id, '$trans_dt');";
	$partner_share_r = mysqli_multi_query($wallet_connection, $partner_share_q);

	// Add the amount to his income in fxpartner db
        $partner_income_q="UPDATE on_user SET income=income+$fxpartner_share WHERE (partner=$fxpartner_id AND user=$buyer_id)";
        $partner_income_r=mysqli_query($fxpartner_connection,$partner_income_q) or die(mysqli_error($fxpartner_connection));



	/*
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

            
        }
        if($fxunivers_interest>0) {
            $fxu_share_q="UPDATE link SET userId=1 WHERE userId=$stu_id LIMIT $fxunivers_interest";
            //echo $fxu_share_q.'<br>';
            $fxu_share_r=mysqli_query($wallet_connection,$fxu_share_q) or die(mysqli_error($wallet_connection));
            
            // transaction data
            $trans_from=$stu_id;
            $trans_to=1;
            $trans_amnt=$fxunivers_interest;
            $trans_query="INSERT INTO transactions(from_id, to_id, amnt, dt) VALUES($trans_from, $trans_to, $trans_amnt, '$trans_dt')";
            $trans_result=mysqli_query($wallet_connection, $trans_query) or die(mysqli_error($wallet_connection));

        }*/
    }
} else {
    echo 'insuff';
    exit();
}

if($purchase_r) {
    $purchase_course_query = "INSERT INTO stucourse(stu_id, course_id) VALUES($stu_id, $course_id)";
    $purchase_course_result = mysqli_query($connection, $purchase_course_query) or die(mysqli_error($connection));
}

if($purchase_course_result) {  
    echo 'success';
} else {
    echo "error";
}
?>
