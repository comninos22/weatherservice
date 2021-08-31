<?php
function encrypt($token)
{
    global $SECRET;
    global $IV;
    $output = base64_encode(openssl_encrypt($token, "AES-256-CBC", $SECRET, 0,  $IV));
    $output = $output . hash_hmac('sha256', $output, $SECRET);
    return $output;
}

function decrypt($token)
{
    global $SECRET;
    global $IV;
    $token = substr($token, 0, -64);
    $output = false;
    $output = openssl_decrypt(base64_decode($token), "AES-256-CBC", $SECRET, 0, $IV);
    return $output;
}
