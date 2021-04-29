<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/register/connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/wallet/php/wallet_connect.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxpartner.php');

$fxunivers_id = 1;
$dt = date('Y-m-d H:i:s');

if(isset($_POST['studentId']) && isset($_POST['instructorId'])) {
    $student_id = $_POST['studentId'];
    $instructor_id = $_POST['instructorId'];

    $oneonone_q = "SELECT * FROM one_on_one WHERE instructor_id = $instructor_id";
    $oneonone_r = mysqli_query($fxinstructor_connection, $oneonone_q);
    $oneonone_c = mysqli_num_rows($oneonone_r);
} else {
    echo 0;
    exit();
}

if($oneonone_c > 0) {
    $oneonone = mysqli_fetch_array($oneonone_r);
    $cost = $oneonone['fxstars'];

    $student_old_balance_q = "SELECT * FROM fxstars WHERE user_id = $student_id";
    $student_old_balance_r = mysqli_query($wallet_connection, $student_old_balance_q);
    $student_old_balance = mysqli_fetch_array($student_old_balance_r);
    if($student_old_balance['balance'] < $cost) {
	echo 'insuff';
	exit();
    }
    
    // Instructor's share: (0.9)cost
    $instructor_share = (0.9)*$cost;
    $instructor_new_balance_q = "UPDATE fxstars SET balance = balance + $instructor_share WHERE user_id = $instructor_id; INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($instructor_share, $student_id, $instructor_id, '$dt');";
    $instructor_new_balance_r = mysqli_multi_query($wallet_connection, $instructor_new_balance_q);
    while($wallet_connection->next_result()) {;}
    
    // Student's new balance: balance - cost
    $student_new_balance_q = "UPDATE fxstars SET balance = balance - $cost WHERE user_id = $student_id";
    $student_new_balance_r = mysqli_query($wallet_connection, $student_new_balance_q);// or die(mysqli_error($wallet_connection));

    if($student_new_balance_r) {
	$set_stu_oneonone_q = "INSERT INTO stu_oneonone(instructor_id, student_id) VALUES($instructor_id, $student_id)";
	$set_stu_oneonone_r = mysqli_query($fxinstructor_connection, $set_stu_oneonone_q);
    } else {
	echo 0;
	exit();
    }


    // Check for partner on fxInstructor
    $check_partner_q="SELECT * FROM on_user WHERE user=$instructor_id";
    $check_partner_r=mysqli_query($fxpartner_connection,$check_partner_q) or die(mysqli_error($fxpartner_connection));
    $check_partner=mysqli_fetch_array($check_partner_r);
    $check_partner_count=mysqli_num_rows($check_partner_r);
    $time_remains=0;
    
    if($check_partner_count!=0) {
	$partner_id = $check_partner['partner'];
        $today=new DateTime("today");
        
        $add_date=date($check_partner['dt']);
        $exp_date_s=strtotime('+90 day',strtotime($add_date));
        $exp_date=date('Y-m-j',$exp_date_s);
        
        $exp=new DateTime($exp_date);
        
        if($exp>$today) $time_remains=1;
    }

    // No fxPartner
    if($check_partner_count == 0 || $time_remains == 0) {
	// (.1)cost goes to fxUnivers
	$fxunivers_share = $cost - $instructor_share;
	$fxunivers_share_q = "INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($fxunivers_share, $instructor_id, $fxunivers_id, '$dt')";
	$fxunivers_share_r = mysqli_query($wallet_connection, $fxunivers_share_q) or die(mysqli_error($wallet_connection));
    } else {
	echo $interest = $cost - $instructor_share;
	$fxunivers_share = $interest * 0.5;
	$fxunivers_share_q = "INSERT INTO fxstar_txn(amnt, from_id, to_id, dt) VALUES($fxunivers_share, $instructor_id, $fxunivers_id, '$dt')";
	$fxunivers_share_r = mysqli_query($wallet_connection, $fxunivers_share_q);

	$partner_share = $interest - $fxunivers_share;
	$partner_share_q = "UPDATE fxstars SET balance = balance + $partner_share WHERE user_id = $partner_id; INSERT INTO fxstar_txn(amn, from_id, to_id, dt) VALUES($partner_share, $instructor_id, $partner_id, '$dt')";
	$partner_share_r = mysqli_multi_query($wallet_connection, $partner_share_q);
	while($wallet_connection->next_result()) {;}
	
	$partner_income_q = "UPDATE on_user SET income = income + $fxpartner_share WHERE (partner = $partner_id AND user=$instructor_id)";
	$partner_income_r = mysqli_query($fxpartner_connection, $partner_income_q);
    }

    echo 1;
} else {
    echo 404;
    exit();
}
?>
