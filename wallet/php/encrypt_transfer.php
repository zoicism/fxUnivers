<?php

$plain_text = "personA: $personA_id | personB: $personB_id | amnt: $cost | dat(ny): $current_date_time_ny";
//$plain_text = "foobar";
//echo $plain_text;
$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
$iv = openssl_random_pseudo_bytes($ivlen);
$key = "92332116372a47b84cd50cb84caac1231e5bce18779b68605c1a73621c1271eb16224924c49a13f0bd1969dbde096e70348019a25369bb0a920c71b19708c10641392439b2befd2c65a1832d557ccec4ea66ecad2417967b5e5326ab08b945a910f05d79ba74b03ea2f320f765a9020abde8d35a3f29e99f3f3953067c58";
$ciphertext_raw = openssl_encrypt($plain_text, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
$ciphertext = base64_encode($iv.$hmac.$ciphertext_raw);

?>