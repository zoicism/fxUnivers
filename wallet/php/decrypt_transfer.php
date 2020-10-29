<?php

$ciphertext = "f5GpyuQ429YzUeJcGMxBgpJWhw6kMJAYhI1MhvsQRYhfuXfNIK3MwSBx49BUcqfApeUTK9ZzHupge5O3k2RETsJh5a740+3n5+F/z3Yxah3H7w9eMPXrrutqMb6ms3FCQbkdUj+V1Ymh616h2YNJvTEHsxaUJN9N362JZgBds7Q=";
$key = "92332116372a47b84cd50cb84caac1231e5bce18779b68605c1a73621c1271eb16224924c49a13f0bd1969dbde096e70348019a25369bb0a920c71b19708c10641392439b2befd2c65a1832d557ccec4ea66ecad2417967b5e5326ab08b945a910f05d79ba74b03ea2f320f765a9020abde8d35a3f29e99f3f3953067c58";
$c = base64_decode($ciphertext);
$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
$iv = substr($c, 0, $ivlen);
$hmac = substr($c, $ivlen, $sha2len=32);
$ciphertext_raw = substr($c, $ivlen+$sha2len);
$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
$calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
if(hash_equals($hmac, $calcmac)) {
  echo $original_plaintext."\n";
}

?>