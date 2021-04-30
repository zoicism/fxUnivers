<?php
session_start();
if(isset($_SESSION['username'])) {
    $username=$_SESSION['username'];
} else {
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/get_login_cookies.php');
}
require_once('../../register/connect.php');
require('wallet_connect.php');

if(isset($_POST['item'])) {
    if($_POST['item']=='course') {
	$bargain_id = $_POST['bargainId'];
        $course_id=$_POST['courseId'];
        $stu_id=$_POST['stuId'];
        $get_user_id=$stu_id;
        $course_q="SELECT * FROM teacher WHERE id=$course_id";
        $course_r=mysqli_query($connection,$course_q) or die(mysqli_error($connection));

        $course_fetch=mysqli_fetch_array($course_r);
        //$cost=$course_fetch['cost'];
	
        $instructor_id=$course_fetch['user_id'];

	$buyer_id = $get_user_id;
	$seller_id = $instructor_id;
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');

	$bargain_q = "SELECT * FROM bargains WHERE id = $bargain_id";
	$bargain_r = mysqli_query($fxinstructor_connection, $bargain_q);
	$bargain_count = mysqli_num_rows($bargain_r);
	if($bargain_count > 0) {
	    $bargain = mysqli_fetch_array($bargain_r);
	    $cost = $bargain['fxstars'];
	} else {
	    echo 0;
	    exit();
	}
	
    }
} else {
    echo 0;
    exit();
}

$get_fxcoin_count = $cost;

$fxunivers_id = 1;
$trans_dt=date('Y-m-d H:i:s');
$interest=0.1*$cost;

if($get_fxcoin_count>=$cost) {
    
    // Check `subcourses` for `sub_of`
    $get_subcourses_q = "SELECT * FROM subcourses WHERE course_id = $course_id";
    $get_subcourses = mysqli_query($fxinstructor_connection, $get_subcourses_q);
    $subcourses_count = mysqli_num_rows($get_subcourses);

    // Buyer's old and new balance
    $buyer_old_balance = $get_fxcoin_count;
    $buyer_new_balance = $get_fxcoin_count - $cost; // balance - n

    // Seller's old balance
    $seller_ob_q = "SELECT * FROM fxstars WHERE user_id = $seller_id";
    $seller_ob_r = mysqli_query($wallet_connection, $seller_ob_q);
    $seller_ob_f = mysqli_fetch_array($seller_ob_r);
    $seller_old_balance = $seller_ob_f['balance'];

    // If there are NO fxReInstructors
    if($subcourses_count == 0) {
	$seller_share = $cost - $interest; // (0.9)n
	$seller_new_balance = $seller_old_balance + $seller_share;

	
	// 1. Update buyer's balance.
	// 2. Update seller's balance.
	// 3. Add a transaction(buyer->seller). 
	$purchase_q = "UPDATE fxstars SET balance = $seller_new_balance WHERE user_id = $seller_id; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($seller_share, $buyer_id, $seller_id, '$trans_dt');";
	$purchase_r = mysqli_multi_query($wallet_connection, $purchase_q);
	while($wallet_connection->next_result()) {;}


	
    } else { // If there are fxReInstructor(s)
	
	$super_shares_sum = $cost * 0.1; // (0.1)n
	$seller_share = $cost - $super_shares_sum - $interest; // (0.8)n
	$grandparent_share = $super_shares_sum * 0.5; // (0.5)(0.1)n
	$parents_share = $super_shares_sum - $grandparent_share; // (0.5)(0.1)n for all

	$seller_new_balance = $seller_old_balance + $seller_share;
	$purchase_q = "UPDATE fxstars SET balance = $seller_new_balance WHERE user_id = $seller_id; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($seller_share, $buyer_id, $seller_id, '$trans_dt');";
	$purchase_r = mysqli_multi_query($wallet_connection, $purchase_q);
	while($wallet_connection->next_result()) {;} // Flushing multi_queries
	
	$super_ids = array();
	while(true) {
	    if($subcourses_count > 0) {
		$get_super_course = mysqli_fetch_array($get_subcourses);
		$get_super_id_q = 'SELECT * FROM teacher WHERE id = '.$get_super_course['sub_of_id'];
		$get_super_id_r = mysqli_query($connection, $get_super_id_q);
		$get_super_id = mysqli_fetch_array($get_super_id_r);
		
		$super_ids[] = $get_super_id['user_id'];
		$next_course_id = $get_super_id['id'];

		$get_subcourses_q = "SELECT * FROM subcourses WHERE course_id = $next_course_id";
		
		$get_subcourses = mysqli_query($fxinstructor_connection, $get_subcourses_q);
		$subcourses_count = mysqli_num_rows($get_subcourses);
	    } else {
		break;
	    }
	    
	}
	
	$parents_count = count($super_ids);
	//echo json_encode($super_ids);
	
	
	// If just 1 parent exists, it's the grandparent and will take all the 10%.
	if($parents_count == 1) {
	    $this_share = $super_shares_sum;
	    $this_txn_q = "UPDATE fxstars SET balance=balance+$this_share  WHERE user_id = $super_ids[0]; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($this_share, $seller_id, $super_ids[0], '$trans_dt');";
	    $purchase_r = mysqli_multi_query($wallet_connection, $this_txn_q);
	    while($wallet_connection->next_result()) {;} // Flushing multi_queries
	} else {
	    $each_share = $parents_share / ($parents_count - 1);
	    $each_share = floor($each_share * 100) / 100;
	    
	    for($counter = 0; $counter < $parents_count; $counter++) {
		if($counter == $parents_count - 1) {
		    $this_share = $grandparent_share;
		    
		    $this_txn_q = "UPDATE fxstars SET balance=balance+$this_share  WHERE user_id = $super_ids[$counter]; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($this_share, $seller_id, $super_ids[$counter], '$trans_dt');";
		    $purchase_r = mysqli_multi_query($wallet_connection, $this_txn_q);
		    while($wallet_connection->next_result()) {;} // Flushing multi_queries
		} else {
		    $this_txn_q = "UPDATE fxstars SET balance=balance+$each_share WHERE user_id = $super_ids[$counter]; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($each_share, $seller_id, $super_ids[$counter], '$trans_dt');";
		    $purchase_r = mysqli_multi_query($wallet_connection, $this_txn_q);
		    while($wallet_connection->next_result()) {;} // Flushing multi_queries
		}
	    }
	}
    }
    
    require('../../php/conn/fxpartner.php');
    $check_partner_q="SELECT * FROM on_user WHERE user=$seller_id";
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

	// Interest goes to fxUnivers
	// 1. Add interest as transaction to fxUnivers
	$fxunivers_share_q = "INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($interest, $seller_id, $fxunivers_id, '$trans_dt')";
	$fxunivers_share_r = mysqli_query($wallet_connection, $fxunivers_share_q) or die(mysqli_error($wallet_connection));
	
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
	$partner_share_q = "INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($fxunivers_share, $seller_id, $fxunivers_id, '$trans_dt'); UPDATE fxstars SET balance = $partner_new_balance WHERE user_id = $fxpartner_id; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($fxpartner_share, $seller_id, $fxpartner_id, '$trans_dt');";
	$partner_share_r = mysqli_multi_query($wallet_connection, $partner_share_q);

	// Add the amount to his income in fxpartner db
        $partner_income_q="UPDATE on_user SET income=income+$fxpartner_share WHERE (partner=$fxpartner_id AND user=$seller_id)";
        $partner_income_r=mysqli_query($fxpartner_connection,$partner_income_q) or die(mysqli_error($fxpartner_connection));

    }
} else {
    echo 'insuff';
    exit();
}

if($purchase_r) {
    $purchase_course_query = "INSERT INTO stucourse(stu_id, course_id) VALUES($stu_id, $course_id)";
    $purchase_course_result = mysqli_query($connection, $purchase_course_query) or die(mysqli_error($connection));

    $rm_bargain_q = "DELETE FROM bargains WHERE id=$bargain_id";
    $rm_bargain_r = mysqli_query($fxinstructor_connection, $rm_bargain_q);

    // Notify student of acceptance
}

if($purchase_course_result && $rm_bargain_r) {  
    echo 1;
} else {
    echo 0;
}
?>
