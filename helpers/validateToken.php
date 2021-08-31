<?php
function validateToken()
{
    global $SECRET;
    $headers = apache_request_headers();
    if (!isset($headers['authorization']) || $headers['authorization'] == "") {
        echo json_encode(["error" => "You are unauthorized"]);
        die();
    }
    $token = $headers['authorization'];
    $payload = (substr($token, 0, -64));
    $signature = substr($token,  -64);
    if ($signature != (hash_hmac("sha256", $payload, $SECRET))) {
        echo json_encode(["error" => "You tampered with the token"]);
        die();
    }
    $token = json_decode(decrypt($token), true);
    if (time() > $token["expires"]) {
        echo json_encode(["error" => "Token expired"]);
        die();
    }
    if ($token["ip"] != $_SERVER['REMOTE_ADDR']) {
        echo json_encode(["error" => "You filthy stealer"]);
        die();
    }
    return $token["content"][0];
}
