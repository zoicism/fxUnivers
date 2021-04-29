<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/conn/fxinstructor.php');
if(isset($_POST['oooid'])) {
    $oooid = $_POST['oooid'];

    $check_ooo_q = "SELECT * FROM stu_oneonone WHERE id = $oooid";
    $check_ooo_r = mysqli_query($fxinstructor_connection, $check_ooo_q);
    $check_ooo = mysqli_fetch_array($check_ooo_r);

    $ooo = array();
    $ooo[0] = $check_ooo['alive'];
    $ooo[1] = $check_ooo['active'];

    echo json_encode($ooo);
}
?>
