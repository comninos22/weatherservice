<?php

function handleLogin()
{
    global $SECRET;
    $body = Request::GetBody();
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        echo json_encode(["error" => "invalid method"]);
        die();
    }
    if (!isset($body["email"]) || !isset($body["password"])) {
        echo json_encode(["error" => "invalid request"]);
        die();
    }
    print_r($body);
    $email = $body["email"];
    $password = hash_hmac('sha256', $body["password"], $SECRET);
    $db = DB::GetInstance();
    try {
        $user = $db->LoginUser($email, $password);
        $token = buildVerificationToken(3600, $user);
        $res = ["user" => $user, "token" => $token];
        echo json_encode($res);
    } catch (Exception $e) {
        echo json_encode(["error" => "Wrong credentials"]);
        die();
    }
}
function buildVerificationToken($expires, $content)
{
    $tokenData = [
        'expires' => time() + $expires,
        'content' => $content,
        'ip' => $_SERVER['REMOTE_ADDR'],
    ];
    $serialized = json_encode($tokenData);
    return encrypt($serialized);
}
