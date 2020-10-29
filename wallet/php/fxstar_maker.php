<?php

session_start();
require('wallet_connect.php');

$from=1;
$to=1000000;

echo '<script src="/js/jquery-3.4.1.min.js"></script>';

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($j = 0; $j < $length; $j++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


for($i=$from; $i<=$to; $i++) {
    $hashed=hash(sha256, generateRandomString(64), false);
    
    $buy_coin_query = "INSERT INTO fxcoin(id,hash) VALUES($i,'$hashed')";
    $buy_coin_result = mysqli_query($wallet_connection, $buy_coin_query) or die(mysqli_error($wallet_connection));

    $hashed_coin_id_query = "SELECT id FROM fxcoin WHERE hash='$hashed'";
    $hashed_coin_id_result = mysqli_query($wallet_connection, $hashed_coin_id_query) or die(mysqli_error($wallet_connection));
    $hashed_coin_id_fetch = mysqli_fetch_array($hashed_coin_id_result);
    $hashed_coin_id = $hashed_coin_id_fetch['id'];

    $link_query = "INSERT INTO link(id, fxCoinId, userId) VALUES($i, $hashed_coin_id, 0)";
    $link_result = mysqli_query($wallet_connection, $link_query) or die(mysqli_error($wallet_connection));

    
    
    echo '<script>console.log("[OK] '.$i.'_________'.$hashed.'");</script>';
}

echo 'Finished adding '.$amnt.' fxCoins.';
?>