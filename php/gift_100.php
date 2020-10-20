<?php
echo '[OK] start';
require('../wallet/php/wallet_connect.php');

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($j = 0; $j < $length; $j++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

for($i=0;$i<100;$i++) {
    $hashed=hash(sha256, generateRandomString(64), false);

    
    
    $gift_fxcoin_query="INSERT INTO fxcoin(hash) VALUES('$hashed')";
    $gift_fxcoin_result=mysqli_query($wallet_connection,$gift_fxcoin_query) or die(mysqli_error($wallet_connection));

    if($gift_fxcoin_result) echo "[OK] insert into fxcoin<br>";
    else echo '[ERR] insert into fxcoin<br>';

    $gift_coin_id_query="SELECT id FROM fxcoin WHERE hash='$hashed'";
    $gift_coin_id_result=mysqli_query($wallet_connection,$gift_coin_id_query) or die(mysqli_error($wallet_connection));
    $gift_coin_id_fetch=mysqli_fetch_array($gift_coin_id_result);
    $gift_coin_id=$gift_coin_id_fetch['id'];

    if($gift_coin_id_result) echo "[OK] select from fxcoin<br>";
    else echo '[ERR] select from fxcoin<br>';

    if($gift_fxcoin_result) {
        $gift_user_id=114;

        $gift_link_query="INSERT INTO link(fxCoinId,userId) VALUES($gift_coin_id, $gift_user_id)";
        $gift_link_result=mysqli_query($wallet_connection, $gift_link_query) or die(mysqli_error($wallet_connection));

        if($gift_link_result) echo "[OK] insert into link<br>";
        else echo "[ERR] insert into link<br>";
    }
}

?>